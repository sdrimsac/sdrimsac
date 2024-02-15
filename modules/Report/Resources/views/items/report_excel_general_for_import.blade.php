<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>REPORTE POR PRODUCTO</strong></h3>
    </div>
    <br>
    <div style="margin-top:20px; margin-bottom:15px;">
        <table>

            <tr>
                <td>
                    <p><b>Empresa: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $company->name }}</strong></p>
                </td>
                <td>
                    <p><strong>Fecha: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ date('Y-m-d') }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
                <td>
                    <p><strong>Establecimiento: </strong></p>
                </td>
                <td align="center">{{ $establishment->address }} - {{ $establishment->department->description }} -
                    {{ $establishment->district->description }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php
                    
                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th> Descripción</th>
                            <th> Nombre Secundario</th>
                            <th> Código Interno</th>
                            <th> Codigo Barra</th>
                            <th> Código Sunat</th>
                            <th> Código Tipo de Unidad</th>
                            <th> Código Tipo de Moneda</th>
                            <th> Precio Unitario Venta</th>
                            <th> Codigo Tipo de Afectación del Igv Venta</th>
                            <th> Tiene Igv</th>
                            <th> Precio Unitario Compra</th>
                            <th> Codigo Tipo de Afectación del Igv Compra</th>
                            <th> Stock</th>
                            <th> Stock Mínimo</th>
                            <th> Categoria</th>
                            <th> Marca</th>
                            <th> Area</th>
                            <th> Series</th>
                            <th> p1_desc</th>
                            <th> p1_cant</th>
                            <th> p1_precio</th>
                            <th> p2_desc</th>
                            <th> p2_cant</th>
                            <th> p2_precio</th>
                            <th> p3_desc</th>
                            <th> p3_cant</th>
                            <th> p3_precio</th>
                            <th> p4_desc</th>
                            <th> p4_cant</th>
                            <th> p4_precio</th>
                            <th> Cantidad Maxima</th>
                            <th> Contenedor</th>
                            <th> Código de lote</th>
                            <th> Fecha de Vencimiento d/m/a</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            @php
                            @endphp
                            <tr>
                                <td>
                                    {{ $value->description }}
                                </td>
                                <td>
                                    {{ $value->second_name }}
                                </td>
                                <td>
                                    {{ $value->internal_id }}
                                </td>
                                <td>
                                    {{ $value->barcode }}
                                </td>
                                <td>
                                    {{ $value->item_code }}
                                </td>
                                <td>
                                    {{ $value->unit_type_id }}
                                </td>
                                <td>
                                    {{ $value->currency_type_id }}
                                </td>
                                <td>
                                    {{ $value->sale_unit_price }}
                                </td>
                                <td>
                                    {{ $value->sale_affectation_igv_type_id }}
                                </td>
                                <td>
                                    {{ $value->has_igv == 1 ? 'SI' : 'NO' }}
                                </td>
                                <td>
                                    {{ $value->purchase_unit_price }}
                                </td>
                                <td>
                                    {{ $value->purchase_affectation_igv_type_id }}
                                </td>
                                <td>
                                    @php
                                        $id = $value->id;
                                        $warehouse = App\Models\Tenant\ItemWarehouse::where('item_id', $id)
                                            ->where('warehouse_id', $warehouse_id)
                                            ->first();
                                    @endphp
                                    {{-- checar por almacen --}}
                                    {{ $warehouse->stock }}
                                </td>
                                <td>
                                    {{ $value->stock_min }}
                                </td>
                                <td>
                                    {{ $value->category ? $value->category->name : '' }}
                                </td>
                                <td>
                                    {{ $value->brand ? $value->brand->name : '' }}
                                </td>
                                <td>
                                    {{ $value->area ? $value->area->name : '' }}
                                </td>
                                <td>
                                    {{ $value->series_enabled == 1 ? 'SI' : 'NO' }}
                                </td>
                                @php
                                    $item_id = $value->id;
                                    $item_unit_types = App\Models\Tenant\ItemUnitType::where('item_id', $item_id)
                                        ->get()
                                        ->take(4);
                                    $unit_types = [];
                                    foreach ($item_unit_types as $idx => $item_unit_type) {
                                        $idx = $idx + 1;
                                        $unit_types[] = [
                                            "p{$idx}_desc" => $item_unit_type->description,
                                            "p{$idx}_cant" => $item_unit_type->quantity_unit,
                                            "p{$idx}_precio" => $item_unit_type->price2 * $item_unit_type->quantity_unit,
                                        ];
                                    }
                                    $count = 4 - count($unit_types);
                                @endphp
                                @foreach ($unit_types as $key => $unit_type)
                                    @php
                                        $idx = $key + 1;
                                    @endphp
                                    <td>
                                        {{ $unit_type["p{$idx}_desc"] }}
                                    </td>
                                    <td>
                                        {{ $unit_type["p{$idx}_cant"] }}
                                    </td>
                                    <td>
                                        {{ $unit_type["p{$idx}_precio"] }}
                                    </td>
                                @endforeach
                                @for ($i = 0; $i < $count; $i++)
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endfor


                                <td>
                                    {{ $value->max_quantity }}
                                </td>
                                <td>
                                    {{ $value->max_quantity_description }}
                                </td>
                                <td>
                                    {{ $value->lot_code }}
                                </td>
                                <td>
                                    @php
                                        //si existe date_of_due pasalo a fecha y regresalo en formato d/m/Y
                                        if ($value->date_of_due) {
                                            $value->date_of_due = date('d/m/Y', strtotime($value->date_of_due));
                                        }
                                    @endphp
                                    {{ $value->date_of_due }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div>
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
