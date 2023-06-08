<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');     
            $table->date('date_of_issue')->nullable();
            $table->string('external_id')->nullable();
            $table->string('hour',15)->nullable();
            $table->unsignedInteger('establishment_id')->nullable();    
            $table->unsignedInteger('customer_id')->nullable();    
            $table->unsignedInteger('sale_note_id')->nullable();    
            $table->unsignedInteger('sale_note_payment_id')->nullable();    
            $table->string('detail')->nullable();
            $table->string('number')->nullable();
            $table->decimal('amount', 10, 2);
             $table->boolean('state')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('customer_id')->references('id')->on('persons');
            $table->foreign('sale_note_id')->references('id')->on('sale_notes');
            $table->foreign('sale_note_payment_id')->references('id')->on('sale_note_payments');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
