<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12 ">
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label class="control-label">Tipo de crédito</label>
                        <el-select
                            v-model="credit_type"
                            clearable
                            placeholder="Seleccione"
                            @change="changeType"
                        >
                            <el-option
                                key="cash"
                                value="is_cash"
                                label="Efectivo"
                            ></el-option>
                            <el-option
                                key="product"
                                value="is_product"
                                label="Hogar"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label"
                            >Periodo (Fecha de emisión)</label
                        >
                        <el-select v-model="form.period" @change="changePeriod">
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
                            <label class="w-100 control-label">Mes de</label>
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
                            <label class="w-100 control-label">Mes al</label>
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
                            <label class="w-100 control-label">Fecha del</label>
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
                            <label class="w-100 control-label">Fecha al</label>
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

                    <div class="d-flex" style="margin-top:29px">
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
                            <!-- <el-button
                                class="submit"
                                type="danger"
                                icon="el-icon-tickets"
                                @click.prevent="clickDownload('pdf')"
                                >Exportar PDF</el-button
                            > -->

                            <el-button
                                class="submit"
                                type="success"
                                @click.prevent="clickDownload('excel')"
                                ><i class="fa fa-file-excel"></i> Exportal
                                Excel</el-button
                            >
                            <!-- <el-button
                                class="submit"
                                @click.prevent="clickOpenWhatsapp"
                                ><i class="fa fa-whatsapp"></i> Enviar
                                whatsapp</el-button
                            > -->
                        </template>
                    </div>
                </div>
                <div class="row mt-1 mb-4"></div>
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
                        <tfoot v-if="records.length > 0">
                            <tr>
                                <td colspan="2">TOTALES</td>
                                <td class="text-center">
                                    {{ totals.acum_total }}
                                </td>
                                <td class="text-center">
                                    {{ totals.acum_purchase_unit_price }}
                                </td>
                                <td></td>
                                <td colspan="2"></td>
                                <td class="text-center">
                                    {{ Number( totals.acum_gain ).toFixed(2)}}
                                </td>
                                <td class="text-end">
                                    {{ totals.acum_total_penalties }}
                                </td>
                                <td class="text-end">
                                    {{Number( totals.acum_total_gain ).toFixed(2)}}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
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
        type: String,
        applyCustomer: { type: Boolean, required: false, default: false }
    },
    components: { WhatsappFormReport },
    data() {
        return {
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
            credit_type: "is_product",
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
        changeType() {
            this.$emit("update:type", 'is_cash');
            this.credit_type = 'is_product';
        
        },
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
        changePersons() {
            // this.form.type_person = this.resource === 'reports/sales' ? 'customers':'suppliers'
        },
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
            // console.log(records)

            records.forEach(row => {
                this.totals.acum_total += row.total;
                this.totals.acum_gain += row.gain;
                this.totals.acum_total_penalties += row.total_penalties;
                this.totals.acum_total_gain += row.total_gain;
                this.totals.acum_purchase_unit_price += row.purchase_unit_price;
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
                credit_type: "is_product",
                establishment_id: null,
                person_id: null,
                type_person: null,
                document_type_id: null,
                period: "month",
                date_start: moment().format("YYYY-MM-DD"),
                date_end: moment().format("YYYY-MM-DD"),
                month_start: moment().format("YYYY-MM"),
                month_end: moment().format("YYYY-MM"),
                seller_id: null,
                state_type_id: null,
                typeresult: "Detallado"
            };
        },
        initTotals() {
            this.totals = {
                acum_total: 0,
                acum_gain: 0,
                acum_total_penalties: 0,
                acum_total_gain: 0,
                acum_purchase_unit_price: 0
            };
        },
        customIndex(index) {
            return index + 1;
        },
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        getRecords() {
            return this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.records;

                    this.loading_submit = false;
                    // this.initTotals();

                    this.getTotals(this.records);
                })
                .catch(error => {
                    this.loading_submit = false;
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
