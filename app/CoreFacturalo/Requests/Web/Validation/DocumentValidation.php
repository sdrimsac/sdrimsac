<?php

namespace App\CoreFacturalo\Requests\Web\Validation;

class DocumentValidation
{
    public static function validation($inputs) {
        $series = Functions::findSeries($inputs);
        
        $inputs['series'] = $series->number;
//        unset($inputs['series_id']);
        //aca estas eliminado series_id por eso no llega
        if(!isset($inputs['customer_id'])){
            $inputs['customer_id'] = Functions::person($inputs['customer'], 'customers');
        }
        Functions::DNI($inputs);
        Functions::identityDocumentTypeInvoice($inputs);
        
        return $inputs;
    }
}