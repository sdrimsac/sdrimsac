<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstablishmentAddressConfDocumentsPrint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->boolean('company_address')->default(false)->comment('Dirección de la empresa en el documento de impresión, nombre del establecimiento y su dirección');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conf_establishment', function (Blueprint $table) {
            $table->dropColumn('company_address');

        });
    }
}
