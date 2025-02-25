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
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleHttpClient;
use Hyn\Tenancy\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientPaymentController extends Controller
{
    protected $client;

    public function messages(Request $request, $client_payment_id){
        $client_payment = ClientPayment::find($client_payment_id);
        $client_payment->message_client_before_end = $request->message_client_before_end;
        $client_payment->message_client_after_end = $request->message_client_after_end;
        $client_payment->save();
        return [
            'success' => true,
            'message' => 'Mensaje enviado con éxito'
        ];
    }
    public function sendMessage($message, $number)
    {
        $web_whatsapp = config('app.web_whatsapp');
        $url = "https://" . $web_whatsapp . "/api/send-message";

        // Reemplazar <br> por saltos de línea
        $message = str_replace('<br>', "\n", $message);

        try {
            $response = Http::withoutVerifying()->post($url, [
                'number' => "51" . $number,
                'sender' => 'sdrimsac',
                'message' => $message,
            ]);

            $status = $response->status();
            $body = $response->body();
            return [
                "success" => $status == 200,
                "message" => $body


            ];
        } catch (\Exception $e) {
            Log::error("Error al enviar el mensaje por WhatsApp: ", [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ];
        }
    }
    public function sendPaymentsMessages()
    {
        $now = Carbon::now();
        $isLastDayOfMonth = $now->endOfMonth()->day === $now->day;
        $payments = ClientPayment::where('state', 0)->get();
        foreach ($payments as $payment) {
            $payment_date = Carbon::parse($payment->date_of_payment);
            $diff_days = $now->diffInDays($payment_date);
            
            if($diff_days > 6) {
                continue;
            }
            if($isLastDayOfMonth){
                $payment->send_message_after_end();
            }else{

                $payment->send_message_before_end();
            }
            sleep(rand(1, 3));
        }
        return response()->json([
            'success' => true,
            'message' => 'Mensajes enviados correctamente'
        ]);
    }
    public function sendVideo($video, $number = null)
    {
        $web_whatsapp = config('app.web_whatsapp');
        $url = "https://" . $web_whatsapp . '/api/send-media';
        
        $video = str_replace('/storage/', '', $video);
        $video_path = Storage::disk('public')->path($video);
        if (!file_exists($video_path)) {
            return [
                "message" => "El archivo de video no existe en la ruta especificada",
                "path" => $video_path
            ];
        }
        
        $content_file = file_get_contents($video_path);
        $extension = pathinfo($video, PATHINFO_EXTENSION);

        $client = new GuzzleHttpClient([
            'verify' => false,
            'stream' => false,
            'headers' => [
                'User-Agent' => 'Testing 1.0'
            ]
        ]);
        try {
            $response = $client->post($url, [
                'multipart' => [
                    [
                        'name'     => 'number',
                        'contents' => "51" . $number
                    ],

                    [
                        'name'     => 'sender',
                        'contents' =>   'sdrimsac'
                    ],
                    [
                        'name'     => 'file',
                        'contents' => $content_file,
                        'filename' => $video . "." . $extension
                    ],

                ]
            ]);

            $body = $response->getBody()->getContents();
        } catch (\Exception $e) {
            return [
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ];
        }
    }
    public function records($client_id)
    {
        $records = ClientPayment::where('client_id', $client_id)->get();

        return new ClientPaymentCollection($records);
    }

    public function record($id)
    {
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

        $total_paid = collect($client->payments)->where('state', true)->sum('payment');
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
    function format_message_client_before_end($message, $client_payment, $configuration)
    {
        $payment_date = date('d-m-Y', strtotime($client_payment->date_of_payment));
        $number_communication = $configuration->number_communication;
        $number_payment = $configuration->number_payment;
        $message = str_replace("DD-MM-AAAA", $payment_date, $message);
        $message = str_replace("#########", $number_payment, $message);
        $message = str_replace("%%%%%%%%%", $number_communication, $message);

        $client_payment->message_client_before_end = $message;
        $client_payment->save();
    }

    function format_message_client_after_end($message, $client_payment, $configuration)
    {
        $payment_date = date('d-m-Y', strtotime($client_payment->date_of_payment));
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

        if ($record->message_client_before_end == null) {
            $this->format_message_client_before_end($configuration->message_client_before_end, $record, $configuration);
        }

        if ($record->message_client_after_end == null) {
            $this->format_message_client_after_end($configuration->message_client_after_end, $record, $configuration);
        }

        $client = Client::findOrFail($request->client_id);
        $tenancy = app(Environment::class);
        $tenancy->tenant($client->hostname->website);

        DB::connection('tenant')->table('account_payments')->insert(

            ['date_of_payment' => $record->date_of_payment, 'reference_id' => $record->id, 'payment_method_type_id' => $record->payment_method_type_id, 'card_brand_id' => $record->card_brand_id, 'reference' => $record->reference, 'payment' => $record->payment, 'state' => 0, 'created_at' => date('Y-m-d H:i:s')]
        );

        return [
            'success' => true,
            'message' => ($id) ? 'Pago editado con éxito' : 'Pago programado con éxito'
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
    public function cancel_payment_client(Request $request)
    {
        $client_payment_id = $request->client_payment_id;
        $document = $request->document;
        $document_url = $request->ticket;
        $client_payment = ClientPayment::find($client_payment_id);
        $client_payment->document = $document;
        $client_payment->document_url = $document_url;
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

    public function sendWhatsappMessage(Request $request, $client_payment_id) 
    {
        try {
            $configuration = Configuration::first();
            $client_payment = ClientPayment::find($client_payment_id);
            
            if (!$client_payment) {
                return [
                    'success' => false,
                    'message' => 'Pago de cliente no encontrado'
                ];
            }
            $url_video = null;
            // Guardar el mensaje actualizado
            if ($request->message_type === 'before') {
                $client_payment->message_client_before_end = $request->message;
                $url_video = $configuration->before_video_url;
            } else {
                $client_payment->message_client_after_end = $request->message;
                $url_video = $configuration->after_video_url;
            }
            $client_payment->save();

            // Obtener el número de teléfono del cliente
            $client = $client_payment->client;
            if (!$client || !$client->phone) {
                return [
                    'success' => false,
                    'message' => 'El cliente no tiene número de teléfono registrado'
                ];
            }

            // Enviar el mensaje por WhatsApp
            $response_success_message = $this->sendMessage($request->message, $client->phone);
            if($url_video){
                $response_success_video = $this->sendVideo($url_video, $client->phone );
            }
            $message_response = "El mensaje se envió ";
            $message_response .= $response_success_message['success'] ? "correctamente" : "con error";
            
            if($url_video) {
                sleep(rand(1, 3));
                $message_response .= " y el video se envió ";
                $message_response .= isset($response_success_video) ? "correctamente" : "con error";
            }
            
            return [
                'success' => true,
                'message' => $message_response
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
            ];
        }
    }
}
