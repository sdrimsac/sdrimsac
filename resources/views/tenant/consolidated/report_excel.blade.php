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
        <h3 align="center" class="title"><strong>Consolidado</strong></h3>
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
                    <p><strong>Fecha de consolidacion: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ $consolidated->date_of_issue }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($groupedQuotations))
        <div>
            <table width="100%" class="">

                <thead>
                    <tr>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">#</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">CODIGO PRODUCTO</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">PRODUCTO</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">PRESENTACION</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">CANTIDAD</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">CLIENTE</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">ZONA</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $idx_g = 0;
                    @endphp
                    @foreach ($groupedQuotations as $idx => $value)
                        @php
                            $idx_iteration = $loop->iteration;
                            //count all items
                            $count_zone_items = 0;
                            foreach ($value as $idx2 => $value2) {
                                $count_zone_items += count($value2->items);
                            }
                        @endphp
                        @foreach ($value as $idx2 => $value2)
                            @php
                                $count_client_items = count($value2->items);
                            @endphp
                            @foreach ($value2->items as $item)
                                @php
                                    $idx_g++;
                                    $unitTypeDescription = '-';
                                    if (isset($item->item->from_unit_type_id)) {
                                        $unitType = \App\Models\Tenant\ItemUnitType::find(
                                            $item->item->from_unit_type_id,
                                        );
                                        $unitTypeDescription = $unitType ? $unitType->description : '-';
                                    }
                                @endphp
                                <tr>
                                    <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $item->item->internal_id }}
                                    </td>
                                    <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $idx_g }}
                                    </td>
                                    <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $item->item->description }}
                                    </td>
                                    <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $unitTypeDescription }}
                                    </td>
                                    <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $item->quantity }}
                                    </td>
                                    @if ($loop->first)
                                        <td valign="middle" rowspan="{{ $count_client_items }}" style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                            {{ $value2->customer->name }}
                                        </td>
                                    @endif
                                    @if ($loop->first && $idx2 == 0)
                                        <td valign="middle" rowspan="{{ $count_zone_items }}" style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                            {{ $idx }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    @if (!empty($records))
        <div class="">
            <div class=" ">

                <table width="100%" class="">

                    <tr>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">#</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">CODIGO</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">PRODUCTO</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">PRESENTACION</th>
                        <th class="encabezado" style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">CANTIDAD</th>
                    </tr>
                    <tbody>
                        @foreach ($records as $idx => $value)
                            <tr>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->item_internal_id }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->item_description }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->unit_type_description }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->total_quantity }}

                                </td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>
    @endif
</body>

</html>
