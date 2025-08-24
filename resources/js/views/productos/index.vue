<!-- Listado de Inventario -->
<template>
    <div>
        <!-- <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
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
        </div> -->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
              <div class="card-header bg-primary d-flex align-items-center" style="padding: 8px;">
                  <h4 class="my-0 text-white d-flex align-items-center"
                      style="font-size: 1rem; font-weight: bold;">
                      <i class="fas fa-truck-loading" style="font-size: 1rem; margin-right: 0.5rem;"></i>
                      Ingreso y Salida de Productos
                  </h4>
              </div>
                <div class="data-table-visible-columns">
                    <div style="display: flex; gap: 8px;">
                        <el-button
                            v-if="configuration.color_size_enabled"
                            type="primary"
                            class="btn_guardarsmall"
                            href="javascript:void(0)"
                            @click.prevent="clickImportColorSize()"
                        >
                            <i class="fa fa-arrow-circle-down fa-lg"></i>
                            Importar talla color 
                        </el-button>
                        <el-button
                            type="primary"
                            class="btn_guardarsmall"
                            href="javascript:void(0)"
                            @click.prevent="clickCreate('input')"
                        >
                            <i class="fa fa-arrow-circle-down fa-lg"></i>
                            Ingreso
                        </el-button>
                        <el-button
                            type="primary"
                            class="btn_guardarsmall"
                            style="margin-right: 5px;"
                            href="javascript:void(0)"
                            @click.prevent="clickOutput()"
                        >
                            <i class="fa fa-arrow-circle-up fa-lg"></i>
                            Salida
                        </el-button>
                    </div>
                </div>
                

                <div class="card-body">
                    <data-table :resource="resource" ref="dataTable">
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white text-center">#</th>
                            <th class="text-white text-center">
                                Codigo Interno
                            </th>
                            <th class="text-white text-left">Producto</th>
                            <th class="text-white text-left">Almacén</th>
                            <th class="text-white text-left">
                                Cant-Movimiento
                            </th>
                            <th class="text-white text-letf">
                                Fecha Movimiento
                            </th>
                            <th class="text-white text-center">
                                Tipo
                            </th>
                            <th class="text-white text-center">Ticket</th>
                        </tr>

                        <tr calss="text-white"></tr>

                        <tr slot-scope="{ index, row }">
                            <td class="text-center">{{ index }}</td>
                            <td class="text-center">
                                {{ row.item_internal_id }}
                            </td>
                            <td class="text-left">
                                {{ row.item_description }}
                                <br />
                                <span>{{ row.lot_code }}</span>
                                <template
                                    v-if="row.lots && row.lots.length > 0"
                                >
                                    <table
                                        class="table table-responsive table-striped"
                                    >
                                        <thead>
                                            <tr
                                                slot="heading"
                                                class="bg-primary"
                                            >
                                                <!-- <th class="text-white">N°</th> -->
                                                <th class="text-white">
                                                    Serie
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="lots in row.lots"
                                                :key="lots.series"
                                            >
                                                <td>{{ lots.series }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </template>
                                <template
                                    v-if="
                                        row.color_size &&
                                            row.color_size.length != 0
                                    "
                                >
                                    <table
                                        class="table table-responsive table-striped"
                                    >
                                        <thead>
                                            <tr
                                                slot="heading"
                                                class="bg-primary"
                                            >
                                                <th class="text-white">Código Familia</th>
                                                <th class="text-white">
                                                    Color
                                                </th>
                                                <th class="text-white">
                                                    Talla
                                                </th>
                                                <th class="text-white">
                                                    Precio
                                                </th>
                                                
                                                <th class="text-white">Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="color_size in row.color_size"
                                                :key="color_size.id"
                                            >   
                                                <td>{{ color_size.code }}</td>
                                                <td>{{ color_size.color }}</td>
                                                <td>{{ color_size.size }}</td>
                                                <td>{{ color_size.price }}</td>
                                                
                                                <td>{{ color_size.stock }}</td>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </template>
                            </td>
                            <td class="text-left">
                                {{ row.warehouse_description }}
                            </td>
                            <td class="text-left">
                                {{ parseFloat(row.quantity).toFixed(2) }}
                            </td>
                            <td class="text_left">
                                <div>
                                    <span style="color: #1976d2; font-weight: bold;">
                                        {{ row.created_at ? row.created_at.split(' ')[0] : '' }}
                                    </span>
                                </div>
                                <div>
                                    <span style="color: #e53935; font-weight: bold;">
                                        {{ row.created_at ? row.created_at.split(' ')[1] : '' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                              <el-tag
                                :type="row.type === 'input' ? 'success' : 'danger'"
                                effect="dark"
                                disable-transitions
                                style="font-size: 0.95em; padding: 2px 10px;"
                              >
                                {{ row.type === "input" ? "Ingreso" : "Salida" }}
                              </el-tag>
                            </td>
                            
                            <td class="text-center">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <button
                                    @click="clickPrint(row.id)"
                                    type="button"
                                    class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:32px;height:32px;padding:0;"
                                    title="Imprimir"
                                >
                                    <i class="fa fa-print"></i>
                                </button>
                                <button
                                    @click="RePrint(row.id)"
                                    type="button"
                                    class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:32px;height:32px;padding:0;margin-left:6px;"
                                    title="Reimprimir"
                                >
                                    <i class="fa fa-redo"></i>
                                </button>
                            </div>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>

            
            <el-dialog
                append-to-body
                :visible.sync="showDialogEstablishment"
                title="Seleccione una impresora de establecimiento"
                width="500px"
            >
                <el-select
                    class="m-2"
                    v-model="establishment_id"
                    placeholder="Seleccione una impresora"
                >
                    <el-option
                        v-for="printer in establishment"
                        :key="printer.id"
                        :label="printer.printer"
                        :value="printer.id"
                    ></el-option>
                </el-select>
                <span slot="footer" class="dialog-footer" style="display: flex; justify-content: flex-end;">
                  <!-- Botón Cancelar -->
                  <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click="showDialogEstablishment = false"
                  >
                    <span>Cancelar</span>
                  </el-button>
                  <!-- Botón Guardar -->
                    <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-print fa-lg"
                    type="primary"
                    @click="Printer(); showDialogEstablishment = false"
                    style="margin-left: 10px;"
                    >
                    <span>Imprimir</span>
                    </el-button>
                </span>
            </el-dialog>
        </div>
        <inventories-form
            :showDialog.sync="showDialog"
            :type.sync="typeTransaction"
        ></inventories-form>

        <inventories-form-output
            :showDialog.sync="showDialogOutput"
        ></inventories-form-output>

        <inventories-move
            :showDialog.sync="showDialogMove"
            :recordId="recordId"
        ></inventories-move>
        <inventories-remove
            :showDialog.sync="showDialogRemove"
            :recordId="recordId"
        ></inventories-remove>
        <form-pdf
            :showDialog.sync="showDialogRePrint"
            :recordId="recordId"
            :type.sync="typeTransaction" 
            :configuration="configuration">
        </form-pdf>
        <import-color-size
            :showDialog.sync="showImportColorSizeDialog"
        ></import-color-size>

    </div>
</template>

<style>
.button-margin {
    margin-right: 100px;
    /* Ajusta este valor según sea necesario */
}
</style>

<script>
import DataTable from "../../../../modules/Inventory/Resources/assets/components/DataTableSalida.vue";
import InventoriesForm from "../../../../modules/Inventory/Resources/assets/js/inventory/form.vue";
import InventoriesFormOutput from "../../../../modules/Inventory/Resources/assets/js/inventory/form_output.vue";
import InventoriesMove from "../../../../modules/Inventory/Resources/assets/js/inventory/move.vue";
import InventoriesRemove from "../../../../modules/Inventory/Resources/assets/js/inventory/remove.vue";
import FormPdf from "./form_pdf.vue";
import ImportColorSize from "./importColorZise.vue";

import Swal from "sweetalert2";
export default {
    props: [
    ],
    components: {
        DataTable,
        InventoriesForm,
        InventoriesMove,
        InventoriesRemove,
        InventoriesFormOutput,
        Swal,
        FormPdf,
        ImportColorSize
    },
    data() {
        return {
            showImportColorSizeDialog: false,
            showDialogRePrint: false,
            title: null,
            showDialog: false,
            showDialogMove: false,
            showDialogRemove: false,
            showDialogOutput: false,
            resource: "productos",
            recordId: null,
            typeTransaction: null,
            showDialogAreas: false,
            showDialogEstablishment: false,
            title: null,
            area_id: null,
            establishment_id: null,
            areas: [],
            establishment: [],
            printer_id: null,
            configuration: []
        };
    },
    created() {
        this.title = "Productos";
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
    mounted() {
        /* console.log("dsadasd2"); */
    },
    methods: {
        clickImportColorSize() {
            this.showImportColorSizeDialog = true;
        },
        RePrint(id){
            this.recordId = id;
            this.showDialogRePrint = true;
        },
        onlyAllowNumbers(event) {
            const charCode = event.which ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        },
        async clickSetStockReal(itemId, realStock, stock, warehouse_id) {
            const response = await this.$http.post(`/productos/stock`, {
                item_id: itemId,
                quantity_real: realStock,
                quantity: stock,
                warehouse_id: warehouse_id
            });
            if (response.data.success) {
                this.$message({
                    type: "success",
                    message: response.data.message
                });
                this.$refs.dataTable.getRecords();
            } else {
                this.$message({
                    type: "error",
                    message: response.data.message
                });
            }
            console.log(response);
        },
        getTables() {
            this.$http.get("/productos/tables").then(response => {
                console.log(
                    "🚀 ~ file: index.vue:116 ~ this.$http.get ~ response:",
                    response
                );
                // this.tables = response.data;
                let { data } = response;
                this.establishment = data.establishment;
                this.configuration = data.configuration;
                console.log(
                    "🚀 ~ file: index.vue:144 ~ this.$http.get ~ this.$areaPrinter:",
                    this.$establishmentPrinter
                );
                if (this.$establishmentPrinter) {
                    //ordena printers de manera que $areaPrinter sea el primero
                    let index = this.establishment.findIndex(
                        printer => printer.printer == this.$establishmentPrinter
                    );
                    if (index != -1) {
                        let printer = this.establishment[index];
                        this.printer_id = printer.id;
                        this.establishment.splice(index, 1);
                        this.establishment.unshift(printer);
                    }
                }
            });
        },
        async Printer(type) {
            let paperConfig = {
                scaleContent: false
            };
            let printer = this.establishment.find(printer => {
                return printer.id == this.establishment_id;
            });
            if (!printer) {
                this.$toast.error("No se encontró la impresora seleccionada.");
                return;
            }
            let config = qz.configs.create(printer.printer, paperConfig);
            // console.log('Valor de recordId: ', type);
            let linkpdf = `/productos/printer/${this.type}`;
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
            -qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
                swal.fire({
                    title: "Error",
                    text: e.message,
                    icon: "error"
                });
            });
        },
        clickMove(recordId) {
            this.recordId = recordId;
            this.showDialogMove = true;
        },
        clickCreate(type) {
            console.log("🚀 ~ clickCreate ~ type:", type);
            this.recordId = null;
            this.typeTransaction = type;
            this.showDialog = true;
        },
        clickRemove(recordId) {
            this.recordId = recordId;
            this.showDialogRemove = true;
        },
        clickOutput() {
            this.recordId = null;
            this.showDialogOutput = true;
        },
        clickPrint(type) {
            this.showDialogEstablishment = true;
            this.type = type;
        }
    }
};
</script>
