<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddFromConsignmentDocumentsSaleNotes extends Migration
{

    public function up()
    {

  
        Schema::table('documents', function (Blueprint $table) {
            $table->boolean('from_consignment')->default(false);
        });
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->boolean('from_consignment')->default(false);
        });
        Schema::table('consignments', function (Blueprint $table) {
            $table->boolean('liquidated')->default(false);
        });
    }


    public function down()
    {


        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('from_consignment');
        });

        Schema::table('sale_notes', function (Blueprint $table) {
            $table->dropColumn('from_consignment');
        });
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropColumn('liquidated');
        });
    }
}
