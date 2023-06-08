<?php

namespace App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends ModelTenant
{
    protected $with = ['user'];
    protected $table="vehicles";         //nombre tabla
    protected $primarykey="id";
    protected $hidden = ["created_at", "updated_at"];
    protected $fillable = [
        'business_name',                        //razon social
        'filming_plate',                        //placa rodaje
        'vehicle_class',                        // clase vehiculo
        'axle_number',                          //numero  eje
        'manufacturing_Year',                   //año fabricacion
        'mark',                                 //marca
        'chassis_number',                       //numero chasis
        'model',                                //modelo
        'number_seats',                         //numero asientos
        'bodywork',                             //carroceria
        'load_capacity',                        //capacidad carga
        'gallons',                              //galones
        'driver',                               //conductor
        'chassis',                              //chasis
        'color',                                //color
        'cylinders',                            //cilindros
        'axles',                                //ejes
        'dry_weight',                           //peso seco
        'gross_weight',                         //peso bruto
        'useful_load',                          //carga util
        'length',                               //longitud          
        'height',                               //altura
        'broad',                                //ancho
        'pineapples',                           //piñas
        'fuel',                                 //combustible
        'bodywork',                             //carroceria                    
        'vehicle_insurance',                    //seguro vehicular
        'insurance_company',                    //seguro compañia
        'soat_number',                          //numero soat
        'expiration_date',                      //fecha vencimiento          
        'soat_cost',                            //soat costo
        'driver_id',                            //relacion tabla usuario
    
    ];
}
