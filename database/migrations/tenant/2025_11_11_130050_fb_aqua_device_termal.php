<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FbAquaDeviceTermal extends Migration
{
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            // Solo agregar si no existe
            if (!Schema::hasColumn('persons', 'job_position_id')) {
                $table->unsignedBigInteger('job_position_id')->nullable()->after('id');

                $table->foreign('job_position_id')
                    ->references('id')
                    ->on('job_positions')
                    ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            if (Schema::hasColumn('persons', 'job_position_id')) {
                $table->dropForeign(['job_position_id']);
                $table->dropColumn('job_position_id');
            }
        });
    }
}
