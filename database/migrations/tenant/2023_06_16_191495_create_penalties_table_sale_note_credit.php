<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePenaltiesTableSaleNoteCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('penalties_sale_note_credit', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('amount_by_day');
        });

        DB::connection('tenant')
        ->table('penalties_sale_note_credit')
        ->insert([
            ['type' => 'Diario', 'amount_by_day' => 1],
            ['type' => 'Semanal', 'amount_by_day' => 3],
            ['type' => 'Quincenal', 'amount_by_day' => 5],
            ['type' => 'Mensual', 'amount_by_day' => 10],
            ['type' => 'Único', 'amount_by_day' => 10],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('tenant')->table('penalties_sale_note_credit')->delete();
        Schema::dropIfExists('penalties_sale_note_credit');
    }
}
