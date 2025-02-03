<?php




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Catalog extends Migration
{
    public function up()
    {
        Schema::create('catalog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_past')->nullable();
            $table->string('image_fond')->nullable();
            $table->string('image_footer')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('catalog')->insert([
            'image_past' => null,
            'image_fond' => null,
            'image_footer' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('catalog');
    }
}
