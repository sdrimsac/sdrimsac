<html>

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
    @for ($i = 0; $i < $stock; $i += 2)
        <div>
            <div class="" style=" height: 60px;">
                <div style="height: 60px;float: left; width:110px;">
                    <div>
                        <div style="width: 50%; float: left;">
                            <div style="height: 30px;">
                                <img style="height: 30px; max-width:110px;" src='{{ $image }}'>
                            </div>

                        </div>
                        <div style="width: 50%; float: left;">
                            <div class="font-xs text-center">
                                {{ $sale_code }}
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

                            echo '<img style="height: 15px;"  src="data:image/png;base64,' .
                                base64_encode(
                                    $generator->getBarcode(
                                        $barcode,
                                        $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                    ),
                                ) .
                                '">';
                        @endphp
                        </div>
                        <div style="text-align:center;font-size:8px;margin:0px;padding:0px;">
                            {{ $barcode }}
                        </div>
                       
                    </div>
                </div>
                <div style="float: left; width:9.3px;height: 55px;">
                    <br>
                </div>
                <div style="height: 60px;float: left; width:110px;">
                    <div>
                        <div style="width: 50%; float: left;">
                            <div style="height: 30px;">
                                <img style="height: 30px; max-width:110px;" src='{{ $image }}'>
                            </div>

                        </div>
                        <div style="width: 50%; float: left;">
                            <div class="font-xs text-center">
                                {{ $sale_code }}
                            </div>
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
                        <div style="overflow: hidden;height: 15px;">
                            @php
                            $colour = [0, 0, 0];
                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                            echo '<img style="height: 15px;"  src="data:image/png;base64,' .
                                base64_encode(
                                    $generator->getBarcode(
                                        $barcode,
                                        $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                    ),
                                ) .
                                '">';
                        @endphp
                        </div>
                        <div style="text-align:center;font-size:8px;margin:0px;padding:0px;">
                            {{ $barcode }}
                        </div>
                       
                    </div>
                </div>
            </div>

        </div>
    @endfor
    {{-- @if (!empty($image))
        <table width="100%" autosize="1">
            @php
                $jj = 0;
                $per_page = $paper;
            @endphp
            @for ($i = 0; $i < $stock; $i += $paper)
                <tr>
                    @for ($j = 0; $j < $paper; $j++)
                        @php
                            $jj++;
                        @endphp

                        @if ($type == 1)
                            <td id="image">

                                @php
                                    if ($jj - 1 < $stock) {
                                        echo '<img style="height: 110px; max-width:110px;" src=' . $image . '>';
                                    }
                                @endphp

                            </td>


                            <td id="content" style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                                <div class="sale_code">
                                    {{ $sale_code }}
                                </div>
                                <div>{{ $description }}</div>
                                <div>{{ $price }}</div>
                                <p>
                                    @php
                                        if ($jj - 1 != $stock) {
                                            $colour = [0, 0, 0];
                                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                        
                                            echo '<img   style="height: 20px"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8)) . '">';
                                        }
                                    @endphp
                                </p>
                                <div style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                                    {{ $barcode }}
                                </div>
                                <table width="100%" style="border-collapse: collapse;padding-right:30px !important">
                                    <tr>
                                        <td style=" text-align: left;" width="50%">
                                            @php
                                                if ($location != null) {
                                                    echo $location;
                                                }
                                            @endphp

                                        </td>
                                        <td style={{ $jj - 1 < $stock ? 'color:black;text-align: right;' : 'color:white;text-align: right;' }}
                                            width="50%">
                                            {{ $purchase_code }}

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @else
                        <td style="text-align:center;">
                            <table width="80%" autosize="1">
                                <tr>
                                    <td id="image">

                                        @php
                                            if ($jj - 1 < $stock) {
                                                echo '<img style="height: 90px; " src=' . $image . '>';
                                            }
                                        @endphp

                                    </td>

                                </tr>
                                <tr>
                                    <td class="text-center font-sm">
                                        {{ $description }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @php
                                            if ($jj - 1 != $stock) {
                                                $colour = [0, 0, 0];
                                                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                            
                                                echo '<img   style="width:160px;height: 30px;"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8)) . '">';
                                            }
                                        @endphp
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center font-sm">
                                        {{ $barcode }}
                                    </td>
                                </tr>
                        
                            </table>
                          </td>
                            @endif
                    @endfor
                </tr>
            @endfor
        </table>
    @else
        <table width="100%" style="">
            @php
                $jj = 0;
                $per_page = $paper;
            @endphp
            @for ($i = 0; $i < $stock; $i += $paper)
                <tr>
                    @for ($j = 0; $j < $paper; $j++)
                        @php
                            $jj++;
                        @endphp


                        <td id="content" style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                            <div class="sale_code">
                                {{ $sale_code }}
                            </div>
                            <div>{{ $description }}</div>
                            <p>
                                @php
                                    if ($jj - 1 != $stock) {
                                        $colour = [0, 0, 0];
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                    
                                        echo '<img style="height: 30px;width:110px+
                    "  src="data:image/png;base64,' .
                                            base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8)) .
                                            '">';
                                    }
                                @endphp
                            </p>
                            <div style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                                {{ $barcode }}
                            </div>
                            <table width="100%" style="border-collapse: collapse;padding-right:30px !important">
                                <tr>
                                    <td style=" text-align: left;" width="50%">
                                        @php
                                            if ($location != null) {
                                                echo $location;
                                            }
                                        @endphp

                                    </td>
                                    <td style={{ $jj - 1 < $stock ? 'color:black;text-align: right;' : 'color:white;text-align: right;' }}
                                        width="50%">
                                        {{ $purchase_code }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>

    @endif --}}
</body>

</html>
