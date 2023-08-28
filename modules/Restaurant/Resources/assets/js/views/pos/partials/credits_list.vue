<template>
    <el-dialog
        :visible="showDialog"
        v-loading="loading"
        @open="open"
        @close="close"
        title="Lista de créditos"
        width="85%"
    >
        <div class="row mt-2">
            <div class="col-md-3">
                <label class="control-label">Periodo (Fecha de emisión)</label>
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
                    form.period === 'month' || form.period === 'between_months'
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
                v-if="form.period === 'date' || form.period === 'between_dates'"
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

            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label class="w-100 control-label">
                        Clientes
                    </label>

                    <el-select
                        class="w-100"
                        v-model="form.person_id"
                        filterable
                        remote
                        popper-class="el-select-customers"
                        clearable
                        placeholder="Nombre o número de documento"
                        :remote-method="searchRemotePersons"
                        :loading="loading_search"
                    >
                        <el-option
                            v-for="option in persons"
                            :key="option.id"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                </div>
            </div>

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
                    <el-button class="submit" @click.prevent="clickOpenWhatsapp"
                        ><i class="fa fa-whatsapp"></i> Enviar
                        whatsapp</el-button
                    >
                </template>
            </div>
        </div>
        <div class="row">
            <table
                class="table table-responsive table-striped 
        "
            >
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">N/V</th>
                        <th class="text-center">Fecha de emisión</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">N° Cuotas Vencidas</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end">Fecha de cobro</th>
                        <th class="text-end">Monto</th>
                        <th class="text-end">Días de atraso</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, idx) in records" :key="idx">
                        <td>{{ customIndex(idx) }}</td>

                        <td class="text-center">{{ row.number }}</td>
                        <td class="text-center">{{ row.date_of_issue }}</td>
                        <td class="text-center">{{ row.customer.number }}</td>
                        <td class="text-center">{{ row.customer.name }}</td>
                        <td class="text-center">{{ row.dues }}</td>
                        <td class="text-center" :class="`${row.canceled ? 'text-success':'text-danger'}`">
                            {{ row.canceled ? "PAGADO" : "PENDIENTE" }}
                        </td>
                        <td class="text-end">{{ row.date_of_due }}</td>
                        <td class="text-end">{{ row.amount_due }}</td>
                        <td class="text-end">{{ row.differenc_days }}</td>
                        <td class="text-center">
                            <template v-if="row.is_credit">
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Registrar Pagos"
                                    placement="bottom-end"
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-primary"
                                        v-if="row.state_type_id != '11'"
                                        @click.prevent="clickPayment(row.id)"
                                    >
                                        <i class="fas fa-money-bill-alt"></i>
                                    </button>
                                </el-tooltip>

                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Imprimir Contrato"
                                    placement="bottom-end"
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickContract(row.id)"
                                    >
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                </el-tooltip>
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Imprimir Cronograma de Pagos"
                                    placement="bottom-end"
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-success"
                                        @click.prevent="clickSchedule(row.id)"
                                    >
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                </el-tooltip>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

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
        <whatsapp-form-report
            :message.sync="messageReport"
            :resource="resourceReport"
            :showWhatsappForm.sync="showWhatsappForm"
        >
        </whatsapp-form-report>
        <sale-note-payments
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
        ></sale-note-payments>

        <sale-note-generate
            :showDialog.sync="showDialogGenerate"
            :recordId="recordId"
            :showGenerate="true"
            :showClose="false"
        ></sale-note-generate>
        <sale-note-detail
            :number="currentNumber"
            :saleNoteId="recordId"
            :showDialog.sync="showDialogDetail"
            :boxes="boxes"
        >
        </sale-note-detail>
    </el-dialog>
</template>

<script>
import SaleNotePayments from "../../../../../../../../resources/js/views/sale_notes/partials/payments.vue";
import SaleNoteGenerate from "../../../../../../../../resources/js/views/sale_notes/partials/option_documents";
import SaleNoteDetail from "../../../../../../../../resources/js/views/sale_notes/partials/detail.vue";
import queryString from "query-string";
import WhatsappFormReport from "../../../../../../../../resources/js/components/WhatsappModalReports.vue";

export default {
    components: {
        WhatsappFormReport,
        SaleNotePayments,
        SaleNoteGenerate,
        SaleNoteDetail
    },
    props: ["showDialog"],
    data() {
        return {
            loading_submit: false,
            showWhatsappForm: false,
            messageReport: "",
            resourceReport: "",
            loading_search: false,
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
            resource: "reports/credits",
            loading: false,
            pagination: {},
            records: [],
            form: {},
            persons: [],
            saleNotesNewId: null,
            showDialogOptions: false,
            recordId: null,
            currentNumber: null,
            boxes: [],
            showDialogDetail: false,
            showDialogGenerate: false,
            showDialogPayments: false
        };
    },
    created() {
        this.initForm();
        this.$eventHub.$on("reloadData", () => {
            this.getRecords();
        });
    },
    methods: {
        clickDetail(record) {
            this.recordId = record.id;
            this.currentNumber = record.full_number;
            this.boxes = record.boxes;
            this.showDialogDetail = true;
        },
        clickGenerate(recordId) {
            this.recordId = recordId;
            this.showDialogGenerate = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickSchedule(recordId) {
            window.open(`/sale-notes/schedule/${recordId}`, "_blank");
        },
        clickContract(recordId) {
            window.open(`/sale-notes/contract/${recordId}`, "_blank");
        },
        clickCreate(id = "") {
            location.href = `/${this.resource}/create/${id}`;
        },
        initForm() {
            this.form = {
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
        clickDownload(type) {
            let query = queryString.stringify({
                ...this.form
            });
            window.open(`/${this.resource}/${type}/?${query}`, "_blank");
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
        async getRecordsByFilter() {
            this.loading_submit = await true;
            await this.getRecords();
            this.loading_submit = await false;
        },
        filterPersons() {
            this.persons = this.all_persons;
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
        changeDisabledMonths() {
            if (this.form.month_end < this.form.month_start) {
                this.form.month_end = this.form.month_start;
            }
            // this.loadAll();
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        open() {
            this.getRecords();
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getRecords() {
            this.loading = true;
            this.$http
                .get(`/${this.resource}/records?${this.getQueryParameters()}`)
                .then(response => {
                    this.records = response.data.data;
                    //sort records by dues property (int) in descending order
                    this.records.sort(function(a, b) {
                        return b.dues - a.dues;
                    });

                    this.pagination = response.data.meta;
                    this.pagination.per_page = parseInt(
                        response.data.meta.per_page
                    );
                    this.loading = false;
                });
        },
        getQueryParameters() {
            return queryString.stringify({
                page: this.pagination.current_page,
                limit: this.limit,
                ...this.form
            });
        }
    }
};
</script>
