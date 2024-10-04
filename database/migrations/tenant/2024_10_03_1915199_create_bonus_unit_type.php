<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusUnitType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_unit_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->decimal('qty_min', 10, 2)->default(0);
            $table->decimal('qty_max', 10, 2)->default(0);
            $table->decimal('qty_free', 10, 2)->default(0);
            $table->timestamps();
        
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('bonus_unit_type');
        
    }

    
}
