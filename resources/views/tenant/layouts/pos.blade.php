<!DOCTYPE html>
<html lang="en" data-footer="true">

<{{-- v --}}head>
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
    <script src="{{ asset('socket/socket_io.js') }}"></script>
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
        {{-- Principal Barra de Caja --}}
        <div id="nav" class="nav-container d-flex">
            <div class="nav-content d-flex justify-content-between">
                <!-- Logo Start -->
                <div class="fix-logo" style="display: flex; align-items: center; height: 100%; margin-right: 24px;">
                    <div class="logo position-relative" style="height: 75px; width: 130px; display: flex; align-items: center;">
                        <a href="javascript:void(0)" style="display: flex; align-items: center; height: 100%; width: 100%;">
                            <div class="img" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                @if (isset($vc_establishment->logo))
                                    <img src="{{ asset('storage/uploads/logos/' . $vc_establishment->logo) }}"
                                         style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;" />
                                @else
                                    @if ($vc_company->logo)
                                        <img src="{{ asset('storage/uploads/logos/' . $vc_company->logo) }}"
                                             style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;" />
                                    @else
                                        <img style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;"
                                             src="{{ asset('logo/logo.png') }}" class="icono" />
                                    @endif
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
                <style>
                    .fix-logo .logo {
                        aspect-ratio: 180/75;
                        width: 180px;
                        max-width: 100vw;
                        height: 75px;
                        max-height: 100px;
                    }
                    .fix-logo .logo .img img {
                        width: 100%;
                        height: 100%;
                        object-fit: contain;
                        aspect-ratio: 180/75;
                        display: block;
                    }
                    @media (max-width: 600px) {
                        .fix-logo .logo {
                            width: 120px;
                            height: 50px;
                        }
                    }
                </style>
                <!-- Logo End -->
                <div>
                    
                </div>
                <!-- User Menu Start -->
                <div class="user-container d-flex flex-row align-items-center justify-content-between" style="width: 100%; max-width: {{ $userWidth ?? '350px' }}; max-height: 120px; gap: 10px;">
                    {{-- Puedes pasar $userWidth desde el controlador para modificar el ancho dinámicamente --}}

                    {{-- Imagen del Usuario --}}
                    <div class="user-image-container ">
                        @php
                            $config = DB::connection('tenant')->table('configurations')->first();
                            $user = auth()->user();
                        @endphp

                        @if ($user && $user->image)
                            @php
                                $imagePath = public_path("storage/uploads/workers/{$user->image}");
                                if (file_exists($imagePath)) {
                                    $imageData = base64_encode(file_get_contents($imagePath));
                                    $mimeType = mime_content_type($imagePath);
                            @endphp
                                    <img src="data:{{ $mimeType }};base64,{{ $imageData }}" 
                                         alt="{{ $user->image }}"
                                         class="profile-image"
                                         loading="lazy">
                            @php
                                } else {
                            @endphp
                                    <img src="/status_images/user.png" 
                                         class="profile-image"
                                         alt="profile"
                                         loading="lazy">
                            @php
                                }
                            @endphp
                        @else
                            <img src="/status_images/user.png" 
                                 class="profile-image"
                                 alt="profile"
                                 loading="lazy">
                        @endif
                    </div>

                    {{-- Nombre del usuario y Tipo --}}
                    <div class="" style="color: var(--light-text); line-height: 1; min-width: 0; max-width: 200px; overflow-wrap: break-word;">
                        @if (strpos($vc_user->name, ' - ') !== false)
                            @php
                                $nameParts = explode(' - ', $vc_user->name);
                            @endphp
                            <br/>
                            <span style="font-weight: bold; font-size: 1rem; margin-top:5px">{{ $nameParts[0] }}</span><br/>
                            <span>{{ $nameParts[1] }}</span>
                        @else
                            {{ $vc_user->name }}
                        @endif
                       
                        @if ($vc_company->soap_type_id == '01')
                            <img 
                                style="width: 90px; height: 30px; object-fit: contain; display: block;" 
                                class="profile" 
                                alt="profile"
                                src="{{ asset('acorn/img/profile/demo.png') }}" />
                        @elseif($vc_company->soap_type_id == '02')
                            <img style="width: 90px; height: 30px; object-fit: contain; display: block;" 
                            class="profile" 
                            alt="profile"
                                src="{{ asset('acorn/img/profile/produccion.png') }}" />
                        @else
                            <img style="width: 90px; height: 30px; object-fit: contain; display: block;" 
                            class="profile" 
                            alt="profile"
                                src="{{ asset('acorn/img/profile/interno.png') }}" />
                        @endif
                    </div>

                    {{-- Logo del Distribuidor --}}
                    <div class="" style="">
                        <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="width: 100px; height: 60px; min-width: 100px; min-height: 60px; max-width: 100px; max-height: 40px; padding: 0; overflow: hidden; align-items: center; justify-content: center;">
                            <img style="width: 100%; height: 100%; object-fit: contain; display: block;" class="profile" alt="profile"
                                src="{{ asset('acorn/img/profile/store.png') }}" />
                        </a>
                        {{-- Menu de usuario Logout y cambio de contraseña --}}
                        <div class="dropdown-menu dropdown-menu-end user-menu p-2" style="background-color: #889199; margin: 0; width: auto; min-width: fit-content;">
                            <div class="row ms-0 me-0">
                                <div class="col-12 pe-1 ps-1">
                                    <ul class="list-unstyled mb-0">
                                        @if ($config->user_edit)
                                            <li class="mb-2">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#changePasswordModal"
                                                    class="btn btn-info align-items-center text-white"
                                                    style="background-color: #1ca497; border-color: #109184; padding: 5px 8px; border-radius: 5px;">
                                                    <i class="fas fa-key me-2"></i>
                                                    <span class="">Cambiar PIN</span>
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="btn btn-danger align-items-center text-white"
                                                style="background-color: #dc3545; border-color: #dc3545; padding: 5px 8px; border-radius: 5px;">
                                                <i class="fas fa-sign-out-alt me-2"></i>
                                                <span class="">Cerrar Sesión</span>
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
                </div>

                {{-- modal para cambiar la contraseñpa del usario caja  --}}
                @auth
                    <div class="modal fade" id="changePasswordModal" tabindex="-1"
                        aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-bs-backdrop="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="changePasswordForm" action="{{ route('update_code') }}" method="POST">
                                    @csrf
                                    <div class="modal-header" style="background-color: #073f68; ">
                                        <h5 class="modal-title" id="changePasswordModalLabel" style="color: white;">Cambiar PIN</h5>
                                        <button type="button" id="closeModal" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" style="filter: invert(1);"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <input type="number" placeholder="Ingrese el PIN de 4 dígitos"
                                                class="form-control bg-white" id="pin" name="pin" required maxlength="4" pattern="\d{4}" inputmode="numeric" autocomplete="off"
                                                oninput="if(this.value.length > 4) this.value = this.value.slice(0,4);" min="0" max="9999" />
                                            {{-- <button class="btn btn-outline-secondary" type="button"
                                                id="showPasswordButton">
                                                Mostrar
                                            </button> --}}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn_cancelarsmall"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn_buscarsmall">Aceptar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth



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
                    <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
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
        </div>
        <div></div>
       

        <main>
            <div id="main">
                @yield('content')
            </div>
        </main>

        {{-- @if ($vc_user->type == 'superadmin')
           
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
            
        @endif --}}
       
        <footer style="margin-top: 0; margin-bottom: 0;">
            

                   
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <img 
                                style="max-width: 100%; max-height: 60px; width: auto; height: auto; object-fit: contain; display: block;" 
                                class="profile" 
                                alt="profile"
                                src="{{ asset('acorn/img/profile/store.png') }}" 
                            />
                        </div>
                        <div class="col-3">
                            <div class="d-flex align-items-center gap-3">
                                <a href="https://www.youtube.com/" target="_blank" rel="noopener" title="YouTube" style="font-size: 2rem;">
                                    <svg width="1em" height="1em" viewBox="0 0 576 512" fill="#FF0000" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M549.655 124.083c-6.281-23.65-24.84-42.208-48.49-48.49C458.281 64 288 64 288 64s-170.281 0-213.165 11.593c-23.65 6.282-42.209 24.84-48.49 48.49C16 166.967 16 256 16 256s0 89.033 10.345 131.917c6.281 23.65 24.84 42.208 48.49 48.49C117.719 448 288 448 288 448s170.281 0 213.165-11.593c23.65-6.282 42.209-24.84 48.49-48.49C560 345.033 560 256 560 256s0-89.033-10.345-131.917zM232 336V176l142.857 80L232 336z"/>
                                    </svg>
                                </a>
                                <a href="https://www.facebook.com/" target="_blank" rel="noopener" title="Facebook" style="font-size: 2rem;">
                                    <svg width="1em" height="1em" viewBox="0 0 320 512" fill="#1877F3" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M279.14 288l14.22-92.66h-88.91V127.91c0-25.35 12.42-50.06 52.24-50.06H293V6.26S259.5 0 225.36 0c-73.22 0-121.09 44.38-121.09 124.72V195.3H22.89V288h81.38v224h100.2V288z"/>
                                    </svg>
                                </a>
                                <a href="https://www.tiktok.com/" target="_blank" rel="noopener" title="TikTok" style="font-size: 2rem;">
                                    <svg width="1em" height="1em" viewBox="0 0 448 512" fill="#000000" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M448,209.9v125.1c0,97.2-78.8,176-176,176S96,432.2,96,335c0-97.2,78.8-176,176-176c12.1,0,24,1.2,35.5,3.5v-59.6h-59.5V0h59.5v59.5h59.5v59.5h-59.5v59.5c-11.5-2.3-23.4-3.5-35.5-3.5c-70.7,0-128,57.3-128,128s57.3,128,128,128s128-57.3,128-128V209.9H448z"/>
                                    </svg>
                                </a>
                                <a href="https://www.instagram.com/" target="_blank" rel="noopener" title="Instagram" style="font-size: 2rem;">
                                    <svg width="1em" height="1em" viewBox="0 0 448 512" fill="#E4405F" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9 114.9-51.3 114.9-114.9S287.7 141 224.1 141zm0 186c-39.5 0-71.5-32-71.5-71.5s32-71.5 71.5-71.5 71.5 32 71.5 71.5-32 71.5-71.5 71.5zm146.4-194.3c0 14.9-12 26.9-26.9 26.9s-26.9-12-26.9-26.9 12-26.9 26.9-26.9 26.9 12 26.9 26.9zm76.1 27.2c-1.7-35.3-9.9-66.7-36.2-92.9S388.6 1.7 353.3 0C317.5-1.7 130.5-1.7 94.7 0 59.4 1.7 28 9.9 1.7 36.2S1.7 123.4 0 158.7C-1.7 194.5-1.7 381.5 0 417.3c1.7 35.3 9.9 66.7 36.2 92.9s57.6 34.5 92.9 36.2c35.8 1.7 222.8 1.7 258.6 0 35.3-1.7 66.7-9.9 92.9-36.2s34.5-57.6 36.2-92.9c1.7-35.8 1.7-222.8 0-258.6zM398.8 388c-7.8 19.6-22.9 34.7-42.5 42.5-29.4 11.7-99.2 9-132.2 9s-102.8 2.6-132.2-9c-19.6-7.8-34.7-22.9-42.5-42.5-11.7-29.4-9-99.2-9-132.2s-2.6-102.8 9-132.2c7.8-19.6 22.9-34.7 42.5-42.5C121.2 9 191 11.6 224 11.6s102.8-2.6 132.2 9c19.6 7.8 34.7 22.9 42.5 42.5 11.7 29.4 9 99.2 9 132.2s2.6 102.8-9 132.2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-7 d-flex align-items-center justify-content-end">
                            @php
                                $commit = exec('git rev-parse HEAD');
                                $commit = substr($commit, 0, 7);
                            @endphp

                            <p class="mb-0   text-medium" style="text-align: right; color: #073f68;">
                            @if ($commit)
                                <span style="margin-right: 35px;">Commit: {{ $commit }}</span>
                            @endif
                            </p>
                            <p class="text-center   mt-3 mb-3" style="color: #073f68;">
                                &copy; Copyright {{ date('Y') }}. Todos los derechos reservados a Sdrimsac
                                Solutions
                            </p>
                        </div>
                    </div>

                    {{-- <div class="container">
                        <div class="row">
                            <div style="color: rgb(9, 9, 57);">
                                @php
                            $commit = exec('git rev-parse HEAD');
                            $commit = substr($commit, 0, 7);
                            @endphp
                            <p class="mb-0 text-medium" style="text-align: right; font-size: 1.2rem;">
                            @if ($commit)
                                <span style="margin-right: 35px;">Commit: {{ $commit }}</span>
                            @endif
                            <span>Todos los derechos reservados
                                <span style="font-weight: bold;">Desarrollado por Sdrimsac Solutions {{ date('Y') }} <i
                                class="far fa-copyright"></i></span>
                            </p>
                        </div>
                    </div>
                </div> --}}
            
        </footer>
    </div>

    <style>
        .swal2-container.swal2-center.swal2-backdrop-show {
            z-index: 3000 !important;
        }

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
        @media screen and (max-width: 800px) {
            .date-time-container {
                display: none !important;
            }
            .user-image-container {
                display: none !important;
            }
        }

        @media (max-width: 800px) {
            .user-image-container {
                width: 50px;
                height: 50px;
                min-width: 50px;
                min-height: 50px;
            }
        }

        /* @media screen and (max-width: 800px) {
            .date-time-container,
            .user-image-container {
                display: none !important;
            }
        } */
        .user-image-container {
            aspect-ratio: 1/1; /* Fuerza una relación de aspecto 1:1 (cuadrado) */
            width: 60px; /* Ancho fijo */
            height: 60px; /* Alto igual al ancho */
            min-width: 60px; /* Evita que se comprima */
            min-height: 60px; /* Evita que se comprima */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 0 10px; /* Añade espacio a los lados */
            border-radius: 8px; /* Bordes redondeados suaves */
        }

        .profile-image {
            width: 100% !important; /* La imagen ocupará el 100% del ancho del contenedor */
            height: auto !important; /* La altura se ajustará automáticamente para mantener la proporción */
            max-width: 700px !important; /* El ancho máximo será de 700px */
            max-height: 300px !important; /* La altura máxima será de 300px */
            object-fit: contain !important; /* La imagen se ajustará dentro del contenedor sin distorsionarse */
            object-position: center !important; /* Centra la imagen si hay espacio adicional */
            image-rendering: -webkit-optimize-contrast !important; /* Mejora la calidad de la imagen */
            transform: translateZ(0) !important;
            backface-visibility: hidden !important;
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

        $(document).ready(function() {
            $("#showPasswordButton").click(function() {
                var passwordInput = $("#pin");
                var type = passwordInput.attr("type");
                if (type === "pin") {
                    passwordInput.attr("type", "text");
                } else {
                    passwordInput.attr("type", "pin");
                }
            });
            $("#pin").on("input", function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
            });
            $("#changePasswordForm").submit(function(event) {
                event.preventDefault();

                const pin = document.getElementById('pin').value;

                if (pin.length !== 4) {
                    alert('El PIN debe tener 4 dígitos.');
                    return;
                }

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            pin: pin
                        })
                    )
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('closeModal').click();
                            setTimeout(() => {
                                alert('PIN actualizado correctamente');
                                window.location.href = "/login";
                            }, 800);

                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // --- Configuración de colores y rangos ---
    function getPingBackground(latencia) {
        if (latencia === -1) return "#6b7280"; // Gris: sin datos
        if (latencia < 90) return "#22c55e";   // Verde
        if (latencia < 150) return "#facc15";  // Amarillo
        return "#ef4444";                      // Rojo
    }

    // --- Medición de latencia usando una imagen pequeña y confiable ---
    function medirLatenciaConImagen(url = "https://www.cloudflare.com/favicon.ico") {
        return new Promise(resolve => {
            const start = performance.now();
            const img = new Image();
            img.onload = () => {
                const end = performance.now();
                const latency = Math.round(end - start);
                console.log('[Latencia] Medida:', latency, 'ms');
                resolve(latency);
            };
            img.onerror = () => {
                console.warn('[Latencia] Error al cargar la imagen para medir latencia');
                resolve(-1);
            };
            img.src = `${url}?_=${Date.now()}`;
        });
    }

    async function actualizarLatenciaBtn() {
        const btn = document.getElementById('latency-btn');
        const text = document.getElementById('latency-btn-text');
        if (!btn || !text) {
            console.warn('[Latencia] No se encontró el botón o el texto');
            return;
        }
        text.textContent = '...';
        btn.style.background = "#6b7280";
        const latencia = await medirLatenciaConImagen();
        text.textContent = latencia >= 0 ? `${latencia} ms` : '-- ms';
        btn.style.background = getPingBackground(latencia);
    }

    document.addEventListener('DOMContentLoaded', function() {
        setInterval(actualizarLatenciaBtn, 2000);
        actualizarLatenciaBtn();
    });
        
        
    </script>
    <!-- Page Specific Scripts End -->
</body>
{{-- <div class="card" style="background-color: red; color: white; padding: 20px; margin: 20px; border-radius: 10px;">
    <h3>Card Roja</h3>
    <p>Este es un ejemplo de una tarjeta con fondo rojo.</p>
</div> --}}
</html>
