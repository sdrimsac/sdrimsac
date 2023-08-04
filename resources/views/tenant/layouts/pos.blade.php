<!DOCTYPE html>
<html lang="en" data-footer="true">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>
        @if ($vc_company->trade_name != null || $vc_company->slogan != null)
            {{ $vc_company->trade_name }} - {{ $vc_company->slogan }}
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
        <link rel="shortcut icon" href="{{ asset('storage/uploads/favicon/' . $vc_company->favicon) }}"
            type="image/x-icon" />
    @else
        <link rel="icon" type="image/ico" href="{{ asset('acorn/img/favicon/copa.ico') }}" sizes="32x32" />
    @endif
    <meta name="application-name" content="SDRIMSAC-STORE" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ asset('acorn/img/favicon/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('acorn/img/favicon/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('acorn/img/favicon/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('acorn/img/favicon/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('acorn/img/favicon/mstile-310x310.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (env('APP_ENV') == 'production')
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
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('icofont/icofont.min.css') }}">
    <script src="{{asset('socket/socket_io.js')}}"></script>
    <!-- Vendor Styles End -->
    <!-- Template Base Styles Start -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_header.css') }}">
    <link rel="stylesheet" href="{{ asset('acorn/css/styles.css') }}" />
    <!-- Template Base Styles End -->
    <link rel="stylesheet" href="{{ asset('acorn/css/main.css') }}" />
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
                                    <img src="{{ asset('storage/uploads/logos/' . $vc_establishment->logo) }}" />
                                @else
                                    @if ($vc_company->logo)
                                        <img src="{{ asset('storage/uploads/logos/' . $vc_company->logo) }}" />
                                    @else
                                        <img style="max-width: 180px  ; max-height: 75px "
                                            src="{{ asset('acorn/img/logo/logo-light.svg') }}" class="icono" />
                                    @endif
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Logo End -->

                <!-- User Menu Start -->
                <div class="user-container d-flex" style="max-width: 250px ;max-height: 120px;">
                    <div class="name " style="color: var(--light-text);                    line-height: 1;">
                        {{ $vc_user->name }} <br>

                        @if ($vc_company->soap_type_id == '01')
                            <span style="margin-top:10px !important;font-weight: 900;">DEMO</span>
                        @elseif($vc_company->soap_type_id == '02')
                            <span
                                style="margin-top:10px !important;color: #28a745 !important;font-weight: 900;">PRODUCCIÓN</span>
                        @else
                            <span style="margin-top:10px !important;">INTERNO</span>
                        @endif
                    </div>
                    <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img style="width:90%;height:90%" class="profile" alt="profile"
                            src="{{ asset('acorn/img/profile/store.png') }}" />
                        
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-menu wide">

                        <div class="row  ms-0 me-0">
                            <div class="col-12 pe-1 ps-1">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                                            <span class="align-middle">Cerrar Sesión</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Menu End -->

                <!-- Icons Menu Start -->
                {{-- <ul class="list-unstyled list-inline text-center menu-icons">
             <li class="list-inline-item">
              <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
                <i data-cs-icon="search" data-cs-size="18"></i>
              </a>
            </li> 
            <li class="list-inline-item">
              <a href="#" id="pinButton" class="pin-button">
                <i data-cs-icon="lock-on" class="unpin" data-cs-size="18"></i>
                <i data-cs-icon="lock-off" class="pin" data-cs-size="18"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#" id="colorButton">
                <i data-cs-icon="light-on" class="light" data-cs-size="18"></i>
                <i data-cs-icon="light-off" class="dark" data-cs-size="18"></i>
              </a>
            </li>
          </ul> --}}
                <!-- Icons Menu End -->

                <!-- Menu Start -->
                @include('tenant.layouts.partials.sidebar_pos')
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
                    <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- <a href="#" id="mobileMenuButton" class="menu-button" aria-haspopup="true" data-bs-toggle="dropdown"> --}}
                        <i data-cs-icon="menu"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-menu wide">

                        <div class="row  ms-0 me-0">
                            <div class="col-12 pe-1 ps-1">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i data-cs-icon="logout" class="me-2" data-cs-size="17"></i>
                                            <span class="align-middle">Cerrar Sesión</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Button End -->
                </div>
                <!-- Mobile Buttons End -->
            </div>
            <div class="nav-shadow"></div>
        </div>

        <main>
            <div id="main">
                @yield('content')
            </div>
        </main>
        @if ($vc_user->type == 'superadmin')
            <!-- Theme Settings Modal Start -->
            <div class="modal fade modal-right scroll-out-negative" id="settings" data-bs-backdrop="true"
                tabindex="-1" role="dialog" aria-labelledby="settings" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable full" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajustes de tema</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="scroll-track-visible">
                                <div class="mb-5" id="color">
                                    <label class="mb-3 d-inline-block form-label">Color</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="light-blue"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="blue-light"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">AZUL CLARO</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-blue"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="blue-dark"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">AZUL OSCURO</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="light-red"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="red-light"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">LUZ ROJA</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-red"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="red-dark"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">ROJO OSCURO</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                                        <a href="#" class="flex-grow-1 w-50 option col"
                                            data-value="light-green" data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="green-light"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">VERDE CLARO</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-green"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="green-dark"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">VERDE OSCURO</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                                        <a href="#" class="flex-grow-1 w-50 option col"
                                            data-value="light-purple" data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="purple-light"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">MORADO CLARO</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col"
                                            data-value="dark-purple" data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="purple-dark"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">MORADO OSCURO</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="light-pink"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="pink-light"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">ROSADO CLARO</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-pink"
                                            data-parent="color">
                                            <div class="card rounded-md p-3 mb-1 no-shadow color">
                                                <div class="pink-dark"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">ROSADO OSCURO </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-5" id="navcolor">
                                    <label class="mb-3 d-inline-block form-label">Anular paleta de navegación</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap">
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="default"
                                            data-parent="navcolor">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">por defecto</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="light"
                                            data-parent="navcolor">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-secondary figure-light top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Claro</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="dark"
                                            data-parent="navcolor">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-muted figure-dark top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Oscuro</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-5" id="placement">
                                    <label class="mb-3 d-inline-block form-label">Ubicación de Menu</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="horizontal"
                                            data-parent="placement">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Horizontal</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="vertical"
                                            data-parent="placement">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary left"></div>
                                                <div class="figure figure-secondary right"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Vertical</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-5" id="behaviour">
                                    <label class="mb-3 d-inline-block form-label">Comportamiento de Menu</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="pinned"
                                            data-parent="behaviour">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary left large"></div>
                                                <div class="figure figure-secondary right small"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Fijo</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="unpinned"
                                            data-parent="behaviour">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary left"></div>
                                                <div class="figure figure-secondary right"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">Sin Fijar</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-5" id="layout">
                                    <label class="mb-3 d-inline-block form-label">Radio</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap">
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="fluid"
                                            data-parent="layout">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">FLUID</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-50 option col" data-value="boxed"
                                            data-parent="layout">
                                            <div class="card rounded-md p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom small"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">BOXED</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-5" id="radius">
                                    <label class="mb-3 d-inline-block form-label">Radius</label>
                                    <div class="row d-flex g-3 justify-content-between flex-wrap">
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="rounded"
                                            data-parent="radius">
                                            <div class="card rounded-md radius-rounded p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">ROUNDED</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="standard"
                                            data-parent="radius">
                                            <div class="card rounded-md radius-regular p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">STANDARD</span>
                                            </div>
                                        </a>
                                        <a href="#" class="flex-grow-1 w-33 option col" data-value="flat"
                                            data-parent="radius">
                                            <div class="card rounded-md radius-flat p-3 mb-1 no-shadow">
                                                <div class="figure figure-primary top"></div>
                                                <div class="figure figure-secondary bottom"></div>
                                            </div>
                                            <div class="text-muted text-part">
                                                <span class="text-extra-small align-middle">FLAT</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn settings-button btn-gradient-primary" data-bs-toggle="modal"
                data-bs-target="#settings" id="settingsButton">
                <i data-cs-icon="paint-roller" class="position-relative"></i>
            </button>
            <!-- Theme Settings Modal End -->
            @endif
        <!-- Layout Footer Start -->
        <footer>
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            @php
                            $commit = exec('git rev-parse HEAD');
                            $commit = substr($commit, 0, 7);
                        @endphp
                        <p class="mb-0 text-muted text-medium" style="text-align: right ; color:darkblue ">
                        @if ($commit)
                        <span style="margin-right: 35px;">Commit: {{$commit}}</span>
                        @endif
                        <span>Todos
                            los derechos reservados por Sdrimsac Solutions E.I.R.L {{ date('Y') }} <i
                                class="far fa-copyright"></i></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Layout Footer End -->
    </div>

    <style>
        @media (min-width: 320px) and (max-width: 768px) {

            .card .card-body,
            .card .card-footer,
            .card .card-header {
                padding: 5px !important;
            }

            .card-body {
                padding: 0px !important;
            }

            .el-dialog {
                width: 100% !important;
            }

            .el-date-editor.el-input,
            .el-date-editor.el-input__inner {
                max-width: 142px;
            }

            .btn_responsive {
                width: 25% !important;
            }
        }
    </style>
    <!-- Vendor Scripts Start -->
    <script src="{{ asset('acorn/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/chartjs-plugin-rounded-bar.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/glide.min.js') }}"></script>
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
    <script src="{{ asset('acorn/js/cs/glide.custom.js') }}"></script>
    <script src="{{ asset('acorn/js/cs/charts.extend.js') }}"></script>
    <script src="{{ asset('acorn/js/pages/dashboard.default.js') }}"></script>
    <script src="{{ asset('acorn/js/common.js') }}"></script>

    <script src="{{ asset('acorn/js/scripts.js') }}"></script>
    <script src="{{ asset('qz/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script src="{{ asset('qz/dependencies/sha-256.min.js') }}"></script>
    <script src="{{ asset('qz/qz-tray.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
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
    <!-- Page Specific Scripts End -->
</body>

</html>
