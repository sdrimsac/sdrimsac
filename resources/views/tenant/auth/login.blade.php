@extends('tenant.layouts.login')
@section('content')
    <tenant-login-default :company="{{ json_encode($company) }}" :config="{{ json_encode($configuration) }}">
    </tenant-login-default>

    <div class="col-1" style="position: fixed;    top: 0;    left: 0;">
        <button id="btn-refresh" class="button btn-success" onclick="limpiarcache()"
            style="max-width: 27px; max-height: 27px;" title="Limpia temporales y la memoria caché del navegador">
            
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        if (!document.getElementById('pin')) {
            limpiarcache(true);
        }
    }, 800);
});

async function limpiarcache(reload = true) {
    const btnrefresh = document.getElementById('btn-refresh');
    if (btnrefresh) btnrefresh.classList.add('fa-spin');

    console.log("Iniciando limpieza de caches y service workers...");

    // 1. Borrar caches
    if ('caches' in window) {
        try {
            const cacheNames = await caches.keys();
            console.log("Caches encontradas:", cacheNames);

            for (const name of cacheNames) {
                const ok = await caches.delete(name);
                console.log(`Cache ${name} borrada:`, ok);
            }
        } catch (err) {
            console.warn("Error al borrar caches:", err);
        }
    }

    // 2. Desregistrar service workers
    if ('serviceWorker' in navigator) {
        try {
            const regs = await navigator.serviceWorker.getRegistrations();
            for (const reg of regs) {
                const ok = await reg.unregister();
                console.log(`SW ${reg.scope} eliminado:`, ok);
            }
        } catch (err) {
            console.warn("Error al desregistrar SW:", err);
        }
    }

    // 3. Limpiar storages extra (opcional)
    try {
        localStorage.clear();
        sessionStorage.clear();
        console.log("LocalStorage y SessionStorage borrados");
    } catch (err) {}

    // 4. Borrar IndexedDB (algunos navegadores)
    if (indexedDB && indexedDB.databases) {
        try {
            const dbs = await indexedDB.databases();
            for (const db of dbs) {
                if (db.name) {
                    console.log("Eliminando DB:", db.name);
                    await new Promise((resolve) => {
                        const req = indexedDB.deleteDatabase(db.name);
                        req.onsuccess = req.onerror = req.onblocked = () => resolve();
                    });
                }
            }
        } catch (err) {
            console.warn("Error al limpiar IndexedDB:", err);
        }
    }

    // 5. Recargar cuando todo esté limpio
    if (reload) {
        console.log("Recargando página sin caché...");
        setTimeout(() => {
            // Cache-busting para móviles (añade parámetro único)
            const url = new URL(window.location.href);
            url.searchParams.set('_cb', Date.now());
            window.location.replace(url.toString());
        }, 1000);
    }
}
</script>

