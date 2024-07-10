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
            width: 125px;
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
            font-size: 10px;
        }

        .font-xs {
            font-size: 6px;
        }

        .font-md {
            font-size: 12px;
        }

        .font-lg {
            font-size: 14px;
        }
    </style>
</head>

<body>
    @if (!empty($image))
        <div width="100%" autosize="1">
            @php
                $jj = 0;
                $per_page = $paper;
            @endphp
            @for ($i = 0; $i < $stock; $i += $paper)
                @for ($j = 0; $j < $paper; $j++)
                    @php
                        $jj++;
                    @endphp
                  <div style="width: 50%; float: left;">
                            <div id="image">

                                    @php
                                        if ($jj - 1 < $stock) {
                                            echo '<img style="height: 25px; " src=' . $image . '>';
                                        }
                                    @endphp


                            </div>

                            <div class="text-center font-xs">
                                {{ $description }}

                            </div>

                            <div class="text-center">
                                @php
                                    if ($jj - 1 != $stock) {
                                        $colour = [0, 0, 0];
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                                        echo '<img   style="width:50px;height: 15px;"  src="data:image/png;base64,' .
                                            base64_encode(
                                                $generator->getBarcode(
                                                    $barcode,
                                                    $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                                ),
                                            ) .
                                            '">';
                                    }
                                @endphp

                            </div>

                            <div class="text-center font-xs">
                                {{ $barcode }}

                            </div>

                        </div>
                @endfor
            @endfor
        </div>
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

                                        echo '<img style="height: 30px;width:150px+
                    "  src="data:image/png;base64,' .
                                            base64_encode(
                                                $generator->getBarcode(
                                                    $barcode,
                                                    $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                                ),
                                            ) .
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

    @endif
</body>

</html>
