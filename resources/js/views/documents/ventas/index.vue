<!-- Listado de Comprobante de Pago -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos Vendidos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Documentos - Productos Vendidos</span
                                >
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <!-- <div class="col-sm-12"> -->
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h4 class="my-0  text-white">
                                <i class=""></i>
                                Productos Vendidos por Documentos
                            </h4>
                        </div>

                        <div class="card-body">
                            <data-table
                                :resource="resource"
                                class="table-striped"
                            >
                                <tr slot="heading" class="bg-primary">
                                    <th class="text-white">#</th>
                                    <th class="text-white">Numero</th>
                                    <th class="text-white">Fecha Emision</th>
                                    <th class="text-white">Establecimiento</th>
                                    <th class="text-white">Codigo Interno</th>
                                    <th class="text-white">Producto</th>
                                    <th class="text-white">Cantidad</th>
                                    <th class="text-white text-end">Precio</th>
                                    <th class="text-white text-end">Total</th>
                                    <!-- <th class="text-white text-end">
                                        Pendiente
                                    </th> -->
                                    <th class="text-white text-end"></th>
                                </tr>

                                <tr></tr>
                                <template slot-scope="{ index_, row }">
                                <tr
                                     v-for="(item, index) in row.items" :key="'item-' + row.id + '-'+ index"
                                >
                                    <td>{{ 
                                        index == 0 ? index_ : ''
                                       }}
                                        
                                    
                                        
                                        </td>
                                    <td v-if="index === 0" :rowspan="row.items.length">
                                        {{ row.number_full }}
                                    </td>

                                    <td v-if="index === 0" :rowspan="row.items.length">
                                        {{ row.date_of_issue }}
                                    </td>
                                    <td>{{ row.establishment_description }}</td>
                                    <td>{{ item.item.internal_id }}</td>
                                    <td>{{ item.item.description }}</td>
                                    <td>{{ parseFloat(item.quantity).toFixed(2) }}</td>
                                    <td class="text-end">{{ parseFloat(item.unit_value).toFixed(2) }}</td>
                                    <td class="text-end">{{ parseFloat(item.total).toFixed(2) }}</td>
                                </tr>
                                </template>
                            </data-table>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>

</template>

<script>
import DataTable from "../../../components/DataTableVenta.vue";
import { deletable } from "../../../mixins/deletable";
/* import DetractionPayments from "./detraction_payments.vue"; */
export default {
    mixins: [deletable],
    props: [
    ],
    components: {
        DataTable,
        /* DetractionPayments */
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
            resource: "documents_ventas",
            recordId: null,
            showDialogOptions: false,
            showDialogPayments: false,
            closeBox: false,
            showDialogEdit: false,
            loading_data: false,
            editDocument: false,
            documents: [],
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


