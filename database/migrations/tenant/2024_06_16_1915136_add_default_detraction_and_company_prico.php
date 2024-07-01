<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultDetractionAndCompanyPrico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_prico')->default(false);
        });

        Schema::table('configurations',function(Blueprint $table){
            $table->string('detraction_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('is_prico');
        });

        Schema::table('configurations',function(Blueprint $table){
            $table->dropColumn('detraction_type_id');
        });
        
    }
}
