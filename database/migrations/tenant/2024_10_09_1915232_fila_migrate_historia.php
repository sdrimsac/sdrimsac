<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilaMigrateHistoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_feature', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_feature', 'historial_id')) {
                $table->unsignedInteger('historial_id')->nullable();
                $table->foreign('historial_id')->references('id')->on('historial');
            }
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_feature', function (Blueprint $table) {
            if (Schema::hasColumn('vehicle_feature', 'historial_id')) {
                // Primero eliminamos la llave foránea si existe
                $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('vehicle_feature');
                foreach ($foreignKeys as $foreignKey) {
                    if ($foreignKey->getLocalColumns() === ['historial_id']) {
                        $table->dropForeign(['historial_id']);
                        break;
                    }
                }
                // Luego eliminamos la columna
                $table->dropColumn('historial_id');
            }
        });   
    } 
}