<template>
      <div id="chart">
          <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
      </div>
</template>
<script>
    import VueApexCharts from 'vue-apexcharts'
 
    export default {
         props: {
          
            type_chart:{
               type: String,
               default: 'pie',
               required: true 
            },
            colors:{
              type:Array,
              default: () => [],
              required: true
            },  
            TitleText:{
              type: String,
              default:'',
              required: true
            },          
             allData:{
                type: Array,
                default: () => [],
                required: true
             },
             labels:{
                type: Array,
                default: () => [],
                required: true
             }
            },
        components: { apexchart: VueApexCharts },
        data() {
            return {
              series: [{
              name: "Desktops",
              data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
          }],
          chartOptions: {
            chart: {
              height: 350,
              type: 'line',
              zoom: {
                enabled: false
              }
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'straight'
            },
            title: {
              text: 'Product Trends by Month',
              align: 'left'
            },
            grid: {
              row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
              },
            },
            xaxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            }
          },
          
            }
        },
        
        watch: {
            labels:function(val) {
                this.createChart(val);
             }
        },
        created(){
         },
        methods: {
            createChart(val) {
               this.chartOptions = {
                  colors:this.colors, 
                  labels: this.labels,
              }


            // this.$refs.apexChart.updateOptions({
            //     chartOptions: {
            //         labels: val
            //     },
            // });
                
            }
            }
    }
</script>
