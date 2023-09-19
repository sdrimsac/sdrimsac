<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @close="close"
        @open="getData"
        width="65%"
        append-to-body
    >
        <div class="form-body">
            <div class="row">
                <div class="col-md-12" v-if="records.length > 0">
                    <!--<div class="right-wrapper pull-right">
                        <button type="button" @click.prevent="clickDownloadReport()" class="btn btn-custom btn-sm  mt-2 mr-2"><i class="fas fa-money-bill-wave-alt"></i> Reporte</button>
                    </div>-->

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de pago</th>
                                    <th>Método de pago</th>
                                    <th>Destino</th>
                                    <th>Referencia</th>
                                    <th>Archivo</th>
                                    <th class="text-end">Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                >
                                    <template v-if="row.id">
                                        <td>
                                            <template v-if="row.receipt">
                                                {{ row.receipt }}
                                            </template>
                                            <template v-else>
                                                PAGO-{{ row.id }}
                                            </template>
                                        </td>
                                        <td>{{ row.date_of_payment }}</td>
                                        <td>
                                            {{
                                                row.payment_method_type_description
                                            }}
                                        </td>
                                        <td>
                                            {{ row.destination_description }}
                                        </td>
                                        <td>{{ row.reference }}</td>
                                        <!-- <td>{{ row.filename }}</td> -->
                                        <td class="text-center">
                                            <button
                                                type="button"
                                                v-if="row.filename"
                                                class="btn waves-effect waves-light btn-sm btn-primary"
                                                @click.prevent="
                                                    clickDownloadFile(
                                                        row.filename
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fas fa-file-download"
                                                ></i>
                                            </button>
                                        </td>
                                        <td class="text-end">
                                            {{ row.payment }}
                                        </td>
                                        <td
                                            class="series-table-actions text-end"
                                        >
                                            <button
                                                v-if="row.receipt_file"
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-success"
                                                @click.prevent="
                                                    clickReceipt(
                                                        row.receipt_file,
                                                        row.printer
                                                    )
                                                "
                                            >
                                                Recibo
                                            </button>
                                            <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                Eliminar
                                            </button>
                                            <!--<el-button type="danger" icon="el-icon-delete" plain @click.prevent="clickDelete(row.id)"></el-button>-->
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td></td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .date_of_payment
                                                }"
                                            >
                                                <el-date-picker
                                                    v-model="
                                                        row.date_of_payment
                                                    "
                                                    type="date"
                                                    :clearable="false"
                                                    format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"
                                                ></el-date-picker>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .date_of_payment
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .date_of_payment[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .payment_method_type_id
                                                }"
                                            >
                                                <el-select
                                                    v-model="
                                                        row.payment_method_type_id
                                                    "
                                                >
                                                    <el-option
                                                        v-for="option in payment_method_types"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .payment_method_type_id
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .payment_method_type_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .payment_destination_id
                                                }"
                                            >
                                                <el-select
                                                    v-model="
                                                        row.payment_destination_id
                                                    "
                                                    filterable
                                                    :disabled="
                                                        row.payment_destination_disabled
                                                    "
                                                >
                                                    <el-option
                                                        v-for="option in payment_destinations"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .payment_destination_id
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .payment_destination_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors.reference
                                                }"
                                            >
                                                <el-input
                                                    v-model="row.reference"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i
                                                ></el-input>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="row.errors.reference"
                                                    v-text="
                                                        row.errors.reference[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-upload
                                                    :data="{ index: index }"
                                                    :headers="headers"
                                                    :multiple="false"
                                                    :on-remove="handleRemove"
                                                    :action="
                                                        `/finances/payment-file/upload`
                                                    "
                                                    :show-file-list="true"
                                                    :file-list="fileList"
                                                    :on-success="onSuccess"
                                                    :limit="1"
                                                >
                                                    <el-button
                                                        slot="trigger"
                                                        type="primary"
                                                        >Seleccione un
                                                        archivo</el-button
                                                    >
                                                </el-upload>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors.payment
                                                }"
                                            >
                                                <el-input v-model="row.payment">
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i
                                                ></el-input>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="row.errors.payment"
                                                    v-text="
                                                        row.errors.payment[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td
                                            class="series-table-actions text-end"
                                        >
                                            <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info"
                                                @click.prevent="
                                                    clickSubmit(index)
                                                "
                                            >
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickCancel(index)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </template>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        TOTAL PAGADO
                                    </td>
                                    <td class="text-end">
                                        {{ document.total_paid }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        TOTAL A PAGAR
                                    </td>
                                    <td class="text-end">
                                        {{ document.total }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        PENDIENTE DE PAGO
                                    </td>
                                    <td class="text-end">
                                        {{ document.total_difference }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div
                    class="col-md-12 text-center pt-2"
                    v-if="showAddButton && document.total_difference > 0"
                >
                    <el-button
                        type="primary"
                        icon="el-icon-plus"
                        @click="clickAddRow"
                        >Nuevo</el-button
                    >
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
import { deletable } from "../../../mixins/deletable";

export default {
    props: ["showDialog", "documentId", "external"],
    mixins: [deletable],
    data() {
        return {
            title: null,
            resource: "document_payments",
            records: [],
            payment_destinations: [],
            headers: headers_token,
            fileList: [],
            payment_method_types: [],
            showAddButton: true,
            document: {},
            index_file: null
        };
    },
    async created() {
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.payment_method_types = response.data.payment_method_types;
            this.payment_destinations = response.data.payment_destinations;
            //this.initDocumentTypes()
        });
    },
    methods: {
        async clickPrintPos(printerName, formatoPdf) {
            this.$confirm("Elija una de las opciones", "Imprimir", {
                confirmButtonText: "Impresión directa",
                cancelButtonText: "Descargar PDF",
                type: "warning"
            })
                .then(async () => {
                    try {
                        let paperConfig = {
                            scaleContent: false
                        };

                        let config = qz.configs.create(
                            printerName,
                            paperConfig
                        );
                        if (!qz.websocket.isActive()) {
                            await qz.websocket.connect(config);
                        }

                        let data = [
                            {
                                type: "pdf",
                                format: "file",
                                data: formatoPdf
                            }
                        ];
                        qz.print(config, data).catch(e => {
                            this.$toast.error(e.message);
                        });

                    } catch (e) {
                        this.$toast.error(e.message);
                    }
                })
                .catch(() => {
                    window.open(formatoPdf, "_blank");
                    this.clickClose();
                });
        },
        async clickReceipt(receipt, printer) {
           
             
                    this.clickPrintPos(printer, receipt);
               
        },
        clickDownloadFile(filename) {
            window.open(
                `/finances/payment-file/download-file/${filename}/documents`,
                "_blank"
            );
        },
        onSuccess(response, file, fileList) {
            // console.log(response, file, fileList)
            this.fileList = fileList;

            if (response.success) {
                this.index_file = response.data.index;
                this.records[this.index_file].filename = response.data.filename;
                this.records[this.index_file].temp_path =
                    response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }

            // console.log(this.records)
        },
        handleRemove(file, fileList) {
            this.records[this.index_file].filename = null;
            this.records[this.index_file].temp_path = null;
            this.fileList = [];
            this.index_file = null;
        },
        initForm() {
            this.records = [];
            this.fileList = [];
            this.showAddButton = true;
        },
        async getData() {
            this.initForm();
            await this.$http
                .get(`/${this.resource}/document/${this.documentId}`)
                .then(response => {
                    this.document = response.data;
                    this.title =
                        "Pagos del comprobante: " + this.document.number_full;
                });
            await this.$http
                .get(`/${this.resource}/records/${this.documentId}`)
                .then(response => {
                    this.records = response.data.data;
                    console.log(
                        "🚀 ~ file: payments.vue:262 ~ getData ~ this.records:",
                        this.records
                    );
                });

            this.$eventHub.$emit("reloadDataUnpaid");
        },
        clickAddRow() {
            this.records.push({
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: "01",
                payment_destination_id: "cash",
                reference: null,
                filename: null,
                temp_path: null,
                payment: 0,
                errors: {},
                loading: false
            });

            this.showAddButton = false;
        },
        clickCancel(index) {
            this.records.splice(index, 1);
            this.fileList = [];
            this.showAddButton = true;
        },
        clickSubmit(index) {
            if (
                this.records[index].payment >
                parseFloat(this.document.total_difference)
            ) {
                this.$toast.error(
                    "El monto ingresado supera al monto pendiente de pago, verifique."
                );
                return;
            }
            let form = {
                id: this.records[index].id,
                document_id: this.documentId,
                date_of_payment: this.records[index].date_of_payment,
                payment_method_type_id: this.records[index]
                    .payment_method_type_id,
                payment_destination_id: this.records[index]
                    .payment_destination_id,
                reference: this.records[index].reference,
                filename: this.records[index].filename,
                temp_path: this.records[index].temp_path,
                payment: this.records[index].payment
            };
            this.$http
                .post(`/${this.resource}`, form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.getData();
                        // this.initDocumentTypes()
                        this.showAddButton = true;
                        this.$eventHub.$emit("reloadData");
                        if (this.external) {
                            this.$emit("getRecords");
                        }
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.records[index].errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                });
        },
        // filterDocumentType(row){
        //
        //     if(row.contingency){
        //         this.document_types = _.filter(this.all_document_types, item => (item.id == '01' || item.id =='03'))
        //         row.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
        //     }else{
        //         row.document_type_id = null
        //         this.document_types = this.all_document_types
        //     }
        // },
        // initDocumentTypes(){
        //     this.document_types = (this.all_document_types.length > 0) ? this.all_document_types : []
        // },
        close() {
            this.$emit("update:showDialog", false);
            // this.initDocumentTypes()
            // this.initForm()
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() => {
                this.getData();
                this.$eventHub.$emit("reloadData");
                // this.initDocumentTypes()
            });
        },
        clickDownloadReport(id) {
            window.open(
                `/${this.resource}/report/${this.documentId}`,
                "_blank"
            );
        }
    }
};
</script>
