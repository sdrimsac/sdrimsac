<?php

namespace Modules\Consignment\Http\Controllers;

use App\Http\Controllers\Tenant\WhatsappController;
use App\Models\Tenant\Company;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Item;
use App\Models\Tenant\ItemWarehouse;
use App\Models\Tenant\Person;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Consignment\Http\Resources\ConsignmentCollection;
use Modules\Consignment\Models\Consignment;
use Modules\Consignment\Models\ConsignmentItem;
use Modules\Consignment\Models\ConsignmentItemLot;
use Modules\Consignment\Models\ConsignmentPenalty;
use Modules\Item\Models\ItemLot;
use Modules\Restaurant\Events\PrintEvent;
use Modules\Restaurant\Models\Food;

class ConsignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $configuration = Configuration::first();
        return view(
            'consignment::index',
            compact('configuration')

        );
    }
    function getCompanyName()
    {
        $company = Company::first();
        $company_name = null;
        if ($company->trade_name) {
            $company_name = $company->trade_name;
        } else {
            $company_name = $company->name;
        }

        return $company_name;
    }

    public function consignment_message($id)
    {
        $consignment = Consignment::find($id);
        $person = $consignment->person;
        $person_telephone = $person->telephone;
        if ($person_telephone == null) {
            return [
                'success' => false,
                'message' => 'El cliente no tiene un número de teléfono registrado'
            ];
        }
        $person_name = $person->name;
        $items = $consignment->items;
        $total = 0;
        foreach ($items as $item) {
            $total += $item->original_quantity * $item->price;
        }
        $penalty = null;
        if ($consignment->penalty) {
            $consignment_penalty = $consignment->penalty;
            $amount = $consignment_penalty->amount;
            if ($consignment_penalty->type == 'percentage') {
                $penalty = $amount . '%';
            } else {
                $penalty = 'S/ ' . $amount;
            }
        }

        $message = "Se le comunica que la consignación N° " . $consignment->id . " del cliente " . $person_name . " por el monto de S/ " . $total . " con fecha de vencimiento " . Carbon::parse($consignment->date_of_end)->format('d/m/Y') . " se encuentra pendiente de liquidación.\n";
        if ($penalty) {
            $message .= "Se le recuerda que tiene una penalidad de " . $penalty . ".\n";
        }
        $message .= "Por favor, acercarse a nuestras oficinas para regularizar su situación. Gracias.\n Atte. " . $this->getCompanyName() . "\n";
        $response =  (new WhatsappController)->sendMessage($message, $person_telephone);
        if(!isset($response['success']) && $response['success'] == false){
            return [
                'success' => false,
                'message' => 'Ocurrió un error al enviar el mensaje',
                'error' => $response['message']
            ];
        }
        return [
            'success' => true,
            'message' => 'Mensaje enviado con éxito'
        ];
        // return $response;
    }
    public function consignment_document_ticket_liquidated($id){
        $consignment = Consignment::find($id);
        $items = $consignment->items;
        
        $establishment = Establishment::first();
        $company = Company::active();
        $customer = $consignment->person;
        $height = 8  * 50;
        $height += $items->count() * 60;
        try {
            $pdf = PDf::loadView("consignment::consignment_ticket_liquidated", compact(
                'consignment',
                'items',
                'company',
                'establishment',
                'customer'
            ))
            ->setPaper(array(0, 0, 220.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function consignment_document_ticket($id){
        $consignment = Consignment::find($id);
        $items = $consignment->items;
        
        $establishment = Establishment::first();
        $company = Company::active();
        $customer = $consignment->person;
        $height = 8  * 40;
        $height += $items->count() * 40;
        // return view('consignment::consignment', compact(
        //     'consignment',
        //     'items',
        //     'company',
        //     'establishment',
        //     'customer'
        // ));
        try {
            $pdf = PDf::loadView("consignment::consignment_ticket", compact(
                'consignment',
                'items',
                'company',
                'establishment',
                'customer'
            ))
            ->setPaper(array(0, 0, 220.45, $height));
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
      
    }
    public function consignment_document($id)
    {
        $consignment = Consignment::find($id);
        $items = $consignment->items;
        $establishment = Establishment::where('id', auth()->user()->establishment_id)->first();
        $company = Company::active();
        $customer = $consignment->person;

        // return view('consignment::consignment', compact(
        //     'consignment',
        //     'items',
        //     'company',
        //     'establishment',
        //     'customer'
        // ));
        try {
            $pdf = PDf::loadView("consignment::consignment", compact(
                'consignment',
                'items',
                'company',
                'establishment',
                'customer'
            ))
                ->setPaper('a4', 'portrait');
        } catch (Exception $e) {
            return ['m' => $e->getMessage()];
        }

        return $pdf->stream('pdf_file.pdf');
    }
    public function liquidated(Request $request)
    {
        $consigment_id = $request->input('id');

        $items = $request->input('items');
        if ($items && is_array($items)) {
            foreach ($items as $item) {
                $consigment_item_id = $item['consignment_item_id'];
                if ($consigment_item_id) {
                    $selled_quantity = $item['quantity'];
                    $return_quantity = $item['toWarehouse'];
                    $consigment_item = ConsignmentItem::find($consigment_item_id);
                    if ($consigment_item) {
                        $consigment_item->selled_quantity = $selled_quantity;
                        $consigment_item->return_quantity = $return_quantity;
                        $consigment_item->save();
                    }
                }
            }
        }
        $consigment = Consignment::find($consigment_id);
        $consigment->liquidated = true;
        $consigment->save();
        event(new PrintEvent($consigment->id, "COL", true, 0));
        return [
            'success' => true,
            'message' => 'Consignación liquidada con éxito'
        ];
    }

    public function liquidate($consigment_id)
    {
        $consigment = Consignment::find($consigment_id);
        $penalty = $consigment->penalty;
        $configuration = Configuration::first();
        if ($penalty && $configuration->item_consignment_id == null) {
            return [
                'success' => false,
                'message' => 'No se ha configurado el producto de penalidad'
            ];
        }
        $items = $consigment->items;
        $foods = [];
        $total = 0;
        foreach ($items as $item) {
            $food_id = $item->item->food->id;
            $food = Food::find($food_id);
            $newItem = [];
            $newItem['food'] = $food;
            $newItem['quantity'] = $item->original_quantity;
            $newItem['price'] = $item->price;
            $total += $item->original_quantity * $item->price;
            $newItem["id"] = $food_id;
            $newItem["consignment_item_id"] = $item->id;
            $newItem["is_penalty"] = false;
            $newItem["series"] =  $item->lots->transform(function ($row)  use ($item) {
                $item_lot = ItemLot::where('item_id', $item->item->id)
                    ->where('series', $row->series)
                    ->first();
                return $item_lot;
            });
            $foods[] = $newItem;
        }
        $is_over_time = Carbon::now()->gt(Carbon::parse($consigment->date_of_end));
        if ($consigment->penalty && $is_over_time) {
            //insertar un elemento en $foods en primera posicion
            $penalty = $consigment->penalty;
            $penalty_item = Item::find($configuration->item_consignment_id);
            $penalty_food = Food::where('item_id', $penalty_item->id)->first();
            $newItem = [];
            $newItem['food'] = $penalty_food;
            $newItem['quantity'] = 1;
            //el "price" dependerá si es porcentaje o monto, si es porcentaje se calculará el monto de $total
            $newItem['price'] = $penalty->type == 'percentage' ? $penalty->amount * $total / 100 : $penalty->amount;
            $newItem["id"] = $penalty_food->id;
            $newItem["consignment_item_id"] = null;
            $newItem["is_penalty"] = true;

            $newItem["series"] =  null;
            array_unshift($foods, $newItem);
        }
        return [
            'success' => true,
            'foods' => $foods
        ];
    }
    public function items_lot($consigment_item_id)
    {
        $consigment_item = ConsignmentItem::find($consigment_item_id);
        $item_id = $consigment_item->item_id;
        $items_lot = ConsignmentItemLot::where('consignment_item_id', $consigment_item_id)->get()->transform(
            function ($row) use ($item_id) {
                $item_lot = ItemLot::where('item_id', $item_id)
                    ->where('series', $row->series)
                    ->first();
                return [
                    'series' => $row->series,
                    'date' => $item_lot->date,
                ];
            }

        );
        return [
            'success' => true,
            'lots' => $items_lot
        ];
    }
    public function stock(Request $request)
    {
        $establishment_id = $request->input('establishment_id');
        $item_id = $request->input('item_id');

        if (!$establishment_id || !$item_id) {
            return [
                'stock' => 0,
                'success' => false,
                'message' => 'No se encontró el establecimiento o el producto'
            ];
        }
        // $item = Item::find($item_id);
        $warehouse = ItemWarehouse::where('item_id', $item_id)
            ->where('warehouse_id', $establishment_id)
            ->first();
        if (!$warehouse) {
            return [
                'stock' => 0,
                'success' => false,
                'message' => 'No se encontró el almacén'
            ];
        }

        $stock =  $warehouse->stock;

        return [
            'stock' => $stock,
            'success' => true,
            'message' => 'Stock obtenido con éxito'
        ];
    }
    public function columns()
    {
        return [
            'person_id' => 'Cliente / Vendedor',
            'date_of_issue' => 'Fecha de emisión',
            'date_of_end' => 'Fecha de liquidación'
        ];
    }
    public function records(Request $request)
    {
        $column = $request->input('column');
        $value = $request->input('value');
        if($column && $value){
            if($column == 'person_id'){
                $consigments = Consignment::whereHas('person', function($query) use($value){
                    $query->where('name', 'like', "%{$value}%")
                    ->orWhere('number', 'like', "%{$value}%");
                    ;
                })->orderBy('liquidated', 'asc')->orderBy('id', 'desc');
            }else{
                $consigments = Consignment::where($column, 'like', "%{$value}%")->orderBy('liquidated', 'asc')->orderBy('id', 'desc');
            }
        }
            else{

                $consigments = Consignment::query()->orderBy('liquidated', 'asc')->orderBy('id', 'desc');
            }

        return new ConsignmentCollection($consigments->paginate(config('tenant.items_per_page')));
    }
    public function tables()
    {
        $customers = $this->getCustomers();
        $penalties = ConsignmentPenalty::all();
        $items = Item::query()->get()->take(20);
        $establishments = Establishment::all();
        return compact('penalties', 'customers', 'items', 'establishments');
    }
    public function getCustomers()
    {
        return Person::whereType('customers')->get()->take(20);
    }
    function restoreStock($consigment_id)
    {
        $consigment_items = ConsignmentItem::where('consignment_id', $consigment_id)->get();
        foreach ($consigment_items as $consigment_item) {
            $item_id = $consigment_item->item_id;
            $establishment_id = $consigment_item->establishment_id;
            $original_quantity = $consigment_item->original_quantity;
            $consigment_item_lots = ConsignmentItemLot::where('consignment_item_id', $consigment_item->id)->get();
            foreach ($consigment_item_lots as $consigment_item_lot) {
                $series = $consigment_item_lot->series;
                ItemLot::where('item_id', $item_id)
                    ->where('series', $series)
                    ->update([
                        'has_sale' => false,
                    ]);
            }
            $item = Item::find($item_id);
            $item->stock += $original_quantity;
            $item->save();
            $warehouse = ItemWarehouse::where('item_id', $item_id)
                ->where('warehouse_id', $establishment_id)
                ->first();
            $warehouse->stock += $original_quantity;
            $warehouse->save();
        }
    }
    public function store(Request $request)
    {

        try {
            DB::connection('tenant')->beginTransaction();
            $id = $request->input('id');
            $person_id = $request->input('person_id');
            $date_of_issue = $request->input('date_of_issue');
            $date_of_issue = Carbon::parse($date_of_issue)->format('Y-m-d');
            $date_of_end = $request->input('date_of_end');
            $date_of_end = Carbon::parse($date_of_end)->format('Y-m-d');
            $penalty_id = $request->input('penalty_id');
            $consigment = Consignment::firstOrNew(["id" => $id]);
            $consigment->person_id = $person_id;
            $consigment->date_of_issue = $date_of_issue;
            $consigment->date_of_end = $date_of_end;
            $consigment->penalty_id = $penalty_id;
            $consigment->save();
            $this->restoreStock($consigment->id);
            $items = $request->input('items');
            foreach ($items as $item) {
                $consigment_item = new ConsignmentItem();
                $consigment_item->consignment_id = $consigment->id;
                $consigment_item->establishment_id = $item['establishment_id'];
                $consigment_item->item_id = $item['id'];
                $consigment_item->original_quantity = $item['quantity'];
                $consigment_item->price = $item['price'];
                $consigment_item->save();
                $item_id = $item['id'];
                $establishment_id = $item['establishment_id'];
                $original_quantity = $item['quantity'];
                $general_item = Item::find($item_id);
                $general_item->stock -= $original_quantity;
                $general_item->save();
                $warehouse = ItemWarehouse::where('item_id', $item_id)
                    ->where('warehouse_id', $establishment_id)
                    ->first();
                $warehouse->stock -= $original_quantity;
                $warehouse->save();
                $has_lots = $item['has_lots'];
                if ($has_lots) {
                    $lots = $item['lots'];
                    foreach ($lots as $lot) {
                        $series = $lot['series'];
                        $consigment_item_lot = new ConsignmentItemLot();
                        $consigment_item_lot->consignment_item_id = $consigment_item->id;
                        $consigment_item_lot->series = $series;
                        //agrega el timestamp

                        $consigment_item_lot->save();
                        ItemLot::where('item_id', $item_id)
                            ->where('series', $series)
                            ->update([
                                'has_sale' => true,
                            ]);
                    }
                }
            }

            DB::connection('tenant')->commit();
            event(new PrintEvent($consigment->id, "CO", true, 0));
            return [
                'success' => true,
                'id' => $consigment->id,
                'message' => 'Consignación registrada con éxito'
            ];
        } catch (Exception $e) {
            DB::connection('tenant')->rollBack();
            return [
                'success' => false,
                'message' => 'Ocurrió un error al registrar la consignación',
                'error' => $e->getMessage()
            ];
        }
    }
    public function items($consigment_id)
    {
        $consignment = Consignment::find($consigment_id);
        $liquidated = $consignment->liquidated;
        $items = ConsignmentItem::where('consignment_id', $consigment_id)->get()
            ->transform(function ($row)  use ($liquidated) {

                return [
                    'id' => $row->id,
                    'name' => $row->item->description,
                    'quantity' => $row->original_quantity,
                    'selled' => $row->selled_quantity ?? 0.0,
                    'returned' => $row->return_quantity ?? 0.0,
                    'price' => $row->price,
                    'total' => $liquidated ? $row->selled_quantity * $row->price  : $row->original_quantity * $row->price,
                    'has_lots' => (bool)$row->item->series_enabled,
                ];
            });

        return [
            'liquidated' => (bool) $liquidated,
            'success' => true,
            'items' => $items
        ];
    }
}
