<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexSuppliesMovTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_kardex_supplies_mov', function (Blueprint $table) {
            $table->increments('k_supp_id');
            $table->unsignedBigInteger('k_supp_id_list');
            $table->unsignedInteger('k_supp_id_alum')->nullable();;
            $table->unsignedInteger('k_supp_id_profe')->nullable();;
            $table->unsignedInteger('k_supp_id_type_event');
            
            $table->decimal('k_supp_cantidad',10,4);            
            $table->string('k_supp_DescMovimiento');
            $table->timestamps();

            $table->foreign('k_supp_id_list')->references('list_supp_id')->on('college_list_supplies');
            $table->foreign('k_supp_id_alum')->references('id')->on('college_students');
            $table->foreign('k_supp_id_profe')->references('teach_id')->on('college_teachers');
            $table->foreign('k_supp_id_type_event')->references('id')->on('event_kardex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex_supplies_mov');
    }
}
