<?php

namespace App\Console\Commands;


use App\Models\Tenant\HotelRentItem;
use App\Models\Tenant\HotelRentPenaltySetting;
use App\Models\Tenant\HotelRentPenalty;
use Illuminate\Console\Command;
use Modules\Restaurant\Models\Table;

// app/Console/Commands/CalculateRentPenalties.php
class CalculateRentPenalties extends Command

{
    protected $signature = 'rents:calculate-penalties';
    
    public function handle()
    {
        $pendingRents = HotelRentItem::where('active', true)
            ->where('is_paid', false)
            ->get();

        foreach($pendingRents as $rent) {
            $this->calculatePenalty($rent->id);
        }
    }


    private function calculatePenalty($rentId)
    {
        $hotel_rent_item = HotelRentItem::find($rentId);
        $total_amount = $hotel_rent_item->total;
        $total_amount_by_day = $total_amount / 30;

        $table = Table::find($hotel_rent_item->table_id);
        $table_type_id = $table->table_type_id;
        $hotel_rent_penalties_settings = HotelRentPenaltySetting::where('table_type_id', $table_type_id)->first();
        if(!$hotel_rent_penalties_settings){
            $hotel_rent_penalties_settings = HotelRentPenaltySetting::whereNull('table_type_id')->first();
        }
        if(!$hotel_rent_penalties_settings){
            return;
        }
        $payments = $hotel_rent_item->payments()
            ->where('is_paid', false)
            ->where('is_warranty', false)
            ->where('date_payment', '<=', now())
            ->orderBy('id', 'desc')
            ->get();
        $is_percentage = $hotel_rent_penalties_settings->is_percentage;
        $amount_per_day = $hotel_rent_penalties_settings->amount_per_day;
        $grace_period_days  = $hotel_rent_penalties_settings->grace_period_days;

        HotelRentPenalty::where('hotel_rent_item_id', $rentId)
        ->where('status', 'pending')
        ->delete();

        $days_late = 0;

        foreach($payments as $payment){
            $days_difference = now()->diffInDays($payment->date_payment);
            $days_late += $days_difference;
        }
        if($days_late > $grace_period_days) {
            $penalty_amount = 0;
            $days_to_charge = $days_late - $grace_period_days; 
            
            if($is_percentage){
                $penalty_amount = ($total_amount_by_day * $amount_per_day / 100) * $days_to_charge;
            }else{
                $penalty_amount = $amount_per_day * $days_to_charge;
            }

            HotelRentPenalty::create([
                'hotel_rent_item_id' => $rentId,
                'days_late' => $days_late,
                'amount' => $penalty_amount,
                'status' => 'pending'
            ]);

            $hotel_rent_item->update([
                'total_penalties' => $penalty_amount
            ]);
        }else{
        }
    }


}