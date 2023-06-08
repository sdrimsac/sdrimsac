<?php

namespace Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\ModelTenant;

class ItemDatabaseSeeder extends Seeder
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
