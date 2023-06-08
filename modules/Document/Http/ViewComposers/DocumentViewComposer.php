<?php

namespace Modules\Document\Http\ViewComposers;
use Carbon\Carbon;
use App\Models\Tenant\Cash;
use App\Models\Tenant\Item;
use App\Models\Tenant\Arqueo;
use App\Models\Tenant\Document;

class DocumentViewComposer
{
    public function compose($view)
    {
        $view->vc_arqueo=null;
      
        $fecha_actual = Carbon::now();
        $date = Carbon::now();
        $month_start = $date->format('Y-m');
        $view->vc_document = Document::whereNotSent()->count();
        $d_start = Carbon::parse($month_start.'-01')->format('Y-m-d');
        $d_end = Carbon::parse($month_start.'-01')->endOfMonth()->format('Y-m-d');

        $cash = Cash::where('state','1')->count();
     
        if($cash>0){
            $view->caja_aperturada=true;
            $view->caja_cerrada=false;
        } else{
            $row_arqueo = Arqueo::where('state','0')->get()->last();
            if($row_arqueo!=null){
                $view->vc_arqueo_hora=$row_arqueo->created_at->format('H:i:s');
                $view->vc_arqueo_date=$row_arqueo->fecha->format('d-m-Y');
                $view->caja_cerrada=true;
                $view->caja_aperturada=false;    
            }else {
                $view->caja_aperturada=true;
                $view->caja_cerrada=false;
            }
        }
       
        $view->vc_defeated = Item::where('stock','>','0')->whereBetween('date_of_due', [$d_start, $d_end])->count();
       
    }
}