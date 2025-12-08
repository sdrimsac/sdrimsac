# Dashboard de Caja en Tiempo Real - API

## Descripción
Esta API proporciona datos en tiempo real del dashboard del cajero/restobar mientras la caja está abierta y se están realizando ventas.

## Endpoint

```
GET /dashboard/cash-dashboard?cash_id={cash_id}
```

## Parámetros de Consulta

| Parámetro | Tipo | Requerido | Descripción |
|-----------|------|-----------|-------------|
| `cash_id` | integer | Sí | ID de la caja abierta |

## Respuesta Exitosa

### Estructura de Respuesta

```json
{
  "success": true,
  "data": {
    "metrics": {
      "total_sales": 350.00,
      "efectivo": 100.00,
      "tarjeta": 130.00,
      "yape": 50.00,
      "plin": 70.00,
      "transferencia": 0.00,
      "orders_count": 12,
      "canceled_count": 3
    },
    "sales_trend": [
      {
        "hour": "19:00",
        "total": 50.00
      },
      {
        "hour": "20:00",
        "total": 120.00
      },
      {
        "hour": "21:00",
        "total": 250.00
      },
      {
        "hour": "22:00",
        "total": 400.00
      }
    ],
    "waiter_performance": [
      {
        "waiter_id": 1,
        "waiter_name": "Juan",
        "orders_count": 5,
        "total_sales": 180.00
      },
      {
        "waiter_id": 2,
        "waiter_name": "María",
        "orders_count": 8,
        "total_sales": 500.00
      }
    ],
    "top_products": [
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
      },
      {
        "category_id": 2,
        "category_name": "BARRA",
        "products": [
          {
            "product_id": 15,
            "product_name": "Cerveza Pilsen",
            "quantity_sold": 25,
            "total_sales": 200.00
          }
        ]
      },
      {
        "category_id": 3,
        "category_name": "COCINA",
        "products": [
          {
            "product_id": 20,
            "product_name": "Lomo Saltado",
            "quantity_sold": 15,
            "total_sales": 300.00
          }
        ]
      }
    ],
    "cash_info": {
      "cashier_name": "Diana Campos",
      "opening_date": "2025-11-22 19:00:00",
      "opening_time": "19:00",
      "turn": "Turno Noche",
      "is_open": true
    }
  }
}
```

## Descripción de Campos

### metrics
Métricas principales de ventas de la caja:
- `total_sales`: Venta total acumulada
- `efectivo`: Total de ventas en efectivo
- `tarjeta`: Total de ventas con tarjeta (incluye NIUBIZ, IZYPAY, OPENPAY)
- `yape`: Total de ventas con Yape
- `plin`: Total de ventas con PLIN
- `transferencia`: Total de transferencias y depósitos bancarios
- `orders_count`: Cantidad de atenciones (órdenes pagadas)
- `canceled_count`: Cantidad de documentos anulados

### sales_trend
Tendencia de ventas hora por hora durante el turno:
- `hour`: Hora en formato HH:00
- `total`: Total de ventas en esa hora

### waiter_performance
Rendimiento de los mozos (top 5):
- `waiter_id`: ID del mozo
- `waiter_name`: Nombre del mozo
- `orders_count`: Cantidad de órdenes atendidas
- `total_sales`: Total de ventas generadas

### top_products
Productos estrella agrupados por categoría (top 5 por categoría):
- `category_id`: ID de la categoría
- `category_name`: Nombre de la categoría (CAJA, BARRA, COCINA, etc.)
- `products`: Array de productos más vendidos
  - `product_id`: ID del producto
  - `product_name`: Nombre del producto
  - `quantity_sold`: Cantidad vendida
  - `total_sales`: Total de ventas del producto

### cash_info
Información de la caja actual:
- `cashier_name`: Nombre del cajero
- `opening_date`: Fecha y hora de apertura de caja
- `opening_time`: Hora de apertura (HH:mm)
- `turn`: Descripción del turno
- `is_open`: Estado de la caja (true = abierta, false = cerrada)

## Respuesta de Error

```json
{
  "success": false,
  "message": "Caja no encontrada"
}
```

## Ejemplo de Uso

### JavaScript/Vue.js

```javascript
async function getDashboardData(cashId) {
  try {
    const response = await axios.get(`/dashboard/cash-dashboard`, {
      params: { cash_id: cashId }
    });
    
    if (response.data.success) {
      const { metrics, sales_trend, waiter_performance, top_products } = response.data.data;
      
      // Actualizar las métricas
      console.log('Total de ventas:', metrics.total_sales);
      
      // Actualizar gráfica de tendencia
      updateSalesTrendChart(sales_trend);
      
      // Actualizar rendimiento por mozo
      updateWaiterChart(waiter_performance);
      
      // Actualizar productos estrella
      updateTopProductsChart(top_products);
    }
  } catch (error) {
    console.error('Error al obtener datos del dashboard:', error);
  }
}

// Actualizar cada 30 segundos para datos en tiempo real
setInterval(() => {
  getDashboardData(currentCashId);
}, 30000);
```

### PHP/Laravel

```php
use Illuminate\Support\Facades\Http;

$cashId = 123;
$response = Http::get(config('app.url') . '/dashboard/cash-dashboard', [
    'cash_id' => $cashId
]);

if ($response->successful() && $response->json('success')) {
    $data = $response->json('data');
    $metrics = $data['metrics'];
    $salesTrend = $data['sales_trend'];
    $waiterPerformance = $data['waiter_performance'];
    $topProducts = $data['top_products'];
    
    // Procesar los datos...
}
```

## Notas Importantes

1. **Tiempo Real**: Este endpoint debe ser consultado periódicamente (cada 30-60 segundos) para mantener los datos actualizados en tiempo real.

2. **Permisos**: El usuario debe tener permisos de administrador o estar autenticado con una caja abierta.

3. **Rendimiento**: Los datos se calculan en tiempo real basándose en las ventas registradas en la caja actual.

4. **Categorías**: Las categorías de productos (CAJA, BARRA, COCINA) se obtienen de la tabla `category_food`.

5. **Turnos**: El turno se obtiene de la relación de la caja con la tabla `turns`.

## Integración con el Frontend

### Componente Vue recomendado

```vue
<template>
  <div class="dashboard-cash">
    <!-- Métricas -->
    <div class="metrics-row">
      <metric-card title="VENTA TOTAL" :value="metrics.total_sales" color="green" />
      <metric-card title="EFECTIVO" :value="metrics.efectivo" />
      <metric-card title="TARJETA" :value="metrics.tarjeta" />
      <metric-card title="YAPE" :value="metrics.yape" />
      <metric-card title="PLIN" :value="metrics.plin" />
      <metric-card title="ATEND." :value="metrics.orders_count" />
      <metric-card title="ANUL." :value="metrics.canceled_count" />
    </div>

    <!-- Gráficas -->
    <div class="charts-row">
      <sales-trend-chart :data="salesTrend" />
      <waiter-performance-chart :data="waiterPerformance" />
    </div>

    <!-- Productos Estrella -->
    <div class="products-section">
      <h3>⭐ PRODUCTOS ESTRELLA</h3>
      <div class="products-by-category">
        <product-category-card
          v-for="category in topProducts"
          :key="category.category_id"
          :category="category"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cash_id: null,
      metrics: {},
      salesTrend: [],
      waiterPerformance: [],
      topProducts: [],
      refreshInterval: null
    };
  },
  mounted() {
    this.loadData();
    // Actualizar cada 30 segundos
    this.refreshInterval = setInterval(() => {
      this.loadData();
    }, 30000);
  },
  beforeDestroy() {
    if (this.refreshInterval) {
      clearInterval(this.refreshInterval);
    }
  },
  methods: {
    async loadData() {
      try {
        const response = await this.$http.get('/dashboard/cash-dashboard', {
          params: { cash_id: this.cash_id }
        });
        
        if (response.data.success) {
          const { metrics, sales_trend, waiter_performance, top_products } = response.data.data;
          this.metrics = metrics;
          this.salesTrend = sales_trend;
          this.waiterPerformance = waiter_performance;
          this.topProducts = top_products;
        }
      } catch (error) {
        console.error('Error:', error);
      }
    }
  }
};
</script>
```

## Soporte

Para consultas o problemas con esta API, contactar al equipo de desarrollo.
