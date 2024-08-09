<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFarmerToTypePersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            // $table->enum('type
            DB::statement("ALTER TABLE `persons` MODIFY `type` ENUM('customers', 'suppliers', 'farmer')");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            // Revertir la opción agregada al enum
            DB::statement("ALTER TABLE `persons` MODIFY `type` ENUM('customers', 'suppliers')");
        });
    }
}