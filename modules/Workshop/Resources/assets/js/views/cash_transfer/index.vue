<!-- Modulo Listado de productos -->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Traslados de dinero</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Traslados</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de traslados de dinero</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end"
                    @click="getCashAvailable"
                    >
                        <span :class="`alert p-2 ${cashAvailable > 0 ? 'alert-info' : 'alert-danger'}`">
                                Dinero disponible S/ {{ cashAvailable.toFixed(2) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-cash"></i> Listado de traslados de
                        dinero
                    </h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-end">
                        <!-- Contact Button Start -->
                        <button
                            type="button"
                            style="margin-right: 5px;"
                            class="btn btn-outline-primary btn-icon btn-icon-start btn-sm"
                            @click.prevent="clickCreate()"
                        >
                            <i data-cs-icon="plus"></i>
                            <span>Nuevo</span>
                        </button>
                    </div>
                    <data-table
                        :typeUser="typeUser"
                        :resource="resource"
                        :config="config"
                        @clickDownload="clickDownload"
                        class="table-striped"
                    >
                        <tr slot="heading" width="100%" class="bg-primary">
                            <!-- <th class="text-white">Acciones</th> -->
                            <th class="text-white">#</th>
                            <th class="text-white">Fecha</th>
                            <th class="text-white">Caja destino</th>
                            <th class="text-white">Monto</th>
                            <th class="text-white">Observación</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <!-- <td class="text-start">
                                <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser == 'superadmin'
                                    "
                                >
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
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a
                                            type="button"
                                            class="dropdown-item text-danger"
                                            @click.prevent="clickDelete(row.id)"
                                        >
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </div>
                                </template>
                            </td> -->

                            <td>{{ index }}</td>
                            <td class="text-left">{{ row.date_of_issue }}</td>
                            <td class="text-left">
                                {{ row.cash_destination }}
                                <br />
                                <small class="text-muted">
                                    {{ row.user_destination }}
                                </small>
                            </td>
                            <td class="text-left">{{ row.amount }}</td>
                            <td class="text-left">{{ row.observation }}</td>
                        </tr>
                    </data-table>
                </div>

                <form-cash-transfer
                    :cashAvailable="cashAvailable"
                    :showDialog.sync="showDialog"
                    :recordId="recordId"
                    @updateCash="getCashAvailable"
                ></form-cash-transfer>
            </div>
        </div>
    </div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>

<script>
import FormCashTransfer from "./form.vue";
import DataTable from "@components/DataTable.vue";
import { deletable } from "@mixins/deletable";
import queryString from "query-string";
export default {
    props: ["typeUser", "user", "configuration"],
    mixins: [deletable],
    components: {
        DataTable,
        FormCashTransfer
    },
    data() {
        return {
            currentItem: null,
            showDialog: false,
            showImportDialog: false,
            showImportListPriceDialog: false,
            showWarehousesDetail: false,
            resource: "caja/cash-transfer",
            recordId: null,
            warehousesDetail: [],
            unit_type: [],
            hasSerie: false,
            itemId: null,
            config: {},
            cashAvailable: 0
        };
    },
    created() {
        this.$http.get(`/configurations/record`).then(response => {
            this.config = response.data.data;
        });

        this.getCashAvailable();
        
    },
    methods: {
        getCashAvailable() {
            this.$http.get(`/caja/cash-transfer/available`).then(response => {
                this.cashAvailable = response.data;
            });
        },
        clickCreate(recordId = null) {
            if(this.cashAvailable <= 0) {
                return this.$toast.error("No hay dinero disponible para realizar un traslado.");
            }
            this.recordId = recordId;
            this.showDialog = true;
        },

        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDisable(id) {
            this.disable(`/${this.resource}/disable/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickEnable(id) {
            this.enable(`/${this.resource}/enable/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDownload(query){
            window.open(`/${this.resource}/export?${queryString.stringify(query)}`);
        },
        clickBarcode(row) {
            if (!row.internal_id) {
                return this.$toast.error(
                    "Para generar el código de barras debe registrar el código interno."
                );
            }

            window.open(`/${this.resource}/barcode/${row.id}`);
        },
        clickPrintBarcode(row) {
            if (!row.barcode) {
                return this.$toast.error(
                    "Para generar el código de barras debe registrar el código de barras."
                );
            }

            window.open(`/${this.resource}/export/barcode/print?id=${row.id}`);
        }
    }
};
</script>
