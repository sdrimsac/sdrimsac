<template>
    <el-dialog
        :visible="showDialog"
        append-to-body
        @close="close"
        @open="open"
        width="60%"
        v-loading="loading"
        title="Imprimir documento"
    >
        <div class="card p-2">
            <div class="d-flex">
                <div class="col-6 p-1 col-md-3">
                    <el-select v-model="typeSearch">
                        <el-option value="document" label="N° documento">
                        </el-option>
                        <el-option value="client" label="Cliente"></el-option>
                        <el-option value="date" label="Fecha"></el-option>
                    </el-select>
                </div>
                <div class="col-6 p-1 col-md-3">
                    <el-input
                        @input="getRecordsInput"
                        v-if="typeSearch != 'date'"
                        v-model="value"
                    ></el-input>
                    <el-date-picker
                        value-format="yyyy-MM-dd"
                        @change="getRecordsInput"
                        v-else
                        v-model="value"
                    ></el-date-picker>
                </div>
                <div
                    class="col-6 p-1-col-md-3
                d-flex align-items-end justify-content-start
                "
                    v-if="activeName == 'documents'"
                >
                    <el-checkbox v-model="remain" @change="getRecordsInput"
                        >Saldos</el-checkbox
                    >
                </div>
            </div>
            <div class="mt-1 d-flex align-items-center justify-content-between">
                <div>
                    <button
                    v-if="activeName == 'saleNotes'"
                        @click.prevent="onOpenModalGenerateCPE"
                        type="button"
                        class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                    >
                        <span>
                            Generar comprobante desde múltiples Notas
                        </span>
                    </button>
                </div>
                <div>
                    <span class="p-1"
                        >Ultimo documento emitido:
                        {{
                            lastDocument
                                ? lastDocument.numberPrint
                                : "No se encontró"
                        }}</span
                    >
                    <el-button
                        class="btn btn-primary"
                        @click="
                            printData(
                                lastDocument.external_id,
                                lastDocument.document_type_id
                            )
                        "
                    >
                        <i class="fas fa-print"></i>
                    </el-button>
                </div>
            </div>
            <div>
                <el-tabs v-model="activeName" @tab-click="handleClick">
                    <el-tab-pane label="Notas de venta" name="saleNotes">
                        <document-print-detail
                            :configuration="config"
                            :company="company"
                            @getRecords="getRecords"
                            @printData="printData"
                            :records.sync="saleNotes"
                            :pagination.sync="pagination.saleNotes"
                            :type="'saleNotes'"
                            :sender="sender"
                            :establishment.sync="establishment"
                        >
                        </document-print-detail>
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="company.soap_type_id != '03'"
                        label="Facturas - Boletas"
                        name="documents"
                    >
                        <document-print-detail
                            :configuration="config"
                            :sender="sender"
                            :company="company"
                            @getRecords="getRecords"
                            @printData="printData"
                            :records.sync="documents"
                            :pagination.sync="pagination.documents"
                            :type="'documents'"
                            :establishment.sync="establishment"
                        >
                        </document-print-detail>
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="config.quotation"
                        label="Cotizaciones"
                        name="quotations"
                    >
                        <document-print-detail
                            :configuration="config"
                            :sender="sender"
                            :company="company"
                            @getRecords="getRecords"
                            @printData="printData"
                            :records.sync="quotations"
                            :pagination.sync="pagination.quotations"
                            :type="'quotations'"
                            :establishment.sync="establishment"
                        >
                        </document-print-detail>
                    </el-tab-pane>
                </el-tabs>
            </div>
            <modal-generate-cpe
            :show.sync="showModalGenerateCPE"
            @sendItems="sendItems"
            @close="closeCpe"
            >

            </modal-generate-cpe>
        </div>
    </el-dialog>
</template>
<style>
.el-dialog__header {
    background-color: var(--primary) !important;
}
.el-dialog__title {
    color: var(--light-text) !important;
}
.el-dialog__headerbtn .el-dialog__close {
    color: white !important;
}
</style>
<script>
import DocumentPrintDetail from "./document_print_detail.vue";
import queryString from "query-string";
import ModalGenerateCpe from "./modal_generate_cpe.vue";

export default {
    components: { DocumentPrintDetail,ModalGenerateCpe },
    props: ["showDialog", "company", "sender", "config", "establishment"],
    data() {
        return {
            remain: false,
            time: null,
            loading: false,
            value: null,
            typeSearch: "document",
            saleNotes: [],
            documents: [],
            quotations: [],
            pagination: {
                saleNotes: {},
                documents: {},
                quotations: {}
            },
            printer: null,
            lastDocument: null,
            activeName: "documents",
            showModalGenerateCPE:false,
        };
    },
    methods: {
        closeCpe(){
             this.showModalGenerateCPE = false;
             this.close();
        },
        onOpenModalGenerateCPE() {
               this.showModalGenerateCPE = true;
        },
        getRecordsInput() {
            this.getRecords();
        },
        sendItems(items,clientNumber,notes,dscto_global){
            this.$emit("sendItems", items,clientNumber,notes,dscto_global);
        },
        async printEvent(url) {
            console.log(url);
            let paperConfig = {
                scaleContent: false
            };
            let partsUrl = url.split("/");
            let document = partsUrl[partsUrl.length - 1];
            let isTicket = document.toLowerCase().includes("ticket");
            let isA4 = document.toLowerCase().includes("a4");
            let isA5 = document.toLowerCase().includes("a5");
            let tipoBandejaImpresora = this.config.new_old_printer;
            if (isA4) {
                if (tipoBandejaImpresora == 1) {
                    paperConfig.density = 700;
                    paperConfig.orientation = "portrait";
                } else {
                    paperConfig.density = 350;
                    paperConfig.orientation = "portrait";
                }
            } else {
                let orientation = "portrait";
                if (isA5) {
                    let { a5_orientation } = this.config;
                    orientation = a5_orientation ? "landscape" : "portrait";
                }
                if (!isTicket && tipoBandejaImpresora == 1) {
                    //opciones que permiten hacer una impresion correcta en impresoras nuevas
                    paperConfig.density = 600;
                    paperConfig.orientation = orientation;
                    paperConfig.margins = { left: 2 };
                } else if (!isTicket && tipoBandejaImpresora == 0) {
                    paperConfig.density = 350;
                    paperConfig.orientation = orientation;
                    let margins = {};
                    if (orientation == "landscape") {
                        margins = {
                            top: 1.1,
                            left: 0.95,
                            right: 0.3,
                            bottom: 1.1
                        };
                    } else {
                        margins = {
                            left: 1.5
                        };
                    }
                    paperConfig.margins = margins;
                }
            }

            try {
                let config = qz.configs.create(this.printer, paperConfig);
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: url
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            } catch (e) {}
        },
        async printData(external_id, type) {
            console.log(external_id, type);
            let typePrint = this.establishment.format_printer;
            let url = "";
            //colocar una condicion para cada caso desde impresira de 80mm hasta las a4 y a5
            if (typePrint == "1") {
                //tamaño a4
                if (type == "80") {
                    url = `/sale-notes/print/${external_id}/a4`;
                } else if (type == "03" || type == "01") {
                    url = `/print/document/${external_id}/a4`;
                } else {
                    url = `/quotations/print/${external_id}/a4`;
                }
            }
            if (typePrint == "2") {
                //tamaño a5
                if (type == "80") {
                    url = `/sale-notes/print/${external_id}/a5`;
                } else if (type == "03" || type == "01") {
                    url = `/print/document/${external_id}/a5`;
                } else {
                    url = `/quotations/print/${external_id}/a5`;
                }
            }
            if (typePrint == "3" || typePrint == null) {
                //tamaño 80mm
                if (type == "80") {
                    url = `/sale-notes/print/${external_id}/ticket`;
                } else if (type == "03" || type == "01") {
                    url = `/print/document/${external_id}/ticket`;
                } else {
                    url = `/quotations/print/${external_id}/ticket`;
                }
            }
            if (typePrint == "4") {
                //tamaño 50mm
                if (type == "80") {
                    url = `/sale-notes/print/${external_id}/ticket_50`;
                } else if (type == "03" || type == "01") {
                    url = `/print/document/${external_id}/ticket_50`;
                } else {
                    url = `/quotations/print/${external_id}/ticket_50`;
                }
            }
            //console.log(config.direct_printing)

            if (this.establishment.direct_printing == 0) {
                window.open(url, "_blank");
            } else {
                await this.printEvent(url);
            }
        },
        async getLastDocument() {
            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/worker/print_last_document`
                );

                if (response.status == 200) {
                    const {
                        data: { document }
                    } = response;
                    this.lastDocument = document;
                    let filename = this.lastDocument.filename.split("-");
                    this.lastDocument.numberPrint =
                        filename[2] + "-" + filename[3];
                }
            } catch (e) {
                this.$toast.error("No se pudo obtener el ultimo documento");
            } finally {
                this.loading = false;
            }
        },
        async getPrinter() {
            const response = await this.$http(
                `/caja/worker/cash/get_printer/${this.area_id}`
            );

            let {
                data: { printer }
            } = response;
            this.printer = printer;
        },
        getRecords(page = 1) {
            if (this.activeName == "saleNotes") {
                this.pagination.saleNotes.current_page = Number(page);
            } else {
                this.pagination.documents.current_page = Number(page);
            }
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                await this.getLastDocuments();
            }, 500);
        },
        getQueryParameters(form = {}) {
            let page =
                this.activeName == "saleNotes"
                    ? this.pagination.saleNotes.current_page
                    : this.pagination.documents.current_page;
            return queryString.stringify({
                page:
                    this.activeName == "saleNotes"
                        ? this.pagination.saleNotes.current_page
                        : this.pagination.documents.current_page,
                isNote: this.activeName == "saleNotes",
                typeDocument: this.activeName,
                column: this.typeSearch,
                value: this.value,
                remain: this.remain

                // limit: this.limit
            });
        },
        handleClick() {
            this.remain = false;
            if (
                this.saleNotes.length == 0 ||
                this.documents.length == 0 ||
                this.quotations.length == 0
            ) {
                this.getLastDocuments();
            }
        },
        async open() {
            console.log(this.config);
            await this.getLastDocument();
            await this.getLastDocuments();
            await this.getPrinter();
        },
        close() {
            this.$emit("update:showDialog", false);
        },

        async getLastDocuments() {
            //"/sale-notes/print/{$doc->external_id}/ticket
            //"/print/document/{$doc->external_id}/ticket";

            try {
                this.loading = true;
                const response = await this.$http(
                    `/caja/worker/cash/get_last_documents?${this.getQueryParameters()}`
                );

                if (response.status != 200) {
                    this.$toast.error("No se pudo imprimir");
                } else {
                    const { data, meta } = response.data;
                    if (this.activeName == "saleNotes") {
                        this.saleNotes = data;
                        this.pagination.saleNotes = meta;
                    } else if (this.activeName == "quotations") {
                        this.quotations = data;
                        this.pagination.quotations = meta;
                    } else {
                        this.documents = data;
                        if (this.remain) {
                            this.documents = this.documents.filter(
                                document => document.remain > 0
                            );
                        }
                        this.pagination.documents = meta;
                    }
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("No se pudo imprimir");
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
