<!-- Listado de Traslados por aceptar -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 8px;">
                    <i class="fas fa-exchange-alt text-white me-2" style="font-size: 1rem;"></i>
                    <h4 class="my-0 text-white">Listado de {{ title }}</h4>
                </div>
                <div class="data-table-visible-columns d-flex justify-content-start align-items-center mb-3"
                    style="margin-left: 1rem;">
                    <el-button class="btn_guardarsmall" href="javascript:void(0)" @click.prevent="clickCreate">
                        <i class="fas fa-plus"></i>
                        <span style="color: #fff; font-size: 1rem; font-weight: bold;">Nuevo</span>
                    </el-button>
                </div>
                
                    <div class="card-body">
                        <data-table ref="dataTable" :resource="resource">
                            <tr slot="heading" class="bg-primary">
                                <th class="text-white">#</th>
                                <th class="text-white">Fecha Envío</th>
                                <th class="text-white">Almacén Origen</th>
                                <th class="text-white">Almacén Destino</th>
                                <th class="text-white">Usuario Remitente</th>
                                <th class="text-white">Motivo</th>
                                <th class="text-white">Código</th>
                                <th class="text-white">Detalle Productos</th>
                                <th class="text-white">Cantidad Total</th>
                                <th class="text-white">Estado</th>
                                <th class="text-end text-white">Acciones</th>
                            </tr>
                            <tr></tr>
                            <tr slot-scope="{ index, row }">
                                <td>{{ index }}</td>
                                <td>
                                    <div style="color: #007bff;">{{ row.created_at ? row.created_at.split(' ')[0] : '' }}</div>
                                    <div style="color: #28a745;">{{ row.created_at ? row.created_at.split(' ')[1] : '' }}</div>
                                </td>
                                <td class="text-center">{{ row.warehouse }}</td>
                                <td class="text-center">{{ row.warehouse_destination }}</td>
                                <td class="text-center">{{ row.sender }}</td>
                                <td class="text-center">{{ row.observation }}</td>
                                <td>
                                    {{ row.code }}
                                </td>
                                <td>
                                    <!-- Popover principal que muestra el detalle de productos (y dentro cada lote / serie / talla-color) -->
                                    <el-button type="primary" @click="items = Array.isArray(row.detail) ? row.detail : (row.detail ? [row.detail] : []); showDialogTransferModel = true">
                                        Ver Productos
                                    </el-button>
                                </td>
                                <td class="text-center">{{ row.quantity }}</td>
                                <td>
                                    <button class="btn" :style="{
                                        color: 'white',
                                        backgroundColor:
                                            row.status === 1
                                                ? '#073f68'
                                                : row.status === 2
                                                    ? 'green'
                                                    : row.status === 3
                                                        ? 'red'
                                                        : 'gray',
                                        fontWeight: 'bold',
                                        width: '110px'
                                    }">
                                        {{
                                            row.status === 1
                                                ? "Enviado"
                                                : row.status === 2
                                                    ? "Aceptado"
                                                    : row.status === 3
                                                        ? "Anulado"
                                                        : "Desconocido"
                                        }}
                                    </button>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <el-tooltip content="Anular Traslado" placement="top" v-if="row.status === 1">
                                            <button
                                                class="btn btn-warning rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; padding: 0;"
                                                @click="cancelTransfer(row.code)"
                                            >
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </el-tooltip>
                                        <el-tooltip content="Imprimir" placement="top" v-if="row.status !== 3">
                                            <button
                                                @click="clickPrint(row.code)"
                                                type="button"
                                                class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; padding: 0;"
                                            >
                                                <i class="fa fa-print"></i>
                                            </button>
                                        </el-tooltip>
                                    </div>
                                </td>
                            </tr>
                        </data-table>
                    </div>
                
            </div>
            <el-dialog append-to-body :visible.sync="showDialogPrinters" title="Seleccione una impresora">
                <el-select class="m-2" v-model="printer_id" placeholder="Seleccione una impresora">
                    <el-option v-for="printer in printers" :key="printer.id" :label="printer.printer"
                        :value="printer.id"></el-option>
                </el-select>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="showDialogPrinters = false">Cancelar</el-button>
                    <el-button type="primary" @click="Printer">Aceptar</el-button>
                </span>
            </el-dialog>
        </div>
        <transfer-form :showDialog.sync="showDialogTransferForm" :configuration="configuration" :direct="direct"
            :warehouse_id="warehouse_id" :establishment_id="establishment_id" :establishments="establishments"
            :printers="printers" @reloadData="reloadDataTable"></transfer-form>
        <pdf-model :showDialog.sync="showDialogPdf" :currentCode="currentCode" :printer_id="printer_id"
            :printers="printers" :configuration="configuration" @reloadData="reloadData" @Printer="Printer"></pdf-model>
        <transfer-model :dialogVisible.sync="showDialogTransferModel" :items="items"></transfer-model>
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransfers.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";
import TransferForm from "./form.vue";
import pdfModel from "./partials/model_pdf.vue";
import TransferModel from "./partials/transfer_model.vue";

export default {
    components: {
        DataTable,
        TransferForm,
        pdfModel,
        TransferModel
    },
    props: ["direct", "areaPrinter", "warehouse_id", "establishment_id"],
    mixins: [deletable],
    data() {
        return {
            showDialogPdf: false,
            showDialogTransferForm: false,
            showDialogPrinters: false,
            title: null,
            showDialog: false,
            resource: "transfers/transfer_place",
            recordId: null,
            typeTransaction: null,
            printer_id: null,
            printers: [],
            currentCode: null,
            transferCode: "",
            configuration: [],
            establishments: [],
            showDialogTransferModel: false,
            items: []
        };
    },
    /* created() {
        this.title = "Traslados";
        this.direct = this.configuration.translate_direct;
    }, */
    created() {
        /* this.direct = this.configuration.translate_direct; */
        this.title = "Traslados por aceptar";
        this.getTables();
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
    },
    methods: {
        reloadDataTable() {
            console.log("Recargando datos desde el padre");
            this.$eventHub.$emit("reloadData")
        },
        reloadData() {
            this.$eventHub.$emit("reloadData")
        },
        clickCreate() {
            this.showDialogTransferForm = true;
        },
        getTables() {
            this.$http
                .get("/transfers/transfer_place/tables")
                .then(response => {
                    console.log(
                        "🚀 ~ file: index.vue:116 ~ this.$http.get ~ response:",
                        response
                    );
                    // this.tables = response.data;
                    let { data } = response;
                    this.printers = data.printers;
                    this.configuration = data.configuration;
                    this.establishments = data.establishments;
                    if (this.$areaPrinter) {
                        //ordena printers de manera que $areaPrinter sea el primero
                        let index = this.printers.findIndex(
                            printer => printer.printer == this.$areaPrinter
                        );
                        if (index != -1) {
                            let printer = this.printers[index];
                            this.printer_id = printer.id;
                            this.printers.splice(index, 1);
                            this.printers.unshift(printer);
                        }
                    }
                });
        },
        async Printer() {
            let paperConfig = {
                scaleContent: false
            };

            let printer = this.printers.find(printer => {
                return printer.id == this.printer_id;
            });

            let config = qz.configs.create(printer.printer, paperConfig);
            let linkpdf = `/transfers/print_places/${this.currentCode}`;
            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
        },
        async cancelTransfer(code) {
            try {
                const response = await axios.post(
                    "/transfers/cancel_transfer",
                    {
                        code: code
                    }
                );

                if (response.data.success) {
                    this.$message.success(response.data.message);
                    //this.$eventHub.$emit("reloadData");
                    this.reloadDataTable();
                } else {
                    this.$message.error("Error al cancelar el traslado");
                }
            } catch (error) {
                this.$message.error("Ocurrió un error al cancelar el traslado");
                console.error(error);
            } finally {
                // Emitir evento para recargar por defecto
                this.$eventHub.$emit("reloadData");
            }
        },
        clickPrint(code) {
            this.showDialogPdf = true;
            console.log("Código enviado al modal:", code);
            this.currentCode = code;
            console.log("Código actual:", this.currentCode);
        }
    }
};
</script>
