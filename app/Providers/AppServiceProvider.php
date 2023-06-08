<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Tenant\Document;
use App\Observers\DocumentObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot() {
        Schema::defaultStringLength(191);
         if (config('tenant.force_https')){
        //    URL::forceScheme('https');
        }

        Document::observe(DocumentObserver::class);
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');

    }

    public function register() {

    }
}
