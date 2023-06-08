<?php

use App\Models\Tenant\User;
use Illuminate\Support\Facades\Auth;



Route::middleware(['auth', 'just.admin'])->group(function () {

    //Route::redirect('/', '/dashboard');
    //if (Auth::check()) {
    //}
    //if(auth()->check()){
    // $user=User::where("id",auth()->user()->id)->first();
    // if(strtolower($user->worker_type->description)=="mozo"){
    //     return redirect()->route('restaurant.workers.dashboard');
    // }else{
    //     $cocina=strripos(strtolower($user->area->description),"cocina");
    //     $caja=strripos(strtolower($user->area->description),"caja");
    //     if ($cocina !== false) {
    //         $kitchen=true;
    //         return redirect()->route('restaurant.kitchen.dashboard');
    //     }else if ($caja !== false) {
    //         $pos=true;
    //         return redirect()->route('restaurant.pos.dashboard');
    //     }
    // }
    // }else{
    Route::redirect('/', '/login');
    // }
    Route::prefix('dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('tenant.dashboard.index');
        Route::get('filter', 'DashboardController@filter');
        Route::post('data', 'DashboardController@data');
        Route::post('data_aditional', 'DashboardController@data_aditional');
        // Route::post('unpaid', 'DashboardController@unpaid');
        // Route::get('unpaidall', 'DashboardController@unpaidall')->name('unpaidall');
        Route::get('stock-by-product/records', 'DashboardController@stockByProduct');
        Route::post('utilities', 'DashboardController@utilities');
    });

    //Commands
    Route::get('command/df', 'DashboardController@df')->name('command.df');
});
