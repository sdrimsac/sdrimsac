<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Reporte globalizado</h6>
        </div>
        <div class="tab-content p-3">
            <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                    <div class="row">
                        <template>
                            <div class="col-md-3">
                                <label class="control-label w-100"
                                    >Fecha de apertura</label
                                >
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.date_open"
                                    type="date"
                                    @change="changeDisabledDates"
                                    value-format="yyyy-MM-dd"
                                    format="dd/MM/yyyy"
                                    clearable
                                ></el-date-picker>
                            </div>
                        </template>
                        <div
                            class="col-lg-7 col-md-7 col-md-7 col-sm-12"
                            style="margin-top: 29px"
                        >
                            <el-button
                                class="submit"
                                type="success"
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
                            </template>
                            <template v-if="records.length > 0">
                                <el-button
                                    class="submit"
                                    type="success"
                                    icon="el-icon-tickets"
                                    @click.prevent="clickDownload('excel')"
                                    >Exportar EXCEL</el-button
                                >
                            </template>
                        </div>
                    </div>
                    <div
                        class="row table-responsive mt-3"
                        v-if="records.length > 0"
                    >
                        <table
                            class="table table-striped"
                            v-for="(record, index) in records"
                            :key="index"
                        >
                            <thead>
                                <tr
                                    style="margin-top: 29px"
                                    class="bg-primary text-white"
                                >
                                    <th
                                        :colspan="columns.length + 2"
                                        class="text-white"
                                    >
                                        {{ record.establishment_description }}
                                    </th>
                                </tr>
                                <tr v-if="record.cash.length != 0">
                                    <th></th>
                                    <th
                                        class="text-end"
                                        v-for="(column, indexcolumn) in columns"
                                        :key="indexcolumn"
                                    >
                                        {{ column.toUpperCase() }}
                                    </th>
                                    <th class="text-end">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, indexcash) in record.cash"
                                    :key="indexcash"
                                >
                                    <td width="8%">
                                        {{ item.turn }}
                                    </td>
                                    <td
                                        :width="`${84 / columns.length}%`"
                                        class="text-end"
                                        v-for="(column, indexcolumn) in columns"
                                        :key="indexcolumn"
                                    >
                                        {{ getValueColumn(column, item) }}
                                    </td>
                                    <td class="text-end">
                                        {{
                                            calculateSumEstablishment(
                                                item
                                            ).toFixed(2)
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="record.cash.length != 0">
                                    <td>
                                        <strong>SUBTOTAL</strong>
                                    </td>
                                    <td
                                        class="text-end"
                                        v-for="(column,
                                        indexcolumnAmount) in columns"
                                        :key="indexcolumnAmount"
                                    >
                                        {{
                                            calculateSum(
                                                record.cash,
                                                column
                                            ).toFixed(2)
                                        }}
                                    </td>
                                    <td width="8%" class="text-end">
                                        <strong>
                                            {{
                                                calculateSumRow(
                                                    record.cash
                                                ).toFixed(2)
                                            }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table>
                            <tfoot v-if="records.length != 0">
                                <tr>
                                    <td width="8%">
                                        <strong>TOTAL GENERAL</strong>
                                    </td>
                                    <td
                                        :width="`${84 / totals.length}%`"
                                        class="text-end"
                                        v-for="(total, idx) in totals"
                                        :key="idx"
                                    >
                                        {{ total.toFixed(2) }}
                                    </td>
                                    <td width="8%"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        TOTAL VENTAL DEL DÍA
                                    </td>
                                    <td class="text-end">
                                        {{
                                            totals
                                                .reduce((sum, item) => {
                                                    return (
                                                        sum + parseFloat(item)
                                                    );
                                                }, 0)
                                                .toFixed(2)
                                        }}
                                    </td>
                                    <td :colspan="totals.length-1"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";
import BoxModal from "./options.vue";
export default {
    props: ["showDialog_report", "restaurant", "users"],
    components: { BoxModal },
    data() {
        return {
            loading_submit: false,
            titleDialog: null,
            resource: "reports/boxes/global",
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
            columns: [],
            search: {},
            pagination: {},
            records: [],
            totals_ingresos: 0,
            totals_egresos: 0,
            totals_efectivos: 0,
            totals_depositos: 0,
            modaltype: false,
            ruta: null,
            totals: [],
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
        //                .then(response => {
        //                    if (response.data !== '') {
        //                        this.form = response.data.data
        //                    }
        //                })
    },
    methods: {
        calculateSumEstablishment(item) {
      
            let { records } = item;
            return records.reduce((sum, item) => {
                return sum + parseFloat(item.amount);
            }, 0);
        },
        calculateSumRow(cash) {
            let total = 0;
            for (let i = 0; i < this.columns.length; i++) {
                total += this.calculateSum(cash, this.columns[i]);
            }
            return total;
        },
        calculateSum(cash, column) {
            return cash.reduce((sum, item) => {
                return sum + parseFloat(this.getValueColumn(column, item));
            }, 0);
        },
        getValueColumn(column, item) {
            let { records } = item;

            let methodMap = records.reduce((map, record) => {
                map[record.method] = record.amount;
                return map;
            }, {});

            let amount = methodMap[column] || 0;

            return amount.toFixed(2);
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                user_id: null,
                date_open: moment().format("YYYY-MM-DD"),
                type: "pdf",
                type_box: null,
                period: "month",
                date_start: null,
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM")
            };
        },
        date_start() {
            this.$http
                .get(`/${this.resource}/user/${this.form.user_id}`)
                .then(response => {
                    this.form.date_start = response.data;
                });
        },
        create() {
            this.titleDialog = "Reporte de Arqueo de Caja";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                    });
            }
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
                .get(
                    `/reports/boxes/global/records?${this.getQueryParameters()}`
                )
                .then(response => {
                    console.log(
                        "🚀 ~ file: global.vue:198 ~ getRecords ~ response:",
                        response
                    );
                    this.records = response.data.data;
                    this.columns = response.data.columns;
                    this.totals = [];
                    for (let i = 0; i < this.columns.length; i++) {
                        let column = this.columns[i];
                        let total = this.records.reduce((sum, record) => {
                            return sum + this.calculateSum(record.cash, column);
                        }, 0);
                        this.totals.push(total);
                    }
                        console.log("🚀 ~ file: global.vue:340 ~ getRecords ~ this.totals:", this.totals)
                })

                .finally(() => {
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
            let query = queryString.stringify({
                ...this.form
            });
            //expensesbox/reports_pd
            let ruta = `/reports/boxes/global/export?${query}`;
         
            let link = `${ruta}`;
            window.open(`${link}`, "_blank");
        },
        close() {
            this.$emit("update:showDialog_report", false);
            this.initForm();
        }
    }
};
</script>
