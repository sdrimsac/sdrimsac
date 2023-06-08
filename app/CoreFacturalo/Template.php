<?php

namespace App\CoreFacturalo;

use App\Models\Tenant\Configuration;
use App\Models\Tenant\DocumentItem;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\ItemUnitType;
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

        if (is_object($document)) {
            $text = null;
            $student_name = null;
            $class = null;
            $config = Configuration::first();
            $document_type = $document->document_type_id == "80" ? "sale_note_id" : "document_id";
            $college_payment = CollegePayment::where($document_type, $document->id)->first();
            if ($college_payment) {
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
                                $row->price_unit = number_format($unit_type->total, 2);
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
            return view($view, compact('company', 'document', 'boxes', 'show_unit_types',  'stablishment', 'is_principal', 'class', 'student_name'))->render();
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
