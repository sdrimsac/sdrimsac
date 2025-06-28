<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\Department;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\DocumentType;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Catalogs\Province;
use Hyn\Tenancy\Traits\UsesTenantConnection;


class Person extends ModelTenant
{

    use UsesTenantConnection;
    const DEFAULT_USER_IMAGE = 'user.png';

    protected $table = 'persons';
    protected $with = ['identity_document_type', 'country'];
    protected $fillable = [
        'image_extra1',
        'image_extra2',
        'user_id',
        'adderss_secondary',
        'varios',
        'document_type_id',
        'alias',
        'has_credit_line',

        'credit_line',
        'sex',
        'type',
        'identity_document_type_id',
        'number',
        'name',
        'trade_name',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'address',
        'email',
        'telephone',
        'perception_agent',
        'state',
        'condition',
        'percentage_perception',
        'person_type_id',
        'comment',
        'enabled',
        'seller_id',
        'client_zone_id',
        'ref_origin',
        'name_family',
        'telephone_family',
        'image',
        'occupation',
        'parient_id',
        'image_extra1',
        'image_extra2',
    ];
    protected $casts = [
        'has_credit_line' => 'boolean',
        'credit_line' => 'float',
        'varios' => 'boolean',
    ];
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('status', 1);
    //     });
    // }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getCollectionData($withFullAddress = false, $childrens = false, $servers = false)
    {
        $addresses = $this->addresses;
        if ($withFullAddress == true) {
            $addresses = collect($addresses)->transform(function ($row) {
                return $row->getCollectionData();
            });
        }
        $person_type_descripton = '';
        if ($this->person_type !== null) {
            $person_type_descripton = $this->person_type->description;
        }
        $optional_mail = $this->getOptionalEmailArray();
        $optional_mail_send = [];
        if (!empty($this->email)) {
            $optional_mail_send[] = $this->email;
        }
        $total_optional_mail = count($optional_mail);
        for ($i = 0; $i < $total_optional_mail; $i++) {
            $temp = isset($optional_mail[$i]['email']) ? trim($optional_mail[$i]['email']) : null;
            if (!empty($temp) && $temp != $this->email) {
                $optional_mail_send[] = $temp;
            }
        }
        // Obtener datos de ubicación usando el helper
        $locationData = $this->getLocationData();
        $department = $locationData['department'];
        $province = $locationData['province'];
        $district = $locationData['district'];

        $location_id = [];
        if (!empty($department)) {
            array_push($location_id, $department['id']);
        }
        if (!empty($province)) {
            array_push($location_id, $province['id']);
        }
        if (!empty($district)) {
            array_push($location_id, $district['id']);
        }
        $seller = null;
        if (!empty($this->seller_id)) {
            $seller = User::find($this->seller_id);
            if (!empty($seller)) {
                $seller = $seller->getCollectionData();
            }
        }

        $data = [
            'parient_id' => $this->parient_id,
            'occupation' => $this->occupation,
            'ref_origin' => $this->ref_origin,
            'name_family' => $this->name_family,
            'telephone_family' => $this->telephone_family,
            'image' => $this->image,
            'varios' => (bool) $this->varios,
            'document_type_id' => $this->document_type_id,
            'alias' => $this->alias,
            'credit_line' => $this->credit_line,
            'has_credit_line' => (bool) $this->has_credit_line,
            'id' => $this->id,
            'description' => $this->number . ' - ' . $this->name,
            'name' => $this->name,
            'number' => $this->number,
            'identity_document_type_id' => $this->identity_document_type_id,
            'identity_document_type_code' => $this->identity_document_type->code ?? null,
            'address' => $this->address,
            'internal_code' => $this->internal_code ?? null,
            'barcode' => $this->barcode ?? null,
            'observation' => $this->observation ?? null,
            'seller' => $seller,
            'zone' => null, // Puedes ajustar si necesitas traer la zona
            'zone_id' => $this->zone_id ?? null,
            'seller_id' => $this->seller_id,
            'website' => $this->website ?? null,
            'document_type' => $this->identity_document_type->description ?? null,
            'enabled' => (bool)$this->enabled,
            'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => optional($this->updated_at)->format('Y-m-d H:i:s'),
            'type' => $this->type,
            'trade_name' => $this->trade_name,
            'country_id' => $this->country_id,
            'nationality_id' => $this->nationality_id ?? null,
            'department_id' => $department['id'] ?? null,
            'department' => $department,
            'province_id' => $province['id'] ?? null,
            'province' => $province,
            'district_id' => $district['id'] ?? null,
            'district' => $district,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'perception_agent' => (bool)$this->perception_agent,
            'percentage_perception' => $this->percentage_perception,
            'state' => $this->state,
            'condition' => $this->condition,
            'person_type_id' => $this->person_type_id,
            'person_type' => $person_type_descripton,
            'contact' => $this->contact ?? null,
            'comment' => $this->comment,
            'addresses' => $addresses,
            'parent_id' => $this->parent_id,
            'credit_days' => (int)($this->credit_days ?? 0),
            'optional_email' => $optional_mail,
            'optional_email_send' => implode(',', $optional_mail_send),
            'childrens' => [],
            'accumulated_points' => $this->accumulated_points ?? null,
            'has_discount' => $this->has_discount ?? null,
            'discount_type' => $this->discount_type ?? null,
            'discount_amount' => $this->discount_amount ?? null,
            'location_id' => $location_id
        ];
        // Si existen relaciones de hijos y padres, agregarlas
        if ($childrens == true) {
            if (method_exists($this, 'children_person')) {
                $child = $this->children_person->transform(function ($row) {
                    return $row->getCollectionData();
                });
                $data['childrens'] = $child;
            }
            $parent = null;
            if (method_exists($this, 'parent_person') && $this->parent_person) {
                $parent = $this->parent_person->getCollectionData();
            }
            $data['parent'] = $parent;
        }
        return $data;
    }
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
    public function getOptionalEmailArray(): array
    {
        $data = unserialize($this->optional_email);
        if ($data === false) {
            $data = [];
        }

        return $data;
    }
    public function item_unit_types()
    {
        return $this->hasMany(UnitTypePerson::class, 'customer_id');
    }
    public static function getZone($id)
    {
        $person = Person::find($id);
        $zone_id = $person->client_zone_id;
        if($zone_id){
            $zone = ClientZone::find($zone_id);
            if($zone){
                return $zone->description;
            }
        }
        return null;
    }
    public function zone()
    {
        return $this->belongsTo(ClientZone::class, 'client_zone_id');
    }

    public function addresses()
    {
        return $this->hasMany(PersonAddress::class);
    }
    public function identity_document_type()
    {
        return $this->belongsTo(IdentityDocumentType::class, 'identity_document_type_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'customer_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function parient()
    {
        return $this->belongsTo(PersonParient::class, 'parient_id');
    }

    public static function getIdClientesVariosOrCreate()
    {
        $clientes_varios = Person::where('number', '99999999')->orWhere('name', 'like', '%CLIENTES VARIOS%')->first();
        if (!$clientes_varios) {
            $clientes_varios = new Person();
            $clientes_varios->type = 'customers';
            $clientes_varios->identity_document_type_id = 1;
            $clientes_varios->number = 99999999;
            $clientes_varios->name = 'CLIENTES VARIOS';
            $clientes_varios->country_id = 'PE';
            $clientes_varios->department_id = 12;
            $clientes_varios->province_id = 1203;
            $clientes_varios->district_id = 120303;
            $clientes_varios->perception_agent = 0;
            $clientes_varios->percentage_perception = 0;
            $clientes_varios->enabled = 1;
            $clientes_varios->seller_id = 1;
            $clientes_varios->status = 1;
            $clientes_varios->save();
        }
        return $clientes_varios->id;
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }    /**
     * Get location data with lazy loading if needed
     *
     * @return array Location data including country, department, province and district
     */
    public function getLocationData()
    {
        // Load relations if not already loaded, but only select the fields we need
        $locationEntities = ['country', 'department', 'province', 'district'];
        
        foreach ($locationEntities as $entity) {
            if (!$this->relationLoaded($entity) && $this->{$entity.'_id'}) {
                $this->load([$entity => function($query) {
                    $query->select('id', 'description', 'active');
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
                'description' => $this->department->description,
                'active' => $this->department->active
            ] : null,
            'province' => $this->province ? [
                'id' => $this->province->id,
                'description' => $this->province->description,
                'active' => $this->province->active
            ] : null,
            'district' => $this->district ? [
                'id' => $this->district->id,
                'description' => $this->district->description,
                'active' => $this->district->active
            ] : null
        ];
    }

    public function scopeWhereType($query, $type)
    {
        return $query->where('type', $type);
    }    public function getAddressFullAttribute()
    {
        $address = trim($this->address);
        $address = ($address === '-' || $address === '') ? '' : $address . ' ,';
        if ($address === '') {
            return '';
        }
        
        // Load only necessary fields for location models
        if (!$this->relationLoaded('department') && $this->department_id) {
            $this->load(['department' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        if (!$this->relationLoaded('province') && $this->province_id) {
            $this->load(['province' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        if (!$this->relationLoaded('district') && $this->district_id) {
            $this->load(['district' => function($query) {
                $query->select('id', 'description');
            }]);
        }
        
        $dept = $this->department ? $this->department->description : '';
        $prov = $this->province ? $this->province->description : '';
        $dist = $this->district ? $this->district->description : '';
        
        return "{$address} {$dept} - {$prov} - {$dist}";
    }

    public function more_address()
    {
        return $this->hasMany(PersonAddress::class);
    }

    public function person_type()
    {
        return $this->belongsTo(PersonType::class);
    }

    public function scopeWhereIsEnabled($query)
    {
        return $query->where('enabled', true);
    }
    // para las imagenes de los clientes
    public function hasDefaultImage()
    {
        return $this->image === self::DEFAULT_USER_IMAGE;
    }
    public function getImageUrlAttribute()
    {
        // Verificar si es la imagen por defecto
        if ($this->image === self::DEFAULT_USER_IMAGE) {
            // Ruta para la imagen por defecto
            return asset('status_images/' . self::DEFAULT_USER_IMAGE);
        }

        // Ruta para imágenes personalizadas
        return asset('storage/uploads/persons/' . $this->image);
    }
}
