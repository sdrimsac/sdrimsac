<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\Person;
use App\Models\Tenant\Item;
use App\Models\Tenant\Catalogs\AffectationIgvType;
use App\Models\Tenant\Company;
use App\Models\Tenant\Document;
use App\Mail\DocumentEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Tenant\Configuration;
use App\Models\Tenant\Series;
use App\Http\Requests\PersonRequest;
use App\Http\Requests\PerfilRequest;
use App\Models\Tenant\PromotionDocumentCustomer;
use Modules\Item\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Validator;
use Modules\College\Models\CollegeStudent;

class MobileController extends Controller
{
    public function perfil(PerfilRequest $request)
    {

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->number = $request->number;
        $user->address = $request->address;
        $user->telephone = $request->telephone;
        $user->identity_document_type_id = $request->identity_document_type_id;
        $user->email = $request->email;
        $user->license = $request->license;
        $user->password = bcrypt($request->password);

        $user->save();
        return [
            'success' => true,
            'message' => 'Datos del Usuario Actualizados correctamente.'
        ];
    }
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'No Autorizado'
            ];
        }

        $user = $request->user();
        return [
            'success' => true,
            'id' => $user->id,
            'name' => $user->name,
            'type' => $user->type,
            'identity_document_type_id' => $user->identity_document_type_id,
            'number' => $user->number,
            'address' => $user->address,
            'telephone' => $user->telephone,
            'email' => $user->email,
            'token' => $user->api_token,
            'license' => $user->license,
        ];
    }

    public function customers()
    {
        $customers = Person::whereType('customers')->orderBy('name')->take(20)->get()->transform(function ($row) {
            return [
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'address' => $row->address,
                'telephone' => $row->telephone,
                'country_id' => $row->country_id,
                'district_id' => $row->district_id,
                'email' => $row->email,
                'selected' => false
            ];
        });

        return [
            'success' => true,
            'data' => array('customers' => $customers)
        ];
    }

    /* public function tables()
    {
        $affectation_igv_types = AffectationIgvType::whereActive()->get();

        $items = Item::with(['warehouses' => function ($query) {
            $query->join('warehouses as w', 'w.id', '=', 'item_warehouse.warehouse_id')
                ->select('item_warehouse.*', 'w.description as warehouse_description');
        }])
            ->whereWarehouse('warehouse')
            ->whereHasInternalId()
            ->whereNotIsSet()
            ->whereIsActive()
            ->orderBy('description')
            ->take(20)
            ->get()
            ->transform(function ($row) {
                $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;

                return [
                    'id' => $row->id,
                    'item_id' => $row->id,
                    'name' => $row->name,
                    'full_description' => $full_description,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'internal_id' => $row->internal_id,
                    'item_code' => $row->item_code,
                    'currency_type_symbol' => $row->currency_type->symbol,
                    'sale_unit_price' => floatval($row->sale_unit_price),
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'has_igv' => (bool) $row->has_igv,
                    'is_set' => (bool) $row->is_set,
                    'aux_quantity' => 1,
                    'image_url' => $row->image_url,
                    'amount_plastic_bag_taxes' => $row->amount_plastic_bag_taxes,
                    'brand' => $row->brand,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'category' => $row->category,
                    'is_stock' => (bool) $row->is_stock,
                    'max_quantity' => $row->max_quantity,
                    'origin' => $row->origin,
                    'series_enabled' => (bool) $row->series_enabled,
                    'max_quantity_description' => $row->max_quantity_description,
                    'stock' => $row->warehouses->sum('stock'),
                    'item_unit_types' => $row->item_unit_types->map(function ($item_unit_type) {
                        return [
                            'id' => $item_unit_type->id,
                            'unit_type_id' => $item_unit_type->unit_type_id,
                            'unit_type_description' => $item_unit_type->unit_type->description,
                            'conversion_factor' => $item_unit_type->conversion_factor,
                            'selected' => (bool) $item_unit_type->selected
                        ];
                    })->toArray(),
                    'lots_enabled' => (bool) $row->lots_enabled,
                    'lots_group' => $row->lots_group,
                    'lots' => $row->lots->map(function ($lot) {
                        return [
                            'id' => $lot->id,
                            'lot' => $lot->lot,
                            'expiration_date' => $lot->expiration_date ? Carbon::parse($lot->expiration_date)->format('Y-m-d') : null,
                            'stock' => $lot->stock,
                            'checked' => (bool) $lot->checked
                        ];
                    })->toArray(),
                    'warehouse' => $row->warehouses->map(function ($warehouse) {
                        return [
                            'id' => $warehouse->warehouse_id,
                            'warehouse_description' => $warehouse->warehouse_description,
                            'stock' => $warehouse->stock,
                            'checked' => (bool) $warehouse->checked
                        ];
                    })->toArray(),

                ];
            });
        return [
            'success' => true,
            'data' => array('items' => $items, 'affectation_types' => $affectation_igv_types)
        ];
    } */

    public function tables()
    {
        $affectation_igv_types = AffectationIgvType::whereActive()->get();

        $items = Item::with(['warehouses' => function ($query) {
            $query->join('warehouses as w', 'w.id', '=', 'item_warehouse.warehouse_id')
                ->select('item_warehouse.*', 'w.description as warehouse_description');
        }])
            ->whereWarehouse('warehouse')
            ->whereHasInternalId()
            ->whereNotIsSet()
            ->whereIsActive()
            ->orderBy('description')
            ->take(20)
            ->get()
            ->transform(function ($row) {
                $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;

                $image_url = $this->getImageUrl($row->image, 'items');

                return [
                    'id' => $row->id,
                    'item_id' => $row->id,
                    'name' => $row->name,
                    'full_description' => $full_description,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'internal_id' => $row->internal_id,
                    'item_code' => $row->item_code,
                    'currency_type_symbol' => $row->currency_type->symbol,
                    'sale_unit_price' => floatval($row->sale_unit_price),
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'has_igv' => (bool) $row->has_igv,
                    'is_set' => (bool) $row->is_set,
                    'is_stock' => $row->is_stock ? 'Si' : 'No',
                    'aux_quantity' => 1,
                    //'image_url' => $row->image_url,
                    'image_url' => $image_url,
                    'amount_plastic_bag_taxes' => $row->amount_plastic_bag_taxes,
                    'brand' => $row->brand ?? '',
                    'category' => $row->category->name ?? '',
                    'max_quantity' => $row->max_quantity,
                    'origin' => $row->origin,
                    'series_enabled' => (bool) $row->series_enabled,
                    'max_quantity_description' => $row->max_quantity_description,
                    'stock' => number_format($row->warehouses->sum('stock'), 4, '.', ''),
                    'lots_enabled' => (bool) $row->lots_enabled,
                    'lots_group' => $row->lots_group ?? [],
                    'lots' => $row->lots->map(function ($lot) {
                        return [
                            'id' => $lot->id,
                            'lot' => $lot->lot,
                            'expiration_date' => $lot->expiration_date ? Carbon::parse($lot->expiration_date)->format('Y-m-d') : null,
                            'stock' => $lot->stock,
                            'checked' => (bool) $lot->checked
                        ];
                    })->toArray(),
                    'warehouse' => $row->warehouses->map(function ($warehouse) {
                        return [
                            'warehouse_id' => $warehouse->warehouse_id,
                            'warehouse_description' => $warehouse->warehouse_description,
                            'stock' => number_format($warehouse->stock, 4, '.', ''),
                            'checked' => (bool) $warehouse->checked
                        ];
                    })->toArray(),
                    'attributes' => [],
                    'item_unit_types' => $row->item_unit_types->map(function ($item_unit_type) {
                        return [
                            'id' => $item_unit_type->id,
                            'unit_type_id' => $item_unit_type->unit_type_id,
                            'unit_type_description' => $item_unit_type->unit_type->description,
                            'conversion_factor' => $item_unit_type->conversion_factor,
                            'selected' => (bool) $item_unit_type->selected
                        ];
                    })->toArray(),
                ];
            });

        return [
            'success' => true,
            'data' => array('items' => $items, 'affectation_types' => $affectation_igv_types)
        ];
    }

    private function getImageUrl($image, $folder)
    {
        if ($image !== 'imagen-no-disponible.jpg') {
            return asset('storage' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $image);
        }
        
        return asset("/logo/{$image}");
    }

    public function getSeries()
    {

        return Series::where('establishment_id', auth()->user()->establishment_id)
            ->whereIn('document_type_id', ['01', '03'])
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'document_type_id' => $row->document_type_id,
                    'number' => $row->number
                ];
            });
    }

    public function document_email(Request $request)
    {
        $company = Company::active();
        $document = Document::find($request->id);
        $customer_email = $request->email;

        Mail::to($customer_email)->send(new DocumentEmail($company, $document));

        return [
            'success' => true,
            'message' => 'Email enviado correctamente.'
        ];
    }


    public function item(ItemRequest $request)
    {
        $row = new Item();
        $row->item_type_id = '01';
        $row->amount_plastic_bag_taxes = Configuration::firstOrFail()->amount_plastic_bag_taxes;
        $row->fill($request->all());
        $row->image = 'imagen-no-disponible.jpg';
        $row->save();

        $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;

        return [
            'success' => true,
            'msg' => 'Producto registrado con éxito',
            'data' => (object)[
                'id' => $row->id,
                'item_id' => $row->id,
                'name' => $row->name,
                'full_description' => $full_description,
                'description' => $row->description,
                'currency_type_id' => $row->currency_type_id,
                'internal_id' => $row->internal_id,
                'item_code' => $row->item_code,
                'currency_type_symbol' => $row->currency_type->symbol,
                'sale_unit_price' => floatval($row->sale_unit_price),
                'purchase_unit_price' => $row->purchase_unit_price,
                'unit_type_id' => $row->unit_type_id,
                'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                'calculate_quantity' => (bool) $row->calculate_quantity,
                'has_igv' => (bool) $row->has_igv,
                'is_set' => (bool) $row->is_set,
                'aux_quantity' => 1,
            ],
        ];
    }

    public function person(PersonRequest $request)
    {
        $row = new Person();
        $row->fill($request->all());
        $row->save();

        return [
            'success' => true,
            'msg' => ($request->type == 'customers') ? 'Cliente registrado con éxito' : 'Proveedor registrado con éxito',
            'data' => (object)[
                'id' => $row->id,
                'description' => $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'address' => $row->address,
                'email' => $row->email,
                'telephone' => $row->telephone,
                'country_id' => $row->country_id,
                'district_id' => $row->district_id,
                'selected' => false
            ]
        ];
    }

    public function searchItems(Request $request)
    {
        $items = Item::where(function ($query) use ($request) {
            $query->where('description', 'like', "%{$request->input}%")
                ->orWhere('internal_id', 'like', "%{$request->input}%");
        })
            ->whereHasInternalId()
            ->whereWarehouse()
            ->whereNotIsSet()
            ->where('active', 1)
            ->whereHas('item_warehouse', function ($query) {
                $query->where('active', 1);
            })
            ->orderBy('description')
            ->get()
            ->transform(function ($row) {
                $full_description = ($row->internal_id) ? $row->internal_id . ' - ' . $row->description : $row->description;

                return [
                    'id' => $row->id,
                    'item_id' => $row->id,
                    'name' => $row->name,
                    'full_description' => $full_description,
                    'description' => $row->description,
                    'currency_type_id' => $row->currency_type_id,
                    'internal_id' => $row->internal_id,
                    'item_code' => $row->item_code,
                    'currency_type_symbol' => $row->currency_type->symbol,
                    'sale_unit_price' => floatval($row->sale_unit_price),
                    'purchase_unit_price' => $row->purchase_unit_price,
                    'unit_type_id' => $row->unit_type_id,
                    'sale_affectation_igv_type_id' => $row->sale_affectation_igv_type_id,
                    'purchase_affectation_igv_type_id' => $row->purchase_affectation_igv_type_id,
                    'calculate_quantity' => (bool) $row->calculate_quantity,
                    'has_igv' => (bool) $row->has_igv,
                    'is_set' => (bool) $row->is_set,
                    'aux_quantity' => 1,
                ];
            });

        return [
            'success' => true,
            'data' => array('items' => $items)
        ];
    }

    public function searchCustomers(Request $request)
    {
        $input = trim($request->input);
        $identity_document_type_id = $this->getIdentityDocumentTypeId($request->document_type_id);

        $query = Person::query()
            ->whereType('customers')
            ->whereIn('identity_document_type_id', $identity_document_type_id)
            ->where(function ($q) use ($input) {
                if (is_numeric($input)) {
                    if (strlen($input) >= 8) {
                        // RUC o DNI exacto
                        $q->where('number', $input);
                    } else {
                        // Búsqueda parcial por número
                        $q->where('number', 'like', "%$input%");
                    }
                } else {
                    // Búsqueda exacta si es nombre largo, parcial si es corto
                    if (strlen($input) >= 5) {
                        $q->whereRaw("REPLACE(UPPER(name), ' ', '') = ?", [strtoupper(str_replace(' ', '', $input))]);
                    } else {
                        $q->where('name', 'like', "%$input%");
                    }
                }
            });

        $customers = $query->orderBy('name')
            ->get()
            ->transform(function ($row) {
                return [
                    'id' => $row->id,
                    'description' => $row->number . ' - ' . $row->name,
                    'name' => $row->name,
                    'number' => $row->number,
                    'identity_document_type_id' => $row->identity_document_type_id,
                    'identity_document_type_code' => optional($row->identity_document_type)->code,
                    'address' => $row->address,
                    'telephone' => $row->telephone,
                    'email' => $row->email,
                    'country_id' => $row->country_id,
                    'district_id' => $row->district_id,
                    'selected' => false
                ];
            });

        return [
            'success' => true,
            'data' => ['customers' => $customers]
        ];
    }


    /* public function searchCustomers(Request $request)
    {
        $configuration = Configuration::first();
        $value = $request->value;
        $parents = $request->parents;

        $persons = Person::query();

        $persons = $persons
            ->where('name', 'like', '%' . $value . '%')
            ->orWhere('alias', 'like', '%' . $value . '%')
            ->orWhere('number', 'like', '%' . $value . '%')
            ->orWhere('address', 'like', '%' . $value . '%')
            ->whereType('customers')->orderBy('name')
            ->whereIsEnabled();

        if ($parents && $configuration->college) {
            $persons = $persons->whereIn('id', function ($query) {

                $query->select('parent_id')
                    ->from('parents');
            });
        }
        $persons = $persons->take(20)->get()->transform(function ($row) use ($configuration) {
            $students = CollegeStudent::whereHas('member', function ($query) use ($row) {
                $query->whereHas('parent', function ($query) use ($row) {
                    $query->where('parent_id', $row->id);
                });
            })

                ->where('active', 1)
                ->get()->transform(function ($student) {
                    return [
                        'id' => $student->id,
                        'name' => $student->person->name,
                        'class' => mb_strtoupper($student->classroom->description),
                    ];
                });
            $promotion_active_id = null;
            if ($configuration->promotions_by_points || $configuration->is_promotion_document) {
                $promotion_customer = PromotionDocumentCustomer::where('customer_id', $row->id)
                    ->where('active', true)
                    ->first();
                if ($promotion_customer) {
                    $promotion_active_id = $promotion_customer->promotion_document_id;
                }
            }
            return [
                'promotion_active_id' => $promotion_active_id,
                'students' => $students,
                'id' => $row->id,
                'description' => ($row->alias ? $row->alias . " - " : '') . $row->number . ' - ' . $row->name,
                'name' => $row->name,
                'number' => $row->number,
                'identity_document_type_id' => $row->identity_document_type_id,
                'identity_document_type_code' => $row->identity_document_type->code,
                'addresses' => $row->addresses,
                'address' =>  $row->address,
                'seller_id' =>  $row->seller_id,
                'phone' => $row->telephone,
            ];
        });

        return compact('persons');
    } */




    public function getIdentityDocumentTypeId($document_type_id)
    {

        return ($document_type_id == '01') ? [6] : [1, 4, 6, 7, 0];
    }
}
