<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class PWAServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $subdomain = request()->getHost();
            Config::set('laravelpwa.manifest.name', $subdomain);
            Config::set('laravelpwa.manifest.short_name', $subdomain);
            
        });
    }
} 