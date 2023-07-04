<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConsignmentTables extends Migration
{

    public function up()
    {
        Schema::create('consignment_penalties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->enum('type',['percentage','fixed'])->default('percentage');
            $table->decimal('amount');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::create('consignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->date('date_of_issue');
            $table->date('date_of_end');
            $table->unsignedInteger('penalty_id')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('penalty_id')->references('id')->on('consignment_penalties')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
        Schema::create('consignment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consignment_id');
            $table->unsignedInteger('establishment_id');
            $table->unsignedInteger('item_id');
            $table->decimal('original_quantity');
            $table->decimal('price');
            $table->decimal('selled_quantity')->nullable();
            $table->decimal('return_quantity')->nullable();
            $table->decimal('lost_quantity')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('consignment_id')->references('id')->on('consignments')->onDelete('cascade');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
        Schema::create('consigment_item_lots', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('consignment_item_id');
            $table->string('series');
            $table->boolean('has_sale')->default(false);
            $table->boolean('has_return')->default(false);
            $table->boolean('has_lost')->default(false);
            $table->foreign('consignment_item_id')->references('id')->on('consignment_items')->onDelete('cascade');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('consignment')->default(false);

        });
    }


    public function down()
    {
        Schema::dropIfExists('consigment_item_lots');
        Schema::dropIfExists('consignment_items');
        Schema::dropIfExists('consignments');
        Schema::dropIfExists('consignment_penalties');
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('consignment');
        });
    }
}
