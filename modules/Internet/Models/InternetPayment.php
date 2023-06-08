<?php

namespace Modules\Internet\Models;

use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use App\Models\Tenant\ModelTenant;

class InternetPayment extends ModelTenant
{
    public $timestamps = true;
    protected $fillable = [
        "document_id",
        "sale_note_id",
        "operation_id",
        "type",
        "active",
        "rest",
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
    protected $with = ["sale_note", "document", "months"];


    public function operation()
    {
        return $this->belongsTo(InternetOperation::class, 'operation_id');
    }
    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class, 'sale_note_id');
    }
    public function get_document()
    {
        //check if document is null or sale_note is null and return the other
        if ($this->document_id) {
            return $this->document;
        } else {
            return $this->sale_note;
        }
    }
    public function months()
    {

        return $this->hasMany(InternetPaymentMonth::class, 'payment_id');
    }


    public function paymentMonths()
    {

        return $this->hasMany(InternetPaymentMonth::class, 'payment_id');
    }
}
