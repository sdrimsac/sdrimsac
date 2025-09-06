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
            size: 100mm 50mm;
        }

        .label-container {
            width: 100mm;
            height: 50mm;
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
            height: 12mm; /* more room for description on 100x50 */
            font-size: 10px;
            overflow: hidden;
            margin: 1mm 0;
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

            <div class="description-section" style="font-size:22px;">
                {{ substr($description, 0, 60) }}
            </div>
            <div style="text-align:center;font-size:48px;margin:0px;padding:0px;">
                S/. {{ $sale_code }}
            </div>
            <div style="text-align:right;font-size:30px;margin:0px;padding-right:10px;">
                {{ $purchase_code }}
            </div>

        </div>
    @endfor
</body>

</html>
