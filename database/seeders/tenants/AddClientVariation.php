<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddClientVariation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->insert(
            [[
                'type' => 'customers',
                'identity_document_type_id' => 1,
                'number' => 88888888,
                'name' => 'CLIENTES VARIOS-MODIFICADO',
                'country_id' => 'PE',
                'perception_agent' => 0,
                'enabled' => 1,
                'status' => 1,


            ]]
        );
    }
}
