<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Restaurant\Events\PrintEventJob;

class PrintOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $orden_id;
    protected $type;
    protected $direct;
    protected $area_id;
    protected $filtered_items;
    protected $user_id;
    protected $isEmit;
    protected $isPrecuenta;
    protected $url;
    protected $url_base;
    public function __construct(
                $orden_id,
                $type,
                $direct,
                $area_id,
                $filtered_items,
                $isEmit = false,
                $isPrecuenta = false,
                $url = null,
                $user_id,
                $url_base = null
    ) {
        $this->orden_id = $orden_id;
        $this->type = $type;
        $this->direct = $direct;
        $this->area_id = $area_id;
        $this->filtered_items = $filtered_items;
        $this->user_id = $user_id;
        $this->isEmit = $isEmit;
        $this->isPrecuenta = $isPrecuenta;
        $this->url = $url;
        $this->url_base = $url_base;
    }

    public function handle()
    {
        event(new PrintEventJob(
            $this->orden_id,
            $this->type,
            $this->direct,
            $this->area_id,
            $this->filtered_items,
            $this->isEmit,
            $this->isPrecuenta,
            $this->url,
            $this->user_id,
            $this->url_base
        ));
    }
} 