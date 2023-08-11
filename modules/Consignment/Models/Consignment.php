<?php

namespace Modules\Consignment\Models;
 

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\Person;
use App\Models\Tenant\User;

class Consignment extends ModelTenant
{
    protected $fillable = [
        'person_id',
        'date_of_issue',
        'date_of_end',
        'penalty_id',
        'active',
        'liquidated',
        'user_id',
        'user_liquidated_id',
    ];
    

    public function user(){
            
            return $this->belongsTo(User::class);
    }

    public function user_liquidated(){
            
            return $this->belongsTo(User::class,'user_liquidated_id');
    }

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