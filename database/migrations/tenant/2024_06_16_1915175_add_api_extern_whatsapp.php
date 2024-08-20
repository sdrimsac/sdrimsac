<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiExternWhatsapp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
                $table->string('api_extern_whatsapp_url')->nullable();
                $table->string('api_extern_whatsapp_token')->nullable();
                $table->string('api_extern_whatsapp_token_2')->nullable();

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
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('api_extern_whatsapp_url');
            $table->dropColumn('api_extern_whatsapp_token');
            $table->dropColumn('api_extern_whatsapp_token_2');
            
        });  
    }
}