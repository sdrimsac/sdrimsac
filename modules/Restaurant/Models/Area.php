<?php

namespace Modules\Restaurant\Models;

use App\Models\Tenant\Company;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Log;

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
        'search_print',
        'establishment_id',
    ];


    public function is_hotel()
    {
        return $this->description == 'HOTEL';
    }

    public static function getAreaCajaId()
    {
        $area = Area::where('description', 'like', '%CAJA%')->first();
        if ($area) {
            return $area->id;
        }
        return null;
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
    public static function getAreaEstablishment($id)
    {
        $company = Company::active();
        if($company->number == '20609612208'){
            Log::info('getAreaEstablishment '.$id);
        }
        $establishment_id = auth()->user()->establishment_id;
        if($company->number == '20609612208'){
            Log::info('getAreaEstablishment '.$establishment_id);
        }
        $area = Area::where('id', $id)->first();
        if (!$area) return null;
        $description = $area->description;
        $description = explode(" ", $description);

        $description = $description[0];
        if($company->number == '20609612208'){
            Log::info('getAreaEstablishment '.$description);
        }
        $user = User::where('establishment_id', $establishment_id)
            ->whereHas('area', function ($query) use ($description) {
                $query->where('description', 'like', '%' . $description . '%');
            })
            ->first();
        if ($user) {
            return $user->area_id;
        } else {
            $user = User::whereHas('worker_type', function ($query) use ($description) {
                $query->where('description', 'like', '%' . $description . '%');
            })
                ->first();
            if ($user) {
                return $user->area_id;
            } else {
                $user = User::where('establishment_id', $establishment_id)
                    ->whereHas('area', function ($query) {
                        $query->where('description', 'like', '%CAJA%');
                    })
                    ->first();
                if ($user) {
                    return $user->area_id;
                }
            }
        }
        return null;
    }

    public static function getZoneEstablishment($id)
    {
        $establishment_id = auth()->user()->establishment_id;
        $area = Area::where('id', $id)->first();
        if (!$area) return null;
        $description = $area->description;
        $description = explode(" ", $description);
        $description = $description[0];
        $area_establishment = Area::where('establishment_id', $establishment_id)
            ->where('description', 'like', '%' . $description . '%')
            ->first();
        if ($area_establishment) {
            return $area_establishment->id;
        } else {
            return null;
        }
    }
}
