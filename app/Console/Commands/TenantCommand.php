<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tenant\Task;
use App\Models\Tenant\HotelRentWhatsapp;
use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\HotelRentPayment;
use Modules\Restaurant\Models\Table;
use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\BankAccount;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\NumberActivity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class TenantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:run';

    /**|
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the scheduled tasks of the tenants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function checkAndSendWhatsappMessages()
    {
        $configuration = Configuration::first();
        if (!$configuration->mod_renta) return;
        try {
            $months_spanish = [
                'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'
            ];
            // Obtener habitaciones ocupadas
            $occupied_rooms = Table::where('is_room', true)
                ->where('status_table_id', 2)
                ->with(['hotel_rent_items' => function ($query) {
                    $query->where('active', true)
                        ->with(['hotel_rent.customer', 'payments' => function ($q) {
                            $q->where('is_paid', false)
                                ->where('is_warranty', false)
                                ->orderBy('date_payment', 'asc');
                        }])
                        ->latest();
                }])
                ->get();
            $company = Company::first();
            $number_activity_db = NumberActivity::first();

            $number_activity = "-";
            if ($number_activity_db) {
                $number_activity = $number_activity_db->number;
            }
            $number_pay_digital = $company->number_pay_digital ?? $number_activity;
            $account = BankAccount::first();
            $bank_description = '-';
            if ($account) {
                $bank_description = $account->bank->description . ' ' . $account->currency_type->description . ' ' . $account->number;
            }
            $whatsapp = new WhatsappController();
            $current_time = Carbon::now()->format('H:i');

            foreach ($occupied_rooms as $room) {
                $rent_item = $room->hotel_rent_items->first();

                if (!$rent_item || !$rent_item->hotel_rent || !$rent_item->payments->count()) {
                    continue;
                }

                $next_payment = $rent_item->payments->first();
                $customer = $rent_item->hotel_rent->customer;
                if (!$customer || !$customer->telephone) {
                    continue;
                }
                $customer_name = $customer->name;
                $customer_telephone = $customer->telephone;
                $payment_date = Carbon::parse($next_payment->date_payment)->startOfDay();
                $payment_date_formatted = $months_spanish[$payment_date->format('n') - 1];
                $current_date = Carbon::now()->startOfDay();
                $current_time = $current_date->format('H:i');

                // Obtener configuración de mensajes WhatsApp
                $whatsapp_settings = HotelRentWhatsapp::where('active', true)->get();

                foreach ($whatsapp_settings as $setting) {
                    if ($setting->send_time !== $current_time) {
                        continue;
                    }



                    $days_difference = $current_date->diffInDays($payment_date, false);
                    // Para mensajes antes del vencimiento
                    if ($setting->type === 'before_due' && $days_difference > 0) {
                        $message = $setting->getMessage($customer_name, $room->getTableFullName(), $payment_date_formatted, $days_difference, $number_pay_digital, $bank_description, $number_activity);
                        $message = str_replace(". ", ".\n", $message);
                        // Si los días de diferencia coinciden con los configurados
                        if ($days_difference === $setting->days) {


                            $whatsapp->sendMessage($message, $customer_telephone);
                        }
                    }
                    // Para mensajes después del vencimiento
                    elseif ($setting->type === 'after_due' && $days_difference < 0) {
                        $message = $setting->getMessage($customer_name, $room->getTableFullName(), $payment_date_formatted, $days_difference, $number_pay_digital, $bank_description, $number_activity);
                        $message = str_replace(". ", ".\n", $message);
                        // Si los días de diferencia coinciden con los configurados
                        if (abs($days_difference) === $setting->days) {

                            $whatsapp->sendMessage($message, $customer_telephone);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error en checkAndSendWhatsappMessages: " . $e->getMessage() . ' - ' . $e->getLine() . ' - ' . $e->getFile());
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Log::debug('Aqui se ejecuta tarea Progrmada '. Carbon::now()->format('H:i').':00');

        if (Schema::connection('tenant')->hasTable('tasks')) {
            // Si la tabla existe, continuar con el proceso
            foreach (Task::where('execution_time', Carbon::now()->format('H:i') . ':00')->get() as $task) {
                try {
                    Artisan::call($task->class);
                    $task->output = Artisan::output();
                    $task->save();
                } catch (\Exception $e) {
                    $task->output = $e->getMessage();
                    $task->save();
                }
            }
        }

        // Ejecutar verificación de mensajes de WhatsApp
        $this->checkAndSendWhatsappMessages();
    }
}
