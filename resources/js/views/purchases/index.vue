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
                    <div class="col-sm-6">
                        <h6><span>Compras</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Compras</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-shopping-cart"></i> Listado de Compras
                    </h4>
                </div>

                <!-- <div class="data-table-visible-columns">
                    <el-dropdown :hide-on-click="false">
                        <el-button type="primary">
                            Mostrar/Ocultar columnas<i
                                class="el-icon-arrow-down el-icon--right"
                            ></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown">
                            <el-dropdown-item
                                v-for="(column, index) in columns"
                                :key="index"
                            >
                                <el-checkbox v-model="column.visible">{{
                                    column.title
                                }}</el-checkbox>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </div> -->
                <div class="card-body">
                    <div class="data-table-visible-columns">
                        <el-button
                            type="primary"
                            class=""
                            href="javascript:void(0)"
                            @click.prevent="clickNuevo()"
                        >
                            <i class="fas fa-cart-plus fa-lg"></i>
                            Nueva Compra
                        </el-button>
                        <el-button
                            type="primary"
                            class=""
                            href="javascript:void(0)"
                            @click.prevent="clickImport()"
                        >
                            <i class="fas fa-file-import fa-lg"></i>
                            Importar Compra
                        </el-button>
                    </div>

                    <data-table
                        :resource="resource"
                        @clickReport="clickReport"
                        class="table-striped"
                    >
                        <tr slot="heading" class="bg-primary">
                            <th class="text-white text-center">#</th>
                            <th class="text-center text-white">F. Emisión</th>
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
                            <!-- <th>F. Pago</th> -->
                            <!-- <th>Estado</th> -->
                            <th class="text-center text-white">Moneda</th>
                            <!-- <th class="text-end">T.Exportación</th> -->
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
                            <!-- <th class="text-center">Descargas</th> -->
                            <th class="text-end text-white">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr class="text-center" slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td class="text-center">{{ row.date_of_issue }}</td>
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
                            <td>{{ row.state_type_payment_description }}</td>
                            <template v-if="row.number != '-0'">
                                <td>
                                    {{ row.number }}<br />
                                    <small
                                        v-text="row.document_type_description"
                                    ></small
                                    ><br />
                                </td>
                            </template>
                            <template v-else>
                                <td>
                                    {{ row.number_full }}<br />
                                    <small
                                        v-text="row.document_type_description"
                                    ></small
                                    ><br />
                                </td>
                            </template>
                            <td class="text-center">
                                <el-popover
                                    placement="right"
                                    width="400"
                                    trigger="click"
                                >
                                    <el-table :data="row.items">
                                        <el-table-column
                                            width="80"
                                            property="key"
                                            label="#"
                                        ></el-table-column>
                                        <el-table-column
                                            width="220"
                                            label="Nombre"
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
                                                    {{ scope.row.description }}
                                                </template>
                                            </template>
                                        </el-table-column>
                                        <el-table-column
                                            width="90"
                                            label="Cantidad"
                                        >
                                            <template slot-scope="scope">{{
                                                calculate(scope.row)
                                            }}</template>
                                        </el-table-column>
                                    </el-table>
                                    <el-button slot="reference">
                                        <i class="fa fa-eye"></i
                                    ></el-button>
                                </el-popover>
                            </td>
                            <!-- <td>{{ row.payment_method_type_description }}</td> -->
                            <!-- <td>
                            <template v-for="(it,ind) in row.payments">
                                {{it.payment_method_type_description}} - {{it.payment}}
                            </template>
                        </td> -->
                            <!-- <td>{{ row.state_type_description }}</td> -->
                            <td class="text-center">
                                <button
                                    v-if="row.state_type_id != '11'"
                                    type="button"
                                    style="min-width: 41px"
                                    class="btn waves-effect waves-light btn-sm btn-info m-1__2"
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
                            <!-- <td class="text-end">{{ row.total_exportation }}</td> -->
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
                                {{
                                    row.total_perception
                                        ? row.total_perception
                                        : 0
                                }}
                            </td>
                            <td class="text-end">{{ row.total }}</td>

                            <td class="text-end">
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
                                <div
                                    class="dropdown-menu dropdown-menu-end"
                                    style=""
                                >
                                    <a
                                        type="button"
                                        class="dropdown-item text-secondary"
                                        v-if="row.state_type_id != '11'"
                                        :href="`/${resource}/edit/${row.id}`"
                                    >
                                        <i class="fa fa-edit"></i> Editar
                                    </a>

                                    <a
                                        v-if="row.state_type_id != '11'"
                                        @click.prevent="clickAnulate(row.id)"
                                        type="button"
                                        class="dropdown-item text-danger"
                                    >
                                        <i class="fa fa-ban"></i> Anular
                                    </a>
                                    <a
                                        v-if="row.state_type_id == '11'"
                                        type="button"
                                        @click.prevent="clickDelete(row.id)"
                                        class="dropdown-item text-danger"
                                        ><i class="fa fa-trash"></i> Eliminar
                                    </a>

                                    <a
                                        v-if="
                                            row.document_type_description !=
                                                'FACTURA ELECTRÓNICA'
                                        "
                                        @click.prevent="clickFacturar(row)"
                                        type="button"
                                        class="dropdown-item text-success"
                                    >
                                        <i class="fas fa-file-invoice"></i>
                                        Facturar
                                    </a>
                                    <a
                                        type="button"
                                        class="dropdown-item text-primary"
                                        @click.prevent="clickOptions(row.id)"
                                        >Opciones</a
                                    >
                                </div>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <!-- <documents-voided :showDialog.sync="showDialogVoided"
                            :recordId="recordId"></documents-voided>
-->
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
    props:['configuration'],
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
            this.$http("/caja/cash-transfer/available").then(response => {
                console.log("🚀 ~ this.$http ~ response:", response)
                this.total = response.data;
            });
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
            this.anular(`/${this.resource}/anular/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
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
        clickImport() {
            this.showImportDialog = true;
        }
    }
};
</script>
