<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Cajas</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">Apertura de Caja</span>
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <el-tooltip v-if="otroNombre" class="item" effect="dark" content="Aperturar caja" placement="bottom-end"
                        > 
                        <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start btn-sm" @click.prevent="clickCreate()"
                            > <i class="fas fa-dollar-sign"></i> <span>Nuevo</span>
                            </button>
                        </el-tooltip>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de cajas</h6>
                </div>
                <div class="card-body">
                    <data-table :resource="resource" :fromAdmin="fromAdmin">
                        <tr slot="heading">
                            <th>#</th>
                            <th># Referencia</th>
                            <th>Vendedor</th>
                            <th class="text-center">Apertura</th>
                            <th class="text-center">Cierre</th>
                            <th>Saldo inicial</th>
                            <th>Saldo final</th>
                            <!-- <th>Ingreso</th> -->
                            <!-- <th>Egreso</th> -->
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr slot-scope="{ index, row }">
                            <td>{{ index }}</td>
                            <td>{{ row.reference_number }}</td>
                            <td>{{ row.user }}</td>
                            <td class="text-center">{{ row.opening }}</td>
                            <td class="text-center">{{ row.closed }}</td>
                            <td>{{ row.beginning_balance }}</td>
                            <td>{{ row.final_balance }}</td>
                            <!-- <td>{{ row.income }}</td>
                        <td>{{ row.expense }}</td> -->
                            <td>{{ row.state_description }}</td>
                            <td class="text-center">
                                <template v-if="row.state">
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-warning"
                                        @click.prevent="clickCloseCash(row.id)"
                                    >
                                        Cerrar caja
                                    </button>
                                    <button
                                        v-if="
                                            typeUser === 'admin' ||
                                                typeUser === 'superadmin'
                                        "
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        v-if="
                                            typeUser === 'admin' ||
                                                typeUser === 'superadmin'
                                        "
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        Eliminar
                                    </button>
                                </template>
                                <template>
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-success"
                                        @click.prevent="printreport(row)"
                                        v-if="row.state == false"
                                    >
                                        <i class="fa fa-print"></i> Imprimir
                                        Reporte
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>
            </div>
        </div>
        <cash-form
            :showDialog.sync="showDialog"
            :typeUser="typeUser"
            :recordId="recordId"
            @ocultarBoton="ocultarBoton"
        ></cash-form>
        <CloseCash
            :recordId.sync="recordId"
            :showDialogClose.sync="showDialogClose"
            @ocultarBoton="ocultarBoton"
        >
        </CloseCash>
    </div>
</template>

<script>
//import DataTable from "../../../../../../../resources/js/components/DataTable.vue";
//import CloseCash from "./closecash.vue";
//'../../../../components/DataTable.vue'
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
///mixins/deletable'
//import CashForm from "./form.vue";

const  DataTable = () => ('../../../../../../../resources/js/components/DataTable.vue');
const  CloseCash = () => ('./closecash.vue');
const  CashForm = () => ('./form.vue');

export default {
    mixins: [deletable],
    components: { DataTable, CashForm, CloseCash },
    props: ["typeUser", "fromAdmin", "cajaopen"],
    data() {
        return {
            showDialog: false,
            showDialogClose: false,
            open_cash: true,
            resource: "caja/worker/cash",
            recordId: null,
            data_closed: moment().format("YYYY-MM-DD"),
            date_start: moment().format("YYYY-MM-DD"),
            month_start: moment().format("YYYY-MM"),

            cash: null,
            otroNombre: false
        };
    },
    async created() {
        this.otroNombre = this.cajaopen;
        //console.log(this.otroNombre);
        /*await this.$http.get(`/${this.resource}/opening_cash`)
                .then(response => {
                    this.cash = response.data.cash
                    this.open_cash = (this.cash) ? false : true
                })*/
        /*this.$eventHub.$on('openCash', () => {
                this.open_cash = false
            })*/
    },
    methods: {
        ocultarBoton() {
            this.otroNombre = !this.otroNombre;
        },

        clickDownload(id) {
            window.open(`/${this.resource}/report/${id}`, "_blank");
        },
        clickDownloadIncomeSummary(id) {
            window.open(
                `/${this.resource}/report/income-summary/${id}`,
                "_blank"
            );
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },
        clickCloseCash(recordId) {
            this.recordId = recordId;
            this.showDialogClose = true;
        },
        printreport(row) {
            window.open(
                `/caja/report-boxes/reports_resumen_type?date_end=${row.date_closed}&date_start=${row.date_closed}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf&cash_id=${row.id}`,
                "_blank"
            );
        },
        createRegister(instance, done) {
            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "Cerrando caja...";
            //this.$http.get(`/${this.resource}/close/${this.recordId}`)
            window.open(
                `/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`,
                "_blank"
            );
            this.showDialogClose = false;
            // .then(response => {
            //     if(response.data.success){
            this.$eventHub.$emit("reloadData");
            //         this.open_cash = true
            //         this.$toast.success(response.data.message)
            //          window.open(`/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`, '_blank')
            //         //window.open(`/${this.resource}/${type}/?${query}`, '_blank')
            //     }else{
            //         console.log(response)
            //     }
            // })
            // .catch(error => {
            //     console.log(error)
            // })
            // .then(() => {
            instance.confirmButtonLoading = false;
            //       instance.confirmButtonText = 'Iniciar prueba'
            //     done()
            // })
        },
        clickOpenPos() {
            window.open("/pos");
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDownloadGeneral() {
            window.open(`/${this.resource}/report`, "_blank");
        },
        clickDownloadProducts(id) {
            window.open(`/${this.resource}/report/products/${id}`, "_blank");
        }
    }
};
</script>
