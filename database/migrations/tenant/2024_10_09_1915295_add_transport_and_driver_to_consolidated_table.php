<?php




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransportAndDriverToConsolidatedTable extends Migration
{
    public function up()
    {
        Schema::table('consolidated', function (Blueprint $table) {
            $table->unsignedInteger('transport_id')->nullable()->after('weight');
            $table->unsignedInteger('driver_id')->nullable()->after('transport_id');

            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('consolidated', function (Blueprint $table) {
            $table->dropForeign(['transport_id']);
            $table->dropForeign(['driver_id']);
            $table->dropColumn(['transport_id', 'driver_id']);
        });
    }
}
