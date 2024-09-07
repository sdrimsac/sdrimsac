<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCasino extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casino', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->unsignedInteger('table_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->string('reference')->nullable();
            $table->date('date_start');
            $table->time('time_start');
            $table->integer('minutes')->default(0);
            $table->date('date_end')->nulllable();
            $table->time('time_end')->nullable();
            $table->boolean('active')->default=true;
            $table->timestamps();
            $table->foreign('table_id')->references('id')->on('tables');
            $table->foreign('customer_id')->references('id')->on('persons');

            
        });
        Schema::create('tarifa_casino', function (Blueprint $table) {

            $table->increments('id');
            $table->decimal('hora')->default(0);
            $table->decimal('media_hora')->default(0);
            $table->decimal('cuarto_hora')->default(0);
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
        //
        Schema::dropIfExists('casino');
        Schema::dropIfExists('tarifa_casino');

    }
}