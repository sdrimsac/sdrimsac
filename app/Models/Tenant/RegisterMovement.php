<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class RegisterMovement extends ModelTenant
{
    protected $table = "registers_movement_users";         //nombre tabla
    protected $fillable = [
        'user_id', 
        'event', 
        'description', 
        'ip', 
        'browser', 
        'model', 
        'model_id', 
        'data', 
    ];

    protected $cast = [
        'data' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_event()
    {   $event = $this->event;
        $description = null;
        switch ($event) {
            case 'create':
                $description = 'Creación';
                break;
            case 'update':
                $description = 'Actualización';
                break;
            case 'delete':
                $description = 'Eliminación';
                break;
            default:
                $description = 'Sin descripción';
                break;
        }
        return $description;
    }
 
}