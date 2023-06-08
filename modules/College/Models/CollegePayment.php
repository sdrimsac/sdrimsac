<?php

namespace Modules\College\Models;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\ModelTenant;

class CollegePayment extends ModelTenant
{

    public $timestamps = true;
    protected $table = "college_payments";
    protected $with = ["document", "months", "sale_note"];
    protected $fillable = [
        'document_id',
        'register_id',
        'type',
        'active',
        'details',
        'sale_note_id',
    ];
    protected $casts = [
        'details' => 'array'
    ];
    public function months()
    {

        return $this->hasMany(CollegePaymentMonth::class, 'payment_id', 'id');
    }
    public function document()
    {

        return $this->belongsTo(Document::class, 'document_id');
    }
    public function sale_note()
    {

        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }
    public function register()
    {

        return $this->belongsTo(CollegeRegister::class, 'register_id');
    }
}
