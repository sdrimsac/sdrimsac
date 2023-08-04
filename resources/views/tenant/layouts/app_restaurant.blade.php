<!DOCTYPE html>
<html lang="en" data-footer="true">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Acorn Admin Template | Editable Rows Datatables</title>
    <meta
      name="description"
      content="A table enhancing plug-in for the jQuery Javascript library, adding sorting, paging and filtering abilities to plain HTML tables with minimal effort."
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    @if ($vc_company->favicon)
    <link rel="shortcut icon"  href="{{ asset('storage/uploads/favicon/'.$vc_company->favicon)  }}"  type="image/x-icon"/>
    @endif


    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('acorn/font/CS-Interface/style.css') }}" />
     <link rel="stylesheet" href="{{ asset('acorn/css/vendor/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/OverlayScrollbars.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/select2-bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('acorn/css/vendor/datatables.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('acorn/css/styles.css') }}" />
     <link rel="stylesheet" href="{{ asset('acorn/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('porto-light/vendor/font-awesome/5.11/css/all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('icofont/icofont.min.css') }}">
    <script src="../acorn/js/base/loader.js"></script>
  </head>

  <body>
    <div id="root">
      <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex justify-content-between">
          <!-- Logo Start -->
          <div class="logo position-relative" style="max-width: 80%  " style="max-height: 80%">
            <a href="Dashboards.Default.html">
              <!-- Logo can be added directly -->
              <!-- <img src="img/logo/logo-white.svg" alt="logo" /> -->

              <!-- Or added via css to provide different ones for different color themes -->
              <div class="img"></div>
            </a>
          </div>
          <!-- Logo End -->

          <!-- Language Switch Start -->
          <div class="language-switch-container">
            <button class="btn btn-empty language-button dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">EN</button>
            <div class="dropdown-menu">
              <a href="#" class="dropdown-item">DE</a>
              <a href="#" class="dropdown-item active">EN</a>
              <a href="#" class="dropdown-item">ES</a>
            </div>
          </div>
          <!-- Language Switch End -->

          <!-- User Menu Start -->
          <div class="user-container d-flex">
            <a href="#" class="d-flex user position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="profile" alt="profile" src="{{ asset('acorn/img/profile/profile-11.jpg') }}" />
            <div class="name">
                {{ $vc_user->name }}
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

              <!-- Icons Menu Start -->
              <ul class="list-unstyled list-inline text-center menu-icons">
                {{-- <li class="list-inline-item">
                <a href="#" data-bs-toggle="modal" data-bs-target="#searchPagesModal">
                    <i data-cs-icon="search" data-cs-size="18"></i>
                </a>
                </li> --}}
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

            </ul>
            <!-- Icons Menu End -->

            <!-- Menu Start -->
            @include('tenant.layouts.partials.sidebar')
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

      <main>
        <div class="container">
          <div class="row">
            <div class="col">
                <div id="main">
                    @yield('content')
                </div>


            </div>
          </div>
        </div>
      </main>

     <!-- Layout Footer Start -->
      <footer>
          <div class="footer-content">
            <div class="container">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <i class="fas fa-code" role="button" onclick="limpiarcache()"></i>
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

    <!-- Theme Settings Modal Start -->
    <div
      class="modal fade modal-right scroll-out-negative"
      id="settings"
      data-bs-backdrop="true"
      tabindex="-1"
      role="dialog"
      aria-labelledby="settings"
      aria-hidden="false"
    >
      <div class="modal-dialog modal-dialog-scrollable full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Theme Settings</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="scroll-track-visible">
              <div class="mb-5" id="color">
                <label class="mb-3 d-inline-block form-label">Color</label>
                <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="light-blue" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="blue-light"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT BLUE</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-blue" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="blue-dark"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK BLUE</span>
                    </div>
                  </a>
                </div>

                <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="light-red" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="red-light"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT RED</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-red" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="red-dark"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK RED</span>
                    </div>
                  </a>
                </div>

                <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="light-green" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="green-light"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT GREEN</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-green" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="green-dark"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK GREEN</span>
                    </div>
                  </a>
                </div>

                <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="light-purple" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="purple-light"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT PURPLE</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-purple" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="purple-dark"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK PURPLE</span>
                    </div>
                  </a>
                </div>

                <div class="row d-flex g-3 justify-content-between flex-wrap mb-3">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="light-pink" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="pink-light"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT PINK</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="dark-pink" data-parent="color">
                    <div class="card rounded-md p-3 mb-1 no-shadow color">
                      <div class="pink-dark"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK PINK</span>
                    </div>
                  </a>
                </div>
              </div>

              <div class="mb-5" id="navcolor">
                <label class="mb-3 d-inline-block form-label">Override Nav Palette</label>
                <div class="row d-flex g-3 justify-content-between flex-wrap">
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="default" data-parent="navcolor">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DEFAULT</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="light" data-parent="navcolor">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-secondary figure-light top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">LIGHT</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="dark" data-parent="navcolor">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-muted figure-dark top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">DARK</span>
                    </div>
                  </a>
                </div>
              </div>

              <div class="mb-5" id="placement">
                <label class="mb-3 d-inline-block form-label">Menu Placement</label>
                <div class="row d-flex g-3 justify-content-between flex-wrap">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="horizontal" data-parent="placement">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">HORIZONTAL</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="vertical" data-parent="placement">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary left"></div>
                      <div class="figure figure-secondary right"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">VERTICAL</span>
                    </div>
                  </a>
                </div>
              </div>

              <div class="mb-5" id="behaviour">
                <label class="mb-3 d-inline-block form-label">Menu Behaviour</label>
                <div class="row d-flex g-3 justify-content-between flex-wrap">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="pinned" data-parent="behaviour">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary left large"></div>
                      <div class="figure figure-secondary right small"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">PINNED</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="unpinned" data-parent="behaviour">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary left"></div>
                      <div class="figure figure-secondary right"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">UNPINNED</span>
                    </div>
                  </a>
                </div>
              </div>

              <div class="mb-5" id="layout">
                <label class="mb-3 d-inline-block form-label">Layout</label>
                <div class="row d-flex g-3 justify-content-between flex-wrap">
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="fluid" data-parent="layout">
                    <div class="card rounded-md p-3 mb-1 no-shadow">
                      <div class="figure figure-primary top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">FLUID</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-50 option col" data-value="boxed" data-parent="layout">
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
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="rounded" data-parent="radius">
                    <div class="card rounded-md radius-rounded p-3 mb-1 no-shadow">
                      <div class="figure figure-primary top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">ROUNDED</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="standard" data-parent="radius">
                    <div class="card rounded-md radius-regular p-3 mb-1 no-shadow">
                      <div class="figure figure-primary top"></div>
                      <div class="figure figure-secondary bottom"></div>
                    </div>
                    <div class="text-muted text-part">
                      <span class="text-extra-small align-middle">STANDARD</span>
                    </div>
                  </a>
                  <a href="#" class="flex-grow-1 w-33 option col" data-value="flat" data-parent="radius">
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

    <button type="button" class="btn settings-button btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#settings" id="settingsButton">
      <i data-cs-icon="paint-roller" class="position-relative"></i>
    </button>
    <!-- Theme Settings Modal End -->
    <style>
    .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
        padding-right:0px !important;
        padding-left:0px !important;
    }

    </style>
    <!-- Search Modal End -->

    <!-- Vendor Scripts Start -->
    <script src="{{ mix('/js/app.js') }}"></script>
    {{--
     <script src="{{ asset('acorn/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/autoComplete.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/clamp.min.js') }}"></script>
    <script src="{{ asset('acorn/js/cs/scrollspy.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/mousetrap.min.js') }}"></script>

    <script src="{{ asset('acorn/font/CS-Line/csicons.min.js') }}"></script>
    <script src="{{ asset('acorn/js/base/helpers.js') }}"></script>
    <script src="{{ asset('acorn/js/base/globals.js') }}"></script>
    <script src="{{ asset('acorn/js/base/nav.js') }}"></script>
     <script src="{{ asset('acorn/js/base/settings.js') }}"></script>
    <script src="{{ asset('acorn/js/base/init.js') }}"></script>
    <script src="{{ asset('acorn/js/forms/controls.select2.js') }}"></script>

    <script src="{{ asset('acorn/js/common.js') }}"></script>
    <script src="{{ asset('acorn/js/scripts.js') }}"></script>
    --}}
    <script src="{{ asset('acorn/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/OverlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('acorn/js/vendor/autoComplete.min.js') }}"></script>


    <script src="{{ asset('acorn/js/vendor/select2.full.min.js') }}"></script>
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
    <script src="{{ asset('acorn/js/forms/controls.select2.js') }}"></script>
    <script src="{{ asset('acorn/js/forms/genericforms.js') }}" ></script>
    <script src="{{ asset('acorn/js/common.js') }}"></script>
    <script src="{{ asset('acorn/js/scripts.js') }}"></script>
    <script src="{{ asset('qz/dependencies/rsvp-3.1.0.min.js') }}"></script>
    <script src="{{ asset('qz/dependencies/sha-256.min.js') }}"></script>
    <script src="{{ asset('qz/qz-tray.js') }}"></script>
    <script src="{{ mix('/js/clear_cache.js') }}"></script>
  </body>
</html>
