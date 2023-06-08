<?php

namespace Database\Seeders\Tenants;


use App\Models\Tenant\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddContadorToWorkType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workers_type')-> insert([
            ['id' => 5 , 'description' => 'CONTADOR' , 'active' => 1]
            
                        
        ]);

        DB::table('users')->insert([
            
            ['name' => 'Contador',      'email' => "contador@sdrimsac.xyz", 'password' => bcrypt("12345"),              'api_token' => str_random(50), 'establishment_id' => 1,      'locked' => true,'number'=>null ,       'pin' => 12345 ,'type'=> 'seller', 'worker_type_id'=> 5, 'area_id'=>	null, 'active'=>	1],
            
        ]); 
    }
}
