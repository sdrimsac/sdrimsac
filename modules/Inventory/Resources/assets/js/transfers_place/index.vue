<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-6">
                        <h6>
                            <span>{{ title }}</span>
                        </h6>
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
                    <h6 class="my-0 text-white">Listado de {{ title }}</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Almacen Inicial</th>
                            <th>Almacen Destino</th>
                            <th>Usuario remitente</th>
                            <th>Código</th>
                            <th>Cantidad Total</th>
                            <th>Estado</th>
                        </tr>
                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.created_at }}</td>
                            <td>{{ row.warehouse }}</td>
                            <td>{{ row.warehouse_destination }}</td>
                            <td>{{ row.sender }}</td>
                            <td>
                                {{ row.code }}
                                <button
                                    @click="clickPrint(row.code)"
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                            <td>{{ row.quantity }}</td>
                            <td>
                                {{ row.status == 1 ? "Enviado" : "Aceptado" }}
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
    </div>
</template>

<script>
import DataTable from "../../../../../../resources/js/components/DataTableTransfers.vue";
import { deletable } from "../../../../../../resources/js/mixins/deletable";

export default {
    components: { DataTable },
    mixins: [deletable],
    data() {
        return {
            showDialogPrinters: false,
            title: null,
            showDialog: false,
            resource: "transfers/transfer_place",
            recordId: null,
            typeTransaction: null,
            printer_id: null,
            printers: [],
            currentCode: null
        };
    },
    created() {
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
                    console.log(
                        "🚀 ~ file: index.vue:144 ~ this.$http.get ~ this.$areaPrinter:",
                        this.$areaPrinter
                    );
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

        clickPrint(code) {
            this.showDialogPrinters = true;
            this.currentCode = code;

            // this.Printer(url);
        },
        clickCreate(recordId = null) {
            location.href = `/${this.resource}/create`;
            //this.recordId = recordId
            //this.showDialog = true
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    }
};
</script>
