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
use App\Models\Tenant\Schedule;
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
use Illuminate\Support\Facades\Http;
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

    public function importPerson(Request $request)
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
    }

    /* public function importPerson(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');

                $response = Http::withoutVerifying()->attach(
                    'archivo',
                    fopen($file->getPathname(), 'r'),
                    $file->getClientOriginalName()
                )->post('https://sdrclientes.shop/biometrico/procesar');


                Log::info('API Response Status: ' . $response->status());
                Log::info('API Response Body: ' . $response->body());

                $result = $response->json();

                // Verificar si la respuesta es exitosa y tiene datos
                if (!isset($result['success']) || !$result['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error en la respuesta del API',
                        'debug' => [
                            'status' => $response->status(),
                            'response' => $result
                        ]
                    ]);
                }

                if (!isset($result['data']) || empty($result['data'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontraron registros en el archivo procesado',
                        'total' => $result['total'] ?? 0
                    ]);
                }

                DB::beginTransaction();

                $registered = 0;
                $errors = [];
                $dataArray = $result['data'];

                Log::info('Total de registros recibidos del API: ' . count($dataArray));

                foreach ($dataArray as $index => $record) {
                    try {
                        // Verificar campos requeridos (según la nueva estructura)
                        if (!isset($record['person_id']) || !isset($record['datetime'])) {
                            $errors[] = "Registro {$index}: Faltan campos requeridos (person_id o datetime)";
                            continue;
                        }

                        // El person_id que viene del API es el DNI
                        $dni = $record['person_id'];
                        $person = Person::where('number', $dni)->first();

                        if (!$person) {
                            $errors[] = "No se encontró persona con DNI: {$dni}";
                            continue;
                        }

                        // Insertar el registro sin determinar el tipo (INGRESO/SALIDA)
                        // El tipo se determinará después con otro método según schedules
                        $attendance = PersonAttendance::create([
                            'person_id' => $person->id,
                            'date_time_attendance' => $record['datetime'],
                            'date_attendance' => $record['date'] ?? Carbon::parse($record['datetime'])->format('Y-m-d'),
                            'time_attendance' => $record['time'] ?? Carbon::parse($record['datetime'])->format('H:i:s'),
                            'type' => null, // Se determinará después
                        ]);

                        $registered++;

                        if ($index < 5) {
                            Log::info("Registro {$index} insertado: ID={$attendance->id}, PersonID={$person->id}, DNI={$dni}, DateTime={$record['datetime']}");
                        }
                    } catch (Exception $e) {
                        $dni = $record['person_id'] ?? 'desconocido';
                        $errors[] = "Error al procesar DNI {$dni}: " . $e->getMessage();
                        Log::error("Error al insertar registro: " . $e->getMessage(), [
                            'record' => $record
                        ]);
                    }
                }

                Log::info("Proceso completado. Registros insertados: {$registered}");

                DB::commit();

                // Llamar al método para determinar tipos de asistencia
                $typeResponse = $this->dateTypeAttendance($request);
                $typeResult = $typeResponse->getData();

                return response()->json([
                    'success' => true,
                    'message' => 'Archivo procesado correctamente',
                    'data' => [
                        'total' => $result['total'] ?? count($dataArray),
                        'registered' => $registered,
                        'errors_count' => count($errors),
                        'types_processed' => $typeResult->processed ?? 0,
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
    } */


    public function dateTypeAttendance(Request $request)
    {
        try {
            DB::beginTransaction();

            // Obtener todas las marcas sin tipo, ordenadas por persona y fecha
            $attendances = PersonAttendance::whereNull('type')
                ->orderBy('person_id')
                ->orderBy('date_time_attendance')
                ->get();

            if ($attendances->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'No hay marcas pendientes de procesar',
                    'processed' => 0
                ]);
            }

            // Agrupar por persona
            $groupedByPerson = $attendances->groupBy('person_id');
            $processed = 0;
            $errors = [];

            foreach ($groupedByPerson as $personId => $personAttendances) {
                // Obtener TODOS los horarios configurados para esta persona
                $schedules = Schedule::where('person_id', $personId)
                    ->orderBy('entrada')
                    ->get();
                
                if ($schedules->isEmpty()) {
                    $errors[] = "No se encontró horario configurado para person_id: {$personId}";
                    continue;
                }

                // Agrupar las marcas por día laboral
                $groupedByDay = [];

                foreach ($personAttendances as $attendance) {
                    $dt = Carbon::parse($attendance->date_time_attendance);
                    
                    // Si la hora es entre 00:00 y 06:59, pertenece al día laboral anterior
                    if ($dt->hour < 7) {
                        $workDay = $dt->copy()->subDay()->format('Y-m-d');
                    } else {
                        $workDay = $dt->format('Y-m-d');
                    }

                    if (!isset($groupedByDay[$workDay])) {
                        $groupedByDay[$workDay] = [];
                    }

                    $groupedByDay[$workDay][] = [
                        'id' => $attendance->id,
                        'dt' => $dt,
                        'time' => $dt->format('H:i:s'),
                    ];
                }

                // Procesar cada día laboral
                foreach ($groupedByDay as $workDay => $dayMarks) {
                    // Ordenar las marcas por hora
                    usort($dayMarks, function($a, $b) {
                        return $a['dt']->timestamp <=> $b['dt']->timestamp;
                    });

                    $count = count($dayMarks);
                    
                    // Variable para rastrear el tipo esperado siguiente
                    $expectedNextType = 'INGRESO'; // Primer marca del día debería ser INGRESO
                    $lastType = null;
                    $lastMarkDateTime = null;

                    // Procesar cada marca considerando el contexto y secuencia
                    for ($i = 0; $i < $count; $i++) {
                        $mark = $dayMarks[$i];
                        
                        // Buscar el tipo basándose en el horario más cercano y contexto
                        $type = $this->determineTypeByScheduleWithContext(
                            $mark['dt'], 
                            $schedules, 
                            $workDay, 
                            $i,
                            $expectedNextType
                        );

                        PersonAttendance::where('id', $mark['id'])->update(['type' => $type]);
                        $processed++;
                        
                        // Guardar última marca y tipo
                        $lastType = $type;
                        $lastMarkDateTime = $mark['dt'];
                        
                        // Actualizar el tipo esperado para la siguiente marca
                        $expectedNextType = ($type === 'INGRESO') ? 'SALIDA' : 'INGRESO';
                    }
                    
                    // VERIFICAR SI FALTA MARCA DE SALIDA
                    // Si la última marca del día es INGRESO, crear una SALIDA automática después de 8 horas
                    if ($lastType === 'INGRESO' && $lastMarkDateTime !== null) {
                        $this->createAutoExitIfNeeded(
                            $personId, 
                            $lastMarkDateTime, 
                            $workDay, 
                            $schedules,
                            $processed,
                            $errors
                        );
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tipos de asistencia asignados correctamente',
                'processed' => $processed,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('dateTypeAttendance error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar tipos de asistencia: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Crea una marca de salida automática si es necesaria
     * Se activa cuando hay INGRESO pero no hay SALIDA
     */
    private function createAutoExitIfNeeded($personId, $lastIngressDateTime, $workDay, $schedules, &$processed, &$errors)
    {
        try {
            Log::info("Verificando salida automática: person_id={$personId}, workDay={$workDay}, lastIngress={$lastIngressDateTime->format('Y-m-d H:i:s')}");
            
            // Verificar que no exista ya una marca de salida DESPUÉS del ingreso en ese día
            $existingExit = PersonAttendance::where('person_id', $personId)
                ->where('date_attendance', $workDay)
                ->where('type', 'SALIDA')
                ->where('time_attendance', '>', $lastIngressDateTime->format('H:i:s'))
                ->first();
            
            if ($existingExit) {
                Log::info("Ya existe salida para person_id={$personId} en {$workDay}: {$existingExit->time_attendance}");
                return;
            }
            
            // Calcular salida estimada: 8 horas después del ingreso
            $estimatedExit = $lastIngressDateTime->copy()->addHours(8);
            
            // Buscar el horario de salida más cercano en los schedules
            $closestScheduleExit = null;
            $minDiff = PHP_INT_MAX;
            
            foreach ($schedules as $schedule) {
                $salidaCompare = Carbon::parse($workDay . ' ' . $schedule->salida);
                
                // Si la salida es antes de la entrada, es turno nocturno
                $salidaTime = Carbon::parse($schedule->salida);
                $entradaTime = Carbon::parse($schedule->entrada);
                if ($salidaTime->lt($entradaTime)) {
                    $salidaCompare->addDay();
                }
                
                $diff = abs($estimatedExit->diffInMinutes($salidaCompare));
                if ($diff < $minDiff) {
                    $minDiff = $diff;
                    $closestScheduleExit = $salidaCompare;
                }
            }
            
            // Decidir qué hora usar para la salida automática
            $autoExitDateTime = $estimatedExit;
            
            // Si hay un horario configurado cercano (menos de 1 hora de diferencia), usarlo
            if ($closestScheduleExit !== null && $minDiff <= 60) {
                $autoExitDateTime = $closestScheduleExit;
            }
            
            // Determinar la fecha de asistencia para la salida
            $exitWorkDay = $workDay;
            if ($autoExitDateTime->hour < 7) {
                // Si la salida es en la madrugada, mantiene la fecha del día laboral
                $exitWorkDay = $workDay;
            } elseif ($autoExitDateTime->format('Y-m-d') !== $workDay) {
                // Si la salida calculada cae en otro día (después de medianoche)
                $exitWorkDay = $autoExitDateTime->format('Y-m-d');
            }
            
            // Crear la marca de salida automática
            $newAttendance = PersonAttendance::create([
                'person_id' => $personId,
                'date_time_attendance' => $autoExitDateTime->format('Y-m-d H:i:s'),
                'date_attendance' => $exitWorkDay,
                'time_attendance' => $autoExitDateTime->format('H:i:s'),
                'type' => 'SALIDA',
                'biometrico' => 0, // Marcar como no biométrico (generado automáticamente)
            ]);
            
            $processed++;
            
            Log::info("✅ Salida automática creada: ID={$newAttendance->id}, person_id={$personId}, entrada={$lastIngressDateTime->format('Y-m-d H:i:s')}, salida={$autoExitDateTime->format('Y-m-d H:i:s')}");
            
        } catch (\Exception $e) {
            $errors[] = "Error al crear salida automática para person_id={$personId}: " . $e->getMessage();
            Log::error("createAutoExitIfNeeded error: " . $e->getMessage(), [
                'person_id' => $personId,
                'work_day' => $workDay,
                'last_ingress' => $lastIngressDateTime->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Determina el tipo de marca considerando contexto de secuencia y horarios
     */
    private function determineTypeByScheduleWithContext($markDateTime, $schedules, $workDay, $position, $expectedType)
    {
        $candidates = [];
        $isInAnyShift = false;
        
        foreach ($schedules as $schedule) {
            // Crear fechas comparables para entrada
            $entradaCompare = Carbon::parse($workDay . ' ' . $schedule->entrada);
            $diffEntrada = abs($markDateTime->diffInMinutes($entradaCompare));
            
            // Crear fechas comparables para salida
            $salidaCompare = Carbon::parse($workDay . ' ' . $schedule->salida);
            
            // Si la salida es antes de la entrada, es turno nocturno
            $salidaTime = Carbon::parse($schedule->salida);
            $entradaTime = Carbon::parse($schedule->entrada);
            if ($salidaTime->lt($entradaTime)) {
                $salidaCompare->addDay();
            }
            
            $diffSalida = abs($markDateTime->diffInMinutes($salidaCompare));
            
            // Determinar si está dentro de algún turno
            if ($markDateTime->between($entradaCompare, $salidaCompare)) {
                $isInAnyShift = true;
            }
            
            // Agregar candidato para ENTRADA
            $candidates[] = [
                'type' => 'INGRESO',
                'diff' => $diffEntrada,
                'schedule' => $schedule,
                'time' => $schedule->entrada,
                'entrada_compare' => $entradaCompare,
                'salida_compare' => $salidaCompare
            ];
            
            // Agregar candidato para SALIDA
            $candidates[] = [
                'type' => 'SALIDA',
                'diff' => $diffSalida,
                'schedule' => $schedule,
                'time' => $schedule->salida,
                'entrada_compare' => $entradaCompare,
                'salida_compare' => $salidaCompare
            ];
        }
        
        // Ordenar candidatos por diferencia (más cercano primero)
        usort($candidates, function($a, $b) {
            return $a['diff'] <=> $b['diff'];
        });
        
        $closest = $candidates[0];
        
        // REGLA 1: Marca muy cercana (≤ 30 minutos) - alta confianza
        if ($closest['diff'] <= 30) {
            return $closest['type'];
        }
        
        // REGLA 2: Marca cercana (≤ 90 minutos) y coincide con el tipo esperado
        if ($closest['diff'] <= 90 && $closest['type'] === $expectedType) {
            return $closest['type'];
        }
        
        // REGLA ESPECIAL: Si esperamos INGRESO pero la marca está ENTRE dos turnos
        // (después de una salida y antes de la próxima entrada), es SALIDA tardía
        if ($expectedType === 'INGRESO' && !$isInAnyShift) {
            // Buscar el turno anterior (su salida) y el siguiente turno (su entrada)
            $recentExit = null;
            $nextEntrance = null;
            
            foreach ($candidates as $c) {
                if ($c['type'] === 'SALIDA' && $markDateTime->gt($c['salida_compare'])) {
                    if ($recentExit === null || $c['diff'] < $recentExit['diff']) {
                        $recentExit = $c;
                    }
                }
                if ($c['type'] === 'INGRESO' && $markDateTime->lt($c['entrada_compare'])) {
                    if ($nextEntrance === null || $c['diff'] < $nextEntrance['diff']) {
                        $nextEntrance = $c;
                    }
                }
            }
            
            // Si la marca está entre una salida pasada y una entrada futura
            // y la salida pasada está dentro de 3 horas, es SALIDA tardía
            if ($recentExit !== null && $nextEntrance !== null && $recentExit['diff'] <= 180) {
                return 'SALIDA';
            }
        }
        
        // REGLA 3: Priorizar tipo esperado por secuencia si está razonablemente cerca
        $expectedCandidates = array_filter($candidates, function($c) use ($expectedType) {
            return $c['type'] === $expectedType;
        });
        
        if (!empty($expectedCandidates)) {
            usort($expectedCandidates, function($a, $b) {
                return $a['diff'] <=> $b['diff'];
            });
            
            $closestExpected = $expectedCandidates[0];
            
            if ($closestExpected['diff'] < $closest['diff'] || 
                ($closestExpected['diff'] <= 180 && $closest['diff'] > 60)) {
                return $closestExpected['type'];
            }
        }
        
        // REGLA 4: Si el candidato más cercano está razonablemente cerca (≤ 2 horas)
        if ($closest['diff'] <= 120) {
            return $closest['type'];
        }
        
        // REGLA 5: Como último recurso, usar el tipo esperado por secuencia
        return $expectedType;
    }

    /**
     * Determina el tipo de marca (INGRESO/SALIDA) basándose en los horarios configurados
     * Usa lógica inteligente considerando múltiples turnos
     * @deprecated Usar determineTypeByScheduleWithContext
     */
    private function determineTypeBySchedule($markDateTime, $schedules, $workDay, $position)
    {
        $candidates = [];
        
        foreach ($schedules as $schedule) {
            // Crear fechas comparables para entrada
            $entradaCompare = Carbon::parse($workDay . ' ' . $schedule->entrada);
            $diffEntrada = $markDateTime->diffInMinutes($entradaCompare, false); // false = con signo
            
            // Crear fechas comparables para salida
            $salidaCompare = Carbon::parse($workDay . ' ' . $schedule->salida);
            
            // Si la salida es antes de la entrada, es turno nocturno
            $salidaTime = Carbon::parse($schedule->salida);
            $entradaTime = Carbon::parse($schedule->entrada);
            if ($salidaTime->lt($entradaTime)) {
                $salidaCompare->addDay();
            }
            
            $diffSalida = $markDateTime->diffInMinutes($salidaCompare, false); // false = con signo
            
            // Agregar candidato para ENTRADA
            $candidates[] = [
                'type' => 'INGRESO',
                'diff' => abs($diffEntrada),
                'signed_diff' => $diffEntrada,
                'schedule' => $schedule,
                'time' => $schedule->entrada
            ];
            
            // Agregar candidato para SALIDA
            $candidates[] = [
                'type' => 'SALIDA',
                'diff' => abs($diffSalida),
                'signed_diff' => $diffSalida,
                'schedule' => $schedule,
                'time' => $schedule->salida
            ];
        }
        
        // Ordenar candidatos por diferencia absoluta (más cercano primero)
        usort($candidates, function($a, $b) {
            return $a['diff'] <=> $b['diff'];
        });
        
        // Obtener el candidato más cercano
        $closest = $candidates[0];
        
        // REGLA 1: Si está muy cerca (menos de 30 minutos), usar ese tipo sin dudas
        if ($closest['diff'] <= 30) {
            return $closest['type'];
        }
        
        // REGLA 2: Si está dentro de 2 horas del horario más cercano, usar ese tipo
        if ($closest['diff'] <= 120) {
            return $closest['type'];
        }
        
        // REGLA 3: Si está lejos de todos los horarios, usar patrón alternado
        // pero con lógica mejorada
        return ($position % 2 == 0) ? 'INGRESO' : 'SALIDA';
    }

    /**
     * Encuentra el tipo de marca (INGRESO/SALIDA) más cercano basado en los horarios configurados
     * @deprecated Usar determineTypeBySchedule en su lugar
     */
    private function findClosestScheduleType($markDateTime, $schedules, $workDay)
    {
        $minDiff = PHP_INT_MAX;
        $closestType = null;
        $tolerancia = 120; // 2 horas de tolerancia para considerar "cercano"

        foreach ($schedules as $schedule) {
            // Comparar con hora de ENTRADA
            $entradaCompare = Carbon::parse($workDay . ' ' . $schedule->entrada);
            $diffEntrada = abs($markDateTime->diffInMinutes($entradaCompare));
            
            if ($diffEntrada < $minDiff && $diffEntrada <= $tolerancia) {
                $minDiff = $diffEntrada;
                $closestType = 'INGRESO';
            }

            // Comparar con hora de SALIDA
            $salidaCompare = Carbon::parse($workDay . ' ' . $schedule->salida);
            
            // Si la salida es antes de la entrada, es turno nocturno
            $salidaTime = Carbon::parse($schedule->salida);
            $entradaTime = Carbon::parse($schedule->entrada);
            if ($salidaTime->lt($entradaTime)) {
                $salidaCompare->addDay();
            }
            
            $diffSalida = abs($markDateTime->diffInMinutes($salidaCompare));
            
            if ($diffSalida < $minDiff && $diffSalida <= $tolerancia) {
                $minDiff = $diffSalida;
                $closestType = 'SALIDA';
            }
        }

        // Solo retornar el tipo si está dentro de la tolerancia
        return ($minDiff <= $tolerancia) ? $closestType : null;
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
