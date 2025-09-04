<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de traslado</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="{{ $company->name }}" />
    <meta name="description" content="Guía de traslado #{{ format_serie($transfer->id) }}" />
</head>
<?php
function format_serie($id)
{
    if (10 > $id) {
        return '000' . $id;
    }
    if (100 > $id) {
        return '00' . $id;
    }
    if (100 > $id) {
        return '0' . $id;
    }

    return '000' . $id;
}
?>
<style>
    html {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 11px;
        color: #1F1F1F;
    }

    body { margin:0; padding:0; }

    @page { margin: 18px 20px 25px 20px; }

    #page-wrapper { width:100%; }

    #register {
        border: 2px solid #111;
        padding: 14px 16px 18px 16px;
        box-sizing: border-box;
        width:100%;
        border-radius: 4px;
        position: relative;
        min-height: 96%;
    }

    .doc-header {
        width:100%;
        border-bottom: 2px solid #444;
        margin-bottom: 6px;
        padding-bottom: 4px;
        display: flex;
        align-items: flex-start;
    }
    .company-block { width:60%; }
    .company-name { font-size:15px; font-weight:700; letter-spacing:.5px; }
    .doc-meta { width:40%; text-align:right; font-size:11px; }
    .doc-title { font-size:16px; font-weight:700; margin-top:4px; }
    .code-box { border:1px solid #888; padding:4px 6px; display:inline-block; border-radius:3px; background:#f7f7f7; }

    table { width:100%; border-spacing:0; border-collapse: collapse; }
    .items-table thead th { background:#efefef; font-weight:600; font-size:10px; letter-spacing:.5px; }
    .items-table th, .items-table td { border:1px solid #c7c7c7; padding:4px 5px; vertical-align: top; }
    .items-table tbody tr:nth-child(even){ background:#fafafa; }
    .col-number { width:32px; text-align:center; }
    .col-desc { width:65%; }
    .col-qty { width:90px; text-align:center; white-space:nowrap; }
    .lot-line { font-size:9px; color:#444; }
    .qty-factor { display:block; font-size:8px; color:#666; line-height:1.1; }

    .section-box { border:1px solid #bbb; padding:6px 8px; border-radius:3px; margin-top:6px; }
    .label { font-weight:600; }
    .footer-sign { margin-top:30px; display:flex; justify-content:space-between; }
    .sign-box { width:32%; text-align:center; font-size:10px; }
    .sign-line { margin-top:35px; border-top:1px solid #333; padding-top:2px; }

    .header_title2 { font-size: 14px !important; }
    .small { font-size: 8px !important; }
    .description_preparacion { font-size: 10px !important; }
    .text-center { text-align:center; }
    .muted { color:#666; }
    .badge { background:#444; color:#fff; padding:1px 5px; border-radius:3px; font-size:10px; }
    .meta-grid { width:100%; margin-top:4px; }
    .meta-grid td { font-size:10px; padding:2px 0; }

    /* Numeración páginas (dompdf) se agrega con script php abajo */

    /* Watermark opcional */
    .watermark {
        position: absolute;
        top:40%;
        left:50%;
        transform:translate(-50%, -50%) rotate(-25deg);
        font-size:70px;
        font-weight:700;
        color:rgba(0,0,0,0.04);
        pointer-events:none;
        white-space:nowrap;
    }

    /* Evitar cortes raros */
    .avoid-break { page-break-inside: avoid; }
    .items-table tr { page-break-inside: avoid; }

    /* Compatibilidad impresión */
    td, th { font-size:10px; }

</style>
<?php
function format($it)
{
    $quantity = $it->quantity;
    $item = $it->item;
    $unit_type_id = $item->unit_type_id;
    $max_qty = $it->item->max_quantity;
    $div = floatval($quantity / $max_qty);
    $part_int = intval($div);
    $parts = $div - $part_int;
    if ($parts != 0) {
        $part_dec = $parts * $max_qty;
    }

    $unit_type_dec = $unit_type_id;
    $units = $item->item_unit_types;
    foreach ($units as $unit) {
        if ($unit->quantity_unit == $max_qty) {
            $unit_type_dec = $unit->description;
        }
    }
    
    $result = '';

    if ($part_int != 0) {
        $result .= $part_int . ' ' . $unit_type_dec;
    }
    if (isset($part_dec)) {
        $result .= ' ' . $part_dec . ' ' . $unit_type_dec;
    }

    return $result;
}
?>

<body>
<div id="page-wrapper">
    <div id="register">
        <div class="watermark">{{ $company->trade_name ?? $company->name }}</div>
        <div class="doc-header">
            <div class="company-block">
                <div class="company-name">
                    {{ $company->trade_name ? $company->trade_name : $company->name }}
                </div>
                <table class="meta-grid">
                    <tr>
                        <td class="label" style="width:80px">RUC:</td>
                        <td>{{ $company->number }}</td>
                    </tr>
                    <tr>
                        <td class="label">Dirección:</td>
                        <td>{{ $company->address ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tel:</td>
                        <td>{{ $company->telephone ?? '—' }}</td>
                    </tr>
                </table>
            </div>
            <div class="doc-meta">
                <div class="doc-title">GUÍA DE TRASLADO</div>
                <div class="code-box">GT-{{ format_serie($transfer->id) }}</div>
                <div style="margin-top:6px;">
                    <span class="label">Fecha:</span> {{ $transfer->created_at->format('d/m/Y') }}<br>
                    <span class="label">Código:</span> {{ $transfer->code }}
                </div>
            </div>
        </div>

        <div class="section-box avoid-break" style="margin-top:4px;">
            <table style="width:100%;">
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <span class="label">Enviado por:</span><br>
                        {{ $transfer->sender->name }}
                    </td>
                    <td style="width:50%; vertical-align:top;">
                        <span class="label">Almacenes:</span><br>
                        <strong>Origen:</strong> {{ $transfer->warehouse->description }}<br>
                        <strong>Destino:</strong> {{ $transfer->warehouse_destination->description }}
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top:10px;" class="avoid-break">
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="col-number">#</th>
                        <th class="col-desc">Producto</th>
                        <th class="col-qty">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($transfer->detail as $idx => $it)
                    <tr>
                        <td class="col-number">{{ $idx + 1 }}</td>
                        <td class="col-desc">
                            <strong>{{ $it->item->description }}</strong>
                            @if (isset($it->series_lots))
                                @foreach ($it->series_lots['lotes'] as $lot)
                                    <div class="lot-line">Lote: {{ $lot['code'] }} - Cant. {{ $lot['quantity'] }}</div>
                                @endforeach
                            @endif
                        </td>
                        <td class="col-qty">
                            @if (isset($it->item->max_quantity))
                                {{ format($it) }}
                                <span class="qty-factor">{{ $it->quantity }} unds</span>
                                <span class="qty-factor">Factor {{ $it->item->max_quantity }}</span>
                            @else
                                {{ $it->quantity }} {{ $it->item->unit_type_id }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer-sign">
            <div class="sign-box">
                <div class="sign-line">Entregado por</div>
            </div>
            <div class="sign-box">
                <div class="sign-line">Transportista</div>
            </div>
            <div class="sign-box">
                <div class="sign-line">Recibido por</div>
            </div>
        </div>

        <div style="margin-top:18px; font-size:9px; color:#555; text-align:right;">
            Generado: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>

@php
    // Numeración de páginas para dompdf
    if (isset($pdf)) {
        $pdf->page_script('if ($PAGE_COUNT > 1) { $font = $fontMetrics->get_font("DejaVu Sans", "normal"); $pdf->text($pdf->get_width() - 70, $pdf->get_height() - 25, "Página $PAGE_NUM de $PAGE_COUNT", $font, 8); }');
    }
@endphp

</body>

</html>
