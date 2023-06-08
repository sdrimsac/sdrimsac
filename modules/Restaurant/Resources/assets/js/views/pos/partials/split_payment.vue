<template>
    <el-dialog
        append-to-body
        @open="open"
        @close="close"
        :visible="showSplitPayment"
        :title="`Dividir pago: S/. ${total}`"
        width="70%"
    >
        <div class="d-flex flex-column p-2">
            <div class="d-flex flex-row align-items-end">
                <div>
                    <label for="">Dividir entre:</label><br />
                    <el-input-number
                        v-if="splitByAmount == '1'"
                        :max="10"
                        @input="updatePayments"
                        v-model="number"
                    ></el-input-number>
                    <el-input-number
                        v-else
                        :max="items.length"
                        @input="updatePayments"
                        v-model="numberProduct"
                    ></el-input-number>
                </div>
                <div style="margin-left:10px;">
                    <el-radio-group
                        v-model="splitByAmount"
                        @change="updatePayments"
                    >
                        <el-radio-button label="1">Por cuotas</el-radio-button>
                        <el-radio-button label="2"
                            >Por producto</el-radio-button
                        >
                    </el-radio-group>
                </div>
            </div>

            <div v-if="splitByAmount == '1'" class="d-flex flex-wrap ">
                <div
                    class="col-3"
                    v-for="(payment, idx) in payments"
                    :key="idx"
                >
                    <!--    <div class="form-check m-2">
                  <input
                            class="form-check-input"
                            type="checkbox"
                            v-model="payment.fixed"
                            :id="idx"
                        />
                        <label class="form-check-label" :for="idx">
                            Fijar
                        </label> 
                    </div>-->
                    <div style="margin-top:10px; margin-right:5px;">
                        <h2 class="text-muted text-small">
                            Cuota {{ idx + 1 }}
                        </h2>
                        <!-- <el-input-number
                            :disabled="payment.fixed"
                            :precision="2"
                            :step="0.1"
                            v-model="payment.amount"
                        ></el-input-number> -->
                        <el-input v-model="payment.amount" readonly></el-input>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="d-flex flex-wrap">
                    <div class="col-2" v-for="(item, idx) in items" :key="idx">
                        <div
                            role="button"
                            @click="addItem(item)"
                            class="card p-1"
                            style=" margin-top:10px; margin-right:5px;"
                        >
                            <h2 class="text-muted text-small">
                                {{ item.food.description }}
                            </h2>

                            <h3 class="text-muted text-small">
                                S/. {{ item.price }}
                            </h3>
                            <h3
                                :class="
                                    ` text-small ${
                                        item.quantity == 0
                                            ? 'text-danger'
                                            : 'text-muted'
                                    }`
                                "
                            >
                                Cantidad: {{ item.quantity }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div
                    style="margin-top:15px;"
                    class="d-flex flex-wrap justify-content-center"
                >
                    <div
                        class="col-3 "
                        v-for="(payment, idx) in payments"
                        :key="idx"
                        style="margin:5px;"
                    >
                        <table class="col-12">
                            <thead>
                                <tr
                                    role="button"
                                    @click="selectAccount(idx)"
                                    :class="
                                        `${
                                            payment.selected
                                                ? 'bg-primary text-white border rounded-top'
                                                : 'border rounded-top'
                                        }`
                                    "
                                >
                                    <th class="text-center" colspan="3">
                                        <b> CUENTA {{ idx + 1 }} </b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="border rounded-top "
                                v-if="
                                    payment.products &&
                                        payment.products.length > 0
                                "
                            >
                                <tr
                                    v-for="(product, idx) in payment.products"
                                    :key="idx"
                                >
                                    <td>
                                        <h3 class="text-muted text-small">
                                            {{ product.quantity }}
                                        </h3>
                                    </td>
                                    <td>
                                        <h3 class="text-muted text-small">
                                            {{ product.description }}
                                        </h3>
                                    </td>
                                    <td style="text-align:right">
                                        <h3 class="text-muted text-small">
                                            {{
                                                product.price * product.quantity
                                            }}

                                            <b
                                                class="text-danger"
                                                role="button"
                                                @click="removeItem(product.id)"
                                            >
                                                x
                                            </b>
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        colspan="2"
                                        class="text-muted text-small"
                                        style="text-align:right"
                                    >
                                        <b>
                                            Total
                                        </b>
                                    </td>
                                    <td class="text-muted text-small">
                                        S/.
                                        {{
                                            totalItemSelected(payment.products)
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else class="border">
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <h3 class="text-muted text-small">
                                            Sin productos seleccionados
                                        </h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row d-flex m-2 justify-content-end">
                <div class="col-3 d-flex justify-content-end">
                    <el-button type="primary" @click="sendPayments"
                        >Listo</el-button
                    >
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showSplitPayment", "total", "orden_items"],
    data() {
        return {
            selectedAccount: undefined,
            splitByAmount: "1",
            number: 2,
            numberProduct: 2,
            payments: [],
            items: []
        };
    },
    created() {
        let payment = _.round(this.total / 2, 1);

        this.payments = [
            {
                fixed: false,
                amount: payment
            },
            {
                fixed: false,
                amount: payment
            }
        ];

        if (this.total != payment * 2) {
            this.payments[0].amount += _.round(payment * 2 - this.total, 1);
        }
    },

    methods: {
        totalItemSelected(products) {
            let total = 0;
            products.forEach(p => {
                total += p.quantity * p.price;
            });

            return _.round(total, 2);
        },
        removeItem(id) {
            let idx = this.payments.findIndex(p => p.selected);
            if (idx > -1) {
                let indexItem = this.payments[idx].products.findIndex(
                    p => p.id == id
                );

                if (indexItem > -1) {
                    let quantity = this.payments[idx].products[indexItem]
                        .quantity;
                    if (quantity == 1) {
                        this.payments[idx].products = [
                            ...this.payments[idx].products.filter(
                                p => p.id != id
                            )
                        ];
                    } else {
                        this.payments[idx].products[indexItem].quantity -= 1;
                    }
                    let item = this.items.find(i => i.id == id);
                    ++item.quantity;
                    if (item.quantity == 1) {
                        this.items = [
                            item,
                            ...this.items.filter(i => i.id != item.id)
                        ];
                    }
                }
            }
        },
        addItem(item) {
            //checar la lista
            //a que cuenta le estas agregando
            if (item.quantity == 0) {
                this.$toast.warning("No quedan unidades disponibles para dividir el producto");
                return;
            }
            let idx = this.payments.findIndex(p => p.selected);
            if (idx > -1) {
                let indexItem = this.payments[idx].products.findIndex(
                    p => p.id == item.id
                );

                if (indexItem > -1) {
                    this.payments[idx].products[indexItem].quantity += 1;
                } else {
                    this.payments[idx].products.push({
                        price: item.price,
                        description: item.food.description,
                        id: item.id,
                        quantity: 1
                    });
                }

                --item.quantity;
                if (item.quantity == 0) {
                    this.items = [
                        ...this.items.filter(i => i.id != item.id),
                        item
                    ];
                }
            } else {
                this.$toast.warning("Seleccione una cuenta");
            }
        },
        async sendPayments() {
            if (this.splitByAmount == "1") {
                this.$emit("receivePayments", this.payments);
            } else {
                if (this.items.some(i => i.quantity > 0)) {
                    this.$toast.error("Aún hay productos por dividir");
                    return;
                }
                this.$emit("receiveProducts", this.payments);
            }
            this.close();
        },
        changePayment(idx) {
            let fixed = this.payments.filter(p => p.fixed);
            let numberFixed = fixed.length;
            if (fixed.length > 0) {
                //obtengo el monto de los pagos fijos
                fixed = fixed.reduce((a, b) => ({
                    amount: a.amount + b.amount,
                    fixed: true
                }));
                if (isNaN(fixed.amount) && fixed.amount > 0) {
                    //el monto que resta del total con los pagos fijos
                    let rest = this.total - fixed.amount;
                    let inputSelected = this.payments[idx];
                    //encontrar el input modificado y dejar el precio
                    rest = rest - inputSelected.amount;
                    //
                }
            }
        },
        paymentByAmount() {
            let payment = _.round(this.total / this.number, 1);
            this.payments = Array.from({ length: this.number }, (_, i) => ({
                fixed: false,
                amount: payment
            }));
            payment;
            if (this.total != payment * this.number) {
                this.payments[0].amount += _.round(
                    this.total - payment * this.number,
                    1
                );
            }
            this.payments.map(p => ({
                ...p,
                amount: _.round(p.amount, 2)
            }));
        },
        updatePayments() {
            if (this.number < 2 || isNaN(this.number)) {
                this.number = 2;
            }

            if (this.splitByAmount == "1") {
                this.paymentByAmount();
            } else {
                this.paymentByProducts();
            }
        },

        selectAccount(idx) {
            if (
                this.selectedAccount != undefined ||
                this.selectedAccount != null
            ) {
                this.payments[this.selectedAccount].selected = false;
            }
            this.payments[idx].selected = true;
            this.selectedAccount = idx;
        },
        paymentByProducts() {
            this.payments = [];
            this.restoreItems();
            let hasProducts = this.payments.some(p => p.products);
            let toAdd = this.numberProduct;
            if (hasProducts) {
                toAdd = this.numberProduct - this.payments.length;
            }

            this.payments = [
                ...this.payments,
                ...Array.from({ length: toAdd }, (_, i) => ({
                    fixed: false,
                    amount: 0,
                    products: [],
                    selected: false
                }))
            ];
        },
        restoreItems() {
            this.items = JSON.parse(JSON.stringify(this.orden_items.items));
        },
        open() {
            this.payments = [];
            this.restoreItems();
            //   this.number = 2;
            //  {
            //         fixed: false,
            //         amount: _.round(this.total / 2, 2)
            //     },
            //     {
            //         fixed: false,
            //         amount: _.round(this.total / 2, 2)
            //     }
        },
        close() {
            this.items = [];
            this.$emit("update:showSplitPayment", false);
        }
    }
};
</script>
