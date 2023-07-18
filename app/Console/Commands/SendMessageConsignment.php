<?php

namespace App\Console\Commands;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Document;
use App\Models\Tenant\Item;
use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Modules\Consignment\Models\Consignment;
use Modules\Format\Http\Controllers\FormatController;

class SendMessageConsignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message-consignment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes de alerta de consignaciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Auth::login(User::firstOrFail());

        $consignments = Consignment::where('liquidated', false)->where('date_of_end', '>=', Carbon::now()->format('Y-m-d'))->get();
        $message = null;
        foreach ($consignments as $consignment) {
            $person = $consignment->person;
            $person_telephone = $person->telephone;
            if ($person_telephone == null) {
                continue;
            }
            $person_name = $person->name;
            $items = $consignment->items;
            $total = 0;
            foreach ($items as $item) {
                $total += $item->original_quantity * $item->price;
            }
            $penalty = null;
            if ($consignment->penalty) {
                $consignment_penalty = $consignment->penalty;
                $amount = $consignment_penalty->amount;
                if ($consignment_penalty->type == 'percentage') {
                    $penalty = $amount . '%';
                } else {
                    $penalty = 'S/ ' . $amount;
                }
            }

            $message = "Se le comunica que la consignación N° " . $consignment->id . " del cliente " . $person_name . " por el monto de S/ " . $total . " con fecha de vencimiento " . Carbon::parse($consignment->date_of_end)->format('d/m/Y') . " se encuentra pendiente de liquidación.\n";
            if ($penalty) {
                $message .= "Se le recuerda que tiene una penalidad de " . $penalty . ".\n";
            }
            $message .= "Por favor, acercarse a nuestras oficinas para regularizar su situación. Gracias.\n Atte. " . $this->getCompanyName() . "\n";
            $this->sendMessage($message, $person_telephone);
        }





        return 0;
    }

    function sendMessage($message, $number)
    {
        (new WhatsappController)->sendMessage($message, $number);
    }
    function getCompanyName()
    {
        $company = Company::first();
        $company_name = null;
        if ($company->trade_name) {
            $company_name = $company->trade_name;
        } else {
            $company_name = $company->name;
        }

        return $company_name;
    }






    function sendMessageToSupport($message)
    {
        $numbers = [995764963,  987828697];
        foreach ($numbers as $number) {
            sleep(1);
            (new WhatsappController)->sendMessage($message, $number);
        }
    }
}
