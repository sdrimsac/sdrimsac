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

        // Primero: recolectar y agrupar marcas por persona y fecha
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
            $time_only = $carbon->format('H:i:s');

            $person = Person::where('number', $number)->first();
            if (!$person) {
                $this->errors[] = "No se encontró persona con number={$number}";
                continue;
            }

            // Agrupar solo por persona; procesaremos emparejamientos cruzando fechas si es necesario
            $groups[$person->id][] = [
                'person_id' => $person->id,
                'date_time' => $date_time,
                'date_attendance' => $date_only,
                'time_attendance' => $time_only,
            ];
        }
        // Segundo: procesar cada grupo (por persona), ordenar por datetime y emparejar cronológicamente
        foreach ($groups as $person_id => $marks) {
            usort($marks, function ($a, $b) {
                return strtotime($a['date_time']) <=> strtotime($b['date_time']);
            });

            $i = 0;
            $count = count($marks);
            while ($i < $count) {
                $entry = $marks[$i];

                // Si existe siguiente marca, la usamos como salida emparejada
                if (isset($marks[$i + 1])) {
                    $exit = $marks[$i + 1];

                    // Calcular si la salida corresponde a la misma jornada (ej. turno nocturno)
                    try {
                        $startDt = Carbon::parse($entry['date_time']);
                        $endDt = Carbon::parse($exit['date_time']);
                    } catch (Exception $e) {
                        $this->errors[] = "Error al parsear fechas para emparejar person_id={$person_id}: " . $e->getMessage();
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
                    // consideramos que pertenece a la misma jornada y asignamos la fecha de la entrada a la salida.
                    $diffHours = $startDt->diffInHours($endDt, false);
                    if ($endDt->gte($startDt) && $diffHours <= 12) {
                        $exit_date_attendance = $startDt->format('Y-m-d');
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
