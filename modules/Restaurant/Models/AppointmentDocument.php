<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\SaleNote;

class AppointmentDocument extends ModelTenant
{
    use HasFactory;

    protected $table = 'appointments_documents';
    protected $fillable = [
        'user_schedule_appointments',
        'document_id',
        'sale_note_id',
    ];  

    public function userScheduleAppointment()
    {
        return $this->belongsTo(UserScheduleAppointment::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    
    public function saleNote()
    {
        return $this->belongsTo(SaleNote::class);
    }

}
