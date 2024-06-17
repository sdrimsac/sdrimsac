<template>
<el-dialog v-loading="loading" :visible="showDetail" append-to-body @close="close" width="30%" @open="open" title="Detalle de caja">
    <div v-loading="loadingPrint" element-loading-text="Imprimiendo...">
        <br>
        <div class="d-flex justify-content-end">
            <el-button type="primary" @click="print">
                <i class="fa fa-print" aria-hidden="true"></i>
                Imprimir A
            </el-button>
        </div>
        <div class="d-flex justify-content-end">
            <el-checkbox @click="print">
                imprimir todo
            </el-checkbox>
        </div>
        <div class="text-center">
            <h5>RESUMEN DE VENTA DIARIA</h5>
        </div>
        <table class="table border-bottom">
            <tr>
                <td class="text-left lead-font-weight-700 h5" colspan="4" style="border: solid 1px black;">
                    CÓDIGO DE APERTURA:
                    {{ cash.reference_number }}
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    FECHA ACTUAL
                </td>
                <td class="text-left h6 " style="border: solid 1px black;">{{ dateNow }}</td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    HORA ACTUAL
                </td>
                <td class="text-left h6" style="border: solid 1px black;">{{ timeNow }}</td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    APERTURA
                </td>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ formatedOpeningDate(cash.opening) }}
                </td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    CIERRE
                </td>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ formatedOpeningDate(cash.closed) }}
                </td>
                <!-- <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                        DINERO INICIAL
                    </td>
                    <td class="text-left h6" style="border: solid 1px black;">
                        {{ formatedMoney(cash.beginning_balance) }}
                    </td> -->
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    DINERO INICIAL
                </td>
                <td class="text-left h6" style="border: solid 1px black;">
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
            <tr v-show="data.sum > 0" v-for="(data, idx) in form.sales_detail" :key="idx">
                <td class="text-left lead-font-weight-700 h6 text-uppercase" style="border: solid 1px black;">
                    {{ data.desc }}
                </td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(data.sum) }}
                </td>
                <td class="text-left"></td>
                <td class="text-left h6" style="border: solid 1px black;">({{ data.quantity }} pagos)</td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">TOTAL</td>
                <td class="text-left"></td>
                <td class="text-left"></td>
                <td class="text-left h6" style="border: solid 1px black;">
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
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">ARTICULOS</td>
                <td class="text-left"></td>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ form.items_detail.uniques }}
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">UNIDADES</td>
                <td class="text-left"></td>
                <td class="text-left h6" style="border: solid 1px black;">{{ form.items_detail.unds }}</td>
            </tr>
        </table>
        <table class="table border-bottom" v-if="categories.length > 0">
            <tr>
                <td class="text-left lead-font-weight-700 h5" colspan="2">
                    TOTAL POR CATEGORIA
                </td>
            </tr>
            <tr v-for="(cat,idx) in categories" :key="idx">
                <td class="text-left text-uppercase lead-font-weight-700 h6" style="border: solid 1px black;">{{ cat.category }}</td>
                <td class="text-end" style="border: solid 1px black;">
                    S/ {{ cat.total }}

                </td>
            </tr>
            <tr>
                <td class="lead-font-weight-700" style="border: solid 1px black;">TOTAL</td>
                <td class="text-end" style="border: solid 1px black;">S/ {{totalCategory.toFixed(2)}}</td>
            </tr>
        </table>

        <table class="table border-bottom" v-if="form.incomes_expenses_cash">
            <tr>
                <td class="text-left lead-font-weight-700 h5" colspan="3">
                    ENTRADAS / SALIDAS DE EFECTIVO
                </td>
            </tr>
            <tr>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ form.incomes_expenses_cash.incomes.quantity }}
                </td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">ENTRADAS</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{
                                    formatedMoney(
                                        form.incomes_expenses_cash.incomes.amount
                                    )
                                }}
                </td>
            </tr>
            <tr>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ form.incomes_expenses_cash.expenses.quantity }}
                </td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">SALIDAS</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{
                                    formatedMoney(
                                        form.incomes_expenses_cash.expenses.amount
                                    )
                                }}
                </td>
            </tr>
        </table>

        <table class="table border-bottom" v-if="form.incomes_expenses_cash">
            <tr>
                <td class="text-left lead-font-weight-700 h5" colspan="3" style="border: solid 1px black;">
                    TOTAL CAJA
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    TOTAL CAJA
                </td>
                <td class="text-right h6" style="border: solid 1px black;">
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
                <td class="text-left text-uppercase lead-font-weight-700 h6" style="border: solid 1px black;">
                    {{ key }}
                </td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(value.total) }}
                </td>
            </tr>
        </table>

        <table class="table border-bottom" v-if="counter.length != 0">
            <tr class="lead-font-weight-700 h5" style="border: solid 1px black;">
                CONTEO DE EFECTIVO
            </tr>
            <tr v-for="(coin, idx) in counter" :key="idx">
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    {{ formatedMoney(coin.value) }}
                </td>
                <td class="text-left h6" style="border: solid 1px black;">
                    {{ coin.total }}
                </td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(coin.value * coin.total) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">Total</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(totalCoins) }}
                </td>
            </tr>
        </table>

        <table class="table table border-bottom" style="border-bottom-style: ridge;">
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">
                    SALDO INICIAL
                </td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(cash.beginning_balance) }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">EFECTIVO</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(cashAmount) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">VIRTUAL</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(virtualAmount) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">BANCOS</td>
                <td class="text-right h6" style="border: solid 1px black;">
                    {{ formatedMoney(bankAmount) }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">GASTOS</td>
                <td v-if="form.incomes_expenses_cash" class="text-right h6" style="border: solid 1px black;">
                    {{
                                    formatedMoney(
                                        form.incomes_expenses_cash.expenses.amount
                                    )
                                }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td class="text-left lead-font-weight-700 h6" style="border: solid 1px black;">TOTAL</td>
                <td v-if="form.incomes_expenses_cash" class="text-right h6" style="border: solid 1px black;">
                    {{
                                    formatedMoney(
                                        Number(virtualAmount) +
                                            Number(bankAmount) +
                                            Number(cashAmount) +
                                            Number(cash.beginning_balance) -
                                            Number(
                                                form.incomes_expenses_cash.expenses
                                                    .amount
                                            )
                                    )
                                }}
                </td>
            </tr>
        </table>

        <div class="text-center">
            <h4>DETALLE DE PRODUCTOS VENDIDOS</h4>
        </div>
        <table class="table table border-bottom" style="border-bottom-style: ridge;" v-if="all_items.length != 0">
            <tr>
                <td class="" style="border: solid 1px black;">UNIDAD</td>
                <td class="text-center" style="border: solid 1px black;">DESCRIPCION</td>
                <td class="text-center" style="border: solid 1px black;">PRECIO</td>
                <td class="text-end" style="border: solid 1px black;">TOTAL</td>
            </tr>
            <tr v-for="(cat,idx) in all_items" :key="idx">
                <td style="border: solid 1px black; width: 20%;">{{ cat.quantity }}</td>
                <td class="text-center" style="border: solid 1px black; width: 40%;">{{ cat.description }}</td>
                <td style="border: solid 1px black; width: 20%;" class="text-end">{{ formatedMoney(cat.price) }}</td>
                <td style="border: solid 1px black; width: 20%;" class="text-end">{{ formatedMoney(cat.total) }}</td>
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
            all_items: [],
            categories: [],
            totalCategory: 0,
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
            bankAmount: 0,
            dateNow: moment().format("D/M/Y"),
            timeNow: moment().format("H:m")
        };
    },

    created() {
        let {
            origin
        } = window.location;
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
            this.categories = [],
                this.all_items = [];
            this.totalCoins = 0;
            this.virtualAmount = 0;
            this.bankAmount = 0;
            this.cashAmount = 0;
        },
        async print() {
            try {
                this.loadingPrint = true;
                const response = await this.$http(
                    `cash/get_printer/${this.area_id}`
                );

                let {
                    data: {
                        printer
                    }
                } = response;
                let config = qz.configs.create(printer, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let isPosd = printer.split(" ")[printer.split(" ").length - 1];
                if (isPosd == "POSD") {
                    config.density = 200;
                }
                let data = [{
                    type: "pdf",
                    format: "file",
                    data: this.url +
                        `/caja/worker/cash/print-report?cash_id=${this.cash.id}`
                }];
                await qz.print(config, data);
            } catch (e) {
                this.$toast.error(e.message);
            } finally {
                this.loadingPrint = false;
            }
        },
        formatedMoney(amount) {
            amount = Number(amount);
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
            this.all_items = [];
            this.categories = [];
            this.init();
            this.formatedCounter();
            try {
                this.loading = true;
                const response = await this.$http(
                    `../boxes/records/${this.cash.id}`
                );
                const {
                    data
                } = response;
                this.form = data;
                let {
                    categories,
                    all_items
                } = data;

                Object.keys(categories).forEach((catName, idx) => {
                    this.totalCategory += Number(categories[catName]);
                    this.categories.push({
                        category: catName,
                        total: categories[catName]
                    });
                });
                Object.keys(all_items).forEach((catName, idx) => {
                    this.all_items.push(all_items[catName]);
                });

                /* console.log(this.categories) */
                console.log('Categories:', this.categories);
                console.log('Total Category:', this.totalCategory);
                console.log('all_items;', this.all_items);
                let {
                    sales_detail
                } = data;

                Object.keys(sales_detail).forEach((k, idx) => {
                    if (k != "cash" && !sales_detail[k].is_bank) {
                        this.virtualAmount += Number(sales_detail[k].sum);
                    }
                    if (sales_detail[k].is_bank) {
                        this.bankAmount += Number(sales_detail[k].sum);
                    }
                    if (k == "cash") {
                        this.cashAmount = Number(sales_detail[k].sum);
                    }
                });
            } catch (e) {
                this.$toast.error(`Error loading data: ${e.message}`);
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
