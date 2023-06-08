<!DOCTYPE html>
<html lang="es">
    <head>
    </head>
    <body>
        
                    <table class="table" style="font-size:6.5px;font-family:Arial, Helvetica, sans-serif;font-weight: bold; " width="100%">
                       
                        @php
                          $jj=0;
                          $per_page = $paper;
                       
                          @endphp
                        @for($i=0; $i <$stock/$paper; $i+=2)
                         <tr height="50%">
                            @for($j=0; $j < $per_page*2; $j++)
                            @php
                            $jj++;
                            @endphp
                         
                           <td width="7%" height={{$is_code_128 ?( is_numeric($barcode)  ?"45px":"53px") :"45px"}} style="text-align:center; line-height: 50px !important; overflow: hidden; ">
                      <div style="height:350px !important;">
                        <table>
                            <tr>
                                <td>
                                    <div style="overflow: hidden;" >
                                        @php
                                 
                                            
                                 if($jj-1<$stock){
                                        echo '<img style="height: 20px ; width: 20px ;" src='. $image . '>';
                                 }
                                    @endphp
                                 
                                       </div>
                                </td>
                                <td> <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                                    <span >{{$sale_code ."-". $jj}}</span>
                          
                                    @php
                                  if($jj-1<$stock){
                                    $colour = [0,0,0] ;
                                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                                    
                                    echo '<img style="max-height: 14px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 :$generator::TYPE_EAN_8,3,57)) . '">';
                                    }
                                        
                                    
                                @endphp
                                  <p >
    {{$barcode}}
                                </p>
                                <span >{{$purchase_code}}</span>
                                </div>

                                </td>
                            </tr>
                         </table>
                      </div>
                           
                           </td>
                        
                           
                            @endfor
                        </tr>
                       
                        @endfor
                    </table>
             
         
        
        
    </body>
</html>
