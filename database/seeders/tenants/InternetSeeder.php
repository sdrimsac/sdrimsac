<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internet_concept')->insert([
            [
                'id' => 1,
                'description' => 'Netflix',
                'item_id' => 1,
                'default_price' => 20,
                'active' => 1
            ],
            [
                'id' => 2,
                'description' => 'Cable',
                'item_id' => 1,
                'default_price' => 30,
                'active' => 1
            ],
            [
                'id' => 3,
                'description' => 'Direct tv',
                'item_id' => 1,
                'default_price' => 40,
                'active' => 1
            ],
        ]);

        DB::table('internet_plan')->insert([
            [
                'id' => 1,
                'capacity' => '30MB',
                'default_price' => 15,
                'item_id' => 1,
                'active' => 1
            ],
            [
                'id' => 2,
                'capacity' => '40MB',
                'default_price' => 25,
                'item_id' => 1,
                'active' => 1
            ],
            [
                'id' => 3,
                'capacity' => '50MB',
                'default_price' => 35,
                'item_id' => 1,
                'active' => 1
            ],
            [
                'id' => 4,
                'capacity' => '10MB',
                'default_price' => 10,
                'item_id' => 1,
                'active' => 1
            ],
            [
                'id' => 5,
                'capacity' => '20MB',
                'default_price' => 14,
                'item_id' => 1,
                'active' => 1
            ],
            [
                'id' => 6,
                'capacity' => 'Dedicado',
                'default_price' => 40,
                'item_id' => 1,
                'active' => 1
            ],
        ]);

        DB::table('internet_plan_variation')->insert([
            [
                "plan_id" => 1,
                "description" => "Descuento Zona A",
                "price" => 45,
                "active" => 1,
            ],
            [
                "plan_id" => 2,
                "description" => "Descuento Zona A",
                "price" => 50,
                "active" => 1,
            ],
            [
                "plan_id" => 1,
                "description" => "Descuento Zona B",
                "price" => 31,
                "active" => 1,
            ],
            [
                "plan_id" => 3,
                "description" => "Descuento Zona R",
                "price" => 45,
                "active" => 1,
            ],
            [
                "plan_id" => 2,
                "description" => "Descuento Zona B",
                "price" => 23,
                "active" => 1,
            ],
            [
                "plan_id" => 4,
                "description" => "Descuento Zona A",
                "price" => 45,
                "active" => 1,
            ],

        ]);

        DB::table('internet_concept_variation')->insert([
            [
                "concept_id" => 1,
                "description" => "4 personas",
                "price" => 20,
                "active" => 1,
            ],
            [
                "concept_id" => 2,
                "description" => "150 canales",
                "price" => 50,
                "active" => 1,
            ],
            [
                "concept_id" => 1,
                "description" => "2 personas",
                "price" => 31,
                "active" => 1,
            ],
            [
                "concept_id" => 3,
                "description" => "Todo incluido",
                "price" => 45,
                "active" => 1,
            ],


        ]);
    }
}
