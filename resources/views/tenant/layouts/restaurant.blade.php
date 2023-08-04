<?php
    //dd("abcde");
?>
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
    @if (env('APP_ENV')=='production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    @if ($vc_company->favicon)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>
    @else
      <link rel="icon" type="image/ico" href="{{ asset('acorn/img/favicon/copa.ico') }}" sizes="32x32" />
    @endif
    <title>
        @if($vc_company->trade_name!=null || $vc_company->slogan!=null)
          {{$vc_company->trade_name}} - {{$vc_company->slogan}}
        @else
            SDRIMSAC-STORE
        @endif
    </title>
    
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/vector-map.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('viho/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />


   <style>
    .font-roboto,.pull-right,span,th,td,.dropdown-item,tr,.el-input__inner::placeholder,.el-input__inner,.footer-copyright,.el-collapse-item__header,.el-dialog__title,.el-tabs__item, .is-top,.is-active ,h1,h2,h3,h4,h5,h6,p a, a:link,a:hover{
    	font-family: "Comfortaa",sans-serif !important;
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
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <div class="main-header-right row m-0">
          <div class="main-header-left">
            <div class="logo-wrapper">
                <!-- <a href="/dashbord">
                    <img class="img-fluid" src="{{ asset('viho/assets/images/logo/logo.png') }}" alt="">
                </a> -->
                <a href="{{route('tenant.dashboard.index')}}">
                    @if($vc_company->logo)
                        <img src="{{ asset('storage/uploads/logos/'.$vc_company->logo) }}"  class="icono" width="80" height="30"/>
                    @else
                       <img src="{{ asset('acorn/img/logo/logo-light.svg') }}"  class="icono"/>
                    @endif
                </a>

            </div>
            <div class="dark-logo-wrapper"><a href="/dashboard"><img class="img-fluid" src="{{ asset('viho/assets/images/logo/dark-logo.png') }}" alt=""></a></div>
            @if($vc_company->soap_type_id == "01")
                <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif">
                <div class="switch switch-sm switch-primary" data-toggle="tooltip" data-placement="bottom" title="SUNAT: ENTORNO DE DEMOSTRACIÓN, pulse para ir a configuración">

                    <div class="ios-switch off">
                        <div class="on-background background-fill"></div>
                        <div class="state-background background-fill"></div>
                        <div class="handle"></div>
                    </div>
                    <input type="checkbox" name="switch" data-plugin-ios-switch="" checked="checked" style="display: none;">
                </div>
                </a>
                @elseif($vc_company->soap_type_id == "02")
                <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif">
                <div class="switch switch-sm switch-success"  data-toggle="tooltip" data-placement="bottom" title="SUNAT: ENTORNO DE PRODUCCIÓN, pulse para ir a configuración">
                    <div class="ios-switch on">
                        <div class="on-background background-fill"><span class="text-white ml-1" style="font-size: 9px;">&nbsp;&nbsp;PROD.</span></div>
                        <div class="state-background background-fill"></div>
                        <div class="handle_on"></div>
                    </div>
                    <input type="checkbox" name="switch" data-plugin-ios-switch="" checked="checked" style="display: none;">
                </div>
                </a>
                @else
                <a href="@if(in_array('configuration', $vc_modules)){{route('tenant.companies.create')}}@else # @endif">
                <div class="switch switch-sm switch-info"  data-toggle="tooltip" data-placement="bottom" title="INTERNO: ENTORNO DE PRODUCCIÓN, pulse para ir a configuración">
                    <div class="ios-switch on">
                        <div class="on-background background-fill"><span class="text-white ml-1" style="font-size: 9px;">&nbsp;&nbsp;INTERNO</span></div>
                        <div class="state-background background-fill"></div>
                        <div class="handle"></div>
                    </div>
                    <input type="checkbox" name="switch" data-plugin-ios-switch="" checked="checked" style="display: none;">
                </div>
                </a>
                @endif
                <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>

          </div>

          <div class="nav-right col pull-right right-menu p-0">
                @if (auth()->user()->type != 'seller')
                    @include('tenant.layouts.partials.header_pos')
                @endif
          </div>
          <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
        </div>
      </div>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        @if (auth()->user()->type != 'seller')
                @include('tenant.layouts.partials.sidebar_pos')
        @endif
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-default-sec">
            <div class="row">
              <div class="col-12">
                <div id="main">
                             @yield('content')
                </div>
              </div>


            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2022 © Todos los derechos reservados.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Desarrollado por GRUPOPCSYSTEMS</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
   <!-- latest jquery-->
   <script src="{{ asset('viho/assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('viho/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('viho/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('viho/assets/js/sidebar-menu.js') }}"></script>
    <!-- <script src="{{ asset('viho/assets/js/config.js') }}"></script> -->
    <!-- Bootstrap js-->
    <script src="{{ asset('viho/assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('viho/assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- Plugins JS start-->
     <script src="{{ asset('viho/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
     <script src="{{ asset('viho/assets/js/notify/bootstrap-notify.min.js') }}"></script>
    <!-- <script src="{{ asset('viho/assets/js/dashboard/default.js') }}"></script> -->
    <script src="{{ asset('viho/assets/js/notify/index.js') }}"></script>
    <script src="{{ asset('viho/assets/js/script.js') }}"></script>
    <script src="{{ asset('viho/assets/js/theme-customizer/customizer.js') }}"></script>
     <script src="{{ asset('qz/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script src="{{ asset('qz/dependencies/sha-256.min.js') }}"></script>
    <script src="{{ asset('qz/qz-tray.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      document.addEventListener('keydown', function(event) {
          if (event.keyCode === 120) {
              if ("caches" in window) {
                  caches.keys().then(function(cacheNames) {
                      console.log(cacheNames);
                      cacheNames.forEach(function(cacheName) {
                          caches.delete(cacheName);
                      });
                  });
              }

              navigator.serviceWorker
                  ?.getRegistrations()
                  .then(function(registrations) {
                      console.log(registrations);
                      for (let registration of registrations) {
                          registration.unregister();
                      }
                  });
                 

                  setTimeout(() => {
                      window.location.reload();
                  }, 1000);
          }
      });
    </script>
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
    @stack('scripts')
  </body>
</html>
