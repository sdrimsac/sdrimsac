<!DOCTYPE html>
<html lang="es">
    <head>
    </head>
    <body>
        @if(!empty($record))
            <div class="">
                <div class=" ">
                    <table class="table" width="100%">
                        @php
                            function withoutRounding($number, $total_decimals) {
                                $number = (string)$number;
                                if($number === '') {
                                    $number = '0';
                                }
                                if(strpos($number, '.') === false) {
                                    $number .= '.';
                                }
                                $number_arr = explode('.', $number);

                                $decimals = substr($number_arr[1], 0, $total_decimals);
                                if($decimals === false) {
                                    $decimals = '0';
                                }

                                $return = '';
                                if($total_decimals == 0) {
                                    $return = $number_arr[0];
                                } else {
                                    if(strlen($decimals) < $total_decimals) {
                                        $decimals = str_pad($decimals, $total_decimals, '0', STR_PAD_RIGHT);
                                    }
                                    $return = $number_arr[0] . '.' . $decimals;
                                }
                                return $return;
                            }
                         
                        @endphp
                        @php
                          $jj=0;
                          @endphp                        
                        @for($i=0; $i <$stock; $i+=2)
                         <tr>
                            @for($j=0; $j < 2; $j++)
                            @php
                            $jj++;
                            @endphp
                            @if(($stock % 2) == 0)
                            <td width="33%" style="text-align: center;font-size: 10px;font-family:Arial, Helvetica, sans-serif;font-weight: bold;">
                            <p style="text-align:right !important;float:right !important;">CV{{withoutRounding($record->purchase_unit_price, 0)}}15 </p>
                            <p>{{$record->description}}</p>
                                <p>
                                    @php
                                        $colour = [0,0,0];
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                        echo '<img style="height: 21px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($record->barcode, $generator::TYPE_CODE_128, 1, 60, $colour)) . '">';
                                    @endphp
                                </p>
                                <p >{{$record->barcode}}</p>
                                <div style="text-align:right !important;width: 100px !important;display: inline-block;border:1px solid #000">
                                    <table width="88%" border="0" cellspacing="0" cellpadding="0" 
                                        style="border-collapse: collapse;float: right !important;text-align:right;font-size: 10px;padding-right:30px !important">
                                        <tr>
                                            <td>
                                            {{withoutRounding($record->sale_unit_price, 2)}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                             </td>
                            @else
                            @if($jj!=$stock)
                            <td width="33%" style="text-align: center;font-size: 10px;font-family:Arial, Helvetica, sans-serif;font-weight: bold;">
                            <p style="text-align:right !important;float:right !important;">CV{{withoutRounding($record->purchase_unit_price, 0)}}15 </p>
                            <p>{{$record->description}}</p>
                             
                                <p>
                                    @php
                                        $colour = [0,0,0];
                                        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                        echo '<img style="height: 21px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($record->barcode, $generator::TYPE_CODE_128, 1, 60, $colour)) . '">';
                                    @endphp
                                </p>
                                <p >{{$record->barcode}}</p>
                                <div style="text-align:right !important;width: 100px !important;display: inline-block;border:1px solid #000">
                                    <table width="88%" border="0" cellspacing="0" cellpadding="0" 
                                        style="border-collapse: collapse;float: right !important;text-align:right;font-size: 10px;padding-right:30px !important">
                                        <tr>
                                            <td>
                                            {{withoutRounding($record->sale_unit_price, 2)}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                             </td>
                             @endif
                            @endif                            
                            @endfor
                        </tr>
                        @endfor
                    </table>
                </div>
            </div>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>
