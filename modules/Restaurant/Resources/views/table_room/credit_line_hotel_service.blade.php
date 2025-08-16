<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garantía</title>
</head>
<style>

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px; /* texto general más grande */
        margin: 0; /* sin margen arriba */
        padding: 0;
        color: #000;
        font-weight: bold;
    }

    /* Contenedor principal: quitar espacio superior visible */
    #register {
        margin-top: -20px; /* empuja el contenido hacia arriba */
        padding-top: 0;
    }

    .ticket {
        width: 226.77px; /* 80mm */
        padding: 4px 2px 4px 0px;
        margin-left: -18px;
        margin-top: 0; /* no dejar margen arriba */
    }

    /* Utilidades de alineación usadas en el markup */
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .center { text-align: center; }
    .right { text-align: right; }
    .bold { font-weight: bold; }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0; /* sin margen al inicio */
        font-weight: bold;
    }

    th, td { padding: 2px 0; }

    th {
        border-bottom: 1px dashed #000;
        font-weight: bold;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 4px 0;
    }

    .thanks {
        margin-top: 10px;
        font-size: 12px;
    }

    /* Título (nombre de la compañía) más grande y destacado */
    .header_title {
        font-size: 18px; /* más grande para el nombre de la compañía */
        font-weight: 900;
        text-transform: uppercase;
    }

    /* Subtítulos/filas de encabezado secundarias ligeramente más grandes */
    .header_title0 {
        font-size: 14px;
        font-weight: 700;
    }

    /* Reglas para impresión: elimina márgenes de página del navegador/impresora */
    @media print {
        @page { margin: 0; }
        html, body { margin: 0; padding: 0; }
        #register { margin-top: -20px; padding-top: 0; }
        table { margin-top: 0; }
    }
    
</style>
<?php

?>

<body>
    <div id="register">
        {{-- <div class="text-center" style="margin-bottom:10px;">
            <h1>texto de prueba</h1>
        </div> --}}

        <table border="0" style="border:0px solid;width:90%">
            <thead>
                <tr>
                    <th colspan="4" class="header_title text-center">
                        @if ($company->trade_name)
                            {{ $company->trade_name }}
                        @else
                            {{ $company->name }}
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="header_title0 text-center">
                        HABITACIÓN: {{ $record->room }}

                    </th>
                </tr>
                <tr>


                    <th colspan="4" class="header_title0 text-center">

                        FECHA: {{ $record->created_at }}
                    </th>

                </tr>
                <tr>
                    <th colspan="4" class="header_title0 text-center">
                        HORA: {{ date('H:i:s') }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="4" class="header_title0 text-left">
                        <strong>HUESPED:</strong> {{ $record->customer_name }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="header_title0 text-left">
                        <strong>DOCUMENTO:</strong> {{ $record->customer_number }}
                    </td>
                </tr>
                <tr style="height: 14px;">
                    <td colspan="5" class="header_title0 text-left">
                        <strong>
                            SE DEJA UNA GARANTÍA DE: S/ {{ $record->credit_line }}

                        </strong>
                    </td>
                </tr>

            </tbody>

        </table>


        <div style="margin-top:15px;">

            <table border="0" style="border:0px solid;width:100%">
                <tbody>

                    <tr>
                        <td colspan="4" class="header_title0 text-left">
                            <strong>CAJERO:</strong> {{ $record->user_name }}
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>

        {{-- Mensaje final si no hay datos --}}
        @php
            $sinDatos =
                empty($record) ||
                (empty($record->room) &&
                    empty($record->customer_name) &&
                    empty($record->customer_number) &&
                    (empty($record->credit_line) && $record->credit_line !== '0' && $record->credit_line !== 0) &&
                    empty($record->user_name));
        @endphp
        @if ($sinDatos)
            <div class="text-center small" style="margin-top:10px;color:#666;">
                <em>Sin datos</em>
            </div>
        @endif

        {{-- <div class="text-center" style="margin-top:10px;">
            <h1>
                texto de prueba
                <strong>fin del texto de prueba de impesion</strong>

            </h1>
        </div> --}}

    </div>
</body>

</html>
