<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Comprobante Nota de Venta</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashbodard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Nota de Venta</span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="bookmark">
                            <button
                                type="button"
                                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                                @click.prevent="clickCreate()"
                            >
                                <i class="icofont-plus-circle"></i>
                                <span>Nuevo</span>
                            </button>
                            <button
                                @click.prevent="onOpenModalGenerateCPE"
                                type="button"
                                class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto"
                            >
                                <span>
                                    Generar comprobante desde múltiples Notas
                                </span>
                            </button>
                            <!-- <ul>
                                <li>
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Nueva Nota de venta"
                                        placement="bottom-end"
                                    >
                                        <a
                                            href="javascript:void(0)"
                                            @click.prevent="clickCreate()"
                                            v-if="user_type == 'admin'"
                                            data-container="body"
                                            data-bs-toggle="popover"
                                            data-placement="top"
                                            data-original-title="Tables"
                                        >
                                            <i data-feather="plus-circle"></i>
                                        </a>
                                    </el-tooltip>
                                </li>
                            </ul> -->
                        </div>
                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <!-- <div class="data-table-visible-columns"> -->
                <div class="col-12 text-end">
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
                </div>
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading">
                            <th>#</th>
                            <th class="text-end">Acciones</th>
                            <th class="text-center">Fecha Emisión</th>
                            <th>Vendedor</th>
                            <th>Cliente</th>
                            <th>Nota de Venta</th>
                            <th>Guia</th>
                            <th>Estado</th>
                            <th class="text-center">Moneda</th>
                            <th
                                class="text-end"
                                v-if="columns.total_exportation.visible"
                            >
                                T.Exportación
                            </th>
                            <th
                                class="text-end"
                                v-if="columns.total_free.visible"
                            >
                                T.Gratuito
                            </th>
                            <th
                                class="text-end"
                                v-if="columns.total_unaffected.visible"
                            >
                                T.Inafecta
                            </th>
                            <th
                                class="text-end"
                                v-if="columns.total_exonerated.visible"
                            >
                                T.Exonerado
                            </th>
                            <th
                                class="text-end"
                                v-if="columns.total_taxed.visible"
                            >
                                T.Gravado
                            </th>
                            <th
                                class="text-end"
                                v-if="columns.total_igv.visible"
                            >
                                T.Igv
                            </th>

                            <th class="text-center">Adelanto</th>
                            <th class="text-center">Metodo de pago</th>
                            <th class="text-center">Pagado</th>
                            <th class="text-center">Resta</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Tasa</th>
                            <th class="text-center">Comprobantes</th>
                            <th class="text-center">Estado pago</th>
                            <th class="text-center">Acciones crédito</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td class="text-end">
                                <div
                                    v-if="row.state_type_id != 11"
                                    class="btn-toolbar mb-2"
                                    role="toolbar"
                                >
                                    <div class="btn-group mb-1">
                                        <button
                                            class="btn btn-secondary btn-sm dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div
                                            class="dropdown-menu dropdown-menu-sm"
                                        >
                                            <a
                                                href="!#"
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                                class="dropdown-item"
                                                @click.prevent="
                                                    clickDetail(row)
                                                "
                                                ><i class="fas fa-trash"></i>
                                                Ver detalle
                                            </a>
                                            <a
                                                :href="
                                                    `/dispatches/create_new/sale_note/${row.id}`
                                                "
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                                class="dropdown-item"
                                            >
                                                <i class="far fa-file-alt"></i>

                                                Generar guía
                                            </a>
                                            <a
                                                href="!#"
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                                class="dropdown-item"
                                                @click.prevent="
                                                    clickVoided(row.id)
                                                "
                                                ><i class="fas fa-trash"></i>
                                                Anular Nota de Venta
                                            </a>
                                            <!-- <div
                                                class="dropdown-divider"
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                            ></div> -->
                                            <!-- <a
                                                href="!#"
                                                class="dropdown-item"
                                                @click.prevent="
                                                    clickCreate(row.id)
                                                "
                                                v-if="
                                                    row.btn_generate &&
                                                        row.state_type_id !=
                                                            '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                            >
                                                <i
                                                    class="fas fa-file-signature"
                                                ></i>
                                                Modificar Nota de Venta
                                            </a> -->
                                            <!-- <div
                                                class="dropdown-divider"
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                            ></div> -->
                                            <a
                                                href="!#"
                                                class="dropdown-item"
                                                @click.prevent="
                                                    clickGenerate(row.id)
                                                "
                                                v-if="
                                                    !row.changed &&
                                                        row.state_type_id !=
                                                            '11' &&
                                                        soapCompany != '03' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                            >
                                                <i
                                                    class="fas fa-file-excel"
                                                ></i>
                                                Generar Comprobante
                                            </a>
                                            <!-- <div
                                                class="dropdown-divider"
                                                v-if="
                                                    row.state_type_id != '11' &&
                                                        (user_type == 'admin' ||
                                                            user_type ==
                                                                'superadmin')
                                                "
                                            ></div> -->
                                            <a
                                                href="!#"
                                                v-if="row.state_type_id != '11'"
                                                class="dropdown-item"
                                                @click.prevent="
                                                    clickOptions(row.id)
                                                "
                                                ><i class="fas fa-print"></i>
                                                Imprimir Nota de Venta
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                {{ row.date_of_issue }}
                                <template>
                                    <br />
                                    <small>
                                        {{ row.time_of_issue }}
                                    </small>
                                </template>
                            </td>
                            <td>{{ row.user_name }}</td>
                            <td>
                                {{ row.customer_name }}<br /><small
                                    v-text="row.customer_number"
                                ></small>
                            </td>

                            <td>{{ row.full_number }}</td>
                            <td>
                                <span
                                    v-for="(dispatch, idx) in row.dispatches"
                                    :key="idx"
                                >
                                    {{ dispatch.number_full }} <br />
                                </span>
                            </td>
                            <td>{{ row.state_type_description }}</td>
                            <td class="text-center">
                                {{ row.currency_type_id }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_exportation.visible"
                            >
                                {{ row.total_exportation }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_free.visible"
                            >
                                {{ row.total_free }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_unaffected.visible"
                            >
                                {{ row.total_unaffected }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_exonerated.visible"
                            >
                                {{ row.total_exonerated }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_taxed.visible"
                            >
                                {{ row.total_taxed }}
                            </td>
                            <td
                                class="text-end"
                                v-if="columns.total_igv.visible"
                            >
                                {{ row.total_igv }}
                            </td>

                            <td
                                class="text-center"
                                v-if="columns.total_paid.visible"
                            >
                                {{ row.total_paid }}
                            </td>
                            <td>
                                {{ row.advances }}
                            </td>
                            <!-- <td>
                                {{ row.advances }}
                            </td> -->
                            <!-- <template v-if="row.total_pending_paid > 0">
                                <td
                                    class="text-center text-danger font-weight-bold"
                                >
                                    {{ row.total_pending_paid }}
                                </td>
                            </template>
                            <template v-else>
                                <td class="text-end"></td>
                            </template> -->
                            <td>
                                <div
                                    class="justify-content-center d-flex flex-column"
                                >
                                    <el-tag
                                        style="margin-top:5px;"
                                        v-for="(data, idx) in row.boxes
                                            .slice(-3)
                                            .reverse()"
                                        :key="idx"
                                        type="primary"
                                    >
                                        <b
                                            >{{ data.method }} S/{{
                                                data.amount
                                            }}</b
                                        >
                                    </el-tag>
                                </div>
                            </td>
                            <!-- <template v-if="row.total_payment != null || row.total_payment != 0">
                                <td class="text-end">
                                    {{ row.total }}
                                </td>
                            </template> -->
                            <td class="text-end">
                                {{ row.paid_amount.toFixed(2) }}
                            </td>
                            <td class="text-end">
                                {{ row.pending.toFixed(2) }}
                            </td>
                            <template>
                                <td class="text-end">
                                    {{ Number(row.total).toFixed(2) }}
                                </td>
                            </template>
                            <td class="text-end">
                                {{
                                    row.tax_rate > 0 ? `${row.tax_rate}%` : "-"
                                }}
                            </td>
                            <td>
                                <template
                                    v-for="(document, i) in row.documents"
                                >
                                    <label
                                        :key="i"
                                        v-text="document.number_full"
                                        class="d-block"
                                    ></label>
                                </template>
                            </td>
                            <td class="text-center">
                                <span
                                    class="badge text-white"
                                    :class="{
                                        'bg-success': row.paid,
                                        'bg-warning': !row.paid
                                    }"
                                    v-if="
                                        row.state_type_description !=
                                            'Anulado' && row.total > 0
                                    "
                                    >{{
                                        row.paid ? "Pagado" : "Pendiente"
                                    }}</span
                                >
                                <span
                                    class="badge text-white bg-danger"
                                    v-if="
                                        row.state_type_description !=
                                            'Registrado'
                                    "
                                    >Anulado</span
                                >
                                <span
                                    class="badge text-white bg-success"
                                    v-if="row.total == 0"
                                    >Pagado</span
                                >
                            </td>

                            <td class="text-center">
                                <!-- <button
                                    type="button"
                                    style="min-width: 41px"
                                    class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                    @click.prevent="clickPayment(row.id)"
                                    v-if="row.btn_payments"
                                >
                                    Pagos
                                </button> -->

                                <template v-if="row.is_credit">
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Registrar Pagos"
                                        placement="bottom-end"
                                    >
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-primary"
                                            v-if="row.state_type_id != '11'"
                                            @click.prevent="
                                                clickPayment(row.id)
                                            "
                                        >
                                            <i
                                                class="fas fa-money-bill-alt"
                                            ></i>
                                        </button>
                                    </el-tooltip>

                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Imprimir Contrato"
                                        placement="bottom-end"
                                    >
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-success"
                                            @click.prevent="
                                                clickContract(row.id)
                                            "
                                        >
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Imprimir Cronograma de Pagos"
                                        placement="bottom-end"
                                    >
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-success"
                                            @click.prevent="
                                                clickSchedule(row.id)
                                            "
                                        >
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                    </el-tooltip>
                                </template>
                            </td>

                            <td
                                class="text-end"
                                v-if="columns.paid.visible && row.total > 0"
                            >
                                {{ row.paid ? "Pagado" : "Pendiente" }}
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
        <sale-note-payments
            :showDialog.sync="showDialogPayments"
            :documentId="recordId"
        ></sale-note-payments>

        <sale-notes-options
            :showDialog.sync="showDialogOptions"
            :recordId.sync="saleNotesNewId"
            :configuration.sync="configuration"
            :editSale.sync="editSale"
            :showClose="true"
            :company="company"
        ></sale-notes-options>

        <sale-note-generate
            :showDialog.sync="showDialogGenerate"
            :recordId="recordId"
            :showGenerate="true"
            :showClose="false"
        ></sale-note-generate>
        <sale-note-detail
            :number="currentNumber"
            :saleNoteId="recordId"
            :showDialog.sync="showDialogDetail"
            :boxes="boxes"
        >
        </sale-note-detail>
             <modal-generate-cpe :show.sync="showModalGenerateCPE"></modal-generate-cpe>
    </div>
</template>
<style>
td {
    color: #000;
}
</style>
<script>
import DataTable from "../../components/DataTableSaleNote.vue";
//'../../components/DataTableSaleNote.vue'
import SaleNotePayments from "./partials/payments.vue";
import SaleNotesOptions from "./partials/options.vue";
import SaleNoteGenerate from "./partials/option_documents";
import SaleNoteDetail from "./partials/detail.vue";
import { deletable } from "../../mixins/deletable";
import ModalGenerateCpe from "./ModalGenerateCPE";
export default {
    props: ["soapCompany", "company", "configuration", "user_type"],
    mixins: [deletable],
    components: {
        ModalGenerateCpe,
        DataTable,
        SaleNotePayments,
        SaleNotesOptions,
        SaleNoteGenerate,
        SaleNoteDetail
    },
    data() {
        return {
            showModalGenerateCPE:false,
            resource: "sale-notes",
            showDialogDetail: false,
            showDialogPayments: false,
            showDialogOptions: false,
            showDialogGenerate: false,
            saleNotesNewId: null,
            recordId: null,
            currentNumber: null,
            boxes: [],
            editSale: false,
            showDialogOptions: false,
            columns: {
                total_free: {
                    title: "T.Gratuito",
                    visible: false
                },
                total_exportation: {
                    title: "T.Exportación",
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
                total_taxed: {
                    title: "T.Gravado",
                    visible: false
                },
                total_igv: {
                    title: "T.IGV",
                    visible: false
                },
                paid: {
                    title: "Estado de Pago",
                    visible: false
                },
                type_period: {
                    title: "Tipo Periodo",
                    visible: true
                },
                quantity_period: {
                    title: "Cantidad Periodo",
                    visible: true
                },
                license_plate: {
                    title: "Placa",
                    visible: true
                },
                total_paid: {
                    title: "Pagado",
                    visible: false
                },
                total_pending_paid: {
                    title: "Por pagar",
                    visible: false
                }
            }
        };
    },
    created() {},
    filters: {
        period(name) {
            let res = "";
            switch (name) {
                case "month":
                    res = "Mensual";
                    break;
                case "year":
                    res = "Anual";
                    break;
                default:
                    break;
            }

            return res;
        }
    },
    methods: {
        onOpenModalGenerateCPE(){
   this.showModalGenerateCPE = true;
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
        clickDownload(external_id) {
            window.open(
                `/sale-notes/downloadExternal/${external_id}`,
                "_blank"
            );
        },
        clickOptions(recordId) {
            this.saleNotesNewId = recordId;
            this.showDialogOptions = true;
        },
        clickDetail(record) {
            this.recordId = record.id;
            this.currentNumber = record.full_number;
            this.boxes = record.boxes;
            this.showDialogDetail = true;
        },
        clickGenerate(recordId) {
            this.recordId = recordId;
            this.showDialogGenerate = true;
        },
        clickPayment(recordId) {
            this.recordId = recordId;
            this.showDialogPayments = true;
        },
        clickSchedule(recordId) {
            window.open(`/sale-notes/schedule/${recordId}`, "_blank");
        },
        clickContract(recordId) {
            window.open(`/sale-notes/contract/${recordId}`, "_blank");
        },
        clickCreate(id = "") {
            location.href = `/${this.resource}/create/${id}`;
        },

        changeConcurrency(row) {
            // console.log(row)
            this.$http
                .post(`/${this.resource}/enabled-concurrency`, row)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {});
        },
        clickVoided(id) {
            this.anular(`/${this.resource}/anulate/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        }
    },
    mounted() {
        this.teclasInit();
    }
};
</script>
