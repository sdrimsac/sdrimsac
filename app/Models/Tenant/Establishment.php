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
        'customer.identity_document_type',
        'conf'
        // Removed eager loading of location data to optimize performance
        // 'country', 'department', 'province', 'district',
    ];
    protected $fillable = [
        'account_workers',
        'credit_warehouse',
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
        'image_yape',
    ];
    protected $casts = [
        'credit_warehouse' => 'boolean',
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
    }    public function getAddressFullAttribute()
    {
        $address = ($this->address != '-') ? $this->address . ' ,' : '';
        
        // Load only the specific location models we need without their relationships
        if (!$this->relationLoaded('department')) {
            $this->load(['department' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        if (!$this->relationLoaded('province')) {
            $this->load(['province' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        if (!$this->relationLoaded('district')) {
            $this->load(['district' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        $dept = $this->department ? $this->department->description : '';
        $prov = $this->province ? $this->province->description : '';
        $dist = $this->district ? $this->district->description : '';
        
        return "{$address} {$dept} - {$prov} - {$dist}";
    }
      /**
     * Get location data in a structured way
     *
     * @return array Location data including country, department, province and district
     */
    public function getLocationDataAttribute()
    {
        // Load only necessary fields for each location entity
        $locationEntities = ['country', 'department', 'province', 'district'];
        
        foreach ($locationEntities as $entity) {
            if (!$this->relationLoaded($entity) && $this->{$entity.'_id'}) {
                $this->load([$entity => function($query) {
                    $query->select('id', 'description');
                }]);
            }
        }
        
        return [
            'country' => $this->country ? [
                'id' => $this->country->id,
                'description' => $this->country->description
            ] : null,
            'department' => $this->department ? [
                'id' => $this->department->id,
                'description' => $this->department->description
            ] : null,
            'province' => $this->province ? [
                'id' => $this->province->id,
                'description' => $this->province->description
            ] : null,
            'district' => $this->district ? [
                'id' => $this->district->id,
                'description' => $this->district->description
            ] : null
        ];
    }
}
