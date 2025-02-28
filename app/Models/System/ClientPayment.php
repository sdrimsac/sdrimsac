<?php

namespace App\Models\System;

use App\Http\Controllers\System\ClientPaymentController;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ClientPayment extends Model
{
    protected $with = ['payment_method_type', 'card_brand'];

    protected $fillable = [
        'send_whatsapp',
        'client_id',
        'date_of_payment',
        'end_payment',
        'payment_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'payment',
        'state',
        'message_client_before_end',
        'message_client_after_end',
        'document',
        'document_url',
    ];

    protected $casts = [
        'date_of_payment' => 'date',
        'end_payment' => 'date',
    ];

    public function payment_method_type()
    {
        return $this->belongsTo(PaymentMethodType::class);
    }

    public function card_brand()
    {
        return $this->belongsTo(CardBrand::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function send_message_before_end()
    {
        $configuration = Configuration::first();
        $client = $this->client;
        if(!$client->phone) return;
        $number = $client->phone;
        $to_group = $client->sent_to_group;
        if($to_group && $client->group_whatsapp){
            $number = $client->group_whatsapp;
        }else{
            $to_group = false;
        }
        $message = $this->message_client_before_end;
        $message = str_replace("<br>", "\n", $message);
        $response = (new ClientPaymentController)->sendMessage($message, $number,$to_group);
        if($response['success']){
            $this->update(['send_whatsapp' => 1]);
        }
        $before_video_url = $configuration->before_video_url;
        $response = (new ClientPaymentController)->sendVideo($before_video_url, $number,$to_group);
        if($response['status']){
            $this->update(['send_whatsapp' => 1]);
        }
    
    }
    public function send_message_after_end()
    {
        $configuration = Configuration::first();
        $client = $this->client;
        if(!$client->phone) return; 
        $number = $client->phone;
        $to_group = $client->sent_to_group;
        if($to_group && $client->group_whatsapp){
            $number = $client->group_whatsapp;
        }else{
            $to_group = false;
        }
        $message = $this->message_client_after_end;
        $message = str_replace("<br>", "\n", $message);
        $response = (new ClientPaymentController)->sendMessage($message, $number,$to_group);
        if($response['success']){
            $this->update(['send_whatsapp' => 1]);
        }
        $after_video_url = $configuration->after_video_url;
        $response = (new ClientPaymentController)->sendVideo($after_video_url, $number,$to_group);
        if($response['status']){
            $this->update(['send_whatsapp' => 1]);
        }
    }
    

}