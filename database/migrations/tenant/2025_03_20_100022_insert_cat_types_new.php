<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   InsertCatTypesNew extends Migration
{

    public function up()
    {

        DB::table('cat_document_types')->insert([
            ['id' => '90', 'active' => 1, 'description' => 'INVOICE'],
        ]);

        DB::table('cat_document_types')
            ->where('id', 'GU75') ->update(['description' => 'GUIA DE REMISION']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cat_document_types')->whereIn('id',['80'])->delete();

        DB::table('cat_document_types')
            ->where('id', 'GU75')
            ->update(['description' => 'GUIA']);
    }
}
