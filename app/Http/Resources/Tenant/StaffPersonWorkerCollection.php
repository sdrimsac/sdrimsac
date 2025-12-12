<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\CreditList;
use App\Models\Tenant\Person;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;


class StaffPersonWorkerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($row) {
            return [
                'id' => $row->id,
                'person_id' => $row->person_id,
                'person_name' => optional($row->person)->name,
                'date_daily' => $row->date_daily,
                'entrance' => $row->entrance,
                'exit' => $row->exit,
                'horas_trabajadas' => $this->formatHoursMinutes($row->horas_trabajadas),
                'overtime' => $row->overtime,
                'amount_extra' => $row->amount_extra,
                'lack' => $row->lack,
                'date_end_daily' => $row->date_end_daily,
                'pairs' => $row->pairs,
                'extra_time_two' => $this->formatHoursMinutes($row->extra_time_two),
                'extra_time_three' => $this->formatHoursMinutes($row->extra_time_three),
                'lack_time' => $this->formatHoursMinutes($row->lack_time),
                'job_position' => optional($row->job_position)->name,
                'factor_diario' => optional($row->job_position)->factor_diario,
                'advances' => (float) ($row->advances ?? 0),
                'advances_methods' => $row->advances_methods,
                'worker_advances' => (float) ($row->worker_advances ?? $row->advances ?? 0),
                'amount' => $row->amount,
                'consumptions' => $row->consumptions,
            ];
        });
    }

    /**
     * Convierte tiempo HH:MM:SS a formato de minutos totales o HH:MM
     * Cambia el return según prefieras:
     * - Para formato HH:MM: return sprintf('%02d:%02d', $hours, $minutes);
     * - Para solo minutos: return $totalMinutes . ' min';
     */
    private function formatHoursMinutes($time)
    {
        if (empty($time)) {
            return $time;
        }

        // Si el tiempo ya está en formato HH:MM, lo devuelve tal como está
        if (substr_count($time, ':') == 1) {
            return $time;
        }

        // Separar horas, minutos y segundos
        $parts = explode(':', $time);
        if (count($parts) < 3) {
            return $time;
        }

        $hours = (int) $parts[0];
        $minutes = (int) $parts[1];
        $seconds = (int) $parts[2];

        // Calcular minutos totales
        $totalMinutes = ($hours * 60) + $minutes;
        
        // Redondear los segundos a minutos si son >= 30 segundos
        if ($seconds >= 30) {
            $totalMinutes++;
        }

        // Opción 1: Mostrar como HH:MM
        $finalHours = floor($totalMinutes / 60);
        $finalMinutes = $totalMinutes % 60;
        return sprintf('%02d:%02d', $finalHours, $finalMinutes);

        // Opción 2: Descomentar esta línea si prefieres solo mostrar minutos
        // return $totalMinutes . ' min';
    }
}