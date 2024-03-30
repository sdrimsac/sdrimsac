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
            /*estilos que  se le pondria a un documento de impresion */
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;


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
        .mt-2{
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h3 class="bold line">
            CALIFICACION EN CENTRALES DE RIESGOS

        </h3>
    </div>
    <div>
        <p>
            YO
            (NOSOTROS)...................................................................................................................................................Y
            COMO AVAL (ES)
            ...................................................................................................................................................
            DECLARO(AMOS) ESTAR INFORMADO(S) QUE:
        </p>
        <p>
            SEGÚN LOS PAGOS REALIZADOS DEMS CREDITOS, Ml CALIFICACIÓN SE REPORTARÁN A INFOCORP, SENTINEL Y A LA
            SUPERINTENDENCIA DE BANCA Y SEGUROS - SBS, ASÍ COMO A LOS BANCOS, FINANCIERAS, CAJAS MUNICIPALES, CAJAS
            RURALES Y EDPYMES, SEGÚN EL CUADRO SIGUIENTE:
        </p>
        <table>
            <thead>
                <tr>
                    <th>
                        CALIFICACIÓN
                    </th>
                    <th>
                        DIAS DE ATRASO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        BUEN CLIENTE - NORMAL
                    </td>
                    <td>
                        PUNTUAL (CERO DIAS)
                    </td>
                </tr>
                <tr>
                    <td>
                        MAL CLIENTE - CON PROBLEMAS POTENCIALES - CPP
                    </td>
                    <td>
                        DE 1 A 30 DIAS DE ATRASO
                    </td>
                </tr>
                <tr>
                    <td>
                        MAL CLIENTE - DEFICIENTE
                    </td>
                    <td>
                        DE 31 A 60 DIAS DE ATRASO
                    </td>
                </tr>
                <tr>
                    <td>
                        MAL CLIENTE - DUDOSO
                    </td>
                    <td>
                        DE 61 A 120 DIAS DE ATRASO
                    </td>
                </tr>
                <tr>
                    <td>
                        MAL CLIENTE - PERDIDA
                    </td>
                    <td>
                        MAS DE 120 DIAS DE ATRASO
                    </td>
                </tr>
            </tbody>
        </table>



        <p>
            POR TANTO, LOS QUE SUSCRIBIMOS, AUTORIZAMOS A SER REPORTADOS COMO TITULARES DEL CRÉDITO, A LAS INSTITUCIONES
            Y EMPRESAS SEÑALADAS LINEAS ARRIBA, POR EL TOTAL DE LA DEUDA.
        </p>
        <?php
        setlocale(LC_TIME, 'es_ES');
        $currentDate = strftime('%d DE %B DEL %Y');
        $currentDate = strtoupper($currentDate);
        ?>
        <p class="text-end">
            {{ $currentDate }}
        </p>

    
    </div>
    <br>
    <br>
    <br>
    <table class="no-border mt-2">
        <tbody>
            <tr>
                <td class="no-border text-center">
                    .............................................................................................
                </td>
                <td  class="no-border text-center">
                    .............................................................................................
                </td>
            </tr>
            <tr>
                <td class="no-border">
                    <br>
                    <br></td>
                <td class="no-border">
                    <br>
                    <br></td>
            </tr>
            <tr>
                <td class="no-border text-center">
                    .............................................................................................
                </td>
                <td  class="no-border text-center">
                    .............................................................................................
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
