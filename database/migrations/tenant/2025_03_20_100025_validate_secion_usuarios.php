<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2025_02_18_100010_add_quotation_item_no_found_consolidated_documents
class   ValidateSecionUsuarios extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_session_id')->nullable()->after('remember_token');
        });    
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_session_id');
        });
    }
}
