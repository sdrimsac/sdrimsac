# Dashboard de Caja - Guía Rápida

## 🚀 Inicio Rápido

### 1. Endpoint API
```
GET /dashboard/cash-dashboard?cash_id={id}
```

### 2. Ejemplo JavaScript
```javascript
// Obtener datos del dashboard
const response = await fetch('/dashboard/cash-dashboard?cash_id=123');
const data = await response.json();

console.log('Total de ventas:', data.data.metrics.total_sales);
console.log('Productos estrella:', data.data.top_products);
```

### 3. Ejemplo Vue.js
```vue
<template>
  <div>
    <h1>Total: S/ {{ metrics.total_sales }}</h1>
    <div v-for="category in topProducts" :key="category.category_id">
      <h2>{{ category.category_name }}</h2>
      <ul>
        <li v-for="product in category.products" :key="product.product_id">
          {{ product.product_name }} - {{ product.quantity_sold }} un
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cashId: 123,
      metrics: {},
      topProducts: []
    };
  },
  async mounted() {
    await this.loadData();
    // Actualizar cada 30 segundos
    setInterval(this.loadData, 30000);
  },
  methods: {
    async loadData() {
      const response = await this.$http.get('/dashboard/cash-dashboard', {
        params: { cash_id: this.cashId }
      });
      
      if (response.data.success) {
        this.metrics = response.data.data.metrics;
        this.topProducts = response.data.data.top_products;
      }
    }
  }
};
</script>
```

## 📊 Estructura de Datos

### Métricas
```json
{
  "total_sales": 350.00,      // Total de ventas
  "efectivo": 100.00,         // Ventas en efectivo
  "tarjeta": 130.00,          // Ventas con tarjeta
  "yape": 50.00,              // Ventas con Yape
  "plin": 70.00,              // Ventas con Plin
  "transferencia": 0.00,      // Transferencias
  "orders_count": 12,         // Cantidad de órdenes
  "canceled_count": 3         // Cantidad de anulaciones
}
```

### Tendencia de Ventas
```json
[
  { "hour": "19:00", "total": 50.00 },
  { "hour": "20:00", "total": 120.00 }
]
```

### Rendimiento de Mozos
```json
[
  {
    "waiter_id": 1,
    "waiter_name": "Juan",
    "orders_count": 5,
    "total_sales": 180.00
  }
]
```

### Productos Estrella
```json
[
  {
    "category_id": 1,
    "category_name": "CAJA",
    "products": [
      {
        "product_id": 10,
        "product_name": "Prod 1",
        "quantity_sold": 30,
        "total_sales": 150.00
      }
    ]
  }
]
```

## 🎨 Ejemplos de Visualización

### Card de Métrica Simple
```vue
<div class="metric-card">
  <div class="metric-label">TOTAL</div>
  <div class="metric-value">S/ {{ metrics.total_sales }}</div>
</div>

<style>
.metric-card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}
.metric-label {
  font-size: 12px;
  color: #666;
}
.metric-value {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}
</style>
```

### Gráfica de Línea (Chart.js)
```javascript
new Chart(ctx, {
  type: 'line',
  data: {
    labels: salesTrend.map(s => s.hour),
    datasets: [{
      label: 'Ventas',
      data: salesTrend.map(s => s.total),
      borderColor: 'rgb(255, 99, 132)',
      tension: 0.4
    }]
  }
});
```

### Lista de Productos
```vue
<div v-for="category in topProducts" :key="category.category_id">
  <h3>{{ category.category_name }}</h3>
  <div v-for="product in category.products" :key="product.product_id">
    <div class="product-row">
      <span>{{ product.product_name }}</span>
      <span>{{ product.quantity_sold }} un</span>
      <span>S/ {{ product.total_sales }}</span>
    </div>
  </div>
</div>
```

## 🔧 Configuración Inicial

### 1. Verificar que la caja esté abierta
```php
$cash = Cash::where('user_id', auth()->id())
    ->where('state', true)
    ->latest()
    ->first();

if (!$cash) {
    return redirect()->back()->with('error', 'No hay caja abierta');
}
```

### 2. Pasar el cash_id a la vista
```php
return view('dashboard.cash', ['cash_id' => $cash->id]);
```

### 3. En la vista Blade
```blade
<dashboard-cash :cash-id="{{ $cash_id }}"></dashboard-cash>
```

## 💡 Tips y Buenas Prácticas

### 1. Actualización Inteligente
```javascript
// Solo actualizar si la ventana está visible
document.addEventListener('visibilitychange', () => {
  if (document.visibilityState === 'visible') {
    this.loadData();
  }
});
```

### 2. Manejo de Errores
```javascript
async loadData() {
  try {
    const response = await this.$http.get('/dashboard/cash-dashboard', {
      params: { cash_id: this.cashId }
    });
    
    if (response.data.success) {
      this.updateData(response.data.data);
    } else {
      this.$message.error(response.data.message);
    }
  } catch (error) {
    console.error('Error:', error);
    this.$message.error('Error al cargar datos del dashboard');
  }
}
```

### 3. Loading State
```vue
<template>
  <div v-loading="loading">
    <!-- Contenido del dashboard -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false
    };
  },
  methods: {
    async loadData() {
      this.loading = true;
      try {
        // ... cargar datos
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
```

### 4. Cache Local (opcional)
```javascript
// Guardar en localStorage para acceso rápido
localStorage.setItem('dashboard_cache', JSON.stringify(data));

// Cargar desde cache si está disponible
const cached = JSON.parse(localStorage.getItem('dashboard_cache'));
if (cached) {
  this.updateData(cached);
}
```

## 🎯 Casos de Uso Comunes

### 1. Mostrar en segunda pantalla
```javascript
window.open(
  '/dashboard/cash-dashboard-view?cash_id=' + cashId,
  'Dashboard',
  'width=1920,height=1080,left=1920,top=0'
);
```

### 2. Dashboard en tablet
```vue
<!-- Vista optimizada para tablet -->
<div class="tablet-dashboard">
  <div class="big-metric">S/ {{ metrics.total_sales }}</div>
  <div class="quick-stats">
    <div>{{ metrics.orders_count }} órdenes</div>
    <div>{{ topWaiter }} mejor mozo</div>
  </div>
</div>
```

### 3. Widget en el POS
```vue
<el-card class="dashboard-widget">
  <div slot="header">
    <span>Dashboard</span>
    <el-button @click="openFullDashboard" type="text">
      Ver completo
    </el-button>
  </div>
  <div>
    <p>Total: S/ {{ metrics.total_sales }}</p>
    <p>Órdenes: {{ metrics.orders_count }}</p>
  </div>
</el-card>
```

## 🐛 Troubleshooting

### Problema: No se muestran datos
```javascript
// Verificar que cash_id esté definido
console.log('Cash ID:', this.cashId);

// Verificar respuesta del servidor
console.log('Response:', response.data);

// Verificar que la caja esté abierta
if (!response.data.data.cash_info.is_open) {
  console.error('La caja está cerrada');
}
```

### Problema: Datos no se actualizan
```javascript
// Verificar que el interval esté funcionando
console.log('Interval ID:', this.refreshInterval);

// Forzar actualización
this.loadData();

// Verificar que no haya múltiples intervals
if (this.refreshInterval) {
  clearInterval(this.refreshInterval);
}
this.refreshInterval = setInterval(this.loadData, 30000);
```

### Problema: Gráficas no se renderizan
```javascript
// Asegurarse de que Chart.js esté cargado
if (typeof Chart === 'undefined') {
  console.error('Chart.js no está cargado');
}

// Esperar a que el DOM esté listo
this.$nextTick(() => {
  this.renderChart();
});

// Verificar que el canvas exista
if (!this.$refs.chartCanvas) {
  console.error('Canvas no encontrado');
}
```

## 📞 Soporte

Si necesitas ayuda, revisa:
1. `docs/DASHBOARD_CAJA_API.md` - Documentación completa de la API
2. `docs/DASHBOARD_CAJA_IMPLEMENTACION.md` - Detalles de implementación
3. `docs/DASHBOARD_CAJA_INTEGRACION_RESTOBAR.md` - Integración con Restobar

---

**Última actualización**: Diciembre 2025
