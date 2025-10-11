<style>
    @page {
        size: 80mm 500mm;
        margin: 0;
    }

    .voucher-wrapper {
        page-break-inside: avoid;
        width: 80mm;
        padding: 2mm;
        box-sizing: border-box;
        margin-left: -2mm;
    }

    .voucher-item {
        page-break-inside: avoid;
    }
</style>

<div class="voucher-wrapper" style="border:2px solid #222; font-family: Arial, sans-serif;">
    <div style="text-align:center; padding:4px 0;">
    <strong style="font-size:18px;">BUENAS NOTICIAS</strong><br>
    <span style="font-size:11px;">Estimado cliente, puedes canjear los siguientes productos:</span>
    <br><br>
    <strong style="font-size:15px;">Cliente: {{ $customer->name ?? '-' }}</strong><br>

        
    </div>
    @if($promotion_items->isEmpty())
        <div style="text-align:center; color:red; font-size:14px; margin:12px 0;">
            No tienes promociones disponibles para canjear.
        </div>
    @else
        @foreach($promotion_items as $item)
            <div class="voucher-item" style="border:1px solid #222; margin:4px 0; padding:2px; text-align:center;">
                <div style="font-size:12px; font-weight:bold;">{{ $item['promotion_description'] }}</div>
                <div style="font-size:12px;">
                    Puntos acumulados: 
                    <span style="font-weight:bold;">{{ $item['customer_points'] }}</span>
                </div>
                <div style="font-size:12px;">Descripción: {{ $item['item_description'] }}</div>
                @if(!empty($item['item_image']))
                    <div style="text-align:center; margin:4px 0;">
                        <img src="{{ public_path('storage/uploads/items/' . $item['item_image']) }}" alt="{{ $item['item_name'] }}" style="width:25%; height:auto; display:inline-block;">
                    </div>
                @endif
                <div style="font-size:12px;">Puntos requeridos: <span style="font-weight:bold;">{{ $item['item_points_value'] }}</span></div>
                <div style="font-size:12px;">Cantidad: <span style="font-weight:bold;">{{ $item['item_quantity'] }}</span></div>
                <div style="font-size:12px;">Fecha de vencimiento: <span style="font-weight:bold;">{{ $item['promotion_end_date'] }}</span></div>
            </div>
        @endforeach
    @endif
</div>