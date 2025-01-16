<template>
    <div class="card mb-0 pt-2 pt-md-0">
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Reporte a nivel establecimientos</h6>
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
                                    v-model="form.month_start"
                                    type="month"
                                    value-format="yyyy-MM"
                                    clearable
                                ></el-date-picker>
                            </div>
                            <!-- <div class="col-md-3">
                                <label class="control-label w-100">AÑO</label>
                                <el-date-picker
                                    class="w-100"
                                    v-model="form.year_start"
                                    type="year"
                                    value-format="yyyy"
                                    clearable
                                ></el-date-picker>
                            </div> -->
                            <div class="col-lg-2 col-md-2 pb-2">
                                <div class="form-group">
                                    <label class="control-label w-100"
                                        >Año</label
                                    >

                                    <el-date-picker
                                        v-model="form.year_start"
                                        type="year"
                                        style="width: 100%;"
                                        placeholder="Buscar"
                                        value-format="yyyy"
                                        clearable 
                                    >
                                    </el-date-picker>
                                </div>
                            </div>
                        </template>
                        <div
                            class="col-lg-3 col-md-3 col-md-3 col-sm-12 text-center"
                            style="margin-top: 29px"
                        >
                            <!-- <el-button
                                class="submit"
                                type="success"
                                @click.prevent="getRecords"
                                :loading="loading_submit"
                                icon="el-icon-search"
                                >Buscar</el-button
                            > -->

                            <template>
                                <el-button
                                    :loading="loading_submit"
                                    class="submit"
                                    type="danger"
                                    icon="el-icon-tickets"
                                    @click.prevent="clickDownload('pdf')"
                                    >Exportar PDF</el-button
                                >
                            </template>
                            <template>
                                <el-button
                                    :loading="loading_submit"
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
                    ></div>
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
            totals: []
        };
    },
    created() {
        this.initForm();
        /* this.getData();  */ // Call getData to fetch data when the component is created
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
            console.log(moment().format("YYYY-MM"));
            this.errors = {};
            this.form = {
                id: null,
                user_id: null,
                // type: "pdf",
                type_box: null,
                period: "month",

                month_start: moment().format("YYYY-MM"),
                year_start: moment().format("YYYY")
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
        /* getData() {
            
            this.$http
                .get(
                    `/health-global/records/${this.getQueryParameters()}`
                )
                .then(response => {
                   
                    this.data = response.data; 
                    this.records = response.data;
                    console.log(
                        "🚀 ~ file: global.vue:198 ~ getRecords ~ response:",
                        response
                    );
                })
                .catch(error => {
                    this.loading_submit = false;
                    console.error(error); // Maneja el error
                });
        }, */
        getRecords(type) {
            // window.open(`/expensesbox/reports?${this.getQueryParameters()}`, '_blank');
            this.loading_submit = true;
            this.$http
                .get(`/health-global/report?${this.getQueryParameters(type)}`)
                .then(response => {
                    if (response.status === 200) {
                        let data = response.data;
                        if (data.success) {
                            window.open(`${data.data}`, "_blank");
                        }
                    }
                    console.log(
                        "🚀 ~ file: global.vue:198 ~ getRecords ~ response:",
                        response
                    );
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
        getQueryParameters(type) {
            console.log("🚀 ~ getQueryParameters ~ type:", type);
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                type: type,
                ...this.form
            });
        },

        clickDownload(type) {
            console.log("🚀 ~ clickDownload ~ type:", type);

            this.getRecords(type);
            return;
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
            // this.initForm();
        }
    }
};
</script>
