<?php

namespace App\Models\Tenant;

use Modules\Restaurant\Models\Table;

class HotelRentItem extends ModelTenant
{
    public $timestamps = false;
    protected $table = 'hotel_rent_items';
    protected $fillable = [
        'was_cancel',
        'is_reserve',
        'advances',
        'sale_note_id',
        'document_id',
        'hotel_rent_id',
        'table_id',
        'duration',
        'quantity_persons',
        'payment_status',
        'checkin_date',
        'checkin_time',
        'checkout_date',
        'checkout_time',
        'total',
        'extra_time',
        'is_month_rent',
    ];

    protected $casts = [
        'is_month_rent' => 'boolean',
        'is_reserve' => 'boolean',  
    ];

    public function hotel_rent()
    {
        return $this->belongsTo(HotelRent::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function guesses()
    {
        return $this->belongsToMany(Person::class, 'hotel_rent_item_person');
    }

}
