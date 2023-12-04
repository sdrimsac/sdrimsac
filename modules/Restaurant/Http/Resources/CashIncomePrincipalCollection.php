<?php

namespace Modules\Restaurant\Http\Resources;

use App\Models\Tenant\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class CashIncomePrincipalCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($row, $key) {
            $cash = $row->cash;
            $user_id = $cash->user_id;
            $user = User::find($user_id);
            $user_name = $user->name;
            return [
                'user_name' => $user_name,
                'id'          => $row->id,
                'cash_principal_id' => $row->cash_principal_id,
                'cash_id' => $row->cash_id,
                'comment' => $row->comment,
                'amount' => $row->amount,
                'status' => $row->status,
                'status_description' => $this->status_description($row->status), 
                'active' => $row->active,
                'cash_principal' => $row->cash_principal,
                'cash' => $row->cash,

            ];
        });
    }

    function status_description($status){
        if($status == 1){
            return 'Pendiente';
        }else if($status == 2){
            return 'Observado';
        }else if($status == 3){
            return 'Aceptado';
        }

    }
}
