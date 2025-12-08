# Integración del Dashboard de Caja en Restobar

## 📋 Pasos para Integrar el Dashboard en el Módulo Restobar

### 1. Crear la Vista Blade

**Archivo**: `modules/Restobar/Resources/views/dashboard/cash_live.blade.php`

```blade
@extends('tenant.layouts.pos')

@section('content')
    <dashboard-cash-live
        :cash-id="{{ $cash_id }}"
        :configuration="{{ \App\Models\Tenant\Configuration::getPublicConfig() }}"
    ></dashboard-cash-live>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
@endpush
```

### 2. Registrar el Componente Vue

**Archivo**: `modules/Restobar/Resources/assets/js/app.js`

```javascript
// Importar el componente
import DashboardCashLive from './views/dashboard/cash_live.vue';

// Registrar globalmente
Vue.component('dashboard-cash-live', DashboardCashLive);
```

### 3. Crear el Componente Vue

**Archivo**: `modules/Restobar/Resources/assets/js/views/dashboard/cash_live.vue`

```vue
<template>
  <div class="restobar-dashboard">
    <!-- Aquí va el contenido del dashboard -->
    <!-- Puedes copiar el contenido de CashDashboard.vue -->
    <cash-dashboard :cash-id="cashId"></cash-dashboard>
  </div>
</template>

<script>
import CashDashboard from '@/modules/Dashboard/Resources/assets/js/views/CashDashboard.vue';

export default {
  components: {
    CashDashboard
  },
  props: {
    cashId: {
      type: Number,
      required: true
    },
    configuration: {
      type: Object,
      default: () => ({})
    }
  }
};
</script>
```

### 4. Agregar Ruta en Restobar

**Archivo**: `modules/Restobar/Routes/web.php`

```php
Route::middleware(['auth', 'locked.tenant'])->group(function () {
    Route::prefix('worker')->group(function () {
        
        // ... otras rutas ...
        
        // Dashboard en vivo de caja
        Route::get('dashboard-live', [RestobarController::class, 'dashboardLive'])
            ->name('restobar.dashboard.live')
            ->middleware('just.worker');
            
    });
});
```

### 5. Agregar Método en el Controlador

**Archivo**: `modules/Restobar/Http/Controllers/RestobarController.php`

```php
public function dashboardLive()
{
    $user = auth()->user();
    
    // Obtener la caja abierta del usuario
    $cash = Cash::where('user_id', $user->id)
        ->where('state', true)
        ->latest()
        ->first();
    
    if (!$cash) {
        return redirect()
            ->route('restobar.pos.dashboard')
            ->with('error', 'No tienes una caja abierta');
    }
    
    $cash_id = $cash->id;
    
    return view('restobar::dashboard.cash_live', compact('cash_id'));
}
```

### 6. Agregar Botón en el POS

**Archivo**: `modules/Restobar/Resources/assets/js/views/pos/index.vue`

En el método `setMenuOptions()`:

```javascript
setMenuOptions() {
    this.optionsMenu = [
        // ... opciones existentes ...
        
        {
            id: 200,
            title: ["Dashboard", "En Vivo"],
            icon: "el-icon-data-line",
            visible: this.cashId && !this.isSeller
        },
    ];
}
```

En el método `trigerFunction()`:

```javascript
async trigerFunction(id) {
    switch (id) {
        // ... casos existentes ...
        
        case 200:
            // Abrir dashboard en nueva ventana
            const dashboardUrl = `/caja/worker/dashboard-live`;
            window.open(dashboardUrl, '_blank', 'width=1200,height=800');
            break;
    }
}
```

## 🎨 Opciones de Visualización

### Opción 1: Ventana Emergente
```javascript
// Abrir en popup
const dashboardWindow = window.open(
    '/caja/worker/dashboard-live',
    'Dashboard',
    'width=1400,height=900,toolbar=no,menubar=no,scrollbars=yes'
);

// Opcional: actualizar cada minuto
setInterval(() => {
    if (dashboardWindow && !dashboardWindow.closed) {
        dashboardWindow.location.reload();
    }
}, 60000);
```

### Opción 2: Modal
```vue
<template>
  <div>
    <el-button @click="showDashboard = true" type="primary">
      <i class="el-icon-data-line"></i> Dashboard en Vivo
    </el-button>

    <el-dialog
      :visible.sync="showDashboard"
      title="Dashboard en Tiempo Real"
      width="95%"
      fullscreen
    >
      <dashboard-cash-live :cash-id="cashId" />
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showDashboard: false
    };
  }
};
</script>
```

### Opción 3: Segunda Pantalla / Tablet
```javascript
// Detectar si hay segunda pantalla
if (window.screen.availWidth > 1920) {
    // Abrir en segunda pantalla
    const left = window.screen.availWidth - 1920;
    window.open(
        '/caja/worker/dashboard-live',
        'Dashboard',
        `left=${left},top=0,width=1920,height=1080`
    );
}
```

## 📱 Dashboard para Móviles

**Archivo**: `modules/Restobar/Resources/assets/js/views/dashboard/cash_live_mobile.vue`

```vue
<template>
  <div class="mobile-dashboard">
    <!-- Versión simplificada para móviles -->
    <div class="mobile-metrics">
      <div class="metric-total">
        S/ {{ metrics.total_sales }}
      </div>
      
      <div class="metric-row">
        <div class="metric-item">
          <span class="label">EFEC.</span>
          <span class="value">{{ metrics.efectivo }}</span>
        </div>
        <div class="metric-item">
          <span class="label">TARJ.</span>
          <span class="value">{{ metrics.tarjeta }}</span>
        </div>
        <div class="metric-item">
          <span class="label">YAPE</span>
          <span class="value">{{ metrics.yape }}</span>
        </div>
      </div>
    </div>

    <!-- Top 3 productos por categoría -->
    <div class="mobile-products">
      <div v-for="category in topProducts" :key="category.category_id">
        <h3>{{ category.category_name }}</h3>
        <div v-for="product in category.products.slice(0, 3)" :key="product.product_id">
          {{ product.product_name }} - {{ product.quantity_sold }} un
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.mobile-dashboard {
  padding: 10px;
  background: #1e3c72;
  min-height: 100vh;
  color: white;
}

.metric-total {
  font-size: 48px;
  font-weight: bold;
  text-align: center;
  margin: 20px 0;
}

.metric-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin: 20px 0;
}

.metric-item {
  background: rgba(255, 255, 255, 0.1);
  padding: 15px;
  border-radius: 8px;
  text-align: center;
}
</style>
```

## 🔐 Permisos y Seguridad

### Middleware Personalizado

**Archivo**: `app/Http/Middleware/CheckCashAccess.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant\Cash;

class CheckCashAccess
{
    public function handle($request, Closure $next)
    {
        $cashId = $request->query('cash_id') ?? $request->route('cash_id');
        
        if (!$cashId) {
            return response()->json([
                'success' => false,
                'message' => 'ID de caja no proporcionado'
            ], 400);
        }
        
        $cash = Cash::find($cashId);
        
        if (!$cash) {
            return response()->json([
                'success' => false,
                'message' => 'Caja no encontrada'
            ], 404);
        }
        
        $user = auth()->user();
        
        // Verificar que el usuario tenga acceso a esta caja
        if ($user->type !== 'admin' && $cash->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para ver esta caja'
            ], 403);
        }
        
        return $next($request);
    }
}
```

Registrar el middleware:

```php
// app/Http/Kernel.php
protected $routeMiddleware = [
    // ... otros middlewares ...
    'cash.access' => \App\Http\Middleware\CheckCashAccess::class,
];
```

Aplicar en la ruta:

```php
Route::get('dashboard/cash-dashboard', 'DashboardController@cashDashboard')
    ->middleware(['auth', 'cash.access'])
    ->name('dashboard.cash');
```

## 📊 Personalización por Tipo de Negocio

### Para Restaurant
```javascript
// Mostrar también habitaciones ocupadas
const dashboardData = {
    ...baseData,
    rooms_occupied: 5,
    rooms_available: 10
};
```

### Para Grifo
```javascript
// Mostrar ventas por tipo de combustible
const dashboardData = {
    ...baseData,
    sales_by_fuel: [
        { type: 'Gasolina 90', liters: 500, total: 1500 },
        { type: 'Gasolina 95', liters: 300, total: 1200 },
        { type: 'Diesel', liters: 400, total: 1400 }
    ]
};
```

### Para Billar
```javascript
// Mostrar mesas en uso y tiempo promedio
const dashboardData = {
    ...baseData,
    tables_in_use: 8,
    tables_available: 4,
    avg_play_time: '2:30' // horas:minutos
};
```

## 🎯 Ejemplo de Uso Completo

```vue
<template>
  <div id="app">
    <button @click="openDashboard" class="btn-dashboard">
      📊 Ver Dashboard
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cashId: 123 // ID de la caja actual
    };
  },
  methods: {
    openDashboard() {
      // Opción 1: Nueva ventana
      window.open(
        `/dashboard/cash-dashboard?cash_id=${this.cashId}`,
        'Dashboard',
        'width=1400,height=900'
      );
      
      // Opción 2: Navegar en la misma ventana
      // this.$router.push({
      //   name: 'dashboard.cash',
      //   query: { cash_id: this.cashId }
      // });
    }
  }
};
</script>
```

## 📈 Métricas Adicionales Sugeridas

Para ampliar el dashboard, puedes agregar:

1. **Promedio de ticket**: Total ventas / cantidad de órdenes
2. **Velocidad de servicio**: Tiempo promedio entre orden y pago
3. **Productos sin stock**: Alertas de productos agotados
4. **Metas del día**: Comparación con objetivo de ventas
5. **Clientes atendidos**: Cantidad de clientes únicos

## 🔄 Actualización Automática

```javascript
// En el componente Vue
mounted() {
    this.loadData();
    
    // Actualizar cada 30 segundos
    this.interval = setInterval(() => {
        this.loadData();
    }, 30000);
},

beforeDestroy() {
    if (this.interval) {
        clearInterval(this.interval);
    }
}
```

## 🎉 ¡Listo para Usar!

Con esta integración, el dashboard estará disponible en el módulo Restobar y podrá ser accedido desde el POS o desde una ruta dedicada.
