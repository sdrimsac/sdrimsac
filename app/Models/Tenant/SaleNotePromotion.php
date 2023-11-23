<?php

namespace App\Models\Tenant;

use Modules\Restaurant\Models\HotelRentItemServices;

class SaleNotePromotion extends ModelTenant
{
    protected $table = 'sale_notes_promotions';
    protected $with = ['sale_note'];
    protected $fillable = [
        'sale_note_id',
        'hotel_rent_item_service_id',
    ];

    protected $casts = [
        'is_advance' => 'boolean',
    ];

    public function hotel_rent_item_service()
    {
        return $this->belongsTo(HotelRentItemServices::class);
    }

  

    public function sale_note()
    {
        return $this->belongsTo(SaleNote::class);
    }

}
