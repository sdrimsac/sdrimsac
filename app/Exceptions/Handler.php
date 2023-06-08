<?php

namespace App\Exceptions;

use App\CoreFacturalo\Requests\Inputs\Functions;
use App\Http\Controllers\Tenant\WhatsappController;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->reportable(function (Throwable $e) {
        //    try{
        //         $message = $e->getMessage();
        //         $trace = $e->getTrace();
        //         $excep = "";
        //         if (count($trace) > 0) {
        //             $firstTrace = $trace[0];

        //             $file = Functions::valueKeyInArray($firstTrace, 'file',"");
        //             $line = Functions::valueKeyInArray($firstTrace, 'line',"");
        //             $function = Functions::valueKeyInArray($firstTrace, 'function',"");
        //             $excep = "File: $file \n Line: $line \n Function: $function";
        //         }

        //         $url = request()->fullUrl();
        //         $date = date('d/m/Y H:i:s');
        //         $payload = request()->all(); 
        //         $full_message = "*💀 Error*: $message \n *🌐 URL*: $url \n *📆 Fecha*: $date \n *📋 Track*: $excep \n *📥 Payload*: " . json_encode($payload);
        //         (new WhatsappController)->sendMessage($full_message, '972053723');
        //    }catch(Exception $e){
        //         Log::error($e->getMessage());
        //    }
           
            //
        });
    }
}
