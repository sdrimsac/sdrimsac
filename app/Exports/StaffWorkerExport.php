<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StaffWorkerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading, WithCustomStartCell, WithStyles
{
    use Exportable;
    protected $records;
    /* protected $person; */
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
    
    public function collection()
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
                                    $horasTrabajadasText .= "\n";
                                }
                                $horasTrabajadasText .= $pair['entrance'] . ' ← ' . $pair['exit'] . ' — ' . $horasDuracion;
                            } catch (\Exception $e) {
                                Log::warning('Error al calcular duración de horas', [
                                    'entrance' => $pair['entrance'], 
                                    'exit' => $pair['exit'],
                                    'error' => $e->getMessage()
                                ]);
                                
                                if (!empty($horasTrabajadasText)) {
                                    $horasTrabajadasText .= "\n";
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

                    // Formato de presentación más claro para mostrar que el puesto puede cambiar por día
                    $personalInfo = $personName . "\n" . "Puesto: " . $personRole . 
                                   ($fechaIngreso ? "\n(" . $fechaIngreso . ")" : "");

                    $data->push([
                        $rowNumber++,                                    // #
                        $personalInfo,                                  // Personal (con puesto específico del día)
                        $fechaIngreso,                                   // Fecha y hora de ingreso
                        $diaSemana,                                     // Día de la semana
                        $horasTrabajadasText,                           // Horas Trabajadas (formato con entradas/salidas)
                        $fechaSalida,                                    // Fecha y Hora de salida
                        $horasTrabajadas,                               // Horas Trabajadas (total)
                        number_format($factorDiario, 2),               // Pago por día
                        $horasExtras25,                                 // Horas Extras 25%
                        $horasExtras35,                                 // Horas Extras 35%
                        $horasFaltante,                                 // Horas Faltante
                        number_format($adelantos, 2),                   // Adelantos
                        number_format($consumosTotal, 2)                // Consumos total
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Error procesando registro individual en exportación', [
                        'record' => $record,
                        'error' => $e->getMessage(),
                        'line' => $e->getLine()
                    ]);
                    // Continuar con el siguiente registro en lugar de fallar completamente
                    continue;
                }
            }

            // ============ AGREGAR FILAS DE TOTALES ============
            
            // Calcular totales por persona
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
                            'pagoHorasNormales' => 0,
                            'pagoExtras25' => 0,
                            'pagoExtras35' => 0,
                            'totalPago' => 0,
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
                    
                    // CORRECCIÓN: Las horas faltantes se restan SOLO de las extras 25%
                    $minutosExtras25Final = $minutosExtras25 - $minutosFaltantes;
                    if ($minutosExtras25Final < 0) $minutosExtras25Final = 0;

                    // Calcular pago por hora basado en el factor diario (50 / 8 = 6.25)
                    $pagoPorHora = $factorDiario > 0 ? ($factorDiario / 8) : 0.00;
                    
                    // Calcular pagos detallados
                    $pagoHorasNormales = ($minutosTrabajadasBase / 60) * $pagoPorHora;
                    // CORRECCIÓN: Usar minutosExtras25Final (ya descontadas las faltantes)
                    $pagoExtras25 = ($minutosExtras25Final / 60) * ($pagoPorHora * 1.25);
                    // Las extras 35% no se ven afectadas por las faltantes
                    $pagoExtras35 = ($minutosExtras35 / 60) * ($pagoPorHora * 1.35);
                    $totalPago = $pagoHorasNormales + $pagoExtras25 + $pagoExtras35;

                    // Calcular "A COBRAR" = Total pago + adelantos - consumos
                    // YA NO restamos valor de horas faltantes porque ya se descontaron de extras 25%
                    $aCobrar = $totalPago + $adelantos - $consumos;

                    // Sumar a totales
                    $totalesPorPersona[$personName]['factorDiario'] += $factorDiario;
                    $totalesPorPersona[$personName]['horasTrabajadas'] += $minutosTrabajadasBase;
                    $totalesPorPersona[$personName]['horasExtras25'] += $minutosExtras25;
                    $totalesPorPersona[$personName]['horasExtras35'] += $minutosExtras35;
                    $totalesPorPersona[$personName]['horasFaltante'] += $minutosFaltantes;
                    $totalesPorPersona[$personName]['adelantos'] += $adelantos;
                    $totalesPorPersona[$personName]['consumos'] += $consumos;
                    $totalesPorPersona[$personName]['pagoHorasNormales'] += $pagoHorasNormales;
                    $totalesPorPersona[$personName]['pagoExtras25'] += $pagoExtras25;
                    $totalesPorPersona[$personName]['pagoExtras35'] += $pagoExtras35;
                    $totalesPorPersona[$personName]['totalPago'] += $totalPago;
                    $totalesPorPersona[$personName]['aCobrar'] += $aCobrar;
                    $totalesPorPersona[$personName]['dias']++;

                } catch (\Exception $e) {
                    Log::warning('Error calculando totales para persona', [
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

            // Agregar filas vacías de separación
            $data->push(['', '', '', '', '', '', '', '', '', '', '', '', '']);
            $data->push(['', '', '', '', '', '', '', '', '', '', '', '', '']);

            // Agregar filas de totales por persona
            foreach ($totalesPorPersona as $nombrePersona => $totales) {
                // Fila de TOTALES
                $data->push([
                    '',
                    'TOTALES - ' . $nombrePersona,
                    '',
                    '',
                    '',
                    '',
                    $minutesToTime($totales['horasTrabajadas']),
                    number_format($totales['factorDiario'], 2),
                    $minutesToTime($totales['horasExtras25']),
                    $minutesToTime($totales['horasExtras35']),
                    $minutesToTime($totales['horasFaltante']),
                    number_format($totales['adelantos'], 2),
                    number_format($totales['consumos'], 2)
                ]);

                // Fila de A COBRAR
                $data->push([
                    '',
                    'A COBRAR - ' . $nombrePersona,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    number_format($totales['aCobrar'], 2)
                ]);

                // Fila vacía de separación
                $data->push(['', '', '', '', '', '', '', '', '', '', '', '', '']);
            }

            //Log::info('Exportación completada exitosamente', ['total_rows' => $data->count()]);
            return $data;
            
        } catch (\Exception $e) {
            Log::error('Error general en exportación de Excel', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            // Retornar colección vacía en lugar de fallar
            return collect();
        }
    }

    public function headings(): array
    {
        return [
            '#',
            'Personal / Puesto del Día',
            'Fecha y hora de ingreso',
            'Día',
            'Horas Trabajadas',
            'Fecha y Hora de salida',
            'Horas Trabajadas',
            'Pago por día',
            'Horas Extras 25%',
            'Horas Extras 35%',
            'Horas Faltante',
            'Adelantos',
            'Consumos total'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        try {
            // Volver a 13 columnas originales (A..M)
            $sheet->mergeCells('A1:M1');
            $sheet->mergeCells('A2:F2');
            $sheet->mergeCells('G2:M2');
            $sheet->mergeCells('A3:F3');
            $sheet->mergeCells('G3:M3');

            // Información de la empresa y fechas
            $sheet->setCellValue('A1', 'Reporte de Personal con Totales');
            $sheet->setCellValue('A2', 'Empresa: ' . ($this->company->name ?? 'Sin nombre'));
            $sheet->setCellValue('G2', 'Reporte desde ' . (isset($this->d_start) ? Carbon::parse($this->d_start)->format('d-m-Y') : 'N/A') .
                          ' hasta ' . (isset($this->d_end) ? Carbon::parse($this->d_end)->format('d-m-Y') : 'N/A'));
            $sheet->setCellValue('A3', 'Ruc: ' . ($this->company->number ?? 'Sin RUC'));
            $sheet->setCellValue('G3', 'Fecha de generación: ' . Carbon::now()->format('d-m-Y H:i:s'));

            // Configurar altura de filas de manera segura
            $sheet->getDefaultRowDimension()->setRowHeight(35);
            
            // Altura específica para las filas de encabezado
            if (method_exists($sheet, 'getRowDimension')) {
                $sheet->getRowDimension('1')->setRowHeight(25);
                $sheet->getRowDimension('2')->setRowHeight(20);
                $sheet->getRowDimension('3')->setRowHeight(20);
                $sheet->getRowDimension('4')->setRowHeight(35); // Encabezados de columnas
            }

            // Configurar wrap text y alineación para columnas específicas
            $sheet->getStyle('B:B')->getAlignment()->setWrapText(true); // Personal
            $sheet->getStyle('B:B')->getAlignment()->setVertical('top');
            $sheet->getStyle('E:E')->getAlignment()->setWrapText(true); // Horas Trabajadas (formato) - ahora columna E
            $sheet->getStyle('E:E')->getAlignment()->setVertical('top');
            
            // Centrar columnas específicas
            $sheet->getStyle('A:A')->getAlignment()->setHorizontal('center'); // #
            $sheet->getStyle('D:D')->getAlignment()->setHorizontal('center'); // Día de la semana
            $sheet->getStyle('G:M')->getAlignment()->setHorizontal('center'); // Datos numéricos

            // Configurar ancho de columnas para las 13 columnas originales
            if (method_exists($sheet, 'getColumnDimension')) {
                $sheet->getColumnDimension('A')->setWidth(5);   // # 
                $sheet->getColumnDimension('B')->setWidth(20);  // Personal
                $sheet->getColumnDimension('C')->setWidth(16);  // Fecha ingreso
                $sheet->getColumnDimension('D')->setWidth(12);  // Día de la semana
                $sheet->getColumnDimension('E')->setWidth(25);  // Horas Trabajadas (formato)
                $sheet->getColumnDimension('F')->setWidth(16);  // Fecha salida
                $sheet->getColumnDimension('G')->setWidth(12);  // Horas Trabajadas (total)
                $sheet->getColumnDimension('H')->setWidth(12);  // Pago por día
                $sheet->getColumnDimension('I')->setWidth(12);  // Horas Extras 25%
                $sheet->getColumnDimension('J')->setWidth(12);  // Horas Extras 35%
                $sheet->getColumnDimension('K')->setWidth(12);  // Horas Faltante
                $sheet->getColumnDimension('L')->setWidth(12);  // Adelantos
                $sheet->getColumnDimension('M')->setWidth(14);  // Consumos total (un poco más ancho para A COBRAR)
            }

            // Resaltar la columna final para A COBRAR con color diferente
            $sheet->getStyle('M:M')->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setRGB('FFE5B4'); // Color crema para destacar

            // Resaltar las filas de TOTALES y A COBRAR con colores especiales
            $lastRow = $sheet->getHighestRow();
            for ($row = 5; $row <= $lastRow; $row++) {
                $cellValue = $sheet->getCell('B' . $row)->getValue();
                if (strpos($cellValue, 'TOTALES -') === 0) {
                    $sheet->getStyle('A' . $row . ':M' . $row)->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                          ->getStartColor()->setRGB('E6F3FF'); // Azul claro para totales
                    $sheet->getStyle('A' . $row . ':M' . $row)->getFont()->setBold(true);
                } elseif (strpos($cellValue, 'A COBRAR -') === 0) {
                    $sheet->getStyle('A' . $row . ':M' . $row)->getFill()
                          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                          ->getStartColor()->setRGB('E6FFE6'); // Verde claro para A COBRAR
                    $sheet->getStyle('A' . $row . ':M' . $row)->getFont()->setBold(true);
                }
            }

            // Estilos básicos y seguros
            return [
                1 => [
                    'font' => ['bold' => true, 'size' => 14], 
                    'alignment' => ['horizontal' => 'center'], 
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E0E0E0']]
                ],
                2 => [
                    'font' => ['bold' => true, 'size' => 11], 
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F0F0F0']]
                ],
                3 => [
                    'font' => ['bold' => true, 'size' => 11], 
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F0F0F0']]
                ],
                4 => [
                    'font' => ['bold' => true, 'size' => 10], 
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'], 
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D0D0D0']]
                ]
            ];
            
        } catch (\Exception $e) {
            Log::error('Error al aplicar estilos en Excel export', [
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            
            // Retornar estilos básicos si hay error
            return [
                1 => ['font' => ['bold' => true]],
                4 => ['font' => ['bold' => true]]
            ];
        }
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function chunkSize(): int
    {
        return 500; // Reducir el tamaño del chunk para evitar timeouts
    }

    public function download($filename)
    {
        return Excel::download($this, $filename);
    }
}
