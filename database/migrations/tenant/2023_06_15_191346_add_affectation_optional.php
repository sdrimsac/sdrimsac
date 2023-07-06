<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffectationOptional extends Migration
{

    public function up()
    {
       

        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('affectation_optional')->default(false);
            $table->string('affectation_optional_id')->nullable();
            $table->foreign('affectation_optional_id')->references('id')->on('cat_affectation_igv_types')->onDelete('cascade');

        });
    }


    public function down()
    {
        
      
            Schema::table('configurations', function (Blueprint $table) {
                $table->dropForeign(['affectation_optional_id']);
                $table->dropColumn('affectation_optional');
                $table->dropColumn('affectation_optional_id');
            });
            
    }
}
