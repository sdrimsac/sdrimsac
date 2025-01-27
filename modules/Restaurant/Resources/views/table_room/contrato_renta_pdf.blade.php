<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Arrendamiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            line-height: 1.4;
            font-size: 14px; /* Tamaño base del documento */
        }

        h2 {
            font-size: 16px; /* Tamaño para títulos principales */
        }

        h3 {
            font-size: 13px; /* Tamaño para subtítulos */
            margin: 10px 0 5px 0;
        }

        p {
            margin: 5px 0;
            font-size: 13px; /* Tamaño para párrafos */
        }

        ul li {
            font-size: 13px; /* Tamaño para items de lista */
        }

        .center {
            text-align: center;
        }

        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature div {
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $data = [
            'hotel_rent_item' => $hotel_rent_item ?? null,
            'hotel_rent' => $hotel_rent ?? null,
            'table' => $table ?? null,
            'company' => $company ?? null,
        ];

        $customer = $hotel_rent['customer'] ?? null;
    @endphp

    <div style="display: flex; align-items: center; margin: 0 0 0 0; padding: 0;">
        @php
            $personImage = $customer && isset($customer['image']) ? storage_path('app/public/uploads/persons/' . $customer['image']) : null;
            $imageUrl = file_exists($personImage ?? '') ? asset('storage/uploads/persons/' . $customer['image']) : asset('status_images/user.png');
        @endphp
        
        <img src="{{ $imageUrl }}" alt="Foto tamaño carné"
            style="width: 100px; height: 120px; margin: 0 10px 0 0; border: 1px solid #000;">
        <h2 class="center" style="margin: 0;">CONTRATO DE ARRENDAMIENTO</h2>
    </div>
    <p style="margin-top: -20px;">Conste por el presente documento, el contrato de arrendamiento que celebran, de una
        parte <strong>Sr. {{ $company->representative ?? 'N/A' }}</strong>,
        identificado con <strong>D.N.I. Nº {{ $company->representative_number ?? 'N/A' }}</strong> domiciliado en
        {{ $company->representative_address ?? 'N/A' }}; en adelante
        EL
        <strong>ARRENDADOR</strong>; y de la otra parte
        don/(ña): <strong>{{ $customer ? $customer['name'] : 'N/A' }}</strong> identificado con D.N.I Nº
        <strong>{{ $customer ? $customer['number'] : 'N/A' }}</strong>,
        domiciliado en {{ $customer && isset($customer['address']) ? $customer['address'] : 'N/A' }}; en adelante EL
        <strong>ARRENDATARIO</strong>;
        en los términos siguientes:
    </p>

    <h3>PRIMERO</h3>
    <p>
        EL <strong>ARRENDADOR</strong> es propietario del edificio ubicado en JR. AYACUCHO Nº 656 - HYO – JUNÍN. La área
        de alquiler será utilizado como: {{ $table ? $table['type'] : 'N/A' }} y
        consta de: {{ $table ? $table['description'] : 'N/A' }}.
    </p>

    <h3>SEGUNDO</h3>
    <p>Por el presente documento, EL <strong>ARRENDADOR</strong> da en arrendamiento a EL <strong>ARRENDATARIO</strong>,
        el área descrita en la cláusula anterior.</p>

    <h3>TERCERO</h3>
    <p>
        El presente contrato se inicia el {{ $hotel_rent_item ? $hotel_rent_item['checkin_date'] : 'N/A' }} finalizando
        el {{ $hotel_rent_item ? $hotel_rent_item['checkout_date_estimated'] : 'N/A' }}.
        Fecha en que EL <strong>ARRENDATARIO</strong>
        entregará el inmueble materia del presente a EL <strong>ARRENDADOR</strong>, en las mismas condiciones en que lo
        recibió, salvo el deterioro de su uso normal y cuidadoso.
    </p>

    <h3>CUARTO</h3>
    <p>
        El monto pactado de común acuerdo, es de S/. 200 (Nuevos soles) mensuales, que se pagarán en
        forma
        adelantada. El primer pago se realiza a
        la firma del presente contrato y EL ARRENDADOR declara recibir a su entera satisfacción, entregando a EL
        ARRENDATARIO el recibo de arrendamiento.
    </p>

    <h3>QUINTO</h3>
    <p>
        <strong>EL ARRENDATARIO</strong> entrega y <strong>EL ARRENDADOR</strong> recibe a su entera satisfacción a la
        suscripción del presente contrato,
        el importe de S/ 200 Soles, por concepto de garantía, que cubrirá cualquier daño al área en alquiler
        materia de arriendo y que ocasione <strong>EL ARRENDATARIO</strong>, sólo por el valor justificado del perjuicio
        y hasta por su
        importe total, de ser necesario y sustentado. En caso de entregar <strong>EL ARRENDATARIO</strong> a <strong>EL
            ARRENDADOR</strong> el inmueble en
        las mismas condiciones en que lo recibió y sin más desgaste que los derivados de su uso normal, la garantía será
        devuelta a la finalización del contrato, contra la entrega de la llave.
    </p>

    <h3>SEXTO</h3>
    <p>
        <strong>EL ARRENDATARIO</strong> declara recibir el área en alquiler, materia de contrato, en perfectas
        condiciones;
        comprometiéndose a devolverlo en el mismo estado, salvo el desgaste causado por el uso normal. En todo caso,
        cualquier daño en el inmueble originará la pérdida de la garantía a que se refiere la cláusula anterior.
    </p>

    <h3>SEPTIMO</h3>
    <p>
        El pago del alquiler se realizará al siguiente número de cuenta: 1234567890, a nombre de: Juan Perez.
        En la fecha pactada, en caso de no realizar el deposito a tiempo este generara el 5% del monto del alquiler
        diario.

    </p>

    <h3>OCTAVO</h3>
    <p>
        <strong>EL ARRENDATARIO</strong> cumplirá las Normas de Conducta siguientes:
    <ul>
        <li>Proporcionar información correcta y veraz.</li>
        <li>Respeto con el arrendador y sus vecinos.</li>
        <li>Evitar ruidos molestos y exagerados.</li>
        <li>Está prohibido tener animales domésticos y/o salvajes.</li>
        <li>Está terminantemente prohibido las reuniones sociales con el consumo de bebidas alcohólicas y drogas,
            dentro de las habitaciones.</li>
        <li>Está prohibido alojar a otras personas en la habitación. (Informar si está hospedando a algún familiar)
        </li>
        <li>Mantener limpia y arreglada su habitación.</li>
        <li>Disponer la basura que genere, en el lugar que el <strong>ARRENDADOR</strong> asigne.</li>
        <li>El Arrendatario debe de informar cualquier conducta que perjudique o ponga en peligro la convivencia
            normal y agradable de la vecindad.</li>
        <li> <strong>El incumplimiento de una norma, se hará acreedor de una amonestación de 40.00 soles, la acumulación
                de 2
                amonestaciones, se tendrá que retirar de la habitación, sin reclamo alguno.</strong> </li>
        <li> <strong>Esta considerado como falta grave, peleas, consumo de sustancias toxicas y realizar acciones como
                hurto, peleas, destrozos del inmueble. </strong> </li>
        <li> <strong>La falta grave tiene una amonestación de 100.00 soles y el termino del contrato.</strong> </li>
    </ul>
    </p>

    <h3>NOVENO</h3>
    <p>
        <strong>EL ARRENDADOR</strong> se compromete a dar todas las facilidades para la instalación del
        <strong>ARRENDATARIO</strong> en la
        habitación a alquilar; así mismo se compromete a otorgar la habitación en óptimas condiciones.
    </p>

    <p>
        Ambas partes declaran su conformidad con las cláusulas que anteceden y en tal virtud lo suscriben por duplicado
        y adjuntando la copia de sus respectivos DNI en la fecha.
    </p>

    <p style="text-align: right;">Huancayo, ___ de ________ del 20__</p>




    <!-- Repite el resto del texto del contrato -->

    <div style="display: flex; justify-content: space-between; margin-top: 100px; width: 100%;">
        <div style="text-align: left;">
            <p>________________________</p>
            <p>EL ARRENDADOR</p>
            <p class="text-center">
                {{ $company->representative ?? 'N/A' }}
            </p>
            <p class="text-center">DNI: {{ $company->representative_number ?? 'N/A' }}</p>
        </div>
        <div style="text-align: right;">
            <p>________________________</p>
            <p>EL ARRENDATARIO</p>
            <p class="text-center">
                {{ $customer ? $customer['name'] : 'N/A' }}
            </p>
            <p class="text-center">DNI: {{ $customer ? $customer['number'] : 'N/A' }}</p>
        </div>
    </div>

</body>

</html>
