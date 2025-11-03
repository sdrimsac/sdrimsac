<template>
    <el-dialog :title="title" :visible="showDialog" @close="close" @open="getData" width="90%" append-to-body>
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <!--<div class="right-wrapper pull-right">
                        <button type="button" @click.prevent="clickDownloadReport()" class="btn btn-custom btn-sm  mt-2 mr-2"><i class="fas fa-money-bill-wave-alt"></i> Reporte</button>
                    </div>-->
                    <div class="col-6 d-flex justify-content-start">
                        <h2 style="font-size: 1.2em;">
                            <strong>{{ document.customer_name }}</strong>
                        </h2>
                    </div>
                    <div class="col-md-12 mb-2" v-if="showAddButton && document.total_difference > 0">
                        <div style="display:flex; justify-content:flex-end;">
                            <el-button class="btn_guardarsmall" type="primary" icon="el-icon-plus" @click="clickAddRow">
                                Registrar Pago
                            </el-button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="background:#073f68;color:#fff;">
                                    <th style="color:#fff; width:25%;">#</th>
                                    <th style="color:#fff; width:20%;">Usuario/Fecha</th>
                                    <!-- <th style="color:#fff; width:15%;">Usuario</th> -->
                                    <th style="color:#fff; width:15%;">Destino/Método</th>
                                    <!-- <th style="color:#fff; width:15%;">Destino</th> -->
                                    <!-- <th style="color:#fff;">Referencia</th> -->
                                    <!-- <th style="color:#fff;">Archivo</th> -->
                                    <th style="color:#fff; width:15%;" class="text-end">Monto</th>
                                    <th style="color:#fff; width:25%; white-space:nowrap;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in records" :key="index"
                                    :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                    <!-- Guard against null/undefined rows returned from API or accidentally inserted -->
                                    <template v-if="row">
                                        <template v-if="row.id">
                                       
                                        <td :class="{ 'text-danger': row.extorned }">
                                            <template v-if="row.extorned">
                                                PAGO - {{ row.id }} <br>
                                                Extornado por:
                                                <br>
                                                {{ (row.user_name || '').split('-').pop().trim() }}
                                            </template>
                                            <template v-else>
                                                PAGO - {{ row.id }}
                                            </template>
                                        </td>

                                        <td :class="{ 'text-danger': row.extorned }">
                                            {{ (row.user_name || '').split(/\s*-\s*/).pop().trim() }}
                                            <br>
                                            {{ row.date_of_issue_payment ? row.date_of_issue_payment :
                                                row.date_of_payment }}


                                        </td>
                                        <!-- <td :class="{
                                            'text-danger': row.extorned
                                        }">{{ row.user_name }} </td> -->
                                        <td :class="{
                                            'text-danger': row.extorned
                                        }">
                                            {{ row.destination_description }}
                                            <br>
                                            {{ row.payment_method_type_description }}
                                        </td>
                                        <!-- <td :class="{
                                            'text-danger': row.extorned
                                        }">
                                            {{ row.destination_description }}
                                        </td> -->
                                        <!-- <td :class="{
                                            'text-danger': row.extorned
                                        }">{{ row.reference }}</td> -->
                                        <!-- <td>{{ row.filename }}</td> -->
                                        <!-- <td class="text-center">
                                            <button type="button" v-if="row.filename"
                                                class="btn waves-effect waves-light btn-sm btn-primary" @click.prevent="
                                                    clickDownloadFile(
                                                        row.filename
                                                    )
                                                    ">
                                                <i class="fas fa-file-download"></i>
                                            </button>
                                        </td> -->
                                        <td class="text-end" :class="{ 'text-danger': row.extorned }">
                                            {{ Number(row.payment).toLocaleString('es-PE', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            }) }}
                                        </td>
                                        <td class="series-table-actions text-end">
                                            <div style="display:inline-flex; gap:8px;">
                                                <button v-if="row.can_extorned && row.canCancel && !row.extorned"
                                                    type="danger" class="btn_cancelarsmall"
                                                    @click.prevent="clickDelete(row.id)"
                                                    style="width:130px; text-align:center;">
                                                    Extornar
                                                </button>
                                                <button v-if="row.receipt_file" type="primary" class="btn_guardarsmall"
                                                    @click.prevent="clickReceipt(row.receipt_file, row.printer)"
                                                    style="width:130px; text-align:center;">
                                                    Recibo
                                                </button>

                                            </div>

                                        </td>
                                        </template>
                                        <!-- Ingresar Pago -->
                                        <template v-else>
                                        <!-- <td>Ingresar Pago :</td> -->
                                        <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors
                                                        .date_of_payment
                                            }">
                                                <el-date-picker v-model="row.date_of_payment
                                                    " type="date" :clearable="false" format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"></el-date-picker>
                                                <small class="form-control-feedback" v-if="
                                                    row.errors
                                                        .date_of_payment
                                                " v-text="row.errors
                                                    .date_of_payment[0]
                                                    "></small>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors
                                                        .payment_method_type_id
                                            }">
                                                <el-select v-model="row.payment_method_type_id
                                                    ">
                                                    <el-option v-for="option in payment_method_types" :key="option.id"
                                                        :value="option.id" :label="option.description
                                                            "></el-option>
                                                </el-select>
                                                <small class="form-control-feedback" v-if="
                                                    row.errors
                                                        .payment_method_type_id
                                                " v-text="row.errors
                                                    .payment_method_type_id[0]
                                                    "></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors
                                                        .payment_destination_id
                                            }">
                                                <el-select v-model="row.payment_destination_id
                                                    " filterable :disabled="row.payment_destination_disabled
                                                        ">
                                                    <el-option v-for="option in payment_destinations" :key="option.id"
                                                        :value="option.id" :label="option.description
                                                            "></el-option>
                                                </el-select>
                                                <small class="form-control-feedback" v-if="
                                                    row.errors
                                                        .payment_destination_id
                                                " v-text="row.errors
                                                    .payment_destination_id[0]
                                                    "></small>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors.reference
                                            }">
                                                <el-input v-model="row.reference">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                                <small class="form-control-feedback" v-if="row.errors.reference" v-text="row.errors.reference[0]
                                                    "></small>
                                            </div>
                                        </td> -->
                                        <!-- <td>
                                            <div class="form-group mb-0">
                                                <el-upload :data="{ index: index }" :headers="headers" :multiple="false"
                                                    :on-remove="handleRemove" :action="`/finances/payment-file/upload`
                                                        " :show-file-list="true" :file-list="fileList"
                                                    :on-success="onSuccess" :limit="1">
                                                    <el-button slot="trigger" type="primary">Seleccione un
                                                        archivo</el-button>
                                                </el-upload>
                                            </div>
                                        </td> -->
                                        <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors.payment
                                            }">
                                                <el-input v-model="row.payment">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                                <small class="form-control-feedback" v-if="row.errors.payment" v-text="row.errors.payment[0]
                                                    "></small>
                                            </div>
                                        </td>
                                        <td class="series-table-actions text-end" colspan="2">
                                            <div style="display:inline-flex; gap:6px;">
                                                <button type="primary" class="btn_limpiezasmall"
                                                    @click.prevent="clickSubmit(index)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" class="btn_cancelarsmall"
                                                    @click.prevent="clickCancel(index)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        </template>
                                    </template>
                                    <!-- If row is null, render an empty placeholder to avoid render errors -->
                                    <template v-else>
                                        <td colspan="5">&nbsp;</td>
                                    </template>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        Total Pagado
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_paid).toFixed(2) }}

                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        Total a Pagar
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total).toFixed(2) }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">
                                        Pendiente de Pago
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_difference || 0).toFixed(2) }}
                                    </td>
                                    <td></td>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
            // filter out any null/undefined entries from server data to avoid template errors
            this.payment_method_types = (response.data.payment_method_types || []).filter(o => o != null);
            this.payment_destinations = (response.data.payment_destinations || []).filter(o => o != null);
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
                        let format = formatoPdf.split("/")[
                            formatoPdf.split("/").length - 1
                        ];
                        let isTicket = format == "ticket";
                        let isPosd = printerName.split(" ")[
                            printerName.split(" ").length - 1
                        ];
                        if (isPosd == "POSD" && isTicket) {
                            paperConfig.density = 200;
                        }
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
                        "Pagos del Comprobante :  " + this.document.number_full;
                });
            await this.$http
                .get(`/${this.resource}/records/${this.documentId}`)
                .then(response => {
                    // Ensure we don't keep null/undefined entries returned by the API
                    this.records = (response.data.data || []).filter(r => r != null);

                    // Clear any previous canCancel flags
                    this.records.forEach(r => {
                        r.canCancel = false;
                    });

                    // Find the latest payment by date+time (prefer date_of_issue_payment when available)
                    // We expect dates to be in 'YYYY-MM-DD' and times may be in 'HH:mm:ss' or included in the field.
                    try {
                        let latestIndex = -1;
                        let latestMoment = null;

                        this.records.forEach((r, idx) => {
                            if (r.extorned) return; // skip extorned payments

                            // prefer date_of_issue_payment, otherwise date_of_payment
                            let datePart = r.date_of_issue_payment ? r.date_of_issue_payment : r.date_of_payment;

                            // if there's a separate time field use it, otherwise parse combined
                            // attempt common combined formats, fallback to date only
                            let m = null;
                            if (datePart) {
                                m = moment(datePart, moment.ISO_8601, true);
                                if (!m.isValid()) {
                                    // try without strict ISO parse
                                    m = moment(datePart);
                                }
                            }

                            // if still invalid, skip
                            if (!m || !m.isValid()) return;

                            if (latestMoment === null || m.isAfter(latestMoment)) {
                                latestMoment = m;
                                latestIndex = idx;
                            }
                        });

                        if (latestIndex !== -1) {
                            this.records[latestIndex].canCancel = true;
                        }
                    } catch (e) {
                        // fallback: if first record has a date, keep old behavior
                        if (this.records[0] && this.records[0].date_of_issue_payment) {
                            this.records[0].canCancel = true;
                        }
                    }
                });

            this.$eventHub.$emit("reloadDataUnpaid");
        },
        clickAddRow() {
            this.records.push({
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                user_id: null,
                payment_method_type_id: "01",
                payment_destination_id: "cash",
                reference: null,
                filename: null,
                temp_path: null,
                payment: 0,
                errors: {},
                loading: false
            });

            this.showAddButton = true;
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
                        this.$emit("reloadData");
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
