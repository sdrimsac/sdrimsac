<?php

namespace Modules\Restaurant\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\ModelTenant;

class RestaurantDatabaseSeeder extends Seeder
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
