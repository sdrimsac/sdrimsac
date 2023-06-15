<?php

namespace Modules\Restaurant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; 


class PromocionPorItemController extends Controller
{
    public function index(){

    }

    public function processPromo(Request $request){
        

        $how_is =  $request->how_is;
        $itemspromo = $request->itemspromo;
        $dataClean = [];
        $date = Carbon::now(); 
        
        foreach($itemspromo as $key => $value){
            
            if($value['is_promotion'] == 1){
                $dataClean [] = array_only($value, ['id', 'is_promotion', 'promotion_count' , 'quantity'] );
                $cantidadComprada  = $value['quantity'];
                $catidadHabilitarPromocion = $value['promotion_count'];
                //consultar de la base de datos cuantos elementeos tiene ya acumulados 
                $DBconsulta = DB::connection('tenant')->select('select * from promociones where prom_clie_id = ? and prom_items_id = ? ', [$how_is['id'],$value['id']]) ; 
                $DBconsulta = json_decode(json_encode($DBconsulta), true);

                if(count($DBconsulta) == 0){
                    
                    $productId = $value['id'];
                    $items_purchased = $value['quantity']; // Número de artículos comprados
                    $gifts_earned = floor($items_purchased / $catidadHabilitarPromocion); // Número de artículos de regalo obtenidos
                    $items_left = $items_purchased % $catidadHabilitarPromocion; // Número de artículos restantes

                    DB::connection('tenant')->select('insert into promociones (prom_clie_id,  prom_items_id,  prom_cumulative_purchase,  prom_to_redeem, prom_redeemed, created_at  , updated_at   ) values (?,?,?,?,0,?,?)',[$how_is['id'], $productId ,$items_left, $gifts_earned ,$date ,$date  ]);
                }else if(count($DBconsulta) == 1){// por iteracion solo  se permite la actualizacion de un item unico de resto el sistema debera arrojar un error
                        $totalComprado = $DBconsulta[0]['prom_cumulative_purchase']  + $cantidadComprada ; 
                        $porReclamar = $DBconsulta[0]['prom_to_redeem']  ; 
                        $promocionId = $DBconsulta[0]['id'] ;

                        $gifts_earned = floor($totalComprado / $catidadHabilitarPromocion);
                        $gifts_earned += $porReclamar; // Número de artículos de regalo obtenidos
                        $items_left = $totalComprado % $catidadHabilitarPromocion; //articulos restantes 

                    DB::connection('tenant')->select('update promociones  set   prom_cumulative_purchase = ? ,  prom_to_redeem = ? , updated_at = ?   where id = ? ',[$items_left , $gifts_earned, $date, $promocionId  ]);
                }
            }
        }

        return 'procesando promo '; 
    }

    public function showCliePromos(Request $request){ 

        $dataPersons = DB::connection('tenant')->select('SELECT persons.id , persons.name FROM  promociones  INNER JOIN persons ON promociones.prom_clie_id = persons.id GROUP BY persons.id , persons.name');
       
        return response()->json(['data' => $dataPersons]);
    }

    public function getPrductosPromo(Request $request){
        //buscar que productos tenesmos disponibles para hacer cambio por clientes 
        $dataProductDisp = DB::connection('tenant')->select('SELECT  promociones.*,  items.description , items.promotion_count FROM promociones INNER JOIN items ON promociones.prom_items_id = items.id where prom_clie_id = ? ', [$request->id ] );

        return $dataProductDisp ;
    }

    public function canjearPromo(Request $request){
        
        $date = Carbon::now(); 
        $formulario = $request->form ; 

        $clieId = $formulario['clientecanje'] ;
        $promocionId = $formulario['productos'] ;
        $PromoDisp = $formulario['PromoDisponibles'] ;

        $totalReclamar  = $request->TotalReclamar;
        //buscar el registro en la db (validar)
        try {
            $registro = DB::connection('tenant')->select('select * from promociones where prom_clie_id  = ? and id = ? and prom_to_redeem = ? ', [$clieId,$promocionId, $PromoDisp]);
            $registro = json_decode(json_encode($registro), true);
            
            $itemId = $registro[0]['prom_items_id'] ; 
            if(count($registro) == 0 ){
                $message = ' no existe regisstro con los datos que ha ingresado '; 
                return response()->json(['error' => $message], 400);
            }else{
                
                $restante = $PromoDisp - $totalReclamar ; 
                DB::connection('tenant')->select('update promociones set prom_to_redeem = ? , prom_redeemed = ?    where id  = ?', [$restante, $totalReclamar,$promocionId ]); 
                DB::insert('insert into listado_canje_promotion (fecha_cambio, clie_id , items_id, cantidad, created_at , updated_at ) values (?,?,?,?,?,?)', [$date,$clieId,$itemId,$totalReclamar,$date,$date]);

            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return 'devolver datos desde canjearPromo';
    }

    public function HistCanje(Request $request){
         
        /* $histcanje = DB::connection('tenant')->select('SELECT        listado_canje_promotion.id,        listado_canje_promotion.fecha_cambio,        items.description,        persons.`name`,        listado_canje_promotion.cantidad,        listado_canje_promotion.clie_id     FROM        listado_canje_promotion        INNER JOIN persons ON listado_canje_promotion.clie_id = persons.id        INNER JOIN items ON listado_canje_promotion.items_id = items.id    WHERE        listado_canje_promotion.clie_id = ? order by 1 desc ', [$request->id]);
         */
        $histcanje = DB::connection('tenant')->table('listado_canje_promotion')
        ->select('listado_canje_promotion.id', 'listado_canje_promotion.fecha_cambio', 'items.description', 'persons.name', 'listado_canje_promotion.cantidad', 'listado_canje_promotion.clie_id')
        ->join('persons', 'listado_canje_promotion.clie_id', '=', 'persons.id')
        ->join('items', 'listado_canje_promotion.items_id', '=', 'items.id')
        ->where('listado_canje_promotion.clie_id', '=', $request->id)
        ->orderBy('listado_canje_promotion.id', 'desc')
        ->paginate(3);


        return $histcanje; 
    }
}
