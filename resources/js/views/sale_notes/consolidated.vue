<template>
    <div>
        <div class="row d-flex justify-content-end">
            <div class="card mb-0">
                <div class="card-header bg-primary mt-0">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Consolidado de Créditos
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label"
                                >Período</label
                            >
                            <el-select
                                v-model="form.period"
                                @change="changePeriod"
                             >
                                <el-option
                                    key="month"
                                    value="month"
                                    label="Por mes"
                                ></el-option>
                                <el-option
                                    key="between_months"
                                    value="between_months"
                                    label="Entre meses"
                                ></el-option>
                                <el-option
                                    key="date"
                                    value="date"
                                    label="Por fecha"
                                ></el-option>
                                <el-option
                                    key="between_dates"
                                    value="between_dates"
                                    label="Entre fechas"
                                ></el-option>
                            </el-select>
                        </div>
                        <template
                            v-if="
                                form.period === 'month' ||
                                    form.period === 'between_months'
                            "
                        >
                            <div class="col-md-2">
                                <label class="w-100 control-label"
                                    >Mes de</label
                                >
                                <el-date-picker
                                    v-model="form.month_start"
                                    type="month"
                                    class="w-100"
                                    @change="changeDisabledMonths"
                                    value-format="yyyy-MM"
                                    format="MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_months'">
                            <div class="col-md-2">
                                <label class="w-100 control-label"
                                    >Mes al</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.month_end"
                                    type="month"
                                    :picker-options="pickerOptionsMonths"
                                    value-format="yyyy-MM"
                                    format="MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>
                        <template
                            v-if="
                                form.period === 'date' ||
                                    form.period === 'between_dates'
                            "
                        >
                            <div class="col-md-2">
                                <label class="w-100 control-label"
                                    >Fecha del</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.date_start"
                                    type="date"
                                    @change="changeDisabledDates"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_dates'">
                            <div class="col-md-2">
                                <label class="w-100 control-label"
                                    >Fecha al</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.date_end"
                                    type="date"
                                    :picker-options="pickerOptionsDates"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>

                        <div class="col-md-3 d-flex align-items-end">
                    
                            <el-button class="btn_guardarsmall" type="primary" @click="getRecords">
                                <i class="fas fa-search"></i> Buscar
                            </el-button>
                                <el-button class="btn_excelsmall" type="success" @click="clickExport" v-if="data.data">
                                <i class="fa fa-file-excel"></i> Exportar
                            </el-button>
                        </div>
                        
                    </div>
                    <div class="col-md-12 mt-4">
                        <div v-if="data && data.data">
                            <div class="row">
                                <!-- Left column: resumen y desglose -->
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="mb-1 text-muted">Total a Cobrar</h5>
                                                    <small class="text-secondary">Resumen general</small>
                                                </div>
                                                <div class="text-right money text-nowrap">
                                                    <h4 class="mb-0">{{ formatCurrency(data.sum_total_general) }}</h4>
                                                    <br> 
                                                    <h4 class="text-success mb-0">Utilidad: {{ formatCurrency(data.gain) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="list-group mt-1">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center"
                                            v-for="(v, k) in data.data"
                                            :key="k"
                                        >
                                            <span>{{ k }}</span>
                                            <strong class="money text-nowrap">{{ formatCurrency(v) }}</strong>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Right column: gastos / compras -->
                                <div class="col-md-6 mb-3">
                                    <div class="card shadow-sm mb-3">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Gastos</h6>
                                                <small class="text-muted">Costos diversos</small>
                                            </div>
                                            <div class="text-right money text-nowrap">
                                                <h5 class="mb-0">{{ formatCurrency(data.expenses) }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card shadow-sm">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">Compras de Productos</h6>
                                                <small class="text-muted">Costo de compra</small>
                                            </div>
                                            <div class="text-right money text-nowrap">
                                                <h5 class="mb-0">{{ formatCurrency(data.purchases) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Estilos  -->

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
    .money {
        font-variant-numeric: tabular-nums;
    }
    .text-nowrap { white-space: nowrap; }
</style>

<script>
import DataTable from "../../components/DataTable.vue";
import queryString from "query-string";
import { deletable } from "../../mixins/deletable";
export default {
    props: ["configuration"],
    mixins: [deletable],
    components: {
        DataTable
    },
    data() {
        return {
            resource: "sale-notes/consolidated",
            form: {},
            data: {},
            pickerOptionsDates: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM-DD");
                    return this.form.date_start > time;
                }
            },
            pickerOptionsMonths: {
                disabledDate: time => {
                    time = moment(time).format("YYYY-MM");
                    return this.form.month_start > time;
                }
            }
        };
    },
    created() {
        this.initForm();
    },
    filters: {},
    methods: {
        clickExport() {
            window.open(
                `/sale-notes/consolidated/export?${this.getQueryParameters()}`
            );
        },
        formatCurrency(value) {
            const n = Number(value || 0);
            return 'S/ ' + new Intl.NumberFormat('es-PE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(n);
        },
        getRecords() {
            this.$http(
                `/sale-notes/consolidated/records?${this.getQueryParameters()}`
            ).then(response => {
                console.log(response);
                this.data = response.data;
            });
        },
        changePeriod() {
            if (this.form.period === "month") {
                this.form.month_start = moment().format("YYYY-MM");
                this.form.month_end = moment().format("YYYY-MM");
            }
            if (this.form.period === "between_months") {
                this.form.month_start = moment()
                    .startOf("year")
                    .format("YYYY-MM"); //'2019-01';
                this.form.month_end = moment()
                    .endOf("year")
                    .format("YYYY-MM");
            }
            if (this.form.period === "date") {
                this.form.date_start = moment().format("YYYY-MM-DD");
                this.form.date_end = moment().format("YYYY-MM-DD");
            }
            if (this.form.period === "between_dates") {
                this.form.date_start = moment()
                    .startOf("month")
                    .format("YYYY-MM-DD");
                this.form.date_end = moment()
                    .endOf("month")
                    .format("YYYY-MM-DD");
            }
            // this.loadAll();
        },
        getQueryParameters() {
            return queryString.stringify({
                ...this.form
            });
        },
        changeDisabledDates() {
            if (this.form.date_end < this.form.date_start) {
                this.form.date_end = this.form.date_start;
            }
            // this.loadAll();
        },
        changeDisabledMonths() {
            if (this.form.month_end < this.form.month_start) {
                this.form.month_end = this.form.month_start;
            }
            // this.loadAll();
        },
        initForm() {
            this.form = {
                period: "month",
                date_start: moment().format("YYYY-MM-DD"),
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM")
            };
        }
    }
};
</script>
