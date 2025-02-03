<?php

namespace App\CoreFacturalo;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemUnitType;
use App\Models\Tenant\PromotionDocumentCustomer;
use App\Models\Tenant\PromotionDocumentCustomerDetail;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\College\Models\CollegeClassroom;
use Modules\College\Models\CollegePayment;
use Modules\College\Models\CollegeRegister;
use Modules\College\Models\CollegeStudent;

class Template
{
    public function pdf($base_template, $template, $company, $document, $format_pdf, $boxes = [])
    {
        if ($template === 'credit' || $template === 'debit') {
            $template = 'note';
        }

        $path_template =  $this->validate_template($base_template, $template, $format_pdf);
        return self::render($path_template, $company, $document, $boxes);
    }

    public function xml($template, $company, $document)
    {
        return self::render('xml.' . $template, $company, $document);
    }

    private function render($view, $company, $document, $boxes = [], $college = false)
    {

        view()->addLocation(__DIR__ . '/Templates');
        //check if $document is a object
        $configuration = Configuration::first();
        if (is_object($document)) {
            $text = null;
            $student_name = null;
            $class = null;
            $config = Configuration::first();
            $students = [];
            $document_type = $document->document_type_id == "80" ? "sale_note_id" : "document_id";
            $college_payments = CollegePayment::where($document_type, $document->id)->get();
            if (count($college_payments) > 0) {
                foreach ($college_payments as $key => $college_payment) {
                    $college_register = CollegeRegister::find($college_payment->register_id);
                    $member = $college_register->member;
                    $student = CollegeStudent::where('student_id', $member->children_id)->where('active', 1)->first();
                    if ($student) {
                        $classroom = CollegeClassroom::find($student->classroom_id);
                        if ($classroom) {
                            $class = mb_strtoupper($classroom->description);
                        }
                    }
                    $parent = $member->parent;
                    $student_name = $member->person->name;
                    $students[] = [
                        'name' => $student_name,
                        'parent' => $parent->person->name,
                        'class' => $class
                    ];
                }
            }

            $show_unit_types = $config->show_unit_types_ticket;
            $stablishment = Establishment::find($document->establishment_id);
            try {
                if ($show_unit_types && is_iterable($document->items)) {
                    foreach ($document->items as $row) {

                        if (isset($row->item->has_unit_type) || isset($row->item->from_unit_type_id_desc)) {
                            if (isset($row->item->has_unit_type)) {

                                $unit_type = ItemUnitType::where('description', $row->item->has_unit_type)->where('item_id', $row->item_id)->first();
                            } else {
                                $unit_type = ItemUnitType::where('description', $row->item->from_unit_type_id_desc)->where('item_id', $row->item_id)->first();
                            }
                            if ($unit_type) {
                            
                                $unds =  floatval($unit_type->quantity_unit);
                                $row->unit_desc = " X " . number_format($unds, 2);
                                $row->unit_qty = number_format($row->quantity / $unds, 2);
                                // $row->price_unit = number_format($unit_type->total, 2);
                                //aqui esta jalando el precio por defecto y no el total
                                $price_default = $unit_type->price_default;
                                $price_var = "price_".$price_default;
                                $row->price_unit = number_format($unit_type->{$price_var}, 2);
                                try{
                                    if($row->price_unit == 0 || $row->price_unit == null){
                                        $row->price_unit = number_format($row->unit_price, 2);
                                        // $price_default = $unit_type->price_default;
                                        // $price_var = "price_".$price_default;
                                        // $row->price_unit = number_format($unit_type->{$price_var}, 2);
                                    }
                                } catch (\Exception $e) {
                                    Log::error($e->getMessage());
                                }
                                if ($config->consolidated_quotations) {
                                    $row->unit_desc = "({$row->unit_desc})";
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
            $stablishment = Establishment::find($document->establishment_id);
            $is_principal = false;
            if ($stablishment) {
                $is_principal = $stablishment->id == 1;
            }
            $footer_text = $config->footer_text;
            $detail_points = [];
            $detail_message = [];
            if ($document->document_type_id == '80' || $document->document_type_id == '03' || $document->document_type_id == '01') {
                if (($configuration->promotions_by_points || $configuration->is_promotion_document )&& PromotionDocumentCustomerDetail::where($document_type, $document->id)->exists()) {

                    if ($configuration->promotions_by_points) {

                        $baseQuery = PromotionDocumentCustomerDetail::with(['promotion_customer.promotion_document'])
                            ->select('total', 'promotion_customer_id');

                        $currentDocumentPoints = (clone $baseQuery)
                            ->where($document_type, $document->id)
                            ->get()
                            ->sum(function ($row) {
                                $promotion_document = $row->promotion_customer->promotion_document;
                                return ($row->total / $promotion_document->total) * $promotion_document->points_value;
                            });

                        $detail_points['total_document_points'] = $currentDocumentPoints;

                        $type_promotion = PromotionDocumentCustomerDetail::where($document_type, $document->id)
                            ->first();
                        $type_promotion_id = $type_promotion->id;
                        $count_promotion_document_customer_detail = $type_promotion->promotion_customer->details()->first()->id;
                        $accumulatedPoints = $type_promotion->promotion_customer->points;

                        $points_before_detail = $type_promotion->getPointBeforeDetail($type_promotion->id);
                        $detail_points['acc_points'] = $points_before_detail + $currentDocumentPoints;
                        if($count_promotion_document_customer_detail == $type_promotion_id){
                            $detail_points['acc_points'] = 0;
                        }
                        $detail_points['is_points'] = true;
                    } else {
                        $baseQuery = PromotionDocumentCustomerDetail::with(['promotion_customer.promotion_document'])
                            ->select('total', 'promotion_customer_id');

                        $currentPromotionDetail = (clone $baseQuery)
                            ->from('promotion_document_customer_detail')
                            ->join('promotion_document_customers', 'promotion_document_customer_detail.promotion_customer_id', '=', 'promotion_document_customers.id')
                            ->where($document_type, $document->id)
                            ->where('promotion_document_customers.active', 1)
                            ->first();

                        if ($currentPromotionDetail) {
                            $promotion_document = $currentPromotionDetail->promotion_customer->promotion_document;
                            $limit_changes = $promotion_document->limit_changes;
                            $promotion_document_total = $promotion_document->total;
                            $promotion_document_description = $promotion_document->description;
                            $promotion_document_id = $promotion_document->id;
                            // Calcular puntos acumulados
                            $counts = (clone $baseQuery)

                                ->whereHas('promotion_customer', function ($query) use ($document, $promotion_document_id, $promotion_document_total) {
                                    $query->where('customer_id', $document->customer_id)
                                        ->where('acc_total', $promotion_document_total)
                                        ->where('active', 1)
                                        ->where('promotion_document_id', $promotion_document_id);
                                })
                                ->count();
                            $counts_desactive = (clone $baseQuery)
                                ->whereHas('promotion_customer', function ($query) use ($document, $promotion_document_id, $promotion_document_total) {
                                    $query->where('customer_id', $document->customer_id)
                                        ->where('acc_total', $promotion_document_total)
                                        ->where('active', 0)
                                        ->where('promotion_document_id', $promotion_document_id);
                                })
                                ->count();
                            // $to_log = [
                            //     'counts' => $counts,
                            //     'limit_changes' => $limit_changes,
                            //     'count_desactive' => $counts_desactive
                            // ];
                            // Log::info(json_encode($to_log));
                            if ($counts > $limit_changes) {
                                $counts = $limit_changes;
                            }
                            $counts = $counts - $counts_desactive;
                            // $to_log = [
                            //     'counts' => $counts,
                            //     'counts_desactive' => $counts_desactive
                            // ];
                            // Log::info(json_encode($to_log));
                            if ($counts > 0) {
                                $detail_message['message'] = "Puede canjear " . $counts . " de la promoción " . $promotion_document_description;
                            }
                        } else {
                            $promotion_document_total = 0;
                            $promotion_document_description = '';
                        }
                    }
                }
            }
            return view($view, compact('company', 'detail_points', 'detail_message', 'document', 'boxes', 'show_unit_types',  'stablishment', 'is_principal', 'class', 'student_name', 'students', 'footer_text'))->render();
        }


        return view($view, compact('company', 'document'))->render();
    }

    public function pdfFooter($base_template)
    {
        view()->addLocation(__DIR__ . '/Templates');

        return view('pdf.' . $base_template . '.partials.footer')->render();
    }

    public function validate_template($base_template, $template, $format_pdf)
    {

        $path_app_template = app_path('CoreFacturalo' . DIRECTORY_SEPARATOR . 'Templates');
        $path_template_default = 'pdf' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . $template . '_' . $format_pdf;
        $path_template = 'pdf' . DIRECTORY_SEPARATOR . $base_template . DIRECTORY_SEPARATOR . $template . '_' . $format_pdf;


        if (file_exists($path_app_template . DIRECTORY_SEPARATOR . $path_template . '.blade.php')) {
            return str_replace(DIRECTORY_SEPARATOR, '.', $path_template);
        }
        return str_replace(DIRECTORY_SEPARATOR, '.', $path_template_default);
    }


    public function pdfFooterTermCondition($base_template, $document)
    {
        view()->addLocation(__DIR__ . '/Templates');

        return view('pdf.' . $base_template . '.partials.footer_term_condition', compact('document'))->render();
    }
}
