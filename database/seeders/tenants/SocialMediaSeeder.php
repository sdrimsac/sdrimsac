<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\DB;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_medias')->insert([
            ['id' => 1, 'description' => 'FACEBOOK',  'active' => 1],
            ['id' => 2, 'description' => 'INSTAGRAM',  'active' => 1],
            ['id' => 3, 'description' => 'TIKTOK',  'active' => 1],
            ['id' => 4, 'description' => 'TWITTER',  'active' => 1],
        ]);
    }
}
