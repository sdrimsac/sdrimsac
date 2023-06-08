<template>
    <div id="chart">
           <apexchart :type="type_chart" height="300px " :options="chartOptions" :series="allData"></apexchart>
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
                chart: null,
        series: [],
        chartOptions: {
        chart: {
            type: this.type_chart
         },
        //  title: {
        //     text: this.TitleText,
        //     align: 'center',
        //     style: {
        //       fontSize:  '14px',
        //       fontWeight:  'bold',
        //       fontFamily: 'Nunito, sans-serif',
        //       color:  '#F2F2F2'
        //     },
        // },
        colors: this.colors,
        dataLabels: {
          enabled: true,
          formatter: function (val, opts) {
              return opts.w.config.series[opts.seriesIndex]
            },
        },
        legend: {
         position: 'bottom',
         fontSize: '14px',         
            labels:    {
            color: '#ccc7c7',
            useSeriesColors: true
        },
        formatter: function(seriesName, opts) {
        return '<div class="legend-info">' + '<span>' + seriesName + '</span>' + '&nbsp; <b>' + opts.w.globals.series[opts.seriesIndex] + '</b>' + '</div>'
      }
        },
          fill: {
              type: 'gradient',
          },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270,
            donut: {
              size: '70%',
              background: 'transparent',
              labels: { 
                show: true, 
                name: { 
                  show: true ,
                 },
                value: { 
                  show: true,
                  fontSize: '26px',
                  fontFamily: 'Nunito, sans-serif',
                  color: '#ccc7c7',
                  formatter: function (val) {
                    return val
                  }
                },
                total: {
              show: true,
              label: 'Total',
              color: '#ccc7c7',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return ((a + b))
                }, 0)
              }
            }
              }
            }
          }
        },
        stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'butt',
        colors: undefined,
        width:0,
        dashArray: 0,      
    },
        states: {
        hover: {
            filter: {
            type: 'none',
            }
        },
        },
        labels:this.labels,
        responsive: [{
            breakpoint: 1599,
            options: {
                chart: {
                    width: '350px',
                    height: '400px'
                },
                legend: {
                    position: 'top'
                }
            },
    
            breakpoint: 1439,
            options: {
                chart: {
                    width: '250px',
                    height: '390px'
                },
                legend: {
                    position: 'top'
                },
                plotOptions: {
                  pie: {
                    donut: {
                      size: '65%',
                    }
                  }
                }
            },
        }]
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
