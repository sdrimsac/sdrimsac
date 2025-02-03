<?php




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IdsCatalogItems extends Migration
{
    public function up()
    {
        Schema::create('item_catalog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_item_catalog')->nullable();
            
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

        Schema::dropIfExists('item_catalog');
    }
}
