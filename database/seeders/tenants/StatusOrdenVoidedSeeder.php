<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusOrdenVoidedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_orden')->insert([

            ['id' => 5, 'description' => 'Anulado',  'active' => 1],
        ]);
    }
}
