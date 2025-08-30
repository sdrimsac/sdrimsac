<!-- Modulo Listado de Compras -->
<template>
    <div>
        <!-- <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header" >
                <div class="row">
                    <div v-if="configuration.sale_note_credit_penalty"
                        class="col-sm-12 col-lg-2 alert alert-success d-flex justify-content-start align-items-center">
                        <span>Efectivo disponible: S/
                            {{ Number(total).toFixed(2) }}</span>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="container-fluid p-l-0 p-r-0">
            <div class="card">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 8px;"
                >
                    <h3
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1rem; font-weight: bold;"
                    >
                        <i
                            class="fas fa-shopping-cart"
                            style="font-size: 1rem; margin-right: 0.5rem;"
                        ></i>
                        Módulo de Compras
                    </h3>
                </div>

                <div
                    class="data-table-visible-columns d-flex align-items-center"
                >
                    <template v-for="(amount, bankName) in banks">
                        <el-button
                            v-if="amount > 0"
                            class="btn_excelsmallmetthod"
                            style="font-weight: bold; font-size: 1.1rem; background-color: #00bfff; border-color: #00bfff; color: #fff !important;"
                        >
                            <span> {{ bankName }}: S/ {{ amount }} </span>
                        </el-button>
                    </template>
                    <el-button
                        v-if="paymentMethods.IZYPAY > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #ff0000; border-color: #ff0000; color: #fff !important;"
                    >
                        <span> Izipay: S/ {{ paymentMethods.IZYPAY }} </span>
                    </el-button>
                    <el-button
                        v-if="paymentMethods.OPENPAY > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background: linear-gradient(135deg, #2196f3 50%, #2ecc71 50%); border-color: #2196f3; color: #fff !important;"
                    >
                        <span> OpenPay: S/ {{ paymentMethods.OPENPAY }} </span>
                    </el-button>
                    <el-button
                        v-if="paymentMethods.NIUBIZ > 0"
                        class="btn_excelsmallmetthod"
                        style="font-weight: bold; font-size: 1.1rem; background-color: #2196f3; border-color: #2196f3; color: #fff !important;"
                    >
                        <span> Niubiz: S/ {{ paymentMethods.NIUBIZ }} </span>
                    </el-button>
                    <el-button
                        v-if="
                            paymentMethods &&
                                Number(paymentMethods.Efectivo) > 0
                        "
                        type="success"
                        class="btn_excelsmall "
                        disabled
                        style="font-weight: bold; font-size: 1.1rem;"
                    >
                        <i class="fas fa-wallet"></i>
                        Efectivo: S/
                        {{ Number(paymentMethods.Efectivo).toFixed(2) }}
                    </el-button>
                    <el-button
                        v-if="
                            paymentMethods && Number(paymentMethods.Culqui) > 0
                        "
                        class="btn_excelsmallmetthod"
                        disabled
                        style="font-weight: bold; font-size: 1.1rem; background-color: orange; border-color: orange !important;"
                    >
                        <i class="fas fa-wallet"></i>
                        Culqui: S/
                        {{ Number(paymentMethods.Culqui).toFixed(2) }}
                    </el-button>
                    <el-button
                        v-if="paymentMethods && Number(paymentMethods.PLIN) > 0"
                        type="info"
                        class="btn_excelsmallmetthod"
                        disabled
                        style="font-weight: bold; font-size: 1.1rem; background-color: #17a2b8; border-color: #17a2b8 !important;"
                    >
                        <i class="fas fa-wallet"></i>
                        Plin: S/ {{ Number(paymentMethods.PLIN).toFixed(2) }}
                    </el-button>
                    <el-button
                        v-if="paymentMethods && Number(paymentMethods.YAPE) > 0"
                        type="secondary"
                        class="btn_excelsmallmetthod"
                        disabled
                        style="font-weight: bold; font-size: 1.1rem; background-color: #8e44ad; border-color: #8e44ad; color: #fff !important;"
                    >
                        <i class="fas fa-wallet"></i>
                        Yape: S/ {{ Number(paymentMethods.YAPE).toFixed(2) }}
                    </el-button>
                    <el-button
                        v-if="total && Number(total) > 0"
                        type="success"
                        class="btn_excelsmall "
                        disabled
                        style="font-weight: bold; font-size: 1.1rem;"
                    >
                        <i class="fas fa-wallet"></i>
                        disponible: S/ {{ Number(total).toFixed(2) }}
                    </el-button>
                    <el-button
                        type="primary"
                        class="btn_guardarsmall"
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
                            <th
                                class="text-white text-center"
                                style="width: 10px;"
                            >
                                #
                            </th>
                            <th
                                class="text-left text-white"
                                style="width: 60px;"
                            >
                                Actividad
                            </th>
                            <!-- <th class="text-center text-white">Usuario</th> -->
                            <th
                                class="text-center text-white"
                                v-if="columns.date_of_due.visible"
                                style="width: 110px;"
                            >
                                F. Vencimiento
                            </th>
                            <th
                                class="text-white text-center"
                                style=" width: 180px;"
                            >
                                Proveedor
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 80px;"
                            >
                                Estado
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 120px;"
                            >
                                Comprobante
                            </th>
                            <th
                                class="text-white text-center"
                                style="width: 90px;"
                            >
                                Productos
                            </th>
                            <!-- <th class="text-white text-center" style="width: 80px;">Pagos</th> -->
                            <th
                                class="text-center text-white"
                                style="width: 80px;"
                            >
                                Moneda
                            </th>
                            <th
                                v-if="columns.total_free.visible"
                                class="text-end"
                                style="width: 90px;"
                            >
                                T.Gratuita
                            </th>
                            <th
                                v-if="columns.total_unaffected.visible"
                                class="text-end text-white"
                                style="width: 90px;"
                            >
                                T.Inafecta
                            </th>
                            <th
                                v-if="columns.total_exonerated.visible"
                                class="text-end text-white"
                                style="width: 90px;"
                            >
                                T.Exonerado
                            </th>
                            <th
                                v-if="columns.total_taxed.visible"
                                class="text-end text-white"
                                style="width: 90px;"
                            >
                                T.Gravado
                            </th>
                            <th
                                v-if="columns.total_igv.visible"
                                class="text-end text-white"
                                style="width: 90px;"
                            >
                                T.Igv
                            </th>
                            <th
                                v-if="columns.total_perception.visible"
                                class="text-end text-white"
                                style="width: 90px;"
                            >
                                Percepcion
                            </th>
                            <th
                                class="text-center text-white"
                                style="width: 100px;"
                            >
                                Total
                            </th>
                            <th
                                class="text-center text-white"
                                style="width: 110px;"
                            >
                                Acciones
                            </th>
                        </tr>

                        <!-- Filas de datos -->
                        <tr slot-scope="{ index, row }">
                            <td class="text-center">{{ index }}</td>
                            <td class="">
                                <strong style="font-size: 1.1rem;">{{
                                    row.user_name
                                }}</strong>
                                :
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
                            <td class="text-left">
                                {{ row.supplier_name }}<br /><small
                                    v-text="row.supplier_number"
                                ></small>
                            </td>
                            <td
                                :class="{
                                    'text-danger': row.state_type_id == '11'
                                }"
                                class="text-center"
                            >
                                {{ row.state_type_payment_description }}
                            </td>
                            <td>
                                <template
                                    v-if="
                                        row.document_type_description === 'GUÍA'
                                    "
                                >
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
                                    width="420"
                                    trigger="click"
                                    popper-class="custom-popover pro-popover"
                                >
                                    <div
                                        class="popover-header pro-popover-header"
                                    >
                                        <i
                                            class="fas fa-box-open"
                                            style="color:#007bff; margin-right:8px;"
                                        ></i>
                                        Productos Comprados
                                    </div>
                                    <div
                                        class="popover-content pro-popover-content"
                                        style="background: #23272f; border-radius: 8px; padding: 10px;"
                                    >
                                        <el-table
                                            :data="row.items"
                                            border
                                            style="width:100%; border-radius:10px; overflow:hidden;"
                                            size="mini"
                                        >
                                            <el-table-column
                                                width="50"
                                                property="key"
                                                label="#"
                                                align="center"
                                            >
                                                <template slot-scope="scope">
                                                    <span
                                                        style="font-weight:bold; color:#007bff;"
                                                        >{{
                                                            scope.$index + 1
                                                        }}</span
                                                    >
                                                </template>
                                            </el-table-column>
                                            <el-table-column
                                                width="180"
                                                label="Nombre"
                                                align="left"
                                            >
                                                <template slot-scope="scope">
                                                    <span
                                                        style="font-weight:500;"
                                                    >
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
                                                    </span>
                                                </template>
                                            </el-table-column>
                                            <el-table-column
                                                width="80"
                                                label="Cantidad"
                                                align="center"
                                            >
                                                <template slot-scope="scope">
                                                    <span
                                                        style="background:#e3f2fd; border-radius:4px; padding:2px 8px; font-weight:500;"
                                                    >
                                                        {{
                                                            calculate(scope.row)
                                                        }}
                                                    </span>
                                                </template>
                                            </el-table-column>
                                        </el-table>
                                    </div>
                                    <el-button
                                        slot="reference"
                                        class="btn-view-details pro-btn-view-details"
                                        style="box-shadow:0 2px 8px rgba(0,0,0,0.08);"
                                    >
                                        <i class="fa fa-eye"></i> Ver
                                    </el-button>
                                </el-popover>
                            </td>

                            <!-- <td class="text-center">
                                <button v-if="row.state_type_id != '11'" type="button"
                                    class="btn btn-info btn-sm m-1__2" @click.prevent="
                                        clickPurchasePayment(row.id)
                                        ">
                                    Pagos
                                </button>
                            </td> -->
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
                                        class="btn btn-acciones"
                                        style="background-color: #1e5a85; color: #fff;"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
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
                                        class="dropdown-menu dropdown-menu-end custom-dropdown dark-dropdown-bg"
                                    >
                                        <button
                                            v-if="row.state_type_id != '11'"
                                            type="button"
                                            class="btn btn-edit btn-sm m-1__2 me-1 btn-efecto action-btn"
                                            style="background-color: #28a745; color: #fff; margin: 2px;"
                                            @click="goToEdit(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </button>
                                        <button
                                            v-if="row.state_type_id != '11'"
                                            type="button"
                                            class="btn btn-anular btn-sm m-1__2 me-1 btn-efecto action-btn"
                                            style="background-color: #dc3545; color: #fff; margin: 2px;"
                                            @click.prevent="
                                                clickAnulate(row.id)
                                            "
                                        >
                                            <i class="fa fa-ban"></i> Anular
                                        </button>
                                        <button
                                            v-if="
                                                row.document_type_description !=
                                                    'FACTURA ELECTRÓNICA' &&
                                                    row.state_type_id != '11'
                                            "
                                            type="button"
                                            class="btn btn-facturar btn-sm m-1__2 me-1 btn-efecto action-btn"
                                            style="background-color: #17a2b8; color: #fff; margin: 2px;"
                                            @click.prevent="clickFacturar(row)"
                                        >
                                            <i class="fas fa-file-invoice"></i>
                                            Facturar
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-imprimir btn-sm m-1__2 me-1 btn-efecto action-btn"
                                            style="background-color: #6c757d; color: #fff; margin: 2px;"
                                            @click.prevent="
                                                clickOptions(row.id)
                                            "
                                        >
                                            <i class="fas fa-print"></i>
                                            Imprimir
                                        </button>
                                        <button
                                            v-if="row.state_type_id != '11'"
                                            type="button"
                                            class="btn btn-edit btn-sm m-1__2 me-1 btn-efecto action-btn"
                                            style="background-color: #1e5a85; color: #fff; margin: 2px;"
                                            @click.prevent="
                                                clickPurchasePayment(row.id)
                                            "
                                        >
                                            <i class="fa fa-edit"></i> Pagos
                                        </button>
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
        <import-color-size
            :showDialog.sync="showImportColorSizeDialog"
        ></import-color-size>
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
    border-bottom: 2px solid #0e2e50;
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
    background-color: #103256;
    color: #fff;
    border: none;
    font-size: 0.9rem;
    padding: 5px 10px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-view-details:hover {
    background-color: #193553;
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
import ImportColorSize from "./partials/importTallaColor.vue";

export default {
    mixins: [deletable],
    props: ["configuration"],
    // components: {DocumentsVoided, DocumentOptions, DataTable},
    components: {
        DataTable,
        PurchaseImport,
        PurchasePayments,
        FacturarModal,
        DocumentOptions,
        ImportColorSize
    },
    data() {
        return {
            banks: [],
            showImportColorSizeDialog: false,
            total: 0,
            paymentMethods: {
                Efectivo: 0,
                Culqui: 0,
                PLIN: 0,
                YAPE: 0,
                NIUBIZ: 0,
                OPENPAY: 0,
                IZYPAY: 0,
                Transferencia: 0
            },
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
        goToEdit(id) {
            window.location.href = `/${this.resource}/edit/${id}`;
        },

        clickImportColorSize() {
            this.showImportColorSizeDialog = true;
        },
        getAvaibleCash() {
            this.$http("/caja/cash-transfer/available?with_all=1")
            .then(response => {
                const data = response.data || {};
                let total = 0;
                // Inicializa los métodos de pago y bancos
                const paymentMethods = {
                Efectivo: 0,
                Culqui: 0,
                PLIN: 0,
                YAPE: 0,
                NIUBIZ: 0,
                OPENPAY: 0,
                IZYPAY: 0,
                Transferencia: 0
                };
                const banks = {};

                // Procesa los métodos de pago
                if (data.metodos && typeof data.metodos === "object") {
                Object.entries(data.metodos).forEach(([method, amount]) => {
                    // Normaliza el nombre del método si es necesario
                    if (paymentMethods.hasOwnProperty(method)) {
                    paymentMethods[method] = Number(amount) || 0;
                    }
                    total += Number(amount) || 0;
                });
                }

                // Procesa los bancos
                if (data.banks && typeof data.banks === "object") {
                Object.entries(data.banks).forEach(([bank, amount]) => {
                    banks[bank] = Number(amount) || 0;
                    total += Number(amount) || 0;
                });
                // Si quieres sumar todos los bancos en Transferencia:
                const transferenciaTotal = Object.values(data.banks).reduce((acc, val) => acc + Number(val || 0), 0);
                paymentMethods.Transferencia = transferenciaTotal;
                }

                // Si el formato anterior (array o objeto plano)
                if (!data.metodos && !data.banks) {
                if (Array.isArray(data)) {
                    data.forEach(item => {
                    const method = item.method || item.name || item[0];
                    const amount = item.amount || item.value || item[1] || 0;
                    if (!method) return;
                    paymentMethods[method] = Number(amount) || 0;
                    total += Number(amount) || 0;
                    });
                } else {
                    Object.entries(data).forEach(([method, amount]) => {
                    paymentMethods[method] = Number(amount) || 0;
                    total += Number(amount) || 0;
                    });
                }
                }

                this.total = total;
                this.paymentMethods = paymentMethods;
                this.banks = banks;
            })
            .catch(() => {});
        },

        /* getAvaibleCash() {
            this.$http("/caja/cash-transfer/available?with_all=1")
                .then(response => {
                    // Guardar los métodos de pago y sus montos en un objeto
                    const data = response.data || {};
                    let total = 0;
                    // Keep defaults for known keys to avoid undefined in template
                    const paymentMethods = {
                        Efectivo: 0,
                        Culqui: 0,
                        Plin: 0,
                        yape: 0,
                        NIUBIZ: 0,
                        OPENPAY: 0,
                        IZYPAY: 0,
                        Transferencia: 0
                    };
                    if (Array.isArray(data)) {
                        // support [{ method, amount }, { method, amount }]
                        data.forEach(item => {
                            const method = item.method || item.name || item[0];
                            const amount =
                                item.amount || item.value || item[1] || 0;
                            if (!method) return;
                            paymentMethods[method] = Number(amount) || 0;
                            total += Number(amount) || 0;
                        });
                    } else {
                        Object.entries(data).forEach(([method, amount]) => {
                            paymentMethods[method] = Number(amount) || 0;
                            total += Number(amount) || 0;
                        });
                    }
                    this.total = total;
                    this.paymentMethods = paymentMethods;
                })
                .catch(() => {
                    // If request fails, keep default values
                });
        }, */

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
        }
        /* clickImport() {
            this.showImportDialog = true;
        } */
    }
};
</script>
