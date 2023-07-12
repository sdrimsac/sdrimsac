<?php

namespace Modules\Consignment\Models;
 

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;

class Consignment extends ModelTenant
{
    protected $fillable = [
        'person_id',
        'date_of_issue',
        'date_of_end',
        'penalty_id',
        'active',
        'liquidated',
    ];
    

    public function person(){

        return $this->belongsTo(Person::class);
    }
    public function items(){
            
            return $this->hasMany(ConsignmentItem::class);
    }
    public function penalty(){
            
            return $this->belongsTo(ConsignmentPenalty::class);
    }

}