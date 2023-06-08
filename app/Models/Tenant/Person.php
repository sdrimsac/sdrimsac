<?php

namespace App\Models\Tenant;

use App\Models\Tenant\Catalogs\Country;
use App\Models\Tenant\Catalogs\Department;
use App\Models\Tenant\Catalogs\District;
use App\Models\Tenant\Catalogs\IdentityDocumentType;
use App\Models\Tenant\Catalogs\Province;
use Hyn\Tenancy\Traits\UsesTenantConnection;


class Person extends ModelTenant
{

    use UsesTenantConnection;

    protected $table = 'persons';
    protected $with = ['identity_document_type', 'country', 'department', 'province', 'district'];
    protected $fillable = [
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
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('status', 1);
    //     });
    // }
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
            $temp = trim($optional_mail[$i]['email']);
            if (!empty($temp) && $temp != $this->email) {
                $optional_mail_send[] = $temp;
            }
        }
        /** @var \App\Models\Tenant\Catalogs\Department  $department */
        $department = Department::find($this->department_id);
        if (!empty($department)) {
            $department = [
                "id" => $department->id,
                "description" => $department->description,
                "active" => $department->active,
            ];
        }

        $location_id = [];
        /** @var \App\Models\Tenant\Catalogs\Department  $department */
        $department = Department::find($this->department_id);
        if (!empty($department)) {
            $department = [
                "id" => $department->id,
                "description" => $department->description,
                "active" => $department->active,
            ];
            array_push($location_id, $department['id']);
        }
        $province = Province::find($this->province_id);

        if (!empty($province)) {
            $province = [
                "id" => $province->id,
                "description" => $province->description,
                "active" => $province->active,
            ];
            array_push($location_id, $province['id']);
        }
        $district = District::find($this->district_id);

        if (!empty($district)) {
            $district = [
                "id" => $district->id,
                "description" => $district->description,
                "active" => $district->active,
            ];
            array_push($location_id, $district['id']);
        }
        $seller = User::find($this->seller_id);
        if (!empty($seller)) {
            $seller = $seller->getCollectionData();
        }


        $data = [
            'id' => $this->id,
            'description' => $this->number . ' - ' . $this->name,
            'name' => $this->name,
            'number' => $this->number,
            'identity_document_type_id' => $this->identity_document_type_id,
            'identity_document_type_code' => $this->identity_document_type->code,
            'address' => $this->address,
            'internal_code' => $this->internal_code,
            'barcode' => $this->barcode,
            'observation' => $this->observation,
            'seller' => $seller,
            // 'zone' => $this->getZone(),
            'zone' => null,
            'zone_id' => $this->zone_id,
            'seller_id' => $this->seller_id,
            'website' => $this->website,
            'document_type' => $this->identity_document_type->description,
            'enabled' => (bool)$this->enabled,
            'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => optional($this->updated_at)->format('Y-m-d H:i:s'),
            'type' => $this->type,
            'trade_name' => $this->trade_name,
            'country_id' => $this->country_id,
            'nationality_id' => $this->nationality_id,
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
            'contact' => $this->contact,
            'comment' => $this->comment,
            'addresses' => $addresses,
            'parent_id' => $this->parent_id,
            'credit_days' => (int)$this->credit_days,
            'optional_email' => $optional_mail,
            'optional_email_send' => implode(',', $optional_mail_send),
            'childrens' => [],
            'accumulated_points' => $this->accumulated_points,
            'has_discount' => $this->has_discount,
            'discount_type' => $this->discount_type,
            'discount_amount' => $this->discount_amount,
            'location_id' => $location_id
        ];
        if ($childrens == true) {
            $child = $this->children_person->transform(function ($row) {
                return $row->getCollectionData();
            });
            $data['childrens'] = $child;
            $parent = null;
            if ($this->parent_person) {
                $parent = $this->parent_person->getCollectionData();
            }

            $data['parent'] = $parent;
        }


        return $data;
    }
    public function getOptionalEmailArray(): array
    {
        $data = unserialize($this->optional_email);
        if ($data === false) {
            $data = [];
        }

        return $data;
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

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function scopeWhereType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getAddressFullAttribute()
    {
        $address = trim($this->address);
        $address = ($address === '-' || $address === '') ? '' : $address . ' ,';
        if ($address === '') {
            return '';
        }
        return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
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
}
