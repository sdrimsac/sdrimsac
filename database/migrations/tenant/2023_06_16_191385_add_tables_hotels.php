<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Restaurant\Models\StatusTable;

class AddTablesHotels extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->boolean('is_room')->default(false);
        });

        StatusTable::create([
            'id' => '4',
            'description' => 'No disponible',
            'active' => true,
        ]);
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn('is_room');
         
        });
     
     
    }
}
