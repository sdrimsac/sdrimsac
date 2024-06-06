<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Reporte</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Cartera presupuestaria</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Reporte - Cartera presupuestaria</span
                                >
                            </li>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h4 class="my-0 text-white">
                        <i class="fas fa-cash"></i> Cartera presupuestaria
                    </h4>
                </div>
                <div class="card-body">
                    <data-table
                        :typeUser="typeUser"
                        :resource="resource"
                        :config="config"
                        class="table-striped"
                        ref="datatable"
                        @clickReport="clickDownload"
                    >
                        <tr slot="heading" width="100%" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Fecha</th>
                            <th class="text-white">Responsable</th>
                            <th class="text-white">Tipo de transacción</th>
                            <th class="text-white">Ingreso</th>
                            <th class="text-white">Egreso</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            
                            <td>{{ index }}</td>
                            <td class="text-left">{{ row.date_of_issue }}</td>
                            <td class="text-left">
                                {{ row.user_name }}
                            
                            </td>
                            <td class="text-left">{{ row.type }}</td>
                            <td class="text-end text-success">{{ row.income }}</td>
                            <td class="text-end text-danger">{{ row.expense }}</td>
                        </tr>
                        <tr slot="footer" v-if="$refs.datatable">
                            <td colspan="4" class="text-right">Total</td>
                            <td class="text-end">{{ $refs.datatable.total_income() }}</td>
                            <td class="text-end">{{ $refs.datatable.total_expense() }}</td>
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
            total_income: 0,
            total_expense: 0,
            currentItem: null,
            showDialog: false,
            showImportDialog: false,
            showImportListPriceDialog: false,
            showWarehousesDetail: false,
            resource: "caja/cash-transfer/report",
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
        clickDownload(query){
            window.open(`/caja/cash-transfer/report/export?${queryString.stringify(query)}`);
        },
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
