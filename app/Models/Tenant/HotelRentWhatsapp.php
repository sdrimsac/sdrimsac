<?php

namespace App\Models\Tenant;


class HotelRentWhatsapp extends ModelTenant
{
    protected $table = 'hotel_rent_whatsapp';

    protected $fillable = [
        'type',
        'message_order',
        'content',
        'days',
        'send_time',
        'active'
    ];

    protected $casts = [
        'days' => 'integer',
        'message_order' => 'integer',
        'active' => 'boolean',
        'send_time' => 'datetime:H:i',
    ];

    /**
     * Obtiene los mensajes antes del vencimiento
     */
    public static function getBeforeDueMessages()
    {
        return self::where('type', 'before_due')
            ->where('active', true)
            ->orderBy('message_order')
            ->get();
    }

    /**
     * Obtiene los mensajes después del vencimiento
     */
    public static function getAfterDueMessages()
    {
        return self::where('type', 'after_due')
            ->where('active', true)
            ->orderBy('message_order')
            ->get();
    }

    /**
     * Formatea los mensajes para el frontend
     */
    public static function getFormattedMessages()
    {
        $before_due = self::where('type', 'before_due')
            ->orderBy('message_order')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'days' => $message->days,
                    'time' => $message->send_time,
                    'image_path' => $message->image_path,
                    'active' => $message->active
                ];
            });

        $after_due = self::where('type', 'after_due')
            ->orderBy('message_order')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'days' => $message->days,
                    'time' => $message->send_time,
                    'image_path' => $message->image_path,
                    'active' => $message->active
                ];
            });

        return [
            'before_due' => $before_due,
            'after_due' => $after_due
        ];
    }

    /**
     * Guarda o actualiza un mensaje
     */
    public static function saveMessage($data, $type, $order)
    {
        return self::updateOrCreate(
            [
                'type' => $type,
                'message_order' => $order
            ],
            [
                'content' => $data['content'],
                'days' => $data['days'],
                'send_time' => $data['time'],
                'active' => $data['active'] ? 1 : 0
            ]
        );
    }


    public  function getMessage($customer_name, $room_name, $payment_date, $days_difference, $number_pay_digital, $bank_description, $number_activity)
    {
        if($this->type === 'before_due') {
            return $this->getMessageBeforeDue($customer_name, $room_name, $payment_date, $days_difference, $number_pay_digital, $bank_description, $number_activity);
        } else {
            return $this->getMessageAfterDue($customer_name, $room_name, $payment_date, $days_difference, $number_pay_digital, $bank_description, $number_activity);
        }
        
    }

    private function getMessageBeforeDue($customer_name, $room_name, $payment_date, $days_difference, $number_pay_digital, $bank_description, $number_activity)
    {
        
        $message = str_replace(
            ['{{huesped}}', '{{mes}}', '{{yape/plin}}', '{{banco}}', '{{numero_whatsapp}}'],
            [
                $customer_name,
                $payment_date,
                $number_pay_digital,
                $bank_description,
                $number_activity
            ],
            $this->content
        );
        
        return $message;
    }

    private function getMessageAfterDue($customer_name, $room_name, $payment_date, $days_difference, $number_pay_digital, $bank_description, $number_activity)
    {

        //Sr. Inquilino {{huesped}}  le comunica que ya se encuentra VENCIDO su recibo de pago  correspondiente al mes {{mes}}  Tiene (1) día(s) de atraso,  recuerde que puede pagar a través de las plataformas de Yape "numero de registrado para yape" o a la  cuenta {{banco}}  y confirmar enviando el Boucher al número de WhatsApp {{numero_whatsapp}} Si ya pago omita este mensaje Atte. La Gerencia General
        $message = str_replace(
            ['{huesped}', '{mes}', '{yape/plin}', '{banco}', '{numero_whatsapp}'],
            [
                $customer_name,
                $payment_date,
                $number_pay_digital,
                $bank_description,
                $number_activity
            ],
            
            $this->content
        );
        return $message;
    }
    
} 