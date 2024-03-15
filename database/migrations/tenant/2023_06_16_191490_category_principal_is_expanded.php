<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryPrincipalIsExpanded extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('principal_categories', function (Blueprint $table) {
            $table->boolean('is_expanded')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('principal_categories', function (Blueprint $table) {
            $table->dropColumn('is_expanded');
        });

     
    }
}
