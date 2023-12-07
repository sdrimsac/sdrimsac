<!DOCTYPE html>
<html lang="es">
@php
    $max_quantity_description = null;
    $max_quantity_und = 1;
    if ($item_id) {
        $item = \App\Models\Tenant\Item::find($item_id);
        $max_quantity_description = $item->unit_type->description;
        $unit_type_description = $item->unit_type->description;
        if ($max_quantity) {
            $max_quantity_description = $item->max_quantity_description ?? $item->unit_type->description;
            $max_quantity_und = $item->max_quantity;
        }
    }
    $formatQuantity = function ($quantity) use ($max_quantity_und, $max_quantity_description, $unit_type_description) {
        $general = intval($quantity / $max_quantity_und);
        $part = fmod($quantity / $max_quantity_und,  1);
        $text = $general . ' ' . $max_quantity_description;
        if ($part != 0) {
            $new_part = $part * $max_quantity_und;
            $new_part = number_format($new_part, 2, '.', '');
            $text .=' '. $new_part . ' ' . $unit_type_description;
        }
    
        return $text;
    };
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kardex</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Reporte Kardex</strong></h3>
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
                    <p><strong>{{ date('d/m/Y') }}</strong></p>
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
            @if ($max_quantity_description)
                <tr>
                    <td>
                        <p><strong>Unidad de medida: </strong></p>
                    </td>
                    <td align="center">{{ $max_quantity_description }}</td>
                </tr>
            @endif
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if (!$item_id)
                                <th>Producto</th>
                            @endif
                            <th>Fecha y hora transacción</th>
                            <th>Tipo transacción</th>
                            <th>Número</th>
                            <th>NV. Asociada</th>
                            <th>Feha emisión</th>

                            <th>Entrada</th>
                            <th>Salida</th>
                            @if ($item_id)
                                <th>Saldo</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            @php
                                $quantity = $value->quantity;
                                // if ($max_quantity) {
                                //     if ($quantity != null && $quantity != 0 && $quantity != '-') {
                                //         $quantity = $quantity / $max_quantity_und;
                                //         $quantity = number_format($quantity, 2, '.', '');
                                //     }
                                // }
                            @endphp
                            <tr>
                                <td class="celda">{{ $loop->iteration }}</td>
                                @if (!$item_id)
                                    <td class="celda">{{ $value->item->description }}</td>
                                @endif
                                <td class="celda">{{ $value->created_at->format('d/m/Y H:i') }}</td>
                                <td class="celda">

                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ $quantity < 0 ? 'Venta' : 'Anulación' }}
                                        @break

                                        @case($models[1])
                                            {{ 'Compra' }}
                                        @break

                                        @case($models[2])
                                            {{ 'Nota de venta' }}
                                        @break

                                        @case($models[3])
                                            {{ $value->inventory_kardexable->description }}
                                        @break

                                        @case($models[4])
                                            {{ $quantity < 0 ? 'Pedido' : 'Anulación pedido' }}
                                        @break
                                        @case($models[5])
                                            {{ 'A cuenta' }}
                                        @break
                                    @endswitch


                                </td>
                                <td class="celda">
                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ optional($value->inventory_kardexable)->series . '-' . optional($value->inventory_kardexable)->number }}
                                        @break

                                        @case($models[1])
                                            {{ optional($value->inventory_kardexable)->series . '-' . optional($value->inventory_kardexable)->number }}
                                        @break

                                        @case($models[2])
                                            {{ optional($value->inventory_kardexable)->prefix . '-' . optional($value->inventory_kardexable)->id }}
                                        @break

                                        @case($models[3])
                                            {{ '-' }}
                                        @break

                                        @case($models[4])
                                            {{ optional($value->inventory_kardexable)->prefix . '-' . optional($value->inventory_kardexable)->id }}
                                        @break
                                    @endswitch

                                </td>
                                <td class="celda">
                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ isset($value->inventory_kardexable->sale_note_id) ? optional($value->inventory_kardexable)->sale_note->prefix . '-' . optional($value->inventory_kardexable)->sale_note->id : '-' }}
                                        @break

                                        @default
                                            {{ '-' }}
                                        @break
                                    @endswitch

                                </td>
                                <td class="celda">

                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ isset($value->inventory_kardexable->date_of_issue) ? \Carbon\Carbon::parse($value->inventory_kardexable->date_of_issue)->format('d/m/Y') : '' }}
                                        @break

                                        @case($models[1])
                                            {{ isset($value->inventory_kardexable->date_of_issue) ? \Carbon\Carbon::parse($value->inventory_kardexable->date_of_issue)->format('d/m/Y') : '' }}
                                        @break

                                        @case($models[2])
                                            {{ isset($value->inventory_kardexable->date_of_issue) ? \Carbon\Carbon::parse($value->inventory_kardexable->date_of_issue)->format('d/m/Y') : '' }}
                                        @break

                                        @case($models[3])
                                            {{ '-' }}
                                        @break

                                        @case($models[4])
                                            {{ isset($value->inventory_kardexable->date_of_issue) ? \Carbon\Carbon::parse($value->inventory_kardexable->date_of_issue)->format('d/m/Y') : '' }}
                                        @break
                                    @endswitch



                                </td>

                                @php
                                    if ($value->inventory_kardexable_type == $models[3]) {
                                        if (!$value->inventory_kardexable->type) {
                                            $transaction = Modules\Inventory\Models\InventoryTransaction::findOrFail($value->inventory_kardexable->inventory_transaction_id);
                                        }
                                    }
                                    
                                @endphp

                                <td class="celda">
                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ $quantity > 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                        @break

                                        @case($models[1])
                                            {{ $quantity > 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                        @break

                                        @case($models[3])
                                            @if ($value->inventory_kardexable->type != null)
                                                {{ $value->inventory_kardexable->type == 1 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @else
                                                {{ $transaction->type == 'input' ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @endif
                                        @break

                                        @case($models[4])
                                            {{ $quantity > 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                        @break

                                        @default
                                            {{ '-' }}
                                        @break
                                    @endswitch
                                </td>
                                <td class="celda">

                                    @switch($value->inventory_kardexable_type)
                                        @case($models[0])
                                            {{ $quantity < 0 ? (isset($value->inventory_kardexable->sale_note_id) ? '-' : $formatQuantity($quantity)) : '-' }}

                                            @php($quantity < 0) ? (isset($value->inventory_kardexable->sale_note_id) ?
                                            $quantity = 0:$quantity):"-";
                                            @endphp
                                        @break

                                        @case($models[1])
                                            {{ $quantity < 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                        @break

                                        @case($models[2])
                                            {{ $quantity }}
                                        @break

                                        @case($models[3])
                                            @if ($value->inventory_kardexable->type != null)
                                                {{ $value->inventory_kardexable->type == 2 || $value->inventory_kardexable->type == 3 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @else
                                                {{ $transaction->type == 'output' ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @endif
                                        @break

                                        @case($models[4])
                                            {{ $quantity < 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                        @break

                                        @default
                                            {{ '-' }}
                                        @break
                                    @endswitch

                                </td>
                                @php
                                    $balance += $quantity;
                                @endphp

                                @if ($item_id)
                                    {{-- <td class="celda">{{ number_format($balance, 4, '.', '') }}</td> --}}
                                    <td class="celda">{{$formatQuantity($balance) }}</td>
                                @endif
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
