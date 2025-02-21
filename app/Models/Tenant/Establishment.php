<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\Department;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\Province;
use Illuminate\Database\Eloquent\Model;

class Establishment extends ModelTenant
{
    protected $with = [
        'customer',
        'country', 'department', 'province', 'district',
        'conf'
    ];
    protected $fillable = [
        'android_configuration',
        'tab_single',
        'is_product',
        'is_service',
        'etiquetadora',
        'description',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'address',
        'email',
        'telephone',
        'code',
        'trade_address',
        'web_address',
        'aditional_information',
        'format_printer',
        'printer',
        'direct_printing',
        'document_default',
        'copies',
        'printer_serve',
        'customer_id',
        'has_igv_31556',
        'logo',
        'document_logo',
        'documents',
    ];
    protected $casts = [
        'android_configuration' => 'boolean',
        'is_product' => 'boolean',
        'is_service' => 'boolean',
        'has_igv_31556' => 'boolean',
        'documents' => 'array'
    ];

    public function conf()
    {
        return $this->hasOne(ConfEstablishment::class, 'establishment_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function documents()
    {
        return $this->belongsTo(document::class, 'establishment_id');
    }
    public function purchase ()
    {
        return $this->hasMany(Purchase::class, 'establishment_id');
    }

    public function getAddressFullAttribute()
    {
        $address = ($this->address != '-') ? $this->address . ' ,' : '';
        return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
    }
}
