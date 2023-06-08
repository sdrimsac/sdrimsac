<?php

namespace Modules\BusinessTurn\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\ModelTenant;

class BusinessTurnDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
