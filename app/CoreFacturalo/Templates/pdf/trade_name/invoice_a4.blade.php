@php
    $establishment = $document->establishment;
    $customer = $document->customer;
    $invoice = $document->invoice;
    $document_base = $document->note ? $document->note : null;
    
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $document_number = $document->series . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $accounts = \App\Models\Tenant\BankAccount::all();
    
    if ($document_base) {
        $affected_document_number = $document_base->affected_document ? $document_base->affected_document->series . '-' . str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT) : $document_base->data_affected_document->series . '-' . str_pad($document_base->data_affected_document->number, 8, '0', STR_PAD_LEFT);
    } else {
        $affected_document_number = null;
    }
    
    $payments = $document->payments;
    
    $total_payment = $document->payments->sum('payment');
    $balance = $document->total - $total_payment - $document->payments->sum('change');
    
@endphp
<html>

<head>
    {{-- <title>{{ $document_number }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
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
            <div class="border_round text-center" id="lateral">
                <table class="full-width text-center">
                    <tr>
                        <td height="20px">
                            <h3 class="text-center">{{ 'RUC ' . $company->number }}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td height="20px">
                            <h5 class="text-center"><b>{{ $document->document_type->description }}</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td height="20px">
                            <h3 class="text-center">{{ $document_number }}</h3>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="principal">
                <table class="full-width">
                    <tr>
                        @if ($stablishment->logo || $stablishment->document_logo)
                            <td width="40%" height="20px">
                                <div>
                                    @if ($stablishment->document_logo)
                                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                            alt="{{ $company->trade_name }}" class="company_logo"
                                            style="max-width: 230px;">
                                    @else
                                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                            alt="{{ $company->trade_name }}" class="company_logo"
                                            style="max-width: 230px;">
                                    @endif
                                </div>
                            </td>
                        @else
                            @if ($company->logo)
                                <td width="40%" height="20px">
                                    <div>
                                        @if ($company->document_logo)
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                style="max-width: 230px;">
                                        @else
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                style="max-width: 230px;">
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td width="40%" height="20px">
                                    {{-- <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px"> --}}
                                </td>
                            @endif
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
                                    {{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                                    {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                                    {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                                    {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                                </h5>
                                @isset($establishment->trade_address)
                                    <h5>{{ $establishment->trade_address !== '-' ? '  ' . $establishment->trade_address : '' }}
                                    </h5>
                                @endisset
                                <h5>{{ $establishment->telephone !== '-' ? 'Teléfono:' . $establishment->telephone : '' }}
                                </h5>
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

        <div class="bordes_datos_clientes  mt-3">
            <table class="full-width" border="0">
                <tr>
                    <td width="120px" height="20px"><b>FECHA DE EMISIÓN</b></td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->date_of_issue }}</td>
                    @if ($document->detraction)
                        <td width="120px" height="20px"><b>N. CTA DETRACCIONES</b></td>
                        <td width="8px" height="20px">:</td>
                        <td>{{ $document->detraction->bank_account }}</td>
                    @endif
                    <td width="120px" height="20px"><b>FORMA DE PAGO</b></td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ strtoupper($document->payment_condition->name) }}</td>
                </tr>


                @if ($document->detraction)
                    <td width="140px" height="20px"><b>B/S SUJETO A DETRACCIÓN</b></td>
                    <td width="8px" height="20px">:</td>
                    @inject('detractionType', 'App\Services\DetractionTypeService')
                    <td width="220px" height="20px">{{ $document->detraction->detraction_type_id }} -
                        {{ $detractionType->getDetractionTypeDescription($document->detraction->detraction_type_id) }}
                    </td>
                @endif
                <tr>
                    <td height="20px"><b>{{ $customer->identity_document_type->description }}</b></td>
                    <td height="20px">:</td>
                    <td height="20px">{{ $customer->number }}</td>
                    <td height="20px"><b>CLIENTE</b></td>
                    <td height="20px">:</td>
                    <td height="20px">{{ $customer->name }}</td>

                    @if ($document->detraction)
                        <td width="120px"><b>MÉTODO DE PAGO</b></td>
                        <td width="8px">:</td>
                        <td width="220px">
                            {{ $detractionType->getPaymentMethodTypeDescription($document->detraction->payment_method_id) }}
                        </td>
                    @endif

                </tr>

                @isset($customer->telephone)
                    <tr>
                        <td height="20px"><b>TELEFONO</b></td>
                        <td height="20px">:</td>
                        <td height="20px">{{ $customer->telephone }}</td>
                        <td height="20px"></td>
                        <td height="20px"></td>
                        <td height="20px"></td>

                    </tr>
                @endisset

                @if (@isset($student_name))
                    <tr>
                        <td height="20px"><b>ALUMNO</b></td>
                        <td height="20px">:</td>
                        <td height="20px">{{ $student_name }}</td>
                        <td height="20px"><b>CLASE</b></td>
                        <td height="20px">:</td>
                        <td height="20px">{{ $class ?? '' }}</td>

                    </tr>
                @endif

                <tr>


                    @if ($document->detraction)
                        <td width="120px" height="20px"><b>P. DETRACCIÓN</b></td>
                        <td width="8px" height="20px">:</td>
                        <td>{{ $document->detraction->percentage }}%</td>
                    @endif
                </tr>
                @if ($customer->address !== '')
                    <tr>
                        <td class="align-top" height="20px"><b>DIRECCIÓN:</b></td>
                        <td>:</td>
                        <td colspan="4">
                            {{ $customer->address }}
                            {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                            {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                            {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                        </td>
                        @if ($document->detraction)
                            <td width="120px" height="20px">MONTO DETRACCIÓN</td>
                            <td width="8px" height="20px">:</td>
                            <td>{{ $document->currency_type->symbol }} {{ $document->detraction->amount }}</td>
                        @endif
                    </tr>
                @endif

                @if ($document->detraction)
                    @if ($document->detraction->pay_constancy)
                        <tr>
                            <td colspan="3">
                            </td>
                            <td width="120px" height="20px">CONSTANCIA DE PAGO</td>
                            <td width="8px" height="20px">:</td>
                            <td>{{ $document->detraction->pay_constancy }}</td>
                        </tr>
                    @endif
                @endif
            </table>
        </div>


        @if ($document->guides)
            <br />
            {{-- <strong>Guías:</strong> --}}
            <table>
                @foreach ($document->guides as $guide)
                    <tr>
                        @if (isset($guide->document_type_description))
                            <td height="20px">{{ $guide->document_type_description }}</td>
                        @else
                            <td height="20px">{{ $guide->document_type_id }}</td>
                        @endif
                        <td height="20px">:</td>
                        <td height="20px">{{ $guide->number }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="mt-2">
            <strong>Observación:</strong>
            @foreach ($document->additional_information as $information)
                @if ($information)
                    @if ($loop->first)
                    @endif
                    {{ $information }}
                @endif
            @endforeach
            {{ trim($document->observation) }}
        </div>


        <table class="full-width mt-3">
            @if ($document->prepayments)
                @foreach ($document->prepayments as $p)
                    <tr>
                        <td width="120px" height="20px">ANTICIPO</td>
                        <td width="8px" height="20px">:</td>
                        <td>{{ $p->number }}</td>
                    </tr>
                @endforeach
            @endif
            @if ($document->purchase_order)
                <tr>
                    <td width="120px" height="20px">ORDEN DE COMPRA</td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->purchase_order }}</td>
                </tr>
            @endif
            @isset($document->quotation->sale_opportunity)
                <tr>
                    <td width="120px" height="20px">O. VENTA</td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->quotation->sale_opportunity->number_full }}</td>
                </tr>
            @endisset
            @if (!is_null($document_base))
                <tr>
                    <td width="120px" height="20px">DOC. AFECTADO</td>
                    <td width="8px" height="20px">:</td>
                    <td height="20px">{{ $affected_document_number }}</td>
                </tr>
                <tr>
                    <td height="20px">TIPO DE NOTA</td>
                    <td height="20px">:</td>
                    <td height="20px">
                        {{ $document_base->note_type === 'credit' ? $document_base->note_credit_type->description : $document_base->note_debit_type->description }}
                    </td>
                </tr>
                <tr>
                    <td height="20px" height="20px">DESCRIPCIÓN</td>
                    <td height="20px">:</td>
                    <td height="20px">{{ $document_base->note_description }}</td>
                </tr>
            @endif
        </table>

        {{-- <table class="full-width mt-3"> --}}
        {{-- <tr> --}}
        {{-- <td width="25%">Documento Afectado:</td> --}}
        {{-- <td width="20%">{{ $document_base->affected_document->series }}-{{ $document_base->affected_document->number }}</td> --}}
        {{-- <td width="15%">Tipo de nota:</td> --}}
        {{-- <td width="40%">{{ ($document_base->note_type === 'credit')?$document_base->note_credit_type->description:$document_base->note_debit_type->description}}</td> --}}
        {{-- </tr> --}}
        {{-- <tr> --}}
        {{-- <td class="align-top">Descripción:</td> --}}
        {{-- <td class="text-left" colspan="3">{{ $document_base->note_description }}</td> --}}
        {{-- </tr> --}}
        {{-- </table> --}}
        <div class="">
            <table border="0" class="full-width bordes_datos_clientes">
                <thead class="">
                    <tr class="bg-grey">
                        <th class="border-top-bottom text-center py-2 bordes  text-center" width="8%"
                            height="20px">CANT.</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center" width="8%"
                            height="20px">UNIDAD</th>
                        <th class="border-top-bottom text-left py-2 bordes" height="20px" height="20px">DESCRIPCIÓN
                        </th>
                        <!--

        <th class="border-top-bottom text-center py-2 bordes" width="8%"  height="20px">LOTE</th>
        <th class="border-top-bottom text-center py-2 bordes" width="8%"  height="20px">SERIE</th>
         -->

                        <th class="border-top-bottom py-2 bordes  text-center" width="12%" height="20px">P.UNIT
                        </th>
                        <th class="border-top-bottom py-2 bordes  text-center" width="8%" height="20px">DTO.
                        </th>
                        <th class="border-top-bottom py-2 bordes  text-center" width="12%" height="20px">TOTAL
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($document->items as $row)
                        <tr>
                            <td class="text-center align-top bordes">
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
                            <td class="text-center align-top bordes" height="20px">{{ $row->item->unit_type_id }}
                            </td>
                            <td class="text-left align-top bordes" height="20px">


                                @if (isset($row->name_product_pdf))
                                    {{ $row->name_product_pdf }}
                                @else
                                    @if (isset($row->item->description_internet))
                                        {{ $row->item->description_internet }}
                                    @else
                                        {{ $row->item->description }}
                                    @endif
                                    @if (isset($row->item->has_unit_type))
                                        - {!! $row->item->has_unit_type !!}
                                    @endif
                                    @if (isset($row->item->lots))
                                        @foreach ($row->item->lots as $lot)
                                            <br />{!! $lot->series !!}
                                        @endforeach
                                    @endif

                                    @if (isset($row->item->second_name))
                                        - {!! $row->item->second_name !!}
                                    @endif
                                    @if (isset($row->unit_desc))
                                        {!! $row->unit_desc !!}
                                    @endif
                                @endif

                                @if (!empty($row->item->presentation))
                                    {{-- $row->item->presentation->description --}}
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

                                {{-- @if ($row->item->is_set == 1)
                                    <br>
                                    @inject('itemSet', 'App\Services\ItemSetService')
                                    {{ join('-', $itemSet->getItemsSet($row->item_id)) }}
                                @endif --}}
                            </td>
                            <!--
            <td class="text-center align-top bordes"  height="20px">
                @inject('itemLotGroup', 'App\Services\ItemLotsGroupService')
                {{ $itemLotGroup->getLote($row->item->IdLoteSelected) }}

            </td>
            <td class="text-center align-top bordes"  height="20px">

                @isset($row->item->lots)
    @foreach ($row->item->lots as $lot)
    @if (isset($lot->has_sale) && $lot->has_sale)
    <span style="font-size: 9px">{{ $lot->series }}</span><br>
    @endif
    @endforeach
@endisset

            </td>
             -->
                            <td class="text-center align-top bordes" height="20px">

                                @if (isset($row->price_unit))
                                    {{ number_format($row->price_unit, 2) }}
                                @else
                                    {{ number_format($row->unit_price, 2) }}
                                @endif

                            </td>
                            <td class="text-center align-top bordes" height="20px">
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
                            <td class="text-center align-top bordes" height="20px">
                                {{ number_format($row->total, 2) }}</td>
                        </tr>
                    @endforeach



                    @if ($document->prepayments)
                        @foreach ($document->prepayments as $p)
                            <tr>
                                <td class="text-center align-top" height="20px">
                                    1
                                </td>
                                <td class="text-center align-top" height="20px">NIU</td>
                                <td class="text-left align-top" height="20px">
                                    ANTICIPO: {{ $p->document_type_id == '02' ? 'FACTURA' : 'BOLETA' }} NRO.
                                    {{ $p->number }}
                                </td>
                                <td class="text-right align-top" height="20px">-{{ number_format($p->total, 2) }}
                                </td>
                                <td class="text-right align-top" height="20px">
                                    0
                                </td>
                                <td class="text-right align-top" height="20px">-{{ number_format($p->total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="border-bottom" height="20px"></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <table class="full-width">
            <tr>
                <td colspan="2" height="5px"></td>
            </tr>
            <tr>
                <td colspan="2" class="full-width border_round">
                    @foreach (array_reverse((array) $document->legends) as $row)
                        @if ($row->code == '1000')
                            Son: <span class="font-bold">{{ $row->value }}
                                {{ $document->currency_type->description }}</span>
                            @if (count((array) $document->legends) > 1)
                                <p><span class="font-bold">Leyendas</span></p>
                            @endif
                        @else
                            <p> {{ $row->code }}: {{ $row->value }} </p>
                        @endif
                    @endforeach
                    <br />
                    @if ($document->detraction)
                        <p>
                            <span class="font-bold">
                                Operación sujeta al Sistema de Pago de Obligaciones Tributarias
                            </span>
                        </p>
                        <br />
                    @endif
                    @if ($customer->department_id == 16)
                        <br /><br /><br />
                        <div>
                            <center>
                                Representación impresa del Comprobante de Pago Electrónico.
                                <br />Esta puede ser consultada en:
                                <br /><b>{!! url('/buscar') !!}</b>
                                <br /> "Bienes transferidos en la Amazonía
                                <br />para ser consumidos en la misma".
                            </center>
                        </div>
                        <br />
                    @endif

                    <br>
                    @if (in_array($document->document_type->id, ['01', '03']))
                        @foreach ($accounts as $account)
                            <p><span class="font-bold">{{ $account->bank->description }}</span>
                                {{ $account->currency_type->description }} {{ $account->number }}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <img src="data:image/png;base64, {{ $document->qr }}" style="margin-right: -10px;" />
                    <p style="font-size: 9px">Código Hash: {{ $document->hash }}</p>
                </td>
                <td width="50%" valign="top">
                    <div class="bordes_datos_clientes ">
                        <table class="full-width bordes_impuesto">
                            @if ($document->total_exportation > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">OP. EXPORTACIÓN:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_exportation, 2) }}</td>
                                </tr>
                            @endif
                            @if ($document->total_free > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">OP. GRATUITAS:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_free, 2) }}</td>
                                </tr>
                            @endif
                            @if ($document->total_unaffected > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">OP. INAFECTAS:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_unaffected, 2) }}</td>
                                </tr>
                            @endif
                            @if ($document->total_exonerated > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">OP. EXONERADAS:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_exonerated, 2) }}</td>
                                </tr>
                            @endif
                            @if ($document->total_taxed > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">OP. GRAVADAS:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_taxed, 2) }}</td>
                                </tr>
                            @endif
                            @if ($document->total_discount > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">
                                        {{ $document->total_prepayment > 0 ? 'ANTICIPO' : 'DESCUENTO TOTAL' }}:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_discount, 2) }}</td>
                                </tr>
                            @endif

                            {{-- @if ($document->total_charge > 0)
            @if ($document->charges)
            @php
            $total_factor = 0;
            foreach($document->charges as $charge) {
            $total_factor = ($total_factor + $charge->factor) * 100;
            }
            @endphp
            <tr>
                <td colspan="7" class="text-right font-bold">CARGOS ({{$total_factor}}
                    %): {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_charge, 2) }}</td>
            </tr>
            @else
            <tr>
                <td colspan="7" class="text-right font-bold">CARGOS: {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_charge, 2) }}</td>
            </tr>
            @endif
            @endif --}}
                            @if ($document->total_plastic_bag_taxes > 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">ICBPER:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total_plastic_bag_taxes, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="7" class="text-right font-bold border_detalles">IGV:
                                    {{ $document->currency_type->symbol }}</td>
                                <td class="text-right font-bold border_detalles">
                                    {{ number_format($document->total_igv, 2) }}</td>
                            </tr>

                            @if ($document->perception)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles"> IMPORTE TOTAL:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">PERCEPCIÓN:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->perception->amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">TOTAL A PAGAR:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total + $document->perception->amount, 2) }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">TOTAL A VENTA:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format($document->total, 2) }}</td>
                                </tr>
                                @if ($document->total_rounded > 0)
                                    <tr>
                                        <td colspan="7" class="text-right font-bold border_detalles">REDONDEO:
                                            {{ $document->currency_type->symbol }}</td>
                                        <td class="text-right font-bold border_detalles">
                                            {{ number_format($document->total_rounded, 2) }}</td>
                                    </tr>
                                @endif
                                @if ($document->total_payment > 0)
                                    <tr>
                                        <td colspan="7" class="text-right font-bold border_detalles">TOTAL A PAGAR:
                                            {{ $document->currency_type->symbol }}</td>
                                        <td class="text-right font-bold border_detalles">
                                            {{ number_format($document->total_payment, 2) }}</td>
                                    </tr>
                                @endif
                            @endif

                            @if ($balance < 0)
                                <tr>
                                    <td colspan="7" class="text-right font-bold border_detalles">VUELTO:
                                        {{ $document->currency_type->symbol }}</td>
                                    <td class="text-right font-bold border_detalles">
                                        {{ number_format(abs($balance), 2, '.', '') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </td>
            <tr>
                {{-- <tr>
                <td colspan="7" height="18px"><b>OBSERVACION: </b>{{ trim($document->observation) }}
                    @isset($document->additional_information)
                    @foreach ($document->additional_information as $information)
                        @if ($information)
                            {{ $information }}<br />
                        @endif
                    @endforeach
                @endisset
                </td>
            </tr> --}}
        </table>



        @if ($payments->count())


            <table class="full-width">
                <tr>
                    <td>
                        <strong>PAGOS:</strong>
                    </td>
                </tr>
                @php
                    $payment = 0;
                @endphp
                @foreach ($payments as $row)
                    <tr>
                        <td>&#8226; {{ $row->payment_method_type->description }} -
                            {{ $row->reference ? $row->reference . ' - ' : '' }}
                            {{ $document->currency_type->symbol }}
                            {{ $document->total_payment + $row->change }}</td>
                    </tr>
                @endforeach
                </tr>

            </table>
        @endif

        @if ($document->user)
            <br>
            <table class="full-width">
                <tr>
                    <td>
                        <strong>Vendedor:</strong> &ensp;&ensp;{{ $document->user->name }}
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
        @endif
</body>

</html>
