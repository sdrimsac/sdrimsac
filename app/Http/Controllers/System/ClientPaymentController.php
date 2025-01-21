<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\ClientPaymentRequest;
use App\Http\Requests\System\DocumentRequest;
use App\Http\Resources\System\ClientPaymentCollection;
use App\Models\System\Client;
use App\Models\System\ClientPayment;
use App\Models\System\PaymentMethodType;
use App\Models\System\CardBrand;
use App\Models\System\Configuration;
use Hyn\Tenancy\Environment;
use Illuminate\Support\Facades\DB;



class ClientPaymentController extends Controller
{
    public function records($client_id)
    {
        $records = ClientPayment::where('client_id', $client_id)->get();

        return new ClientPaymentCollection($records);
    }

    public function record($id){
        $record = ClientPayment::find($id);
        return response()->json($record);
    }

    public function tables()
    {
        return [
            'payment_method_types' => PaymentMethodType::all(),
            'card_brands' => CardBrand::all()
        ];
    }

    public function client($client_id)
    {
        $client = Client::find($client_id);

        $total_paid = collect($client->payments)->where('state',true)->sum('payment');
        $total = collect($client->payments)->sum('payment');
        $total_difference = round($total - $total_paid, 2);

        return [
            'name' => $client->name,
            'pricing' => $client->plan->pricing,
            'total_paid' => $total_paid,
            'total' => $total,
            'total_difference' => $total_difference
        ];

    }
    function format_message_client_before_end($message,$client_payment,$configuration){
        $payment_date = date('d-m-Y',strtotime($client_payment->date_of_payment));
        $number_communication = $configuration->number_communication;
        $number_payment = $configuration->number_payment;
        $message = str_replace("DD-MM-AAAA", $payment_date, $message);
        $message = str_replace("#########", $number_payment, $message);
        $message = str_replace("%%%%%%%%%", $number_communication, $message);
    
        $client_payment->message_client_before_end = $message;
        $client_payment->save();
    }

    function format_message_client_after_end($message,$client_payment,$configuration){
        $payment_date = date('d-m-Y',strtotime($client_payment->date_of_payment));
        $number_communication = $configuration->number_communication;
        $number_payment = $configuration->number_payment;
        $message = str_replace("DD-MM-AAAA", $payment_date, $message);
        $message = str_replace("XX:XXXX", "12:00PM", $message);
        $message = str_replace("S/SS", "S/20", $message);
        $message = str_replace("#########", $number_payment, $message);
        $message = str_replace("%%%%%%%%%", $number_communication, $message);

        $week_day = date('l', strtotime($client_payment->date_of_payment));
        $month = date('F', strtotime($client_payment->date_of_payment));
        $year = date('Y', strtotime($client_payment->date_of_payment));
        $spanish_months = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];
        $spanish_days = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes', 
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        $spanish_month = $spanish_months[$month];
        $spanish_day = $spanish_days[$week_day];
        $message = str_replace("dddddd", $spanish_day, $message);
        $message = str_replace("MMMMMMMMMMM", $spanish_month, $message);
        $message = str_replace("AAAA", $year, $message);
        $client_payment->message_client_after_end = $message;
        $client_payment->save();
    }

    public function store(ClientPaymentRequest $request)
    {
        $configuration = Configuration::first();

        $id = $request->input('id');
        $configuration = Configuration::first();
        $record = ClientPayment::firstOrNew(['id' => $id]);
        $record->fill($request->all());
        $record->save();

        if($record->message_client_before_end == null){
            $this->format_message_client_before_end($configuration->message_client_before_end,$record,$configuration);
        }

        if($record->message_client_after_end == null){
            $this->format_message_client_after_end($configuration->message_client_after_end,$record,$configuration);
        }

        $client = Client::findOrFail($request->client_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);

        DB::connection('tenant')->table('account_payments')->insert(

            ['date_of_payment' => $record->date_of_payment, 'reference_id' => $record->id, 'payment_method_type_id'=> $record->payment_method_type_id, 'card_brand_id' =>$record->card_brand_id, 'reference' => $record->reference, 'payment' => $record->payment, 'state' => 0, 'created_at' => date('Y-m-d H:i:s')]
        );

        return [
            'success' => true,
            'message' => ($id)?'Pago editado con éxito':'Pago programado con éxito'
        ];
    }

    public function destroy($id)
    {
        $item = ClientPayment::findOrFail($id);
        $item->delete();

        return [
            'success' => true,
            'message' => 'Pago eliminado con éxito'
        ];
    }


    public function cancel_payment($client_payment_id)
    {
        $client_payment = ClientPayment::find($client_payment_id);
        $client_payment->state = true;
        $client_payment->save();

        $client = Client::findOrFail($client_payment->client_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);
        DB::connection('tenant')->table('account_payments')->where('reference_id', $client_payment->id)->update(['state' => 1, 'date_of_payment_real' => date('Y-m-d')]);

        return [
            'success' => true,
            'message' => 'Monto pagado', 
        ];

    } 
}
