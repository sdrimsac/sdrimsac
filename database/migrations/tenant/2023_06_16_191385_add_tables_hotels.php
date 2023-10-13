<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('towers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
        });
        DB::connection('tenant')->table('towers')->insert([
            ['name' => '1', 'active' => true],
           

        ]);
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('tower_id')->nullable();
            $table->boolean('active')->default(true);
        });

        Schema::create('table_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
        });
        DB::connection('tenant')->table('table_types')->insert([
            ['name' => 'Normal', 'active' => true],
            ['name' => 'Vip', 'active' => true],
            ['name' => 'Super Vip', 'active' => true],

        ]);
        DB::connection('tenant')->table('floors')->insert([
            ['tower_id'=>1,'name' => 'Piso 1', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 2', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 3', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 4', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 5', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 6', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 7', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 8', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 9', 'active' => true],
            ['tower_id'=>1,'name' => 'Piso 10', 'active' => true],
        ]);
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('hotels')->default(false);
        });
        Schema::table('tables', function (Blueprint $table) {
            $table->boolean('is_room')->default(false);
            $table->unsignedInteger('floor_id')->nullable();
            $table->unsignedInteger('table_type_id')->nullable();
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
            $table->dropColumn('floor_id');
            $table->dropColumn('table_type_id');
        });
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('hotels');
        });
        StatusTable::where('description', 'No disponible')->delete();
        Schema::dropIfExists('floors');
        Schema::dropIfExists('table_types');
        Schema::dropIfExists('towers');
    }
}
