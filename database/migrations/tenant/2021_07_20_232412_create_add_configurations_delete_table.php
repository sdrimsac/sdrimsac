<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddConfigurationsDeleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            //$table->unsignedTinyInteger('status_order_id')->after('number_document')->nullable();
            $table->boolean('recreat_document')->default(0)->after('cotizaction_finance');
            $table->boolean('delete_document')->default(0)->after('terms_condition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('status_order_id');
        });
    }
}
