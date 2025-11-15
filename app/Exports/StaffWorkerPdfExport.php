<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade as PDF;

class StaffWorkerPdfExport
{
    protected $records;
    protected $company;
    protected $establishment;
    protected $d_start;
    protected $d_end;

    public function records($records) {
        $this->records = $records;
        return $this;
    }
    
    public function company($company) {
        $this->company = $company;
        return $this;
    }

    public function establishment($establishment)
    {
        $this->establishment = $establishment;
        return $this;
    }

    public function dateRange($d_start, $d_end)
    {
        $this->d_start = $d_start;
        $this->d_end = $d_end;
        return $this;
    }
    
    public function processData()
    {
        try {
            $data = collect();
            $rowNumber = 1;

            // Validar que existan records
            if (empty($this->records)) {
                Log::warning('No hay registros para exportar');
                return $data;
            }

            foreach ($this->records as $record) {
                try {
                    // Resolve el nombre de la persona con validación - DINÁMICO
                    $personName = '';
                    $personRole = '';
                    $factorDiario = 0.00; // Inicializar sin valor por defecto
                    
                    if (isset($record->person)) {
                        $person = $record->person;
                        $personName = isset($person->name) ? $person->name : ($person['name'] ?? 'Sin nombre');
                    } else {
                        $personName = isset($record->person_name) ? $record->person_name : ($record['person_name'] ?? 'Sin nombre');
                    }

                    // PRIORIDAD 1: Usar el job_position del registro diario específico (puede cambiar día a día)
                    if (isset($record->job_position) && $record->job_position) {
                        $jobPositionFromRecord = $record->job_position;
                        $personRole = isset($jobPositionFromRecord->name) ? $jobPositionFromRecord->name : 'Sin cargo';
                        $factorDiario = isset($jobPositionFromRecord->factor_diario) && is_numeric($jobPositionFromRecord->factor_diario) ? 
                            (float)$jobPositionFromRecord->factor_diario : 0.00;
                    }
                    // PRIORIDAD 2: Fallback al job_position fijo de la persona si no hay en el registro diario
                    elseif (isset($record->person->job_position) && $record->person->job_position) {
                        $jobPosition = $record->person->job_position;
                        $personRole = isset($jobPosition->name) ? $jobPosition->name : 'Sin cargo';
                        $factorDiario = isset($jobPosition->factor_diario) && is_numeric($jobPosition->factor_diario) ? 
                            (float)$jobPosition->factor_diario : 0.00;
                    }
                    // PRIORIDAD 3: Sin cargo si no hay ninguna relación
                    else {
                        $personRole = 'Sin cargo';
                        $factorDiario = 0.00;
                    }

                    $dateDaily = isset($record->date_daily) ? $record->date_daily : ($record['date_daily'] ?? '');
                    $dateEnd = isset($record->date_end_daily) ? $record->date_end_daily : ($record['date_end_daily'] ?? '');
                    $pairsRaw = isset($record->pairs) ? $record->pairs : ($record['pairs'] ?? []);

                    // Validar que pairsRaw sea iterable
                    if (!is_array($pairsRaw) && !is_object($pairsRaw)) {
                        $pairsRaw = [];
                    }

                    // Normalize pairs con validación mejorada
                    $normalizedPairs = collect($pairsRaw)->map(function ($p) {
                        if (!$p) return null;
                        
                        $entr = isset($p->entrance) ? $p->entrance : ($p['entrance'] ?? '');
                        $ext = isset($p->exit) ? $p->exit : ($p['exit'] ?? '');
                        $minutes = isset($p->minutes) ? $p->minutes : ($p['minutes'] ?? null);
                        $date = isset($p->exit_date) ? $p->exit_date : ($p['exit_date'] ?? '');
                        return [
                            'entrance' => $entr,
                            'exit' => $ext,
                            'minutes' => $minutes,
                            'exit_date' => $date,
                        ];
                    })->filter()->values();

                    // Formatear las horas trabajadas
                    $horasTrabajadasText = '';
                    $totalMinutesToday = 0;
                    
                    foreach ($normalizedPairs as $pair) {
                        if (!empty($pair['entrance']) && !empty($pair['exit'])) {
                            try {
                                // Validar fechas antes de parsear
                                if (empty($dateDaily)) {
                                    $dateDaily = date('Y-m-d');
                                }
                                if (empty($pair['exit_date'])) {
                                    $pair['exit_date'] = $dateDaily;
                                }

                                $entranceTime = Carbon::parse($dateDaily . ' ' . $pair['entrance']);
                                $exitTime = Carbon::parse($pair['exit_date'] . ' ' . $pair['exit']);
                                $duration = $exitTime->diff($entranceTime);
                                $totalMinutesInPair = ($duration->h * 60) + $duration->i;
                                $totalMinutesToday += $totalMinutesInPair;
                                
                                $horasDuracion = sprintf('%dh %dm', $duration->h, $duration->i);
                                
                                if (!empty($horasTrabajadasText)) {
                                    $horasTrabajadasText .= "<br>";
                                }
                                $horasTrabajadasText .= $pair['entrance'] . ' ← ' . $pair['exit'] . ' — ' . $horasDuracion;
                            } catch (\Exception $e) {
                                Log::warning('Error al calcular duración de horas', [
                                    'entrance' => $pair['entrance'], 
                                    'exit' => $pair['exit'],
                                    'error' => $e->getMessage()
                                ]);
                                
                                if (!empty($horasTrabajadasText)) {
                                    $horasTrabajadasText .= "<br>";
                                }
                                $horasTrabajadasText .= $pair['entrance'] . ' ← ' . $pair['exit'];
                            }
                        }
                    }

                    // Calcular total de minutos trabajados del record
                    $totalMinutes = $normalizedPairs->reduce(function ($carry, $p) {
                        $m = isset($p['minutes']) && is_numeric($p['minutes']) ? (int) $p['minutes'] : 0;
                        return $carry + $m;
                    }, 0);

                    // Si no hay minutos calculados del record, usar los calculados aquí
                    if ($totalMinutes == 0) {
                        $totalMinutes = $totalMinutesToday;
                    }

                    // Formatear tiempo total trabajado
                    $formatMinutesToTime = function ($minutes) {
                        if ($minutes === null || $minutes === '' || !is_numeric($minutes)) return '00:00';
                        $minutes = (int)$minutes;
                        if ($minutes < 0) return '00:00';
                        $h = floor($minutes / 60);
                        $m = $minutes % 60;
                        return sprintf('%02d:%02d', $h, $m);
                    };

                    // Usar los datos ya calculados que vienen en el record
                    $horasTrabajadas = isset($record->horas_trabajadas) ? $record->horas_trabajadas : '00:00:00';
                    
                    // Formatear a HH:MM si viene como HH:MM:SS
                    if (strlen($horasTrabajadas) > 5) {
                        $horasTrabajadas = substr($horasTrabajadas, 0, 5); // Quitar los segundos
                    }

                    // Usar las horas extras ya calculadas
                    $horasExtras25 = isset($record->extra_time_two) ? $record->extra_time_two : '00:00:00';
                    $horasExtras35 = isset($record->extra_time_three) ? $record->extra_time_three : '00:00:00';
                    
                    // Formatear a HH:MM si vienen como HH:MM:SS
                    if (strlen($horasExtras25) > 5) {
                        $horasExtras25 = substr($horasExtras25, 0, 5);
                    }
                    if (strlen($horasExtras35) > 5) {
                        $horasExtras35 = substr($horasExtras35, 0, 5);
                    }

                    // Usar las horas faltantes ya calculadas
                    $horasFaltante = '00:00';
                    if (isset($record->lack_time) && $record->lack_time) {
                        $horasFaltante = $record->lack_time;
                        if (strlen($horasFaltante) > 5) {
                            $horasFaltante = substr($horasFaltante, 0, 5);
                        }
                    }

                    // Usar adelantos y consumos ya calculados del registro
                    $adelantos = isset($record->advances) && is_numeric($record->advances) ? 
                        (float)$record->advances : 0.00;
                    
                    $consumosTotal = isset($record->consumptions) && is_numeric($record->consumptions) ? 
                        (float)$record->consumptions : 0.00;

                    // ============ NUEVOS CÁLCULOS DETALLADOS ============
                    
                    // Función para convertir HH:MM a minutos
                    $timeToMinutes = function($time) {
                        if (empty($time) || $time === '00:00') return 0;
                        $parts = explode(':', $time);
                        if (count($parts) >= 2) {
                            return (int)$parts[0] * 60 + (int)$parts[1];
                        }
                        return 0;
                    };

                    // Función para convertir minutos a HH:MM
                    $minutesToTime = function($minutes) {
                        if ($minutes <= 0) return '00:00';
                        $h = floor($minutes / 60);
                        $m = $minutes % 60;
                        return sprintf('%02d:%02d', $h, $m);
                    };

                    // Convertir tiempos a minutos para cálculos
                    $minutosTrabajadasBase = $timeToMinutes($horasTrabajadas);
                    $minutosExtras25 = $timeToMinutes($horasExtras25);
                    $minutosExtras35 = $timeToMinutes($horasExtras35);
                    $minutosFaltantes = $timeToMinutes($horasFaltante);

                    // Calcular horas totales trabajadas (base + extras)
                    $minutosHorasTotal = $minutosTrabajadasBase + $minutosExtras25 + $minutosExtras35;
                    $horasTotal = $minutesToTime($minutosHorasTotal);

                    // Las horas faltantes se restan de las extras de 25%
                    $minutosExtras25Final = $minutosExtras25 - $minutosFaltantes;
                    if ($minutosExtras25Final < 0) $minutosExtras25Final = 0;
                    $horasExtras25Final = $minutesToTime($minutosExtras25Final);

                    // Horas extras 35% no se ven afectadas por las faltantes
                    $horasExtras35Final = $horasExtras35;

                    // Calcular pago por hora basado en el factor diario
                    // Asumiendo 8 horas de jornada laboral estándar
                    $pagoPorHora = $factorDiario > 0 ? ($factorDiario / 8) : 0.00;

                    // Calcular pagos detallados
                    $pagoHorasNormales = ($minutosTrabajadasBase / 60) * $pagoPorHora;
                    $pagoExtras25 = ($minutosExtras25Final / 60) * ($pagoPorHora * 1.25);
                    $pagoExtras35 = ($minutosExtras35 / 60) * ($pagoPorHora * 1.35);

                    // Total de pago del día (incluye adelantos y descuenta consumos)
                    $totalPagoDia = $pagoHorasNormales + $pagoExtras25 + $pagoExtras35 + $adelantos - $consumosTotal;

                    // Formatear fechas para mostrar solo la fecha
                    $fechaIngreso = $dateDaily;
                    $fechaSalida = $dateEnd;

                    // Calcular el día de la semana en español
                    $diaSemana = '';
                    if ($fechaIngreso) {
                        try {
                            $diasSemana = [
                                'Monday' => 'Lunes',
                                'Tuesday' => 'Martes', 
                                'Wednesday' => 'Miércoles',
                                'Thursday' => 'Jueves',
                                'Friday' => 'Viernes',
                                'Saturday' => 'Sábado',
                                'Sunday' => 'Domingo'
                            ];
                            $fechaCarbon = Carbon::parse($fechaIngreso);
                            $dayEnglish = $fechaCarbon->format('l'); // Día en inglés
                            $diaSemana = $diasSemana[$dayEnglish] ?? $dayEnglish;
                        } catch (\Exception $e) {
                            Log::warning('Error al calcular día de la semana', [
                                'fecha' => $fechaIngreso,
                                'error' => $e->getMessage()
                            ]);
                            $diaSemana = '';
                        }
                    }

                    $data->push([
                        'numero' => $rowNumber++,
                        'persona_nombre' => $personName,
                        'persona_cargo' => $personRole,
                        'fecha_ingreso' => $fechaIngreso,
                        'dia_semana' => $diaSemana,
                        'horas_trabajadas_detalle' => $horasTrabajadasText,
                        'fecha_salida' => $fechaSalida,
                        'horas_trabajadas' => $horasTrabajadas,
                        'factor_diario' => $factorDiario,
                        'horas_extras_25' => $horasExtras25,
                        'horas_extras_35' => $horasExtras35,
                        'horas_faltante' => $horasFaltante,
                        'adelantos' => $adelantos,
                        'consumos' => $consumosTotal
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Error procesando registro individual en exportación PDF', [
                        'record' => $record,
                        'error' => $e->getMessage(),
                        'line' => $e->getLine()
                    ]);
                    continue;
                }
            }

            // ============ CALCULAR TOTALES POR PERSONA ============
            
            $totalesPorPersona = [];
            
            foreach ($this->records as $record) {
                try {
                    $personName = '';
                    if (isset($record->person)) {
                        $person = $record->person;
                        $personName = isset($person->name) ? $person->name : ($person['name'] ?? 'Sin nombre');
                    } else {
                        $personName = isset($record->person_name) ? $record->person_name : ($record['person_name'] ?? 'Sin nombre');
                    }

                    if (!isset($totalesPorPersona[$personName])) {
                        $totalesPorPersona[$personName] = [
                            'factorDiario' => 0,
                            'horasTrabajadas' => 0,
                            'horasExtras25' => 0,
                            'horasExtras35' => 0,
                            'horasFaltante' => 0,
                            'adelantos' => 0,
                            'consumos' => 0,
                            'aCobrar' => 0,
                            'dias' => 0
                        ];
                    }

                    // Obtener factor diario
                    $factorDiario = 0.00;
                    if (isset($record->job_position) && $record->job_position) {
                        $factorDiario = isset($record->job_position->factor_diario) && is_numeric($record->job_position->factor_diario) ? 
                            (float)$record->job_position->factor_diario : 0.00;
                    } elseif (isset($record->person->job_position) && $record->person->job_position) {
                        $factorDiario = isset($record->person->job_position->factor_diario) && is_numeric($record->person->job_position->factor_diario) ? 
                            (float)$record->person->job_position->factor_diario : 0.00;
                    }

                    // Función para convertir HH:MM a minutos
                    $timeToMinutes = function($time) {
                        if (empty($time) || $time === '00:00') return 0;
                        $parts = explode(':', $time);
                        if (count($parts) >= 2) {
                            return (int)$parts[0] * 60 + (int)$parts[1];
                        }
                        return 0;
                    };

                    // Obtener y procesar datos
                    $horasTrabajadas = isset($record->horas_trabajadas) ? $record->horas_trabajadas : '00:00:00';
                    if (strlen($horasTrabajadas) > 5) {
                        $horasTrabajadas = substr($horasTrabajadas, 0, 5);
                    }

                    $horasExtras25 = isset($record->extra_time_two) ? $record->extra_time_two : '00:00:00';
                    $horasExtras35 = isset($record->extra_time_three) ? $record->extra_time_three : '00:00:00';
                    if (strlen($horasExtras25) > 5) $horasExtras25 = substr($horasExtras25, 0, 5);
                    if (strlen($horasExtras35) > 5) $horasExtras35 = substr($horasExtras35, 0, 5);

                    $horasFaltante = '00:00';
                    if (isset($record->lack_time) && $record->lack_time) {
                        $horasFaltante = $record->lack_time;
                        if (strlen($horasFaltante) > 5) $horasFaltante = substr($horasFaltante, 0, 5);
                    }

                    $adelantos = isset($record->advances) && is_numeric($record->advances) ? (float)$record->advances : 0.00;
                    $consumos = isset($record->consumptions) && is_numeric($record->consumptions) ? (float)$record->consumptions : 0.00;

                    // Convertir a minutos y calcular
                    $minutosTrabajadasBase = $timeToMinutes($horasTrabajadas);
                    $minutosExtras25 = $timeToMinutes($horasExtras25);
                    $minutosExtras35 = $timeToMinutes($horasExtras35);
                    $minutosFaltantes = $timeToMinutes($horasFaltante);
                    
                    // Las horas faltantes se restan SOLO de las extras 25%
                    $minutosExtras25Final = $minutosExtras25 - $minutosFaltantes;
                    if ($minutosExtras25Final < 0) $minutosExtras25Final = 0;

                    // Calcular pago por hora basado en el factor diario
                    $pagoPorHora = $factorDiario > 0 ? ($factorDiario / 8) : 0.00;
                    
                    // Calcular pagos detallados
                    $pagoHorasNormales = ($minutosTrabajadasBase / 60) * $pagoPorHora;
                    $pagoExtras25 = ($minutosExtras25Final / 60) * ($pagoPorHora * 1.25);
                    $pagoExtras35 = ($minutosExtras35 / 60) * ($pagoPorHora * 1.35);
                    $totalPago = $pagoHorasNormales + $pagoExtras25 + $pagoExtras35;
                    $aCobrar = $totalPago + $adelantos - $consumos;

                    // Sumar a totales
                    $totalesPorPersona[$personName]['factorDiario'] += $factorDiario;
                    $totalesPorPersona[$personName]['horasTrabajadas'] += $minutosTrabajadasBase;
                    $totalesPorPersona[$personName]['horasExtras25'] += $minutosExtras25;
                    $totalesPorPersona[$personName]['horasExtras35'] += $minutosExtras35;
                    $totalesPorPersona[$personName]['horasFaltante'] += $minutosFaltantes;
                    $totalesPorPersona[$personName]['adelantos'] += $adelantos;
                    $totalesPorPersona[$personName]['consumos'] += $consumos;
                    $totalesPorPersona[$personName]['aCobrar'] += $aCobrar;
                    $totalesPorPersona[$personName]['dias']++;

                } catch (\Exception $e) {
                    Log::warning('Error calculando totales para persona en PDF', [
                        'record' => $record,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            // Función para convertir minutos a HH:MM
            $minutesToTime = function($minutes) {
                if ($minutes <= 0) return '00:00';
                $h = floor($minutes / 60);
                $m = $minutes % 60;
                return sprintf('%02d:%02d', $h, $m);
            };

            // Convertir totales de minutos a tiempo
            foreach ($totalesPorPersona as $nombre => &$totales) {
                $totales['horasTrabajadas_formatted'] = $minutesToTime($totales['horasTrabajadas']);
                $totales['horasExtras25_formatted'] = $minutesToTime($totales['horasExtras25']);
                $totales['horasExtras35_formatted'] = $minutesToTime($totales['horasExtras35']);
                $totales['horasFaltante_formatted'] = $minutesToTime($totales['horasFaltante']);
            }

            return [
                'data' => $data,
                'totales' => $totalesPorPersona
            ];
            
        } catch (\Exception $e) {
            Log::error('Error general en procesamiento de datos para PDF', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'data' => collect(),
                'totales' => []
            ];
        }
    }

    public function download($filename)
    {
        try {
            $processedData = $this->processData();
            
            $data = [
                'records' => $processedData['data'],
                'totales' => $processedData['totales'],
                'company' => $this->company,
                'establishment' => $this->establishment,
                'date_start' => $this->d_start ? Carbon::parse($this->d_start)->format('d-m-Y') : 'N/A',
                'date_end' => $this->d_end ? Carbon::parse($this->d_end)->format('d-m-Y') : 'N/A',
                'generation_date' => Carbon::now()->format('d-m-Y H:i:s')
            ];

            $pdf = PDF::loadView('exports.staff_worker_pdf', $data);
            
            // Configurar el PDF en orientación horizontal
            $pdf->setPaper('A3', 'landscape');

            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            Log::error('Error generando PDF', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
