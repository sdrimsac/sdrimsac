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
use App\Models\Tenant\Schedule;

class PersonWorkerImport implements ToCollection
{
    use Importable;

    protected $data;
    protected $errors = [];

    // Tolerancia para eliminar marcas duplicadas en minutos
    protected $toleranceMinutes = 3;   // ≤ 3 min es duplicado real
    
    // Tiempo máximo entre ingreso y salida (en horas)
    // Si pasan más de estas horas, se considera que olvidó marcar
    protected $maxHoursBetweenMarks = 13;
    
    // Horas a sumar al ingreso para crear salida automática
    // Basado en jornada laboral estándar
    protected $estimatedWorkHours = 8;

    public function collection(Collection $rows)
    {
        if (isset($rows[0])) unset($rows[0]);

        $groups = [];
        $rowCount = 0;

        foreach ($rows as $row) {
            $rowCount++;

            $number = trim((string)($row[0] ?? ''));
            $dateCell = $row[1] ?? null;

            if (!$number || !$dateCell) {
                $this->errors[] = "Fila {$rowCount}: Datos vacíos (number={$number}, fecha={$dateCell})";
                continue;
            }

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

            $this->errors[] = "Procesando person_id={$person_id}: " . count($marks) . " marcas";

            // ORDENAR por fecha-hora
            usort($marks, function($a, $b) {
                return $a['carbon']->timestamp <=> $b['carbon']->timestamp;
            });

            // NO MOSTRAR TODAS LAS MARCAS - Solo resumen
            // Log de marcas ordenadas REMOVIDO para evitar overflow

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

            // Log simplificado
            $this->errors[] = "  Filtrado: " . count($marks) . " marcas válidas";

            // 2. CLASIFICAR INGRESO / SALIDA INTELIGENTEMENTE
            //
            // REGLA INTELIGENTE:
            // - Verificar si hay entrada sin salida en BD
            // - Si la diferencia entre marcas es > maxHoursBetweenMarks (13h):
            //   → La marca anterior olvidó su salida, la nueva es INGRESO
            // - Si la diferencia es <= maxHoursBetweenMarks:
            //   → Alterna normal: INGRESO → SALIDA → INGRESO → SALIDA

            // Verificar si hay un ingreso sin salida en la BD
            $lastAttendance = PersonAttendance::where('person_id', $person_id)
                ->orderBy('date_time_attendance', 'desc')
                ->first();

            $estado = null; // null = nada abierto, 'ING' = esperando salida
            
            // Si existe un registro previo y es INGRESO, empezar con SALIDA
            if ($lastAttendance && $lastAttendance->type === 'INGRESO') {
                // Verificar si pasó mucho tiempo desde el último ingreso
                $hoursSinceLastMark = Carbon::parse($lastAttendance->date_time_attendance)
                    ->diffInHours($marks[0]['carbon']);
                
                if ($hoursSinceLastMark > $this->maxHoursBetweenMarks) {
                    // Pasó mucho tiempo, probablemente olvidó marcar salida
                    $this->errors[] = "  Último: INGRESO hace {$hoursSinceLastMark}h - Olvidó salida";
                    $estado = null; // Empezar con INGRESO
                } else {
                    $estado = 'ING'; // Hay entrada abierta reciente
                    $this->errors[] = "  Último: INGRESO hace {$hoursSinceLastMark}h - Continuar con SALIDA";
                }
            } else if ($lastAttendance) {
                // Log simplificado
                $estado = null;
            } else {
                $this->errors[] = "  Sin registros previos";
            }

            $previousMark = null;
            $marksWithAutoExit = []; // Incluirá salidas automáticas
            $autoExitsCount = 0; // Contador de salidas automáticas
            
            foreach ($marks as $m) { // REMOVIDO & (sin referencia)

                if ($estado === null) {
                    // Después de una salida o al inicio → INGRESO
                    $m['type'] = 'INGRESO';
                    $estado = 'ING';
                    $marksWithAutoExit[] = $m;
                } else {
                    // Hay entrada pendiente, verificar tiempo transcurrido
                    if ($previousMark !== null) {
                        $hoursDiff = $previousMark['carbon']->diffInHours($m['carbon']);
                        
                        if ($hoursDiff > $this->maxHoursBetweenMarks) {
                            // Pasó mucho tiempo, olvidó marcar salida anterior
                            $autoExitsCount++;
                            
                            // CREAR SALIDA AUTOMÁTICA usando el horario real de la persona
                            $autoExitTime = $this->calculateAutoExitTime($m['person_id'], $previousMark['carbon']);
                            
                            $autoExit = [
                                'person_id' => $m['person_id'],
                                'carbon' => $autoExitTime,
                                'date_time' => $autoExitTime->format('Y-m-d H:i:s'),
                                'date' => $autoExitTime->format('Y-m-d'),
                                'time' => $autoExitTime->format('H:i'),
                                'type' => 'SALIDA',
                                'auto_generated' => true,
                            ];
                            $marksWithAutoExit[] = $autoExit;
                            
                            // La marca actual es un nuevo ingreso
                            $m['type'] = 'INGRESO';
                            $estado = 'ING';
                            $marksWithAutoExit[] = $m;
                        } else {
                            // Tiempo normal, es una salida
                            $m['type'] = 'SALIDA';
                            $estado = null;
                            $marksWithAutoExit[] = $m;
                        }
                    } else {
                        // Primera marca después de verificar BD
                        $m['type'] = 'SALIDA';
                        $estado = null;
                        $marksWithAutoExit[] = $m;
                    }
                }
                
                // LOG REMOVIDO para evitar overflow
                $previousMark = $m;
            }
            
            if ($autoExitsCount > 0) {
                $this->errors[] = "  ⚠️ {$autoExitsCount} salida(s) automática(s) creada(s)";
            }
            
            // Usar las marcas con salidas automáticas incluidas
            $marks = $marksWithAutoExit;

            // Si quedó una entrada sin salida → advertencia
            if ($estado === 'ING') {
                $this->errors[] = "Advertencia: persona {$person_id} quedó con entrada sin salida";
            }

            // 3. GUARDAR (evitando duplicados en BD)
            $insertados = 0;
            $duplicados = 0;
            $errores = 0;
            
            $this->errors[] = "  DEBUG: Intentando guardar " . count($marks) . " marcas";
            $this->errors[] = "  DEBUG: Primera marca tiene campos: " . json_encode(array_keys($marks[0] ?? []));
            
            foreach ($marks as $idx => $m) {
                // Verificar campos requeridos
                if (!isset($m['person_id']) || !isset($m['date_time']) || !isset($m['date']) || !isset($m['time']) || !isset($m['type'])) {
                    $this->errors[] = "  ❌ Marca {$idx} incompleta: " . json_encode($m);
                    $errores++;
                    continue;
                }
                
                // Verificar si ya existe este registro exacto en la BD
                $existing = PersonAttendance::where('person_id', $m['person_id'])
                    ->where('date_time_attendance', $m['date_time'])
                    ->first();

                if ($existing) {
                    $duplicados++;
                    continue;
                }

                try {
                    PersonAttendance::create([
                        'person_id' => $m['person_id'],
                        'date_time_attendance' => $m['date_time'],
                        'date_attendance' => $m['date'],
                        'time_attendance' => $m['time'],
                        'type' => $m['type'],
                        'biometrio' => isset($m['auto_generated']) && $m['auto_generated'] ? 'AUTO' : null,
                    ]);
                    
                    $insertados++;
                } catch (\Exception $e) {
                    $errores++;
                    $this->errors[] = "  ❌ ERROR marca {$idx}: " . $e->getMessage();
                }
            }
            
            $this->errors[] = "  ✅ Insertados: {$insertados} | Duplicados: {$duplicados} | Errores: {$errores}";
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
    
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Calcula la hora de salida automática basándose en el horario real del trabajador
     */
    protected function calculateAutoExitTime($person_id, $ingresoCarbon)
    {
        // Buscar el horario del trabajador
        $schedule = Schedule::where('person_id', $person_id)->first();
        
        if (!$schedule) {
            // Si no tiene horario, usar estimación de 8 horas
            return $ingresoCarbon->copy()->addHours($this->estimatedWorkHours);
        }
        
        // Calcular la duración del turno en horas
        $entrada = Carbon::parse('2000-01-01 ' . $schedule->entrada);
        $salida = Carbon::parse('2000-01-01 ' . $schedule->salida);
        
        // Si la salida es menor que la entrada, es turno nocturno (cruza medianoche)
        if ($salida->lt($entrada)) {
            $salida->addDay();
        }
        
        $duracionTurnoHoras = $entrada->diffInHours($salida, false);
        
        // Sumar la duración del turno a la hora REAL de ingreso
        return $ingresoCarbon->copy()->addHours($duracionTurnoHoras);
    }
}
