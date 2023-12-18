<template>
    <div class="chart-container">
        <canvas ref="canvas"></canvas>
    </div>
</template>

<style>
    .chart-container {
        position: relative;
        margin: auto;
        height: 170px;
        width: 200px;
    }
    .chart-container .chartjs-render-monitor{
        height: inherit!important;
    }
</style>
<script>
    import Chart from 'chart.js';
    export default {
        props: ['type', 'allData'],
        data() {
            return {
                chart: null,
                options: {
                    maintainAspectRatio: false,
                    lineTension: 0,
                    // circumference: Math.PI,
                    // rotation: -Math.PI
                    legend: {
                        display: false,
                    },
                },
            }
        },
        created() {
            this.title = 'Comprobantes';
        },
        mounted() {
        },
        watch: {
            allData() {
                this.createChart();
            }
        },
        methods: {
            createChart() {
                if (this.chart) {
                    this.chart.destroy();
                 }
                this.chart = new Chart(this.$refs.canvas.getContext('2d'), {
                    type: this.type,
                    data: {
                        labels: this.allData.labels,
                        datasets: this.allData.datasets,
                    },
                    options: this.options,
                });

            }
        }
    }
</script>
