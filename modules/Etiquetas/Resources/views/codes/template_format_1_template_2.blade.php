<html>
@php
    $configuration = \App\Models\Tenant\Configuration::first();
@endphp

<head>
    <style>
        body {
            margin: 0 auto;
            padding: 0px;
        }

        @page {
            margin: 0px;
            padding: 0px;
        }

        #image {
            width: 110px;
            margin: auto;
            text-align: center;
        }

        table {
            font-size: 13px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        #content {
            height: 163px;
            width: 225px;
            text-align: center;
        }

        .text-center {
            text-align: center !important;
        }

        .purchase_code {
            text-align: right !important;
            float: right;
        }

        .text-right {
            text-align: right !important;
        }

        .font-sm {
            font-size: 15px;
        }

        .font-xxs {
            font-size: 6px;
        }

        .font-xs {
            font-size: 8px;
        }

        .font-md {
            font-size: 12px;
        }

        .font-lg {
            font-size: 15px;
        }

        w-100 {
            width: 100%;
        }

        float-left {
            float: left;
        }

        w-47 {
            width: 47%;
        }
    </style>
</head>

<body>
    {{-- @for ($i = 0; $i < $stock; $i += 2) --}}
    <div>
        <div class="" style=" height: 60px;">
            <div style="height: 60px;float: left; width:110px;">
                <div>
                    <div style="width: 50%; float: left; text-align: center;">
                        <div style="height: 30px;">
                            <img style="height: 20px; max-width:100px;" src='{{ $image }}'>
                        </div>
                    </div>
                    <div style="width: 50%; float: left;">
                        <div class="font-xs text-center">
                            S/.{{ $sale_code }}
                        </div>
                        <div class="text-center font-xs"
                            style="width:100%;height:20px;font-size:6px;overflow:hidden;text-align: justify">
                            {{ substr($description, 0, 30) }}
                        </div>
                    </div>
                </div>
                <div style="height:13px;width:100%;overflow:hidden;">
                    <div class="w-100 " style="height: 5px;text-align: center;">

                        <div class="font-xxs" style="float:left;width:50%;">
                            {{ $location ?? '-' }}
                        </div>

                        <div class="font-xxs" style="float:left;width:50%;">
                            {{ $purchase_code }}
                        </div>

                    </div>
                    <div style="overflow: hidden;height: 15px;">
                        @php
                            $colour = [0, 0, 0];
                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                            echo '<img style="height: 15px; margin-left: 5px;"  src="data:image/png;base64,' .
                                base64_encode(
                                    $generator->getBarcode(
                                        $barcode1,
                                        $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                    ),
                                ) .
                                '">';
                        @endphp
                    </div>
                    <div style="text-align:center;font-size:8px;margin:0px;padding:0px;">
                        {{ $barcode1 }}
                    </div>

                </div>
            </div>
            <div style="float: left; width:5px;height: 55px;">
                <br>
            </div>
            <div style="height: 60px;float: left; width:110px;">
                <div>
                    <div style="width: 50%; float: left;text-align: center;">
                        <div style="height: 30px;">
                            <img style="height: 20px; max-width:100px;" src='{{ $image }}'>
                        </div>
                    </div>
                    <div style="width: 50%; float: left;">
                        {{-- @if ($configuration->correo_red_salud_ticket) --}}
                        <div class="font-xs text-center">
                            S/.{{ $sale_code }}
                        </div>
                        {{-- @endif --}}
                        <div class="text-center font-xs"
                            style="width:100%;height:20px;font-size:6px;overflow:hidden;text-align: justify">
                            {{ substr($description, 0, 30) }}
                        </div>
                    </div>
                </div>
                <div style="height:13px;width:100%;overflow:hidden;">
                    <div class="w-100" style="height: 5px; text-align: center;">
                        <div class="font-xxs" style="float:left;width:50%;">
                            {{ $location ?? '-' }}
                        </div>

                        <div class="font-xxs" style="float:left;width:50%;">
                            {{ $purchase_code }}
                        </div>
                    </div>
                    <div style="overflow: hidden;height: 15px; text-align:center; margin:0px; padding:0px;">
                        @php
                            $colour = [0, 0, 0];
                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                            echo '<img style="height: 15px; float: left; margin-left: 10px;"  src="data:image/png;base64,' .
                                base64_encode(
                                    $generator->getBarcode(
                                        $barcode2,
                                        $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                    ),
                                ) .
                                '">';
                        @endphp
                    </div>
                    <div style="text-align:center;font-size:8px;margin:0px;padding:0px;">
                        {{ $barcode2 }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endfor --}}
</body>

</html>
