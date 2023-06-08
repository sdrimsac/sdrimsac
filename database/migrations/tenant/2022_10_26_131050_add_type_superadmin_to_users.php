<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeSuperadminToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users CHANGE type type ENUM('superadmin','admin', 'seller','integrator', 'client','drivers') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users CHANGE type type ENUM('admin', 'seller','integrator', 'client','drivers') NOT NULL");
    }
}
