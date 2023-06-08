<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($vc_company->favicon)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>
 
    @endif 
    <title>Facturación Electrónica</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
     <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/chartist.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/vector-map.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/style.css') }}">
     <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />
  
   <style>
    .font-roboto,.pull-right,span,th,td,tr,.el-input__inner::placeholder,.el-input__inner,.footer-copyright,.el-collapse-item__header,.el-dialog__title,.el-tabs__item, .is-top,.is-active ,h1,h2,h3,h4,h5,h6,p a, a:link,a:hover{
    	font-family: "Comfortaa",sans-serif !important;
      font-size: 14px !important;
   }
      h5, .h5 {
        font-size: 1.1rem;
    }
   </style>
   @laravelPWA
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start       -->
    <div class="container-fluid dashboard-default-sec">
            <div class="row">
              <div class="col-12"> 
                <div id="main">
                             @yield('content')   
                </div>
              </div>
          
            
            </div>
          </div>
   <!-- latest jquery-->
   <script src="{{ asset('viho/assets/js/jquery-3.5.1.min.js') }}"></script>
    
    <script src="{{ asset('viho/assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('viho/assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('viho/assets/js/chart/chartist/chartist.js') }}"></script>
    <script src="{{ asset('viho/assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
    <script src="{{ asset('viho/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('viho/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
  
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('viho/assets/js/script.js') }}"></script>
    <script src="{{ asset('viho/assets/js/theme-customizer/customizer.js') }}"></script>
    <!-- login js-->
    <!-- Plugin used-->
    
   
    @stack('scripts')
  </body>
</html>