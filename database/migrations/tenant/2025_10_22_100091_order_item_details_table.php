<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderItemDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('order_item_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('orden_item_id');
            $table->string('description')->nullable();
            $table->decimal('quantity', 8, 2)->default(0);
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('orden_item_id')->references('id')->on('orden_item')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('order_item_details');
    }
}
