<?php

namespace App\Models\Tenant;



class HotelRent extends ModelTenant
{
    protected $fillable = [
        'customer_id',
        'user_id',
        'establishment_id',
        'customer',
        'was_cancel',
        'observation',
        'payment_type',
        'payment_number_operation',
        'payment_status',
        'total',
        'paid',
        'document_id',
        'sale_note_id',
    ];


    

    public function getCustomerAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setCustomerAttribute($value)
    {
        $this->attributes['customer'] = (is_null($value)) ? null : json_encode($value);
    }
    
    public function items()
    {
        return $this->hasMany(HotelRentItem::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

    public function customer()
    {
        return $this->belongsTo(Person::class);
    }
    
    public function has_many_rooms()
    {
        return $this->items->count() > 1;
    }

    
}