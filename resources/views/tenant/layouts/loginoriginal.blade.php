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
    @if ($vc_company!=null)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>

    @endif
    <title>
        @if($vc_company->trade_name!=null || $vc_company->slogan!=null)
            {{$vc_company->trade_name}} - {{$vc_company->slogan}}
        @else
            SDRIMSAC-STORE
        @endif
    </title>
    <!-- Google font-->
    @if ($vc_company->favicon)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>
    @else
      <link rel="icon" type="image/ico" href="{{ asset('acorn/img/favicon/TuNegocioFavicon.png') }}" sizes="32x32" />
    @endif
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ asset('acorn/img/favicon/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('acorn/img/favicon/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('acorn/img/favicon/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('acorn/img/favicon/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('acorn/img/favicon/mstile-310x310.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (env('APP_ENV')=='production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_header.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('acorn/font/CS-Interface/style.css') }}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/OverlayScrollbars.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2-bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/bootstrap-datepicker3.standalone.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/tagify.css') }}" />
    <link rel="stylesheet"  href="{{ asset('acorn/css/icofont.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/main.css') }}" />
    <script src="{{ asset('acorn/js/base/loader.js') }}"></script> 
    @laravelPWA
</head>
 
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">
        <div class="loader-p"></div>
      </div>
    </div>
     <!-- page-wrapper Start-->
     <section>
      <div class="container-fluid">
        <div class="row">
    @if($company->logo==null || $company->logo=="")     
        <div class="col-xl-12 order-1" style="background-image: url({{ asset('img/restaurant.png')}}) ;
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-position: top center;
         height:100vh;
         -webkit-background-size: cover;
         -moz-background-size: cover;
         -o-background-size: cover;">
        @else   
          <div class="col-xl-12 order-1" style="background-image: url({{ asset('storage/uploads/img_bg/'.$company->img_bg)}}) ;
           background-repeat: no-repeat;
           background-attachment: fixed;
           height:100vh;
           background-position: top center;
           -webkit-background-size: cover;
           -moz-background-size: cover;
           -o-background-size: cover;">
       
       
        @endif
        <!-- <div class="col-xl-12 order-1" style="background-color:#ffff;"> -->
            <div id="main">
                 @yield('content')
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- Search Modal End -->
    <!-- Vendor Scripts Start -->
       <!-- Vendor Scripts Start -->
    <script src="{{ asset('acorn/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('acorn/js/cs/scrollspy.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/tagify.min.js') }}"></script>
    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="{{ asset('acorn/font/CS-Line/csicons.min.js') }}"></script>
    <script src="{{ asset('acorn/js/base/helpers.js') }}"></script>
    <script src="{{ asset('acorn/js/base/globals.js') }}"></script>
    <script src="{{ asset('acorn/js/base/nav.js') }}"></script>
    <script src="{{ asset('acorn/js/base/search.js') }}"></script>
    <script src="{{ asset('acorn/js/base/settings.js') }}"></script>
    <script src="{{ asset('acorn/js/base/init.js') }}"></script>
    <!-- Template Base Scripts End -->
    <!-- Page Specific Scripts Start -->
    <script src="{{ asset('acorn/js/forms/layouts.js') }}"></script>
    <script src="{{ asset('acorn/js/common.js') }}"></script>
    <script src="{{ asset('acorn/js/scripts.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
  
</body>
</html>
