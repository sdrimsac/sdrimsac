<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Reviews extends ModelTenant
{
    protected $with = ['vehicle'];
    protected $table="reviews";         //nombre tabla
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
    'date_latest_reviews',                        //fechaultimo_revision
    'date_next_reviews',                         //fechaproximo_revision
    'description',                              // descripcion
    'vehicle_id',                              //relacion tabla vehiculo
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }  
}
