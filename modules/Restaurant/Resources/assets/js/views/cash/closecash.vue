<template>
    <div>
        <div class="row">
            <el-dialog
                title="Cierra de Caja - Contador de dinero"
                :visible.sync="showDialogClose"
                @open="dateclosed"
                :before-close="closeDialog"
            >
                <div class="row">
                    <div class="col-md-6">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.date_closed
                            }"
                        >
                            <label class="control-label disabled w-100"
                                >Fecha
                            </label>
                            <h3>
                                {{ date_closed }}
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="form-group"
                            v-if="
                                configuration.view_daily_cash ||
                                    configuration.view_daily_cash_pin
                            "
                        >
                            <label class="control-label disabled w-100"
                                >Total V. Efectivo</label
                            >
                            <template v-if="configuration.view_daily_cash_pin">
                                <h3>
                                    {{ returnTextObfuscated("123456") }}
                                </h3>
                            </template>
                            <template v-else>
                                <h3>{{ totalSales.toFixed(2) }}</h3>
                            </template>
                            <!-- <el-input :value="totalSales"> </el-input> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table-responsive table">
                            <thead>
                                <tr>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        <img
                                            width="75px"
                                            height="50px"
                                            src="/billetes.png"
                                            alt="billete"
                                        />
                                    </th>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        UND
                                    </th>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        TOTAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <h3>10.00</h3>
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
                                                    (count["10"] || 0) * 10
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>20.00</h3>
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
                                                    (count["20"] || 0) * 20
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>50.00</h3>
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
                                                    (count["50"] || 0) * 50
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>100.00</h3>
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
                                                    (count["100"] || 0) * 100
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>200.00</h3>
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
                                                    (count["200"] || 0) * 200
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center">
                                        <h3>TOTAL</h3>
                                    </td>
                                    <td></td>
                                    <td class="text-center">
                                        <h6>{{ totalBills.toFixed(2) }}</h6>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table-responsive table">
                            <thead>
                                <tr>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        <img
                                            width="75px"
                                            height="50px"
                                            src="/monedas.png"
                                            alt="monedas"
                                        />
                                    </th>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        UND
                                    </th>
                                    <th
                                        style="vertical-align:bottom;text-align:center;"
                                    >
                                        TOTAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <h3>0.10</h3>
                                    </td>
                                    <td>
                                        <el-input
                                            placeholder="0"
                                            v-model="count['0.1']"
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                (
                                                    (count["0.1"] || 0) * 0.1
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>0.20</h3>
                                    </td>
                                    <td>
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                (
                                                    (count["0.2"] || 0) * 0.2
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>0.50</h3>
                                    </td>
                                    <td>
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                (
                                                    (count["0.5"] || 0) * 0.5
                                                ).toFixed(2)
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>1.00</h3>
                                    </td>
                                    <td>
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                ((count["1"] || 0) * 1).toFixed(
                                                    2
                                                )
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>2.00</h3>
                                    </td>
                                    <td>
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                ((count["2"] || 0) * 2).toFixed(
                                                    2
                                                )
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <h3>5.00</h3>
                                    </td>
                                    <td>
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
                                    <td class="text-center">
                                        <h6>
                                            {{
                                                ((count["5"] || 0) * 5).toFixed(
                                                    2
                                                )
                                            }}
                                        </h6>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center">
                                        <h3>TOTAL</h3>
                                    </td>
                                    <td></td>
                                    <td class="text-center">
                                        <h6>{{ totalCoins.toFixed(2) }}</h6>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="w-100">
                            Total Efectivo
                        </label>
                        <el-input :value="final_balance.toFixed(2)" readonly>
                        </el-input>
                    </div>
                    <div
                        v-if="
                            configuration.view_daily_cash ||
                                configuration.view_daily_cash_pin
                        "
                        class="col-md-4"
                    >
                        <label class="w-100">
                            Diferencia
                        </label>
                        <template v-if="configuration.view_daily_cash_pin">
                            <el-input
                                :value="returnTextObfuscated('123456')"
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
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="closeDialog()">Cerrar</el-button>
                    <el-button type="primary" @click="clickCloseCash"
                        >Guardar</el-button
                    >
                </span>
            </el-dialog>
        </div>
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

export default {
    mixins: [deletable],
    props: ["showDialogClose", "recordId", "fromBox", "configuration"],
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
            difference: 0
        };
    },

    methods: {
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
                difference: this.difference
            };
            try {
                this.loading = true;
                const response = await this.$http.post(
                    `/${this.resource}/close`,
                    body
                );

                if (response.data.success) {
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
            window.open(
                `/caja/report-boxes/reports_resumen_type?cash_id=${this.recordId}`,
                "_blank"
            );
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
