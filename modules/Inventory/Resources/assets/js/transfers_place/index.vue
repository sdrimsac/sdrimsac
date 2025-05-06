<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-6">
                        <h4>
                            <span>{{ title }}</span>
                        </h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">{{ title }}</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">Listado de {{ title }}</h4>
                </div>
                <div
                    class="data-table-visible-columns d-flex justify-content-start align-items-center mb-3"
                    style="margin-left: 1rem;"
                >
                    <el-button
                        class="btn_buscar me-2"
                        href="javascript:void(0)"
                        @click.prevent="clickCreate"
                    >
                        <i class="fas fa-plus"></i>
                        <span
                            style="color: #fff; font-size: 1.25rem; font-weight: bold;"
                            >Nuevo Traslado de Productos</span
                        >
                    </el-button>
                </div>
                <div class="card-body">
                    <data-table ref="dataTable" :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Fecha</th>
                            <th class="text-white">Almacen Inicial</th>
                            <th class="text-white">Almacen Destino</th>
                            <th class="text-white">Usuario remitente</th>
                            <th class="text-white">Motivo del Traslado</th>
                            <th class="text-white">Código</th>
                            <th class="text-white">Detalle Productos</th>
                            <th class="text-white">Cantidad Total</th>
                            <th class="text-white">Estado</th>
                            <th class="text-end text-white">Acciones</th>
                        </tr>
                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.created_at }}</td>
                            <td>{{ row.warehouse }}</td>
                            <td>{{ row.warehouse_destination }}</td>
                            <td>{{ row.sender }}</td>
                            <td>{{ row.observation }}</td>
                            <td>
                                {{ row.code }}
                                <button
                                    @click="clickPrint(row.code)"
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="fa fa-print"></i>
                                </button>
                                <!-- <button
                                    @click="clickPrint(row.code)"
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="fa fa-print"></i>
                                </button> -->
                            </td>
                            <td>
                                <el-popover
                                    placement="right"
                                    width="400"
                                    trigger="click"
                                >
                                    <el-table :data="row.detail">
                                        <el-table-column
                                            width="260"
                                            property="description"
                                            label="Producto"
                                        ></el-table-column>

                                        <el-table-column
                                            width="100"
                                            property="quantity"
                                            label="Cantidad"
                                        ></el-table-column>

                                        <el-table-column
                                            fixed="right"
                                            label="Series"
                                            width="120"
                                        >
                                            <template slot-scope="scope">
                                                <el-popover
                                                    placement="right"
                                                    width="150"
                                                    trigger="click"
                                                >
                                                    <el-table
                                                        :data="scope.row.lots"
                                                        width="80"
                                                    >
                                                        <el-table-column
                                                            prop="series"
                                                            label="Series"
                                                            width="180"
                                                        ></el-table-column>
                                                    </el-table>
                                                    <el-button
                                                        slot="reference"
                                                        icon="el-icon-zoom-in"
                                                    ></el-button>
                                                </el-popover>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <el-button
                                        slot="reference"
                                        icon="el-icon-zoom-in"
                                    ></el-button>
                                </el-popover>
                            </td>
                            <td>{{ row.quantity }}</td>
                            <td>
                                <button
                                    class="btn"
                                    :style="{
                                        color: 'white',
                                        backgroundColor:
                                            row.status === 1
                                                ? 'blue'
                                                : row.status === 2
                                                ? 'green'
                                                : row.status === 3
                                                ? 'red'
                                                : 'gray',
                                        fontWeight: 'bold',
                                        width: '110px'
                                    }"
                                >
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
                            <td class="text-end" v-if="row.status === 1">
                                <button
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
                                        >Acciones</span
                                    >
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a
                                        type="button"
                                        class="dropdown-item text-warning"
                                        @click="cancelTransfer(row.code)"
                                    >
                                        <i class="fa fa-edit"></i> Cancelar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
            <el-dialog
                append-to-body
                :visible.sync="showDialogPrinters"
                title="Seleccione una impresora"
            >
                <el-select
                    class="m-2"
                    v-model="printer_id"
                    placeholder="Seleccione una impresora"
                >
                    <el-option
                        v-for="printer in printers"
                        :key="printer.id"
                        :label="printer.printer"
                        :value="printer.id"
                    ></el-option>
                </el-select>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="showDialogPrinters = false"
                        >Cancelar</el-button
                    >
                    <el-button type="primary" @click="Printer"
                        >Aceptar</el-button
                    >
                </span>
            </el-dialog>
        </div>
        <transfer-form
            :showDialog.sync="showDialogTransferForm"
            :configuration="configuration"
            :direct="direct"
            :warehouse_id="warehouse_id"
            :establishment_id="establishment_id"
            :establishments="establishments"
            :printers="printers"
            @reloadData="reloadDataTable"
        ></transfer-form>
        <pdf-model
            :showDialog.sync="showDialogPdf"
            :currentCode="currentCode"
            :printer_id="printer_id"
            :printers="printers"
            :configuration="configuration"
            @reloadData="reloadData"
            @Printer="Printer"
        ></pdf-model>
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransfers.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";
import TransferForm from "./form.vue";
import pdfModel from "./partials/model_pdf.vue";

export default {
    components: {
        DataTable,
        TransferForm,
        pdfModel
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
            establishments: []
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
                } else {
                    this.$message.error("Error al cancelar el traslado");
                }
            } catch (error) {
                this.$message.error("Ocurrió un error al cancelar el traslado");
                console.error(error);
            }
        },
        clickPrint(code) {
            this.showDialogPdf = true;
            console.log("Código enviado al modal:", code);
            this.currentCode = code;
            console.log("Código actual:", this.currentCode);
        }
        /* clickPrint(code) {
            this.showDialogPrinters = true;
            this.currentCode = code;

            // this.Printer(url);
        }, */
        /* clickCreate(recordId = null) {
            location.href = `/${this.resource}/create`;
            //this.recordId = recordId
            //this.showDialog = true
        }, */
        /* clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        } */
        /* cancel(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        } */
    }
};
</script>
