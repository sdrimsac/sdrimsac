<template>
    <el-dialog
        :visible="showDialog"
        title="Consolidados"
        @open="open"
        @close="close"
        append-to-body
        v-loading="loading"
    >
        <div class="row m-2">
            <div class="col-md-3">
                <el-input
                    v-model="form.number"
                    placeholder="Número"
                    @input="getRecordsTimer"
                    clearable
                ></el-input>
            </div>
            <div class="col-md-3">
                <el-date-picker
                    @change="getRecords"
                    v-model="form.date"
                    type="date"
                    placeholder="Fecha"
                    clearable
                    value-format="yyyy-MM-dd"
                    format="yyyy-MM-dd"
                ></el-date-picker>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Consolidación
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Usuario
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(record, idx) in records" :key="idx">
                        <td>
                            {{ customIndex(idx) }}
                        </td>
                        <td>
                            {{ record.identifier }}
                        </td>
                        <td>{{ record.date }}</td>
                        <td>
                            {{ record.user_name }}
                        </td>
                        <td>
                            <el-tooltip
                            v-if="configuration && configuration.consolidated_quotation_details"
                                content="Reporte documentos de pago por vendedor detalle"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickExportDocumentsDetail(record)"
                                >
                                    <i class="el-icon-document"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-else
                                content="Reporte documentos de pago por vendedor"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickExportDocuments(record)"
                                >
                                    <i class="el-icon-document"></i>
                                </el-button>
                            </el-tooltip>
                            
                            <el-tooltip
                                content="Exportar"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickExport(record)"
                                >
                                    <i class="el-icon-download"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                content="Exportar formato de entrega"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickExportDelivery(record)"
                                >
                                    <i class="fas fa-truck"></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                :content="
                                    record.hasPrint
                                        ? 'Imprimir documentos'
                                        : 'Emitir documentos'
                                "
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    @click="clickPrint(record)"
                                >
                                    <i
                                        class="el-icon-printer"
                                        v-if="record.hasPrint"
                                    ></i>
                                    <i class="el-icon-document" v-else></i>
                                </el-button>
                            </el-tooltip>
                            <el-tooltip
                                v-if="record.hasPrint"
                                content="Liquidar"
                                placement="top"
                                effect="dark"
                            >
                                <el-button
                                    type="success"
                                    size="mini"
                                    @click="clickLiquidate(record)"
                                >
                                    <i class="el-icon-money"></i>
                                </el-button>
                            </el-tooltip>
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
                :page-size="Number(pagination.per_page)"
            >
            </el-pagination>
        </div>
        <ConsolidatedPayment
            :configuration="configuration"
            @cancelOrden="cancelOrden"
            :showDialog.sync="showDialogPayment"
            :record="recordPayment"
            @insertOrdenQuotation="insertOrdenQuotation"
        ></ConsolidatedPayment>
    </el-dialog>
</template>

<script>
import ConsolidatedPayment from "./consolidated_payment.vue";
import querystring from "querystring";
export default {
    components: {
        ConsolidatedPayment
    },
    props: ["showDialog", "configuration"],
    data() {
        return {
            showDialogPayment: false,
            recordPayment: null,
            form: {
                date: ""
            },
            resource: "quotations",
            records: [],
            excludes: [],
            loading: false,
            checkAll: false,
            pagination: {},
            loading: false,
            timer: null,
            documents: []
        };
    },
    computed: {},
    methods: {
        cancelOrden(id) {
            this.$emit("cancelOrden");
        },
        insertOrdenQuotation(quotation_id, identifier, item, customer_number) {
            this.$emit(
                "insertOrdenQuotation",
                quotation_id,
                identifier,
                item,
                customer_number
            );
            this.close();
        },
        clickLiquidate(record) {
            this.showDialogPayment = true;
            this.recordPayment = record;
        },
        clickExportDocuments(record) {
            window.open(
                `/${this.resource}/consolidateds/${record.id}/export-documents`
            );
        },
        clickExportDocumentsDetail(record) {
            window.open(
                `/${this.resource}/consolidateds/${record.id}/export-documents-detail`
            );
        },
        clickReport() {
            window.open(`/${this.resource}/consolidateds/${record.id}/report`);
        },
        query() {
            return querystring.stringify({
                number: this.form.number,
                date: this.form.date,
                page: this.pagination.current_page
            });
        },
        getRecordsTimer() {
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(() => {
                this.getRecords();
            }, 500);
        },
        clickExport(record) {
            window.open(`/${this.resource}/consolidateds/${record.id}/export`);
        },
        clickExportDelivery(record) {
            window.open(
                `/${this.resource}/consolidateds/${record.id}/export-delivery`
            );
        },
        customIndex(index) {
            return (
                this.pagination.per_page * (this.pagination.current_page - 1) +
                index +
                1
            );
        },
        open() {
            this.documents = [];
            this.checkAll = false;
            this.excludes = [];
            this.pagination = {};
            this.getRecords();
        },
        assignDocument(q) {
            let document = {};
            document.establishment_id = q.establishment_id;
            document.date_of_issue = q.date_of_issue;
            document.time_of_issue = moment().format("HH:mm:ss");
            document.customer_id = q.customer_id;
            document.currency_type_id = q.currency_type_id;
            document.purchase_order = null;
            document.exchange_rate_sale = q.exchange_rate_sale;
            document.total_prepayment = q.total_prepayment;
            document.total_charge = q.total_charge;
            document.total_discount = q.total_discount;
            document.total_exportation = q.total_exportation;
            document.total_free = q.total_free;
            document.total_taxed = q.total_taxed;
            document.total_unaffected = q.total_unaffected;
            document.total_exonerated = q.total_exonerated;
            document.total_igv = q.total_igv;
            document.total_base_isc = q.total_base_isc;
            document.total_isc = q.total_isc;
            document.total_base_other_taxes = q.total_base_other_taxes;
            document.total_other_taxes = q.total_other_taxes;
            document.total_taxes = q.total_taxes;
            document.total_value = q.total_value;
            document.total = q.total;
            document.seller_id = q.seller_id;
            document.operation_type_id = "0101";
            // this.document.date_of_due = q.date_of_issue
            document.items = q.items;
            document.charges = q.charges;
            document.discounts = q.discounts;
            document.attributes = [];
            document.guides = q.guides;
            document.additional_information = null;
            document.actions = {
                format_pdf: "a4"
            };
            document.quotation_id = q.id;
        },
        async clickEmit(document) {
            let url =
                document.document_type_id == "80" ? "sale-notes" : "documents";
            try {
                this.loading = true;
                const response = await this.$http.post(`/${url}`, document);
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        async clickPrint(record) {
            let has_print = record.hasPrint;
            let message = has_print
                ? "¿Desea imprimir los documentos?"
                : "¿Desea emitir los documentos?";
            this.$confirm(message, "Imprimir", {
                confirmButtonText: "Sí",
                cancelButtonText: "No",
                type: "warning"
            })
                .then(() => {
                    this.$http
                        .get(
                            `/${this.resource}/consolidateds/${record.id}/print`
                        )
                        .then(async response => {
                            let { data } = response;
                            this.documents = data.documents;
                            let message = data.message;
                            let has_print = data.has_print;
                            if (!has_print) {
                                 for (const document of this.documents) {
                                     await this.clickEmit(document);
                                 }
                                this.getRecords();
                            }

                            this.$message.success(message);
                        })
                        .catch(error => {
                            console.error(error);
                        });
                })
                .catch(() => {});
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/${this.resource}/consolidateds?${this.query()}`
                );
                this.pagination = response.data.meta;
                this.pagination.current_page = Number(
                    this.pagination.current_page
                );
                this.records = response.data.data.map(record => {
                    return {
                        ...record,
                        checked: true
                    };
                });
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>

<style></style>
