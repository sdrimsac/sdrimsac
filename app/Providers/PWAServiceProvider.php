<?php

namespace App\Providers;

use App\Models\Tenant\Company;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PWAServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            try{
            $company = Company::first();
            $subdomain = request()->getHost();
            Config::set('laravelpwa.manifest.name', $subdomain);
            Config::set('laravelpwa.manifest.short_name', $subdomain);
            $favicon = $company->favicon;
              $iconSizes = ['72x72', '96x96', '128x128', '144x144', '152x152', '192x192', '384x384', '512x512'];
              foreach ($iconSizes as $size) {
                if($favicon){
                  Config::set("laravelpwa.manifest.icons.{$size}.path", asset('storage/uploads/favicon/'.$favicon));

                }else{
                  Config::set("laravelpwa.manifest.icons.{$size}.path", "/images/icons/icon-{$size}.png");
                }
                Config::set("laravelpwa.manifest.icons.{$size}.purpose", 'any');
              }
            
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        });
    }
} 