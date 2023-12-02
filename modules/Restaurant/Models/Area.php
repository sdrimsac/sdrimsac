<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class Area extends ModelTenant
{

    public $timestamps = false;
    protected $table = "areas";
    protected $casts = [
        "search_print" => "bool"
    ];
    protected $fillable = [
        'description',
        'printer',
        'copies',
        'active',
        'search_print'
    ];


    public function is_hotel()
    {
        return $this->description == 'HOTEL';
    }

    public static function getCajaAreaIdByTableId($table_id)
    {
        $table = Table::find($table_id);
        $establishment_id = $table->establishment_id;
        $users = User::where('establishment_id', $establishment_id)
            ->whereHas('worker_type', function ($query) {
                $query->where('description', 'CAJA');
            })
            ->first();
        if ($users) {
            return $users->area->id;
        }
        return null;
    }
}
