<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->string('smtp_host')->nullable()->after('visual');
            $table->string('smtp_port')->nullable()->after('visual');
            $table->string('smtp_user')->nullable()->after('visual');
            $table->string('smtp_password')->nullable()->after('visual'); 
            $table->string('smtp_encryption')->nullable()->after('visual'); 
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
            $table->dropColumn('smtp_host');
            $table->dropColumn('smtp_port');
            $table->dropColumn('smtp_user');
            $table->dropColumn('smtp_password');
            $table->dropColumn('smtp_encryption');
        });
    }
}
