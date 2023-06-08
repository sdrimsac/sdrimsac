<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
   
	<title>Recibo de Pago</title>
    <style>
    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: .5cm;
        margin-left: .5cm;
        margin-right: .5cm;
        margin-bottom: .5cm;
    }
    .logotipo{
        width: 250px !important;
        height: 1.5cm !important;
        text-align: center;
    }
    td{
        font-family: Arial, sans-serif;
        font-size: 12px;
        height: 20px !important;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .detalle{
                margin-top: 1.8cm;
                margin-bottom: 1cm;
            }
    .border-right{
        border-right: 1px solid #333;
    }
    .border-top{
        border-top: 1px solid #333;
    }
    @page {
        margin-top: 5px;
		margin-left: 15px;
		margin-right:15px;
	}
    .border-bottom, thead {
        font-family: Arial, sans-serif;
        font-size: 12px;
        height: 20px !important;
        border-bottom: 0.1px solid #ccc;
    }
    h4{
                font-weight: bold;
                font-size: 16px;
                margin:0px;
                padding: 2px;

            }
            h1,h2,h3,h5,h6{
                margin:0px;
                padding: 2px;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
            .text-right {
                text-align: right !important;
            }
            .text-center {
                text-align: center !important;
            }
            .text-left {
                text-align: left !important;
            }
            .text-justify{
                text-align: justify !important;
                line-height: 25px;
            }
            .date_css{
                width: 100px !important;
                float: left;
                border-bottom: 0.1px solid #ccc;
                padding-bottom: 5px;
                margin-right: 10px !important;
            }
            .container{
                width: 100% !important;
                border: 1px solid #333;
                 min-height: 600px;
                
            }
    </style>
<body>
    
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr >
            <td valign="top" class="text_header" align="center">
            @if($company->logo)
                    <img src="data:{{mime_content_type(public_path("storage/uploads/logos/{$company->logo}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}")))}}" alt="{{$company->name}}" class="logotipo">
            @endif
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3 style="font-size:15px !important">
                    CONTRATO DE SERVICIOS
                </h3>
            </td>
        </tr>
    </table>
     <table width="100%" class="table table">
            <tr>
                <td>
                    <?php
                    //dd($sale->establishment);
                    ?>
                   <p class="text-justify"> YO <b>{{$company->representative}}</b> con DNI Nº <b>{{$company->representative_number}}</b> REPRESENTANTE LEGAL DE <b>{{ strtoupper($company->name)}}</b> UBICADO EN {{$company->representative_address}};  DOY EN VENTA AL <br>
                    SR(A). <b>{{$sale->customer->name}}</b>  DNI N° {{$sale->customer->number}} DOMICILIO EN {{$sale->customer->address}} DEL DISTRITO {{strtoupper($sale->establishment->district->description)}} PROVINCIA {{strtoupper($sale->establishment->province->description)}} DEPARTAMENTO {{ strtoupper($sale->establishment->department->description)}} <br>  </p>
                   
                    UN <b>{{$sale->items[0]->item->description}}</b><br><br>
                    MONTO DEL CREDITO S/ <b>{{$sale->total}}</b></p><br><br>
                    Nº CUOTA <b>{{count($payment)}}</b><br><br>
                    VALOR DE LA CUOTA <b>{{number_format($payment[0]->amount,2)}}</b><br><br>
                    <?php
                    $num=0;
                    $cont=0;
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
                                        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                        $fecha = \Carbon\Carbon::parse($date);
                                        $mes = $meses[($fecha->format('n')) - 1];
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
     </table>       
</body>