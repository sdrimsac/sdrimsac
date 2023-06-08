<?php
namespace App\Models\Tenant;
use App\Models\Tenant\User;
use App\Models\Tenant\Document;
use App\Models\Tenant\SaleNote;
use Illuminate\Database\Eloquent\Model;

class Turned extends ModelTenant
{
     protected $table="turned";                                  //nombre tabla
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'number',
        'enter_amount',                         //grupos
        'difference',                     //categorias

      ];


}
