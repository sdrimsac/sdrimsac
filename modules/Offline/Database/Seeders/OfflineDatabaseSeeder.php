<?php

namespace Modules\Offline\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\ModelTenant;

class OfflineDatabaseSeeder extends Seeder
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
