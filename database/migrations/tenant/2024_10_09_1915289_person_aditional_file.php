<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//2024_10_09_1915283_add_direct_unit_type
class PersonAditionalFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('ref_origin')->nullable();
            $table->string('name_family')->nullable();
            $table->string('telephone_family')->nullable();
            $table->string('image')->nullable();
            $table->string('occupation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('ref_origin');
            $table->dropColumn('name_family');
            $table->dropColumn('telephone_family');
            $table->dropColumn('image');
            $table->dropColumn('occupation');
        });
    }
}
