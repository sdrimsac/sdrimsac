<?php

use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use Illuminate\Database\Migrations\Migration;
//2024_10_09_1915270_add_main_to_numbers

class AddMainToNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $configuration = Configuration::first();
        $number_activity = $configuration->number_activity;
        if ($number_activity) {
            $configuration->number_activity = null;
            $configuration->save();
        }
        if (!NumberActivity::where('number', $number_activity)->exists() && $number_activity != null) {
            NumberActivity::create([
                'number' => $number_activity,
            ]);
        }
    }
}
