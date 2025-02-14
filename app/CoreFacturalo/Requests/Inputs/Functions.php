<?php

namespace App\CoreFacturalo\Requests\Inputs;

use App\Models\Tenant\CompanySameRuc;
use App\Models\Tenant\Document;
use App\Models\Tenant\Series;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
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

    public static function identifier($soap_type_id, $date_of_issue, $model)
    {
        $same_rucs = CompanySameRuc::all();
        $path = explode('\\', $model);
        
        if (count($same_rucs) > 0) {
            $numeration = 0;
            $table = $path == 'Voided' ?  'voided' : 'summaries';
            foreach ($same_rucs as $same_ruc) {
                $query = "SELECT COUNT(*) as total FROM " . $same_ruc->uuid . "." . $table . " WHERE soap_type_id = ? AND date_of_issue = ?";
                $result = DB::select($query, [$soap_type_id, $date_of_issue]);
                $numeration += $result[0]->total;
            }
            $numeration += 2;
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
