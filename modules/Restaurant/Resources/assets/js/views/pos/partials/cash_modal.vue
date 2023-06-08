<template>
    <el-dialog
        v-loading="loading"
        :visible="showDetail"
        append-to-body
        @close="close"
        width="30%"
        @open="open"
    >
        <div v-loading="loadingPrint" element-loading-text="Imprimiendo...">
            <div class="d-flex justify-content-end">
                <el-button type="primary" @click="print">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Imprimir
                </el-button>
            </div>
            <table class="table border-bottom">
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="4">
                        CÓDIGO DE APERTURA:
                        {{ cash.reference_number }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">
                        FECHA ACTUAL
                    </td>
                    <td class="text-left h6 ">{{ dateNow }}</td>
                    <td class="text-left lead-font-weight-700 h6">
                        HORA ACTUAL
                    </td>
                    <td class="text-left h6">{{ timeNow }}</td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">
                        APERTURA
                    </td>
                    <td class="text-left h6">
                        {{ formatedOpeningDate(cash.opening) }}
                    </td>
                    <td class="text-left lead-font-weight-700 h6">
                        DINERO INICIAL
                    </td>
                    <td class="text-left h6">
                        {{ formatedMoney(cash.beginning_balance) }}
                    </td>
                </tr>
            </table>

            <table class="table border-bottom">
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="4">
                        VENTAS REALIZADAS
                    </td>
                </tr>
                <tr
                    v-show="data.sum > 0"
                    v-for="(data, idx) in form.sales_detail"
                    :key="idx"
                >
                    <td
                        class="text-left lead-font-weight-700 h6 text-uppercase"
                    >
                        {{ data.desc }}
                    </td>
                    <td class="text-right h6">
                        {{ formatedMoney(data.sum) }}
                    </td>
                    <td class="text-left"></td>
                    <td class="text-left h6">({{ data.quantity }} pagos)</td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">TOTAL</td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <td class="text-left h6">
                        {{ formatedMoney(form.sales_amount) }}
                    </td>
                </tr>
            </table>

            <table class="table border-bottom" v-if="form.items_detail">
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="3">
                        ARTICULOS VENDIDOS
                    </td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">ARTICULOS</td>
                    <td class="text-left"></td>
                    <td class="text-left h6">
                        {{ form.items_detail.uniques }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">UNIDADES</td>
                    <td class="text-left"></td>
                    <td class="text-left h6">{{ form.items_detail.unds }}</td>
                </tr>
            </table>

            <table
                class="table border-bottom"
                v-if="form.incomes_expenses_cash"
            >
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="3">
                        ENTRADAS / SALIDAS DE EFECTIVO
                    </td>
                </tr>
                <tr>
                    <td class="text-left h6">
                        {{ form.incomes_expenses_cash.incomes.quantity }}
                    </td>
                    <td class="text-left lead-font-weight-700 h6">ENTRADAS</td>
                    <td class="text-right h6">
                        {{
                            formatedMoney(
                                form.incomes_expenses_cash.incomes.amount
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left h6">
                        {{ form.incomes_expenses_cash.expenses.quantity }}
                    </td>
                    <td class="text-left lead-font-weight-700 h6">SALIDAS</td>
                    <td class="text-right h6">
                        {{
                            formatedMoney(
                                form.incomes_expenses_cash.expenses.amount
                            )
                        }}
                    </td>
                </tr>
            </table>

            <table
                class="table border-bottom"
                v-if="form.incomes_expenses_cash"
            >
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="3">
                        TOTAL CAJA
                    </td>
                </tr>
                <tr>
                    <td class="text-left lead-font-weight-700 h6">
                        TOTAL CAJA
                    </td>
                    <td class="text-right h6">
                        {{
                            formatedMoney(
                                Number(
                                    form.incomes_expenses_cash.incomes.amount
                                ) +
                                    Number(form.sales_amount) -
                                    Number(
                                        form.incomes_expenses_cash.expenses
                                            .amount
                                    )
                            )
                        }}
                    </td>
                </tr>
            </table>

            <table class="table border-bottom" v-if="form.documents">
                <tr>
                    <td class="text-left lead-font-weight-700 h5" colspan="2">
                        LISTADO DE DOCUMENTOS
                    </td>
                </tr>
                <tr v-for="(value, key) in form.documents" :key="key">
                    <td
                        class="text-left text-uppercase lead-font-weight-700 h6"
                    >
                        {{ key }}
                    </td>
                    <td class="text-right h6">
                        {{ formatedMoney(value.total) }}
                    </td>
                </tr>
            </table>

            <table class="table border-bottom" v-if="counter.length != 0">
                <tr class="lead-font-weight-700 h5">
                    CONTEO DE EFECTIVO
                </tr>
                <tr v-for="(coin, idx) in counter" :key="idx">
                    <td class="text-left lead-font-weight-700 h6">
                        {{ formatedMoney(coin.value) }}
                    </td>
                    <td class="text-left h6">
                        {{ coin.total }}
                    </td>
                    <td class="text-right h6">
                        {{ formatedMoney(coin.value * coin.total) }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left lead-font-weight-700 h6">Total</td>
                    <td class="text-right h6">
                        {{ formatedMoney(totalCoins) }}
                    </td>
                </tr>
            </table>

            <table class="table table border-bottom">
                <tr>
                    <td></td>
                    <td class="text-left lead-font-weight-700 h6">EFECTIVO</td>
                    <td class="text-right h6">
                        {{ formatedMoney(totalCoins) }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left lead-font-weight-700 h6">VIRTUAL</td>
                    <td class="text-right h6">
                        {{ formatedMoney(virtualAmount) }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left lead-font-weight-700 h6">TOTAL</td>
                    <td class="text-right h6">
                        {{ formatedMoney(virtualAmount + totalCoins) }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="m-4"></div>
    </el-dialog>
</template>

<style scoped>
.txt_bold {
    font-weight: bolder !important;
}
</style>
<script>
import moment from "moment";
export default {
    props: ["cash", "showDetail", "area_id"],
    data() {
        return {
            url: "",
            loading: false,
            loadingPrint: false,
            form: {},
            moneyFormat: Intl.NumberFormat("es-PE", {
                style: "currency",
                currency: "PEN",
                minimumFractionDigits: 2
            }),
            itemsUnique: 0,
            itemsUnds: 0,
            counter: [],
            totalCoins: 0,
            virtualAmount: 0,
            dateNow: moment().format("D/M/Y"),
            timeNow: moment().format("H:m")
        };
    },

    created() {
        let { origin } = window.location;
        this.url = origin;
        this.open();
    },
    methods: {
        init() {
            this.url = "";
            this.form = {};
            this.itemsUnique = 0;
            this.itemsUnds = 0;
            this.counter = [];
            this.totalCoins = 0;
            this.virtualAmount = 0;
        },
        async print() {
            try {
                this.loadingPrint = true;
                const response = await this.$http(
                    `cash/get_printer/${this.area_id}`
                );

                let {
                    data: { printer }
                } = response;
                let config = qz.configs.create(printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }

                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data:
                            this.url +
                            `/restaurant/worker/cash/print-report?cash_id=${this.cash.id}`
                    }
                ];
                await qz.print(config, data);
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loadingPrint = false;
            }
        },
        formatedMoney(amount) {
            return this.moneyFormat.format(amount);
        },
        formatedCounter() {
            let coins = [...this.cash.counter];
            coins.sort((a, b) => a.value - b.value);
            this.counter = coins.map(c => ({
                value: Number(c.value).toFixed(2),
                total: Number(c.total).toFixed(2)
            }));
            this.totalCoins = this.counter.reduce((a, b) => {
                return a + Number(b.total) * Number(b.value);
            }, 0);
        },
        formatedOpeningDate(openingDate) {
            let [date, time] = openingDate.split(" ");
            date = date
                .split("-")
                .reverse()
                .join("/");

            return date + " " + time;
        },
        async open() {
            this.init();
            this.formatedCounter();
            try {
                this.loading = true;
                const response = await this.$http(
                    `../boxes/records/${this.cash.id}`
                );
                const { data } = response;
                this.form = data;
                let { sales_detail } = data;

                Object.keys(sales_detail).forEach((k, idx) => {
                    if (k != "cash") {
                        this.virtualAmount += Number(sales_detail[k].sum);
                    }
                });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        close() {
            this.$emit("update:showDetail", false);
        },
        getTotalSales() {}
    }
};
</script>
