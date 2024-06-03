<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTransfer extends Migration
{

        
        public function up()
        {
            Schema::create('cash_transfers', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('cash_principal_id');
                $table->unsignedInteger('cash_destination_id');
                $table->decimal('amount', 12, 2);
                $table->date('date_of_issue');
                $table->text('observation')->nullable();
                $table->timestamps();
                $table->foreign('cash_destination_id')->references('id')->on('cash');
                $table->foreign('cash_principal_id')->references('id')->on('cash');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_transfers');

    
    }
}
