<!-- Modulo de Notas de Venta -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary" style="padding: 10px;">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-file-alt"></i>
                        Consulta de Nota de venta
                    </h4>
                </div>
                <div class="data-table-visible-columns d-flex align-items-center mb-2">
                    <el-button class="btn_guardarsmall me-2" type="primary" href="javascript:void(0)"
                        @click.prevent="clickCreate()">

                        <i class="fas fa-plus"></i>
                        Nuevo
                    </el-button>
                    <el-button @click.prevent="onOpenModalGenerateCPE" v-if="just_sale_notes" class="btn_guardarsmall"
                        type="primary">
                        <i class="fas fa-file-check"></i>
                        Generar CPE de Multiples NV
                    </el-button>
                </div>

                <!-- <div class="col-12 text-end">
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
        </div>-->
                <div class="card-body">
                    <data-table :resource="resource">
                        <tr slot="heading" class="bg-primary">
                            <th style="width: 40px;">#</th>
                            <!-- <th class="text-white text-end">Acciones</th>
                            <th class="text-white text-end">Actividad</th> -->
                            <th class="text-white text-center" style="width: 200px;">
                                Actividad
                            </th>
                            <!-- <th class="text-center text-white" style="width: 100px;">Usuario</th> -->
                            <th class="text-left text-white" style="min-width: 230px; text-align: left;">Cliente</th>
                            <th class="text-center text-white" style="width: 150px;">N.V.</th>
                            <!-- <th class="text-center text-white" style="width: 80px;">G.R.</th> -->
                           
                            <!-- <th class="text-center text-white" style="width: 50px;">Moneda</th> -->
                            <th class="text-white text-end" v-if="columns.total_exportation.visible"
                                style="width: 110px;">
                                T.Exportación
                            </th>
                            <th class="text-white text-end" v-if="columns.total_free.visible" style="width: 110px;">
                                T.Gratuito
                            </th>
                            <th class="text-white text-end" v-if="columns.total_unaffected.visible"
                                style="width: 110px;">
                                T.Inafecta
                            </th>
                            <th class="text-white ext-end" v-if="columns.total_exonerated.visible"
                                style="width: 110px;">
                                T.Exonerado
                            </th>
                            <th class="text-white text-end" v-if="columns.total_taxed.visible" style="width: 110px;">
                                T.Gravado
                            </th>
                            <th class="text-white text-end" v-if="columns.total_igv.visible" style="width: 90px;">
                                T.Igv
                            </th>
                            <th class="text-white text-center" style="width: 50px;" v-if="configuration.credits">
                                Adelanto</th>
                            <th class="text-white text-center" style="width: 130px;">
                                Metodo de pago
                            </th>
                            <th class="text-white text-center" style="width: 150px;">Pagado</th>
                            <!-- <th class="text-white text-center" style="width: 90px;">Resta</th>
                            <th class="text-white text-end" style="width: 100px;">Total</th> -->
                            <th class="text-white text-end" style="width: 70px;" v-if="configuration.credits">Tasa</th>
                            <th class="text-white text-center" style="width: 100px;">CPE</th>
                             <th class="text-center text-white" style="width: 200px;">Motivo</th>
                            <th class="text-white text-center" style="width: 100px;">Estado pago</th>
                            <th class="text-white text-center" style="width: 140px;">
                                Acciones
                            </th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <!-- <td class="text-end">
                                
                            </td> -->
                            <!-- <td v-if="row.state_type_id == '11'">
                                
                            </td>
                            <td>
                                <template v-if="
                                    row.last_register &&
                                    row.last_register.user
                                " class="text-center">
                                    <span class="text-center fw-bold" style="font-family: Arial, sans-serif;">{{
                                        row.last_register.user }}</span>
                                    :
                                    <br />
                                    <span class="text-primary" style="font-family: Arial, sans-serif;">{{
                                        row.last_register.description
                                        }}</span>
                                    <br />
                                    <span style="font-family: Arial, sans-serif;">
                                        {{
                                            formatDateTime(
                                                row.last_register.date_time
                                            )
                                        }}
                                        {{ row.last_register.created_at }}
                                    </span>
                                </template>
</td> -->

                            <td class="text-left">
                                {{ row.user_name }} <br>
                                <span style="font-weight: bold; color: #15344a;">
                                    Fecha: {{ row.date_of_issue }}
                                </span>
                                <template>
                                    <br />
                                    <small style="font-weight: bold; color: #e67e22;">
                                        Hora: {{ row.time_of_issue }}
                                    </small>
                                </template>
                            </td>
                            <!-- <td></td> -->
                            <td>
                                {{ row.customer_name }}
                                <br />
                                <small v-text="row.customer_number"></small>
                            </td>

                            <td class="text-center">{{ row.full_number }}</td>
                            <!-- <td>
                                <span v-for="(dispatch, idx) in row.dispatches" :key="idx">
                                    {{ dispatch.number_full }}
                                    
                                </span>
                            </td> -->
                            <!-- <td>{{ row.state_type_description }}</td> -->
                            
                            <!-- <td class="text-center">
                                {{ row.currency_type_id }}
                            </td> -->
                            <td class="text-end" v-if="columns.total_exportation.visible">
                                {{ row.total_exportation }}
                            </td>
                            <td class="text-end" v-if="columns.total_free.visible">
                                {{ row.total_free }}
                            </td>
                            <td class="text-end" v-if="columns.total_unaffected.visible">
                                {{ row.total_unaffected }}
                            </td>
                            <td class="text-end" v-if="columns.total_exonerated.visible">
                                {{ row.total_exonerated }}
                            </td>
                            <td class="text-end" v-if="columns.total_taxed.visible">
                                {{ row.total_taxed }}
                            </td>
                            <td class="text-end" v-if="columns.total_igv.visible">
                                {{ row.total_igv }}
                            </td>

                            <td class="text-center" v-if="columns.total_paid.visible">
                                {{ row.total_paid }}
                            </td>
                            <td v-if="configuration.credits">{{ Number(row.advances).toFixed(2) }}</td>
                            <!-- <td>
                                {{ row.advances }}
              </td>-->
                            <!-- <template v-if="row.total_pending_paid > 0">
                                <td
                                    class="text-center text-danger font-weight-bold"
                                >
                                    {{ row.total_pending_paid }}
                                </td>
                            </template>
                            <template v-else>
                                <td class="text-end"></td>
              </template>-->
                            <td>
                                <div class="justify-content-center d-flex flex-column">
                                    <el-tag style="margin-top:5px;" v-for="(data, idx) in row.boxes
                                        .slice(-3)
                                        .reverse()" :key="idx" type="primary">
                                        <b>
                                            {{ data.method }} S/{{
                                                data.amount
                                            }}
                                        </b>
                                    </el-tag>
                                </div>
                            </td>
                            <!-- <template v-if="row.total_payment != null || row.total_payment != 0">
                                <td class="text-end">
                                    {{ row.total }}
                                </td>
                              </template>-->
                            <td class="text-end">
                                Pagado: S/ {{ row.paid_amount.toFixed(2) }}
                                Pendiente: S/ {{ row.pending.toFixed(2) }}
                                <br>
                                <span style="display:block; border-bottom:1px solid #222; margin:6px 0;"></span>
                                Total: S/ {{ Number(row.total).toFixed(2) }}
                            </td>
                            <!-- <td class="text-end">
                               
                            </td>
                            <template>
                                <td class="text-end">
                                   
                                </td>
                            </template> -->
                            <td class="text-end" v-if="configuration.credits">
                                {{
                                    row.tax_rate > 0 ? `${row.tax_rate}%` : "-"
                                }}
                            </td>
                            <td>
                                <template v-for="(document, i) in row.documents">
                                    <label :key="i" v-text="document.number_full" class="d-block"></label>
                                </template>
                            </td>
                            <td>  {{ row.observation }} </td>
                            <td class="text-center">
                                <span class="badge text-white" :class="{
                                    'bg-success': row.paid,
                                    'bg-warning': !row.paid
                                }" v-if="
                                    row.state_type_description !=
                                    'Anulado' && row.total > 0
                                ">
                                    {{ row.paid ? "Pagado" : "Pendiente" }}
                                </span>
                                <span class="badge text-white bg-danger" v-if="
                                    row.state_type_description == 'Anulado'
                                ">
                                    Anulado

                                </span>
                                <span class="badge text-white bg-success" v-if="row.total == 0">Pagado</span>
                                <br>
                                
                            </td>
                            <!-- Acciones -->
                            <td class="text-center">
                                <template v-if="row.state_type_id != 11">
                                    <div class="btn-toolbar mb-2" role="toolbar">
                                        <div class="btn-group mb-1">
                                            <button class="btn_guardarsmall dropdown-toggle" type="primary"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                                Acciones
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-sm">
                                                <button v-if="
                                                    row.state_type_id !=
                                                    '11' &&
                                                    (user_type ==
                                                        'admin' ||
                                                        user_type ==
                                                        'superadmin')
                                                " class="dropdown-item" type="button" @click.prevent="
                                                    clickDetail(row)
                                                    ">
                                                    <i class="fas fa-trash"></i>
                                                    Ver detalle
                                                </button>
                                                <button v-if="
                                                    row.state_type_id !=
                                                    '11' &&
                                                    !row.is_credit &&
                                                    !row.paid
                                                " class="dropdown-item" type="button" @click.prevent="
                                                    clickPayment(row.id)
                                                    ">
                                                    <i class="fas fa-money-bill-alt"></i>
                                                    Registrar Pago
                                                </button>
                                                <a :href="`/dispatches/create_new/sale_note/${row.id}`
                                                    " v-if="
                                                        row.state_type_id !=
                                                        '11' &&
                                                        (user_type ==
                                                            'admin' ||
                                                            user_type ==
                                                            'superadmin')
                                                    " class="dropdown-item">
                                                    <i class="far fa-file-alt"></i>
                                                    Generar GR
                                                </a>

                                                <button v-if="
                                                    row.state_type_id !=
                                                    '11' &&
                                                    (user_type ==
                                                        'admin' ||
                                                        user_type ==
                                                        'superadmin')
                                                " class="dropdown-item btn-danger" type="button" @click.prevent="
                                                    clickVoided(row.id)
                                                    ">
                                                    <i class="fas fa-trash"></i>
                                                    Anular
                                                </button>

                                                <button class="dropdown-item" type="button" @click.prevent="
                                                    clickCreate(row.id)
                                                    " v-if="
                                                        row.btn_generate &&
                                                        row.state_type_id !=
                                                        '11' &&
                                                        (user_type ==
                                                            'admin' ||
                                                            user_type ==
                                                            'superadmin')
                                                    ">
                                                    <i class="fas fa-file-signature"></i>
                                                    Editar
                                                </button>

                                                <button class="dropdown-item" type="button" @click.prevent="
                                                    clickGenerate(row.id)
                                                    " v-if="
                                                        !row.changed &&
                                                        row.state_type_id !=
                                                        '11' &&
                                                        soapCompany !=
                                                        '03' &&
                                                        (user_type ==
                                                            'admin' ||
                                                            user_type ==
                                                            'superadmin')
                                                    ">
                                                    <i class="fas fa-file-excel"></i>
                                                    Generar CPE
                                                </button>
                                                <button v-if="
                                                    row.state_type_id !=
                                                    '11'
                                                " class="dropdown-item" type="button" @click.prevent="
                                                    clickOptions(row.id)
                                                    ">
                                                    <i class="fas fa-print"></i>
                                                    Imprimir
                                                </button>

                                                <div class="d-flex flex-row justify-content-center"
                                                    v-if="row.is_credit">
                                                    <el-tooltip class="item" effect="dark" content="Registrar Pagos"
                                                        placement="bottom-end">
                                                        <button type="button"
                                                            class="btn btn-primary btn-circle btn-xs me-1"
                                                            v-if="row.state_type_id != '11'"
                                                            @click.prevent="clickPayment(row.id)"
                                                            style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                                                            <i class="fas fa-money-bill-alt"></i>
                                                        </button>
                                                    </el-tooltip>
                                                    <el-tooltip class="item" effect="dark" content="Imprimir Contrato"
                                                        placement="bottom-end">
                                                        <button type="button"
                                                            class="btn btn-success btn-circle btn-xs me-1"
                                                            @click.prevent="clickContract(row.id)"
                                                            style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                                                            <i class="fas fa-file-alt"></i>
                                                        </button>
                                                    </el-tooltip>
                                                    <el-tooltip class="item" effect="dark"
                                                        content="Imprimir Cronograma de Pagos" placement="bottom-end">
                                                        <button type="button" class="btn btn-success btn-circle btn-xs"
                                                            @click.prevent="clickSchedule(row.id)"
                                                            style="width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center;">
                                                            <i class="fas fa-file-alt"></i>
                                                        </button>
                                                    </el-tooltip>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <el-button @click.prevent="clickOptions(row.id)">
                                        <i class="fas fa-print"></i>
                                    </el-button>
                                </template>
                                <!-- <button
                                        type="button"
                                        style="min-width: 41px"
                                        class="btn waves-effect waves-light btn-sm btn-info m-1__2"
                                        @click.prevent="clickPayment(row.id)"
                                        v-if="row.btn_payments"
                                    >
                                    Pagos
                                 </button>-->

                                <!-- <template v-if="row.is_credit">
                                    <el-tooltip class="item" effect="dark" content="Registrar Pagos"
                                        placement="bottom-end">
                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-primary"
                                            v-if="row.state_type_id != '11'" @click.prevent="
                                                clickPayment(row.id)
                                                ">
                                            <i class="fas fa-money-bill-alt"></i>
                                        </button>
                                    </el-tooltip>

                                    <el-tooltip class="item" effect="dark" content="Imprimir Contrato"
                                        placement="bottom-end">
                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-success"
                                            @click.prevent="
                                                clickContract(row.id)
                                                ">
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                    </el-tooltip>
                                    <el-tooltip class="item" effect="dark" content="Imprimir Cronograma de Pagos"
                                        placement="bottom-end">
                                        <button type="button" class="btn waves-effect waves-light btn-sm btn-success"
                                            @click.prevent="
                                                clickSchedule(row.id)
                                                ">
                                            <i class="fas fa-file-alt"></i>
                                        </button>
                                    </el-tooltip>
                                </template> -->
                            </td>

                            <td class="text-end" v-if="columns.paid.visible && row.total > 0">
                                {{ row.paid ? "Pagado" : "Pendiente" }}
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
        <sale-note-payments :showDialog.sync="showDialogPayments" :configuration.sync="configuration"
            :documentId="recordId"></sale-note-payments>

        <sale-notes-options :showDialog.sync="showDialogOptions" :recordId.sync="saleNotesNewId"
            :configuration.sync="configuration" :editSale.sync="editSale" :showClose="true"
            :company="company"></sale-notes-options>

        <sale-note-generate :showDialog.sync="showDialogGenerate" :recordId="recordId" :showGenerate="true"
            :configuration.sync="configuration" :showClose="false"></sale-note-generate>
        <sale-note-detail :number="currentNumber" :saleNoteId="recordId" :showDialog.sync="showDialogDetail"
            :configuration.sync="configuration" :boxes="boxes"></sale-note-detail>
        <modal-generate-cpe :show.sync="showModalGenerateCPE"></modal-generate-cpe>
    </div>
</template>
<style scoped>
/* Encabezado de la tabla */
.data-table thead th,
table thead th {
    background-color: #15344a !important;
    color: #fff !important;
    font-weight: bold;
    text-align: center;
}

/* Filas alternas (zebra striping) */
.data-table tbody tr:nth-child(even),
table tbody tr:nth-child(even) {
    background-color: #fff;
}

.data-table tbody tr:nth-child(odd),
table tbody tr:nth-child(odd) {
    background-color: #e3ded3;
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
import swal from "sweetalert2";
export default {
    props: [
        "just_sale_notes",
        "soapCompany",
        "company",
        "configuration",
        "user_type"
    ],
    mixins: [deletable],
    components: {
        ModalGenerateCpe,
        DataTable,
        SaleNotePayments,
        SaleNotesOptions,
        SaleNoteGenerate,
        SaleNoteDetail,
        swal
    },
    data() {
        return {
            cashId: null,
            showModalGenerateCPE: false,
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
    created() { },
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
    mounted() {
        this.$getCashId().then(() => {
            this.cashId = this.$cashId;
        });
    },
    methods: {
        onOpenModalGenerateCPE() {
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
        /* clickCreate(id = "") {
      
      location.href = `/${this.resource}/create/${id}`;
    }, */

        async clickCreate(id = "") {
            if (this.$cashId) {
                location.href = `/${this.resource}/create/${id}`;
            } else {
                swal.fire({
                    title: "Caja cerrda",
                    text:
                        "No puedes realizar esa accion debido a que tu caja esta cerrado",
                    icon: "error",
                    timer: 2000
                }).then(() => {
                    location.href = "/report_closed_cash";
                });
            }
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
                .then(() => { });
        },
        clickVoided(id) {
            swal.fire({
                title: "Motivo de Anulación",
                input: "text",
                inputPlaceholder: "Escribe el motivo de la anulación",
                showCancelButton: true,
                confirmButtonText: "Anular",
                cancelButtonText: "Cancelar",
                inputValidator: value => {
                    if (!value) {
                        return "El motivo es obligatorio";
                    }
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const motivo = result.value;
                    this.$http
                        .get(`/${this.resource}/anulate/${id}`, {
                            params: { motivo }
                        })
                        .then(() => {
                            this.$eventHub.$emit("reloadData");
                            this.$toast.success(
                                "Nota de venta anulada correctamente"
                            );
                        })
                        .catch(error => {
                            this.$toast.error(
                                "Ocurrió un error al anular la nota de venta"
                            );
                            console.error(error);
                        });
                }
            });
        }
    },
    mounted() {
        this.teclasInit();
    }
};
</script>
