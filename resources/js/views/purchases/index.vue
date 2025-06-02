<!-- Modulo Listado de Compras -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div
                        v-if="configuration.sale_note_credit_penalty"
                        class="col-sm-12 col-lg-2 alert alert-success d-flex justify-content-start align-items-center"
                    >
                        <span
                            >Efectivo disponible: S/
                            {{ Number(total).toFixed(2) }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
               
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 15px;"
                >
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="fas fa-shopping-cart"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Módulo de Compras
                    </h4>
                </div>

                <div class="data-table-visible-columns">
                    <!-- <el-button
                                type="primary"
                                class=""
                                href="javascript:void(0)"
                                @click.prevent="clickRestaurar()"
                            >
                                Restaurar Compra
                            </el-button> -->
                    <el-button
                    type="primary"
                        class="btn_buscar"
                        style="margin-right: 5px;"
                        href="javascript:void(0)"
                        @click.prevent="clickNuevo()"
                    >
                        <i class="fas fa-plus"></i>
                       
                            Nuevo
                    </el-button>
                    <!-- <el-button
                        class="btn_titulos_modal"
                        href="javascript:void(0)"
                        @click.prevent="clickImport()"
                    >
                        <i class="fa fa-upload"></i>
                        <span
                            style="color: #000; font-size: 1.25rem; font-weight: bold;"
                            >Importar</span
                        >
                    </el-button> -->
                </div>
                <!-- ********** -->

                <div class="card-body">
                    <data-table
                        :resource="resource"
                        @clickReport="clickReport"
                        class="table-striped"
                    >
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white text-center">#</th>
                            <th class="text-center text-white">Actividad</th>
                            <!-- <th class="text-center text-white">Usuario</th> -->
                            <th
                                class="text-center text-white"
                                v-if="columns.date_of_due.visible"
                            >
                                F. Vencimiento
                            </th>
                            <th class="text-white text-center">Proveedor</th>
                            <th class="text-white text-center">Estado</th>
                            <th class="text-white text-center">Número</th>
                            <th class="text-white text-center">Productos</th>
                            <th class="text-white text-center">Pagos</th>
                            <th class="text-center text-white">Moneda</th>
                            <th
                                v-if="columns.total_free.visible"
                                class="text-end"
                            >
                                T.Gratuita
                            </th>
                            <th
                                v-if="columns.total_unaffected.visible"
                                class="text-end text-white"
                            >
                                T.Inafecta
                            </th>
                            <th
                                v-if="columns.total_exonerated.visible"
                                class="text-end text-white"
                            >
                                T.Exonerado
                            </th>
                            <th
                                v-if="columns.total_taxed.visible"
                                class="text-end text-white"
                            >
                                T.Gravado
                            </th>
                            <th
                                v-if="columns.total_igv.visible"
                                class="text-end text-white"
                            >
                                T.Igv
                            </th>
                            <th
                                v-if="columns.total_perception.visible"
                                class="text-end text-white"
                            >
                                Percepcion
                            </th>
                            <th class="text-end text-white">Total</th>
                            <th class="text-white">Acciones</th>
                        </tr>

                        <!-- Filas de datos -->
                        <tr class="text-center" slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td class="">
                                <strong>{{ row.user_name }}</strong> : 
                                <br />
                                {{ row.date_of_issue }}
                                <br />
                                <small>{{ row.time_of_issue }}</small>
                            </td>
                            <!-- <td class="text-center">{{ row.user_name }}</td> -->
                            <td
                                v-if="columns.date_of_due.visible"
                                class="text-center"
                            >
                                {{ row.date_of_due }}
                            </td>
                            <td>
                                {{ row.supplier_name }}<br /><small
                                    v-text="row.supplier_number"
                                ></small>
                            </td>
                            <td
                                :class="{
                                    'text-danger': row.state_type_id == '11'
                                }"
                            >
                                {{ row.state_type_payment_description }}
                            </td>
                            <td>
                                <template v-if="row.document_type_description === 'GUÍA'">
                                    {{ row.number_full }}<br /><small
                                        v-text="row.document_type_description"
                                    ></small>
                                </template>
                                <template v-else>
                                    {{ row.number }}<br /><small
                                        v-text="row.document_type_description"
                                    ></small>
                                </template>
                            </td>
                            <td class="text-center">
                                <el-popover
                                    placement="right"
                                    width="600"
                                    trigger="click"
                                    popper-class="custom-popover"
                                >
                                    <div class="popover-header">
                                        <h5>Detalles del Producto</h5>
                                    </div>
                                    <div class="popover-content">
                                        <el-table
                                            :data="row.items"
                                            border
                                            style="width: 100%"
                                        >
                                            <el-table-column
                                                width="80"
                                                property="key"
                                                label="#"
                                                align="center"
                                            ></el-table-column>
                                            <el-table-column
                                                width="220"
                                                label="Nombre"
                                                align="left"
                                            >
                                                <template slot-scope="scope">
                                                    <template
                                                        v-if="
                                                            scope.row
                                                                .name_product_pdf
                                                        "
                                                    >
                                                        <span
                                                            v-html="
                                                                scope.row
                                                                    .name_product_pdf
                                                            "
                                                        ></span>
                                                    </template>
                                                    <template v-else>
                                                        {{
                                                            scope.row
                                                                .description
                                                        }}
                                                    </template>
                                                </template>
                                            </el-table-column>
                                            <el-table-column
                                                width="90"
                                                label="Cantidad"
                                                align="center"
                                            >
                                                <template slot-scope="scope">
                                                    {{ calculate(scope.row) }}
                                                </template>
                                            </el-table-column>
                                        </el-table>
                                    </div>
                                    <el-button
                                        slot="reference"
                                        class="btn-view-details"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </el-button>
                                </el-popover>
                            </td>

                            <td class="text-center">
                                <button
                                    v-if="row.state_type_id != '11'"
                                    type="button"
                                    class="btn btn-info btn-sm m-1__2"
                                    @click.prevent="
                                        clickPurchasePayment(row.id)
                                    "
                                >
                                    Pagos
                                </button>
                            </td>
                            <td class="text-center">
                                {{ row.currency_type_id }}
                            </td>
                            <td
                                v-if="columns.total_free.visible"
                                class="text-end"
                            >
                                {{ row.total_free }}
                            </td>
                            <td
                                v-if="columns.total_unaffected.visible"
                                class="text-end"
                            >
                                {{ row.total_unaffected }}
                            </td>
                            <td
                                v-if="columns.total_exonerated.visible"
                                class="text-end"
                            >
                                {{ row.total_exonerated }}
                            </td>
                            <td
                                v-if="columns.total_taxed.visible"
                                class="text-end"
                            >
                                {{ row.total_taxed }}
                            </td>
                            <td
                                v-if="columns.total_igv.visible"
                                class="text-end"
                            >
                                {{ row.total_igv }}
                            </td>
                            <td
                                v-if="columns.total_perception.visible"
                                class="text-end"
                            >
                                {{ row.total_perception || 0 }}
                            </td>
                            <td class="text-end">{{ row.total }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button
                                        class="btn btnsdr-acciones btnsdr-acciones:hover"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        style="height: 50px; font-size: 1.2rem;"
                                    >
                                        <span
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                        >
                                            Acciones
                                        </span>
                                    </button>
                                    
                                    <div
                                        class="dropdown-menu dropdown-menu-end custom-dropdown"
                                    >
                                        <a
                                            v-if="row.state_type_id != '11'"
                                            :href="
                                                `/${resource}/edit/${row.id}`
                                            "
                                            class="dropdown-item text-edit"
                                            style="background-color: #28a745; color: #fff;"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a
                                            v-if="row.state_type_id != '11'"
                                            @click.prevent="
                                                clickAnulate(row.id)
                                            "
                                            class="dropdown-item text-anular"
                                            style="background-color: #dc3545; color: #fff;"
                                        >
                                            <i class="fa fa-ban"></i> Anular
                                        </a>
                                        <a
                                            v-if="
                                                row.document_type_description !=
                                                    'FACTURA ELECTRÓNICA' &&
                                                    row.state_type_id != '11'
                                            "
                                            @click.prevent="clickFacturar(row)"
                                            class="dropdown-item text-facturar"
                                            style="background-color: #17a2b8; color: #fff;"
                                        >
                                            <i class="fas fa-file-invoice"></i>
                                            Facturar
                                        </a>
                                        <a
                                            @click.prevent="
                                                clickOptions(row.id)
                                            "
                                            class="dropdown-item text-imprimir"
                                            style="background-color: #6c757d; color: #fff;"
                                        >
                                            <i class="fas fa-print"></i>
                                            Imprimir
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <document-options
                    :showDialog.sync="showDialogOptions"
                    :recordId="recordId"
                    :showClose="true"
                ></document-options>
                <purchase-import
                    :showDialog.sync="showImportDialog"
                ></purchase-import>
            </div>
        </div>
        <purchase-payments
            :showDialog.sync="showDialogPurchasePayments"
            :purchaseId="recordId"
            :external="true"
        ></purchase-payments>
        <FacturarModal
            :showFacturarDialog.sync="showFacturarDialog"
            :data.sync="data"
        ></FacturarModal>
    </div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* ***** */
/* Estilo general del Popover */
.custom-popover {
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    background-color: #f9f9f9;
    font-family: "Arial", sans-serif;
}

/* Encabezado del Popover */
.popover-header {
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 1.2rem;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 8px;
}

/* Contenido del Popover */
.popover-content {
    text-align: left;
}

/* Tabla dentro del Popover */
.el-table {
    font-size: 0.9rem;
    background-color: #ffffff;
    border-radius: 5px;
    overflow: hidden;
}

/* Columnas de la tabla */
.el-table th {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
    text-align: center;
}

.el-table td {
    color: #555;
}

/* Botón para abrir el Popover */
.btn-view-details {
    background-color: #007bff;
    color: #fff;
    border: none;
    font-size: 0.9rem;
    padding: 5px 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-view-details:hover {
    background-color: #0056b3;
    transform: scale(1.1);
}

/* Botón principal de Acciones */
.btn-acciones {
    background-color: #0d335b;
    /* Azul por defecto */
    color: #fff;
    /* Texto blanco */
    border: none;
    font-weight: bold;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-acciones:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Menú desplegable personalizado */
.custom-dropdown {
    min-width: 180px;
    /* Ancho fijo */
    padding: 0;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.custom-dropdown .dropdown-item {
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 10px;
    /* Espacio entre ícono y texto */
    font-weight: bold;
    color: #595656;
    /* Letras blancas */
    transition: all 0.3s ease;
}

/* Colores específicos con fondo igual al texto */
.text-edit {
    background-color: #28a745;
    /* Verde */
}

.text-anular {
    background-color: #dc3545;
    /* Rojo */
}

.text-facturar {
    background-color: #17a2b8;
    /* Celeste */
}

.text-imprimir {
    background-color: #6c757d;
    /* Gris */
}

/* Efecto hover: Opacidad y escala */
.custom-dropdown .dropdown-item:hover {
    opacity: 0.85;
    transform: translateX(5px);
    /* Efecto desplazamiento sutil */
}

/* ************ */
/* Botones Generales */
.btn {
    border: none;
    border-radius: 5px;
    padding: 8px 15px;
    font-size: 1rem;
    font-weight: bold;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-transform: uppercase;
}

.btn i {
    margin-right: 8px;
    /* Espacio entre el icono y el texto */
    font-size: 18px;
    /* Tamaño del icono */
}

/* Botón Restaurar */
.btn-restore {
    background-color: #28a745;
    /* Verde */
    color: #fff;
}

.btn-restore:hover {
    background-color: #218838;
    transform: scale(1.05);
}

/* Botón Aparcar */
.btn-apark {
    background-color: #0056b3;
    /* Azul oscuro */
    color: #fff;
}

.btn-apark:hover {
    background-color: #004080;
    transform: scale(1.05);
}

/* Botón Agregar Productos */
.btn-add-product {
    background-color: #17a2b8;
    /* Color celeste/teal */
    color: #fff;
}

.btn-add-product:hover {
    background-color: #138496;
    transform: scale(1.05);
}

/* Tooltip Personalizado */
.tooltip-custom {
    background-color: #333;
    color: #fff;
    font-size: 0.9rem;
    padding: 6px 10px;
    border-radius: 4px;
}

/* Iconos dentro de los botones */
.btn i {
    vertical-align: middle;
    font-size: 1.1rem;
}

/* Contenedor de botones */
.button-group {
    display: flex;
    gap: 10px;
    /* Espacio entre botones */
    justify-content: flex-end;
    /* Alinea los botones a la derecha */
}

/* Botón de Tacho de Basura (Eliminar) */
.btn-trash {
    background-color: #dc3545;
    /* Rojo */
    color: #fff;
}

.btn-trash:hover {
    background-color: #c82333;
    transform: scale(1.05);
}
</style>

<script>
// import DocumentsVoided from './partials/voided.vue'
import DocumentOptions from "./partials/options.vue";

import DataTable from "../../components/DataTable.vue";
import { deletable } from "../../mixins/deletable";
import PurchaseImport from "./import.vue";
import PurchasePayments from "@viewsModulePurchase/purchase_payments/payments.vue";
import FacturarModal from "./partials/facturar.vue";
import queryString from "query-string";

export default {
    mixins: [deletable],
    props: ["configuration"],
    // components: {DocumentsVoided, DocumentOptions, DataTable},
    components: {
        DataTable,
        PurchaseImport,
        PurchasePayments,
        FacturarModal,
        DocumentOptions
    },
    data() {
        return {
            total: 0,
            showDialogVoided: false,
            resource: "purchases",
            recordId: null,
            showDialogOptions: false,
            showDialogPurchasePayments: false,
            showImportDialog: false,
            data: {},
            showFacturarDialog: false,
            columns: {
                date_of_due: {
                    title: "F. Vencimiento",
                    visible: false
                },
                total_free: {
                    title: "T.Gratuita",
                    visible: false
                },
                total_unaffected: {
                    title: "T.Inafecta",
                    visible: false
                },
                total_exonerated: {
                    title: "T.Exonerado",
                    visible: false
                },
                total_taxed: {
                    title: "T.Gravado",
                    visible: false
                },
                total_igv: {
                    title: "T.Igv",
                    visible: false
                },
                total_perception: {
                    title: "Percepcion",
                    visible: false
                }
            }
        };
    },
    created() {},
    mounted() {
        this.getAvaibleCash();
    },
    methods: {
        getAvaibleCash() {
            this.$http("/caja/cash-transfer/available?with_all=1").then(
                response => {
                    console.log("🚀 ~ this.$http ~ response:", response);
                    this.total = response.data;
                }
            );
        },
        calculate(item) {
            let {
                quantity,
                unit_type_id,
                max_quantity,
                max_quantity_description
            } = item;
            if (!max_quantity && !max_quantity_description) {
                return `${quantity} ${unit_type_id}`;
            }
            let general = Math.trunc(quantity / max_quantity);
            let part = ((quantity / max_quantity) % 1).toFixed(2);

            let text = `${general} ${unit_type_id}`;
            if (part != 0) {
                let part = (quantity / max_quantity) % 1;

                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${unit_type_id}`;
                }
            } else {
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                }
            }

            return text;
        },
        clickReport(type) {
            let params = queryString.stringify({
                ...type
            });
            console.log(params);
            window.open(`purchases/export/excel/?${params}`, "_blank");
        },
        clickPurchasePayment(recordId) {
            this.recordId = recordId;
            this.showDialogPurchasePayments = true;
        },
        clickVoided(recordId = null) {
            this.recordId = recordId;
            this.showDialogVoided = true;
        },
        clickDownload(download) {
            window.open(download, "_blank");
        },
        clickOptions(recordId = null) {
            this.recordId = recordId;
            this.showDialogOptions = true;
        },
        clickAnulate(id) {
            this.$confirm("¿Está seguro de anular la compra?", "Anular", {
                confirmButtonText: "Anular",
                cancelButtonText: "Cancelar",
                type: "warning"
            })
                .then(() => {
                    this.$http
                        .get(`/${this.resource}/anular/${id}`)
                        .then(response => {
                            let { success, message } = response.data;
                            if (!success && message) {
                                this.$showSAlert("Error", message, "error");
                                return;
                            } else {
                                this.$showSAlert(
                                    "Anulado",
                                    "La compra ha sido anulada",
                                    "success"
                                );
                                this.$eventHub.$emit("reloadData");
                            }
                        });
                })
                .catch(() => {});
        },
        clickNuevo() {
            location.href = `/${this.resource}/create`;
        },
        clickDelete(id) {
            this.delete(`/${this.resource}/delete/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickFacturar(row) {
            this.showFacturarDialog = true;
            this.data = row;
        },
        /* clickImport() {
            this.showImportDialog = true;
        } */
    }
};
</script>
