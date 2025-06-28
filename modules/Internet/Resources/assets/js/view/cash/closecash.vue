<template>
    <div>
        <div class="row">
            <el-dialog
                title="Contador de dinero"
                :visible.sync="showDialogClose"
                @open="dateclosed"
                :before-close="closeDialog"
                v-loading="loading"
                width="40%"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            >
                <!-- Encabezado de la caja -->
                <div class="">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.date_closed
                                    }"
                                >
                                    <label class="control-label disabled w-100 d-flex justify-content-end"
                                        >Fecha:
                                        <strong
                                            style="font-size: 1.2em; color: #000000; margin-left: 8px;"
                                            >{{ date_closed }}</strong
                                        >
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="card-body">
                                <div
                                    class="row"
                                    v-if="configuration && (configuration.view_daily_cash || configuration.view_daily_cash_pin)"
                                >
                                    <div class="col-md-12">
                                        <template v-if="configuration.view_daily_cash_pin">
                                            <label class="control-label disabled w-100" style="color: darkgreen;">Total Ventas en Efectivo</label>
                                            <h3 style="text-align: right;">
                                                {{ returnTextObfuscated(totalSales ? totalSales.toString() : '0.00') }}
                                            </h3>
                                        </template>
                                        <template v-else>
                                            <label class="control-label disabled w-100" style="color: darkgreen;">Total Ventas en Efectivo</label>
                                            <h2 style="text-align: right; color: darkgreen; font-size: 2em;">
                                                <strong>{{ totalSales ? totalSales.toFixed(2) : '0.00' }}</strong>
                                            </h2>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                
                <!-- Cuerpo del conteo de dinero -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <!-- Encabezado de Billetes -->
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #073f68; color: white; padding: 5px;">
                                <h6 class="card-title mb-0" style="color: white; font-size: 1.2em;">Billetes</h6>
                                <el-button type="text" style="border-radius: 5px; padding: 0; width: 50px; height: 35px;">
                                    <img width="50px" height="35px" src="/billetes.png" alt="billete" style="border-radius: 5px;" />
                                </el-button>
                            </div>
                            <div class="card-body" style="padding: 8px;">
                                <table class="table-responsive table">
                                    <thead style="background-color: #1e5a85; color: white;">
                                        <tr>
                                            <th style="vertical-align:bottom;text-align:center; width: 20%; color: white;"></th>
                                            <th style="vertical-align:bottom;text-align:center; width: 40%; color: white;">Cantidad</th>
                                            <th style="vertical-align:bottom;text-align:center; width: 40%; color: white;">S/</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="bill in [10, 20, 50, 100, 200]" :key="bill">
                                            <td class="text-center" style="padding: 8px 4px;"><h3>{{ bill }}</h3></td>
                                            <td style="padding: 8px 4px;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count[bill.toString()]"
                                                    @input="updateFinalBalance(count[bill.toString()], bill)"
                                                ></el-input>
                                            </td>
                                            <td class="text-center" style="padding: 8px 4px;">
                                                <h6>{{ ((count[bill.toString()] || 0) * bill).toFixed(2) }}</h6>
                                            </td>
                                        </tr>
                                        <!-- Espacio visual -->
                                        <tr>
                                            <td class="text-center" style="padding: 8px 4px;"><h3 style="visibility: hidden;">200</h3></td>
                                            <td style="padding: 8px 4px;"><el-input placeholder="0" style="visibility: hidden;"></el-input></td>
                                            <td class="text-center" style="padding: 8px 4px;"><h6 style="visibility: hidden;">0.00</h6></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" colspan="2" style="padding: 8px 4px;"><h6><strong>Total Billetes </strong></h6></td>
                                            <td class="text-center" style="padding: 8px 4px;"><h5>{{ totalBills.toFixed(2) }}</h5></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Monedas -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #073f68; color: white; padding: 5px;">
                                <h6 class="card-title mb-0" style="color: white; font-size:1.2em;">Monedas</h6>
                                <el-button type="text" style="border-radius: 5px; padding: 0; width: 50px; height: 35px;">
                                    <img width="50px" height="35px" src="/monedas.png" alt="monedas" style="border-radius: 5px;" />
                                </el-button>
                            </div>
                            <div class="card-body" style="padding: 8px;">
                                <table class="table-responsive table">
                                    <thead style="background-color: #1e5a85; color: white;">
                                        <tr>
                                           <th style="vertical-align:bottom;text-align:center; width: 20%; color: white;"></th>
                                            <th style="vertical-align:bottom;text-align:center; width: 40%; color: white;">Cantidad</th>
                                            <th style="vertical-align:bottom;text-align:center; width: 40%; color: white;">S/</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="coin in ['0.1','0.2','0.5','1','2','5']" :key="coin">
                                            <td class="text-center" style="width: 5ch;"><h3>{{ parseFloat(coin).toFixed(2) }}</h3></td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count[coin]"
                                                    @input="updateFinalBalance(count[coin], parseFloat(coin))"
                                                ></el-input>
                                            </td>
                                            <td class="text-center" style="width: 10ch;">
                                                <h6>{{ ((count[coin] || 0) * parseFloat(coin)).toFixed(2) }}</h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center" colspan="2"><h6><strong>Total Monedas</strong></h6></td>
                                            <td class="text-center"><h5>{{ totalCoins.toFixed(2) }}</h5></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Resumen de dinero -->
                    <div class="col-md-6">
                        <div class="">
                            <div class="card-body">
                                <div class="col-md-12 text-center">
                                    <div class="col-md-12">
                                        <label class="w-100">Total Efectivo Contado</label>
                                        <el-input :value="final_balance.toFixed(2)" readonly></el-input>
                                    </div>
                                    <div v-if="configuration && (configuration.view_daily_cash || configuration.view_daily_cash_pin)" class="col-md-12">
                                        <label class="w-100">Diferencia del Conteo de Dinero</label>
                                        <template v-if="configuration.view_daily_cash_pin">
                                            <el-input :value="returnTextObfuscated('123456')" readonly></el-input>
                                        </template>
                                        <template v-else>
                                            <el-input :class="difference < 0 ? 'text-danger-difference' : ''" :value="difference" readonly></el-input>
                                        </template>
                                    </div>
                                    <br />
                                    <!-- Opcional: Serie de Billetes y Subir Excel -->
                                    <tfoot>
                                        <tr v-if="configuration && configuration.health_network">
                                            <div class="card">
                                                <div class="card-header" style="background-color: #073f68; color: white;">
                                                    <h6 class="card-title mb-0" style="color: white; font-weight: bold;">Serie de Billetes</h6>
                                                </div>
                                                <div class="card-body">
                                                    <td colspan="4">
                                                        <el-button type="primary" style="border-radius: 5px; padding: 10px 20px; margin-right: 5px; font-size: 1em;" icon="el-icon-document" @click="showSeriesBills">Ingresar</el-button>
                                                        <el-button style="border-radius: 5px; padding: 10px 20px; background-color: #28a745; color: white; font-size: 1em;" icon="el-icon-folder-opened" @click.prevent="$refs.file && $refs.file.click()">Subir Excel</el-button>
                                                        <input type="file" @change="uploadExcelBillsSeries" style="visibility:hidden;" ref="file" accept=".xlsx,.xls" />
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tfoot>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 20px;">
                        <div class="">
                            <div class="card-body">
                                <div class="d-flex justify-content-end" style="flex-wrap: wrap; gap: 10px;">
                                    <el-button @click="closeDialog()" class="btn_cancelarsmall " style="font-size: 0.9em; min-width: fit-content;">
                                        <i class="el-icon-close" style="margin-right: 5px;"></i>
                                        Cancelar
                                    </el-button>
                                    <el-button type="primary" @click="clickCloseCash" class="btn_guardarsmall" style="font-size: 0.9em; min-width: fit-content;">
                                        <i class="el-icon-s-finance" style="margin-right: 5px;"></i>
                                        Cerrar Caja
                                    </el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
        </div>
        <!-- Si tienes un dialogo para series de billetes -->
    </div>
</template>

<style>
.text-danger-difference {
    color: #e74c3c;
    font-weight: bold;
}
</style>
<script>
//'../../../../components/DataTable.vue'
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
///mixins/deletable'
import CashForm from "./form.vue";

export default {
    mixins: [deletable],
    props: ["showDialogClose", "recordId", "fromBox"],
    data() {
        return {
            total: 0,
            count: {},
            showDialog: false,
            open_cash: true,
            errors: {},
            resource: "caja/worker/cash",
            date_closed: moment().format("YYYY-MM-DD"),
            date_start: moment().format("YYYY-MM-DD"),
            month_start: moment().format("YYYY-MM"),
            final_balance: 0,
            cash: null,
            loading: false,
            configuration: {}, // Asegúrate de cargar la configuración real
            totalSales: 0, // Debes asignar el valor real
            seriesBills: [] // Si usas series de billetes
        };
    },
    computed: {
        totalBills() {
            // Suma total de billetes
            return [10, 20, 50, 100, 200].reduce((sum, bill) => sum + (Number(this.count[bill]) || 0) * bill, 0);
        },
        totalCoins() {
            // Suma total de monedas
            return ['0.1','0.2','0.5','1','2','5'].reduce((sum, coin) => sum + (Number(this.count[coin]) || 0) * parseFloat(coin), 0);
        },
        difference() {
            // Diferencia entre total contado y ventas (ajusta según tu lógica)
            return (this.final_balance - (this.totalSales || 0)).toFixed(2);
        }
    },
    methods: {
        ocultarBoton() {
            this.$emit("ocultarBoton");
        },
        sumCount() {
            let sum = 0;
            for (const amount in this.count) {
                if (this.count[amount] > 0) {
                    sum +=
                        (Number(this.count[amount]) || 0) *
                        (Number(amount) || 0);
                } else {
                    delete this.count[amount];
                }
            }
            return sum;
        },
        updateFinalBalance(quantity, value) {
            this.count[value.toString()] = quantity;

            this.final_balance = _.round(this.sumCount(), 2);
        },
        clickCloseCash() {
            const h = this.$createElement;
            this.$msgbox({
                title: "Cerrar caja",
                type: "warning",
                message: h("p", null, [
                    h(
                        "p",
                        { style: "text-align: justify; font-size:15px" },
                        "¿Está seguro de cerrar la caja?"
                    )
                ]),

                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                beforeClose: (action, instance, done) => {
                    if (action === "confirm") {
                        //  console.log(this.count);
                        this.createRegister(instance, done);
                    } else {
                        done();
                    }
                }
            })
                .then(action => {})
                .catch(action => {});
        },
        async dateclosed(date_closed) {
            this.loading = true;
            await this.$http
                .get(`/caja/cash/balance-final/${this.date_closed}`)
                .then(response => {
                    //  this.final_balance = response.data.balance_total.toFixed(2);
                    this.loading = false;
                });
        },
        closeDialog() {
            this.$emit("update:showDialogClose", false);
            this.count = {};
            this.final_balance = 0;
        },
        async createRegister(instance, done) {
            const body = {
                id: this.recordId,
                final_balance: this.final_balance,
                counter: this.count
            };
            try {
                const response = await this.$http.post(
                    `/${this.resource}/close`,
                    body
                );
              

                if (response.data.success) {
                    this.$eventHub.$emit("reloadData");
                    this.open_cash = true;
                    this.$toast.success(response.data.message);
                    this.ocultarBoton();
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);

                    if (this.fromBox) {
                        this.$emit("updateCashId", null);
                    }
                } else {
                    console.log(response);
                }
            } catch (error) {
                console.log(error);
            } finally {
                instance.confirmButtonLoading = false;
                instance.confirmButtonText = "Iniciar prueba";
                done();
            }

            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "Cerrando caja...";
            window.open(
                `/caja/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,
                "_blank"
            );
            this.closeDialog();
        },
        returnTextObfuscated(text) {
            // Devuelve texto ofuscado (ajusta según tu lógica)
            return '******';
        },
        showSeriesBills() {
            this.showSeriesBillsDialog = true;
        },
        uploadExcelBillsSeries(e) {
            // Lógica para subir excel (ajusta según tu lógica)
        }
    }
};
</script>
