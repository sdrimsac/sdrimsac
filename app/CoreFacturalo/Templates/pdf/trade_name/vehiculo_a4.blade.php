@php
    $establishment = $document->establishment;
    $customer = $document->vehiculo ? $document->vehiculo->customer : null;
    $services = $document->services ?? collect([]);
    $items = $document->items ?? collect([]);
    $tittle = str_pad($document->id, 8, '0', STR_PAD_LEFT);
@endphp
<html>

<head>
</head>

<body>
    <table class="full-width">
        <tr>
            @if ($company->logo)
                <td width="20%">
                    <div class="company_logo_box">
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->name }}" class="company_logo" style="max-width: 150px;">
                    </div>
                </td>
            @else
                <td width="20%">
                </td>
            @endif
            <td width="50%" class="pl-3">
                <div class="text-left">
                    <h4 class="">{{ $company->name }}</h4>
                    <h5>{{ 'RUC ' . $company->number }}</h5>
                    <h6 style="text-transform: uppercase;">
                        {{ $establishment->address !== '-' ? $establishment->address : '' }}
                        {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                        {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                        {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                    </h6>

                    @isset($establishment->trade_address)
                        <h6>{{ $establishment->trade_address !== '-' ? 'D. Comercial: ' . $establishment->trade_address : '' }}
                        </h6>
                    @endisset
                    <h6>{{ $establishment->telephone !== '-' ? 'Central telefónica: ' . $establishment->telephone : '' }}
                    </h6>

                    <h6>{{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }}</h6>

                    @isset($establishment->web_address)
                        <h6>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}</h6>
                    @endisset

                    @isset($establishment->aditional_information)
                        <h6>{{ $establishment->aditional_information !== '-' ? $establishment->aditional_information : '' }}
                        </h6>
                    @endisset
                </div>
            </td>
            <td width="30%" class="border-box py-4 px-2 text-center">
                <h5 class="text-center">{{ 'SERVICIO TÉCNICO' }}</h5>
                <h3 class="text-center">{{ $tittle }}</h3>
            </td>
        </tr>
    </table>
    <table class="full-width mt-5">
        <tr>
            <td width="15%">Cliente:</td>
            <td width="45%">{{ $customer ? $customer->name : '' }}</td>
            <td width="25%">Fecha de emisión:</td>
            <td width="15%">{{ $document->created_at->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>{{ $customer ? $customer->identity_document_type->description : '' }}:</td>
            <td>{{ $customer ? $customer->number : '' }}</td>

        </tr>
        @if ($customer && $customer->address !== '')
            <tr>
                <td class="align-top">Dirección:</td>
                <td colspan="">
                    {{ $customer->address }}
                    {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                    {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                    {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                </td>
            </tr>
        @endif
        <tr>
            <td class="align-top">Celular:</td>
            <td colspan="3">
                {{ $document->cellphone }}
            </td>
        </tr>
    </table>
    <table class="full-width mt-2">
        <tr>
            <td> <input {{ $document->reparacion ? 'checked="checked"' : '' }} class="tech-chk" type="checkbox">
                Reparación
            </td>
            <td> <input {{ $document->mantenimiento ? 'checked="checked"' : '' }} class="tech-chk" type="checkbox">
                Mantenimiento </td>
            <td> <input {{ $document->garantia ? 'checked="checked"' : '' }} class="tech-chk" type="checkbox"> Garantía
            </td>
            <td> <input {{ $document->diagnostico ? 'checked="checked"' : '' }} class="tech-chk" type="checkbox">
                Diagnostico </td>
        </tr>
    </table>

    <table class="full-width mt-3">
        <tr>
            <td><b>Descripción:</b></td>
        </tr>
        <tr>
            <td>{{ $document->observacion }}</td>
        </tr>
        <tr>
            <td><b>Actividades realizadas:</b> {{ $document->motive }} </td>
        </tr>
        <tr>
            <td><b>Marca:</b> {{ $document->vehiculo->marca }} </td>
        </tr>
        <tr>
            <td><b>Placa:</b> {{ $document->vehiculo->placa }} </td>
        </tr>
        <tr>
            <td><b>Modelo:</b> {{ $document->vehiculo->modelo }} </td>
        </tr>
        <tr>
            <td style="padding-top: 7px;">

            </td>
        </tr>
    </table>
    <table class="full-width mt-10 mb-10">
        <thead class="">
            <tr class="bg-grey">
                <th class="border-top-bottom text-center py-2" width="20%">CANT.</th>
                <th class="border-top-bottom text-center py-2">DESCRIPCIÓN</th>
                <th class="border-top-bottom text-right py-2" width="25%">P.UNIT</th>
                <th class="border-top-bottom text-right py-2" width="20%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $serviceQuantities = [];

                $services = $services ?? collect([]);
                $items = $items ?? collect([]);

                foreach ($services as $s) {
                    if (isset($serviceQuantities[$s->name])) {
                        $serviceQuantities[$s->name]++;
                    } else {
                        $serviceQuantities[$s->name] = 1;
                    }
                }
            @endphp
            @if ($services->count() > 0)
                @foreach ($services as $service)
                    <tr>
                        <td class="text-center align-top">
                            {{ $serviceQuantities[$service->name] }}
                        </td>
                        <td class="text-center align-top">{{ $service->name }}</td>
                        <td class="text-right align-top">{{ number_format($service->price_unit, 2) }}</td>
                        <td class="text-right align-top">
                            {{ number_format($service->price_unit * $serviceQuantities[$service->name], 2) }}</td>
                    </tr>
                    @php
                        $total += $service->price_unit * $serviceQuantities[$service->name];
                    @endphp
                @endforeach
            @endif

            @if ($items->count() > 0)
                @foreach ($items as $item)
                    <tr>
                        <td class="text-center align-top">{{ number_format($item['quantity'], 2) }}</td>
                        <td class="text-center align-top">{{ $item['description'] }}</td>
                        <td class="text-right align-top">{{ number_format($item['sale_unit_price'], 2) }}</td>
                        <td class="text-right align-top">
                            {{ number_format($item['sale_unit_price'] * $item['quantity'], 2) }}
                        </td>
                    </tr>
                    @php
                        $total += floatval($item['sale_unit_price']) * floatval($item['quantity']);
                    @endphp
                @endforeach
            @endif

            @if ($services->count() === 0 && $items->count() === 0)
                <tr>
                    <td colspan="4" class="text-center">No hay servicios o items registrados</td>
                </tr>
            @endif
            <tr>
                <td colspan="7" class="border-bottom"></td>
            </tr>
        </tbody>
    </table>

    <table class="full-width">
        <tr>
            <td colspan="4" class="text-left font-bold mb-3">TOTAL DEL SERVICIO: </td>
            <td class="text-right font-bold">
                @php
                    $total = 0;
                    foreach ($services as $service) {
                        $total += $service->price_unit;
                    }
                @endphp
                {{ number_format($total, 2) }}
            </td>
        </tr>
    </table>
</body>

</html>
