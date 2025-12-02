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

    // Tolerancia para eliminar marcas duplicadas en minutos
    protected $toleranceMinutes = 3;   // ≤ 3 min es duplicado real

    public function collection(Collection $rows)
    {
        if (isset($rows[0])) unset($rows[0]);

        $groups = [];

        foreach ($rows as $row) {

            $number = trim((string)($row[0] ?? ''));
            $dateCell = $row[1] ?? null;

            if (!$number || !$dateCell) continue;

            // Convertir Excel → datetime
            try {
                if (is_numeric($dateCell)) {
                    $dt = Date::excelToDateTimeObject($dateCell);
                    $carbon = Carbon::instance($dt);
                } else {
                    $carbon = Carbon::parse($dateCell);
                }
            } catch (Exception $e) {
                $this->errors[] = "Error fecha number={$number}: " . $e->getMessage();
                continue;
            }

            $person = Person::where('number', $number)->first();
            if (!$person) {
                $this->errors[] = "Persona no encontrada number={$number}";
                continue;
            }

            $groups[$person->id][] = [
                'person_id' => $person->id,
                'carbon' => $carbon,
                'date_time' => $carbon->format('Y-m-d H:i:s'),
                'date' => $carbon->format('Y-m-d'),
                'time' => $carbon->format('H:i'),
            ];
        }

        // PROCESAR PERSONA POR PERSONA
        foreach ($groups as $person_id => $marks) {

            // ORDENAR por fecha-hora
            usort($marks, fn($a, $b) => $a['carbon']->timestamp <=> $b['carbon']->timestamp);

            // 1. FILTRAR DUPLICADOS (marcas en pocos minutos)
            $filtered = [];
            foreach ($marks as $m) {
                if (empty($filtered)) {
                    $filtered[] = $m;
                    continue;
                }

                $last = end($filtered);
                $diff = $last['carbon']->diffInMinutes($m['carbon']);

                if ($diff <= $this->toleranceMinutes) {
                    $this->errors[] = "Duplicado eliminado person={$person_id} {$m['date_time']} diff={$diff}";
                    continue;
                }

                $filtered[] = $m;
            }
            $marks = $filtered;

            // 2. CLASIFICAR INGRESO / SALIDA INTELIGENTEMENTE
            //
            // REGLA:
            // - Si NO tiene una marca sin cerrar → la siguiente es INGRESO
            // - Si YA tiene una entrada sin salida → la siguiente es SALIDA

            $estado = null; // null = nada abierto, 'ING' = esperando salida
            foreach ($marks as &$m) {

                $hour = $m['carbon']->hour;

                if ($estado === null) {
                    // Primera marca del ciclo → INGRESO
                    $m['type'] = 'INGRESO';
                    $estado = 'ING';
                } else {
                    // Si hay entrada pendiente → ahora es salida
                    $m['type'] = 'SALIDA';
                    $estado = null;
                }
            }

            // Si quedó una entrada sin salida → advertencia
            if ($estado === 'ING') {
                $this->errors[] = "Advertencia: persona {$person_id} quedó con entrada sin salida";
            }

            // 3. GUARDAR
            foreach ($marks as $m) {
                PersonAttendance::create([
                    'person_id' => $m['person_id'],
                    'date_time_attendance' => $m['date_time'],
                    'date_attendance' => $m['date'],
                    'time_attendance' => $m['time'],
                    'type' => $m['type'],
                ]);
            }
        }

        $this->data = [
            'total' => count($rows),
            'registered' => PersonAttendance::count()
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
