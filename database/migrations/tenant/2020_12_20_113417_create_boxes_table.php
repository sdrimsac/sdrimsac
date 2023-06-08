<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');            //relacion tabla grupos
            $table->unsignedInteger('category_id');         //relacion tabla categorias
            $table->unsignedInteger('subcategory_id');      //relacion tabla subcategorias
            $table->unsignedInteger('user_id');      //relacion tabla Vendedor
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('soap_type_id',2);
            $table->string('description');
            $table->string('type',2);
            $table->string('method');
            $table->date('close')->nullable();
            $table->integer('sale_note_id')->nullable();
            $table->integer('document_id')->nullable();
           
            $table->string('state',2);
            
            $table->timestamps();
            $table->foreign('group_id')->references('id')->on('group');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('category');  
            $table->foreign('subcategory_id')->references('id')->on('subcategories');     
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boxes');
    }
}
