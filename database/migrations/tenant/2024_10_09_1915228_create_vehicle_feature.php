<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createVehicleFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vehicle_feature')) {
            Schema::create('vehicle_feature', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('vehiculo_id');
                $table->date('year')->nullable();
                $table->string('chasis')->nullable();
                $table->date('date_soat_due')->nullable();
                $table->date('date_check_due')->nullable();
                $table->string('quantity_front_lights')->nullable();
                $table->string('state_front_lights')->nullable();
                $table->string('quantity_directional_lights_front')->nullable();
                $table->string('state_directional_lights_front')->nullable();
                $table->string('quantity_directional_lights_back')->nullable();
                $table->string('state_directional_lights_back')->nullable();
                $table->string('quantity_hazard_lights')->nullable();
                $table->string('state_hazard_lights')->nullable();
                $table->string('quantity_wiper_washer_arm')->nullable();
                $table->string('state_wiper_washer_arm')->nullable();
                $table->string('quantity_gasoil_cap')->nullable();
                $table->string('state_gasoil_cap')->nullable();
                $table->string('quantity_radio_antenna')->nullable();
                $table->string('state_radio_antenna')->nullable();
                $table->string('quantity_side_mirrors')->nullable();
                $table->string('state_side_mirrors')->nullable();
                $table->string('quantity_test_handles')->nullable();
                $table->string('state_test_handles')->nullable();
                $table->string('quantity_alarm')->nullable();
                $table->string('state_alarm')->nullable();
                $table->string('quantity_booties')->nullable();
                $table->string('quantity_spare_tire')->nullable();
                $table->string('state_spare_tire')->nullable();
                $table->string('quantity_wheel_nut')->nullable();
                $table->string('state_wheel_nut')->nullable();
                $table->string('quantity_wheel_cup')->nullable();
                $table->string('state_wheel_cup')->nullable();
                $table->string('quantity_ashtray')->nullable();
                $table->string('state_ashtray')->nullable();
                $table->string('quantity_internal_rearview_mirror')->nullable();
                $table->string('state_internal_rearview_mirror')->nullable();
                $table->string('quantity_car_radio')->nullable();
                $table->string('state_car_radio')->nullable();
                $table->string('quantity_proteccion_mat')->nullable();
                $table->string('state_proteccion_mat')->nullable();
                $table->string('quantity_rubber_floors')->nullable();
                $table->string('state_rubber_floors')->nullable();
                $table->string('qunatity_cup_holder')->nullable();
                $table->string('quantity_vehicle_key')->nullable();
                $table->string('state_vehicle_key')->nullable();
                $table->string('quantity_extinguisher')->nullable();
                $table->string('state_extinguisher')->nullable();
                $table->string('quantity_jack_lever')->nullable();
                $table->string('state_jack_lever')->nullable();
                $table->string('quantity_toolkit')->nullable();
                $table->string('state_tolkit')->nullable();
                $table->string('quantity_property_card')->nullable();
                $table->string('state_property_card')->nullable();
                $table->string('quantity_logbook')->nullable();
                $table->string('state_logbook')->nullable();
                $table->string('quantity_owner_namual')->nullable();
                $table->string('state_owner_manual')->nullable();
                $table->string('quantity_document_holder')->nullable();
                $table->string('state_document_holder')->nullable();
                $table->string('auth_drive')->nullable();
                $table->string('move_on')->nullable();
                $table->string('no_value_things')->nullable();
                $table->string('cost_for_days')->nullable();
                $table->string('gasoline_level')->nullable();
                $table->string('quantiy_front_lights')->nullable();
                $table->string('quantity_protection_mat')->nullable();
                $table->string('quantity_cup_holder')->nullable();
                $table->string('quantity_owner_manual')->nullable();
                $table->string('state_booties')->nullable();
                $table->string('state_cup_holder')->nullable();
                $table->string('state_protection_mat')->nullable();
                $table->string('state_toolkit')->nullable();
                $table->string('observations')->nullable();
                $table->string('certificate')->nullable();
                $table->timestamps();
                $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
                
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_feature');
    }
}
