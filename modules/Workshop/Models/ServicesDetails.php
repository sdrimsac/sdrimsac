<?php

namespace Modules\Workshop\Models;

use App\Models\Tenant\ModelTenant;

use Modules\Workshop\Models\Services;

class ServicesDetails extends ModelTenant
{
    protected $table = 'services_details';
    
    protected $fillable = [
        'service_id',
        'name',
        'description',
        'date_start',
        'date_end',
        'status',
        'price_unit',
        
    ];
    protected $casts = [
        'price_unit' => 'decimal:2',
        ];
    public function service(){
        return $this->belongsTo(Services::class,'service_id');
    }
    
}