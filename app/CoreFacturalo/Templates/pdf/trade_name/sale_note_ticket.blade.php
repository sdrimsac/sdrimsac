@php
    
    $establishment = $document->establishment;
    $customer = $document->customer;
    $invoice = $document->invoice;
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $tittle = $document->series . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $payments = $document->payments;
    $is_chifa_china = $company->number == '15609876309';
@endphp
<html>

<head>
    {{-- <title>{{ $tittle }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
</head>

<body>

    @if ($stablishment->logo || $stablishment->document_logo)
        @if ($is_chifa_china)
            <div class="text-center company_logo_box" style="padding-top:2rem;width: 350px;">
                @if ($stablishment->document_logo)
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="
    contain" style=" max-width: 400px; max-height: 150px">
                @else
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="
    contain" style=" max-width: 400px; max-height: 150px">
                @endif
            </div>
        @else
            <div class="text-center full-width company_logo_box pt-5">
                @if ($stablishment->document_logo)
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                @else
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                @endif
            </div>
        @endif
    @else
        @if ($company->logo)
            @if ($is_chifa_china)
                <div class="text-center company_logo_box" style="padding-top:2rem;width: 350px;">
                    @if ($company->document_logo)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
  contain"
                            style=" max-width: 400px; max-height: 150px">
                    @else
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
  contain"
                            style=" max-width: 400px; max-height: 150px">
                    @endif
                </div>
            @else
                <div class="text-center full-width company_logo_box pt-5">
                    @if ($company->document_logo)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                    @else
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                    @endif
                </div>
            @endif
        @endif
    @endif
    <table class="full-width">
        <tr>
            <td class="text-center">
                @if ($is_chifa_china)
                    <h1>{{ $company->trade_name }}</h1>
                @else
                    <h4>{{ $company->trade_name }}</h4>
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center">
                @if ($is_chifa_china)
                    <h5>{{ $company->eslogan }}</h5>
                @else
                    <h4>{{ $company->eslogan }}</h4>
                @endif
            </td>
        </tr>
        @if ($is_chifa_china)
            <tr>
                <td class="text-center">
                    <h5> {{ $company->name }}</h5>
                </td>
            </tr>
        @endif
        <tr>
            <td class="text-center">
                @if ($is_chifa_china)
                    <h5>{{ 'RUC ' . $company->number }}</h5>
                @else
                    <h5>{{ 'RUC ' . $company->number }}</h5>
            </td>
            @endif

            </h5>
            </td>
        </tr>
        <tr>
            <td class="text-center">
                {{ $establishment->address !== '-' ? $establishment->address : '' }}
                {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
            </td>
        </tr>
        <tr>
            <td class="text-center">{{ $establishment->email !== '-' ? $establishment->email : '' }}</td>
        </tr>
        <tr>
            <td class="text-center pb-3">{{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}</td>
        </tr>
        <tr>
            <td class="text-center pt-3 border-top">
                <h4>NOTA DE VENTA</h4>
            </td>
        </tr>
        <tr>
            <td class="text-center pb-3 border-bottom">
                <h3>{{ $tittle }}</h3>
            </td>
        </tr>
    </table>
    <table class="full-width">
        <tr>
            <td width="" class="pt-3">
                <p class="desc">F. Emisión:</p>
            </td>
            <td width="" class="pt-3">
                <p class="desc">{{ $document->date_of_issue->format('d-m-Y') }}</p>
            </td>
        </tr>


        <tr>
            <td class="align-top">
                <p class="desc">Cliente:</p>
            </td>
            <td>
                <p class="desc">{{ $customer->name }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="desc">{{ $customer->identity_document_type->description }}:</p>
            </td>
            <td>
                <p class="desc">{{ $customer->number }}</p>
            </td>
        </tr>
        @isset($customer->telephone)
            <tr>
                <td>
                    <p class="desc">Telefono:</p>
                </td>
                <td>
                    <p class="desc">{{ $customer->telephone }}</p>
                </td>

            </tr>
        @endisset

        @if ($student_name)
            <tr>
                <td class="align-top">
                    <p class="desc">Alumno:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $student_name }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">Clase:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $class }}
                    </p>
                </td>
            </tr>
        @endif
        @if ($customer->address !== '')
            <tr>
                <td class="align-top">
                    <p class="desc">Dirección:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $customer->address }}
                        {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                        {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                        {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                    </p>
                </td>
            </tr>
        @endif
        @if ($document->purchase_order)
            <tr>
                <td>
                    <p class="desc">Orden de Compra:</p>
                </td>
                <td>
                    <p class="desc">{{ $document->purchase_order }}</p>
                </td>
            </tr>
        @endif
        <tr>
            <td height="18px"><b>OBSERVACION:</b></td>
            <td colspan="3" class="align-top">{{ trim($document->observation) }}</td>
        </tr>

    </table>

    <table class="full-width mt-10 mb-10">
        <thead class="">
            <tr>
                <th class="border-top-bottom desc-9 text-left">CANT.</th>
                <th class="border-top-bottom desc-9 text-left">UNIDAD</th>
                <th class="border-top-bottom desc-9 text-left">DESCRIPCIÓN</th>
                <th class="border-top-bottom desc-9 text-left">P.UNIT</th>
                <th class="border-top-bottom desc-9 text-left">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($document->items as $row)
                <tr>
                    <td class="text-center desc-9 align-top">
                        @if ((int) $row->quantity != $row->quantity)
                            {{ number_format($row->quantity, 2) }}
                        @else
                            @if (isset($row->unit_qty))
                                {{ number_format($row->quantity, 2) }}
                            @else
                                {{ number_format($row->quantity, 2) }}
                            @endif
                        @endif
                    </td>
                    <td class="text-center desc-9 align-top">{{ $row->item->unit_type_id }}</td>
                    <td class="text-left desc-9 align-top">
                        @if (isset($row->item->descriptionInternet))
                            {{ $row->item->descriptionInternet }}
                        @else
                            {!! $row->item->description !!}
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
                        @if (!empty($row->item->presentation))
                            {!! $row->item->presentation->description !!}
                        @endif
                        @if (isset($row->item->lots))
                        @foreach ($row->item->lots as $lot)
                            <br />{!! $lot->series !!}
                        @endforeach
                    @endif

                        @if ($row->attributes)
                            @foreach ($row->attributes as $attr)
                                <br />{!! $attr->description !!} : {{ $attr->value }}
                            @endforeach
                        @endif
                        @if ($row->discounts)
                            @foreach ($row->discounts as $dtos)
                                <br /><small>{{ $dtos->factor * 100 }}% {{ $dtos->description }}</small>
                            @endforeach
                        @endif
                    </td>
                    <td class="text-right desc-9 align-top">
                        @if (isset($row->price_unit))
                            {{ number_format($row->price_unit, 2) }}
                    </td>
                @else
                    {{ number_format($row->unit_price, 2) }}</td>
            @endif
            <td class="text-right desc-9 align-top">{{ number_format($row->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="5" class="border-bottom"></td>
            </tr>
            @endforeach
            @if ($document->total_exportation > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. EXPORTACIÓN:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_exportation, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_free > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. GRATUITAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_free, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_unaffected > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. INAFECTAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_unaffected, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_exonerated > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. EXONERADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_exonerated, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_taxed > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. GRAVADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_taxed, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_discount > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold">
                        {{ $document->total_prepayment > 0 ? 'ANTICIPO' : 'DESCUENTO TOTAL' }}:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="4" class="text-right font-bold desc">IGV: {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_igv, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold desc">TOTAL A PAGAR:
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total, 2) }}</td>
            </tr>
            @php
                
                $total_boxes = 0;
                foreach ($boxes as $box) {
                    $total_boxes += floatval($box->amount);
                }
                
                $difference = $total_boxes - $document->total;
            @endphp
            @if ($difference > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">VUELTO:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($difference, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    <table class="full-width">
        <tr>

            @foreach (array_reverse((array) $document->legends) as $row)
        <tr>
            @if ($row->code == '1000')
                <td class="desc pt-3">Son: <span class="font-bold">{{ $row->value }}
                        {{ $document->currency_type->description }}</span></td>
                @if (count((array) $document->legends) > 1)
        <tr>
            <td class="desc pt-3"><span class="font-bold">Leyendas</span></td>
        </tr>
        @endif
    @else
        <td class="desc pt-3">{{ $row->code }}: {{ $row->value }}</td>
        @endif
        </tr>
        @endforeach
        </tr>
        @foreach ($boxes as $box)
            <tr>
                <td colspan="4" class="text-left font-bold desc">Total {{ $box->method }}:
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format(abs($box->amount), 2, '.', '') }}</td>
            </tr>
        @endforeach

        @if (!empty(Session::get('difference')))
            <tr>
                <td align="right">EFECTIVO: {{ $document->currency_type->symbol }}
                    {{ number_format(Session::get('enter_amount'), 2) }}</td>
            </tr>
            <tr>
                <td align="right">VUELTO: {{ $document->currency_type->symbol }}
                    {{ number_format(Session::get('difference'), 2) }}</td>
            </tr>
        @endif
        {{-- <tr>
            <td class="desc pt-3"><b>OBSERVACION:</b>{{ $document->observation }}</td>
        </tr> --}}
        <tr>
            <td class="desc pt-3">
                <b>Vendedor</b>: {{ $document->user->name }} <br>
            </td>
        </tr>
        <tr>
            <td align="center" height="60"><b>Gracias por su Preferencia</b></td>
        </tr>
    </table>

</body>

</html>
