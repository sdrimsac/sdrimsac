<?php

namespace Modules\Billar\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;
use Modules\Restaurant\Models\Table;

class Casino extends ModelTenant
{
    protected $table = 'casino';
    
    protected $fillable = [
        'table_id',
        'customer_id',
        'reference',
        'date_start',
        'time_start',
        'minutes',
        'date_end',
        'time_end',
        'active',
        'created_at',
        'updated_at',
    ];
    public function customer(){
        return $this->belongsTo(Person::class,'customer_id' , 'id');
    }
    public function table(){
        return $this->belongsTo(Table::class,'table_id');
    }
}