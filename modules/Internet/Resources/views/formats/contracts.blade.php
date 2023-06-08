<html>

<head>
    <style>
        p {
            padding: 0px;
            margin: 2px;
        }

        body {
            font-size: 12.5px;
        }

        .center {
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }

        .bold {
            font-weight: bold;
        }

        .border {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: 1px solid black;
        }

        .v-top {
            vertical-align: top;
        }

        .no-border {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .no-spacing {
            margin: 0;
            padding: 0;
        }

        .small {
            font-size: 10px;
        }

        h1 {
            font-size: 18px;
        }

        .bg-gray {
            background-color: #aeaeae;
        }
    </style>
</head>


<body>
    <table class="w-100 border" style="height:70px">
        <tbody>
            <tr>
                <td class="center" width="25%">
                    @if ($company->logo)
                        <div>
                            @if ($company->document_logo)
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo"
                                    style="height:auto; max-width: 110px;">
                            @else
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo"
                                    style="height:auto; max-width: 110px;">
                            @endif
                        </div>
                    @endif
                </td>
                <td class="center bold" width="50%">

                    <h2>CONTRATO DE PRESTACION DE SERVICIOS DE INTERNET</h2>
                </td>
                <td class="v-top" width="25%" style="margin:0;padding:0">
                    <table style="margin: auto;border-collapse:collapse;border-spacing: 0;" class="w-100">
                        <tbody>
                            @php
                                use Carbon\Carbon;
                            @endphp
                            <tr>
                                <td>FECHA: {{ Carbon::now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>TEC:
                                    @php
                                        $tech = '-';
                                        if ($register->tech) {
                                            $tech = $register->tech->person->name;
                                        }
                                    @endphp
                                    {{ $tech }}

                                </td>
                            </tr>
                            <tr>
                                <td>PLAN: {{ $plan->capacity }}</td>
                            </tr>
                            <tr>
                                <td class="no-border">ID: {{ $register->identifier }}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="w-100">

        <tbody>
            <tr>
                <td class="v-top text-center">
                    CONTRATO N°<br>
                    <h1 class="bold no-spacing">{{ $register->identifier }}</h1>
                </td>
                <td class="v-top text-center">
                    FECHA DE INSTALACION: <br>
                    @php
                        
                        $date = Carbon::parse($register->date)->format('d/m/Y');
                    @endphp
                    <h1 class="bold no-spacing">{{ $date }}</h1>
                </td>
                <td class="v-top text-center">
                    FECHA DE INICIO: <br>
                    @php
                        
                        $date = Carbon::parse($register->pay_date ?? $register->date)->format('d/m/Y');
                    @endphp
                    <h1 class="bold no-spacing">{{ $date }}</h1>
                </td>
                <td class="v-top text-center">
                    FECHA DE TERMINO: <br>
                    @php
                        $end_date = $register->end_date ? Carbon::parse($register->end_date)->format('d/m/Y') : '-';
                    @endphp
                    <h1 class="bold no-spacing">{{ $end_date }}</h1>
                </td>
                <td class="v-top text-center">
                    MENSUALIDAD: <br>
                    <h1 class="bold no-spacing">S/ {{ $total }}</h1>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="w-100">
        <tbody>
            <tr>
                <td class="center bg-gray bold" colspan="2">
                    <h1 class="no-spacing" style="padding: 3px;">INFORMACION DEL CONTRATO</h1>
                </td>
            </tr>
            <tr>
                <td>
                    NOMBRES:
                </td>
                <td>
                    {{ $register->person->name }}
                </td>
            </tr>
            <tr>
                @php
                    $length = strlen($register->person->number);
                    $doc = $length == 8 ? 'DNI' : ($length == 11 ? 'RUC' : 'CPP');
                @endphp
                <td>{{ $doc }}:</td>
                <td>{{ $register->person->number }}</td>
            </tr>
            <tr>
                <td>CELULAR:</td>
                <td>{{ $register->person->telephone }}</td>
            </tr>
            <tr>
                <td>DIRECCION:</td>
                <td>{{ $register->installation_address }}</td>
            </tr>
            <tr>
                <td>REFERENCIA:</td>
                <td>
                    {{ $register->reference_installation_address }}
                </td>
            </tr>
            <tr>
                <td>N° DE SUMINISTRO ELECTRICO:</td>
                <td>{{ $register->supplie ?? '-' }}</td>
            </tr>
            <tr>
                <td>TIPO DE INSTALACION:</td>
                <td>{{ mb_strtoupper($register->type) }}

                </td>
            </tr>
            <tr>
                <td>MAC:</td>
                <td>
                    {{ $register->mac ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>ZONA:</td>
                <td>
                    {{ $register->person->zone ? $register->person->zone->description : '-' }}
                </td>
            </tr>
            <tr>
                <td>EQUIPOS:</td>
                @php
                    $item_by_row = array_chunk($items, 2);
                @endphp
                <td>
                    <table class="w-100">
                        @foreach ($item_by_row as $row)
                            <tr>
                                @foreach ($row as $item)
                                    <td class="no-border v-top">{{ $item['description'] }} ({{ $item['quantity'] }})
                                        @if ($item['series'])
                                            <br>
                                            @foreach ($item['series'] as $serie)
                                                <span class="small">{{ $serie['series'] }}</span> <br>
                                            @endforeach
                                        @endif

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>

                </td>
            </tr>
        </tbody>
    </table>
    <p>
        1- La empresa {{ $company->name }} de internet que en adelante se denominara LA EMPRESA, para la prestación de
        servicios
        de
        internet, condiciona al CLIENTE, tenga a su disposición los equipos terminales y software debidamente
        configurado y
        ademar del servicio técnico para que se establezca la conexión a la red de internet.
    </p>
    <p>
        2- LA EMPRESA entrega al CLIENTE en calidad de PRESTAMO, los equipos que se describen líneas arriba, en buenas
        condiciones y estado optimo.
    </p>
    <p>
        3- EL CLIENTE una vez recibido los equipos a satisfacción, se obliga a la responsabilidad y cuidado de los
        equipos
        descritos haciéndose cargo de cualquier cobro que se realice por la afectación de los mismo y requieran el
        servicio
        del técnico.
    </p>
    <p>
        4- LA EMPRESA, no se hace responsable por los daños que se ocasionen, por el cliente al manipular los equipos o
        las
        configuraciones que {{ $company->name }}, establecida al realizar la instalación en el domicilio de EL CLIENTE
        para
        brindar
        el servicio de internet.
    </p>
    <p>
        5- EL CLIENTE, al adquirir el servicio estará dentro de la modalidad de PREPAGO, por ende, se le hará cobro
        respectivo del servicio al término de la instalación, siendo de ese modo su pago en la misma fecha del día en
        que se
        adquirió el servicio.
    </p>
    <p>
        6- En caso de que el cliente no haga los pagos establecidos dentro del plazo de (24 HORAS) al vencimiento de la
        fecha pago y haga caso omiso a los intentos de cobro por parte de LA EMPRESA, se procederá a hacer el corte del
        servicio inmediatamente salvo previa petición por parte del cliente a la empresa para prorrogar su plazo de pago
        no
        mayor de (15) días calendarios.
    </p>
    <p>
        7- En caso de ser necesario el traslado de equipos por parte de EL CLIENTE, este deberá informar a la EMPRESA,
        de
        dicho traslado con la finalidad de coordinar los tramites y pagos correspondientes para dicho acto.
        8- Terminado el contrato de prestación por cualquier motivo, AL CLIENTE se le obliga a restituir a la EMPRESA
        los
        equipos arrendados en un plazo no mayor de (03) tres días hábiles en las mismas condiciones de uso en que le
        fueron
        entregadas.
    </p>
    <p>
        9- En caso de no entregar los equipos en el tiempo y condiciones establecidas, salvo deterioro ordinario del
        mismo
        LA EMPRESA facturara al CLIENTE el importe total de los equipos.
    </p>
    <p>
        10- Las averías en los equipos serán reparadas por LA EMPRESA, a solicitud del CLIENTE. LA EMPRESA, facturará al
        CLIENTE, el valor de las reparaciones de los equipos, salvo cuando el daño venga por defecto de fabrica en las
        cuales la empresa se hará cargo y por lo tanto serán reemplazadas por fallas o defectos imputables a la misma.
    </p>
    <p>
        11- En caso de daño irreparable del equipo que no provenga de defectos de fabricación, causa natural como
        cambios
        climático, u otros, de deterioro no imputable a estos factores, sea hurto o se haya extraviado el equipo, EL
        CLIENTE
        pagará a LA EMPRESA el valor de reposición vigente del equipo a la fecha del cobro, de conformidad con la
        certificación que el respecto expida del área contable de LA EMPRESA, por escrito dentro del término de 8 días
        de la
        ocurrencia de cualquiera de los eventos mencionados, a falta de lo cual no podrá exonerarse de su
        responsabilidad.
    </p>
    <p>
        12- Los equipos serán instalados, trasladados o retirados por el personal autorizado por LA EMPRESA.
    </p>
    <p>
        13- LA EMPRESA se reserva la facultad de cambiar la plataforma tecnológica del sistema caso en el cual procederá
        a
        sustituir los equipos entregados en arrendamiento.
    </p>
    <p>
        14- LA EMPRESA atenderá los reportes de daños, a través de nuestra línea de WhatsApp 915026860 – 964494025, y
        realizar el mantenimiento en el menor tiempo posible.
    </p>
    <p>
        15- Los derechos y obligaciones establecidos en el contrato de prestación de servicios de internet se aplicarán
        al
        presente desde el momento de la instalación.
    </p>
    <p>
        16- En señal de aceptación y constancia de entrega de los equipos, se firman por ambas partes al final de este
        contrato en la parte de las firmas.
    </p>

    <table class="w-100" style="margin-top: 25px;">
        <tr>
            <td class="v-top no-border  text-center">
                <div class="text-center" style="margin:auto; width:80%;border-top: 1px black solid !important;">
                    FIRMAR DEL CLIENTE <br>
                    {{ $register->person->name }}<br>
                    @php
                        $length = strlen($register->person->number);
                        $doc = $length == 8 ? 'DNI' : ($length == 11 ? 'RUC' : 'CPP');
                    @endphp
                    {{ $doc }}: {{ $register->person->number }}
                </div>

            </td>
            <td class="v-top no-border text-center">
                <div class="text-center" style="margin:auto; width:80%;border-top: 1px black solid !important;">
                    FIRMAR DE LA EMPRESA <br>
                    {{ $company->name }}<br>
                    RUC: {{ $company->number }}
                </div>

            </td>
        </tr>
    </table>

</body>

</html>
