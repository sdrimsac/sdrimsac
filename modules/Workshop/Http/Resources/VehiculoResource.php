<?php

namespace Modules\Workshop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer->name,
            'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
            'tipo_vehiculo_description' => $this->tipo_vehiculo->name,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'serie' => $this->serie,
            'color' => $this->color,
            'motor' => $this->motor,
            'anio_fabricacion' => $this->anio_fabricacion,
            'kilometraje' => $this->kilometraje,
            'chasis' => $this->chasis,
            'date_soat_due' => $this->date_soat_due,
            'quantity_front_lights' => $this->quantity_front_lights,
            'state_front_lights' => $this->state_front_lights,
            'quantity_directional_lights_front' => $this->quantity_directional_lights_front,
            'state_directional_lights_front' => $this->state_directional_lights_front,
           'quantity_directional_lights_back' =>$this->quantity_directional_lights_back,
            'state_directional_lights_back' => $this->state_directional_lights_back,
           'quantity_hazard_lights' => $this->quantity_hazard_lights,
            'state_hazard_lights' => $this->state_hazard_lights,
            'quantity_wiper_washer_arm' => $this->quantity_wiper_washer_arm,
            'state_wiper_washer_arm' => $this->state_wiper_washer_arm,
            'quantity_gasoil_cap' => $this->quantity_gasoil_cap,
            'state_gasoil_cap' => $this->state_gasoil_cap,
            'quantity_radio_antenna' => $this->quantity_radio_antenna,
            'state_radio_antenna' => $this->state_radio_antenna,
            'quantity_side_mirrors' => $this->quantity_side_mirrors,
            'state_side_mirrors' => $this->state_side_mirrors,
            'quantity_test_handles' => $this->quantity_test_handles,
            'state_test_handles' => $this->state_test_handles,
            'quantity_alarm' => $this->quantity_alarm,
            'state_alarm' => $this->state_alarm,
            'quantity_booties' => $this->quantity_booties,
            'quantity_spare_tire' => $this->quantity_spare_tire,
            'state_spare_tire' => $this->state_spare_tire,
            'quantity_wheel_nut' =>$this->quantity_wheel_nut,
            'state_wheel_nut' =>$this->state_wheel_nut,
            'quantity_wheel_cup' =>$this->quantity_wheel_cup,
            'state_wheel_cup' =>$this->state_wheel_cup,
            'quantity_ashtray' =>$this->quantity_ashtray,
            'state_ashtray' =>$this->state_ashtray,
            'quantity_internal_rearview_mirror' =>$this->quantity_internal_rearview_mirror,
            'state_internal_rearview_mirror' => $this->state_internal_rearview_mirror,
            'quantity_car_radio' => $this->quantity_car_radio,
            'state_car_radio' => $this->state_car_radio,
            'quantity_proteccion_mat' => $this->quantity_proteccion_mat,
            'state_proteccion_mat' => $this->state_proteccion_mat,
            'quantity_rubber_floors' => $this->quantity_rubber_floors,
            'state_rubber_floors' => $this->state_rubber_floors,
            'qunatity_cup_holder' => $this->qunatity_cup_holder,
           'quantity_vehicle_key' => $this->quantity_vehicle_key,
            'state_vehicle_key' => $this->state_vehicle_key,
            'quantity_extinguisher' => $this->quantity_extinguisher,
            'state_extinguisher' => $this->state_extinguisher,
            'state_jack_lever' => $this->state_jack_lever,
            'quantity_toolkit' => $this->quantity_toolkit,
            'state_tolkit' => $this->state_tolkit,
            'quantity_property_card' => $this->quantity_property_card,
            'state_property_card' => $this->state_property_card,
            'quantity_logbook' => $this->quantity_logbook,
            'state_logbook' => $this->state_logbook,
            'quantity_owner_namual' => $this->quantity_owner_namual,
            'state_owner_manual' => $this->state_owner_manual,
            'quantity_document_holder' => $this->quantity_document_holder,
            'state_document_holder' => $this->state_document_holder,
            'auth_drive' => $this->auth_drive,
            'move_on' => $this->move_on,
            'no_value_things' => $this->no_value_things,
            'cost_for_days' => $this->cost_for_days,
            'gasoline_level' => $this->gasoline_level,
            'certificate' => $this->certificate,
            'historiales' => HistorialResource::collection($this->historiales),

        ];
    }
}