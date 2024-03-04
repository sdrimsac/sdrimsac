<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Modules\Item\Models\CategoryItem;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;


class CategoryImport implements ToCollection
{
    use Importable;

    protected $data;

    public function collection(Collection $rows)
    {
        //try {
        $total = count($rows) - 1;

        $registered = 0;
        unset($rows[0]);
        foreach ($rows as $row) {

            $name = $row[0];
            $identifier = $row[1];
            $category = CategoryItem::updateOrCreate(
                ['name' => $name],
                [
                    'name' => $name,
                    'identifier' => $identifier,
                ]
            );
            $registered += 1;
        }
        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }
}
