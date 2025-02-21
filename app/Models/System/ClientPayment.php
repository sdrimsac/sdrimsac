<?php

namespace App\Models\System;

use App\Http\Controllers\System\ClientPaymentController;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    protected $with = ['payment_method_type', 'card_brand'];

    protected $fillable = [
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
        $message = $this->message_client_before_end;
        $message = str_replace("<br>", "\n", $message);
        (new ClientPaymentController)->sendMessage($message, $number);
        $before_video_url = $configuration->before_video_url;
        (new ClientPaymentController)->sendVideo($before_video_url, $number);
    }
    public function send_message_after_end()
    {
        $configuration = Configuration::first();
        $client = $this->client;
        if(!$client->phone) return; 
        $number = $client->phone;
        $message = $this->message_client_after_end;
        $message = str_replace("<br>", "\n", $message);
        (new ClientPaymentController)->sendMessage($message, $number);
        $after_video_url = $configuration->after_video_url;
        (new ClientPaymentController)->sendVideo($after_video_url, $number);
    }
    

}