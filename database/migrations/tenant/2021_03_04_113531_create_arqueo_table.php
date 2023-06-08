<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArqueoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arqueo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_id'); 
            $table->decimal('diez_moneda', 10, 4)->default(0);
            $table->decimal('veinte_moneda', 10, 4)->default(0);
            $table->decimal('cincuenta_moneda', 10, 4)->default(0);
            $table->decimal('uno_moneda', 10, 4)->default(0);
            $table->decimal('dos_moneda', 10, 4)->default(0);
            $table->decimal('cinco_moneda', 10, 4)->default(0);
            $table->decimal('diez_billete', 10, 4)->default(0);
            $table->decimal('veinte_billete', 10, 4)->default(0);
            $table->decimal('cincuenta_billete', 10, 4)->default(0);
            $table->decimal('cien_billete', 10, 4)->default(0);
            $table->decimal('docientos_billete', 10, 4)->default(0);
            $table->date('fecha');
            $table->decimal('total_sistema', 10, 4)->default(0);
            $table->decimal('total_moneda', 10, 4)->default(0);
            $table->decimal('total_billete', 10, 4)->default(0);
            $table->decimal('egresos', 10, 4)->default(0);
            $table->decimal('efectivo_total', 10, 4)->default(0);
            $table->decimal('total', 10, 4)->default(0);
            $table->string('state',2)->default('1');
            $table->string('transferir',2)->default('0');
            $table->string('transferir_a')->default('');
            $table->timestamps();
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arqueo');
    }
}
