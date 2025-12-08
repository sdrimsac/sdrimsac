<template>
  <div class="dashboard-cash-container">
    <!-- Header con información del cajero -->
    <div class="dashboard-header">
      <div class="cash-info">
        <h1>DASHBOARD VENTAS [{{ cashInfo.turn }}]</h1>
        <div class="cashier-info">
          <div class="cashier-avatar">
            <img :src="cashierAvatar" alt="Cajero" />
          </div>
          <div class="cashier-details">
            <p class="cashier-name">CAJERO: {{ cashInfo.cashier_name }}</p>
            <p class="cashier-date">FECHA: {{ formattedDate }}</p>
            <p class="cashier-time">HORA: {{ cashInfo.opening_time }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Métricas principales -->
    <div class="metrics-section">
      <div class="metric-card metric-total">
        <div class="metric-label">VENTA TOTAL</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.total_sales) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">N V</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.efectivo) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">CPE</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.tarjeta) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">EFECTIVO</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.efectivo) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">YAPE</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.yape) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">PLIN</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.plin) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">TARJETA</div>
        <div class="metric-value">S/ {{ formatNumber(metrics.tarjeta) }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">ATEND.</div>
        <div class="metric-value">{{ metrics.orders_count }}</div>
      </div>

      <div class="metric-card">
        <div class="metric-label">ANUL.</div>
        <div class="metric-value">{{ metrics.canceled_count }}</div>
      </div>
    </div>

    <!-- Gráficas -->
    <div class="charts-section">
      <!-- Tendencia de Ventas por Hora -->
      <div class="chart-container">
        <h3>Tendencia de Ventas ({{ cashInfo.turn }})</h3>
        <canvas ref="salesTrendChart"></canvas>
      </div>

      <!-- Rendimiento por Mozo -->
      <div class="chart-container">
        <h3>Rendimiento por Mozo (Ventas y Órdenes)</h3>
        <canvas ref="waiterPerformanceChart"></canvas>
      </div>
    </div>

    <!-- Productos Estrella -->
    <div class="products-section">
      <h2>⭐ PRODUCTOS ESTRELLA</h2>
      <div class="products-grid">
        <div
          v-for="category in topProducts"
          :key="category.category_id"
          class="category-card"
        >
          <div class="category-header" :class="getCategoryClass(category.category_name)">
            <i :class="getCategoryIcon(category.category_name)"></i>
            <h3>{{ category.category_name }}</h3>
          </div>
          <div class="products-list">
            <div
              v-for="product in category.products"
              :key="product.product_id"
              class="product-item"
            >
              <div class="product-name">{{ product.product_name }}</div>
              <div class="product-stats">
                <span class="product-quantity">{{ product.quantity_sold }} Un</span>
                <span class="product-total">S/ {{ formatNumber(product.total_sales) }}</span>
              </div>
              <div class="product-bar">
                <div
                  class="product-bar-fill"
                  :style="{ width: getProductPercentage(product, category.products) + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Indicador de actualización -->
    <div class="update-indicator" v-if="loading">
      <i class="el-icon-loading"></i>
      Actualizando datos...
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import moment from 'moment';

export default {
  props: {
    cashId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      loading: false,
      metrics: {
        total_sales: 0,
        efectivo: 0,
        tarjeta: 0,
        yape: 0,
        plin: 0,
        transferencia: 0,
        orders_count: 0,
        canceled_count: 0
      },
      salesTrend: [],
      waiterPerformance: [],
      topProducts: [],
      cashInfo: {
        cashier_name: '',
        opening_date: '',
        opening_time: '',
        turn: '',
        is_open: true
      },
      refreshInterval: null,
      salesTrendChartInstance: null,
      waiterPerformanceChartInstance: null
    };
  },
  computed: {
    formattedDate() {
      return moment(this.cashInfo.opening_date).format('DD/MM/YYYY');
    },
    cashierAvatar() {
      // Puedes personalizar esto con una foto real del cajero
      return '/images/default-avatar.png';
    }
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
    if (this.salesTrendChartInstance) {
      this.salesTrendChartInstance.destroy();
    }
    if (this.waiterPerformanceChartInstance) {
      this.waiterPerformanceChartInstance.destroy();
    }
  },
  methods: {
    async loadData() {
      try {
        this.loading = true;
        const response = await this.$http.get('/dashboard/cash-dashboard', {
          params: { cash_id: this.cashId }
        });

        if (response.data.success) {
          const {
            metrics,
            sales_trend,
            waiter_performance,
            top_products,
            cash_info
          } = response.data.data;

          this.metrics = metrics;
          this.salesTrend = sales_trend;
          this.waiterPerformance = waiter_performance;
          this.topProducts = top_products;
          this.cashInfo = cash_info;

          // Actualizar gráficas
          this.$nextTick(() => {
            this.updateSalesTrendChart();
            this.updateWaiterPerformanceChart();
          });
        }
      } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        this.$message.error('Error al cargar los datos del dashboard');
      } finally {
        this.loading = false;
      }
    },

    updateSalesTrendChart() {
      const ctx = this.$refs.salesTrendChart;
      if (!ctx) return;

      const labels = this.salesTrend.map(item => item.hour);
      const data = this.salesTrend.map(item => item.total);

      if (this.salesTrendChartInstance) {
        this.salesTrendChartInstance.destroy();
      }

      this.salesTrendChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Ventas (S/)',
              data: data,
              borderColor: 'rgb(255, 99, 132)',
              backgroundColor: 'rgba(255, 99, 132, 0.1)',
              tension: 0.4,
              fill: true,
              pointRadius: 6,
              pointBackgroundColor: 'rgb(255, 99, 132)',
              pointBorderColor: '#fff',
              pointBorderWidth: 2
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return 'S/ ' + context.parsed.y.toFixed(2);
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'S/ ' + value;
                }
              }
            }
          }
        }
      });
    },

    updateWaiterPerformanceChart() {
      const ctx = this.$refs.waiterPerformanceChart;
      if (!ctx) return;

      const labels = this.waiterPerformance.map(item => item.waiter_name);
      const salesData = this.waiterPerformance.map(item => item.total_sales);
      const ordersData = this.waiterPerformance.map(item => item.orders_count);

      if (this.waiterPerformanceChartInstance) {
        this.waiterPerformanceChartInstance.destroy();
      }

      this.waiterPerformanceChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Ventas (S/)',
              data: salesData,
              backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(153, 102, 255, 0.8)'
              ],
              borderColor: [
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(255, 99, 132)',
                'rgb(153, 102, 255)'
              ],
              borderWidth: 2
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                afterLabel: function(context) {
                  const index = context.dataIndex;
                  const orders = ordersData[index];
                  return orders + ' ord';
                },
                label: function(context) {
                  return 'S/ ' + context.parsed.y.toFixed(2);
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'S/ ' + value;
                }
              }
            }
          }
        }
      });
    },

    formatNumber(value) {
      return parseFloat(value).toFixed(2);
    },

    getCategoryClass(categoryName) {
      const name = categoryName.toLowerCase();
      if (name.includes('caja')) return 'category-caja';
      if (name.includes('barra')) return 'category-barra';
      if (name.includes('cocina')) return 'category-cocina';
      return 'category-default';
    },

    getCategoryIcon(categoryName) {
      const name = categoryName.toLowerCase();
      if (name.includes('caja')) return 'el-icon-goods';
      if (name.includes('barra')) return 'el-icon-coffee-cup';
      if (name.includes('cocina')) return 'el-icon-food';
      return 'el-icon-star-off';
    },

    getProductPercentage(product, products) {
      const maxQuantity = Math.max(...products.map(p => p.quantity_sold));
      return (product.quantity_sold / maxQuantity) * 100;
    }
  }
};
</script>

<style scoped>
.dashboard-cash-container {
  padding: 20px;
  background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
  min-height: 100vh;
  color: white;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.cash-info h1 {
  font-size: 28px;
  margin-bottom: 15px;
  font-weight: bold;
}

.cashier-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.cashier-avatar img {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  border: 3px solid white;
}

.cashier-details p {
  margin: 5px 0;
  font-size: 14px;
}

.cashier-name {
  font-weight: bold;
}

/* Métricas */
.metrics-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 15px;
  margin-bottom: 30px;
}

.metric-card {
  background: rgba(255, 255, 255, 0.95);
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.metric-total {
  background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
  color: white;
  grid-column: span 2;
}

.metric-label {
  font-size: 12px;
  font-weight: bold;
  color: #666;
  margin-bottom: 10px;
}

.metric-total .metric-label {
  color: white;
}

.metric-value {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}

.metric-total .metric-value {
  color: white;
  font-size: 32px;
}

/* Gráficas */
.charts-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.chart-container {
  background: rgba(255, 255, 255, 0.95);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.chart-container h3 {
  color: #333;
  margin-bottom: 15px;
  font-size: 16px;
}

.chart-container canvas {
  height: 300px !important;
}

/* Productos Estrella */
.products-section {
  margin-bottom: 30px;
}

.products-section h2 {
  font-size: 24px;
  margin-bottom: 20px;
  text-align: center;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 20px;
}

.category-card {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.category-header {
  padding: 15px;
  color: white;
  display: flex;
  align-items: center;
  gap: 10px;
}

.category-header i {
  font-size: 24px;
}

.category-caja {
  background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
}

.category-barra {
  background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
}

.category-cocina {
  background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
}

.category-default {
  background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
}

.products-list {
  padding: 15px;
}

.product-item {
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}

.product-item:last-child {
  border-bottom: none;
}

.product-name {
  color: #333;
  font-weight: bold;
  margin-bottom: 5px;
}

.product-stats {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
  font-size: 14px;
  color: #666;
}

.product-bar {
  height: 8px;
  background: #eee;
  border-radius: 4px;
  overflow: hidden;
}

.product-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  transition: width 0.3s ease;
}

/* Indicador de actualización */
.update-indicator {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  display: flex;
  align-items: center;
  gap: 10px;
}

@media (max-width: 768px) {
  .metrics-section {
    grid-template-columns: repeat(2, 1fr);
  }

  .charts-section {
    grid-template-columns: 1fr;
  }

  .products-grid {
    grid-template-columns: 1fr;
  }
}
</style>
