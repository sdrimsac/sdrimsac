<html>

<head>
    <style>
        table {
            font-size: 10px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
        }

        #general {
            text-align: center;
            width: 120px;
            height: 70px;
            padding: 5px;
        }

        .label-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding-right: 5px;
        }

        .label-left {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .label-left img {
            max-height: 25px;
            max-width: 50px;
        }

        .label-right {
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-left: 5px;
        }

        .label-price {
            font-size: 12px;
            font-weight: bold;
            color: black;
        }

        .label-description {
            font-size: 10px;
            color: black;
        }

        .barcode {
            text-align: center;
            margin-top: 10px;
        }

        .barcode img {
            height: 20px;
        }

        .barcode-number {
            font-size: 10px;
            text-align: center;
            color: black;
        }
    </style>
</head>

<body>
    <table>
        @php
            $jj = 0;
            $per_page = 2; // Solo una etiqueta por fila
        @endphp
        @for ($i = 0; $i < $stock; $i += $per_page)
            <tr>
                @for ($j = 0; $j < $per_page; $j++)
                    @php
                        $jj++;
                    @endphp
                    <td id="general">
                        @if ($jj - 1 < $stock)
                            <div class="">
                                <div style="height: 30px; width:50px;">
                                    <img style="height: 30px; width: 50px;" src="{{ $image }}"
                                        alt="">
                                </div>
                                <div class="label-right" style="float: right;">
                                    <span class="label-price">S/. {{ $sale_code }}</span><br>
                                    <span class="label-description">{{ $description }}</span>
                                </div>
                            </div>
                            <!-- Código de barras -->
                            <div class="barcode">
                                @php
                                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                    echo '<img src="data:image/png;base64,' .
                                        base64_encode(
                                            $generator->getBarcode(
                                                $barcode,
                                                $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                            ),
                                        ) .
                                        '">';
                                @endphp
                            </div>

                            <!-- Número de código de barras -->
                            <div class="barcode-number">
                                <span>{{ $barcode }}</span>
                            </div>
                        @endif
                    </td>
                @endfor
            </tr>
        @endfor
    </table>
</body>

</html>
