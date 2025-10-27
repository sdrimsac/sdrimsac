<?php

namespace App\Imports;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Tenant\Person;
use App\Models\Tenant\PersonAttendance;

class PersonWorkerImport implements ToCollection
{
    use Importable;

    protected $data;
    protected $errors = [];

    public function collection(Collection $rows)
    {
        // rows: header + rows where col0 = number, col1 = date/time
        $total = count($rows);
        $registered = 0;

        // remove header row if present
        if (isset($rows[0])) unset($rows[0]);

        foreach ($rows as $row) {
            $number = isset($row[0]) ? trim((string)$row[0]) : null;
            $dateCell = $row[1] ?? null;

            if (empty($number) || empty($dateCell)) {
                $this->errors[] = "Fila vacía o incompleta: number={$number} date={$dateCell}";
                continue;
            }

            try {
                if (is_numeric($dateCell)) {
                    $dt = Date::excelToDateTimeObject($dateCell);
                    $carbon = Carbon::instance($dt);
                } else {
                    $carbon = Carbon::parse($dateCell);
                }
            } catch (Exception $e) {
                $this->errors[] = "No se pudo parsear la fecha para number={$number}: " . $e->getMessage();
                continue;
            }

            $date_time = $carbon->format('Y-m-d H:i:s');
            $date_only = $carbon->format('Y-m-d');
            $time_only = $carbon->format('H:i:s');

            $person = Person::where('number', $number)->first();
            if (!$person) {
                $this->errors[] = "No se encontró persona con number={$number}";
                continue;
            }

            try {
                PersonAttendance::create([
                    'person_id' => $person->id,
                    'date_time_attendance' => $date_time,
                    'date_attendance' => $date_only,
                    'time_attendance' => $time_only,
                ]);
                $registered++;
            } catch (Exception $e) {
                $this->errors[] = "Error al crear attendance para number={$number}: " . $e->getMessage();
                continue;
            }
        }

        $this->data = compact('total', 'registered');
    }

    public function getData()
    {
        return $this->data;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
