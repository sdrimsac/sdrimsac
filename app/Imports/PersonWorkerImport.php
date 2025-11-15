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

            $groups[$person->id][] = [
                'person_id' => $person->id,
                'date_time' => $date_time,
                'date_attendance' => $date_only,
                'time_attendance' => $time_only,
                'carbon' => $carbon,
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
           
            $toleranceMinutes = 10;

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

            $i = 0;
            $count = count($marks);
            while ($i < $count) {
                $entry = $marks[$i];

                // Si existe siguiente marca, la usamos como salida emparejada
                if (isset($marks[$i + 1])) {
                    $exit = $marks[$i + 1];

                    if (isset($entry['carbon']) && isset($exit['carbon'])) {
                        $startDt = $entry['carbon'];
                        $endDt = $exit['carbon'];
                    } else {
                        try {
                            $startDt = Carbon::parse($entry['date_time']);
                            $endDt = Carbon::parse($exit['date_time']);
                        } catch (Exception $e) {
                            $this->errors[] = "Error al parsear fechas para emparejar person_id={$person_id}: " . $e->getMessage();
                        }
                        // crear ambos por separado sin alterar fechas
                        $pair = [
                            ['m' => $entry, 'type' => 'INGRESO', 'date_att' => $entry['date_attendance']],
                            ['m' => $exit, 'type' => 'SALIDA', 'date_att' => $exit['date_attendance']],
                        ];
                        foreach ($pair as $p) {
                            try {
                                PersonAttendance::create([
                                    'person_id' => $p['m']['person_id'],
                                    'date_time_attendance' => $p['m']['date_time'],
                                    'date_attendance' => $p['date_att'],
                                    'time_attendance' => $p['m']['time_attendance'],
                                    'type' => $p['type'],
                                ]);
                                $registered++;
                            } catch (Exception $ee) {
                                $this->errors[] = "Error al crear attendance para person_id={$p['m']['person_id']} datetime={$p['m']['date_time']}: " . $ee->getMessage();
                            }
                        }
                        $i += 2;
                        continue;
                    }

                    // Si la salida es posterior a la entrada y la diferencia es razonable (<=12 horas),
                    // consideramos que pertenece a la misma jornada; usamos la fecha del datetime de salida
                    // para que las salidas después de medianoche se registren en el día correcto.
                    $diffHours = $startDt->diffInHours($endDt, false);
                    if ($endDt->gte($startDt) && $diffHours <= 12) {
                        // usar la fecha del endDt (salida), no la del inicio
                        $exit_date_attendance = $endDt->format('Y-m-d');
                    } else {
                        $exit_date_attendance = $exit['date_attendance'];
                    }

                    // Crear registro de ingreso
                    try {
                        PersonAttendance::create([
                            'person_id' => $entry['person_id'],
                            'date_time_attendance' => $entry['date_time'],
                            'date_attendance' => $entry['date_attendance'],
                            'time_attendance' => $entry['time_attendance'],
                            'type' => 'INGRESO',
                        ]);
                        $registered++;
                    } catch (Exception $e) {
                        $this->errors[] = "Error al crear ingreso para person_id={$entry['person_id']} datetime={$entry['date_time']}: " . $e->getMessage();
                    }

                    // Crear registro de salida (ajustando date_attendance si corresponde)
                    try {
                        PersonAttendance::create([
                            'person_id' => $exit['person_id'],
                            'date_time_attendance' => $exit['date_time'],
                            'date_attendance' => $exit_date_attendance,
                            'time_attendance' => $exit['time_attendance'],
                            'type' => 'SALIDA',
                        ]);
                        $registered++;
                    } catch (Exception $e) {
                        $this->errors[] = "Error al crear salida para person_id={$exit['person_id']} datetime={$exit['date_time']}: " . $e->getMessage();
                    }

                    $i += 2; // avanzamos por pares
                } else {
                    // Marca sin pareja: la registramos como INGRESO
                    try {
                        PersonAttendance::create([
                            'person_id' => $entry['person_id'],
                            'date_time_attendance' => $entry['date_time'],
                            'date_attendance' => $entry['date_attendance'],
                            'time_attendance' => $entry['time_attendance'],
                            'type' => 'INGRESO',
                        ]);
                        $registered++;
                    } catch (Exception $e) {
                        $this->errors[] = "Error al crear attendance sin pareja para person_id={$entry['person_id']} datetime={$entry['date_time']}: " . $e->getMessage();
                    }
                    $i++;
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
