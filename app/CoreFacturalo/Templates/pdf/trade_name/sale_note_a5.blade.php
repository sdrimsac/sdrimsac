@php
        $configuration = \App\Models\Tenant\Configuration::first();
    $company = \App\Models\Tenant\Company::first();
    $establishment = $document->establishment;
    $customer = $document->customer;
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $left = $document->series ? $document->series : $document->prefix;
    $tittle = $left . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $payments = $document->payments;
    
@endphp
<html>

<head>
    {{-- <title>{{ $tittle }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
    <style>
    </style>
</head>

<body>
    @if ($document->state_type->id == '11')
        <div class="company_logo_box" style="position: absolute; text-align: center; top:30%;">
            <img src="data:{{ mime_content_type(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png')) }};base64, {{ base64_encode(file_get_contents(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png'))) }}"
                alt="anulado" class="" style="opacity: 0.6;">
        </div>
    @endif
    <div>


        <div id="contenedor" class="clearfix">
            <div class="border_round text-center" id="lateral_sales">
                <table class="full-width text-center">
                    <tr>
                        <td height="20px">

                            <h5>{{ 'RUC ' . $company->number }}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td height="20px">
                            <h5 class="text-center"><b>NOTA DE VENTA</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td height="20px">

                            <h4 class="text-center">{{ $tittle }}</h4>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="principal">
                <table>
                    <tr>
                        @if ($company->logo)
                            <td width="40%" height="20px">
                                <div>
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                        alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 180px;">
                                </div>
                            </td>
                        @else
                            <td width="40%" height="20px">
                                {{-- <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px"> --}}
                            </td>
                        @endif
                        <td width="60%" class="align-top" height="20px">
                            <div class="text-left">
                                <h4 class=""><b>{{ $company->trade_name }}</b></h4>
                                <h6>{{ $company->eslogan }}</h6>
                                @isset($establishment->aditional_information)
                                    <h5><b>{{ $establishment->aditional_information !== '-' ? $establishment->aditional_information : '' }}</b>
                                    </h5>
                                @endisset
                                <h5>
                                    {{ $establishment->address !== '-' ? $establishment->address : '' }}
                                    {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                                    {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                                    {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                                </h5>

                                @isset($establishment->trade_address)
                                    <h5>{{ $establishment->trade_address !== '-' ? '  ' . $establishment->trade_address : '' }}
                                    </h5>
                                @endisset

                                <h6>{{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}</h5>

                                    <h5>{{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }}
                                    </h5>

                                    @isset($establishment->web_address)
                                        <h5>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                                        </h5>
                                    @endisset


                            </div>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
        @if ($company->a5_image && $configuration->show_image_a5)
        @php
            $image = $company->a5_image;
        @endphp
            <div class="w-100 text-center">
                <img src="data:{{mime_content_type(public_path("storage/uploads/logos/{$image}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/uploads/logos/{$image}")))}}" alt="{{$company->image}}"  style="max-height: 250px;">
            </div>
        @endif
        <div class="bordes_datos_clientes  mt-3">
            <table class="full-width">


                <tr>
                    <td height="20px" style="font-size:12px;"><b>CLIENTE</b></td>
                    <td height="20px">:</td>
                    <td colspan="4" height="20px" style="font-size:12px;">{{ $customer->name }}</td>
                </tr>
                <tr>
                    <td width="120px" height="20px" style="font-size:12px;"><b>FECHA EMISIÓN</b></td>
                    <td width="8px" height="20px">:</td>
                    <td style="font-size:12px;">{{ $document->date_of_issue->format('d-m-Y') }}</td>
                    <td height="18px" style="font-size:12px;"><b>TELEFONO</b></td>
                    <td height="20px">:</td>
                    <td style="font-size:12px;">{{ $customer->telephone }}</td>
                </tr>

                <tr>
                    <td height="20px" style="font-size:12px;">
                        <b>{{ $customer->identity_document_type->description }}</b></td>
                    <td height="20px">:</td>
                    <td colspan="4" height="20px" style="font-size:12px;">{{ $customer->number }}</td>


                </tr>
                @if ($customer->address !== '')
                    <tr>
                        <td class="align-top" height="20px" style="font-size:12px;"><b>DIRECCIÓN:</b></td>
                        <td>:</td>
                        <td colspan="4" style="font-size:12px;">
                            {{ $customer->address }}
                            {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                            {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                            {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                        </td>


                    </tr>
                @endif
                @if ($document->paid == 1)
                    <tr>
                        <td height="18px" style="font-size:12px;padding:0px;"><b>ESTADO</b></td>
                        <td>:</td>
                        <td colspan="4" style="font-size:12px;padding:0px;">CANCELADO</td>
                    </tr>
                @else
                    <tr>
                        <td height="18px" style="font-size:12px;padding:0px;"><b>ESTADO</b></td>
                        <td>:</td>
                        <td colspan="4" style="font-size:12px;padding:0px;">PENDIENTE DE PAGO</td>
                    </tr>
                @endif
                <tr>
                    <td height="18px" style="font-size:12px;padding:0px;"><b>OBSERVACION:</b></td>
                    <td>:</td>
                    <td colspan="4" style="font-size:12px;padding:0px;">{{ $document->observation }}</td>
                </tr>
            </table>
        </div>

        @if ($document->guides)
            <br />
            {{-- <strong>Guías:</strong> --}}
            <table>
                @foreach ($document->guides as $guide)
                    <tr>
                        @if (isset($guide->document_type_description))
                            <td>{{ $guide->document_type_description }}</td>
                        @else
                            <td>{{ $guide->document_type_id }}</td>
                        @endif
                        <td>:</td>
                        <td>{{ $guide->number }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        <table class="full-width mt-10 mb-10">
            <thead class="">
                <tr class="bg-grey">
                    <th class="border-top-bottom text-center py-2" width="8%">CANT.</th>
                    <th class="border-top-bottom text-center py-2" width="8%">UNIDAD</th>
                    <th class="border-top-bottom text-left py-2">DESCRIPCIÓN</th>
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
                                {{ number_format($row->quantity, 0) }}
                            @endif
                        </td>
                        <td class="text-center align-top">{{ $row->item->unit_type_id }}</td>
                        <td class="text-left">
                            {!! $row->item->description !!} @if (!empty($row->item->presentation))
                                {!! $row->item->presentation->description !!}
                            @endif
                            @if ($row->attributes)
                                @foreach ($row->attributes as $attr)
                                    <br /><span style="font-size: 9px">{!! $attr->description !!} :
                                        {{ $attr->value }}</span>
                                @endforeach
                            @endif
                            @if ($row->discounts)
                                @foreach ($row->discounts as $dtos)
                                    <br /><span style="font-size: 9px">{{ $dtos->factor * 100 }}%
                                        {{ $dtos->description }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-right align-top">{{ number_format($row->unit_price, 2) }}</td>
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
                        <td colspan="6" class="border-bottom"></td>
                    </tr>
                @endforeach
                @if ($document->total_exportation > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">OP. EXPORTACIÓN:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_exportation, 2) }}</td>
                    </tr>
                @endif
                @if ($document->total_free > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">OP. GRATUITAS:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_free, 2) }}</td>
                    </tr>
                @endif
                @if ($document->total_unaffected > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">OP. INAFECTAS:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_unaffected, 2) }}</td>
                    </tr>
                @endif
                @if ($document->total_exonerated > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">OP. EXONERADAS:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_exonerated, 2) }}</td>
                    </tr>
                @endif
                @if ($document->total_taxed > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">OP. GRAVADAS:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_taxed, 2) }}</td>
                    </tr>
                @endif
                @if ($document->total_discount > 0)
                    <tr>
                        <td colspan="5" class="text-right font-bold">
                            {{ $document->total_prepayment > 0 ? 'ANTICIPO' : 'DESCUENTO TOTAL' }}:
                            {{ $document->currency_type->symbol }}</td>
                        <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="5" class="text-right font-bold">IGV: {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total_igv, 2) }}</td>
                </tr>

                <tr>
                    <td colspan="5" class="text-right font-bold">TOTAL VENTA:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right font-bold border_detalles">REDONDEO:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold border_detalles">{{ number_format($document->total_rounded, 2) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right font-bold border_detalles">TOTAL A PAGAR:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold border_detalles">{{ number_format($document->total_payment, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="full-width">
            <tr>
                <td>
                    <strong>PAGOS:</strong>
                </td>
            </tr>
            @php
                $payment = 0;
            @endphp
            {{-- @foreach ($payments as $row)
        <tr><td>- {{ $row->date_of_payment->format('d/m/Y') }} - {{ $row->payment_method_type->description }} - {{ $row->reference ? $row->reference.' - ':'' }} {{ $document->currency_type->symbol }} {{ $document->total_payment }}</td></tr>
        @php
            $payment += (float) $row->payment;
        @endphp
    @endforeach --}}
            <tr>
                <td><strong>SALDO:</strong> {{ $document->currency_type->symbol }}
                    {{ number_format($document->total - $payment, 2) }}</td>
            </tr>

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
