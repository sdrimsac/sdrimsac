<template>
    <el-dialog title="Detracción" :visible="showDialog" @close="close" width="80%" :show-close="true">
        <!-- <div class="d-flex justify-content-end ">
            <button @click="close" type="button" class="btn btn-primary btn-sm">
                <i class="el-icon-close"></i>
            </button>
        </div> -->
        <!-- Listado de Comprobante de Pago  caja y Administracion -->
        <template>
            <div>
                <!-- <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Comprobantes con detracciones</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Documentos - Detracciones</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> -->
                <!-- Container-fluid starts-->
                <div class="container-fluid p-l-0 p-r-0">
                    <div class="row">
                            

                            <div class="">
                                <data-table :resource="resource" class="table-striped">
                                    <tr slot="heading" class="bg-primary">
                                        <th class="text-white" style="width: 10px;">#</th>
                                        <th class="text-white" style="width: 100px;">CPE</th>
                                        <!-- <th class="text-white">Fecha emisión</th> -->
                                        <th class="text-white" style="width: 250px;">Código</th>
                                        <th class="text-white text-end" style="width: 110px;">
                                            %
                                        </th>
                                        <th class="text-white text-end" style="width: 110px;">Total</th>
                                        <th class="text-white text-end" style="width: 110px;">Pagado</th>
                                        <th class="text-white text-end" style="width: 110px;">
                                            Pendiente
                                        </th>
                                        <th class="text-white text-end" style="width: 90px;"></th>
                                    </tr>

                                    <tr></tr>
                                    <tr slot-scope="{ index, row }" :class="{
                                        'text-danger':
                                            row.state_type_id === '11',
                                        'border border-secondary':
                                            row.state_type_id === '01',
                                        'border border-warning':
                                            row.state_type_id === '03',
                                        'border border-primary':
                                            row.state_type_id === '05',
                                        'border border-info':
                                            row.state_type_id === '07',
                                        'border border-dark':
                                            row.state_type_id === '09',
                                        'border border-danger':
                                            row.state_type_id === '11',
                                        'border border-warnnig':
                                            row.state_type_id === '13'
                                    }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                        <td>{{ index }}</td>
                                        <td>
                                            {{ row.number_full }}
                                            </br>
                                            {{ row.date_of_issue }}
                                        </td>
                                        <!-- <td></td> -->
                                        <td>
                                            {{ row.code }}
                                            </br>
                                            {{ row.detraction_description }}
                                        </td>
                                        <td class="text-end">
                                            {{ row.percentage }}%
                                        </td>
                                        <td class="text-end">{{ Number(row.amount).toFixed(2) }}</td>
                                        <td class="text-end">
                                            {{ Number(row.paid).toFixed(2) }}
                                        </td>
                                        <td class="text-end">
                                            {{ Number(row.pending_payment).toFixed(2) }}
                                        </td>
                                        <td class="text-center">
                                            <el-button class="btn_guardarsmall" type="primary" icon="el-icon-bank-card"
                                                size="mini" @click="clickPayment(row.id)">
                                                Pagos
                                            </el-button>
                                        </td>
                                    </tr>
                                </data-table>
                            </div>

                        <!-- </div> -->
                    </div>
                </div>
                <detraction-payments :documentId="recordId" :showDialog.sync="showDialogPayments"></detraction-payments>
                <br>
            </div>

        </template>

       


        <!-- <detraction-index> </detraction-index> -->
    </el-dialog>
</template>

<style scoped>
  .table-striped tr:nth-child(even) {
                background-color: #f2f2f2;
            }
</style>

<!-- <script>
// import DetractionIndex from "@views/documents/detractions/index.vue";
export default {
    props: ["showDialog"],
    components: {
        DetractionIndex
    },
    data() {
        return {};
    },
    methods: {
        close() {
            this.$emit('update:showDialog', false);
        }
    }
};
</script> -->

<script>

import DataTable from "../../../../../../../../resources/js/components/DataTableDocuments.vue";

import { deletable } from "../../../../../../../../resources/js/mixins/deletable.js";

import DetractionPayments from "../../../../../../../../resources/js/views/documents/detractions/detraction_payments.vue";
export default {
    mixins: [deletable],
    props: [
        "showDialog"
    ],
    components: {
        DataTable,
        DetractionPayments
    },
    data() {
        return {
            showDialogDocumentSalud: false,
            showDialogReportPayment: false,
            showDialogVoided: false,
            showImportDialog: false,
            showDialogCDetraction: false,
            showDialogValidate: false,
            showImportSecondDialog: false,
            resource: "documents_detraction",
            recordId: null,
            showDialogOptions: false,
            showDialogPayments: false,
            closeBox: false,
            showDialogEdit: false,
            loading_data: false,
            editDocument: false,
            print: false,
            columns: {
                sale_note: {
                    title: "Nota de venta",
                    visible: true
                },
                dispatch: {
                    title: "Guia de remisión",
                    visible: true
                },
                igv: {
                    title: "T.Igv",
                    visible: false
                },
                total_value: {
                    title: "T. Gravado",
                    visible: false
                },
                boxes: {
                    title: "Metodo de pago",
                    visible: true
                },
                notes: {
                    title: "Notas C/D",
                    visible: false
                },
                user_name: {
                    title: "Usuario",
                    visible: true
                },
                total_exportation: {
                    title: "T.Exportación",
                    visible: false
                },
                total_free: {
                    title: "T.Gratuito",
                    visible: false
                },
                total_unaffected: {
                    title: "T.Inafecto",
                    visible: false
                },
                total_exonerated: {
                    title: "T.Exonerado",
                    visible: false
                },
                date_of_due: {
                    title: "F. Vencimiento",
                    visible: false
                }
            }
        };
    },
    created() {
        // this.$http.get(`/${this.resource}/tables`)
        //         .then(response => {
        //           this.closeBox=response.data.closebox
        //         })
    },
    methods: {
         close() {
            this.$emit('update:showDialog', false);
        },
        clickDocumentSalud() {
            this.showDialogDocumentSalud = true;
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F3") {
                    //Agregar cliente
                    location.href = `/${this.resource}/create`;
                }
            };
        },

        clickVoided(recordId = null) {
            this.recordId = recordId;
            this.showDialogVoided = true;
        },
        clickNuevo() {
            location.href = `/${this.resource}/create`;
        },
        clickDownload(download) {
            window.open(download, "_blank");
        },
        clickResend(document_id) {
            this.$http
                .get(`/${this.resource}/send/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickSendOnline(document_id) {
            this.$http
                .get(`/${this.resource}/send_server/${document_id}/1`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(
                            "Se envio satisfactoriamente el comprobante."
                        );
                        this.$eventHub.$emit("reloadData");

                        this.clickCheckOnline(document_id);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickCheckOnline(document_id) {
            this.$http
                .get(`/${this.resource}/check_server/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success("Consulta satisfactoria.");
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickCDetraction(recordId) {
            this.recordId = recordId;
            this.showDialogCDetraction = true;
        },
        async checkResume() {
            try {
                this.loading_data = true;
                const response = await this.$http.get(
                    `/documents/check_summarie`
                );
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$eventHub.$emit("reloadData");
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (e) {
                this.$toast.error(e.response.data.message);
            } finally {
                this.loading_data = false;
            }
        },
        async clickResume() {
            try {
                this.loading_data = true;
                const response = await this.$http.get(
                    `/documents/create_summarie`
                );
                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.$eventHub.$emit("reloadData");
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (e) {
                this.$toast.error(e.response.data.message);
            } finally {
                this.loading_data = false;
            }
        },
        clickValidarCpe(document_id) {
            this.loading_data = false;
            this.$http
                .get(`/${this.resource}/validate/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                    this.loading_data = false;
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                    this.loading_data = false;
                });
            this.loading_data = false;
        },
        clickEdit(recordId = null) {
            location.href = `/${this.resource}/create/${recordId}`;
        },
        clickOptions(recordId = null, printer) {
            this.recordId = recordId;
            this.showDialogOptions = true;
            this.print = printer;
        },
        clickReStore(document_id) {
            this.$http
                .get(`/${this.resource}/re_store/${document_id}`)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        tooltip(row, message = true) {
            if (message) {
                if (row.shipping_status) return row.shipping_status.message;

                if (row.sunat_shipping_status)
                    return row.sunat_shipping_status.message;

                if (row.query_status) return row.query_status.message;
            }

            if (
                row.shipping_status ||
                row.sunat_shipping_status ||
                row.query_status
            )
                return true;

            return false;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickChangeToRegisteredStatus(document_id) {
            this.$http
                .get(
                    `/${this.resource}/change_to_registered_status/${document_id}`
                )
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                });
        },
        clickImport() {
            this.showImportDialog = true;
        },
        clickValidate() {
            this.showDialogValidate = true;
        },
        clickDownloadReportPagos(type) {
            window.open(`/${this.resource}/payments/${type}`, "_blank");
        },
        clickImportSecond() {
            this.showImportSecondDialog = true;
        },
        clickDeleteDocument(document_id) {
            this.destroy(
                `/${this.resource}/delete_document/${document_id}`
            ).then(() => this.$eventHub.$emit("reloadData"));
        },
        clickReportPayments() {
            this.showDialogReportPayment = true;
        }
    },
    mounted() {
        this.teclasInit();
        //prueba haber
        //nada
    }
};
</script>