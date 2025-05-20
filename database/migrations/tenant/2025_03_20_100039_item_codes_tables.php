<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  ItemCodesTables extends Migration
{
    public function up()
    {
        Schema::create('item_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_id');
            $table->string('code_barcode')->unique();
            $table->boolean('is_primary')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });

        Schema::create('item_price_policy', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('item_unit_type_id');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('barcode_policy')->unique()->nullable();
            $table->timestamps();

            $table->foreign('item_unit_type_id')->references('id')->on('item_unit_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_codes');
        Schema::dropIfExists('item_price_policy');
    }
}
