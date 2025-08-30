<!-- Modal de CIerre de Caja -->
<template>
    <!-- <div>
        <div class="row"> -->
    <el-dialog
        title="Cierre de Caja - Contador de dinero"
        :visible.sync="showDialogClose"
        @open="dateclosed"
        :before-close="closeDialog"
        v-loading="loading"
        width="900px"
    >
        <!-- Encabezado -->
        <el-row :gutter="10" style="margin-bottom: 1px;">
            <el-col :span="12">
                <div>
                    <label>Fecha:</label>
                    <strong style="font-size: 1.2em; color: #000;">{{
                        date_closed
                    }}</strong>
                </div>
            </el-col>
            <el-col :span="12" class="text-right">
                <div
                    v-if="
                        configuration.view_daily_cash ||
                            configuration.view_daily_cash_pin
                    "
                >
                    <label style="color: darkgreen;"
                        >Total Ventas en Efectivo</label
                    >
                    <div v-if="configuration.view_daily_cash_pin">
                        <h3>
                            {{ returnTextObfuscated(totalSales.toString()) }}
                        </h3>
                    </div>
                    <div v-else>
                        <h2 style="color: darkgreen; font-size: 2em;">
                            <strong>{{ totalSales.toFixed(2) }}</strong>
                        </h2>
                    </div>
                </div>
            </el-col>
        </el-row>

        <!-- Billetes y Monedas -->
        <el-row :gutter="10">
            <el-col :span="12">
                <el-card shadow="hover" style="padding:1px;">
                    <div class="header">
                        <span style="font-size: 1.3em; color: #222;">Billetes</span>
                        <!-- <img src="/billetes.png" width="30" height="20" /> -->
                    </div>
                    <el-row
                        v-for="b in [10, 20, 50, 100, 200]"
                        :key="b"
                        align="middle"
                        style="margin-bottom:10px;"
                    >
                        <!-- <el-col :span="8"
                            ><strong>S/ {{ b }}</strong></el-col
                        ><el-col :span="8"> -->
                        <el-col :span="8">
                            <strong style="font-size: 1.3em; color: #222;">S/ {{ b }}</strong>
                        </el-col>
                        <el-col :span="8">
                            <el-input
                                size="mini"
                                v-model="count[b]"
                                placeholder="0"
                                @input="updateFinalBalance(count[b], b)"
                                style="font-size: 1.3em; color: #222;"
                            />
                        </el-col>
                        <el-col :span="8" class="text-right">
                            <span style="font-size: 1.3em; color: #222;">{{ ((count[b] || 0) * b).toFixed(2) }}</span>
                        </el-col>
                    </el-row>
                    <br />
                    <br />
                    <div class="total-row">
                        <span style="font-size: 1.3em; color: #222;">Total:</span>
                        <span class="float-right"
                            ><strong style="font-size: 1.3em; color: #222;">{{ totalBills.toFixed(2) }}</strong></span
                        >
                    </div>
                </el-card>
            </el-col>
            <el-col :span="12">
                <el-card shadow="hover" style="padding:10px;">
                    <div class="header">
                        <span>Monedas</span>
                        <!-- <img src="/monedas.png" width="30" height="20" /> -->
                    </div>
                    <el-row
                        v-for="m in [0.1, 0.2, 0.5, 1, 2, 5]"
                        :key="m"
                        align="middle"
                        style="margin-bottom:10px;"
                    >
                        <el-col :span="8">
                            <strong style="font-size: 1.3em; color: #222;">S/ {{ m }}</strong>
                        </el-col>
                        <el-col :span="8">
                            <el-input
                                size="mini"
                                v-model="count[m]"
                                placeholder="0"
                                @input="updateFinalBalance(count[m], m, true)"
                                style="font-size: 1.3em; color: #222;"
                            />
                        </el-col>
                        <el-col :span="8" class="text-right">
                            <span style="font-size: 1.3em; color: #222;">{{ ((count[m] || 0) * m).toFixed(2) }}</span>
                        </el-col>
                    </el-row>
                    <div class="total-row">
                        <span style="font-size: 1.3em; color: #222;">Total:</span>
                        <span class="float-right"
                            ><strong style="font-size: 1.3em; color: #222;">{{ totalCoins.toFixed(2) }}</strong></span
                        >
                    </div>
                </el-card>
            </el-col>
        </el-row>
        <br />
        <!-- Resumen y acciones -->
        <el-row :gutter="10" style="margin-top:5px; align-items: center;">
            <el-col :span="8" style="display: flex; align-items: center;">
                <span style="font-size: 1.3em; color: #222; margin-right: 8px;">Conteo:</span>
                <el-input
                    :value="final_balance.toFixed(2)"
                    readonly
                    size="mini"
                    style="flex: 1; font-size: 1.3em; color: #222;"
                    
                ></el-input>
            </el-col>
            <el-col
                :span="8"
                v-if="
                    configuration.view_daily_cash ||
                        configuration.view_daily_cash_pin
                "
                style="display: flex; align-items: center;"
            >
                <span style="font-size: 1.3em; color: #222; margin-right: 8px;">Diferencia:</span>
                <el-input
                    :class="difference < 0 ? 'text-danger-difference' : ''"
                    :value="
                        configuration.view_daily_cash_pin
                            ? returnTextObfuscated(difference)
                            : difference
                    "
                    readonly
                    size="mini"
                    style="flex: 1; font-size: 1.3em; color: #222;"
                ></el-input>
            </el-col>
            <el-col
                :span="8"
                class="text-right"
                style="display: flex; align-items: right; justify-content: center;"
            >
                <el-button
                    class="btn_guardarsmall"
                    size="mini"
                    type="primary"
                    @click="clickCloseCash"
                >
                    <i class="el-icon-s-finance" style="margin-right: 5px;"></i>
                    Cerrar Caja
                </el-button>
            </el-col>
        </el-row>
        <!-- <el-row :gutter="10" style="margin-top:15px;">
                    <el-col :span="16">
                        <el-card shadow="never" style="padding:10px;">
                            <div>
                                
                            </div>
                            <div v-if="configuration.view_daily_cash || configuration.view_daily_cash_pin" style="margin-top:10px;">
                                <label>Diferencia del Conteo de Dinero</label>
                                <el-input
                                    :class="difference < 0 ? 'text-danger-difference' : ''"
                                    :value="configuration.view_daily_cash_pin ? returnTextObfuscated(difference) : difference"
                                    readonly
                                    size="mini"
                                ></el-input>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="8" class="text-right">
                        <el-button size="mini" @click="closeDialog">
                            <i class="el-icon-close" style="margin-right: 5px;"></i>
                            Cancelar
                        </el-button>
                        <el-button size="mini" type="primary" @click="clickCloseCash">
                            <i class="el-icon-s-finance" style="margin-right: 5px;"></i>
                            Cerrar Caja
                        </el-button>
                    </el-col>
                </el-row> -->

        <!-- Serie de Billetes (solo si health_network) -->
        <el-row v-if="configuration.health_network" style="margin-top:15px;">
            <el-col :span="24">
                <el-card shadow="never" style="padding:10px;">
                    <div class="header">
                        <span>Serie de Billetes</span>
                    </div>
                    <el-button
                        type="primary"
                        style="border-radius: 5px; padding: 5px 10px; margin-right: 10px;"
                        icon="el-icon-document"
                        @click="showSeriesBills"
                    >
                        Ingresar
                    </el-button>
                    <el-button
                        style="border-radius: 5px; padding: 5px 10px; background-color: #28a745; color: white;"
                        icon="el-icon-folder-opened"
                        @click.prevent="$refs.file.click()"
                    >
                        Subir Excel
                    </el-button>
                    <input
                        type="file"
                        @change="uploadExcelBillsSeries"
                        style="visibility:hidden;"
                        ref="file"
                        accept=".xlsx,.xls"
                    />
                </el-card>
            </el-col>
        </el-row>
        <br />

        <series-bills-dialog
            :showDialog.sync="showSeriesBillsDialog"
            :seriesBills.sync="seriesBills"
        ></series-bills-dialog>
    </el-dialog>
    <!-- </div>
    </div> -->
</template>

<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    margin-bottom: 10px;
}
.total-row {
    border-top: 1px solid #eee;
    margin-top: 8px;
    padding-top: 5px;
    font-weight: bold;
}
.text-right {
    text-align: right;
}
.float-right {
    float: right;
}
.text-danger-difference .el-input__inner {
    color: red !important;
}
</style>
<script>
//'../../../../components/DataTable.vue'
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
///mixins/deletable'
import SeriesBillsDialog from "./series_bills.vue";
import readXlsxFile from "read-excel-file";
import Swal from "sweetalert2";
export default {
    components: {
        SeriesBillsDialog,
        Swal
    },
    mixins: [deletable],
    props: [
        "showDialogClose",
        "recordId",
        "fromBox",
        "configuration",
        "fromPos"
    ],
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
            totalSales: 0,
            totalCoins: 0,
            totalBills: 0,
            difference: 0,
            seriesBills: {},
            showSeriesBillsDialog: false
        };
    },
    created() {
        if (this.fromPos) {
            this.dateclosed();
        }
    },
    methods: {
        uploadExcelBillsSeries(event) {
            let file = event.target.files[0];
            let localSeries = {
                diez: [],
                veinte: [],
                cincuenta: [],
                cien: [],
                doscientos: []
            };
            readXlsxFile(file).then(rows => {
                rows.forEach(columns => {
                    let serie = this.getSerieBills(columns[0]);
                    console.log("🚀 ~ readXlsxFile ~ columns[0]:", columns[0]);
                    console.log("🚀 ~ readXlsxFile ~ serie:", serie);
                    for (let i = 0; i < columns.length; i++) {
                        if (i != 0 && columns[i] != null) {
                            localSeries[serie].push(columns[i]);
                        }
                    }
                });
                this.seriesBills = localSeries;
                this.$showSAlert("EXITO", "Series cargadas correctamente");
                event.target.value = "";
            });
        },
        getSerieBills(serie) {
            switch (serie) {
                case 10:
                    return "diez";
                case 20:
                    return "veinte";
                case 50:
                    return "cincuenta";
                case 100:
                    return "cien";
                case 200:
                    return "doscientos";
                default:
                    return "";
            }
        },
        showSeriesBills() {
            this.showSeriesBillsDialog = true;
        },
        returnTextObfuscated(text) {
            let textObfuscated = "";
            for (let i = 0; i < text.length; i++) {
                textObfuscated += "*";
            }
            return textObfuscated;
        },
        ocultarBoton() {
            this.$emit("ocultarBoton");
        },
        sumCount() {
            this.totalCoins = 0;
            this.totalBills = 0;
            let sum = 0;
            for (const amount in this.count) {
                if (this.count[amount] > 0) {
                    sum +=
                        (Number(this.count[amount]) || 0) *
                        (Number(amount) || 0);
                    if (Number(amount) > 5) {
                        this.totalBills +=
                            (Number(this.count[amount]) || 0) *
                            (Number(amount) || 0);
                    } else {
                        this.totalCoins +=
                            (Number(this.count[amount]) || 0) *
                            (Number(amount) || 0);
                    }
                } else {
                    delete this.count[amount];
                }
            }

            return sum;
        },
        updateFinalBalance(quantity, value, isCoin = false) {
            this.count[value.toString()] = quantity;
            this.final_balance = _.round(this.sumCount(), 2);
            this.difference = (this.totalSales - this.final_balance).toFixed(2);
        },
        async clickCloseCash() {
            const result = await Swal.fire({
                title: "Cerrar caja",
                text:
                    this.difference == 0
                        ? "¿Está seguro de cerrar la caja?"
                        : "¿Está seguro de cerrar la caja, sin realizar el conteo en efectivo?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonText: "Aceptar",
                reverseButtons: true
            });
            if (result.isConfirmed) {
                await this.createRegister({}, () => {});
            }
        },
        async dateclosed() {
            console.log("dateclosed");
            this.totalCoins = 0;
            this.totalBills = 0;
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/caja/worker/totales_sales?cash_id=${this.recordId}&only_cash=1`
                );
                if (response.status == 200) {
                    const { data } = response;
                    this.totalSales = data.total_sales;
                }
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
            this.difference = (this.totalSales - this.final_balance).toFixed(2);
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
                counter: this.count,
                difference: this.difference,
                bill_series: this.seriesBills
            };
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}/close`,
                    body
                );

                if (response.data.success) {
                    this.$eventHub.$emit("cashStatusChanged", {
                        status: "closed",
                        cashId: null
                    });
                    this.$eventHub.$emit("reloadData");
                    this.open_cash = true;
                    /* this.$toast.success(response.data.message); */
                    this.$showSAlert("ÉXITO", response.data.message);
                    this.ocultarBoton();
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
                this.loading = false;
                done();
            }

            instance.confirmButtonText = "Cerrando caja...";
            // window.open(
            //     `/caja/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,
            //     "_blank"
            // );
            // location.reload();
            // if(this.configuration.hotels){
            //     setTimeout(() => {
            //                window.open(
            //     `/caja/report-product-warehouse`,
            //     "_blank"
            // );
            //     }, 3000);
            // }
            this.closeDialog();
        }
    }
};
</script>
