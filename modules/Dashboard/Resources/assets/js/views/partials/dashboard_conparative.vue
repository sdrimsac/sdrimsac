<template>
    <div class="card">
        <div>
            <apexchart
                type="bar"
                height="400"
                :options="chartOptions"
                :series="series"
            />
        </div>
    </div>
</template>

<script>
import { method } from "lodash";
import VueApexCharts from "vue-apexcharts";

export default {
    components: {
        apexchart: VueApexCharts
    },
    data() {
        return {
            resource: "dashboard/comparative",
            series: [
                {
                    name: "FACTURAS",
                    data: [56258, 60215, 10548, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "BOLETAS",
                    data: [12598, 10548, 4500, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "NOTAS DE VENTA",
                    data: [5879, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "COMPRAS",
                    data: [10456, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "GASTOS",
                    data: [1256, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "VENTA BRUTA",
                    data: [63023, 70763, 15048, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }
            ],
            chartOptions: {
                chart: {
                    type: "bar",
                    stacked: false,
                    toolbar: { show: false }
                },
                xaxis: {
                    categories: [
                        "ENERO",
                        "FEBRERO",
                        "MARZO",
                        "ABRIL",
                        "MAYO",
                        "JUNIO",
                        "JULIO",
                        "AGOSTO",
                        "SEPTIEMBRE",
                        "OCTUBRE",
                        "NOVIEMBRE",
                        "DICIEMBRE"
                    ],
                    labels: {
                        style: {
                            fontSize: "12px"
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "60%"
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: "top",
                    horizontalAlign: "center"
                },
                colors: [
                    "#008FFB",
                    "#00E396",
                    "#FEB019",
                    "#FF4560",
                    "#775DD0",
                    "#546E7A"
                ],
                tooltip: {
                    y: {
                        formatter: val => `S/. ${val.toLocaleString()}`
                    }
                }
            }
        };
    },
    created() {
        this.getRecords();
    },
    methods: {
        getRecords() {
            return this.$http
                .get(`/${this.resource}/records`)
                .then(response => {
                    const data = response.data;

                    this.series = [
                        {
                            name: "FACTURAS",
                            data: data.invoices.monthly.map(
                                item => parseFloat(item.total) || 0
                            )
                        },
                        {
                            name: "BOLETAS",
                            data: data.tickets.monthly.map(
                                item => parseFloat(item.total) || 0
                            )
                        },
                        {
                            name: "NOTAS DE VENTA",
                            data: data.sale_notes.monthly.map(
                                item => parseFloat(item.total) || 0
                            )
                        },
                        {
                            name: "COMPRAS",
                            data: data.purchases.monthly.map(
                                item => parseFloat(item.total) || 0
                            )
                        }
                    ];
                });
        }
    }
};
</script>
