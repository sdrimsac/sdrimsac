<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointsDocument extends Migration
{
    public function up()
    {
        Schema::table('promotion_documents', function (Blueprint $table) {
            $table->boolean('is_points')->default(false);
        });

        Schema::table('promotion_document_customers', function (Blueprint $table) {
            $table->decimal('points', 12, 2)->default(0)->after('acc_total');
        });
    }

    public function down()
    {
        Schema::table('promotion_documents', function (Blueprint $table) {
            $table->dropColumn('is_points');
        });

        Schema::table('promotion_document_customers', function (Blueprint $table) {
            $table->dropColumn('points');
        });
        
        
    }
}