<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 0;
            padding: 0;
            size: 50mm 25mm;
        }
        .label-container {
            width: 50mm;
            height: 25mm;
            text-align: center;
            padding: 1mm;
            box-sizing: border-box;
        }
        .image-section {
            height: 7mm;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1mm;
        }
        .description-section {
            height: 5mm;
            font-size: 6px;
            overflow: hidden;
            margin: 0.5mm 0;
        }
        .barcode-section {
            height: 8mm;
            margin-top: -2mm;
        }
        .barcode-number {
            font-size: 8px;
            margin-top: 0.2mm;
        }
    </style>
</head>
<body>
    @for ($i = 0; $i < $stock; $i++)
        <div class="label-container">
            {{-- Image Section --}}
            <div class="image-section">
                <img style="height: 20px; width: 100px;" src="{{ $image }}">
            </div>

            {{-- Description Section --}}
            <div class="description-section">
                {{ substr($description, 0, 60) }}
            </div>
            <div class="barcode-section">
                @php
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img style="height: 20px; width: 90px;" src="data:image/png;base64,' .
                        base64_encode(
                            $generator->getBarcode(
                                $barcode,
                                $is_code_128 ? $generator::TYPE_CODE_128 : $generator::TYPE_EAN_8,
                            ),
                        ) .
                        '">';
                @endphp
                <div class="barcode-number">{{ $barcode }}</div>
            </div>
        </div>
    @endfor
</body>
</html>
