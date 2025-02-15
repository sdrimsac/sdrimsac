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
        $part = fmod($quantity / $max_quantity_und, 1);
        $text = $general . ' ' . $max_quantity_description;
        if ($part != 0) {
            $new_part = $part * $max_quantity_und;
            $new_part = number_format($new_part, 2, '.', '');
            $text .= ' ' . $new_part . ' ' . $unit_type_description;
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
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td colspan="9"
                        style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 13px; text-align: center;">
                        <h3><strong>Reporte Kardex</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"
                        style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong> {{ $company->name }}</p>
                    </td>
                    <td colspan="4"
                        style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong> {{ date('d/m/Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"
                        style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong> {{ $company->number }}</p>
                    </td>
                    <td colspan="6"
                        style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Establecimiento: </strong> {{ $establishment->address }} -
                            {{ $establishment->department->description }} -
                            {{ $establishment->district->description }}
                        </p>
                    </td>

                </tr>
                @if ($max_quantity_description)
                    <tr>
                        <td colspan="9"
                            style="border: 1px solid black !important; background-color: #DCDCDC; font-size: 12px;">
                            <p><strong>Unidad de medida: </strong>{{ $max_quantity_description }}</p>
                        </td>
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
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">#</th>
                                @if (!$item_id)
                                    <th style="border: 1px solid black !important; background-color: #DCDCDC;">Producto
                                    </th>
                                @endif
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Usuario
                                </th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Fecha y hora
                                    transacción</th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Tipo
                                    transacción</th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Número</th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">NV. Asociada
                                </th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Feha emisión
                                </th>

                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Entrada</th>
                                <th style="border: 1px solid black !important; background-color: #DCDCDC;">Salida</th>
                                @if ($item_id)
                                    <th style="border: 1px solid black !important; background-color: #DCDCDC;">Saldo
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $key => $value)
                                @php
                                    $quantity = $value->quantity;
                                    if ($value->user_id) {
                                        $value->user_name = $value->user->name;
                                    }
                                    // if ($max_quantity) {
                                    // if ($quantity != null && $quantity != 0 && $quantity != '-') {
                                    // $quantity = $quantity / $max_quantity_und;
                                    // $quantity = number_format($quantity, 2, '.', '');
                                    // }
                                    // }
                                @endphp
                                <tr>
                                    <td class="celda" style="border: 1px solid black !important;">
                                        {{ $loop->iteration }}</td>
                                    @if (!$item_id)
                                        <td class="celda" style="border: 1px solid black !important;">
                                            {{ $value->item->description }}</td>
                                    @endif
                                    <td class="celda" style="border: 1px solid black !important;">
                                        {{ $value->user_name }}</td>
                                    <td class="celda" style="border: 1px solid black !important;">
                                        {{ $value->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="celda" style="border: 1px solid black !important;">

                                        @switch($value->inventory_kardexable_type)
                                            @case($models[0])
                                                {{ $quantity < 0 ? 'Venta' : 'Anulación' }}
                                            @break

                                            @case($models[1])
                                                {{ 'Compra' }}
                                            @break

                                            @case($models[2])
                                            {{ $quantity < 0 ? 'Nota de venta' : 'Nota de venta Anulado interno' }}
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

                                            @case($models[7])
                                                {{ $value->is_import_excel == 1 ? 'Importación' : 'Ingreso' }}
                                            @break
                                        @endswitch


                                    </td>
                                    <td class="celda" style="border: 1px solid black !important;">
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
                                    <td class="celda" style="border: 1px solid black !important;">
                                        @switch($value->inventory_kardexable_type)
                                            @case($models[0])
                                                {{ isset($value->inventory_kardexable->sale_note_id) ? optional($value->inventory_kardexable)->sale_note->prefix . '-' . optional($value->inventory_kardexable)->sale_note->id : '-' }}
                                            @break

                                            @default
                                                {{ '-' }}
                                            @break
                                        @endswitch

                                    </td>
                                    <td class="celda" style="border: 1px solid black !important;">

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
                                                $transaction = Modules\Inventory\Models\InventoryTransaction::findOrFail(
                                                    $value->inventory_kardexable->inventory_transaction_id,
                                                );
                                            }
                                        }

                                    @endphp

                                    <td class="celda" style="border: 1px solid black !important;">
                                        @switch($value->inventory_kardexable_type)
                                            @case($models[0])
                                                {{ $quantity > 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @break

                                            @case($models[1])
                                                {{ $quantity > 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @break
                                            
                                            @case($models[2])
                                            {{ $quantity > 0 ? $formatQuantity($quantity) : '-' }}
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
                                    <td class="celda" style="border: 1px solid black !important;">

                                        @switch($value->inventory_kardexable_type)
                                            @case($models[0])
                                                {{ $quantity < 0 ? (isset($value->inventory_kardexable->sale_note_id) ? '-' : $formatQuantity($quantity)) : '-' }}

                                                {{-- @php($quantity < 0) ?
                                                (isset($value->inventory_kardexable->sale_note_id) ?
                                                $quantity = 0:$quantity):"-";
                                                @endphp --}}
                                            @break

                                            @case($models[1])
                                                {{ $quantity < 0 ? ($max_quantity ? $formatQuantity($quantity) : $quantity) : '-' }}
                                            @break
                                            @case($models[2])
                                            {{ $quantity < 0 ? ($formatQuantity($quantity)) : '-' }}
    
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
                                        {{-- <td class="celda" style="border: 1px solid black !important;">{{ number_format($balance, 4, '.', '') }}</td> --}}
                                        <td class="celda" style="border: 1px solid black !important;">
                                            {{ $formatQuantity($balance) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </table>
@else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>
