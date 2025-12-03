<?php

namespace App\Http\Controllers\Tenant;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Exports\CreditListExport;
use App\Exports\StaffWorkerExport;
use App\Exports\StaffWorkerPdfExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tenant\CreditListCollection;
use App\Http\Resources\Tenant\CreditListPersonCollection;
use App\Http\Resources\Tenant\StaffPersonCollection;
use App\Http\Resources\Tenant\StaffPersonWorkerCollection;
use App\Imports\PersonWorkerImport;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\CreditList;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\InventoryKardex;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemPromotion;
use App\Models\Tenant\ItemSet;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\JobPosition;
use App\Models\Tenant\Payment;
use App\Models\Tenant\Person;
use App\Models\Tenant\PersonAttendance;
use App\Models\Tenant\Series;
use App\Models\Tenant\User;
use App\Models\Tenant\Warehouse;
use App\Models\Tenant\WorkerAdvance;
use App\Models\Tenant\WorkerConsumption;
use App\Models\Tenant\WorkerDailySummari;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Restaurant\Models\Orden;
use Modules\Restaurant\Models\OrdenItem;
use Modules\Restaurant\Models\Table;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Restobar\Events\OrdenEvent;
use Modules\Restobar\Events\PrintEvent;
use Modules\Restobar\Models\Area;
use Modules\Restobar\Models\Food;
use Maatwebsite\Excel\Excel;
use Modules\Restobar\Models\OrderItemDetail;

class StaffController extends Controller
{
    public function download(Request $request)
    {
        $company = Company::first();
        $records = $this->getData($request)->get();
        $person = Person::find($request->person_id);
        return (new CreditListExport)
            ->records($records)
            ->person($person)
            ->company($company)
            ->download('Lista_de_credito_' . Carbon::now() . '.xlsx');
    }

    public function adelanto(Request $request)
    {

        $person_id = $request->input('person_id');
        $amount = $request->input('amount');
        $method = $request->input('method');
        $date_time_advances = $request->input('date_time_advances');

        $create = WorkerAdvance::create([
            'person_id' => $person_id,
            'amount' => $amount,
            'method' => $method,
            'date_time_advance' => $date_time_advances ?? now()
        ]);

        return response()->json([
            'success' => true,
            'data' => $create
        ]);
    }

    /* public function importPerson(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        if ($request->hasFile('file')) {
            try {
                $import = new PersonWorkerImport();
                $import->import($request->file('file'), null, Excel::XLSX);
                $data = $import->getData();
                $errors = $import->getErrors();
                return [
                    'success' => true,
                    'message' =>  __('app.actions.upload.success'),
                    'data' => $data,
                    'errors' => $errors
                ];
            } catch (Exception $e) {
                return [
                    'success' => false,
                    'message' =>  $e->getMessage()
                ];
            }
        }

        
        return [
            'success' => false,
            'message' =>  __('app.actions.upload.error'),
        ];
    } */

    public function importPerson(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');

                $response = \Illuminate\Support\Facades\Http::attach(
                    'archivo',
                    fopen($file->getPathname(), 'r'),
                    $file->getClientOriginalName()
                )->post('https://sdrclientes.shop/biometrico/procesar');

                // Log del status y cuerpo de la respuesta
                Log::info('API Response Status: ' . $response->status());
                Log::info('API Response Body: ' . $response->body());

                // Decodificar la respuesta JSON de FastAPI
                $result = $response->json();

                Log::info('importPerson parsed result: ' . json_encode($result));

                // Verificar si la respuesta tiene datos
                if (!isset($result['rows']) || empty($result['rows'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontraron registros en el archivo procesado',
                        'debug' => [
                            'status' => $response->status(),
                            'response' => $result
                        ]
                    ]);
                }

                // Procesar los registros
                DB::beginTransaction();

                $registered = 0;
                $errors = [];

                Log::info('Total de registros recibidos del API: ' . count($result['rows']));

                foreach ($result['rows'] as $index => $row) {
                    try {
                        Log::info("Procesando fila {$index}: " . json_encode($row));

                        // Verificar que existan los campos requeridos
                        if (!isset($row['dni'])) {
                            $errors[] = "Fila {$index}: Falta el campo 'dni'";
                            Log::warning("Fila {$index}: Falta el campo 'dni'", ['row' => $row]);
                            continue;
                        }

                        if (!isset($row['ingreso']) || !isset($row['hora_ingreso'])) {
                            $errors[] = "Fila {$index}: Faltan campos de ingreso para DNI {$row['dni']}";
                            Log::warning("Fila {$index}: Faltan campos de ingreso", ['row' => $row]);
                            continue;
                        }

                        // Buscar la persona por DNI (number)
                        $person = Person::where('number', $row['dni'])->first();

                        if (!$person) {
                            $errors[] = "No se encontró persona con DNI: {$row['dni']}";
                            Log::warning("No se encontró persona con DNI: {$row['dni']}");
                            continue;
                        }

                        Log::info("Persona encontrada: ID={$person->id}, Nombre={$person->name}");

                        // Crear registro de INGRESO
                        try {
                            $ingreso = Carbon::parse($row['ingreso']);
                            $attendanceIngreso = PersonAttendance::create([
                                'person_id' => $person->id,
                                'date_time_attendance' => $ingreso->format('Y-m-d H:i:s'),
                                'date_attendance' => $ingreso->format('Y-m-d'),
                                'time_attendance' => $row['hora_ingreso'],
                                'type' => 'INGRESO',
                                'biometrico' => $row['biometrico'] ?? null,
                            ]);
                            $registered++;
                            Log::info("INGRESO registrado correctamente: ID={$attendanceIngreso->id}");
                        } catch (Exception $e) {
                            $errors[] = "Error al crear INGRESO para DNI {$row['dni']}: " . $e->getMessage();
                            Log::error("Error al crear INGRESO: " . $e->getMessage(), [
                                'row' => $row,
                                'person_id' => $person->id
                            ]);
                        }

                        // Crear registro de SALIDA si existe
                        if (!empty($row['salida']) && !empty($row['hora_salida'])) {
                            try {
                                $salida = Carbon::parse($row['salida']);
                                $attendanceSalida = PersonAttendance::create([
                                    'person_id' => $person->id,
                                    'date_time_attendance' => $salida->format('Y-m-d H:i:s'),
                                    'date_attendance' => $salida->format('Y-m-d'),
                                    'time_attendance' => $row['hora_salida'],
                                    'type' => 'SALIDA',
                                    'biometrico' => $row['biometrico'] ?? null,
                                ]);
                                $registered++;
                                Log::info("SALIDA registrada correctamente: ID={$attendanceSalida->id}");
                            } catch (Exception $e) {
                                $errors[] = "Error al crear SALIDA para DNI {$row['dni']}: " . $e->getMessage();
                                Log::error("Error al crear SALIDA: " . $e->getMessage(), [
                                    'row' => $row,
                                    'person_id' => $person->id
                                ]);
                            }
                        } else {
                            Log::info("No se registró SALIDA (datos vacíos o nulos) para DNI {$row['dni']}");
                        }
                    } catch (Exception $e) {
                        $errors[] = "Error general al procesar DNI " . ($row['dni'] ?? 'desconocido') . ": " . $e->getMessage();
                        Log::error("Error general procesando registro: " . $e->getMessage(), [
                            'row' => $row,
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }

                Log::info("Proceso completado. Registros insertados: {$registered}");

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Archivo procesado correctamente',
                    'data' => [
                        'total_rows' => count($result['rows']),
                        'registered' => $registered,
                        'rows' => $result['rows'] ?? [],
                        'summary' => $result['summary'] ?? [],
                    ],
                    'errors' => $errors
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('importPerson error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No se ha enviado ningún archivo'
        ]);
    }

    /* public function importPersonDat(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        
        $request->validate([
            'file' => 'required|file|mimes:dat,txt'
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();

            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            $total = count($lines);
            $registered = 0;
            $errors = [];
            $groups = [];

            // Procesar cada línea del archivo .dat
            foreach ($lines as $lineIndex => $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // Dividir la línea por espacios
                $data = preg_split('/\s+/', $line);
                
                if (count($data) < 2) {
                    $errors[] = "Línea {$lineIndex}: Formato incorrecto - {$line}";
                    continue;
                }

                $number = isset($data[0]) ? trim((string)$data[0]) : null;
                $dateTimeString = isset($data[1]) ? $data[1] : null;
                
                // Si hay más partes, puede ser fecha y hora separadas
                if (isset($data[2])) {
                    $dateTimeString .= ' ' . $data[2];
                }

                if (empty($number) || empty($dateTimeString)) {
                    $errors[] = "Línea {$lineIndex}: Datos vacíos o incompletos - number={$number} datetime={$dateTimeString}";
                    continue;
                }

                try {
                    // Intentar parsear la fecha/hora
                    $carbon = Carbon::parse($dateTimeString);
                } catch (Exception $e) {
                    $errors[] = "Línea {$lineIndex}: No se pudo parsear la fecha para number={$number} datetime={$dateTimeString} - " . $e->getMessage();
                    continue;
                }

                $date_time = $carbon->format('Y-m-d H:i:s');
                $date_only = $carbon->format('Y-m-d');
                $time_only = $carbon->format('H:i:s');

                // Buscar la persona por número
                $person = Person::where('number', $number)->first();
                if (!$person) {
                    $errors[] = "Línea {$lineIndex}: No se encontró persona con number={$number}";
                    continue;
                }

                // Agrupar por persona
                $groups[$person->id][] = [
                    'person_id' => $person->id,
                    'date_time' => $date_time,
                    'date_attendance' => $date_only,
                    'time_attendance' => $time_only,
                    'carbon' => $carbon,
                ];
            }

            // Procesar cada grupo (por persona), ordenar por datetime y emparejar cronológicamente
            foreach ($groups as $person_id => $marks) {
                // Ordenar por timestamp para asegurar orden cronológico correcto
                usort($marks, function ($a, $b) {
                    $ta = isset($a['carbon']) ? $a['carbon']->getTimestamp() : strtotime($a['date_time']);
                    $tb = isset($b['carbon']) ? $b['carbon']->getTimestamp() : strtotime($b['date_time']);
                    return $ta <=> $tb;
                });

                // Filtrar marcas duplicadas con lógica mejorada
                $filtered = [];
                $duplicateToleranceMinutes = 60; // Tolerancia de 60 minutos para manejar marcas repetitivas

                foreach ($marks as $m) {
                    if (empty($filtered)) {
                        $filtered[] = $m;
                        continue;
                    }

                    $last = end($filtered);
                    if (isset($last['carbon']) && isset($m['carbon'])) {
                        $diff = $last['carbon']->diffInMinutes($m['carbon']);
                    } else {
                        try {
                            $lastDt = Carbon::parse($last['date_time']);
                            $curDt = Carbon::parse($m['date_time']);
                            $diff = $lastDt->diffInMinutes($curDt);
                        } catch (Exception $e) {
                            $diff = $duplicateToleranceMinutes + 1;
                        }
                    }

                    if ($diff <= $duplicateToleranceMinutes) {
                        $errors[] = "Marca duplicada eliminada person_id={$m['person_id']} datetime={$m['date_time']} (diferencia {$diff} minutos)";
                        continue;
                    }

                    $filtered[] = $m;
                }

                $marks = array_values($filtered);

                // Agrupar marcas por día laboral considerando turnos nocturnos de manera inteligente
                $dailyGroups = [];
                
                for ($i = 0; $i < count($marks); $i++) {
                    $mark = $marks[$i];
                    $dt = $mark['carbon'];
                    $hour = $dt->hour;
                    $dateStr = $dt->format('Y-m-d');
                    
                    if ($hour >= 9 && $hour <= 18) {
                        // 09:00-18:59: Turno diurno - usar fecha actual
                        $workDay = $dateStr;
                    } elseif ($hour >= 19) {
                        // 19:00-23:59: Inicio de turno nocturno - usar fecha actual
                        $workDay = $dateStr;
                    } else {
                        // 00:00-08:59: Marcas de madrugada - necesitamos analizar el contexto
                        
                        // Buscar si hay una entrada nocturna en el mismo día O en días cercanos
                        $hasNightEntryToday = false;
                        $hasNightEntryYesterday = false;
                        
                        $yesterday = $dt->copy()->subDay()->format('Y-m-d');
                        
                        foreach ($marks as $otherMark) {
                            $otherDate = $otherMark['carbon']->format('Y-m-d');
                            $otherHour = $otherMark['carbon']->hour;
                            
                            // Verificar entrada nocturna el mismo día
                            if ($otherDate === $dateStr && $otherHour >= 19 && $otherHour <= 23) {
                                $hasNightEntryToday = true;
                            }
                            
                            // Verificar entrada nocturna el día anterior
                            if ($otherDate === $yesterday && $otherHour >= 19 && $otherHour <= 23) {
                                $hasNightEntryYesterday = true;
                            }
                        }
                        
                        // Lógica de asignación mejorada:
                        if ($hasNightEntryYesterday && !$hasNightEntryToday) {
                            // Si hay entrada nocturna ayer pero no hoy, esta marca pertenece al turno de ayer
                            $workDay = $yesterday;
                        } elseif ($hasNightEntryToday && !$hasNightEntryYesterday) {
                            // Si hay entrada nocturna hoy pero no ayer, esta marca pertenece al turno de hoy
                            $workDay = $dateStr;
                        } elseif ($hasNightEntryYesterday && $hasNightEntryToday) {
                            // Si hay entradas nocturnas tanto ayer como hoy, usar proximidad temporal
                            // Buscar cuál entrada nocturna está más cerca de esta marca de madrugada
                            $closestToYesterday = null;
                            $closestToToday = null;
                            
                            foreach ($marks as $otherMark) {
                                $otherDate = $otherMark['carbon']->format('Y-m-d');
                                $otherHour = $otherMark['carbon']->hour;
                                
                                if ($otherDate === $yesterday && $otherHour >= 19 && $otherHour <= 23) {
                                    if (!$closestToYesterday || $otherMark['carbon']->isAfter($closestToYesterday)) {
                                        $closestToYesterday = $otherMark['carbon'];
                                    }
                                }
                                
                                if ($otherDate === $dateStr && $otherHour >= 19 && $otherHour <= 23) {
                                    if (!$closestToToday || $otherMark['carbon']->isBefore($closestToToday)) {
                                        $closestToToday = $otherMark['carbon'];
                                    }
                                }
                            }
                            
                            // Calcular diferencias temporales
                            $diffToYesterday = $closestToYesterday ? abs($closestToYesterday->diffInHours($dt)) : 999;
                            $diffToToday = $closestToToday ? abs($closestToToday->diffInHours($dt)) : 999;
                            
                            // Asignar al turno más cercano temporalmente
                            $workDay = ($diffToYesterday <= $diffToToday) ? $yesterday : $dateStr;
                        } else {
                            // Si no hay entradas nocturnas cerca, asumir que es salida del día anterior
                            $workDay = $yesterday;
                        }
                    }
                    
                    $dailyGroups[$workDay][] = $mark;
                }

                // Procesar cada día laboral por separado
                foreach ($dailyGroups as $workDay => $dayMarks) {
                    // Ordenar por hora
                    usort($dayMarks, function ($a, $b) {
                        return $a['carbon']->getTimestamp() <=> $b['carbon']->getTimestamp();
                    });

                    $this->processDailyMarks($dayMarks, $workDay, $errors, $registered);
                }
            }

            return [
                'success' => true,
                'message' => __('app.actions.upload.success'),
                'data' => compact('total', 'registered'),
                'errors' => $errors
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
 */
    /**
     * Procesa las marcas de un día laboral específico
     */
    private function processDailyMarks($dayMarks, $workDay, &$errors, &$registered)
    {
        $count = count($dayMarks);

        // Si solo hay una marca, determinar si es entrada o salida basado en la hora y contexto
        if ($count == 1) {
            $mark = $dayMarks[0];
            $hour = $mark['carbon']->hour;

            // Lógica mejorada para determinar tipo basado en horarios típicos:
            // Horarios más probables de ENTRADA: 09:00-12:00, 19:00-23:59
            // Horarios más probables de SALIDA: 00:00-08:59, 13:00-18:59
            // PERO también considerar que puede haber entradas tardías o salidas tempranas

            if (($hour >= 7 && $hour <= 12) || ($hour >= 19 && $hour <= 23)) {
                $type = 'INGRESO'; // Probablemente entrada
            } else {
                $type = 'SALIDA'; // Probablemente salida
            }

            // Para marcas únicas, usar el workDay que ya fue calculado correctamente en el agrupamiento
            $singleMarkDate = $workDay;

            try {
                PersonAttendance::create([
                    'person_id' => $mark['person_id'],
                    'date_time_attendance' => $mark['date_time'],
                    'date_attendance' => $singleMarkDate,
                    'time_attendance' => $mark['time_attendance'],
                    'type' => $type,
                ]);
                $registered++;
            } catch (Exception $e) {
                $errors[] = "Error al crear marca única para person_id={$mark['person_id']} datetime={$mark['date_time']}: " . $e->getMessage();
            }
            return;
        }

        // Para múltiples marcas, emparejarlas inteligentemente usando patrón alternado
        $this->smartPairMarks($dayMarks, $workDay, $errors, $registered);
    }

    /**
     * Empareja marcas de forma inteligente usando patrón alternado INGRESO-SALIDA
     */
    private function smartPairMarks($dayMarks, $workDay, &$errors, &$registered)
    {
        $count = count($dayMarks);

        // Procesar marcas secuencialmente usando patrón alternado
        for ($i = 0; $i < $count; $i++) {
            $currentMark = $dayMarks[$i];

            // Determinar el tipo basado en la posición en la secuencia
            // Primera marca = INGRESO, segunda = SALIDA, tercera = INGRESO, etc.
            $isEntrance = ($i % 2 == 0); // Posición par = entrada, impar = salida
            $type = $isEntrance ? 'INGRESO' : 'SALIDA';

            // Validación adicional basada en horarios para corregir si es necesario
            $hour = $currentMark['carbon']->hour;

            // Si es la primera marca y está en horario de salida típico, podría ser una salida
            if ($i == 0 && $hour >= 0 && $hour <= 8) {
                // Primera marca en horario de madrugada - probablemente es salida del turno anterior
                $type = 'SALIDA';
                $isEntrance = false;
            }

            // Si es posición impar pero está en horario de entrada típico, mantener como entrada
            if (!$isEntrance && (($hour >= 7 && $hour <= 12) || ($hour >= 19 && $hour <= 23))) {
                // Esta marca parece ser entrada aunque esté en posición impar
                // Podría indicar que falta una salida anterior
                $type = 'INGRESO';
            }

            try {
                PersonAttendance::create([
                    'person_id' => $currentMark['person_id'],
                    'date_time_attendance' => $currentMark['date_time'],
                    'date_attendance' => $workDay,
                    'time_attendance' => $currentMark['time_attendance'],
                    'type' => $type,
                ]);
                $registered++;
            } catch (Exception $e) {
                $errors[] = "Error al crear marca para person_id={$currentMark['person_id']} datetime={$currentMark['date_time']}: " . $e->getMessage();
            }
        }
    }

    /**
     * Crea un par de registros de entrada y salida
     */
    private function createAttendancePair($entryMark, $exitMark, $workDay, &$errors, &$registered)
    {
        try {
            // Crear registro de ingreso
            PersonAttendance::create([
                'person_id' => $entryMark['person_id'],
                'date_time_attendance' => $entryMark['date_time'],
                'date_attendance' => $workDay,
                'time_attendance' => $entryMark['time_attendance'],
                'type' => 'INGRESO',
            ]);
            $registered++;

            // Para registros emparejados, ambos usan el mismo workDay calculado en el agrupamiento
            // Esto asegura que entrada y salida del mismo turno tengan la misma fecha de asistencia

            // Crear registro de salida
            PersonAttendance::create([
                'person_id' => $exitMark['person_id'],
                'date_time_attendance' => $exitMark['date_time'],
                'date_attendance' => $workDay,
                'time_attendance' => $exitMark['time_attendance'],
                'type' => 'SALIDA',
            ]);
            $registered++;
        } catch (Exception $e) {
            $errors[] = "Error al crear par entrada-salida para person_id={$entryMark['person_id']}: " . $e->getMessage();
        }
    }


    /**
     * Update only the job position for a person (partial update).
     * Expects: person_id, job_position_id (nullable)
     */
    public function updateJobPosition(Request $request)
    {
        try {
            $record = WorkerDailySummari::find($request->input('worker_daily_summary_id'));
            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Registro diario no encontrado'], 404);
            }

            $record->job_position_id = $request->input('job_position_id') ?? null;
            $record->save();

            return response()->json(['success' => true, 'data' => $record]);
        } catch (\Exception $e) {
            Log::error('updateJobPosition error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar el cargo diario'], 500);
        }
    }

    public function receipt($id)
    {
        $credit_list = CreditList::find($id);
        $customer = $credit_list->customer;
        $user = $credit_list->seller;
        $orden = $credit_list->orden;
        $total = $orden->getTotal();
        $observation = $credit_list->observation;
        $company = Company::first();
        $count_items = $orden->orden_items->count();


        $height = 10  * 30;
        if ($count_items > 8) {
            $height = $count_items * 30;
        }
        try {
            $pdf = PDF::loadView('restaurant::credit_list.receipt', compact(
                "credit_list",
                "customer",
                "observation",
                "user",
                "orden",
                "total",
                "company",
            ))
                ->setPaper(array(0, 0, 249.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function recordByPersonToPay(Request $request)
    {
        $request['paid'] = "0";
        $orden_items = $this->getData($request);
        $records = $orden_items->get();
        return [
            'success' => true,
            'records' => $records,
        ];
    }
    public function recordByPersonTotal(Request $request)
    {
        try {
            $data = $this->getData($request);
            // Verificar si $data es un objeto y obtener los resultados
            if (is_object($data)) {
                // Realizar las operaciones necesarias con los resultados
                $total = $data->get()->sum(function ($row) {
                    return $row->quantity * $row->price;
                });

                return [
                    'success' => true,
                    'total' => $total,
                ];
            } else {
                throw new \Exception('La función getData() no devolvió un objeto válido.');
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function generarResumenAsistencias(Request $request)
    {
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        $empleados = Person::where('is_staff', true)->whereNotNull('job_position_id')->get();
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay()->addDay();

        foreach ($empleados as $empleado) {

            $registros = PersonAttendance::where('person_id', $empleado->id)
                ->where(function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('date_time_attendance', [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()])
                        ->orWhereBetween(DB::raw("CONCAT(date_attendance, ' ', COALESCE(time_attendance, '00:00:00'))"), [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()]);
                })
                ->orderBy('date_time_attendance')
                ->get();

            $marks = $registros->map(function ($r) {
                if (!empty($r->date_time_attendance)) {
                    $dt = Carbon::parse($r->date_time_attendance);
                } elseif (!empty($r->time_attendance) && !empty($r->date_attendance)) {
                    $dt = Carbon::parse($r->date_attendance . ' ' . $r->time_attendance);
                } else {
                    return null;
                }
                return [
                    'dt' => $dt,
                    'type' => isset($r->type) ? strtolower($r->type) : null,
                    'raw' => $r,
                ];
            })->filter()->values();

            $filtered = [];
            foreach ($marks as $m) {
                if (empty($filtered)) {
                    $filtered[] = $m;
                    continue;
                }
                $last = end($filtered);
                $diffSeconds = $last['dt']->diffInSeconds($m['dt']);
                if ($diffSeconds <= 5 && $last['type'] === $m['type']) {
                    continue;
                }
                $filtered[] = $m;
            }

            $pairsByDate = [];
            $unpairedByDate = [];
            $i = 0;
            $count = count($filtered);
            while ($i < $count) {
                $start = $filtered[$i];
                $end = null;
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($start['type'] && strpos($start['type'], 'ing') !== false) {
                        if (isset($filtered[$j]['type']) && strpos($filtered[$j]['type'], 'sal') !== false) {
                            $end = $filtered[$j];
                            $i = $j + 1;
                            break;
                        }
                    } else {
                        $end = $filtered[$j];
                        $i = $j + 1;
                        break;
                    }
                }

                if ($end === null) {
                    $dateKey = $start['dt']->toDateString();
                    $unpairedByDate[$dateKey] = true;
                    if (!isset($pairsByDate[$dateKey])) {
                        $pairsByDate[$dateKey] = ['minutes' => 0, 'pairs' => []];
                    }
                    $pairsByDate[$dateKey]['pairs'][] = [
                        'entrance' => $start['dt']->format('H:i'),
                        'exit' => null,
                        'minutes' => 0,
                        'exit_date' => null,
                    ];
                    $i++;
                    continue;
                }

                $endDt = $end['dt'];
                $startDt = $start['dt'];
                if ($endDt->lt($startDt)) {
                    $endDt = $endDt->copy()->addDay();
                }

                $dateKey = $startDt->toDateString();
                if (!isset($pairsByDate[$dateKey])) {
                    $pairsByDate[$dateKey] = ['minutes' => 0, 'pairs' => []];
                }
                $minutes = $startDt->diffInMinutes($endDt);
                $pairsByDate[$dateKey]['minutes'] += $minutes;
                $pairsByDate[$dateKey]['pairs'][] = [
                    'entrance' => $startDt->format('H:i'),
                    'exit' => $endDt->format('H:i'),
                    'minutes' => $minutes,
                    'exit_date' => $endDt->toDateString(),
                ];
            }

            foreach ($pairsByDate as $fecha => $data) {
                $workedMinutes = $data['minutes'];
                $horasTrabajadas = $workedMinutes / 60;

                $pairs_array = $data['pairs'] ?? [];

                $fecha_salida = $fecha;
                if (!empty($pairs_array)) {
                    $lastPair = end($pairs_array);
                    if (!empty($lastPair['exit_date'])) {
                        $fecha_salida = $lastPair['exit_date'];
                    }
                }

                $horasExtras = max(0, $horasTrabajadas - 8);

                $monthlySalary = 0.0;
                if (isset($empleado->base_salary)) {
                    $monthlySalary = (float) $empleado->base_salary;
                } elseif (isset($empleado->{'base-salary'})) {
                    $monthlySalary = (float) $empleado->{'base-salary'};
                } elseif (isset($empleado->salary)) {
                    $monthlySalary = (float) $empleado->salary;
                }
                $horaBase = $monthlySalary / 30 / 8;

                $montoExtra = 0;
                if ($horasExtras > 0 && $horaBase > 0) {
                    if ($horasExtras <= 2) {
                        $montoExtra = $horasExtras * $horaBase * 1.25;
                    } else {
                        $montoExtra = (2 * $horaBase * 1.25) + (($horasExtras - 2) * $horaBase * 1.35);
                    }
                }
                $falta = ($horasTrabajadas < 8);
                $minutesMissing = 0;
                if ($falta) {
                    $minutesMissing = max(0, 480 - $workedMinutes);
                }

                WorkerDailySummari::updateOrCreate(
                    [
                        'person_id' => $empleado->id,
                        'date_daily' => $fecha
                    ],
                    [
                        'pairs' => $pairs_array,
                        'entrance' => null,
                        'exit' => null,
                        'job_position_id' => $empleado->job_position_id,
                        'horas_trabajadas' => gmdate('H:i', $workedMinutes * 60),
                        'overtime' => round($horasExtras, 2),
                        'amount_extra' => round($montoExtra, 2),
                        'lack' => $falta,
                        'date_end_daily' => $fecha_salida,
                        'extra_time_two' => gmdate('H:i', ($horasExtras > 2 ? 2 : $horasExtras) * 3600),
                        'extra_time_three' => gmdate('H:i', ($horasExtras > 2 ? $horasExtras - 2 : 0) * 3600),
                        'lack_time' => $falta ? gmdate('H:i', $minutesMissing * 60) : null,
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Resumen diario generado correctamente'
        ]);
    }

    public function getRecords(Request $request)
    {
        Log::info('getRecords called with request: ' . json_encode($request->all()));

        $waTable = (new WorkerAdvance)->getTable();
        $wdTable = (new WorkerDailySummari)->getTable();
        $wcTable = (new WorkerConsumption)->getTable();

        // SUBQUERY DE ADELANTOS
        $advancesSub = DB::connection('tenant')->table($waTable)
            ->select(
                "{$waTable}.person_id",
                DB::raw("DATE({$waTable}.date_time_advance) as adv_date"),
                DB::raw("SUM({$waTable}.amount) as advances_sum")
            )
            ->groupBy("{$waTable}.person_id", DB::raw("DATE({$waTable}.date_time_advance)"));

        // SUBQUERY DE CONSUMOS
        $consumptionsSub = DB::connection('tenant')->table($wcTable)
            ->select(
                "{$wcTable}.person_id",
                DB::raw("DATE({$wcTable}.date_time_consumption) as cons_date"),
                DB::raw("SUM({$wcTable}.amount) as consumptions_sum")
            )
            ->groupBy("{$wcTable}.person_id", DB::raw("DATE({$wcTable}.date_time_consumption)"));

        // QUERY PRINCIPAL
        $query = WorkerDailySummari::with(['person.job_position', 'job_position'])

            // JOIN ADELANTOS
            ->leftJoinSub($advancesSub, 'wa', function ($join) use ($wdTable) {
                $join->on("{$wdTable}.person_id", '=', 'wa.person_id')
                    ->on("{$wdTable}.date_daily", '=', 'wa.adv_date');
            })

            // JOIN CONSUMOS
            ->leftJoinSub($consumptionsSub, 'wc', function ($join) use ($wdTable) {
                $join->on("{$wdTable}.person_id", '=', 'wc.person_id')
                    ->on("{$wdTable}.date_daily", '=', 'wc.cons_date');
            })

            ->select(
                "{$wdTable}.*",
                DB::raw("COALESCE(wa.advances_sum, 0) as advances"),
                DB::raw("COALESCE(wc.consumptions_sum, 0) as consumptions")
            )

            ->whereHas('person', function ($q) {
                $q->where('is_staff', true);
            });

        // FILTROS QUE YA TIENES
        if ($request->filled('person_id')) {
            $query->where("{$wdTable}.person_id", $request->person_id);
        }

        if ($request->filled('date_day')) {
            $query->whereDate("{$wdTable}.date_daily", $request->date_day);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = Carbon::parse($request->from_date)->format('Y-m-d');
            $to = Carbon::parse($request->to_date)->format('Y-m-d');
            $query->whereBetween("{$wdTable}.date_daily", [$from, $to]);
        }

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear("{$wdTable}.date_daily", $year)
                ->whereMonth("{$wdTable}.date_daily", $month);
        }

        if ($request->filled('date')) {
            $dateVal = $request->date;

            if (preg_match('/^\d{4}-\d{2}-00$/', $dateVal)) {
                $dateVal = substr($dateVal, 0, 7);
            }

            if (preg_match('/^\d{4}-\d{2}$/', $dateVal)) {
                [$y, $m] = explode('-', $dateVal);
                $query->whereYear("{$wdTable}.date_daily", $y)
                    ->whereMonth("{$wdTable}.date_daily", $m);
            } else {
                $query->whereDate("{$wdTable}.date_daily", $dateVal);
            }
        }

        return $query->orderBy("{$wdTable}.date_daily", 'desc');
    }


    public function recordsWorker(Request $request)
    {
        $records = $this->getRecords($request);

        return new StaffPersonWorkerCollection($records->paginate(20));
    }

    public function ExportExcel(Request $request)
    {
        $company = Company::first();
        $records = $this->getRecords($request)->get();
        return (new StaffWorkerExport)
            ->records($records)
            ->company($company)
            ->download('Lista_de_personal_' . Carbon::now() . '.xlsx');
    }

    public function ExportPdf(Request $request)
    {
        $company = Company::first();
        $establishment = Establishment::first();
        $records = $this->getRecords($request)->get();

        return (new StaffWorkerPdfExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->dateRange($request->d_start, $request->d_end)
            ->download('Lista_de_personal_' . Carbon::now() . '.pdf');
    }

    public function recordByPerson(Request $request)
    {

        $ordens = $this->getData($request);
        $ordens = $ordens->orderBy('date', 'asc');
        return new StaffPersonCollection($ordens->get());
    }
    public function staff_report_index(Request $request)
    {

        return view('tenant.staff.index');
    }

    private function updateStock($item_id, $quantity, $warehouse_id)
    {
        $configuration = Configuration::firstOrFail();

        if ($configuration->college) {

            $item_warehouse = ItemWarehouse::where('item_id', $item_id)->first();
            if (!isset($item_warehouse)) {
                $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
            }
        } else {

            $item_warehouse = ItemWarehouse::firstOrNew(['item_id' => $item_id, 'warehouse_id' => $warehouse_id]);
        }

        $old_stock = $item_warehouse->stock;
        $item_warehouse->stock = $item_warehouse->stock + $quantity;

        if ($quantity < 0 && $item_warehouse->item->unit_type_id !== 'ZZ') {
            if (($configuration->sales_stock) && ($item_warehouse->stock < 0)) {

                throw new Exception("El producto {$item_warehouse->item->description} no tiene suficiente stock!");
            }
        }

        $item_warehouse->save();
        //Log::info('ItemWarehouse saved successfully');
        // $item-save();
    }
    function findWarehouse()
    {
        $warehouse = Warehouse::where('establishment_id', auth()->user()->establishment_id)->first();
        if (!$warehouse) {
            $warehouse = Warehouse::create([
                'description' => 'Almacén',
                'establishment_id' => auth()->user()->establishment_id,
            ]);
        }
        return $warehouse;
    }
    function createInventoryKardex($item_id, $quantity, $warehouse_id, $credit_list)
    {
        //Log::info('createInventoryKardex called with item_id: ' . $item_id . ', quantity: ' . $quantity . ', warehouse_id: ' . $warehouse_id);

        $kardex = InventoryKardex::create([
            'inventory_kardexable_id' => $credit_list->id,
            'inventory_kardexable_type' => 'App\Models\Tenant\CreditList',
            'item_id' => $item_id,
            'date_of_issue' => date('Y-m-d'),
            'warehouse_id' => $warehouse_id,
            'quantity' => $quantity,
            'type' => 'output',
            'user_id' => isset(auth()->user()->id) ? auth()->user()->id : null,
        ]);

        //Log::info('InventoryKardex created successfully with ID: ' . $kardex->id);
    }

    function update_stock($credit_list)
    {
        Log::info('update_stock called for CreditList ID: ' . $credit_list->id);
        $orden = Orden::find($credit_list->orden_id);
        $items = $orden->orden_items;
        $warehouse = $this->findWarehouse();

        foreach ($items as $orden_item) {
            $food_id = $orden_item->food_id;
            $quantity = $orden_item->quantity * -1;
            $food = Food::find($food_id);
            $item_id = $food->item_id;
            $item = Item::find($item_id);
            $promotion_count = ItemPromotion::where('item_id', $item_id)->count();
            $set_components_count = ItemSet::where('item_id', $item_id)->count();

            if ($item->unit_type_id !== 'ZZ') {
                $has_real_promotions = $promotion_count > 0;

                // 1️⃣ Item normal (no es set ni promoción)
                if (!$item->is_set && !$has_real_promotions) {
                    $this->createInventoryKardex($item_id, $quantity, $warehouse->id, $credit_list);
                    $this->updateStock($item_id, $quantity, $warehouse->id);
                } elseif ($item->is_set) {
                    $item_sets = ItemSet::where('item_id', $item_id)->get();

                    if ($item_sets->count() == 0) {
                        $this->createInventoryKardex($item_id, $quantity, $warehouse->id, $credit_list);
                        $this->updateStock($item_id, $quantity, $warehouse->id);
                    } else {
                        foreach ($item_sets as $set_item) {
                            $total_quantity = $set_item->quantity * $orden_item->quantity * -1;
                            $this->createInventoryKardex($set_item->individual_item_id, $total_quantity, $warehouse->id, $credit_list);
                            try {
                                $this->updateStock($set_item->individual_item_id, $total_quantity, $warehouse->id);
                            } catch (Exception $e) {
                                Log::error('updateStock error for set component: ' . $e->getMessage());
                                throw $e;
                            }
                        }
                    }

                    // 3️⃣ Item de promoción
                } elseif ($has_real_promotions) {
                    $promotion_items = ItemPromotion::where('item_id', $item_id)->get();

                    foreach ($promotion_items as $promo_item) {
                        $promo_item_obj = Item::find($promo_item->promotion_item_id);
                        $promo_quantity = isset($promo_item->quantity) ? floatval($promo_item->quantity) : 1;

                        if ($promo_item_obj && $promo_item_obj->is_set) {
                            $set_items = ItemSet::where('item_id', $promo_item_obj->id)->get();
                            foreach ($set_items as $set_item) {
                                $total_quantity = $set_item->quantity * $promo_quantity * $orden_item->quantity * -1;
                                $this->createInventoryKardex($set_item->individual_item_id, $total_quantity, $warehouse->id, $credit_list);
                                try {
                                    $this->updateStock($set_item->individual_item_id, $total_quantity, $warehouse->id);
                                } catch (Exception $e) {
                                    throw $e;
                                }
                            }
                        } else {
                            $total_quantity = $promo_quantity * $orden_item->quantity * -1;

                            $this->createInventoryKardex($promo_item_obj->id, $total_quantity, $warehouse->id, $credit_list);
                            try {
                                $this->updateStock($promo_item_obj->id, $total_quantity, $warehouse->id);
                            } catch (Exception $e) {
                                //Log::error('updateStock error for promo item: ' . $e->getMessage());
                                throw $e;
                            }
                        }
                    }
                } else {
                    $this->createInventoryKardex($item_id, $quantity, $warehouse->id, $credit_list);
                    $this->updateStock($item_id, $quantity, $warehouse->id);
                }
            }
        }
    }

    public function send_credit(Request $request)
    {
        $configuration = Configuration::firstOrFail();
        $cash_id = $request->cash_id;
        try {
            DB::beginTransaction();
            $customer_id = $request->customer_id;
            $ref = $request->ref;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $request->items;
            $user_id = auth()->id();
            $table_caja_id = Table::get_caja();
            $table_caja = Table::find($table_caja_id);
            $table_caja->status_table_id = 2;
            $table_caja->save();
            $status_orden_id = 1;
            $orden = Orden::create([
                'table_id' => $table_caja_id,
                'status_orden_id' => $status_orden_id,
                'date' => date('Y-m-d'),
                'ref' => $customer_name . ' - ' . $ref,
            ]);
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];

            foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();

                // Agregamos la primera área (del item principal)
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];

                // Procesar promoción (si aplica)
                $promotion_items = $item['promotion_items']
                    ?? $item['food']['promotion_items']
                    ?? $item['food']['item']['promotion_items']
                    ?? null;

                if (!empty($promotion_items)) {
                    if ($promotion_items instanceof \Illuminate\Support\Collection) {
                        $promotion_items = $promotion_items->toArray();
                    }

                    foreach ($promotion_items as $p_item) {
                        $detail_item_id = $p_item['item']['id']
                            ?? $p_item['id']
                            ?? $p_item['item_id']
                            ?? null;

                        $detail_description = $p_item['description']
                            ?? ($p_item['item']['description'] ?? ($p_item['name'] ?? null));

                        $detail_quantity = $p_item['quantity']
                            ?? ($p_item['item_quantity'] ?? ($p_item['quantity_item'] ?? 1));

                        $detail_quantity_final = $detail_quantity * (float) $orden_item->quantity;

                        $area_id_for_detail = data_get($p_item, 'item.area_id')
                            ?? optional(Item::find($detail_item_id))->area_id
                            ?? $orden_item->area_id;

                        $user_id_for_detail = $user_id;

                        OrderItemDetail::create([
                            'orden_item_id' => $orden_item->id,
                            'item_id' => $detail_item_id,
                            'description' => $detail_description,
                            'quantity' => $detail_quantity_final,
                            'area_id' => $area_id_for_detail,
                            'user_id' => $user_id_for_detail,
                        ]);

                        $orden_items_ids_for_kitchen[] = [
                            "orden_id" => $orden_item->id,
                            "area_id" => $area_id_for_detail
                        ];
                    }
                }

                $orden_items_ids[] = $orden_item->id;

                // Disparar evento por item
                event(new OrdenEvent($orden_item->id));
            }

            $print_box = $configuration->print_commands;
            $print_kitchen = $configuration->print_kitchen;
            if ($print_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                }
            }

            $credit_list =  CreditList::create([
                'cash_id' => $cash_id,
                'orden_id' => $orden->id,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'establishment_id' => auth()->user()->establishment_id,
                'observation' => $request->ref,
                'paid' => false,
            ]);
            $worker_consumptions =  WorkerConsumption::create([
                'person_id' => $customer_id,
                'amount' => $orden->getTotal(),
                'date_time_consumption' => now(),
                'obervation' => $request->ref,
            ]);

            Log::info("CreditList creado con ID:4ertetertertertert", $credit_list->toArray());
            $this->update_stock($credit_list);

            //Log::info("Intentando imprimir crédito para CreditList ID DAFSDFSDFSDFDF: {$credit_list->id}");

            event(new PrintEvent($credit_list->id, 'S', true, null, []));
            sleep(1);
            event(new PrintEvent($credit_list->id, 'S', true, null, []));

            DB::commit();

            return [
                'success' => true,
                'message' => 'Credito enviado correctamente'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function send_credit_restobar(Request $request)
    {
        $configuration = Configuration::firstOrFail();
        $cash_id = $request->cash_id;
        try {
            DB::beginTransaction();
            $customer_id = $request->customer_id;
            $ref = $request->ref;
            $customer = Person::find($customer_id);
            $customer_name = $customer->name;
            $items = $request->items;
            $user_id = auth()->id();
            $table_caja_id = Table::get_caja();
            $table_caja = Table::find($table_caja_id);
            $table_caja->status_table_id = 2;
            $table_caja->save();
            $status_orden_id = 1;
            $orden = Orden::create([
                'table_id' => $table_caja_id,
                'status_orden_id' => $status_orden_id,
                'date' => date('Y-m-d'),
                'ref' => $customer_name . ' - ' . $ref,
            ]);
            $orden_items_ids = [];
            $orden_items_ids_for_kitchen = [];
            foreach ($items as $item) {
                $orden_item = new OrdenItem;
                $orden_item->food_id = $item['food']['id'];
                $orden_item->observations = $item['observation'] ?? '-';
                $orden_item->quantity = $item['quantity'];
                $orden_item->unit_type_id = Functions::valueKeyInArray($item, 'type_id', null);
                $orden_item->price = $item['price'];
                $orden_item->user_id = $user_id;
                $orden_item->orden_id = $orden->id;
                $orden_item->to_carry = Functions::valueKeyInArray($item, 'to_carry', 0);
                $orden_item->status_orden_id = 1;
                $orden_item->date = Carbon::today();
                $orden_item->time = date('H:i:s');
                $orden_item->area_id = $item['food']['area_id'];
                $orden_item->save();
                $orden_items_ids[] = $orden_item->id;
                $orden_items_ids_for_kitchen[] = [
                    "orden_id" => $orden_item->id,
                    "area_id" => $orden_item->area_id
                ];
                event(new OrdenEvent($orden_item->id));
            }
            $print_box = $configuration->print_commands;
            $print_kitchen = $configuration->print_kitchen;
            if ($print_kitchen) {
                $ids_areas = array_unique(array_column($orden_items_ids_for_kitchen, "area_id"));
                foreach ($ids_areas as $area_id) {
                    $filtered = array_column(array_filter($orden_items_ids_for_kitchen, function ($a) use ($area_id) {
                        return $area_id == $a['area_id'];
                    }), "orden_id");
                    event(new PrintEvent($orden->id, "0", true, $area_id, $filtered));
                }
            }
            // $isFromBox = $this->isArea("CAJ", $user->area_id);

            if ($print_box) {
                // event(new PrintEvent($orden->id, "0", true, $this->getBoxArea(), $orden_items_ids));
            }
            $credit_list =  CreditList::create([
                'cash_id' => $cash_id,
                'orden_id' => $orden->id,
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'establishment_id' => auth()->user()->establishment_id,
                'observation' => $request->ref,
                'paid' => false,
            ]);
            $this->update_stock($credit_list);

            event(new PrintEvent($credit_list->id, 'S', true, null, []));
            sleep(1);
            event(new PrintEvent($credit_list->id, 'S', true, null, []));

            DB::commit();

            return [
                'success' => true,
                'message' => 'Credito enviado correctamente'
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        // $orden_id = $request->orden_id;
    }
    function getBoxArea()
    {
        $establishment_id = auth()->user()->establishment_id;
        $user_box = User::whereHas('area', function ($query) {
            $query->where('description', 'like', '%CAJ%');
        })->where('establishment_id', $establishment_id)->first();
        if ($user_box) {
            $area_box = $user_box->area;
            return $area_box->id;
        }
        $area_box = Area::where('description', 'like', '%CAJ%')->first();

        if ($area_box != null) {
            return $area_box->id;
        }
        return null;
    }
    public function tables()
    {
        $persons = Person::where('is_staff', 1)->select('id', 'name')->get();
        $establishments = Establishment::all();
        $job_positions = JobPosition::all();
        /* $series = Series::all(); */
        return [
            'success' => true,
            /* 'printers' => $printers, */
            'establishments' => $establishments,
            'persons' => $persons,
            'job_positions' => $job_positions,
            /* 'series' => $series, */
        ];
    }
    public function records(Request $request)
    {
        $value = $request->value;
        //saca los registros que tengan paid en false pero agrupados por customer_id
        $credit_lists = CreditList::select('customer_id', DB::raw('count(*) as count'));
        if ($value) {
            $credit_lists = $credit_lists->whereHas('customer', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%")
                    ->orWhere('number', 'like', "%{$value}%");
            });
        }
        $credit_lists =            $credit_lists->where('paid', false)
            ->groupBy('customer_id');

        return new CreditListCollection($credit_lists->paginate(config('tenant.items_per_page')));
    }
    public function get_ordens($customer_id)
    {
        $credit_lists = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return [
                        'id' => $ordenItem->id,
                        'food' => $ordenItem->food,
                        'observations' => $ordenItem->observations,
                        'quantity' => $ordenItem->quantity,
                        'unit_type_id' => $ordenItem->unit_type_id,
                        'price' => $ordenItem->price,
                        'user_id' => $ordenItem->user_id,
                        'orden_id' => $ordenItem->orden_id,
                        'to_carry' => $ordenItem->to_carry,
                        'status_orden_id' => $ordenItem->status_orden_id,
                        'date' => $ordenItem->date,
                        'time' => $ordenItem->time,
                        'area_id' => $ordenItem->area_id,
                    ];
                });
            });

        return $credit_lists;
    }
    public function get_balance($customer_id)
    {
        $balance = CreditList::where('customer_id', $customer_id)
            ->where('paid', false)
            ->with(['orden.orden_items'])
            ->get()
            ->flatMap(function ($creditList) {
                return $creditList->orden->orden_items->map(function ($ordenItem) {
                    return $ordenItem->quantity * $ordenItem->price;
                });
            })
            ->sum();

        return $balance;
    }
}
