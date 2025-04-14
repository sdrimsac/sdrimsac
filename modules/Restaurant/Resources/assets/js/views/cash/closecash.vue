<!-- Modal de CIerre de Caja -->
<template>
    <div>
        <div class="row">
            <el-dialog
                title="Cierra de Caja - Contador de dinero"
                :visible.sync="showDialogClose"
                @open="dateclosed"
                :before-close="closeDialog"
                v-loading="loading"
                width="60%"
            >
                <!-- Encabezado de la caja -->
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.date_closed
                                    }"
                                >
                                    <label class="control-label disabled w-100"
                                        >Fecha:
                                        <strong
                                            style="font-size: 1.2em; color: #000000;"
                                            >{{ date_closed }}</strong
                                        >
                                    </label>
                                    <!-- <h3>{{ date_closed }}</h3> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div
                                    class="row"
                                    v-if="
                                        configuration.view_daily_cash ||
                                            configuration.view_daily_cash_pin
                                    "
                                >
                                    <!-- <div class="col-md-7">
                                        <label
                                            class="control-label disabled w-100"
                                            style="color: darkgreen;"
                                            >Total Ventas en Efectivo</label
                                        >
                                    </div> -->
                                    <div class="col-md-12">
                                        <template
                                            v-if="
                                                configuration.view_daily_cash_pin
                                            "
                                        >
                                            <label
                                                class="control-label disabled w-100"
                                                style="color: darkgreen;"
                                                >Total Ventas en Efectivo</label
                                            >
                                            <h3 style="text-align: right;">
                                                {{
                                                    returnTextObfuscated(
                                                        totalSales.toString()
                                                    )
                                                }}
                                            </h3>
                                        </template>
                                        <template v-else>
                                            <label
                                                class="control-label disabled w-100"
                                                style="color: darkgreen;"
                                                >Total Ventas en Efectivo</label
                                            >
                                            <h2
                                                style="text-align: right; color: darkgreen; font-size: 2em;"
                                            >
                                                <strong>{{
                                                    totalSales.toFixed(2)
                                                }}</strong>
                                            </h2>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <!-- Cuerpor del conteo de dinero -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <!-- Encabezado de Billetes -->
                            <div
                                class="card-header d-flex justify-content-between align-items-center"
                                style="background-color: #073f68; color: white; padding: 5px;"
                            >
                                <h6
                                    class="card-title mb-0"
                                    style="color: white; font-size: 1.2em;"
                                >
                                    Billetes
                                </h6>
                                <el-button
                                    type="text"
                                    style="
                                    border-radius: 5px;
                                    padding: 0;
                                    width: 50px;
                                    height: 35px;
                                "
                                >
                                    <img
                                        width="50px"
                                        height="35px"
                                        src="/billetes.png"
                                        alt="billete"
                                        style="border-radius: 5px;"
                                    />
                                </el-button>
                            </div>
                            <div class="card-body">
                                <table class="table-responsive table">
                                    <thead>
                                        <tr>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 5ch;"
                                            ></th>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 6ch;"
                                            >
                                                Cantidad
                                            </th>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 10ch;"
                                            >
                                                S/
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <h3>10</h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['10']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['10'],
                                                            10
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{
                                                        (
                                                            (count["10"] || 0) *
                                                            10
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <h3>20</h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['20']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['20'],
                                                            20
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{
                                                        (
                                                            (count["20"] || 0) *
                                                            20
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <h3>50</h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['50']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['50'],
                                                            50
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{
                                                        (
                                                            (count["50"] || 0) *
                                                            50
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <h3>100</h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['100']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['100'],
                                                            100
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{
                                                        (
                                                            (count["100"] ||
                                                                0) * 100
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <h3>200</h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['200']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['200'],
                                                            200
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6>
                                                    {{
                                                        (
                                                            (count["200"] ||
                                                                0) * 200
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <!-- Solo un espacio hacia abajo -->
                                        <tr>
                                            <td class="text-center">
                                                <h3 style="visibility: hidden;">
                                                    200
                                                </h3>
                                            </td>
                                            <td>
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['200']"
                                                    style="visibility: hidden;"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['200'],
                                                            200
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td class="text-center">
                                                <h6 style="visibility: hidden;">
                                                    {{
                                                        (
                                                            (count["200"] ||
                                                                0) * 200
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <h6><strong>Total</strong></h6>
                                            </td>
                                            <td></td>
                                            <td class="text-center">
                                                <h6>
                                                    {{ totalBills.toFixed(2) }}
                                                </h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr v-if="configuration.health_network">
                                            <td colspan="3">
                                                <el-button
                                                    type="primary"
                                                    style="border-radius: 5px; padding: 5px 10px; margin-right: 10px;"
                                                    icon="el-icon-document"
                                                    @click="showSeriesBills"
                                                >
                                                    Ingresar Series
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
                                            </td>
                                        </tr>

                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Encabezado de Monedas -->
                    <div class="col-md-6">
                        <div class="card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center"
                                style="background-color: #073f68; color: white; padding: 5px;"
                            >
                                <h6
                                    class="card-title mb-0"
                                    style="color: white; font-size:1.2em;"
                                >
                                    Monedas
                                </h6>
                                <el-button
                                    type="text"
                                    style="
                                    border-radius: 5px;
                                    padding: 0;
                                    width: 50px;
                                    height: 35px;
                                "
                                >
                                    <img
                                        width="50px"
                                        height="35px"
                                        src="/monedas.png"
                                        alt="monedas"
                                        style="border-radius: 5px;"
                                    />
                                </el-button>
                            </div>
                            <div class="card-body">
                                <table class="table-responsive table">
                                    <thead>
                                        <tr>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 5ch;"
                                            ></th>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 6ch;"
                                            >
                                                Cantidad
                                            </th>
                                            <th
                                                style="vertical-align:bottom;text-align:center; width: 10ch;"
                                            >
                                                S/
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>0.10</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['0.1']"
                                                    maxlength="6"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['0.1'],
                                                            0.1,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["0.1"] ||
                                                                0) * 0.1
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>0.20</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['0.2']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['0.2'],
                                                            0.2,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["0.2"] ||
                                                                0) * 0.2
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>0.50</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['0.5']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['0.5'],
                                                            0.5,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["0.5"] ||
                                                                0) * 0.5
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>1.00</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['1']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['1'],
                                                            1,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["1"] || 0) *
                                                            1
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>2.00</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['2']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['2'],
                                                            2,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["2"] || 0) *
                                                            2
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="text-center"
                                                style="width: 5ch;"
                                            >
                                                <h3>5.00</h3>
                                            </td>
                                            <td style="width: 6ch;">
                                                <el-input
                                                    placeholder="0"
                                                    v-model="count['5']"
                                                    @input="
                                                        updateFinalBalance(
                                                            count['5'],
                                                            5,
                                                            true
                                                        )
                                                    "
                                                >
                                                </el-input>
                                            </td>
                                            <td
                                                class="text-center"
                                                style="width: 10ch;"
                                            >
                                                <h6>
                                                    {{
                                                        (
                                                            (count["5"] || 0) *
                                                            5
                                                        ).toFixed(2)
                                                    }}
                                                </h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-center">
                                                <h6><strong>Total</strong></h6>
                                            </td>
                                            <td></td>
                                            <td class="text-center">
                                                <h6>
                                                    {{ totalCoins.toFixed(2) }}
                                                </h6>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Resumen de dinero -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 text-center">
                                    <div class="col-md-12">
                                        <label class="w-100">
                                            Total Efectivo Contado
                                        </label>
                                        <el-input
                                            :value="final_balance.toFixed(2)"
                                            readonly
                                        >
                                        </el-input>
                                    </div>
                                    <div
                                        v-if="
                                            configuration.view_daily_cash ||
                                                configuration.view_daily_cash_pin
                                        "
                                        class="col-md-12"
                                    >
                                        <label class="w-100">
                                            Diferencia del Conteo de Dinero
                                        </label>
                                        <template
                                            v-if="
                                                configuration.view_daily_cash_pin
                                            "
                                        >
                                            <el-input
                                                :value="
                                                    returnTextObfuscated(
                                                        '123456'
                                                    )
                                                "
                                                readonly
                                            >
                                            </el-input>
                                        </template>
                                        <template v-else>
                                            <el-input
                                                :class="
                                                    `${
                                                        difference < 0
                                                            ? 'text-danger-difference'
                                                            : ''
                                                    }`
                                                "
                                                :value="difference"
                                                readonly
                                            >
                                            </el-input>
                                        </template>
                                    </div>

                                    <br />
                                    <tfoot>
                                        <tr v-if="configuration.health_network">
                                            <div class="card">
                                                <div
                                                    class="card-header"
                                                    style="background-color: #073f68; color: white;"
                                                >
                                                    <h6
                                                        class="card-title mb-0"
                                                        style="color: white; font-weight: bold;"
                                                    >
                                                        Serie de Billetes
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <td colspan="4">
                                                        <el-button
                                                            type="primary"
                                                            style="border-radius: 5px; padding: 10px 20px; margin-right: 5px; font-size: 1em;"
                                                            icon="el-icon-document"
                                                            @click="
                                                                showSeriesBills
                                                            "
                                                        >
                                                            Ingresar
                                                        </el-button>
                                                        <el-button
                                                            style="border-radius: 5px; padding: 10px 20px; background-color: #28a745; color: white; font-size: 1em;"
                                                            icon="el-icon-folder-opened"
                                                            @click.prevent="
                                                                $refs.file.click()
                                                            "
                                                        >
                                                            Subir Excel
                                                        </el-button>
                                                        <input
                                                            type="file"
                                                            @change="
                                                                uploadExcelBillsSeries
                                                            "
                                                            style="visibility:hidden;"
                                                            ref="file"
                                                            accept=".xlsx,.xls"
                                                        />
                                                    </td>
                                                </div>
                                            </div>
                                        </tr>
                                    </tfoot>
                                    <!-- <div class="col-md-12 text-center">
                                        <div class="row"></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end" style="flex-wrap: wrap; gap: 10px;">
                                    <el-button
                                        @click="closeDialog()"
                                        class="btn-cancel"
                                        style="font-size: 0.9em; min-width: fit-content;"
                                    >
                                        <i class="el-icon-close" style="margin-right: 5px;"></i>
                                        Cancelar
                                    </el-button>
                                    <el-button
                                        type="primary"
                                        @click="clickCloseCash"
                                        class="btn-agregar"
                                        style="font-size: 0.9em; min-width: fit-content;"
                                    >
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
        <series-bills-dialog
            :showDialog.sync="showSeriesBillsDialog"
            :seriesBills.sync="seriesBills"
        ></series-bills-dialog>
    </div>
</template>

<style>
.text-danger-difference .el-input__inner {
    color: red !important;
}
/* .el-input__inner {
    padding: 0 25px !important;
} */
</style>
<script>
//'../../../../components/DataTable.vue'
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
///mixins/deletable'
import SeriesBillsDialog from "./series_bills.vue";
import readXlsxFile from "read-excel-file";
export default {
    components: {
        SeriesBillsDialog
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
                this.$toast.success("Series cargadas correctamente");
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
            const h = this.$createElement;
            this.$msgbox({
                title: "Cerrar caja",
                type: "warning",
                message: h("p", null, [
                    h(
                        "p",
                        { style: "text-align: justify; font-size:15px" },
                        `${
                            this.difference == 0
                                ? "¿Está seguro de cerrar la caja?"
                                : "¿Está seguro de cerrar la caja,  sin realizar el conteo en efectivo?"
                        }`
                    )
                ]),

                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                beforeClose: async (action, instance, done) => {
                    if (action === "confirm") {
                        instance.confirmButtonLoading = true;
                        instance.confirmButtonText = "Cerrando...";
                        //  console.log(this.count);
                        await this.createRegister(instance, done);
                        instance.confirmButtonLoading = false;
                    } else {
                        done();
                    }
                }
            })
                .then(action => {})
                .catch(action => {});
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
                    this.$toast.success(response.data.message);
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
