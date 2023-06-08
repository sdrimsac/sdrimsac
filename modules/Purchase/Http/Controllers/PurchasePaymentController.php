<?php
namespace Modules\Purchase\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tenant\Box;
use App\Models\Tenant\Company;
use App\Models\Tenant\Purchase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Tenant\PurchasePayment;
use App\Models\Tenant\PaymentMethodType;
use Modules\Finance\Traits\FinanceTrait; 
use App\Models\Tenant\Catalogs\DocumentType;
use Modules\Finance\Traits\FilePaymentTrait; 
use Modules\Purchase\Http\Requests\PurchasePaymentRequest;
use Modules\Purchase\Http\Resources\PurchasePaymentCollection;

class PurchasePaymentController extends Controller
{
    use FinanceTrait, FilePaymentTrait;

    public function records($purchase_id)
    {
        $records = PurchasePayment::where('purchase_id', $purchase_id)->get();

        return new PurchasePaymentCollection($records);
    }

    public function tables()
    {
        return [
            'payment_method_types' => PaymentMethodType::all(),
            'payment_destinations' => $this->getPaymentDestinations()
        ];
    }

    public function purchase($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);

        $total_paid = collect($purchase->payments)->sum('payment');
        $total = $purchase->total;
        $total_difference = round($total - $total_paid, 2);

        return [
            'number_full' => $purchase->number_full,
            'total_paid' => $total_paid,
            'total' => $total,
            'total_difference' => $total_difference
        ];

    }


    public function store(PurchasePaymentRequest $request)
    {
        $id = $request->input('id');

        DB::transaction(function () use ($id, $request) {
            //dd($request->all());
            $record = PurchasePayment::firstOrNew(['id' => $id]);
            $record->fill($request->all());
            $record->save();
            $payment= PaymentMethodType::where('id',$request->payment_method_type_id)->first(); 
            $purchase=Purchase::where('id',$request->purchase_id)->first();
            //$document_type=DocumentType::where('id',$request->document_type_id)->first();
            $company=Company::first();
            if($request->payment_method_type_id=="01"){
            $boxes=Box::create([
                'purchase_id' => $purchase->id,
                'group_id'=>2,
                'category_id'=>2,
                'subcategory_id'=>2,
                'amount'=> $request->payment,
                'date'=>$request->date_of_payment,
                'type'=>'2',
                'state'=>'1',
                'method'=>$payment->description,
                'user_id'=>auth()->user()->id,  
                'state'=>'1',           
                'description'=>"PAGO DE COMPRA Nº" .$purchase->document_type->description ." ". $purchase->series."-".$purchase->number,
                'soap_type_id'=>$company->soap_type_id  
                ]);        
            }
            $this->createGlobalPayment($record, $request->all());
            $this->saveFiles($record, $request, 'purchases');

        });

        return [
            'success' => true,
            'message' => ($id)?'Pago editado con éxito':'Pago registrado con éxito'
        ];
    }

    public function destroy($id)
    {
        $item = PurchasePayment::findOrFail($id);
        $search_box=Box::where('purchase_id',$item->purchase_id)->first();
        $boxes=Box::findOrFail($search_box->id);
        $boxes->delete();
        $item->delete();

        return [
            'success' => true,
            'message' => 'Pago eliminado con éxito'
        ];
    }
 


}
