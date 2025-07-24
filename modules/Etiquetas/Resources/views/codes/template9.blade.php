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
            width: 50px;
            height: 25px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <table>
        @php
            $jj = 0;
            $per_page = 1; // Solo una etiqueta por fila
        @endphp
        @for ($i = 0; $i < $stock; $i += $per_page)
            <tr>
                @for ($j = 0; $j < $per_page; $j++)
                    @php
                        $jj++;
                    @endphp
                    <td id="general">
                        <div>
                            @php
                                if ($jj - 1 < $stock) {
                                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                    echo '<img style="height: 20px;" src="data:image/png;base64,' . base64_encode(
                                        $generator->getBarcode(
                                            $barcode,
                                            $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                                        )
                                    ) . '">';
                                }
                            @endphp
                        </div>
                        <div style="{{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}">
                            {{ $barcode }}
                        </div>
                        <span></span>
                        <div style="{{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}">
                            <span>S/. {{ $sale_code }}</span>
                        </div>
                        <div style="{{ $jj - 1 < $stock ? 'color:black;' : 'color:white;' }}">
                            <span>{{ $description }}</span>
                        </div>
                    </td>
                @endfor
            </tr>
        @endfor
    </table>
</body>

</html>
