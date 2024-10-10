<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use Carbon\Carbon;
use App\Models\Tenant\RegisterMovement;
use Hyn\Tenancy\Environment;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {

            $type = '';
            switch ($row->type) {
                case 'admin':
                    $type =  'Administrador' ;
                    break;
                case 'seller':
                    $type =  'Vendedor' ;
                        break;
                case 'client':
                    $type =  'Cliente' ;
                    break;
                case 'drivers':
                    $type =  'Conductor' ;
                    break;
                default:
                    # code...
                    break;
            }

            return [
                'last_register' => $this->get_last_document($row),
                'id' => $row->id,
                'email' => $row->email,
                'name' => $row->name,
                'pin' => $row->pin,
                'can_accept_credit_sale_note' => (bool) $row->can_accept_credit_sale_note,
                'api_token' => $row->api_token,
                'establishment_id' => $row->establishment_id,
                'establishment_description' => optional($row->establishment)->description,
                'type' =>$type,
                'area' => optional($row->area)->description,
                'license' => $row->license,
                'category' => $row->category,
                'locked' => (bool) $row->locked,
                'active' => (bool) $row->active,
                'establishment_table_id' => $row->establishment_table_id,
                'warehouse_product_id' => $row->warehouse_product_id,
                'state' => $row->state,
            ];
        });
    }
    function get_last_document($row){

        $last_register_movement = RegisterMovement::where('user_id', $row->id)->orderBy('id', 'desc')->first();
        $data = [
            'user'=>'',
            'date_time' => '',
            'description' => '',
        ];
        if($last_register_movement){
            $date_time = $last_register_movement->created_at;
            $data = [
                'user'=>$last_register_movement->user->name,
                'description' =>$last_register_movement->description,
                'date_time' => $this->get_date_difference($date_time),
                
            ];
        }
        return $data;
    }
    function get_date_difference($created_at){
        $currentDay = Carbon::now();
        $created_at = Carbon::parse($created_at);
        
        $difference = $created_at->diff($currentDay);
        $days = $difference->days;
        $hours = $difference->h;
        $minutes = $difference->i;
        $seconds = $difference->s;
        $is24Hours = false;
        if($days > 0){
            $is24Hours = true;
        }
        $data = [
            'is24Hours' => $is24Hours,
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds
        ];
        return $data;
    }
}
