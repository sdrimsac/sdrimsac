<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DeleteSellersNumberColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->statement('ALTER TABLE sellers DROP COLUMN number');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          
    } 
}
