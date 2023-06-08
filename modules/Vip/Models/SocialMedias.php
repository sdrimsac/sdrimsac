<?php

namespace Modules\Vip\Models;

use App\Models\Tenant\ModelTenant;

class SocialMedias extends ModelTenant
{

    public $timestamps = true;
    protected $table = "social_medias";
    protected $casts = [
        "active" => "bool"
    ];
    protected $fillable = [
        'description',
        'active',

    ];
}
