<?php

namespace App\CoreFacturalo\Requests\Inputs;

use App\Models\Tenant\Company;
use App\Models\Tenant\CompanySameRuc;
use App\Models\Tenant\Document;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Exception;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Document\Models\SeriesConfiguration;

class Functions
{
    public static function newNumber($soap_type_id, $document_type_id, $series, $number, $model)
    {
        return DB::transaction(function () use ($soap_type_id, $document_type_id, $series, $number, $model) {
            if ($number === '#') {
                $document = $model::select('number')
                    ->where('soap_type_id', $soap_type_id)
                    ->where('document_type_id', $document_type_id)
                    ->where('series', $series)
                    ->orderBy('number', 'desc')
                    ->lockForUpdate() // Bloquear la fila para evitar concurrencia
                    ->first();

                if ($document) {
                    return (int)$document->number + 1;
                } else {
                    $series_configuration = SeriesConfiguration::where([['document_type_id', $document_type_id], ['series', $series]])
                        ->lockForUpdate() // Bloquear la fila para evitar concurrencia
                        ->first();
                    return ($series_configuration) ? (int) $series_configuration->number : 1;
                }
            }
            return $number;
        });

        // if ($number === '#') {

        //     $document = $model::select('number')
        //                             ->where('soap_type_id', $soap_type_id)
        //                             ->where('document_type_id', $document_type_id)
        //                             ->where('series', $series)
        //                             ->orderBy('number', 'desc')
        //                             ->first();

        //     if($document){

        //         return (int)$document->number+1;

        //     }else{

        //         $series_configuration = SeriesConfiguration::where([['document_type_id',$document_type_id],['series',$series]])->first();
        //         return ($series_configuration) ? (int) $series_configuration->number:1;

        //     }

        // }

        // return $number;


    }

    public static function filename($company, $document_type_id, $series, $number)
    {
        return join('-', [$company->number, $document_type_id, $series, $number]);
    }

    public static function validateUniqueDocument($soap_type_id, $document_type_id, $series, $number, $model)
    {
        $document = $model::where('soap_type_id', $soap_type_id)
            ->where('document_type_id', $document_type_id)
            ->where('series', $series)
            ->where('number', $number)
            ->first();
        if ($document) {
            throw new Exception("El documento: {$document_type_id} {$series}-{$number} ya se encuentra registrado.");
        }
    }

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);
        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if (count($same_rucs) > 0) {
            $numeration = 0;
            //$table = $path == 'Voided' ?  'voided' : 'summaries';

            //foreach ($same_rucs as $same_ruc) {
            //    $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
            //    $result = DB::select($query, [$soap_type_id, $date_of_issue]);
            //    $numeration += $result[0]->total;
            // }
            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }
            $numeration += 1;
            $suffix = auth()->user()->company->id;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->get();
            $numeration = count($documents) + 1;
        }
        switch (array_pop($path)) {
            case 'Voided':
                $prefix = 'RA';
                break;
            default:
                $prefix = 'RC';
                break;
        }

        return join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration]);
    } */

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);

        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if (count($same_rucs) > 0) {
            $numeration = 0;
            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }
            $numeration += 1;

            // ✅ Diferenciar por aplicativo
            $suffix = auth()->user()->company->id;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->get();
            $numeration = count($documents) + 1;
            $suffix = null;
        }

        $prefix = $last === 'Voided' ? 'RA' : 'RC';

        // ✅ Si hay sufijo, lo añadimos
        return $suffix
            ? join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration, $suffix])
            : join('-', [$prefix, Carbon::parse($date_of_issue)->format('Ymd'), $numeration]);
    } */

    /* public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        $last = array_pop($path);

        $table = $last === 'Voided' ? 'voided' : 'summaries';

        if ($same_rucs->count() > 0) {
            $numeration = 0;

            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total 
                      FROM {$same_ruc->uuid}.{$table} 
                      WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }

            $numeration += 1;
        } else {
            $documents = $model::where('soap_type_id', $soap_type_id)
                ->where('date_of_issue', $date_of_issue)
                ->count();

            $numeration = $documents + 1;
        }

        $prefix = $last === 'Voided' ? 'RA' : 'RC';

        return join('-', [
            $prefix,
            Carbon::parse($date_of_issue)->format('Ymd'),
            $numeration
        ]);
    } */

    public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        // Obtener RUC de la empresa actual
        $company = Company::first();
        $ruc = $company->number;

        // Prefijo según tipo de documento (RA o RC)
        $prefix = $soap_type_id === 'RA' ? 'RA' : 'RC';

        // Nombre o UUID del tenant actual (solo informativo)
        $origin_app = app(\Hyn\Tenancy\Environment::class)->tenant()->uuid;

        // Conexión a la base central (fuera del tenant)
        $connection = DB::connection('mysql');

        // Usamos transacción + lockForUpdate() para evitar duplicados concurrentes
        $next_correlative = $connection->transaction(function () use ($connection, $ruc, $prefix, $origin_app) {

            // Buscar correlativo existente por RUC y tipo (no por origin_app)
            $record = $connection->table('summary_correlatives')
                ->where('ruc', $ruc)
                ->where('type', $prefix)
                ->lockForUpdate()
                ->first();

            if ($record) {
                // Incrementar correlativo
                $next = (int)$record->correlative + 1;

                $connection->table('summary_correlatives')
                    ->where('id', $record->id)
                    ->update([
                        'correlative' => $next,
                        'updated_at' => now(),
                    ]);

                return $next;
            } else {
                // Crear nuevo registro con correlativo 1
                $connection->table('summary_correlatives')->insert([
                    'ruc' => $ruc,
                    'type' => $prefix,
                    'correlative' => 1,
                    'origin_app' => $origin_app, // informativo, no afecta búsqueda
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return 1;
            }
        });

        // El correlativo se mantiene sin ceros a la izquierda (1, 2, 3, ...)
        $numeration = (string) $next_correlative;

        // Retornar identificador final: RC-20251107-2
        return join('-', [
            $prefix,
            \Carbon\Carbon::parse($date_of_issue)->format('Ymd'),
            $numeration
        ]);
    }

    public static function valueKeyInArray($inputs, $key, $default = null)
    {
        if (array_key_exists($key, $inputs)) {
            if (!is_null($inputs[$key])) {
                return $inputs[$key];
            }
        }
        return $default;
    }
}
