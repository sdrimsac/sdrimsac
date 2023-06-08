
<html >

    <head>
        <style>
            table{
            font-size: 15px;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
          }
          #general{
            text-align: center;
            width:230px;
            height: 215px;
         
          }
        </style>
    </head>
  
    <body>
    
        
                    <table  width="100%">
                        @php
                          $jj=0;
                          $per_page = $paper == 1 ? 2 : 4;
                          @endphp
                        @for($i=0; $i <$stock; $i+=$per_page)
                         <tr >
                            
                            @for($j=0; $j <$per_page; $j++)
                            @php
                            $jj++;
                            @endphp
                            
                          
                            
                              <td id="general">
                                <div>
                                  @php
                                  if($jj-1<$stock){
                                  
                                  
                                   
                                          echo '<img style="height: 50px; width:50px;" src='. $image . '>';
                                      
                                  }
                              @endphp
                                </div>
                                <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
  <span>{{$sale_code}}</span>
                                </div>
                                <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                                  <span>{{$description}}</span>
                                </div>
                                <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
  
                                </div>
                             <div>
                              @php
                              if($jj-1<$stock){
                                  $colour = [0,0,0] ;
                              $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                              
                              echo '<img style="height: 25px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode,$is_code_128 ?$generator::TYPE_CODE_128 :  $generator::TYPE_EAN_8)) . '">';
                              }
                          @endphp
                             </div>
                             <div  style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                              {{$barcode}}
                             </div>
                             <div style="text-align:right !important;width: 100% !important;display: inline-block;border:1px solid #000">
                              <table width="88%" border="0" cellspacing="0" cellpadding="0"
                              style="border-collapse: collapse;float: right !important;text-align:right;padding-right:30px !important">
                              <tr>
                                  <td>
                                      <p 
                                      style={{$jj-1<$stock ? 'color:black;text-align: right; !important;':'color:white;text-align: right !important;'}}
                                      
                                 > {{$purchase_code}}</p>
                                 
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
  
  
  