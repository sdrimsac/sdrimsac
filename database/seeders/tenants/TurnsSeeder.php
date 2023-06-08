<?php

namespace Database\Seeders\Tenants;

use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turns')-> insert([
            ['turn_desc' => 'MAÑANA' , 'turn_active' => 1 ],
            ['turn_desc' => 'TARDE' , 'turn_active' => 1],
            ['turn_desc' => 'NOCHE' , 'turn_active' => 1]
                        
        ]);
    }
}
