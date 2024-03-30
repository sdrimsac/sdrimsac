<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 1px;
            padding: 1px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            line-height: 1.42857143;
            /*texto justificado */
            text-align: justify;


        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        /*clase  para deshacer los estilos de la tabla */
        .no-border {
            border: none;
        }

        .mt-2 {
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h3 class="bold line">
            PAGARE
        </h3>
    </div>
    <div>
        <p>
            Moneda: soles
        </p>
        <p>
            Importe: {{ $sale->total }}
        </p>
    </div>

    <p>
        FECHA DE VENCIMIENTO:...........................INTERES COMPUESTO EFECTIVO MENSUAL N° DE
        PAGARE....................................IMPORTE MORATORIO EFECTIVO DIARIO
        PAGARE/PAGAREMOS el presente título valor a la orden de CREDIHOGAR RUC:10753874106., o a su legítimo tenedor al
        momento de su vencimiento, en las oficinas del tenedor o donde sea presentado el título para su cobro por la
        suma.........................................que he/hemos recibido de la empresa CREDIHOGAR RUC:10753874106, a
        mi/nuestra entera satisfacción. abonando los
        Intereses compensatorios a la tasa señalada en el presente título valor desde su emisión, la cual es
        capitalizable
        en términos efectivos, reconociendo el pago de intereses moratorias a la tasa pactada en el presente título
        valor
        por día que se devengarán desde la fecha de vencimiento. los cuales se sumarán hasta la total cancelación de la
        obligación contenida en el presente título; así como comisiones, penalidades y gastos, que se pudieran devengar
        desde la fecha de emisión hasta la cancelación total de la presente obligación, sin que sea necesario
        requerimiento
        de pago para constituirme/constituimos en mora, la que se producirá de modo automático.
    </p>

    <p>Expresamente acepto 'aceptamos toda variación de la tasa de interés, comisiones y gastos de acuerdo a ley. Las
        cuales se aplicarán sobre el saldo pendiente de este Pagaré a la fecha de la variación bastando que las mismas
        sean
        exhibidas en el tarifario de CREDIHOGAR RUC:10753874106. o me/nos sean comunicados por cualquier medio.</p>

    <p>
        Asimismo. convengo/convenimos en establecer que el pago de este título valor, se realizara en el domicilio la
        empresa CREDIHOGAR RUC:10753874106. o agencia de ésta {dependiendo el tugar de emisión).
    </p>

    <p>El presente título valor no estará sujeto a protesto notarial, procediendo su ejecución con el solo vencimiento
        de
        la obligación y la falta de prórroga. En este caso. el protesto será facultativo para el tenedor de acuerdo a la
        ley; sin embargo, acepto/aceptamos los gastos notariales que se deriven de suceder el protesto.</p>

    <p>
        Acepto/aceptamos las prórrogas totales o parciales, las renovaciones y/o refinanciamientos que el tenedor decida
        concedemos en el futuro para la cancelación total de la deuda contenida en el presente; autorizo/autorizamos se
        complete el presente título valor por el saldo deudor que adeude/adeudemos.
    </p>

    <p>
        Renuncio/renunciamos expresamente a la posibilidad de incluir clausula alguna que limite la circulación del
        presente
        título valor.
    </p>

    <p>
        Asimismo, declaro/declaramos que a la cancelación de la obligación que representa el presente pagaré, me/nos
        obligó/obligamos a recoger éste documento de forma inmediata, pactando la destrucción de presente título valor
        en
        dicho momento.
    </p>

    <p>
        "Dejo/dejamos constancia que nuestro domicilio es el declarado en el presente título valor. El tenedor a su sota
        decisión podrá entablar acción judicial ante los órganos competentes del lugar de pago del título valor o del
        lugar
        de mi/nuestro domicilio, al amparo de lo establecido en el Art. 24° numeral 4 y Art. 34° del código procesal
        vigente". (...)
    </p>

    <p>
        Declaro/declaramos estar plenamente facultado/s para suscribir el presente Pagaré, asumiendo en caso contrario
        la
        responsabilidad civil y/o penal a que hubiere lugar.
    </p>
    <?php
    setlocale(LC_TIME, 'es_ES');
    $currentDate = strftime('%d DE %B DEL %Y');
    $currentDate = strtoupper($currentDate);
    ?>
    <p class="text-end">
        PICHANAQUI - {{ $currentDate }}
    </p>

<br><br>
    <table class="no-border">
        <tbody>
            <tr>
                <td class="text-center no-border">
                    ...........................................
                    <br>
                    (1) (Firma y/o sello del emitente)
                </td>
                <td class="text-center no-border">
                    ........... <br>
                    Huella</td>
                <td class="text-center no-border">
                    ............................................ <br>
                    (2) Firma y/o sello del emitente</td>
                <td class="text-center no-border">
                    ............ <br>
                    Huella</td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    

    <p style="margin:3px;"> NOMBRE/DENOMINACION/RAZON SOCIAL:</p>
    <p style="margin:3px;"> D.N.I.:</p>
    <p style="margin:3px;"> DOMICILIO:</p>
    <p style="margin:3px;"> NOMBRE/DENOMINACION/RAZON SOCIAL:</p>
    <p style="margin:3px;"> D.N.I.:</p>
    <p style="margin:3px;"> DOMICILIO:</p>

</body>

</html>
