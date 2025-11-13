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

        Log::info('Asignando registros para exportación Excel', ['records' => $records]);
        
        return $this;
    }
    
    public function company($company) {
        $this->company = $company;
        
        return $this;
    }

    /* public function person($person) {
        $this->person = $person;

        Log::info('Asignando persona para exportación Excel', ['person' => $person]);
        
        return $this;
    } */

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
        $data = collect();

        foreach ($this->records as $record) {
            // Resolve el nombre de la persona, puede venir como objeto `person`, como arreglo `person` o como campo plano `person_name`.
            $personName = '';
            if (isset($record->person)) {
                $person = $record->person;
                $personName = isset($person->name) ? $person->name : ($person['name'] ?? '');
            } else {
                $personName = isset($record->person_name) ? $record->person_name : ($record['person_name'] ?? '');
            }

            $dateDaily = isset($record->date_daily) ? $record->date_daily : ($record['date_daily'] ?? '');
            $entrance = isset($record->entrance) ? $record->entrance : ($record['entrance'] ?? '');
            $exit = isset($record->exit) ? $record->exit : ($record['exit'] ?? '');
            $horas = isset($record->horas_trabajadas) ? $record->horas_trabajadas : ($record['horas_trabajadas'] ?? '');
            $overtime = isset($record->overtime) ? $record->overtime : ($record['overtime'] ?? '');
            $amountExtra = isset($record->amount_extra) ? $record->amount_extra : ($record['amount_extra'] ?? '');
            $lack = isset($record->lack) ? $record->lack : ($record['lack'] ?? '');
            $dateEnd = isset($record->date_end_daily) ? $record->date_end_daily : ($record['date_end_daily'] ?? '');
            $pairsRaw = isset($record->pairs) ? $record->pairs : ($record['pairs'] ?? []);

            // Normalize pairs to array of arrays with keys entrance, exit, minutes, exit_date
            $normalizedPairs = collect($pairsRaw)->map(function ($p) {
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
            })->values();

            // total minutes from pairs
            $totalMinutes = $normalizedPairs->reduce(function ($carry, $p) {
                $m = isset($p['minutes']) && is_numeric($p['minutes']) ? (int) $p['minutes'] : 0;
                return $carry + $m;
            }, 0);

            // format minutes to HH:MM:SS
            $formatMinutesToTime = function ($minutes) {
                if ($minutes === null || $minutes === '') return '';
                $h = floor($minutes / 60);
                $m = $minutes % 60;
                return sprintf('%02d:%02d:00', $h, $m);
            };

            $tHoras = $formatMinutesToTime($totalMinutes);
            $hn_decimal = $totalMinutes > 0 ? round($totalMinutes / 60, 2) : ($horas !== '' ? round((float) $horas, 2) : 0);

            // get first entrance and last exit if available
            $firstEntrance = '';
            $lastExit = '';
            if ($normalizedPairs->isNotEmpty()) {
                $first = $normalizedPairs->first();
                $last = $normalizedPairs->last();
                $firstEntrance = $first['entrance'] ?? '';
                $lastExit = $last['exit'] ?? '';
            }

            // pairs JSON (raw)
            $pairsJson = empty($pairsRaw) ? '' : json_encode($pairsRaw, JSON_UNESCAPED_UNICODE);

            // created_at / updated_at fallbacks
            $createdAt = isset($record->created_at) ? $record->created_at : ($record['created_at'] ?? '');
            $updatedAt = isset($record->updated_at) ? $record->updated_at : ($record['updated_at'] ?? '');

            // day name in Spanish from date_daily
            $dayName = '';
            try {
                if (!empty($dateDaily)) {
                    $d = Carbon::parse($dateDaily);
                    $map = [1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado',7=>'Domingo'];
                    $dayName = $map[(int)$d->format('N')];
                }
            } catch (\Exception $e) {
                $dayName = '';
            }

            $data->push([
                // best-effort columns to match the sample image / pasted rows
                'id' => isset($record->id) ? $record->id : ($record['id'] ?? ''),
                'person_id' => isset($record->person_id) ? $record->person_id : ($record['person_id'] ?? ''),
                'area_id' => isset($record->area_id) ? $record->area_id : ($record['area_id'] ?? ''),
                'turn' => isset($record->turn) ? $record->turn : ($record['turn'] ?? ''),
                'weekday' => $dayName,
                'entrance' => $firstEntrance,
                'exit' => $lastExit,
                't_horas' => $tHoras,
                '+hn_f' => $hn_decimal,
                's' => $amountExtra !== '' ? round((float) $amountExtra, 2) : null,
                'extra_2h_amount' => isset($record->extra_2h_amount) ? $record->extra_2h_amount : ($record['extra_2h_amount'] ?? ''),
                'extra_2h_time' => isset($record->extra_2h_time) ? $record->extra_2h_time : ($record['extra_2h_time'] ?? ''),
                'extra_3h_amount' => isset($record->extra_3h_amount) ? $record->extra_3h_amount : ($record['extra_3h_amount'] ?? ''),
                'extra_3h_time' => isset($record->extra_3h_time) ? $record->extra_3h_time : ($record['extra_3h_time'] ?? ''),
                'faltante' => is_numeric($lack) ? $formatMinutesToTime((int)$lack) : ($lack ?: ''),
                /* 'created_at' => $createdAt,
                'updated_at' => $updatedAt, */
                'date_daily' => $dateDaily,
                'date_end_daily' => $dateEnd,
                /* 'pairs_json' => $pairsJson, */
                'tardanza' => isset($record->tardanza) ? $record->tardanza : ($record['tardanza'] ?? ''),
                'ausencia' => isset($record->ausencia) ? $record->ausencia : ($record['ausencia'] ?? ''),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'id',
            'person_id',
            'area_id',
            'Turno',
            'Dia',
            'Ingreso',
            'Salida',
            'T. HORAS',
            '+HN (F)',
            'S/',
            '+ 2H 25% (S/)',
            '2H tiempo',
            '+ 3H 35% (S/)',
            '3H tiempo',
            ' horas faltante',
            'fecha ingreso',
            'fecha salida',
            'tardanza',
            'ausencia',  
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el título y la información de la empresa
        // Ajustado a 10 columnas (A..J)
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('F2:J2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('F3:J3');

        // Información de la empresa y fechas
        $sheet->setCellValue('A1', 'Reporte de Personal');
        $sheet->setCellValue('A2', 'Empresa: ' . ($this->company->name ?? ''));
        $sheet->setCellValue('F2', 'Reporte desde ' . (isset($this->d_start) ? Carbon::parse($this->d_start)->format('d-m-Y') : '') .
                      ' hasta ' . (isset($this->d_end) ? Carbon::parse($this->d_end)->format('d-m-Y') : ''));
        $sheet->setCellValue('A3', 'Ruc: ' . ($this->company->number ?? ''));
        $sheet->setCellValue('F3', '');

        // Estilos generales
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            2 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            3 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]],
            4 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DCDCDC']]]
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function download($filename)
    {
        return Excel::download($this, $filename);
    }
}
