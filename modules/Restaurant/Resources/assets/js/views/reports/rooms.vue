<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Reporte de habitaciones</h6>
        </div>
        <div class="tab-content p-3">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <!-- <div class="col-md-3">
                            <label class="control-label">Periodo</label>
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
                        </div> -->
                        <template
                            v-if="
                                form.period === 'month' ||
                                    form.period === 'between_months'
                            "
                        >
                            <div class="col-md-3">
                                <label class="control-label w-100"
                                    >Mes de</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.month_start"
                                    type="month"
                                    @change="changeDisabledMonths"
                                    value-format="yyyy-MM"
                                    format="MM/yyyy"
                                    :clearable="false"
                                ></el-date-picker>
                            </div>
                        </template>
                        <template v-if="form.period === 'between_months'">
                            <div class="col-md-3">
                                <label class="control-label w-100"
                                    >Mes al</label
                                >
                                <el-date-picker
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
                            <div class="col-md-3">
                                <label class="control-label w-100"
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
                            <div class="col-md-3">
                                <label class="control-label w-100"
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

                        <template>
                            <div class="col-md-3">
                                <label class="control-label">Filtro</label>
                                <el-select
                                    v-model="form.filter_type"
                                    @change="getRecordsByFilter"
                                >
                                    <el-option
                                        value="1"
                                        label="Por cliente"
                                    ></el-option>
                                    <el-option
                                        value="2"
                                        label="Por habitación"
                                    ></el-option>
                                </el-select>
                            </div>
                        </template>

                        <div
                            class="col-lg-7 col-md-7 col-md-7 col-sm-12"
                            style="margin-top: 29px"
                        >
                            <el-button
                                class="submit"
                                type="primary"
                                @click.prevent="getRecords"
                                :loading="loading_submit"
                                icon="el-icon-search"
                                >Buscar</el-button
                            >

                            <template v-if="records.length > 0">
                                <el-button
                                    class="submit"
                                    type="danger"
                                    icon="el-icon-tickets"
                                    @click.prevent="clickDownload('pdf')"
                                    >Exportar PDF</el-button
                                >

                                <el-button
                                    class="submit"
                                    type="success"
                                    @click.prevent="clickDownload('excel')"
                                    ><i class="fa fa-file-excel"></i> Exportal
                                    Excel</el-button
                                >
                            </template>
                        </div>
                    </div>
                    <div class="row" v-if="records.length > 0">
                        <div class="col-md-12">
                            <div class="table-responsive mt-2">
                                <table
                                    class="table table-striped table-bordered"
                                    width="100%"
                                >
                                    <tr slot="heading">
                                        <th class="">#</th>
                                        <template
                                            v-if="form.filter_type == '1'"
                                        >
                                            <th class="">Cliente</th>
                                        </template>
                                        <template v-else>
                                            <th class="">Habitación</th>
                                        </template>
                                        <th class="">N° de veces</th>
                                        <th class="">Días de alquiler</th>
                                    </tr>

                                    <tr
                                        v-for="(row, index) in records"
                                        :key="index"
                                    >
                                        <td class="">
                                            {{ customIndex(index) }}
                                        </td>
                                        <template
                                            v-if="form.filter_type == '1'"
                                        >
                                            <td class="">
                                                {{ row.customer_name }}
                                                <br />
                                                <small>
                                                    {{ row.customer_number }}
                                                </small>
                                            </td>
                                        </template>
                                        <template v-else>
                                            <td class="">
                                                {{ row.name }}
                                            </td>
                                        </template>
                                        <td class="">
                                            {{ row.item_count }}
                                        </td>
                                        <td class="">
                                            {{ row.total_duration }}
                                        </td>
                                    </tr>
                                </table>

                                <div>
                                    <el-pagination
                                        @current-change="getRecords"
                                        layout="total, prev, pager, next"
                                        :total="pagination.total"
                                        :current-page.sync="
                                            pagination.current_page
                                        "
                                        :page-size="pagination.per_page"
                                    >
                                    </el-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";
export default {
    props: ["showDialog_report", "restaurant", "users"],
    components: {},
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "/caja/rooms/reports",
            form: {},
            array_subcategorias: [],
            array_categorias: [],
            array_group: [],
            register_group: false,
            register_category: false,
            register_subcategory: false,
            form_group: [],
            form_category: [],
            form_subcategory: [],
            pagination: {},
            search: {},
            pagination: {},
            records: [],
            totals_ingresos: 0,
            totals_egresos: 0,
            totals_efectivos: 0,
            totals_depositos: 0,
            modaltype: false,
            ruta: null,
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

        //            await this.$http.get(`/${this.resource}/record`)
        //                .then(response => {
        //                    if (response.data !== '') {
        //                        this.form = response.data.data
        //                    }
        //                })
    },
    methods: {
        customIndex(index) {
            return (
                this.pagination.current_page * this.pagination.per_page -
                this.pagination.per_page +
                (index + 1)
            );
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                user_id: null,
                group_id: null,
                category_id: null,
                subcategory_id: null,
                type: "pdf",
                filter_type: "1",
                period: "between_dates",
                date_start: moment()
                    .startOf("month")
                    .format("YYYY-MM-DD"),
                date_end: moment()
                    .endOf("month")
                    .format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM")
            };
        },

        create() {
            this.titleDialog = "Reporte de Arqueo de Caja";
        },
        async getRecordsByFilter() {
            this.loading_submit = true;
            await this.getRecords();
            this.loading_submit = false;
        },
        getRecords() {
            // window.open(`/expensesbox/reports?${this.getQueryParameters()}`, '_blank');
            this.loading_submit = true;
            this.$http
                .get(`${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    console.log(
                        "🚀 ~ file: rooms.vue:375 ~ getRecords ~ response:",
                        response
                    );
                    this.records = response.data.data;
                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_submit = false;
                });
        },
        Totals() {
            let letIngresos = _.filter(this.records, {
                type: "Efectivo - Ingreso"
            });
            let depositos_total = _.filter(this.records, {
                type: "Transferencia - Ingreso"
            });
            let letEgresos = _.filter(this.records, { type: "Egreso" });
            this.totals_depositos = _.sumBy(depositos_total, it =>
                parseFloat(it.amount)
            );
            this.totals_ingresos = _.sumBy(letIngresos, it =>
                parseFloat(it.amount)
            );
            this.totals_egresos = _.sumBy(letEgresos, it =>
                parseFloat(it.amount)
            );
            this.totals_efectivos = _.round(
                this.totals_ingresos - this.totals_egresos,
                2
            );
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
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
        clickDownload(type) {
            this.modaltype = true;
            this.form.type = type;
            let form_data = this.form;
            this.ruta = form_data;
              window.open(`${this.resource}/export?${this.getQueryParameters()}`, '_blank');
        },
        close() {
            this.$emit("update:showDialog_report", false);
            this.initForm();
        }
    }
};
</script>
