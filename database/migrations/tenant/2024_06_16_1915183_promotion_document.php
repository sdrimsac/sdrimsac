<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromotionDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->date('date_start');
            $table->date('date_end');
            $table->decimal('total', 12, 2);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('promotion_documents');
    }
}
