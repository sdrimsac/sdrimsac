<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Travel extends ModelTenant
{
    protected $with = ['vehicle'];
    protected $table="travels";         //nombre tabla
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
    'destination',                          //destino
    'mileage',                              //kilometraje
    'price',                                // precio
    'carga',                                //carga
    'travel_date',                          //fecha viaje
    'vehicle_id',                           //relacion tabla vehiculo
    ];

    public function vehicle()
    {
        return $this->belongsTo(user::class,'vehicle_id','id');
    }  
}
