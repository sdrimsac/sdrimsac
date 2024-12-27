<?php

use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//2024_10_09_1915271_add_description_number_activity

class AddDescriptionNumberActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('numbers_activity', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('numbers_activity', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
