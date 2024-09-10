<template>
    <div>
        <div class="row" v-loading="loading">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row">
                    

                    <div class="d-flex" style="margin-top:29px">
                        <span style="margin-right:5px">
                            <strong class="h4">
                                Fecha : {{ form.date }}
                            </strong>
                        </span>
                        <el-button
                            class="submit"
                            type="primary"
                            @click.prevent="getRecordsByFilter"
                            :loading="loading_submit"
                            icon="el-icon-search"
                            >Buscar</el-button
                        >

                        <template
                            v-if="
                                records.length > 0 &&
                                    resource !== 'reports/document-detractions'
                            "
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
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <slot name="heading"></slot>
                        </thead>
                        <tbody>
                            <slot
                                v-for="(row, index) in records"
                                :row="row"
                                :index="customIndex(index)"
                            ></slot>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td
                                    :colspan="
                                        resource == 'reports/sales' ? 6 : 7
                                    "
                                ></td>
                                <td></td>
                                <td></td>
                                <td class="text-end">
                                    <strong>Totales</strong>
                                </td>
                                <!-- <td class="text-end">{{ totals.acum_quote.toFixed(2) }}</td> -->
                                <td class="text-end">
                                    {{ totals.acum_unpaid.toFixed(2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div>
                        <el-pagination
                            @current-change="getRecords"
                            layout="total, prev, pager, next"
                            :total="pagination.total"
                            :current-page.sync="pagination.current_page"
                            :page-size="pagination.per_page"
                        >
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>
        <whatsapp-form-report
            :message.sync="messageReport"
            :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-form-report>
    </div>
</template>
<style>
.font-custom {
    font-size: 15px !important;
}
</style>
<script>
import moment from "moment";
import queryString from "query-string";
import WhatsappFormReport from "../../../../../../resources/js/components/WhatsappModalReports.vue";
export default {
    props: {
        resource: String,
        applyCustomer: { type: Boolean, required: false, default: false }
    },
    components: { WhatsappFormReport },
    data() {
        return {
            loading: false,
            messageReport: "",
            resourceReport: "",
            showWhatsappForm: false,
            loading_submit: false,
            persons: [],
            all_persons: [],
            loading_search: false,
            columns: [],
            records: [],
            headers: headers_token,
            document_types: [],
            pagination: {},
            search: {},
            totals: {},
            establishment: null,
            establishments: [],
            state_types: [],
            form: {},

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
            },
            sellers: []
        };
    },
    computed: {},
    created() {
        this.initForm();
        this.initTotals();
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    async mounted() {
        await this.$http.get(`/${this.resource}/filter`).then(response => {
            this.establishments = response.data.establishments;
            this.all_persons = response.data.persons;
            this.sellers = response.data.sellers;
        });

        await this.getRecords();
        await this.filterPersons();
        // await this.getTotals()
        this.form.type_person =
            this.resource === "reports/sales" ? "customers" : "suppliers";
    },
    methods: {
        clickOpenWhatsapp() {
            let query = queryString.stringify({
                ...this.form
            });
            this.resourceReport = `/${this.resource}/pdf?${query}`;
            this.messageReport = `Reporte de creditos a la fecha ${moment().format(
                "DD-MM-YYYY"
            )}`;
            this.showWhatsappForm = true;
        },
        changePersons() {},
        searchRemotePersons(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.form.type_person = "customers";

                this.$http
                    .get(
                        `/reports/data-table/persons/${this.form.type_person}?${parameters}`
                    )
                    .then(response => {
                        this.persons = response.data.persons;
                        this.loading_search = false;

                        if (this.persons.length == 0) {
                            this.filterPersons();
                        }
                    });
            } else {
                this.filterPersons();
            }
        },
        filterPersons() {
            this.persons = this.all_persons;
            console.log(this.persons);
        },
        getTotals(records) {
            this.initTotals();

            records.forEach(row => {
                this.totals.acum_unpaid += parseFloat(
                    row.payments.reduce(
                        (acc, payment) => acc + parseFloat(payment.total),
                        0
                    )
                );
                // this.totals.acum_quote += parseFloat(row.quote_payment);
            });
        },
        clickDownload(type) {
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/${this.resource}/${type}/?${query}`, "_blank");
        },
        initForm() {
            this.form = {
                date: moment().format("YYYY-MM-DD")
                // establishment_id: null,
                // person_id: null,
                // type_person: null,
                // document_type_id: null,
                // period: "month",
                // date_start: moment().format("YYYY-MM-DD"),
                // date_end: moment().format("YYYY-MM-DD"),
                // month_start: moment().format("YYYY-MM"),
                // month_end: moment().format("YYYY-MM"),
                // seller_id: null,
                // state_type_id: null,
                // typeresult: "Detallado"
            };
        },
        initTotals() {
            this.totals = {
                acum_unpaid: 0,
                acum_quote: 0
            };
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        updateRowVisible(index) {
            index = index - 1;
            this.records[index].visible = !this.records[index].visible;
            this.$forceUpdate();
        },
        getRecords() {
            this.loading = true;
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    this.records = this.records.map(row => {
                        row.visible = false;
                        return row;
                    });
                    console.log("🚀 ~ getRecords ~ this.records:", this.records)

                    //sort records by dues property (int) in descending order

                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading_submit = false;
                    // this.initTotals()

                    this.getTotals(response.data.data);
                })
                .finally(() => {
                    this.loading = false;
                });
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
        }
    }
};
</script>
