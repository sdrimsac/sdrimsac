<?php

namespace App\Models\Tenant;


class HotelRentDocument extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_documents';
    protected $with = ['document', 'sale_note'];
    protected $fillable = [
        'sale_note_id',
        'document_id',
        'hotel_rent_id',
    ];


    public function hotel_rent()
    {
        return $this->belongsTo(HotelRent::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

}
