$orden = Orden::find($row->id);
$ordenItem=OrdenItem::where('orden_id',$row->id)->first();
$total="0.00";

if($ordenItem!=null){
$totalizar = DB::connection('tenant')->table('orden_item')
->select(DB::raw('SUM(quantity*price) as total'))->where('orden_id',$row->id)->first();
$total=$totalizar->total;
}

// foreach ($totalizar as $key => $row_totalizar) {
//     $total= $total+($row_totalizar->quantity*$row_totalizar->price);
// }
$table = Table::find($orden->table_id);
if($ordenItem!=null){
    $user = User::find($ordenItem->user_id);
}else{
    $user=[];
}
//dd($user);
$status_orden= StatusOrden::where('id',$orden->status_orden_id)->first();
$document_type="";
$document_number="";
$document_type_id="";
if($row->status_orden_id==4){
    if($row->document_id != null){
        $document=Document::where('id',$row->document_id)->first();
        if($document->document_type_id=="01"){
            $document_type="FACTURA ELECTRÓNICA";
        }else{
            $document_type="BOLETA DE VENTA ELECTRÓNICA";

        }
        $document_number=" Nº ".$document->series."-".$document->number;
        $document_type_id="01";
        $customer=Person::where('id',$document->customer_id)->first();
    }else{
        $saleNote=SaleNote::where('id',$row->sale_note_id)->first();
        if($saleNote!=null){
            $document_type="NOTA DE VENTA";
            $document_number=" Nº ".$saleNote->series."-".$saleNote->number;
            $document_type_id="80";
            $customer=Person::where('id',$saleNote->customer_id)->first();
         }else{
            $customer=null;
         }
    }
}else{
       $customer=Person::find($row->customer_id);
}