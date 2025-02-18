<?php

namespace App\CoreFacturalo\Requests\Web\Validation;

class DocumentValidation
{
    public static function validation($inputs)
    {
        $series = Functions::findSeries($inputs);

        $inputs['series'] = $series->number;
        //        unset($inputs['series_id']);
        //aca estas eliminado series_id por eso no llega
        // if (!isset($inputs['customer_id'])) {
        //     $inputs['customer_id'] = Functions::person($inputs['customer'], 'customers');
        // }
        // $inputs['items'] = self::items($inputs['items']);
        Functions::DNI($inputs);
        Functions::identityDocumentTypeInvoice($inputs);

        return $inputs;
    }
    private static function items($inputs)
    {
        foreach ($inputs as &$row) {
            if (!isset($row['item_id'])) {
                $row['item_id'] = Functions::item($row);
                unset($row['internal_id'], $row['description']);
                unset($row['item_type_id'], $row['item_code']);
                unset($row['item_code_gs1'], $row['unit_type_id']);
                unset($row['currency_type_id']);
            }
        }

        return $inputs;
    }
}
