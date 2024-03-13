<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Fianza</title>
    <style>
        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: .5cm;
            margin-left: .5cm;
            margin-right: .5cm;
            margin-bottom: .5cm;
            font-family: Arial, sans-serif;
        }

        .title {
            font-size: 24px;
        }

        .logotipo {
            width: 250px !important;
            height: 1.5cm !important;
            text-align: center;
        }

        td {
            font-family: Arial, sans-serif;
            font-size: 12px;
            height: 20px !important;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .detalle {
            margin-top: 1.8cm;
            margin-bottom: 1cm;
        }

        .border-right {
            border-right: 1px solid #333;
        }

        .border-top {
            border-top: 1px solid #333;
        }

        @page {
            margin-top: 5px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .border-bottom,
        thead {
            font-family: Arial, sans-serif;
            font-size: 12px;
            height: 20px !important;
            border-bottom: 0.1px solid #ccc;
        }

        h4 {
            font-weight: bold;
            font-size: 16px;
            margin: 0px;
            padding: 2px;

        }

        h1,
        h2,
        h3,
        h5,
        h6 {
            margin: 0px;
            padding: 2px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-justify {
            text-align: justify !important;
            line-height: 25px;
        }

        .date_css {
            width: 100px !important;
            float: left;
            border-bottom: 0.1px solid #ccc;
            padding-bottom: 5px;
            margin-right: 10px !important;
        }

        .container {
            width: 100% !important;
            border: 1px solid #333;
            min-height: 600px;

        }
    </style>

<body>
    @php
    //declarar la funcion func_get_month si no ha sido declarada ya
    if (!function_exists('func_get_month')) {
        function func_get_month($month)
        {
            $months = array(
                '01' => 'ENERO',
                '02' => 'FEBRERO',
                '03' => 'MARZO',
                '04' => 'ABRIL',
                '05' => 'MAYO',
                '06' => 'JUNIO',
                '07' => 'JULIO',
                '08' => 'AGOSTO',
                '09' => 'SEPTIEMBRE',
                '10' => 'OCTUBRE',
                '11' => 'NOVIEMBRE',
                '12' => 'DICIEMBRE'
            );
            return $months[$month];
        }
    }

@endphp 
    <table width="100%" cellspacing="0" cellpadding="0">

        <tr>
            <td align="center" class="title">
                FIANZA
            </td>
        </tr>
    </table>
    <div>
        <p>
            Me constituyo/nos constituimos en fiador solidario/fiadores solidarios de: {{ $sale->customer->name }}
            y entre nosotros mismos. por las obligaciones contraídas en este documento sus prorrogas,
            renovaciones y/o refinanciamientos, comprometiéndome/comprometiéndonos a responder por la
            cantidad adecuada.
        </p>

        <p>Intereses compensatorios y moratorios pactados, así como comisiones y
            gastos que se pudieran devengar desde la fecha de emisión del presente título valor hasta la
            cancelación total de la presente obligación, de sus prorrogas. renovaciones y/o refinanciamientos.
            Esta fianza es solidaria, incondicional, irrevocable y por plazo indefinido y estará vigente mientras
            no se encuentre totalmente pagada la obligación contenida en este título valor. Acepto/aceptamos
            desde ahora todas las prórrogas, renovaciones y/o refinanciamientos que el tenedor tenga a bien
            conceder a mi/nuestro garantizado aun cuando no estén suscritas por él y sin que sea necesario
            mi/nuestra conformidad posterior y/o comunicación alguna. Asimismo, acepto/aceptamos que esta
            garantía personal cubre no sólo a la obligación cambiaria sino a la obligación causal, pudiendo
            ejecutarse sin necesidad de presentar o exhibir este título valor. permaneciendo vigente aun
            cuando el mismo se hubiera perjudicado o prescrito de acuerdo a la ley.</p>
        <p>Declaro/declaramos mi/nuestra completa aceptación a todas las cláusulas contenidas en el
            anverso del presente título valor siempre que no sean incompatibles con la naturaleza de este
            acto. Asimismo, queda establecido que mi/nuestro domicilio es el consignado en el presente
            documento.</p>
        <p>Asimismo. declaro/declaramos que a la cancelación de la obligación que respaldo/respaldamos
            con la presente fianza, me/nos obligó/obligamos a recoger este documento de forma inmediata.
            pactando la destrucción del presente título valor en dicho momento.</p>
        <p>Declaro/declaramos estar plenamente facultado/s para suscribir el presente Pagaré, asumiendo
            en caso contrario la responsabilidad civil y/o penal que diere lugar.</p>

            <div class="text-end">
                @php
                    $date_of_issue = $sale->date_of_issue;
                @endphp
                PICHANAQUI, {{ $date_of_issue->format('d') }} DE {{ func_get_month($date_of_issue->format('m')) }} DEL {{ $date_of_issue->format('Y') }}
            </div>
    </div>
    <table
    width="100%"
    class="table"
    style="margin-top: 100px;"

    >
<tr>
    <td
    width="49%"
    style="border-top: #333 solid 1px; padding-top: 10px; padding-bottom: 10px;"
    >
    (1) Firma o sello del emitente  Huella
</td>
<td
width="2%"
>

</td>
    <td
    style="border-top: #333 solid 1px; padding-top: 10px; padding-bottom: 10px;"
    >
        (1) Firma o sello del emitente  Huella
    </td>
</tr>
<tr>
    <td style="font-size: 15px;">
        <strong>
            NOMBRE/DENOMICACIÓN/RAZÓN SOCIAL:
        </strong><br>
        <strong>
            DNI:
        </strong><br>
        <strong>
            DOMICILIO:
        </strong><br>
    </td>
</tr>
<tr>
    <td style="font-size: 15px;">
        <strong>
            NOMBRE/DENOMICACIÓN/RAZÓN SOCIAL:
        </strong><br>
        <strong>
            DNI:
        </strong><br>
        <strong>
            DOMICILIO:
        </strong><br>
    </td>
</tr>
</table>
    {{-- <table width="100%" class="table table">
            <tr>
                <td>
                    <?php
                    //dd($sale->establishment);
                    ?>
                   <p class="text-justify"> YO <b>{{$company->representative}}</b> con DNI Nº <b>{{$company->representative_number}}</b> REPRESENTANTE LEGAL DE <b>{{ strtoupper($company->name)}}</b> UBICADO EN {{$company->representative_address}};  DOY EN VENTA AL <br>
                    SR(A). <b>{{$sale->customer->name}}</b>  DNI N° {{$sale->customer->number}} DOMICILIO EN {{$sale->customer->address}} DEL DISTRITO {{strtoupper($sale->establishment->district->description)}} PROVINCIA {{strtoupper($sale->establishment->province->description)}} DEPARTAMENTO {{ strtoupper($sale->establishment->department->description)}} <br>  </p>
                   
                    UN <b>{{$sale->items[0]->item->description}}</b><br><br>
                    MONTO DEL CREDITO S/ <b>{{$sale->total - $sale->advances}}</b></p><br><br>
                    Nº CUOTA <b>{{count($payment)}}</b><br><br>
                    VALOR DE LA CUOTA <b>{{number_format($payment[0]->amount,2)}}</b><br><br>
                    <?php
                    $num = 0;
                    $cont = 0;
                    ?>
                   
                    <p class="text-justify">
                    UNA VEZ FIRMADA LA CONTRATA Y ENTREGADA LA MERCADERIA NO SE ACEPTA DEVOLUCIÓN; SI LO HACE PERDERÁ LOS PAGOS RALIZADOS.  EN CASO  DE INCUMPLIMIENTO, 
                    ESTÁ  OBLIGADO  EL  DEUDOR(A)  EN  PAGAR  EL  INTERÉS  COMPENSATORIO  Y MONETARIO Y MORATORIO DE CONFORMIDAD CON LO ESCRITO EN EL ART. 1242,1243 <br>

                    01. AL NO PAGAR DE DOS CUOTAS CONSECUTIVAS (MESES)EL, EL ARTEFACTO SERÁ RECOGIDO POR LA CASA COMERCIAL SIN OBJECIÓN
                    ALGUNA DE PARTE DEL DEUDOR(A).<br>
                    02. AL GARANTE: EL GARANTE ASUMIRA TODA LA DEUDA PENDIENTE, PROTESTA ALGUNA.<br>
                    03. AL CABO DE LA CONCELACIÓN TOTAL, EL CLIENTE DEBERÁ RECLAMAR SU BOLETO O FACTURA A LA CASA COMERCIAL.</p>
                    <p>
                    EN CONFORMIDAD PLENA DE TODO LO MENSIONADO LINEAS ARRIBA, FIRMAN LAS PARTES INVOLUCRADAS EN ESTE CONTRATO.
                    </p>
                    <?php
                    $date = \Carbon\Carbon::now();
                    ?>
                    <?php
                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    $fecha = \Carbon\Carbon::parse($date);
                    $mes = $meses[$fecha->format('n') - 1];
                    ?>
                        
                    <p style="text-align: right;padding-top:50px">{{strtoupper($sale->establishment->district->description)}} {{\Carbon\Carbon::parse($date)->format('d')}} DE {{strtoupper($mes)}} DEL {{\Carbon\Carbon::parse($date)->format('Y')}}</p>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:150px"> 
                        <tr>
                            <td align="center" valign="top" width="30%" style="border-top: 1px solid #333;">
                            {{strtoupper($company->name)}}
                            </td>
                            <td  width="5%"></td>
                            <td align="center" valign="top"  width="30%" style="border-top: 1px solid #333;">
                                CLIENTE
                            </td>
                            <td  width="5%"></td>
                            <td align="center" valign="top"  width="30%" style="border-top: 1px solid #333;">
                                GARANTE
                            </td>

                        </tr>
                    </table>

                </td>
            </tr>
     </table>        --}}
</body>
