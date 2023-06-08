<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\LevelAccess\Models\ModuleLevel;
use Modules\Restaurant\Models\Area;
use Modules\Restaurant\Models\WorkersType;
use Modules\Sale\Models\UserCommission;


class User extends Authenticatable
{
    use Notifiable;
    use UsesTenantConnection;

    protected $with = ['establishment', 'area', 'worker_type', "modules"];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_id',
        'pin',
        'worker_type_id',
        'active',
        'name',
        'email',
        'password',
        'establishment_id',
        'type',
        'locked',
        'identity_document_type_id',
        'number',
        'address',
        'telephone',
        'license',
        'category'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    protected $cast = [
        'locked' => 'boolean',
        'active' => 'boolean',
    ];
    public function getCollectionData()
    {
        $type = '';
        switch ($this->type) {
            case 'admin':
                $type =  'Administrador';
                break;
            case 'seller':
                $type =  'Vendedor';
                break;
            case 'client':
                $type =  'Cliente';
                break;
            default:
                # code...
                break;
        }

        return [
            'id' => $this->id,

            'email' => $this->email,

            'name' => $this->name,

            'api_token' => $this->api_token,

            'document_id' => $this->document_id,

            'serie_id' => ($this->series_id == 0) ? null : $this->series_id,

            'establishment_description' => optional($this->establishment)->description,

            'type' => $type,

            'locked' => (bool) $this->locked,

        ];
    }

    public function getDataOnlyAuthUser()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'establishment_id' => $this->establishment_id,
            'type' => $this->type,
            'locked' => $this->locked,
            'identity_document_type_id' => $this->identity_document_type_id,
            'number' => $this->number,
            'address' => $this->address,
            'telephone' => $this->telephone,
            'document_id' => $this->document_id,
            'series_id' => $this->series_id,
            'permission_edit_cpe' => $this->permission_edit_cpe,
            'recreate_documents' => $this->recreate_documents,
            'zone_id' => $this->zone_id,
            'restaurant_role_id' => $this->restaurant_role_id,
            'delete_payment' => $this->delete_payment,
            'create_payment' => $this->create_payment,
            'edit_purchase' => $this->edit_purchase,
            'annular_purchase' => $this->annular_purchase,
            'delete_purchase' => $this->delete_purchase,
            'names' => $this->names,
            'last_names' => $this->last_names,
            'personal_email' => $this->personal_email,
            'corporate_email' => $this->corporate_email,
            'personal_cell_phone' => $this->personal_cell_phone,
            'corporate_cell_phone' => $this->corporate_cell_phone,
            'date_of_birth' => $this->date_of_birth,
            'contract_date' => $this->contract_date,
            'position' => $this->position,
            'photo_filename' => $this->photo_filename,
            'multiple_default_document_types' => $this->multiple_default_document_types,
            'default_document_types' => $this->default_document_types,
            'permission_force_send_by_summary' => $this->permission_force_send_by_summary,
        ];
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function levels()
    {
        return $this->belongsToMany(ModuleLevel::class);
    }

    public function authorizeModules($modules)
    {
        if ($this->hasAnyModule($modules)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }

    public function hasAnyModule($modules)
    {
        if (is_array($modules)) {
            foreach ($modules as $module) {
                if ($this->hasModule($module)) {
                    return true;
                }
            }
        } else {
            if ($this->hasModule($modules)) {
                return true;
            }
        }
        return false;
    }

    public function hasModule($module)
    {
        if ($this->modules()->where('name', $module)->first()) {
            return true;
        }
        return false;
    }



    public function getModule()
    {
        $module = $this->modules()->orderBy('id')->first();
        if ($module) {
            return $module->value;
        }
        return null;
    }

    public function getModules()
    {
        $modules = $this->modules()->get();
        if ($modules) {
            return $modules;
        }
        return null;
    }


    public function searchModule($module)
    {
        if ($this->modules()->where('value', $module)->first()) {
            return true;
        }
        return false;
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function worker_type()
    {
        return $this->belongsTo(WorkersType::class);
    }
    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }


    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function sale_notes()
    {
        return $this->hasMany(SaleNote::class);
    }

    public function scopeWhereTypeUser($query)
    {
        $user = auth()->user();
        return ($user->type == 'seller') ? $query->where('id', $user->id) : null;
    }



    public function getLevel()
    {
        $level = $this->levels()->orderBy('id')->first();
        if ($level) {
            return $level->value;
        }
        return null;
    }

    public function getLevels()
    {
        $levels = $this->levels()->get();
        if ($levels) {
            return $levels;
        }
        return null;
    }


    public function searchLevel($Level)
    {
        if ($this->levels()->where('value', $Level)->first()) {
            return true;
        }
        return false;
    }

    public function user_commission()
    {
        return $this->hasOne(UserCommission::class);
    }
}
