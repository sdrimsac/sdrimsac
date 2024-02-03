<template>
    <div v-loading="loading">
        <div class="container table-responsive col-md-12">
            <table
                class="table table-hover table-striped table-condensed  table-responsive"
                style="width:100%;     white-space: nowrap;"
            >
                <thead>
                    <tr>
                        <th v-if="type == 'documents'">SUNAT</th>
                        <th v-if="type == 'saleNotes'">Acciones</th>
                        <th>
                            Acciones
                        </th>
                        <th>
                            Número
                        </th>
                        <th>Fecha</th>
                        <th>
                            Cliente
                        </th>
                        <th v-if="type == 'documents'">
                            N/V
                        </th>
                        <th>
                            Estado
                        </th>
                        <th v-if="type == 'documents'">
                            Saldo
                        </th>
                        <th>
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(data, idx) in records"
                        :key="idx"
                        :class="
                            `${
                                data.state_type_id == '11' ||
                                data.state_type_id == '13'
                                    ? 'bg-danger text-white'
                                    : ''
                            }`
                        "
                    >
                        <td
                            :class="
                                `${data.state_type_id != '11' &&
                                    data.state_type_id != '13' &&
                                    'text-white'}`
                            "
                            v-if="type == 'documents'"
                        >
                            <div
                                class="dropdown-as-select d-inline-block"
                                data-childselector="span"
                            >
                                <button
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                    class="btn p-0"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-delay="0"
                                        title=""
                                        data-bs-original-title="Item Count"
                                        aria-label="Item Count"
                                        ><i class="fas fa-list"></i
                                    ></span>
                                </button>

                                <div
                                    class="dropdown-menu dropdown-menu-end col-md-2 col-1"
                                >
                                    <template>
                                        <template
                                            v-if="configuration.caja_actions"
                                        >
                                            <el-button
                                                class="col-md-12 col-12"
                                                v-if="
                                                    data.state_type_id == '01'
                                                "
                                                @click="
                                                    clickDeleteDocument(data.id)
                                                "
                                            >
                                                Anular internamente
                                            </el-button>
                                            <br
                                                v-if="
                                                    data.state_type_id == '01'
                                                "
                                            />
                                            <el-button
                                                v-if="
                                                    data.document_type_id ==
                                                        '01' &&
                                                        data.state_type_id ==
                                                            '05'
                                                "
                                                class="col-md-12 col-12"
                                                @click="clickVoided(data.id)"
                                            >
                                                Anular sunat
                                            </el-button>
                                            <br
                                                v-if="
                                                    data.document_type_id ==
                                                        '01'
                                                "
                                            />
                                            <el-button
                                                v-if="
                                                    data.state_type_id == '05'
                                                "
                                                class="col-md-12 col-12"
                                                @click="clickNote(data.id)"
                                            >
                                                Nota de crédito
                                            </el-button>
                                            <br
                                                v-if="
                                                    data.state_type_id == '05'
                                                "
                                            />
                                            <el-button
                                                v-if="data.is_credit"
                                                class="col-md-12 col-12"
                                                @click="clickPayment(data.id)"
                                            >
                                                Pagos
                                            </el-button>
                                            <br v-if="data.is_credit" />
                                        </template>
                                    </template>
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                data.document_type_id == '01'
                                        "
                                        @click="clickReStore(data.id)"
                                    >
                                        Recrear
                                    </el-button>
                                    <br
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                data.document_type_id == '01'
                                        "
                                    />
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        plain
                                        @click="clickSendOnline(data.id)"
                                    >
                                        Reenviar
                                    </el-button>
                                    <br
                                        v-if="
                                            type == 'documents' &&
                                                data.document_type_id == '01'
                                        "
                                    />

                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        @click="clickValidarCpe(data.id)"
                                    >
                                        Validar cpe
                                    </el-button>
                                    <br
                                        v-if="
                                            type == 'documents' &&
                                                data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                    />

                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        @click="clickGenerateGuie(data.id)"
                                    >
                                        Guia
                                    </el-button>
                                </div>
                            </div>
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                            v-if="type == 'saleNotes'"
                        >
                            <div
                                class="dropdown-as-select d-inline-block"
                                data-childselector="span"
                            >
                                <button
                                    v-if="
                                        data.state_type_id != '11' &&
                                            data.state_type_id != '13'
                                    "
                                    class="btn p-0"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <span
                                        class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-delay="0"
                                        title=""
                                        data-bs-original-title="Item Count"
                                        aria-label="Item Count"
                                        ><i class="fas fa-list"></i
                                    ></span>
                                </button>

                                <div
                                    class="dropdown-menu dropdown-menu-end col-md-2 col-1"
                                >
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13' &&
                                                !data.changed
                                        "
                                        @click="clickGenerate(data.id)"
                                    >
                                        Generar comprobantes
                                    </el-button>
                                    <br
                                        v-if="
                                            (data.state_type_id != '11' ||
                                                data.state_type_id != '13') &&
                                                !data.changed
                                        "
                                    />
                                    <el-button
                                        class="col-md-12 col-12"
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                        @click="
                                            clickGenerateGuie(data.id, '80')
                                        "
                                    >
                                        Guia
                                    </el-button>
                                    <br
                                        v-if="
                                            data.state_type_id != '11' &&
                                                data.state_type_id != '13'
                                        "
                                    />
                                    <template v-if="configuration.caja_actions">
                                        <el-button
                                            class="col-md-12 col-12"
                                            v-if="
                                                data.state_type_id != '11' &&
                                                    data.state_type_id != '13'
                                            "
                                            @click="clickVoidedNote(data.id)"
                                        >
                                            Anular internamente
                                        </el-button>
                                    </template>
                                </div>
                            </div>
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                        >
                            <template
                                v-if="
                                    type == 'quotations' &&
                                        data.state_type_id != '11'
                                "
                            >
                                <el-tooltip content="Generar documento">
                                    <el-button
                                        size="mini"
                                        style="margin-bottom:3px;"
                                        @click="clickOptionsQuotation(data.id)"
                                    >
                                        <i class="fas fa-file-import"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Editar">
                                    <el-button
                                        size="mini"
                                        style="margin-bottom:3px;"
                                        @click="clickEditQuotation(data.id)"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Anular">
                                    <el-button
                                        @click="clickAnulateQuotation(data.id)"
                                        type="danger"
                                        size="mini"
                                        style="margin-bottom:3px;"
                                    >
                                        <i class="fas fa-ban"></i>
                                    </el-button>
                                </el-tooltip>
                            </template>
                            <el-button
                                v-if="
                                    data.state_type_id != '11' &&
                                        data.state_type_id != '13'
                                "
                                size="mini"
                                type="success"
                                style="margin-bottom:3px;"
                                @click="clickOpenWhatsapp(data)"
                            >
                                <i
                                    class="fab fa-whatsapp"
                                    aria-hidden="true"
                                ></i>
                            </el-button>

                            <el-button
                                v-if="
                                    data.state_type_id != '11' &&
                                        data.state_type_id != '13' &&
                                        configuration.print_document_cash
                                "
                                size="mini"
                                plain
                                @click="
                                    print(
                                        data.external_id,
                                        data.document_type_id
                                    )
                                "
                            >
                                <i class="fas fa-print"></i>
                            </el-button>
                            <el-button
                                size="mini"
                                plain
                                @click="
                                    previsualitation(
                                        data.external_id,
                                        data.document_type_id
                                    )
                                "
                            >
                                <i class="far fa-file-pdf"></i>
                            </el-button>
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                        >
                            <template v-if="type == 'saleNotes'">
                                {{ data.full_number }}
                            </template>
                            <template v-if="type == 'documents'">
                                {{ data.number }}
                            </template>
                            <template v-if="type == 'quotations'">
                                {{ data.identifier }}
                            </template>
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                        >
                            {{ data.date_of_issue }}
                            <br />
                            <small>
                                {{ data.time_of_issue }}
                            </small>
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                        >
                            {{ data.customer_name }} <br />
                            <span class="text-muted">{{
                                data.customer_number
                            }}</span>
                            <template
                                v-if="type == 'saleNotes' && data.variation"
                            >
                                <br />
                                <small>
                                    <span
                                        >{{ data.variation.series }}-{{
                                            data.variation.number
                                        }}
                                        /
                                    </span>
                                    <span>
                                        {{ data.variation.customer.name }}
                                    </span>
                                    <span>
                                        {{
                                            data.variation.customer.number
                                        }}</span
                                    >
                                </small>
                            </template>
                        </td>
                        <td v-if="type == 'documents'">
                            <template
                                v-for="(row, index) in data.sale_note_related"
                            >
                                <small class="d-block" :key="index">{{
                                    row.number
                                }}</small>
                            </template>
                        </td>
                        <td
                            :class="
                                `${
                                    data.state_type_description == 'Aceptado'
                                        ? 'text-success'
                                        : data.state_type_description ==
                                              'Anulado' ||
                                          data.state_type_description ==
                                              'Por anular'
                                        ? 'text-white'
                                        : data.state_type_description ==
                                          'Enviado'
                                        ? 'text-primary'
                                        : 'text-black'
                                }`
                            "
                        >
                            <b> {{ data.state_type_description }}</b>
                        </td>
                        <td v-if="type == 'documents'" class="text-warning">
                            {{ data.remain > 0 ? data.remain : "" }}
                        </td>
                        <td
                            :class="
                                `${(data.state_type_id == '11' ||
                                    data.state_type_id == '13') &&
                                    'text-white'}`
                            "
                        >
                            {{ data.total }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
        ></el-pagination>
        <br /><br /><br /><br />
        <br />
        <br />
        <whatsapp-modal
            :documentNumber="currentNumber"
            :company="company"
            :documentId="currentId"
            :documentTypeId="currentType"
            :showDialog.sync="showWhatsappModal"
            :sender="sender"
            :establishment.sync="establishment"
        >
        </whatsapp-modal>

        <template v-if="type == 'quotations'">
            <quotation-options
                :showDialog.sync="showDialogOptions"
                :recordId="quotationId"
                :showGenerate="true"
                :showClose="true"
            ></quotation-options>
            <quotation-edit-modal
                :showDialog.sync="showEditQuotationDialog"
                :recordId="quotationId"
            ></quotation-edit-modal>
        </template>
        <document-print-previsualitation
            :resource="resourcePdf"
            :showDialog.sync="showPrevisualitation"
        >
        </document-print-previsualitation>

        <sale-note-generate
            :configuration="configuration"
            :showDialog.sync="showDialogGenerate"
            :recordId="currentId"
            :showGenerate="true"
            :showClose="false"
            :fromCaja="true"
            @getRecords="getRecords"
        ></sale-note-generate>
        <create-dispatch
            :showDialog.sync="showCreateDispatch"
            :type="currentType"
            :recordId="currentId"
            :configuration="configuration"
        >
        </create-dispatch>

        <documents-voided
            :external="true"
            @getRecords="getRecords"
            :showDialog.sync="showDialogVoided"
            :recordId="recordId"
        ></documents-voided>
        <documents-payments
            @getRecords="getRecords"
            :external="true"
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
        ></documents-payments>
        <note-modal
            :configuration="configuration"
            :showDialog.sync="showNoteModal"
            :recordId.sync="recordId"
            @getRecords="getRecords"
        >
        </note-modal>
    </div>
</template>

<script>
const DocumentsVoided = () =>
    import(
        "../../../../../../../../resources/js/views/documents/partials/voided.vue"
    );
const DocumentsPayments = () =>
    import(
        "../../../../../../../../resources/js/views/documents/partials/payments.vue"
    );
import whatsappModal from "./whatsapp_modal.vue";
import { deletable } from "../../../../../../../../resources/js/mixins/deletable";
const DocumentPrintPrevisualitation = () =>
    import("./document_print_previsualitation.vue");
const QuotationEditModal = () => import("./quotation_edit_modal.vue");
const QuotationOptions = () =>
    import(
        "../../../../../../../../resources/js/views/quotations/partials/options.vue"
    );
const SaleNoteGenerate = () =>
    import(
        "../../../../../../../../resources/js/views/sale_notes/partials/option_documents.vue"
    );
const CreateDispatch = () => import("./create_dispatch.vue");
const NoteModal = () => import("./note_modal.vue");
export default {
    components: {
        whatsappModal,
        QuotationOptions,
        QuotationEditModal,
        DocumentPrintPrevisualitation,
        SaleNoteGenerate,
        CreateDispatch,
        DocumentsVoided,
        DocumentsPayments,
        NoteModal
    },
    mixins: [deletable],
    props: [
        "records",
        "pagination",
        "type",
        "company",
        "sender",
        "establishment",
        "configuration"
    ],
    data() {
        return {
            resourcePdf: null,
            showPrevisualitation: false,
            loading: false,
            showWhatsappModal: false,
            currentId: null,
            currentType: null,
            currentNumber: null,
            showDialogOptions: false,
            recordId: null,
            quotationId: null,
            showDialogVoided: false,
            showEditQuotationDialog: false,
            showDialogGenerate: false,
            currentType: null,
            showCreateDispatch: false,
            showDialogPayments: false,
            showNoteModal: false
        };
    },

    methods: {
        clickVoidedNote(id) {
            this.anular(`/sale-notes/anulate/${id}`).then(() =>
                this.$emit("getRecords")
            );
        },
        clickNote(id) {
            this.recordId = id;
            this.showNoteModal = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickVoided(recordId) {
            this.recordId = recordId;
            this.showDialogVoided = true;
        },
        clickDeleteDocument(document_id) {
            this.destroy(`/documents/delete_document/${document_id}`).then(() =>
                this.$emit("getRecords")
            );
        },
        clickGenerateGuie(recordId, type = "03") {
            this.currentId = recordId;
            this.currentType = type;
            this.showCreateDispatch = true;
        },
        clickGenerate(recordId) {
            this.currentId = recordId;
            this.showDialogGenerate = true;
        },
        previsualitation(external_id, type) {
            let url = null;
            if (type == "80") {
                url = `/sale-notes/print/${external_id}/ticket`;
            } else if (type == "03" || type == "01") {
                url = `/print/document/${external_id}/ticket`;
            } else {
                url = `/quotations/print/${external_id}/ticket`;
            }
            this.resourcePdf = url;
            this.showPrevisualitation = true;
        },
        clickAnulateQuotation(id = null) {
            this.anular(`/quotations/anular/${id}`).then(
                () => this.$emit("getRecords")
                // this.$eventHub.$emit("reloadData")
            );
        },
        clickEditQuotation(recordId = null) {
            this.quotationId = recordId;
            this.showEditQuotationDialog = true;
        },
        clickOptionsQuotation(recordId = null) {
            this.quotationId = recordId;
            this.showDialogOptions = true;
        },
        clickOpenWhatsapp(record) {
            console.log(this.establishment, " mode");
            this.showWhatsappModal = true;
            this.currentId = record.id;
            this.currentType = record.document_type_id || "COT";
            if (this.type == "saleNotes") {
                this.currentNumber = record.full_number;
            } else if (this.type == "documents") {
                this.currentNumber = record.number;
            } else {
                this.currentNumber = record.identifier;
            }
        },
        async clickSendOnline(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/send/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(
                        "Se envio satisfactoriamente el comprobante."
                    );
                    this.$eventHub.$emit("reloadData");

                    // this.clickCheckOnline(document_id);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        async clickReStore(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/re_store/${document_id}`
                );
                console.log(response);
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },

        async clickValidarCpe(document_id) {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/documents/validate/${document_id}`
                );

                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$emit("getRecords", this.pagination.current_page);
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                this.$toast.error(error.response.data.message);
            } finally {
                this.loading = false;
            }
        },
        getRecords() {
            this.$emit("getRecords", this.pagination.current_page);
        },
        print(external_id, type) {
            this.$emit("printData", external_id, type);
        }
    }
};
</script>
