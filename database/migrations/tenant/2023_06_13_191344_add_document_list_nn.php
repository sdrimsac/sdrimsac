<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDocumentListNn extends Migration
{
    
    public function up()
    {
         if(!DB::table('cat_identity_document_types')->where('id', '-')->exists()){
          DB::table('cat_identity_document_types')->insert([
                'id' => '-',
                'description' => 'SIN DOCUMENTO',
                'active' => true,
          ]);
         }
    }

  
    public function down()
    {
      
    }
}
