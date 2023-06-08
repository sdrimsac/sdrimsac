<?php
namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Arqueo extends ModelTenant
{
    protected $with = ['establishments']; //nombre tablas secundarias
    protected $table="arqueo";                                  //nombre tabla
    protected $primarykey="id";
  //  protected $hidden = ["created_at", "updated_at"];
    protected $dates = ['fecha'];
    protected $fillable = [
        'establishment_id',                
        'diez_moneda',                         
        'veinte_moneda',                           
        'cincuenta_moneda',                     
        'uno_moneda',
        'dos_moneda',                           
        'cinco_moneda',                   
        'diez_billete',
        'veinte_billete',
        'cincuenta_billete',
        'cien_billete',
        'docientos_billete',
        'fecha',
        'total_sistema',
        'total_moneda',
        'total_billete',
        'egresos',
        'efectivo_total',
        'total',
        'state',
        'transferir',
        'transferir_a'
      ];

        public function establishments()
    {
        return $this->belongsTo(Establishment::class,'establishment_id','id');
    }  
  
}
