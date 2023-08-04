@extends('tenant.layouts.login')
@section('content')
    <tenant-login-default :company="{{ json_encode($company) }}" :config="{{ json_encode($configuration) }}">
    </tenant-login-default>

    <div class="col-1" style="position: fixed;    top: 0;    left: 0;">
        <button id="btn-refresh" class="button btn-success" onclick="limpiarcache()"
            style="max-width: 27px; max-height: 27px; "> <i class="fas fa-sync-alt"></i>
        </button>
    </div>
@endsection
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     limpiarcache(false);

    // });

    function limpiarcache(reload = true) {
        const btnrefresh = document.getElementById('btn-refresh');
        btnrefresh.classList.add('fa-spin')

        if ('caches' in window) {
            caches.keys().then(function(cacheNames) {
                console.log(cacheNames)
                cacheNames.forEach(function(cacheName) {
                    caches.delete(cacheName);
                });
            });
        }

        navigator.serviceWorker?.getRegistrations().then(function(registrations) {
            console.log(registrations)
            for (let registration of registrations) {

                registration.unregister();
            }
        });

        if (reload) {

            setTimeout(() => {
                window.location.reload()
            }, 2000);
        }

    }
</script>
