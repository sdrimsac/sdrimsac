<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915262_create_digital_payment_notifications

class CreateDigitalPaymentNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digital_payment_notifications', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('type');
            $table->string('person_name');
            $table->decimal('amount', 10, 2);
            $table->string('title');
            $table->string('all_message');
            $table->string('package_name');
            $table->timestamps();
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digital_payment_notifications');
    }
}
