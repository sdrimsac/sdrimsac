<html>

<head>
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }

        @page {
            margin: 0px;
            padding: 0px;
        }

    </style>
</head>

<body>
    @if (!empty($image))
        <div width="98%" style="margin:0;padding:0;">
            @php
                $jj = 0;
                $per_page = $paper;
            @endphp
            @for ($i = 0; $i < $stock; $i += $paper)
                @for ($j = 0; $j < $paper; $j++)
                    @php
                        $jj++;
                    @endphp

                    @if ($type == 1)
                        <div>
                            <div
                                style="width:100%;">
                                <div
                                    style="width:50%;float:left;margin:auto 0;
                                ">
                                    <div style="height: 5px"></div>
                                    @php
                                        if ($jj - 1 < $stock) {
                                            echo '<img style="height: 50px;" src=' . $image . '>';
                                        }
                                    @endphp
                                </div>

                                <div style="width:50%;float:left;">
                                    <div id="content" style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                                        {{-- <div class="sale_code">
                                            {{ $sale_code }}
                                        </div> --}}
                                        <div style="height:35px;font-size:10px;text-align:center;">
                                            {{ $description }}
                                        </div>

                                        {{-- <div style={{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}>
                                            {{ $barcode }}
                                        </div> --}}
                                        {{-- <div width="100%"
                                            style="height:5px; border-collapse: collapse;padding-right:30px !important">
                                            <span style=" text-align: left;" width="50%">
                                                @php
                                                    if ($location != null) {
                                                        echo $location;
                                                    }
                                                @endphp
            
                                            </span>
                                            <span
                                                style={{ $jj - 1 < $stock ? 'color:black;text-align: right;' : 'color:white;text-align: right;' }}
                                                width="50%">
                                                {{ $purchase_code }}
            
                                            </span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div >
                                {{-- <div> --}}
                                <div style="height: 15px">
                                    @php
                                        if ($jj - 1 != $stock) {
                                            $colour = [0, 0, 0];
                                            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                                            echo '<img   style="height: 30px"  src="data:image/png;base64,' .
                                                base64_encode(
                                                    $generator->getBarcode(
                                                        $barcode,
                                                        $is_code_128
                                                            ? $generator::TYPE_CODE_128
                                                            : $generator::TYPE_EAN_8,
                                                    ),
                                                ) .
                                                '">';
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center;width:98%">
                            <div class="width:100%">
                                @php
                                    if ($jj - 1 < $stock) {
                                        echo '<img style="height: 25px;" src=' . $image . '>';
                                    }
                                @endphp
                            </div>

                            <div class="text-center font-xs" style="height:25px;">
                                {{ $description }}
                            </div>

                            <div style="text-align: center;">
                                @php
                                    if ($jj - 1 != $stock) {
                                        $colour = [0, 0, 0];
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                                        echo '<img style="width:98%;height: 20px;" src="data:image/png;base64,' .
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

                            <div class="font-sm" style="height: 5px;">
                                {{ $barcode }}
                            </div>
                        </div>
                    @endif
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
