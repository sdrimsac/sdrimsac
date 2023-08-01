<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountWithBaseVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->boolean('discount_with_base_variant')->default(false)->comment('Variante en el descuento de base');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->decimal('discount_variant')->nullable()->comment('Monto del descuento de variante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('discount_with_base_variant');

        });
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('discount_variant');

        });
    }
}
