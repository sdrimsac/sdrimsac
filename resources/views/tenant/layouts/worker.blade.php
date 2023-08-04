<!DOCTYPE html>
<html lang="en" data-footer="true">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>
        @if($vc_company->trade_name!=null || $vc_company->slogan!=null)
            {{$vc_company->trade_name}} - {{$vc_company->slogan}}
        @else
            SDRIMSAC-STORE
        @endif
    </title>
 
    <meta name="description" content="Sistema de Restaurante - Facturaciòn Electronica - GRUPOPCSYSTEMS" />
    {{-- <!-- Favicon Tags Start -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('acorn/img/favicon/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('acorn/img/favicon/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('acorn/img/favicon/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('acorn/img/favicon/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('acorn/img/favicon/apple-touch-icon-60x60.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('acorn/img/favicon/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('acorn/img/favicon/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('acorn/img/favicon/apple-touch-icon-152x152.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('acorn/img/favicon/favicon-196x196.png') }}" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ asset('acorn/img/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ asset('acorn/img/favicon/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('acorn/img/favicon/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('acorn/img/favicon/favicon-128.png') }}" sizes="128x128" /> --}}
    @if ($vc_company->favicon)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>
    @else
      <link rel="icon" type="image/ico" href="{{ asset('acorn/img/favicon/copa.ico') }}" sizes="32x32" />
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
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('acorn/font/CS-Interface/style.css') }}" />
    <!-- Font Tags End -->
    <!-- Vendor Styles Start -->
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/OverlayScrollbars.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('acorn/css/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />

     <link rel="stylesheet" href="{{ asset('acorn/css/vendor/quill.bubble.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2-bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/tagify.css') }}"/>
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/dropzone.min.css') }}" />

    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" href="{{ asset('acorn/css/styles.css') }}" />
    <!-- Template Base Styles End -->
    <link rel="stylesheet" href="{{ asset('acorn/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('porto-light/master/style-switcher/style-switcher.css')}}">
    <script src="{{ asset('acorn/js/base/loader.js') }}"></script>
    @laravelPWA
  </head>

  <body>
    <div id="root">
      <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex justify-content-between">
          <!-- Logo Start -->
          <div class="fix-logo">
            <div class="logo position-relative">
              <a href="javascript:void(0)">
                <!-- Logo can be added directly -->
                <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->
  
                <!-- Or added via css to provide different ones for different color themes -->
                <div class="img">
                  @if (isset($vc_establishment->logo))
                  <img  src="{{ asset('storage/uploads/logos/'.$vc_establishment->logo) }}"/>
                  @else
                     @if($vc_company->logo)
                       <img  src="{{ asset('storage/uploads/logos/'.$vc_company->logo) }}"/>
                     @else
                         <img style="max-width: 80%  ; max-height: 80% " src="{{ asset('acorn/img/logo/logo-light.svg') }}"  class="icono"/>
                     @endif
                  @endif
                </div>
              </a>
            </div>
          </div>
          <!-- Logo End -->

          <!-- User Menu Start -->
          <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img 
              style="width:90%;height:90%"
              class="profile" alt="profile" src="{{ asset('acorn/img/profile/store.png') }}" />
              <div class="name">
                {{ $vc_user->name }} <br>

                @if($vc_company->soap_type_id == "01")
                    <span style="margin-top:10px !important;font-weight: 900;">DEMO</span>
                @elseif($vc_company->soap_type_id == "02")
                    <span style="margin-top:10px !important;color: #28a745 !important;font-weight: 900;">PRODUCCIÓN</span>
                @else
                    <span style="margin-top:10px !important;">INTERNO</span>
                @endif
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end user-menu wide">

              <div class="row  ms-0 me-0">
                <div class="col-12 pe-1 ps-1">
                  <ul class="list-unstyled">
                    <li>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                        <span class="align-middle">Cerrar Sesión</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                           @csrf
                      </form>

                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- User Menu End -->


          <!-- Menu Start -->
          @include('tenant.layouts.partials.sidebar_restaurant')
          <!-- Menu End -->

          <!-- Mobile Buttons Start -->
          <div class="mobile-buttons-container">
            <!-- Scrollspy Mobile Button Start -->
            <a href="#" id="scrollSpyButton" class="spy-button" data-bs-toggle="dropdown">
              <i data-cs-icon="menu-dropdown"></i>
            </a>
            <!-- Scrollspy Mobile Button End -->

            <!-- Scrollspy Mobile Dropdown Start -->
            <div class="dropdown-menu dropdown-menu-end" id="scrollSpyDropdown"></div>
            <!-- Scrollspy Mobile Dropdown End -->

            <!-- Menu Button Start -->
            <a href="#" id="mobileMenuButton" class="menu-button">
              <i data-cs-icon="menu"></i>
            </a>
            <!-- Menu Button End -->
          </div>
          <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
      </div>
        <main style="padding-left:1.5rem !important">
            <div id="main">
                @yield('content')
            </div>
        </main>
        <!-- Layout Footer Start -->
        <footer>
          <div class="footer-content">
            <div class="container">
              <div class="row">
                <div class="col-12 col-sm-12  " >
                    <p class="mb-0 text-muted text-medium" style="text-align: right ; color:darkblue ">Todos los derechos reservados por Sdrimsac Solutions E.I.R.L {{date('Y')}} <i class="far fa-copyright"></i></p> 
                </div>
                 
              </div>
            </div>
          </div>
        </footer>
        <!-- Layout Footer End -->
      </div>

    <!-- Vendor Scripts Start -->


    <script src="{{ asset('acorn/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/imask.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/quill.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/quill.active.js') }}"></script>
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
    <script src="{{ asset('acorn/js/common.js') }}"></script>
    <script src="{{ asset('acorn/js/scripts.js') }}"></script>

    <script src="{{ asset('qz/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script src="{{ asset('qz/dependencies/sha-256.min.js') }}"></script>
    <script src="{{ asset('qz/qz-tray.js') }}"></script>
     <script src="{{ asset('js/app.js') }}"></script>
     <script src="{{ mix('/js/clear_cache.js') }}"></script>
    <!-- Page Specific Scripts End -->
  </body>
</html>
