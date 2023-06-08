<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class SummaryDocument extends ModelTenant
{
    protected $with = ['document'];
    public $timestamps = false;

    protected $fillable = [
        'summary_id',
        'document_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}