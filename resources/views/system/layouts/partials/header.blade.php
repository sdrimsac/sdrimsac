@php
    $path = explode('/', request()->path());
    $path[1] = array_key_exists(1, $path) > 0 ? $path[1] : '';
    $path[2] = array_key_exists(2, $path) > 0 ? $path[2] : '';
    $path[0] = $path[0] === '' ? 'documents' : $path[0];
@endphp
@include('system.layouts.partials.swal')
<header class=" d-flex align-items-center justify-content-center" style="min-height: 90px; background: #073f68;">
    <div class="logo-container me-4">
        <a href="{{ route('system.dashboard') }}" class="logo">
            @if (file_exists(public_path('acorn/img/profile/store.png')))
                <img class="img-fluid" width="120" height="auto" src="{{ asset('acorn/img/profile/store.png') }}"
                    alt="Logo" />
            @else
                <i class="fa fa-circle fa-3x"></i>
            @endif
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-center gap-2 flex-grow-1"
        style="margin-top: 10px; margin-bottom: 10px;">
        <style>
            .custom-nav-btn {
                margin-right: 6px;
                transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
                box-shadow: none;
                position: relative;
            }
            .custom-nav-btn:last-child {
                margin-right: 0;
            }
            .custom-nav-btn.active, .custom-nav-btn:focus, .custom-nav-btn:hover {
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
                transform: translateY(-2px) scale(1.03);
                background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
                color: #fff !important;
            }
        </style>
        <button type="button" class="btn btn-primary custom-nav-btn {{ in_array($path[0], ['clients', 'dashboard']) ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.dashboard') }}'">
            <i class="fas fa-chart-line me-2"></i> <span class="ms-1">Dashboard</span>
        </button>
        {{-- <button type="button" class="btn btn-secondary custom-nav-btn {{ $path[0] === 'plans' ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.plans.index') }}'">
            <i class="fas fa-plane me-2"></i> <span class="ms-1">Planes</span>
        </button> --}}
        <button type="button" class="btn btn-success custom-nav-btn {{ $path[0] === 'configurations' ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.configuration.index') }}'">
            <i class="fas fa-cogs me-2"></i> <span class="ms-1">Configuración</span>
        </button>
        {{-- <button type="button" class="btn btn-danger custom-nav-btn {{ $path[0] === 'backup' ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.backup') }}'">
            <i class="fas fa-database me-2"></i> <span class="ms-1">Backup</span>
        </button> --}}
        <button type="button" class="btn btn-info custom-nav-btn {{ $path[0] === 'information' ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.information') }}'">
            <i class="fas fa-info me-2"></i> <span class="ms-1">Información</span>
        </button>
        {{-- <button type="button" class="btn btn-warning custom-nav-btn {{ $path[0] === 'auto-update' ? 'active' : '' }}"
            onclick="window.location.href='{{ route('system.update') }}'">
            <i class="fas fa-code-branch me-2"></i> <span class="ms-1">Actualización</span>
        </button> --}}
        {{-- <button type="button" class="btn btn-dark custom-nav-btn"
            onclick="window.open('{{ url('monitor') }}', '_blank')">
            <i class="fas fa-book-open me-2"></i> <span class="ms-1">Monitorear</span>
        </button> --}}
        <button type="button" class="btn btn-dark custom-nav-btn"
            onclick="window.open('{{ url('logs') }}', '_blank')">
            <i class="fas fa-bug me-2"></i> <span class="ms-1">Logs</span>
        </button>
        {{-- <button type="button" class="btn btn-dark custom-nav-btn"
            onclick="window.open('{{ url('historial') }}', '_blank')">
            <i class="fas fa-file-pdf me-2"></i> <span class="ms-1">Registro De Clientes</span>
        </button> --}}
        {{-- <button type="button" class="btn btn-success custom-nav-btn" id="btn-git-update">
            <i class="fas fa-sync-alt me-2"></i> <span class="ms-1">Actualizar desde GitHub</span>
        </button>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('btn-git-update');
                if(btn) {
                    btn.addEventListener('click', function() {
                        if(confirm('¿Estás seguro de que deseas actualizar el sistema desde GitHub?')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('system.git-update') }}";
                            form.style.display = 'none';
                            const csrf = document.createElement('input');
                            csrf.type = 'hidden';
                            csrf.name = '_token';
                            csrf.value = "{{ csrf_token() }}";
                            form.appendChild(csrf);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
            });
        </script> --}}
    </div>
    <div class="ms-auto">
        <!-- start: search & user box -->
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="#" data-toggle="dropdown">
                    <figure class="profile-picture">
                        {{-- <img src="{{asset('img/%21logged-user.jpg')}}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/%21logged-user.jpg" /> --}}
                        <div class="border rounded-circle text-center bg-white" style="width: 25px;"><i
                                class="fas fa-user"></i></div>
                    </figure>
                    <div class="profile-info" data-lock-name="{{ \Auth::getUser()->email }}"
                        data-lock-email="{{ \Auth::getUser()->email }}">
                        <span class="name text-white">{{ \Auth::getUser()->name }}</span>
                        <span class="role">{{ \Auth::getUser()->role }}</span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>

                <div class="dropdown-menu"
                    style="background: #073f68;">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a role="menuitem" href="{{ route('system.users.create') }}"><i class="fas fa-user"></i>
                                Perfil</a>
                            <a role="menuitem" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off"></i> @lang('app.buttons.logout')
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
        <!-- end: search & user box -->
    </div>
</header>
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Servidor Actualizado',
                html: `{!! addslashes(session('success')) !!}`,
                icon: 'success',
                width: 700,
                customClass: {popup: 'swal-wide'},
            });
        });
    </script>
    @if(session('git_output'))
        <div class="container mt-2">
            <pre style="background:#222;color:#b5f;font-size:13px;padding:10px;border-radius:5px;max-height:300px;overflow:auto;">
@foreach(session('git_output') as $cmd)
<b>${{ $cmd['command'] }}</b>
{{ $cmd['output'] }}
@if($cmd['error'])
[Error]: {{ $cmd['error'] }}
@endif

@endforeach
            </pre>
        </div>
    @endif
@endif
@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error en actualización',
                html: `{!! addslashes(session('error')) !!}`,
                icon: 'error',
                width: 700,
                customClass: {popup: 'swal-wide'},
            });
        });
    </script>
@endif
