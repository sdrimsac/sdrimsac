<?php
// app/Jobs/ProcesarFuncionOtrosControlador.php

namespace App\Jobs;

use App\Http\Controllers\Tenant\WhatsappController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
class WhatsappProccess implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $website_id;
    protected $url_file;


    public function __construct($website_id, $message, $url_file = null)
    {
        $this->message = $message;
        $this->website_id = $website_id;
        $this->url_file = $url_file;
    }


    public function handle()
    {
        (new WhatsappController)->sendMessageAll($this->message);
    }
}
