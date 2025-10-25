<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="row">

                    <div class="col-lg-3 col-md-4 col-sm-12 pb-2">
                        <div class="row m-2 d-flex align-items-center">
                            <div class="col-4">
                                <el-select ref="cliente" filterable remote clearable popper-class="el-select-customers"
                                    dusk="customer_id" placeholder="Ingrese Personal / Cliente"
                                    :remote-method="searchRemoteCustomers" :loading="loading_search"
                                    @change="changeCustomer" v-model="form.person_id">
                                    <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                        :label="option.description"></el-option>
                                </el-select>
                            </div>
                            <div class="col-md-2 col-lg-2 col-12">
                                <el-select v-model="form.establishment_id" placeholder="Seleccione Establecimiento">
                                    <el-option v-for="item in establishments" :key="item.id" :label="item.description"
                                        :value="item.id"></el-option>
                                </el-select>
                            </div>
                            <div class="col-md-2 col-lg-2 col-12">
                                <el-date-picker class="w-100" v-model="form.date" type="month"
                                    placeholder="Seleccione Mes" value-format="yyyy-MM" :picker-options="{
                                        disabledDate(time) {
                                            return (
                                                time.getTime() > Date.now()
                                            );
                                        }
                                    }"></el-date-picker>
                            </div>
                            <div class="col-md-2 col-lg-2 col-12">
                                <el-select v-model="form.paid" placeholder="Seleccione">
                                    <el-option label="Pagado" value="1"></el-option>
                                    <el-option label="Pendiente" value="0"></el-option>
                                </el-select>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" @click="getRecords">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
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
                column: null,
                value: null
            },
            columns: [],
            records: [],
            pagination: {},
            warehouses: [],
            time: null
        };
    },
    computed: {},
    created() {

        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        // console.log(this.resource);
        // let column_resource = _.split(this.resource, "/");

        await this.$http
            // .get(`/${_.head(column_resource)}/columns`)
            .get(`/${this.resource}/columns`)
            .then(response => {
                this.columns = response.data;
                this.search.column = _.head(Object.keys(this.columns));
            });

        await this.$http
            // .get(`/${_.head(column_resource)}/columns`)
            .get(`/${this.resource}/tables`)
            .then(response => {
                this.warehouses = response.data.warehouses;
                // this.search.column = _.head(Object.keys(this.columns));
            });
        await this.getRecords();
    },
    methods: {

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

                this.records = response.data.data;
                this.pagination = response.data.meta;
                this.pagination.per_page = parseInt(
                    response.data.meta.per_page
                );
            }, 500);
        },
        async clickPayment(form) {
            // this.reCalculateTotal();
            // return;

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
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.search
            });
        },
        changeClearInput() {
            this.search.value = "";
            this.getRecords();
        }
    }
};
</script>
