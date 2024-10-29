<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehiculoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $historial_id = null;
            $historial = $row->historiales()->latest()->first();
            if ($historial) {
                $historial_id = $historial->id;
            }
            return [
                'id' => $row->id,
                'historial_id' => $historial_id,
                'customer_id' => $row->customer_id,
                'customer_name' => $row->customer ? $row->customer->name : null,
                'tipo_vehiculo_id' => $row->tipo_vehiculo_id,
                'tipo_vehiculo_description' => $row->tipo_vehiculo ? $row->tipo_vehiculo->description : null,
                'marca' => $row->marca,
                'modelo' => $row->modelo,
                'anio_fabricacion' => $row->anio_fabricacion,
                'placa' => $row->placa,
                'kilometraje' => $row->kilometraje,
                'active' => $row->active,
                'serie' => $row->serie,
                'color' => $row->color,
                'motor' => $row->motor,
                'created_at' => $row->created_at->format('d-m-Y H:i'),
                'chasis' => $row->chasis,
                'date_soat_due' => $row->date_soat_due,
                'date_check_due' => $row->date_check_due,
                'quantity_front_lights' => $row->quantity_front_lights,
                'state_front_lights' => $row->state_front_lights,
                'quantity_directional_lights_front' => $row->quantity_directional_lights_front,
                'state_directional_lights_front' => $row->state_directional_lights_front,
                'quantity_directional_lights_back' => $row->quantity_directional_lights_back,
                'state_directional_lights_back' => $row->state_directional_lights_back,
                'quantity_hazard_lights' => $row->quantity_hazard_lights,
                'state_hazard_lights' => $row->state_hazard_lights,
                'quantity_wiper_washer_arm' => $row->quantity_wiper_washer_arm,
                'state_wiper_washer_arm' => $row->state_wiper_washer_arm,
                'quantity_gasoil_cap' => $row->quantity_gasoil_cap,
                'state_gasoil_cap' => $row->state_gasoil_cap,
                'quantity_radio_antenna' => $row->quantity_radio_antenna,
                'state_radio_antenna' => $row->state_radio_antenna,
                'quantity_side_mirrors' => $row->quantity_side_mirrors,
                'state_side_mirrors' => $row->state_side_mirrors,
                'quantity_test_handles' => $row->quantity_test_handles,
                'state_test_handles' => $row->state_test_handles,
                'quantity_alarm' => $row->quantity_alarm,
                'state_alarm' => $row->state_alarm,
                'quantity_booties' => $row->quantity_booties,
                'quantity_spare_tire' => $row->quantity_spare_tire,
                'state_spare_tire' => $row->state_spare_tire,
                'quantity_wheel_nut' => $row->quantity_wheel_nut,
                'state_wheel_nut' => $row->state_wheel_nut,
                'quantity_wheel_cup' => $row->quantity_wheel_cup,
                'state_wheel_cup' => $row->state_wheel_cup,
                'quantity_ashtray' => $row->quantity_ashtray,
                'state_ashtray' => $row->state_ashtray,
                'quantity_internal_rearview_mirror' => $row->quantity_internal_rearview_mirror,
                'state_internal_rearview_mirror' => $row->state_internal_rearview_mirror,
                'quantity_car_radio' => $row->quantity_car_radio,
                'state_car_radio' => $row->state_car_radio,
                'quantity_proteccion_mat' => $row->quantity_proteccion_mat,
                'state_proteccion_mat' => $row->state_proteccion_mat,
                'quantity_rubber_floors' => $row->quantity_rubber_floors,
                'state_rubber_floors' => $row->state_rubber_floors,
                'qunatity_cup_holder' => $row->qunatity_cup_holder,
                'quantity_vehicle_key' => $row->quantity_vehicle_key,
                'state_vehicle_key' => $row->state_vehicle_key,
                'quantity_extinguisher' => $row->quantity_extinguisher,
                'state_extinguisher' => $row->state_extinguisher,
                'quantity_jack_lever' => $row->quantity_jack_lever,
                'state_jack_lever' => $row->state_jack_lever,
                'quantity_toolkit' => $row->quantity_toolkit,
                'state_tolkit' => $row->state_tolkit,
                'quantity_property_card' => $row->quantity_property_card,
                'state_property_card' => $row->state_property_card,
                'quantity_logbook' => $row->quantity_logbook,
                'state_logbook' => $row->state_logbook,
                'quantity_owner_namual' => $row->quantity_owner_namual,
                'state_owner_manual' => $row->state_owner_manual,
                'quantity_document_holder' => $row->quantity_document_holder,
                'state_document_holder' => $row->state_document_holder,
                'auth_drive' => $row->auth_drive,
                'move_on' => $row->move_on,
                'no_value_things' => $row->no_value_things,
                'cost_for_days' => $row->cost_for_days,
                'gasoline_level' => $row->gasoline_level,
                'observations' => $row->observations,
                'certificate' => $row->certificate,

            ];
        });
    }
}
