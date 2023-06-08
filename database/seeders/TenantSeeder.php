<?php

namespace Database\Seeders;

use Database\Seeders\Tenants\AddClientVariation;
use Database\Seeders\Tenants\CollegeSeeder;
use Database\Seeders\Tenants\StatusOrdenVoidedSeeder;
use Database\Seeders\Tenants\TurnsSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $establishment_id = DB::table('establishments')->insertGetId([
            'description' => 'Oficina Principal',
            'country_id' => 'PE',
            'department_id' => '15',
            'province_id' => '1501',
            'district_id' => '150101',
            'address' => '-',
            'email' => "admin@gmail.com",
            'telephone' => '-',
            'code' => '0000',
            'printer' => '',
            'format_printer' => '1',
            'direct_printing' => false
        ]);
        DB::table('warehouses')->insertGetId([
            'establishment_id' => $establishment_id,
            'description' => 'Almacén - ' . 'Oficina Principal',
        ]);

        DB::table('series')->insert([
            ['establishment_id' => 1, 'document_type_id' => '01', 'number' => 'F001'],
            ['establishment_id' => 1, 'document_type_id' => '03', 'number' => 'B001'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'FC01'],
            ['establishment_id' => 1, 'document_type_id' => '07', 'number' => 'BC01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'FD01'],
            ['establishment_id' => 1, 'document_type_id' => '08', 'number' => 'BD01'],
            ['establishment_id' => 1, 'document_type_id' => '20', 'number' => 'R001'],
            ['establishment_id' => 1, 'document_type_id' => '09', 'number' => 'T001'],
            ['establishment_id' => 1, 'document_type_id' => '40', 'number' => 'P001'],
            ['establishment_id' => 1, 'document_type_id' => '80', 'number' => 'NV01'],
        ]);
        DB::table('workers_type')->upsert([
            ['id' => 1, 'description' => 'CAJA', 'active' => 1],
            ['id' => 2, 'description' => 'MOZO', 'active' => 1],
            ['id' => 3, 'description' => 'COCINA', 'active' => 1],
            ['id' => 4, 'description' => 'BARMAN', 'active' => 1],
            ['id' => 5, 'description' => 'CONTADOR', 'active' => 1]
        ], ['id'], ['description', 'active']);
        DB::table('areas')->upsert([
            ['id' => 1, 'description' => 'BARRA',            'copies' => 0,            'printer' => null,            'active' => 1],
            ['id' => 2, 'description' => 'CAJA',            'copies' => 0,            'printer' => "POS-80-Series",            'active' => 1],
            ['id' => 3, 'description' => 'COCINA',            'copies' => 0,            'printer' => null,            'active' => 1],
            ['id' => 4, 'description' => 'MESA',            'copies' => 0,            'printer' => null,            'active' => 1]
        ], ['id']);

        $token = str_random(50);
        DB::table('users')->delete();
        $user_id = DB::table('users')->insert([
            ['name' => 'Soporte',    'email' => "admin@sdrimsac.xyz",    'password' => bcrypt("Sdr147258369"),       'api_token' => str_random(50), 'establishment_id' => $establishment_id,  'locked' => true, 'number' => null,       'pin' => 205687,    'type' => 'superadmin', 'worker_type_id' => null, 'area_id' =>    null, 'active' =>    1],
            ['name' => 'Administrador', 'email' => "admin@gmail.xyz",       'password' => bcrypt("teros"),              'api_token' => str_random(50), 'establishment_id' => $establishment_id,  'locked' => true, 'number' => null,          'pin' => 159357, 'type' => 'admin', 'worker_type_id' => null, 'area_id' =>    null, 'active' =>    1],
            ['name' => 'Contador',      'email' => "contador@sdrimsac.xyz", 'password' => bcrypt("12345"),              'api_token' => str_random(50), 'establishment_id' => $establishment_id,      'locked' => true, 'number' => null,       'pin' => 12345, 'type' => 'seller', 'worker_type_id' => 5, 'area_id' =>    null, 'active' =>    1],
            ['name' =>     'CAJA',    'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        1,     'pin' => 8800, 'type'    => 'seller', 'worker_type_id' =>    1, 'area_id' =>    2, 'active' =>    1],
            ['name' =>     'BARRA',        'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        2,     'pin' => 5822, 'type'    => 'seller', 'worker_type_id' =>    4, 'area_id' =>    1, 'active' =>    1],
            ['name' =>     'COCINA',        'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        3,     'pin' => 5725, 'type'    => 'seller', 'worker_type_id' =>    3, 'area_id' =>    3, 'active' =>    1],
            ['name' =>     'MOZO',    'email' => null, 'password' => null,   'api_token' => null,     'establishment_id' =>    1, 'locked' =>    0,                                                                      'number' =>        4,     'pin' => 7808, 'type'    => 'seller', 'worker_type_id' =>    2, 'area_id' =>    4, 'active' =>    1]


        ]);

        DB::table('status_table')->upsert([
            [
                'id' => '1',
                'description' => "Libre",
                'active' => true
            ],
            [
                'id' => '2',
                'description' => "Ocupado",
                'active' => true
            ],
            [
                'id' => '3',
                'description' => "En mantenimiento",
                'active' => true
            ]
        ],'id');



        DB::table('status_orden')->upsert([
            [
                'id' => '1',
                'description' => "Solicitado"
            ],
            [
                'id' => '2',
                'description' => "Preparando"
            ],
            [
                'id' => '3',
                'description' => "Listo"
            ],
            [
                'id' => '4',
                'description' => "Atendido"
            ]
        ], ['id']);


        DB::table('group')->upsert([
            'id' => '1',
            'group' => "Ingresos",
            'type'        => 1
        ], ['id']);


        DB::table('group')->upsert([
            'id' => '2',
            'group' => "Egresos",
            'type'        => 2
        ], ['id']);

        DB::table('category')->upsert([
            'id' => '1',
            'category' => "Ventas",
            'type'        => 1
        ], ['id']);

        DB::table('category')->upsert([
            'id' => '2',
            'category' => "Egresos",
            'type'        => 2
        ], ['id']);

        DB::table('subcategories')->upsert([
            'id' => '1',
            'subcategory' => "Ventas",
            'type'        => 1
        ], ['id']);

        DB::table('companies')->insert([
            'identity_document_type_id' => '6',
            'number' => "12345678901",
            'name' => "COMPANY DEMO",
            'trade_name' => "",
            'soap_type_id' => "01",
            'soap_send_id' => "01",
            'soap_username' => "",
            'soap_password' => "",
            'soap_url' => "",
            'certificate' => "",
        ]);



        DB::table('persons')->delete();
        DB::table('persons')->insert([
            ['id' => 1, 'type' => 'customers', 'identity_document_type_id' =>    1, 'number' =>    99999999, 'name' =>    'CLIENTES VARIOS', 'trade_name' => null,                 'country_id' =>  'PE', 'department_id' => 12, 'province_id' => 1203, 'district_id' => 120303,    'perception_agent' => 0, 'percentage_perception' => 0, 'enabled' =>    1, 'seller_id' =>    1, 'created_at' =>    '2022-06-02 22:48:07', 'updated_at' => '2022-06-02 22:48:07', 'status' =>    1],
            ['id' => 2, 'type' => 'suppliers', 'identity_document_type_id' =>    0, 'number' =>    99999999, 'name' =>    'PROVEEDOR - Varios', 'trade_name' => 'Inicio de stock', 'country_id' =>  'PE',    'department_id'    => null,     'province_id' => null, 'district_id' => NULL,    'perception_agent' => 0, 'percentage_perception' => 0, 'enabled' =>    1, 'seller_id' =>    1, 'created_at' =>    '2022-06-07 16:43:09', 'updated_at' => '2022-06-07 16:43:09', 'status' =>    1]
        ]);



        $this->call([
            TurnsSeeder::class,
            StatusOrdenVoidedSeeder::class,
            AddClientVariation::class,
            CollegeSeeder::class,
        ]);
    }
}
