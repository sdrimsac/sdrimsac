<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('college_degrees')->insert([
            ['description' => '1RO', 'active' => 1],
            ['description' => '2DO', 'active' => 1],
            ['description' => '3RO', 'active' => 1],
            ['description' => '4TO', 'active' => 1],
            ['description' => '5TO', 'active' => 1],
            ['description' => '6TO', 'active' => 1],
            ['description' => '7MO', 'active' => 1]
        ]);

        DB::table('college_sections')->insert([
            ['description' => 'A', 'active' => 1],
            ['description' => 'B', 'active' => 1],
            ['description' => 'C', 'active' => 1],
            ['description' => 'D', 'active' => 1],
            ['description' => 'E', 'active' => 1],
            ['description' => 'F', 'active' => 1],
            ['description' => 'G', 'active' => 1],
            ['description' => 'H', 'active' => 1]
        ]);


        DB::table('college_levels')->insert([
            ['description' => 'INICIAL', 'active' => 1],
            ['description' => 'PRIMARIA', 'active' => 1],
            ['description' => 'SECUNDARIA', 'active' => 1],
        ]);


        DB::table('college_turns')->insert([
            ['description' => 'MAÑANA', 'active' => 1],
            ['description' => 'TARDE', 'active' => 1],
            ['description' => 'NOCHE', 'active' => 1],
        ]);

        DB::table('college_plan_types')->insert([
            ['description' => 'MATRICULA', 'active' => 1],
            ['description' => 'MENSUALIDAD', 'active' => 1],
            ['description' => 'OTROS', 'active' => 1],
        ]);

        DB::table('college_periods')->insert([
            ['description' => 'ANUAL', 'default_count' => 1, 'active' => 1],
            ['description' => 'MENSUAL', 'default_count' => 12, 'active' => 1],
        ]);

        DB::table('college_plans')->insert([
            ['name' => 'OTROS', 'description' => 'ADQUISICION', 'period_id' => 1, 'type_id' => 3, 'count' => 1, 'days_extension' => 0, 'active' => 1],
        ]);
    }
}
