<?php

namespace Modules\Restaurant\Models;
use App\Models\Tenant\ModelTenant;
use App\Models\Tenant\User;

class TableUserMaintenance extends ModelTenant
{
    public $timestamps = false;
    protected $table = "table_user_maintenance";
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $fillable = [

        'id',
        'table_id',
        'user_id',
        'type',
        'init_comment',
        'finish_comment',
        'init_time',
        'estimated_finish_time',
        'finish_time',
        'status',
        'active',
        'created_at',
        'updated_at',
        
        
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
