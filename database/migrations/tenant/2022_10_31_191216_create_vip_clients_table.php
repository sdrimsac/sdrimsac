<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_clients', function (Blueprint $table) {
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('vip_id');
            $table->foreign('client_id')->references('id')->on('persons');
            $table->foreign('vip_id')->references('id')->on('vips');
            $table->decimal('amount', 7, 2);
            $table->date('pay_date');
            $table->date('end_date');
            $table->date('cancel_date')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('vip_clients');
    }
}
