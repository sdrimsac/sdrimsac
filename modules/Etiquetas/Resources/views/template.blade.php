
<html >

    <head>
      <style>
 body{ margin:0 auto; }
        #image{
          width:125px;
          margin: auto;
          text-align: center;
        } 
        table{
          font-size: 13px;
          font-weight: bold;
          font-family: Arial, Helvetica, sans-serif;
        }
        #content{
          height: 163px;
          width: 225px;
          text-align: center;
        }
        .purchase_code{
          text-align: right !important;
          float: right;
        }
        
        </style>
    </head>
 
    <body>
     @if (!empty($image))
      <table  width="100%"  style="">
          @php
            $jj=0;
            $per_page = $paper;
          @endphp
          @for($i=0; $i <$stock; $i+=$paper)
            <tr>
              @for($j=0; $j < $paper; $j++)
                @php
                  $jj++;
                @endphp
                
                  <td id="image" >
              
                    @php
                      if($jj-1<$stock){
                      
                      
                      
                              echo '<img style="height: 125px; width:125px;" src='. $image . '>';
                      
                      }
                    @endphp
              
                  </td>
              
                
                  <td id="content" style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                        <div class="sale_code">
                          {{$sale_code}}
                        </div>
                  <div>{{$description}}</div>
                  <p>
                    @php
                    if($jj-1!=$stock){
                        $colour = [0,0,0] ;
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    
                    echo '<img   style="height: 20px"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 :$generator::TYPE_EAN_8)) . '">';
                    }
                @endphp
                  </p>
                  <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                    {{$barcode}}
                  </div>
                    <table 
                    width="100%"
                    style="border-collapse: collapse;padding-right:30px !important">
                    <tr>
                      <td style=" text-align: left;" width="50%">
                        @php
                          if($location!=null){
                          echo $location;

                          }
                        @endphp
                  
                    </td>
                        <td style={{$jj-1<$stock ? 'color:black;text-align: right;':'color:white;text-align: right;'}} width="50%">
                            {{$purchase_code}}
                      
                        </td>
                    </tr>
                </table>
                    </td>
              
            
              @endfor
            </tr>
          @endfor
        </table>
        @else
        <table  width="150%"  style="">
          @php
            $jj=0;
            $per_page = $paper;
          @endphp
          @for($i=0; $i <$stock; $i+=$paper)
            <tr>
              @for($j=0; $j < $paper; $j++)
                @php
                  $jj++;
                @endphp
                
                
                  <td id="content" style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                        <div class="sale_code">
                          {{$sale_code}}
                        </div>
                  <div>{{$description}}</div>
                  <p>
                    @php
                    if($jj-1!=$stock){
                        $colour = [0,0,0] ;
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    
                    echo '<img   style="height: 30px"  src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $is_code_128 ? $generator::TYPE_CODE_128 :$generator::TYPE_EAN_8)) . '">';
                    }
                @endphp
                  </p>
                  <div style={{$jj-1<$stock ? 'color:black;':'color:white;'}}>
                    {{$barcode}}
                  </div>
                    <table 
                    width="100%"
                    style="border-collapse: collapse;padding-right:30px !important">
                    <tr>
                      <td style=" text-align: left;" width="50%">
                        @php
                          if($location!=null){
                          echo $location;

                          }
                        @endphp
                  
                    </td>
                        <td style={{$jj-1<$stock ? 'color:black;text-align: right;':'color:white;text-align: right;'}} width="50%">
                            {{$purchase_code}}
                      
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


