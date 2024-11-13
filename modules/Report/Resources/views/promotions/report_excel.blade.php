<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créditos por cobrar</title>

</head>
@php

    $configuration = App\Models\Tenant\Configuration::first();

@endphp

<body>
    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td colspan="15" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <strong>REPORTE PROMOCIONES</strong>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="background: #afd095; color:#006100;border:1px solid black;">
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
                <td colspan="4" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
                <td colspan="3" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
        </table>
    </div>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php

                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">#
                            </th>
                        
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                                Cliente
                            </th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                                Promoción
                            </th>
                        
                            @if ($configuration->promotions_by_points)
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                                Puntos</th>
                            @else
                                <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                                    Monto
                                </th>
                            @endif
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                        @php
                        
                        @endphp
                        {{-- return [
                            'id' => $row->id,
                            'customer_id' => $row->customer_id,
                            'customer_name' => $row->customer->name,
                            'promotion_id' => $row->promotion_id,
                            'promotion_name' => $row->promotion_document->description,
                            'points' => $row->points,
                            'acc_total' => $row->acc_total,
                        ]; --}}
                        <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $record->customer_name }}</td>
                                <td>{{ $record->promotion_name }}</td>
                                @if ($configuration->promotions_by_points)
                                    <td>{{ $record->points }}</td>
                                @else
                                    <td>{{ $record->acc_total }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
