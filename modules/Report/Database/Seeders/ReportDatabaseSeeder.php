<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\ModelTenant;

class ReportDatabaseSeeder extends Seeder
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
