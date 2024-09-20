<?php

namespace App\Models\Tenant;


class Consolidated extends ModelTenant

{
    // public $timestamps = false;
    protected $table = "consolidated";
    protected $fillable = [
        "user_id",
        "establishment_id",
        "date_of_issue",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
 
}
