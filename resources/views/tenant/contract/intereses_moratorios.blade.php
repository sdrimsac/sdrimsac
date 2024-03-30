<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* @page{
 margin: 3px;
 padding: 3px;
 } */
        body {
            margin: 1px;
            padding: 1px;
            /*estilos que se le pondria a un documento de impresion */
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
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

        /*clase para deshacer los estilos de la tabla */
        .no-border {
            border: none;
        }

        .mt-2 {
            margin-top: 2px;
        }

        .min-p {
            padding: 3px;
            margin: 1px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h3 class="bold line">
            INTERESES MORATORIOS
        </h3>
    </div>



    <p>
        LA MORA GENERADA ES POR DÍA Y POR CUOTA, DE ACUERDO DE ACUERDO AL PERIODO DEL CRÉDITO.
    </p>


    <table>
        <tr>
            <th>PERIODO</th>
            <th>INTERES</th>
            <th>MONTO</th>
        </tr>
        <tr>
            <td>DIARIO</td>
            <td>15%</td>
            <td>S/. 1.00</td>
        </tr>
        <tr>
            <td>SEMANAL</td>
            <td>17%</td>
            <td>S/. 3.00</td>
        </tr>
        <tr>
            <td>QUINCENAL</td>
            <td>20%</td>
            <td>S/. 5.00</td>
        </tr>
        <tr>
            <td>PAGO UNICO</td>
            <td>15%-17%</td>
            <td>S/. 7.00</td>
        </tr>
        <tr>
            <td>MENSUAL</td>
            <td>25%</td>
            <td>S/. 10.00</td>
        </tr>
        <tr>
            <td>PRENDARIOS</td>
            <td>30%</td>
            <td>S/. 15.00</td>
        </tr>
    </table>



    <p>
        LEIDO Y TENIENDO CONOCIMIENTO DE LOS INTERES Y LA MORA QUE GENERAN MI/SU CREDITO
        ADQUIRIDO, ME/NOS COMPROMETO/COMPROMETEMOS A PAGAR A MI/NUESTRA ENTERA RESPONSABILIDAD LOS INTERESES MORATORIOS
        A LA
        TASA PACTADA EN EL PRESENTE TITULO.
    </p>
    <p>
        FIRMAN CONFORMIDAD Y ENTERADOS
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
            <tr class="no-border">
                <td class="no-border" width="50%" valign="top">
                    <p class="min-p">ASESORA:</p>
                    <p class="min-p">NOMBRE:</p>
                    <p class="min-p">DNI:</p>
                </td>
                <td class="no-border" valign="top">
                    <p class="min-p">NOMBRE Y APELLIDO:</p>
                    <p class="min-p">DNI:</p>
                </td>
            </tr>
            <tr>
                <td class="no-border" valign="top">

                </td>
                <td class="no-border" valign="top">
                    <p class="min-p"><strong>AVAL</strong></p>
                    <p class="min-p">NOMBRE Y APELLIDO:</p>
                    <p class="min-p">DNI:</p>
                </td>
            </tr>
        </tbody>
    </table>








</body>

</html>
