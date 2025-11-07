<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row">

                    <!-- <div class="row m-2 d-flex align-items-center"> -->
                    <div class="col-4">
                        <label for="">Buscar Personal</label>
                        <el-select ref="cliente" filterable remote clearable popper-class="el-select-customers"
                            dusk="customer_id" placeholder="Ingrese Personal / Cliente"
                            :remote-method="searchRemoteCustomers" @change="changeCustomer" v-model="search.person_id">
                            <el-option v-for="option in persons" :key="option.id" :value="option.id"
                                :label="option.name"></el-option>
                        </el-select>
                    </div>
                    <!-- </div> -->

                    <div class="col-md-2 col-lg-2 col-12">
                        <label for="">Seleccione Establecimiento</label>
                        <el-select v-model="search.establishment_id" placeholder="Seleccione Establecimiento" clearable
                            filterable @change="changeCustomer">
                            <el-option v-for="item in establishments" :key="item.id" :label="item.description"
                                :value="item.id"></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-2 col-lg-2 col-12">
                        <label for="">Seleccione Mes</label>
                        <el-date-picker class="w-100" v-model="form.date" type="month" placeholder="Seleccione Mes"
                            @change="changeCustomer" value-format="yyyy-MM" :picker-options="{
                                disabledDate(time) {
                                    // Comparar por inicio de mes para evitar bloquear meses pasados
                                    const now = new Date();
                                    const timeMonthStart = new Date(time.getFullYear(), time.getMonth(), 1).getTime();
                                    const nowMonthStart = new Date(now.getFullYear(), now.getMonth(), 1).getTime();
                                    return timeMonthStart > nowMonthStart; // true = deshabilitado (meses futuros)
                                }
                            }"></el-date-picker>
                    </div>
                    <div class="col-md-2 col-lg-2 col-12">
                        <label for="">Seleccione Dia</label>
                        <el-date-picker class="w-100" v-model="form.date_day" type="date" placeholder="Seleccione Dia"
                            @change="changeCustomer" value-format="yyyy-MM-dd" :picker-options="{
                                disabledDate(time) {
                                    // Comparar por inicio de mes para evitar bloquear meses pasados
                                    const now = new Date();
                                    const timeMonthStart = new Date(time.getFullYear(), time.getMonth(), 1).getTime();
                                    const nowMonthStart = new Date(now.getFullYear(), now.getMonth(), 1).getTime();
                                    return timeMonthStart > nowMonthStart; // true = deshabilitado (meses futuros)
                                }
                            }"></el-date-picker>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" @click="diasPersonal">
                            Generar datos de personal
                        </button>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" @click="ExportExcel">
                            exportar a excel
                        </button>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" @click="ExportPdf">
                            exportar a pdf
                        </button>
                    </div> 
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot v-for="(row, index) in records" :row="row" :index="customIndex(index)"></slot>
                        </tbody>
                    </table>
                    <div>
                        <el-pagination @current-change="getRecords" layout="total, prev, pager, next"
                            :total="pagination.total" :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"></el-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import queryString from "query-string";

export default {
    props: {
        resource: String
    },
    data() {
        return {
            search: {
                value: null,
                person_id: null
            },
            columns: [],
            records: [],
            customers: [],
            pagination: {},
            warehouses: [],
            persons: [],
            establishments: [],
            time: null,
            form: {
                person_id: null,
                establishment_id: null,
                date: null,
                paid: null,
                date_day: null
            },
        };
    },
    computed: {},
    created() {

        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {

        await this.$http
            // .get(`/${_.head(column_resource)}/columns`)
            .get(`/${this.resource}/tables`)
            .then(response => {
                this.establishments = response.data.establishments;
                this.persons = response.data.persons
                // this.search.column = _.head(Object.keys(this.columns));
            });
        await this.getRecords();
    },
    methods: {

        ExportExcel() {
            const parameters = this.getQueryParameters();
            const url = `/${this.resource}/export-excel${parameters ? '?' + parameters : ''}`;
            window.open(url, '_blank');
        },
        ExportPdf() {
            const parameters = this.getQueryParameters();
            const url = `/${this.resource}/export-pdf${parameters ? '?' + parameters : ''}`;
            window.open(url, '_blank');
        },
        diasPersonal() {
            let month = null;
            let year = null;
            if (this.form.date) {
                const parts = String(this.form.date).split('-');
                if (parts.length >= 2) {
                    year = parseInt(parts[0], 10);
                    month = parseInt(parts[1], 10);
                }
            }
            if (!month || !year) {
                const d = new Date();
                month = d.getMonth() + 1;
                year = d.getFullYear();
            }

            const payload = {
                month: month,
                year: year
            };

            if (this.form.date_day) {
                payload.date_day = this.form.date_day;
            }

            this.$http.post('/staff/generate-summary', payload).then(response => {
                this.records = response.data && response.data.data ? response.data.data : [];

                const meta = (response.data && response.data.meta) ? response.data.meta : {};
                this.pagination = Object.assign({ total: 0, per_page: 10, current_page: 1 }, meta);
                this.pagination.per_page = parseInt(this.pagination.per_page) || 10;
            });
        },
        changeCustomer() {
            this.getRecords();
        },

        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {

                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}`
                );
                this.customers = response.data.customers;
                this.loading_search = false;
                this.input_person.number = null;
            }
        },

        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecords() {
            if (this.time) {
                clearTimeout(this.time);
            }

            this.time = setTimeout(async () => {
                const response = await this.$http.get(
                    `/${this.resource}/records?${this.getQueryParameters()}`
                );

                this.records = response.data && response.data.data ? response.data.data : [];

                // Defensive meta handling: ensure pagination is always an object with defaults
                const meta = (response.data && response.data.meta) ? response.data.meta : {};
                this.pagination = Object.assign({ total: 0, per_page: 10, current_page: 1 }, meta);
                this.pagination.per_page = parseInt(this.pagination.per_page) || 10;
            }, 500);
        },
        /* async clickPayment(form) {

            this.setSeries();

            let customer = this.customers.find(
                c => c.id == this.form.person_id
            );

            if (!form.series_id) {
                return this.$toast.warning(
                    "El establecimiento no tiene series disponibles para el comprobante"
                );
            }

            if (form.document_type_id === "80") {
                form.prefix = "NV";
                form.paid = 1;
                this.resource_documents = "sale-notes";
                this.resource_payments = "sale_note_payments";
            }

            form.advances = 0.0;
            form.prefix = "NV";
            form.total_advances = 0.0;
            form.total_payment = form.total;
            form.exchange_rate_sale = 1;
            form.list_ordens = this.list_ordens;
            form.currency_type_id = "PEN";
            form.date_of_issue = moment().format("YYYY-MM-DD");
            form.time_of_issue = moment().format("HH:mm:ss");
            form.is_pay_credit_list = true;
            form.payments = [
                {
                    payment_method_type_id: "01",
                    date_of_payment: form.date_of_issue,
                    payment: form.total
                }
            ];

            this.loading_submit = true;
            this.formDocument.items = this.formDocument.items.filter(
                item => Number(item.quantity) > 0
            );

            try {
                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);

                const response = await this.$http.post(
                    `/${this.resource_documents}`,
                    form
                );
                console.log(
                    "🚀 ~ file: index.vue:300 ~ clickPayment ~ response:",
                    response
                );
                let { data } = response;
                if (response.status == 200 && data.data) {
                    let data = response.data.data;
                    let { print_ticket } = data;
                    window.open(`${print_ticket}`, "_blank");
                    this.getRecords();

                    if (response.data.success == true) {
                    }
                }
                let { success, message } = data;
                if (!success) {
                    this.$toast.error(message);
                }
            } catch (error) {
                console.log(error);
                const response = error.response;
                let {
                    data: { message }
                } = response;

                this.$toast.error(message || "Ocurrió un error");
                this.loading_submit = false;
            }
        }, */
        getQueryParameters() {
            // Merge `search` and `form` so filters from both places are included
            // (previously this used `this.search || this.form` which ignored `form`
            // because `this.search` is always truthy)
            const merged = Object.assign({}, this.search || {}, this.form || {});
            // Exclude `column` if present
            const { column, ...searchWithoutColumn } = merged;

            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...searchWithoutColumn
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.form.person_id = "";
            this.getRecords();
        }
    }
};
</script>
