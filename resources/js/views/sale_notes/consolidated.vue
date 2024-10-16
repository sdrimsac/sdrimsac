<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6>
                            <span>Consolidado por fechas</span>
                        </h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashbodard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Consolidado</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-end">
            <div class="card mb-0">
                <div class="card-header bg-primary mt-0">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Consolidado de créditos
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label"
                                >Periodo (Fecha de emisión)</label
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
                    
                            <el-button type="primary" @click="getRecords">
                                <i class="fas fa-search"></i> Buscar
                            </el-button>
                                <el-button type="success" @click="clickExport" v-if="data.data">
                                <i class="fas fa-print"></i> Exportar
                            </el-button>
                        </div>
                        
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="row table-responsive">
                            <table
                                class="table table-striped table-bordered"
                                v-if="data.data"
                            >
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="2">TOTAL A COBRAR</th>
                                        <th colspan="2">UTILIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>
                                            S/
                                            {{
                                                Number(
                                                    data.sum_total_general
                                                ).toFixed(2)
                                            }}
                                        </td>
                                        <td colspan="2">
                                            S/
                                            {{ Number(data.gain).toFixed(2) }}
                                        </td>
                                    </tr>
                                    <tr v-for="(v, k) in data.data" :key="k">
                                        <td>{{ k }}</td>
                                        <td>S/ {{ Number(v).toFixed(2) }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>GASTOS</td>
                                        <td>
                                            S/ {{ Number(data.expenses).toFixed(2) }}
                                        </td>
                                        <td>COMPRAS DE PRODUCTOS</td>
                                        <td>
                                            S/
                                            {{ Number(data.purchases).toFixed(2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
