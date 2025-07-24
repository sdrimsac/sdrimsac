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
    @for ($i = 0; $i < $stock; $i += 2)
        <div>
            <div class="" style="height: 60px;">
                <div style="height: 60px;float: left; width:110px; padding: 3px;">
                    <div>
                        <div style="width: 100%;">
                            <div class="text-center"
                                style="width:100%;height:20px;font-size:6px;overflow:hidden;text-align: left;margin: 10px 0 0 0;padding-left: 0;">
                                {{ substr($description, 0, 50) }}
                            </div>
                        </div>
                    </div>
                    <div style="height:13px;width:100%;overflow:hidden;text-align:center;">
                        <div style="text-align:center;font-size:14px;margin:0px;padding:0px;">
                            S/. {{ $sale_code }}
                        </div>
                        <div style="text-align:right;font-size:10px;margin:0px;padding-right:10px;">
                            {{ $purchase_code }}
                        </div>
                    </div>
                </div>
                <div style="height: 60px;float: left; width:110px;">
                    <div style="padding: 5px">
                        <div style="width: 100%;">
                            <div class="text-center"
                                style="width:100%;height:20px;font-size:6px;overflow:hidden;text-align: center;margin: 8px auto 0;">
                                 {{ substr($description, 0, 50) }}
                            </div>
                        </div>
                        <div style="text-align:center;font-size:14px;margin:0px;padding:0px;">
                           S/. {{ $sale_code }}
                        </div>
                        <div style="text-align:right;font-size:10px;margin:0px;padding:0px;">
                            {{ $purchase_code }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
</body>

</html>
