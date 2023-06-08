<?php

namespace Modules\College\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

use Modules\College\Models\CollegePenalty as ModelsCollegePenalty;

class CollegePenaltyService extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_penalty_services";
    protected $with = ["item"];
    protected $fillable = [
        'penalty_id',
        'item_id',
        'price',
        'active',
    ];

    public function penalty()
    {
        return $this->belongsTo(ModelsCollegePenalty::class, 'penalty_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
