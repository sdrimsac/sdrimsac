<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\DB;

class AddPaymentMethods extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('payment_method_types')-> insert([
            ['id'=> 13 ,'description' => 'TARJETA: IZIPAY' , 'has_card' => 1, 'active' => 1 ],
            ['id'=> 14 ,'description' => 'TARJETA: NIUBIZ' , 'has_card' => 1, 'active' => 1  ]
            
        ]);
    }
}
