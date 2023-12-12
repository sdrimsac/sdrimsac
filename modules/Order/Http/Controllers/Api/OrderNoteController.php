<?php

namespace Modules\Order\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Order\Http\Requests\OrderNoteRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Models\OrderNote;
use Modules\Order\Http\Resources\OrderNoteCollection;
use Modules\Order\Http\Resources\OrderNoteResource;

class OrderNoteController extends Controller
{
    // public function store(OrderNoteRequest $request)
    // {
    //     DB::connection('tenant')->transaction(function () use ($request) {
    //         $data = $this->mergeData($request);

    //         $this->order_note =  OrderNote::create($data);

    //         foreach ($data['items'] as $row) {
    //             $this->order_note->items()->create($row);
    //         }

    //         $this->setFilename();
    //         $this->createPdf($this->order_note, "a4", $this->order_note->filename);

    //     });

    //     return [
    //         'success' => true,
    //         'data' => [
    //             'id' => $this->order_note->id,
    //         ],
    //     ];
    // }

    public function lista_user($user_id)
    {
        //$records = $this->getRecords($request);
        $records = OrderNote::where("user_id",$user_id)->latest();

        return new OrderNoteCollection($records->paginate(config('tenant.items_per_page')));
    }
    public function lists(Request $request)
    {
       //  dd($request->all());   
       if($request->document==null && $request->document_number==null  && $request->date_of_issue==null && $request->customer_id==null){
        $records = OrderNote::orderBy('id', 'desc')->get();
       }else{
        $record = OrderNote::orderBy('id', 'desc');
        if($request->document!=null){
            $records = $record->where( 'document',$request->document)->get();
        } 
        if($request->customer_id!=null){
            $records = $record->where( 'customer_id',$request->customer_id)->get();
        } 
        if($request->document!=null){
            $records = $record->where( 'document_number',$request->document_number)->get();
        }   
        if($request->date_of_issue!=null){
            $records = $record->where( 'date_of_issue',$request->date_of_issue)->get();
        }  
    }

        return new OrderNoteCollection($records);
    }
    public function status(Request $request) {
        $record=OrderNote::where('external_id',$request->external_id)->first();
        $orden=OrderNote::findOrFail($record->id);
        $orden->state_type_id="05";
        $orden->save();
        return [
            "status"=>true,
            "message"=>"Se registro con Exito",
            "data"=> $record,

        ];
     }
    // private function setFilename(){

    //     $name = [$this->order_note->prefix,$this->order_note->id,date('Ymd')];
    //     $this->order_note->filename = join('-', $name);
    //     $this->order_note->save();

    // }
}
