<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\Box;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Document;
use App\Models\Tenant\DocumentPayment;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Restaurant\Models\Orden;
use Carbon\Carbon;
use App\Models\Tenant\RegisterMovement;

class DocumentCollection extends ResourceCollection
{


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        $configuration = Configuration::first();

        // Precarga todas las relaciones necesarias para evitar consultas N+1
        $this->collection->load([
            'state_type', 
            'document_type', 
            'customer', 
            'soap_type', 
            'boxes',
            'payments',
            'sale_note_related',
            'user',
            'note',
            'reference_guides',
            'dispatch',
            'orden',
            'orden.mesa'
        ]);

        // Inicializar variables fuera del bucle
        $documents_affected_ids = $this->collection
            ->filter(function($doc) {
                return $doc->document_type_id == '07' && $doc->note && $doc->note->affected_document_id;
            })
            ->pluck('note.affected_document_id')
            ->merge(
                $this->collection
                ->filter(function($doc) {
                    return $doc->relationLoaded('document_affected_note') && $doc->document_affected_note;
                })
                ->pluck('document_affected_note.affected_document_id')
            )
            ->filter()
            ->unique()
            ->toArray();
        
        // Cargar todos los documentos afectados en una sola consulta
        $affected_documents = empty($documents_affected_ids) ? collect() : 
            Document::whereIn('id', $documents_affected_ids)->get()->keyBy('id');

        // Obtener todos los RegisterMovement de una vez
        $register_movements = RegisterMovement::where('model', Document::class)
            ->whereIn('model_id', $this->collection->pluck('id')->toArray())
            ->with('user')
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('model_id');

        $currentDay = Carbon::now();

        return $this->collection->transform(function ($row, $key) use ($configuration, $affected_documents, $register_movements, $currentDay) {
            // Valores predeterminados para botones y estados
            $has_xml = true;
            $has_pdf = true;
            $has_cdr = false;
            $btn_note = false;
            $btn_guide = true;
            $btn_resend = false;
            $btn_voided = false;
            $btn_consult_cdr = false;
            $btn_delete_doc_type_03 = false;
            $btn_constancy_detraction = false;

            $affected_document = null;
            $btn_resend = ($row->state_type_id === '01');

            // Lógica para botones basada en grupo y tipo de documento
            if ($row->group_id === '01') {
                if ($row->state_type_id === '01' || $row->state_type_id === '03') {
                    $btn_delete_doc_type_03 = true;
                }
                if ($row->state_type_id === '05') {
                    $has_cdr = true;
                    $btn_note = true;
                    $btn_voided = true;
                    $btn_consult_cdr = true;
                }
                if (in_array($row->document_type_id, ['07', '08'])) {
                    $btn_note = false;
                }
            }

            if ($row->group_id === '02') {
                if ($row->state_type_id === '05') {
                    $btn_note = true;
                    $btn_voided = true;
                }
                if (in_array($row->document_type_id, ['07', '08'])) {
                    $btn_note = false;
                }
                if ($row->state_type_id == '01' || $row->state_type_id == '03') {
                    $btn_delete_doc_type_03 = true;
                }
            }

            if (in_array($row->document_type_id, ['01', '03'])) {
                $btn_constancy_detraction = ($row->detraction) ? true : false;
            }

            $btn_guide = $btn_note;
            if ($btn_guide === false && ($row->state_type_id === '01')) {
                $btn_guide = true;
            }

            $btn_recreate_document = $configuration->recreat_document;
            $btn_change_to_registered_status = false;
            if ($row->state_type_id === '01') {
                $btn_change_to_registered_status = config('tenant.change_to_registered_status');
            }

            // Calcular balance una sola vez
            $total_payments = $row->payments->sum('payment');
            $balance = number_format(($row->total - $row->total_rounded) - $total_payments, 2, ".", "");

            // Optimizado: relaciones ya están precargadas
            $boxes = $row->boxes;
            $is_credit = $row->payment_condition_id == "02";
            $paid = false;
            $remain = 0;

            if ($is_credit) {
                $sum = $boxes->sum('amount');
                if ($sum < $row->total) {
                    $remain = $row->total - $sum;
                    $paid = false;
                } else {
                    $paid = true;
                }
            } else {
                $paid = $boxes->sum('amount') >= $row->total;
            }

            if ($configuration->health_network && !$paid && $row->payment_condition_id == "01") {
                $paid = true;
            }

            // Transformar sale_note_related (ya precargado)
            $sale_note_related = $row->sale_note_related->transform(function ($sale_note) {
                return [
                    "number" => $sale_note->getNumberFullAttribute(),
                ];
            });

            // Optimizado acceso a orden
            $orden = $row->orden;
            $ordens_ref = $orden ? $orden->ref : null;

            if ($sale_note_related->count() > 0 && !$paid) {
                $paid = true;
            }

            // Obtener número de mesa de forma optimizada
            $table_number = null;
            if ($orden && $orden->mesa) {
                $table_number = $orden->mesa->number;
            }        // Obtener último registro de movimiento
        $last_register = $this->getLastRegisterMovementOptimized($row->id, $register_movements, $currentDay);

            // Obtener document_affected_notes de forma optimizada
            $document_affected_notes = $this->getDocumentAffectedNotesOptimized($row, $affected_documents);

            return [
                'state_sunat' => $row->state_sunat,
                'internal_voided' => (bool) $row->internal_voided,
                'last_register' => $last_register,
                'ordens_ref' => $ordens_ref,
                'table_number' => $table_number,
                'sale_note_related' => $sale_note_related,
                'remain' => $remain,
                'paid' => $paid,
                'is_credit' => $row->payment_condition_id == "02",
                'dispatch_id' => $row->dispatch_id,
                'boxes' => $boxes,
                'id' => $row->id,
                'group_id' => $row->group_id,
                'soap_type_id' => $row->soap_type_id,
                'soap_type_description' => $row->soap_type->description,
                'date_of_issue' => $row->date_of_issue,
                'time_of_issue' => $row->time_of_issue,
                'from_consignment' => (bool) $row->from_consignment,
                'number' => $row->number_full,
                'payment' => $row->payments,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'customer_telephone' => $row->customer->telephone,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => $row->total_exportation,
                'total_free' => $row->total_free,
                'total_unaffected' => $row->total_unaffected,
                'total_exonerated' => $row->total_exonerated,
                'total_taxed' => $row->total_taxed,
                'total_taxes' => $row->total_taxes,
                'total_igv' => $row->total_igv,
                'total' => $row->total,
                'total_rounded' => $row->total_rounded,
                'total_payment' => $row->total_payment,
                'state_type_id' => $row->state_type_id,
                'state_type_description' => $row->state_type->description,
                'document_type_description' => $row->document_type->description,
                'document_type_id' => $row->document_type->id,
                'has_xml' => $has_xml,
                'has_pdf' => $has_pdf,
                'has_cdr' => $has_cdr,
                'download_xml' => $row->download_external_xml,
                'download_pdf' => $row->download_external_pdf,
                'download_cdr' => $row->download_external_cdr,
                'btn_voided' => $btn_voided,
                'btn_note' => $btn_note,
                'btn_guide' => $btn_guide,
                'dispatches' => $this->getDispatches($row),
                'btn_resend' => $btn_resend,
                'btn_consult_cdr' => $btn_consult_cdr,
                'btn_constancy_detraction' => $btn_constancy_detraction,
                'btn_recreate_document' => (bool) $btn_recreate_document,
                'btn_change_to_registered_status' => $btn_change_to_registered_status,
                'btn_delete_doc_type_03' => $btn_delete_doc_type_03,
                'send_server' => (bool) $row->send_server,
                'affected_document' => $affected_document,
                'shipping_status' => json_decode($row->shipping_status),
                'sunat_shipping_status' => json_decode($row->sunat_shipping_status),
                'query_status' => json_decode($row->query_status),
                'user_name' => ($row->user) ? $row->user->name : '',
                'user_email' => ($row->user) ? $row->user->email : '',
                'external_id' => $row->external_id,
                'observation' => $row->observation,
                'balance' => $balance,
                'document_affected_notes' => $document_affected_notes,
            ];
        });
    }


    /**
     * Obtiene los despachos relacionados optimizados
     *
     * @param \App\Models\Tenant\Document $row
     * @return array
     */
    private function getDispatches($row)
    {
        $dispatches = [];

        if (in_array($row->document_type_id, ['01', '03'])) {
            // Las guías de referencia ya están precargadas
            $dispatches = $row->reference_guides->transform(function ($row) {
                return [
                    'description' => $row->number_full,
                ];
            })->toArray();

            // El despacho ya está precargado
            if ($row->dispatch) {
                $dispatches[] = [
                    'description' => $row->dispatch->number_full,
                ];
            }
        }

        return $dispatches;
    }    // Métodos antiguos reemplazados por versiones optimizadas

    /**
     * Obtiene el último registro de movimiento de forma optimizada
     * 
     * @param int $documentId
     * @param \Illuminate\Support\Collection $registerMovements
     * @param \Carbon\Carbon $currentDay
     * @return array
     */
    private function getLastRegisterMovementOptimized($documentId, $registerMovements, $currentDay)
    {
        $data = [
            'user' => '',
            'date_time' => '',
            'description' => '',
            'created_at' => ''
        ];

        // Verificar si hay registros de movimiento para este documento
        if ($registerMovements->has($documentId) && $registerMovements[$documentId]->first()) {
            $lastMovement = $registerMovements[$documentId]->first();
            
            // Calcular la diferencia de tiempo
            $date_time = $lastMovement->created_at;
            $difference = $date_time->diff($currentDay);

            $data = [
                'user' => $lastMovement->user->name,
                'description' => $lastMovement->description,
                'date_time' => [
                    'is24Hours' => $difference->days > 0,
                    'days' => $difference->days,
                    'hours' => $difference->h,
                    'minutes' => $difference->i,
                    'seconds' => $difference->s
                ],
                'created_at' => $lastMovement->created_at->format('Y-m-d H:i:s')
            ];
        }

        return $data;
    }

    /**
     * Obtiene las notas de documentos afectados de forma optimizada
     * 
     * @param \App\Models\Tenant\Document $row
     * @param \Illuminate\Support\Collection $affectedDocuments
     * @return array
     */
    private function getDocumentAffectedNotesOptimized($row, $affectedDocuments)
    {
        // Si es nota de crédito, buscar el documento afectado de forma optimizada
        if ($row->document_type_id == '07') {
            if ($row->note && $row->note->affected_document_id) {
                $affectedDocId = $row->note->affected_document_id;
                $affectedDoc = $affectedDocuments->get($affectedDocId);

                return [[
                    'document_id' => $row->id,
                    'affected_document_id' => $affectedDocId,
                    'series' => $row->series,
                    'number' => $row->number,
                    'affected_series' => optional($affectedDoc)->series,
                    'affected_number' => optional($affectedDoc)->number,
                ]];
            }
            return [];
        }
        
        // Si no, usar la relación normal pero de forma optimizada
        if ($row->relationLoaded('document_affected_note') && $row->document_affected_note) {
            $affectedDocId = $row->document_affected_note->affected_document_id;
            $affectedDoc = $affectedDocuments->get($affectedDocId);

            return [[
                'document_id' => $row->document_affected_note->document_id,
                'affected_document_id' => $affectedDocId,
                'series' => optional($row->document_affected_note->document)->series,
                'number' => optional($row->document_affected_note->document)->number,
                'affected_series' => optional($affectedDoc)->series,
                'affected_number' => optional($affectedDoc)->number,
            ]];
        }
        
        return [];
    }
}
