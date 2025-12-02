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
        $total = count($rows);
        $registered = 0;

        if (isset($rows[0])) unset($rows[0]);

        $groups = [];

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
            $time_only = $carbon->format('H:i');

            $person = Person::where('number', $number)->first();
            if (!$person) {
                $this->errors[] = "No se encontró persona con number={$number}";
                continue;
            }

            // Determinar tipo preliminar según hora
            $hour = (int)$carbon->format('H');
            $minute = (int)$carbon->format('i');
            $type = 'SALIDA';
            // INGRESO: 07:00-11:00 (inclusive) o 15:00-20:00 (inclusive) estrictamente
            if ((($hour > 6 && $hour < 12) || ($hour > 14 && $hour < 21))) {
                $type = 'INGRESO';
            }
            $groups[$person->id][] = [
                'person_id' => $person->id,
                'date_time' => $date_time,
                'date_attendance' => $date_only,
                'time_attendance' => $time_only,
                'carbon' => $carbon,
                'type' => $type,
            ];
        }
        // Segundo: procesar cada grupo (por persona), ordenar por datetime y emparejar cronológicamente
        foreach ($groups as $person_id => $marks) {
            // sort by the Carbon timestamp to ensure correct chronological order and avoid
            // any parsing/formatting inconsistencies
            usort($marks, function ($a, $b) {
                $ta = isset($a['carbon']) ? $a['carbon']->getTimestamp() : strtotime($a['date_time']);
                $tb = isset($b['carbon']) ? $b['carbon']->getTimestamp() : strtotime($b['date_time']);
                return $ta <=> $tb;
            });
           
            $toleranceMinutes = 60;

            $filtered = [];
            foreach ($marks as $m) {
                if (empty($filtered)) {
                    $filtered[] = $m;
                    continue;
                }

                $last = end($filtered);
                // Usamos las instancias Carbon ya almacenadas para calcular la diferencia
                if (isset($last['carbon']) && isset($m['carbon'])) {
                    $diff = $last['carbon']->diffInMinutes($m['carbon']);
                } else {
                    try {
                        $lastDt = Carbon::parse($last['date_time']);
                        $curDt = Carbon::parse($m['date_time']);
                        $diff = $lastDt->diffInMinutes($curDt);
                    } catch (Exception $e) {
                        // Si algo falla al parsear, no descartamos la marca por seguridad
                        $diff = $toleranceMinutes + 1;
                    }
                }

                if ($diff <= $toleranceMinutes) {
                    // Omitimos la marca duplicada cercana. Guardamos un mensaje opcional.
                    $this->errors[] = "Marca duplicada eliminada person_id={$m['person_id']} datetime={$m['date_time']} (diferencia {$diff} minutos)";
                    continue;
                }

                $filtered[] = $m;
            }

            // Reemplazamos el arreglo de marcas por el filtrado
            $marks = array_values($filtered);

            // Ahora, simplemente registrar cada marca según su tipo determinado
            foreach ($marks as $entry) {
                try {
                    PersonAttendance::create([
                        'person_id' => $entry['person_id'],
                        'date_time_attendance' => $entry['date_time'],
                        'date_attendance' => $entry['date_attendance'],
                        'time_attendance' => $entry['time_attendance'],
                        'type' => $entry['type'],
                    ]);
                    $registered++;
                } catch (Exception $e) {
                    $this->errors[] = "Error al crear attendance para person_id={$entry['person_id']} datetime={$entry['date_time']}: " . $e->getMessage();
                }
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
