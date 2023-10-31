@php
    $establishment = $document->establishment;
    $customer = $document->customer;
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    
    $left = $document->series ? $document->series : $document->prefix;
    $tittle = $left . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $payments = $document->payments;
    $hotel_rent = \App\Models\Tenant\HotelRent::where('sale_note_id', $document->id)->first();
@endphp
<html>

<head>
    {{-- <title>{{ $tittle }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
</head>

<body>
    <table class="full-width">
        <tr>
            @if ($stablishment->logo || $stablishment->document_logo)
                <td width="20%">
                    <div class="company_logo_box">
                        @if ($stablishment->document_logo)
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 150px;">
                        @else
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 150px;">
                        @endif
                    </div>
                </td>
            @else
                @if ($company->logo)
                    <td width="20%">
                        <div class="company_logo_box">
                            @if ($company->document_logo)
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 150px;">
                            @else
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 150px;">
                            @endif
                        </div>
                    </td>
                @else
                    <td width="20%">
                    </td>
                @endif
            @endif
            <td width="50%" class="pl-3">
                <div class="text-left">
                    <h4 class="">{{ $company->trade_name }}</h4>
                    <h6>{{ $company->eslogan }}</h6>
                    <h5>{{ 'RUC ' . $company->number }}</h5>
                    <h6>
                        {{ $establishment->address !== '-' ? $establishment->address : '' }}
                        {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                        {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                        {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                    </h6>
                    <h6>{{ $establishment->email !== '-' ? $establishment->email : '' }}</h6>
                    <h6>{{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}</h6>
                </div>
            </td>
            <td width="30%" class="border-box py-4 px-2 text-center">
                <h5 class="text-center">NOTA DE VENTA</h5>
                <h3 class="text-center">{{ $tittle }}</h3>
            </td>
        </tr>
    </table>
    <table class="full-width mt-4">
        <tr>
            <td width="80" height="18px"><b>Cliente:</b></td>
            <td>{{ $customer->name }}</td>
            <td><b>{{ $customer->identity_document_type->description }}:</b></td>
            <td>{{ $customer->number }}</td>

        </tr>
        @isset($customer->telephon)
            <tr>
                <td width="80" height="18px"><b>Telefono:</b></td>
                <td>{{ $customer->telephono }}</td>
            </tr>
        @endisset
        @if ($student_name)
            <tr>
                <td width="80" height="18px"><b>Alumno:</b></td>
                <td>{{ $student_name }}</td>
                <td><b>Clase:</b></td>
                <td>{{ $class }}</td>

            </tr>
        @endif

        <tr>
            <td height="18px"><b>Telefono:</b></td>
            <td>{{ $customer->telephone }}</td>
            <td><b>Fecha Emisión</b></td>
            <td>{{ $document->date_of_issue->format('d-m-Y') }}</td>

        </tr>

        @if ($customer->address !== '')
            <tr>
                <td height="18px"><b>Dirección:</b></td>
                <td colspan="3">
                    {{ $customer->address }}
                    {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                    {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                    {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                </td>
            </tr>
        @endif
        @if ($document->paid == 1)
            <tr>
                <td height="18px"><b>Estado:</b></td>
                <td colspan="3">CANCELADO</td>
            </tr>
        @else
            <tr>
                <td height="18px"><b>Estado:</b></td>
                <td colspan="3">PENDIENTE DE PAGO</td>
            </tr>
        @endif
        <tr>
            <td height="18px"><b>OBSERVACION:</b></td>
            <td colspan="3" class="align-top">{{ trim($document->observation) }}</td>
        </tr>
        @if ($hotel_rent)
            @php
                $hotel_rent_items = $hotel_rent->items;
                
            @endphp
            @foreach ($hotel_rent_items as $hri)
                <tr>
                    <td height="18px">
                        <b>
                            Habitación:
                        </b>
                    </td>
                    <td colspan="3" class="align-top">
                        {{ $hri->table->number }}
                    </td>
                </tr>
                <tr>
                    <td height="18px">
                        <b>
                            Entrada:
                        </b>

                    </td>
                    <td colspan="3" class="align-top">

                        {{ \Carbon\Carbon::parse($hri->checkin_date)->format('d/m/Y') }} {{ $hri->checkin_time }}
                    </td>
                </tr>
                <tr>
                    <td height="18px">
                        <b>
                            Salida:
                        </b>

                    </td>
                    <td colspan="3" class="align-top">
                        {{ \Carbon\Carbon::parse($hri->checkout_date)->format('d/m/Y') }} {{ $hri->checkout_time }}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    <table class="full-width mt-10 mb-10">
        <thead class="">
            <tr class="bg-grey">
                <th class="border-top-bottom text-center py-2" width="8%">CANT.</th>
                <th class="border-top-bottom text-center py-2" width="8%">UNIDAD</th>
                <th class="border-top-bottom text-left py-2">DESCRIPCIÓN</th>
                <th class="border-top-bottom text-center py-2" width="8%">LOTE</th>
                <th class="border-top-bottom text-center py-2" width="8%">SERIE</th>
                <th class="border-top-bottom text-right py-2" width="12%">P.UNIT</th>
                <th class="border-top-bottom text-right py-2" width="8%">DTO.</th>
                <th class="border-top-bottom text-right py-2" width="12%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($document->items as $row)
                <tr>
                    <td class="text-center align-top">
                        @if ((int) $row->quantity != $row->quantity)
                            {{ $row->quantity }}
                        @else
                            @if (isset($row->unit_qty))
                                {{ number_format($row->quantity, 0) }}
                            @else
                                {{ number_format($row->quantity, 0) }}
                            @endif
                        @endif
                    </td>
                    <td class="text-center align-top">
                        {{ isset($row->item->from_unit_type_id_desc) ? 'NIU' : $row->item->unit_type_id }}
                    </td>
                    <td class="text-left">

                        @if (isset($row->item->descriptionInternet))
                            {{ $row->item->descriptionInternet }}
                        @else
                            @if (isset($row->name_product_pdf) && strlen($row->name_product_pdf) > 0)
                                {{ $row->name_product_pdf }}
                            @else
                                {{ $row->item->description }}
                            @endif
                        @endif

                        @if (isset($row->item->from_unit_type_id_desc))
                            - {!! $row->item->from_unit_type_id_desc !!}
                        @endif
                        @if (isset($row->item->second_name))
                            - {!! $row->item->second_name !!}
                        @endif
                        @if (isset($row->unit_desc))
                            {!! $row->unit_desc !!}
                        @endif
                        @if (isset($row->item->lots))
                            @foreach ($row->item->lots as $lot)
                                <br />{!! $lot->series !!}
                            @endforeach
                        @endif

                        @if (!empty($row->item->presentation))
                            {!! $row->item->presentation->description !!}
                        @endif

                        @if ($row->discounts)
                            @foreach ($row->discounts as $dtos)
                                <br /><span style="font-size: 9px">{{ $dtos->factor * 100 }}%
                                    {{ $dtos->description }}</span>
                            @endforeach
                        @endif




                    </td>
                    <td class="text-center align-top">
                        {{-- @inject('itemLotGroup', 'App\Services\ItemLotsGroupService')
                @php
                    $lot_code = isset($row->item->lots_group) ? collect($row->item->lots_group)->first(function($row){ return $row->checked == true;}):null;
                @endphp
                {{
                    $itemLotGroup->getLote($lot_code ? $lot_code->id : null)
                }} --}}

                    </td>
                    <td class="text-center align-top">

                    </td>
                    <td class="text-right align-top">

                        @if (isset($row->price_unit))
                            {{ number_format($row->price_unit, 2) }}
                    </td>
                @else
                    {{ number_format($row->unit_price, 2) }}</td>
            @endif

            </td>
            <td class="text-right align-top">
                @if ($row->discounts)
                    @php
                        $total_discount_line = 0;
                        foreach ($row->discounts as $disto) {
                            $total_discount_line = $total_discount_line + $disto->amount;
                        }
                    @endphp
                    {{ number_format($total_discount_line, 2) }}
                @else
                    0
                @endif
            </td>
            <td class="text-right align-top">{{ number_format($row->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="8" class="border-bottom"></td>
            </tr>
            @endforeach
            @if ($document->total_exportation > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">OP. EXPORTACIÓN:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_exportation, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_free > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">OP. GRATUITAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_free, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_unaffected > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">OP. INAFECTAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_unaffected, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_exonerated > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">OP. EXONERADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_exonerated, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_taxed > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">OP. GRAVADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_taxed, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_discount > 0)
                <tr>
                    <td colspan="7" class="text-right font-bold">
                        {{ $document->total_prepayment > 0 ? 'ANTICIPO' : 'DESCUENTO TOTAL' }}:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="7" class="text-right font-bold">IGV: {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_igv, 2) }}</td>
            </tr>
            <tr>
                <td colspan="7" class="text-right font-bold">TOTAL VENTA: {{ $document->currency_type->symbol }}
                </td>
                <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="7" class="text-right font-bold border_detalles">REDONDEO:
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold border_detalles">{{ number_format($document->total_rounded, 2) }}</td>
            </tr>
            <tr>
                <td colspan="7" class="text-right font-bold border_detalles">TOTAL A PAGAR:
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold border_detalles">{{ number_format($document->total_payment, 2) }}</td>
            </tr>
            {{-- <tr>
                <td colspan="7" height="18px"><b>OBSERVACION: </b>{{ trim($document->observation) }}</td>
            </tr> --}}
        </tbody>

    </table>
    <table class="full-width">
        <tr>
            <td>
                <strong>PAGOS:</strong>
            </td>
        </tr>
        @foreach ($boxes as $box)
            <tr>
                <td colspan="7" class="text-left font-bold border_detalles">{{ $box->method }} @if ($box->bank_account_operation)
                        <small>N° Op: {{ $box->bank_account_operation }}</small>
                    @endif
                    :
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format(abs($box->amount), 2, '.', '') }}
                </td>
            </tr>
        @endforeach


    </table>
    {{-- <table align="center" width="70%" style="margin-top:50px">
        <tr>
            <td align="center" width="45%" style="border-top:1px solid #000;font-weight:bold">Recibi
                Conforme<br>Cliente</td>
            <td></td>
            <td align="center" width="45%" style="border-top:1px solid #000;font-weight:bold">Vendedor:
                {{ $document->user->name }}<br>Celular:{{ $document->user->telephone }}</td>

        </tr>
    </table> --}}
</body>

</html>
