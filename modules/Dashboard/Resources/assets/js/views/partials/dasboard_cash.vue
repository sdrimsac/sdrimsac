<template>
  <div class="dashboard-container">

    <!-- HEADER CON FILTROS Y CAJERO -->
    <div class="top-section">
      <!-- Filtros y Título -->
      <div class="left-section">
    
        <h1>DASHBOARD VENTAS [GEKO RESTOBAR]</h1>
        
        <!-- INDICADORES COMPACTOS -->
        <div class="cards-compact">
          <div class="card-small" :class="item.class" v-for="(item, index) in indicadores" :key="index">
            <p class="card-title-small">{{ item.title }}</p>
            <h3 class="card-value-small">{{ item.value }}</h3>
          </div>
        </div>
      </div>

      <!-- Info Cajero -->
      <div class="cajero-info">
        <img :src="cajero.foto" class="avatar" />
        <div class="cajero-text">
          <strong>CAJERO: {{ cajero.nombre.toUpperCase() }}</strong><br />
          <span>FECHA: {{ cajero.fecha }}</span><br />
          <span>HORA: {{ cajero.hora }}</span>
          <!-- <div class="cajero-stats">
            <div class="stat-badge">AT <span>{{ cajero.at }}</span></div>
            <div class="stat-badge anulados">ANUL <span>{{ cajero.anul }}</span></div>
          </div> -->
        </div>
      </div>
    </div>

    <!-- GRÁFICO PRINCIPAL -->
    <div class="charts-row">
      <div class="chart big">
        <h3>Tendencia de Ventas (Turno Noche)</h3>
        <apexchart type="line" height="300" :options="lineOptions" :series="lineSeries"/>
      </div>

      <div class="chart big">
        <h3>Rendimiento por Mozo (Ventas y Órdenes)</h3>
        <apexchart type="bar" height="300" :options="barOptions" :series="barSeries"/>
      </div>
    </div>

    <!-- PRODUCTOS ESTRELLA -->
    <h2 class="section-title">⭐ PRODUCTOS ESTRELLA</h2>
    <div class="productos-row">

      <div class="area-box" v-for="(area, i) in productosAreas" :key="i">
        <div class="area-header">
          <img :src="area.icon" width="50" />
          <h3>{{ area.nombre }}</h3>
        </div>

        <apexchart type="bar" height="250" :options="area.options" :series="area.series"/>
        
        <div class="area-footer">
          <span>- VENDIDO</span>
          <div class="producto-badge">
            <span class="producto-label">PRODUCTO</span>
            <span class="producto-number">1</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      resource: "dashboard/cash-dashboard-open",
      cajero: {
        nombre: "Diana Campos",
        fecha: "22/11/25",
        hora: "23:15",
        foto: "https://randomuser.me/api/portraits/women/44.jpg",
        at: "23",
        anul: "3"
      },
      metrics: {},
      sales_trend: [],
      waiter_performance : [],
      top_products: [],
      cash_info : {},


      indicadores: [],

      /* ---------------- LINE CHART ---------------- */
      lineSeries: [],
      lineOptions: {
        chart: { 
          toolbar: { show: false },
          background: 'transparent'
        },
        stroke: { width: 3, curve: "smooth" },
        xaxis: {
          categories: [],
          labels: { style: { colors: '#999' } }
        },
        yaxis: {
          labels: { style: { colors: '#999' } }
        },
        colors: ["#FF4D6D"],
        fill: { 
          type: 'gradient',
          gradient: {
            shade: 'dark',
            type: 'vertical',
            shadeIntensity: 0.5,
            opacityFrom: 0.7,
            opacityTo: 0.2,
          }
        },
        markers: {
          size: 5,
          colors: ["#FF4D6D"],
          strokeColors: "#fff",
          strokeWidth: 2,
        },
        grid: {
          borderColor: '#333',
        },
        tooltip: {
          theme: 'dark'
        }
      },

      /* ---------------- BAR MOZOS ---------------- */
      barSeries: [],
      barOptions: {
        chart: { 
          toolbar: { show: false },
          background: 'transparent'
        },
        plotOptions: {
          bar: {
            borderRadius: 5,
            distributed: true,
            dataLabels: {
              position: 'top'
            }
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val, opts) {
            return "S/" + val + "\n(" + opts.w.config.series[0].data[opts.dataPointIndex].orders + " ord)"
          },
          offsetY: -25,
          style: {
            fontSize: '11px',
            colors: ["#fff"]
          }
        },
        xaxis: { 
          categories: [],
          labels: { style: { colors: '#999', fontSize: '12px' } }
        },
        yaxis: {
          labels: { style: { colors: '#999' } }
        },
        colors: ["#00DFA2","#0081F1","#FFC700","#FF5733","#8A2BE2"],
        legend: { show: false },
        grid: {
          borderColor: '#333',
        },
        tooltip: {
          theme: 'dark'
        }
      },

      /* ---------------- AREAS PRODUCTOS ---------------- */
      productosAreas: [],

    };
  },
  mounted() {
    this.getDashboardData();
  },
  methods: {
    async getDashboardData() {
      try {
        const response = await this.$http.get(`/${this.resource}`);
        console.log('Dashboard data:', response.data);
        
        const data = response.data.data;
        
        // Asignar data
        this.metrics = data.metrics;
        this.sales_trend = data.sales_trend;
        this.waiter_performance = data.waiter_performance;
        this.top_products = data.top_products;
        this.cash_info = data.cash_info;
        
        // Mapear indicadores
        this.mapIndicadores();
        
        // Mapear gráfico de tendencia de ventas
        this.mapSalesTrend();
        
        // Mapear rendimiento de mozos
        this.mapWaiterPerformance();
        
        // Mapear productos por área
        this.mapTopProducts();
        
        // Mapear info del cajero
        this.mapCashierInfo();
        
      } catch (error) {
        console.error('Error al cargar datos del dashboard:', error);
        this.$message.error('Error al cargar los datos del dashboard');
      }
    },
    
    mapIndicadores() {
      this.indicadores = [
        { 
          title: "VENTA TOTAL", 
          value: `S/ ${this.metrics.total_sales.toFixed(2)}`, 
          class: "destacado" 
        },
        { 
          title: "N.V", 
          value: `S/ ${this.metrics.total_sale_notes.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "CPE", 
          value: `S/ ${this.metrics.total_documents.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "EFECTIVO", 
          value: `S/ ${this.metrics.efectivo.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "YAPE", 
          value: `S/ ${this.metrics.yape.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "PLIN", 
          value: `S/ ${this.metrics.plin.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "TARJETA", 
          value: `S/ ${this.metrics.tarjeta.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "TRANSFER.", 
          value: `S/ ${this.metrics.transferencia.toFixed(2)}`, 
          class: "" 
        },
        { 
          title: "ATEND.", 
          value: `${this.metrics.orders_count}`, 
          class: "" 
        },
        { 
          title: "ANUL.", 
          value: `${this.metrics.canceled_count}`, 
          class: "" 
        },
      ];
    },
    
    mapSalesTrend() {
      // Solo usar las horas que vienen en los datos
      if (this.sales_trend && this.sales_trend.length > 0) {
        const hours = this.sales_trend.map(item => item.hour);
        const data = this.sales_trend.map(item => parseFloat(item.total));
        
        /* console.log('Hours:', hours);
        console.log('Data:', data); */
        
        // Actualizar las opciones del gráfico de forma reactiva
        this.lineOptions = {
          ...this.lineOptions,
          xaxis: {
            ...this.lineOptions.xaxis,
            categories: hours
          }
        };
        
        this.lineSeries = [{
          name: "Ventas",
          data: data
        }];
      } else {
        // Si no hay datos, limpiar el gráfico
        this.lineOptions = {
          ...this.lineOptions,
          xaxis: {
            ...this.lineOptions.xaxis,
            categories: []
          }
        };
        
        this.lineSeries = [{
          name: "Ventas",
          data: []
        }];
      }
    },
    
    mapWaiterPerformance() {
      if (this.waiter_performance && this.waiter_performance.length > 0) {
        const categories = this.waiter_performance.map(item => item.waiter_name);
        const data = this.waiter_performance.map(item => ({
          x: item.waiter_name,
          y: parseFloat(item.total_sales),
          orders: item.orders_count
        }));
        
        this.barOptions.xaxis.categories = categories;
        this.barSeries = [{
          name: "Ventas",
          data: data
        }];
      } else {
        // Si no hay mozos, mostrar mensaje
        this.barSeries = [];
      }
    },
    
    mapTopProducts() {
      if (this.top_products && this.top_products.length > 0) {
        this.productosAreas = this.top_products.map(area => {
          const productNames = area.products.map(p => p.product_name);
          const quantities = area.products.map(p => parseFloat(p.quantity_sold));
          
          // Determinar icono según el área
          let icon = "https://img.icons8.com/color/96/pos-terminal.png";
          if (area.area_name.toLowerCase().includes('barra')) {
            icon = "https://img.icons8.com/color/96/cocktail.png";
          } else if (area.area_name.toLowerCase().includes('cocina')) {
            icon = "https://img.icons8.com/color/96/chef-cooking.png";
          }
          
          return {
            nombre: area.area_name,
            icon: icon,
            series: [{
              name: 'Unidades',
              data: quantities
            }],
            options: {
              chart: { 
                toolbar: { show: false },
                background: 'transparent'
              },
              plotOptions: { 
                bar: { 
                  horizontal: true,
                  borderRadius: 4,
                  distributed: true,
                  dataLabels: {
                    position: 'right'
                  }
                } 
              },
              dataLabels: {
                enabled: true,
                formatter: function (val) {
                  return val + " Und"
                },
                style: {
                  colors: ['#111'],
                  fontSize: '11px',
                  fontWeight: 'bold'
                }
              },
              xaxis: { 
                categories: productNames,
                labels: { show: false }
              },
              yaxis: {
                labels: { 
                  style: { colors: '#999', fontSize: '11px' }
                }
              },
              colors: ["#8B5CF6"],
              legend: { show: false },
              grid: {
                borderColor: '#333',
              },
              tooltip: {
                theme: 'dark'
              }
            }
          };
        });
      }
    },
    
    mapCashierInfo() {
      if (this.cash_info) {
        this.cajero = {
          nombre: this.cash_info.cashier_name || "Sin Cajero",
          fecha: this.cash_info.opening_date || "-",
          hora: this.cash_info.opening_time || "-",
          foto: "https://randomuser.me/api/portraits/women/44.jpg",
          at: this.metrics.orders_count || 0,
          anul: this.metrics.canceled_count || 0
        };
      }
    }
  }
};
</script>

<style scoped>
.dashboard-container {
  background: #073f68;
  color: white;
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  min-height: 100vh;
}

/* Nueva sección superior */
.top-section {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 25px;
}

.left-section {
  flex: 1;
}

.filter-bar {
  margin-bottom: 15px;
}

.search-input {
  width: 100%;
  max-width: 500px;
  padding: 10px 15px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  color: white;
  font-size: 14px;
  outline: none;
  transition: all 0.3s;
}

.search-input::placeholder {
  color: rgba(255, 255, 255, 0.4);
}

.search-input:focus {
  background: rgba(255, 255, 255, 0.08);
  border-color: #2196F3;
}

.left-section h1 {
  font-size: 22px;
  font-weight: bold;
  letter-spacing: 1px;
  margin: 0 0 15px 0;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
  color: #4a9eff;
}

/* Cards compactos en fila */
.cards-compact {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 10px;
  margin-top: 15px;
}

.card-small {
  background: linear-gradient(135deg, #2d2d44 0%, #1f1f2e 100%);
  padding: 12px;
  border-radius: 10px;
  text-align: center;
  border: 2px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 3px 10px rgba(0,0,0,0.3);
  transition: transform 0.2s, box-shadow 0.2s;
}

.card-small:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 14px rgba(0,0,0,0.4);
}

.card-small.destacado {
  background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
  border-color: #66BB6A;
  box-shadow: 0 3px 14px rgba(76, 175, 80, 0.4);
}

.card-title-small {
  font-size: 10px;
  margin: 0 0 6px 0;
  color: #bbb;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.card-small.destacado .card-title-small {
  color: #fff;
  font-weight: bold;
}

.card-value-small {
  font-size: 16px;
  font-weight: bold;
  margin: 0;
  color: #fff;
}

/* Cajero Info */
.cajero-info {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(255, 255, 255, 0.05);
  padding: 10px 14px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  min-width: 280px;
}

.avatar {
  width: 60px !important;
  height: 60px !important;
  border-radius: 50% !important;
  border: 2px solid #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}

.cajero-text {
  text-align: left;
}

.cajero-text strong {
  font-size: 12px;
  color: #FFC107;
  display: block;
  margin-bottom: 3px;
}

.cajero-text span {
  font-size: 10px;
  color: #ddd;
  line-height: 1.6;
}

.cajero-stats {
  display: flex;
  gap: 8px;
  margin-top: 8px;
}

.stat-badge {
  background: #2196F3;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 11px;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 5px;
}

.stat-badge.anulados {
  background: #FF5252;
}

.stat-badge span {
  background: white;
  color: #111;
  padding: 2px 8px;
  border-radius: 4px;
  font-weight: bold;
}

.charts-row {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
}

.chart.big {
  background: linear-gradient(135deg, #2d2d44 0%, #1f1f2e 100%);
  padding: 20px;
  border-radius: 12px;
  width: 50%;
  border: 2px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.chart.big h3 {
  margin: 0 0 15px 0;
  font-size: 16px;
  color: #ddd;
  font-weight: 600;
}

.section-title {
  font-size: 22px;
  margin: 30px 0 20px 0;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
  color: #ffffff;
}

.productos-row {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  margin-top: 20px;
}

.area-box {
  flex: 1;
  background: linear-gradient(135deg, #2d2d44 0%, #1f1f2e 100%);
  padding: 20px;
  border-radius: 12px;
  border: 2px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  position: relative;
}

.area-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 15px;
}

.area-header img {
  width: 50px;
  height: 50px;
  object-fit: contain;
}

.area-header h3 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
  color: #fff;
}

.area-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.area-footer > span {
  font-size: 12px;
  color: #999;
  font-weight: 600;
}

.producto-badge {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 193, 7, 0.2);
  padding: 6px 12px;
  border-radius: 8px;
  border: 1px solid #FFC107;
}

.producto-label {
  color: #FFC107;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
}

.producto-number {
  background: #FFC107;
  color: #111;
  padding: 2px 10px;
  border-radius: 6px;
  font-weight: bold;
  font-size: 14px;
}

@media (max-width: 1200px) {
  .top-section {
    flex-direction: column;
  }
  
  .cajero-info {
    min-width: auto;
    width: 100%;
  }
  
  .charts-row {
    flex-direction: column;
  }
  
  .chart.big {
    width: 100%;
  }
  
  .productos-row {
    flex-direction: column;
  }
}

@media (max-width: 768px) {
  .cards-compact {
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  }
  
  .left-section h1 {
    font-size: 18px;
  }
  
  .avatar {
    width: 50px;
    height: 50px;
  }
}
</style>


