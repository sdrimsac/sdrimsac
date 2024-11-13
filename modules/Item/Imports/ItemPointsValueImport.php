<?php

namespace Modules\Item\Imports;

use App\Models\Tenant\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;


class ItemPointsValueImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
            $total = count($rows);
            $registered = 0;
            unset($rows[0]);

            foreach ($rows as $row)
            {
                $internal_id = ($row[0])?:null;
                $description = $row[1];
                $points_value = $row[2];
 


                if($internal_id) {
                    $item = Item::where('internal_id', $internal_id)
                                    ->first();
                }

                
                if($item) {
                    $item->points_value = $points_value;
                    $item->save();
                    $registered += 1;

                } 

            }

            $this->data = compact('total', 'registered');

    }

    public function getData()
    {
        return $this->data;
    }
}
