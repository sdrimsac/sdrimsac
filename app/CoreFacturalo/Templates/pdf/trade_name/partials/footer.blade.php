@php
    $path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $footer_text = \App\Models\Tenant\Configuration::select('footer_text')->first()->footer_text;
@endphp
<head>
    <link href="{{ $path_style }}" rel="stylesheet" />
</head>
<body>
<table class="full-width" style="margin-top: 25px;">
    @if ($footer_text)
        
    <tr>
        <td class="text-center desc font-bold">{{$footer_text}}</td>
    </tr>
    @endif
    <tr>
        <td class="text-center desc font-bold">Para consultar el comprobante ingresar a {!! url('/buscar') !!}</td>
    </tr>
</table>
</body>