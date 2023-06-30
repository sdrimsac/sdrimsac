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
    ];
    

    public function person(){

        return $this->belongsTo(Person::class);
    }

}