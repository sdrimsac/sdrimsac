<template>
    <el-dialog
        append-to-body
        @open="open"
        @close="close"
        v-loading="loading"
        :visible="showSplitPayment"
        :title="`Dividir pago: S/. ${total} Cant. ${quantity} productos`"
        width="85%"
    >
        <div class="row mt-2">
            <div class="d-flex flex-column col-md-6 col-lg-6 col-12">
                <div class="row">
                    <div class="col-md-6 col-12 col-lg-6">
                        <label for="">Dividir entre:</label><br />
                        <el-input-number
                            class="w-100"
                            :min="2"
                            @input="updatePayments"
                            v-model="number"
                            controls
                        ></el-input-number>
                    </div>
                    <div class="col-md-6 col-12 col-lg-6">
                        <label for="type">Tipo</label>
                        <br />
                        <el-radio-group
                            v-model="splitByAmount"
                            @change="updatePayments"
                        >
                            <el-radio-button label="1"
                                >Por cuotas</el-radio-button
                            >
                            <el-radio-button label="2" :disabled="quantity == 1"
                                >Por producto</el-radio-button
                            >
                        </el-radio-group>
                    </div>
                </div>
                <div
                    class="row mt-1"
                    v-for="(person, idx) in persons"
                    :key="idx"
                >
                    <div
                        class="row"
                        :class="{
                            'mt-2': idx == 0
                        }"
                    >
                        <div class="col-2">
                            <br />
                            <el-button
                                :type="
                                    `${person.selected ? 'primary' : 'default'}`
                                "
                                icon="el-icon-plus"
                                :disabled="splitByAmount == '1'"
                                @click="selectAccount(idx)"
                            ></el-button>
                        </div>
                        <div class="col-10">
                            <label for="new_customer_id">
                                <a href="#" @click.prevent="openDialogNewPerson(idx)"
                                    >[+ Nuevo]</a
                                >
                            </label>
                            <el-select
                                v-model="person.customer_id"
                                filterable
                                remote
                                :class="{
                                    pperson: person.selected
                                }"
                                popper-class="el-select-customers"
                                placeholder="Escriba el nombre o número de documento del cliente"
                                :remote-method="searchRemoteCustomers"
                                :loading="loading_search"
                                @change="changeCustomer(idx)"
                                :ref="`customer_${idx}`"
                            >
                                <el-option
                                    v-for="option in customers"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                        </div>

                        <div class="col-4">
                            <label for="document_type_id"
                                >Tipo de documento</label
                            >
                            <el-select
                                v-model="person.document_type_id"
                                filterable
                            >
                                <el-option
                                    v-for="option in documentTypes"
                                    :key="option.value"
                                    :value="option.value"
                                    :label="option.text"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="col-4">
                            <label for="payment_method_id"
                                >Método de pago</label
                            >
                            <el-select
                                v-model="person.payment_method"
                                filterable
                            >
                                <el-option
                                    v-for="option in paymentMethods"
                                    :key="option.value"
                                    :value="option.text"
                                    :label="option.text"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="col-4">
                            <label for="amount">Monto</label>
                            <el-input
                                v-model="person.amount"
                                readonly
                            ></el-input>
                        </div>
                        <div class="col-3"></div>
                        <div
                            class="col-12 m-1"
                            v-if="
                                splitByAmount == '2' &&
                                    person.products.length > 0
                            "
                        >
                            <el-collapse>
                                <el-collapse-item
                                    :title="
                                        `Productos ${person.products.length}`
                                    "
                                >
                                    <el-table
                                        :data="person.products"
                                        style="width: 100%"
                                    >
                                        <el-table-column
                                            prop="quantity"
                                            label="Cantidad"
                                            width="150"
                                        ></el-table-column>
                                        <el-table-column
                                            prop="description"
                                            label="Descripción"
                                        ></el-table-column>
                                        <el-table-column
                                            label="Acciones"
                                            width="120"
                                        >
                                            <template slot-scope="scope">
                                                <el-button
                                                    size="mini"
                                                    type="danger"
                                                    @click="
                                                        removeItem(
                                                            scope.row.id,
                                                            idx
                                                        )
                                                    "
                                                >
                                                    Remover
                                                </el-button>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                </el-collapse-item>
                            </el-collapse>
                        </div>
                    </div>
                    <el-divider></el-divider>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>P/U</th>
                                <th colspan="2">Cant</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in items" :key="idx">
                                <td>
                                    {{ item.food.description }}
                                </td>
                                <td>S/. {{ item.price }}</td>
                                <td class="text-primary font-weight-bold">
                                    {{ item.originalQuantity }}
                                </td>
                                <td>{{ item.quantity }}</td>
                                <td>
                                    <el-button
                                        icon="el-icon-plus"
                                        :disabled="item.quantity == 0"
                                        @click="addItem(item)"
                                    ></el-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :user_id="form.user_id"
            :external="true"
            document_type_id="03"
            @reloadDataPersons="reloadDataCustomers"
        ></person-form>
        <div class="row d-flex m-2 justify-content-end">
            <div class="col-3 d-flex justify-content-end">
                <el-button type="primary" @click="sendPayments"
                    >Listo</el-button
                >
            </div>
        </div>
    </el-dialog>
</template>
<style>
.el-divider--horizontal {
    margin-top: 10px;
    margin-bottom: 10px;
}

.pperson .el-input--suffix .el-input__inner {
    color: #073f68;
}
</style>
<script>
import PersonForm from "../../../../../../../../resources/js/views/persons/form.vue";
export default {
    components: {
        PersonForm
    },
    props: [
        "printerOn",
        "showSplitPayment",
        "total",
        "orden_items",
        "customer_default",
        "form",
        "series"
    ],
    created() {
    
    },
    data() {
        return {
            showDialogNewPerson: false,
            formOrigin: {},
            colorArray: [
                { background: "#CFE2F3", color: "#004080" }, // SoftBlue background with Navy text
                { background: "#B7E1A1", color: "#2C6B2F" }, // SoftGreen background with ForestGreen text
                { background: "#F4C2C2", color: "#C2185B" }, // SoftPink background with DarkPink text
                { background: "#FFE08A", color: "#D2691E" }, // SoftGold background with Chocolate text
                { background: "#CFF4F9", color: "#008B8B" }, // SoftCyan background with DarkCyan text
                { background: "#DCDCDC", color: "#505050" }, // SoftGray background with Gray text
                { background: "#FFF5CC", color: "#FFA500" }, // SoftLemonChiffon background with Orange text
                { background: "#F5E9A1", color: "#8B8B00" }, // SoftKhaki background with Olive text
                { background: "#EDE5F5", color: "#6A0DAD" }, // SoftLavender background with Purple text
                { background: "#F5E7B1", color: "#8B4513" }, // SoftBeige background with SaddleBrown text
                { background: "#FFD9D6", color: "#D83B1F" }, // SoftMistyRose background with Tomato text
                { background: "#E5FFE5", color: "#1D8348" }, // SoftHoneydew background with Green text
                { background: "#EFFAF0", color: "#2E8B57" }, // SoftMintCream background with SeaGreen text
                { background: "#FFEBEF", color: "#B03060" }, // SoftLavenderBlush background with Crimson text
                { background: "#F9F3D2", color: "#B8860B" }, // SoftGoldenRodYellow background with GoldenRod text
                { background: "#FFE9C8", color: "#FF4500" }, // SoftPapayaWhip background with OrangeRed text
                { background: "#FFF1E8", color: "#8B0000" }, // SoftSeaShell background with DarkRed text
                { background: "#EAF3FF", color: "#4682B4" }, // SoftAliceBlue background with SteelBlue text
                { background: "#FBFBFF", color: "#483D8B" }, // SoftGhostWhite background with SlateBlue text
                { background: "#F7F7F7", color: "#696969" } // SoftWhiteSmoke background with DimGray text
            ],
            selectedAccount: undefined,
            customer_default_id: null,
            current_index_person: null,
            splitByAmount: "1",
            number: 2,
            loading: false,
            numberProduct: 2,
            payments: [],
            items: [],
            quantity: 0,
            documentTypes: [
                { value: "01", text: "FACTURA" },

                { value: "03", text: "BOLETA" },
                { value: "80", text: "NOTA DE VENTA" }
            ],
            paymentMethods: [
                { value: "01", text: "Efectivo", img: "botonEfectivo.png" },
                { value: "02", text: "Culqui", img: "CulquiIcon.png" },
                {
                    value: "05",
                    text: "TARJETA: IZYPAY",
                    img: "botonIzipay.png"
                },
                {
                    value: "06",
                    text: "TARJETA: NIUBIZ",
                    img: "botonNiubiz.png"
                },
                {
                    value: "03",
                    text: "Yape",
                    img: "yape-logo-3E473EE7E5-seeklogo.com.png"
                },
                {
                    value: "04",
                    text: "PLIN",
                    img: "plin-logo-0C4106153C-seeklogo.com.png"
                },
                { value: "07", text: "BBVA", img: "bbva-logo.png" },
                { value: "08", text: "BCP", img: "bcp-logo.png" },
                { value: "09", text: "Scotiabank", img: "scotiabank-logo.png" },
                { value: "10", text: "BCO NACION", img: "nacion-logo.png" }
            ],
            persons: [],
            customers: [],
            loading_search: false,
            input_person: { number: null },
            payments: []
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
        reloadDataCustomers(customer_id) {
            this.loading    = true;
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.persons[
                        this.current_index_person
                    ].customer_id = customer_id;
                }).catch(error => {
                    console.log(error);
                }).finally(() => {
                    this.loading = false;
                });
        },
        openDialogNewPerson(idx) {
            this.current_index_person = idx;
            let ref = `customer_${idx}`;
            console.log("🚀 ~ openDialogNewPerson ~ ref:", ref)
            console.log(this.$refs[ref]);
            let vv = this.$refs[ref][0].$el.getElementsByTagName("input")[0].value;
            this.showDialogNewPerson = true;
            console.log("🚀 ~ openDialogNewPerson ~ vv:", vv);
        },
        validate() {
            let somePersonHasZeroAmount = this.persons.some(p => p.amount == 0);
            console.log(
                "🚀 ~ validate ~ somePersonHasZeroAmount:",
                somePersonHasZeroAmount
            );
            if (somePersonHasZeroAmount) {
                this.$showSAlert(
                    "Error",
                    "El monto a pagar no puede ser 0",
                    "error"
                );
                return false;
            }
            let person = this.persons.find(
                p =>
                    p.identity_document_type_id !== "6" &&
                    p.document_type_id == "01"
            );
            if (person) {
                this.$showSAlert(
                    "Error",
                    "Las facturas deben ser emitidas a RUC",
                    "error"
                );
                return false;
            }

            let total = this.persons.reduce((a, b) => a + Number(b.amount), 0);
            console.log("🚀 ~ validate ~ this.total:", this.total);
            console.log("🚀 ~ validate ~ total:", total);
            if (total != this.total) {
                this.$showSAlert(
                    "Error",
                    "La suma de los montos no coincide con el total",
                    "error"
                );
                return false;
            }
            return true;
        },
        async sendDocument(form, resource) {
            this.loading = true;
            let newForm = this.reCalculateTotal(form);
            if (this.printerOn) {
                newForm.printerOn = true;
            }
            const response = await this.$http.post(`/${resource}`, newForm);
            this.loading = false;
        },
        async sendPayments() {
            if (!this.validate()) {
                return;
            }

            let form = JSON.parse(JSON.stringify(this.form));
            let { items } = form;

            // Ensure printerOn is true for split payments
            form.printerOn = this.printerOn;

            if (this.splitByAmount == "1") {
                for (const p of this.persons) {
                    let fItems = this.formatItems(
                        items,
                        null,
                        this.percentage_igv,
                        p.amount
                    );
                    form.items = fItems;
                    form.document_type_id = p.document_type_id;
                    form.prefix = "NV";
                    form.payments = [];
                    let serie_id = this.series.find(
                        s => s.document_type_id == form.document_type_id
                    ).id;
                    form.customer_id = p.customer_id;
                    form.series_id = serie_id;
                    form.afectar_caja = false;
                    let resource =
                        p.document_type_id == "80" ? "sale-notes" : "documents";
                    this.payments.push({
                        amount: p.amount,
                        payment_method: this.paymentMethods.find(
                            pm => pm.text == p.payment_method
                        ).value
                    });
                    await this.sendDocument(form, resource);
                }
            } else {
                for (let i = 0; i < this.persons.length; i++) {
                    let items = JSON.parse(JSON.stringify(this.form.items));
                    let p = this.persons[i];

                    // Filtrar los ítems correspondientes a la persona actual
                    let personItems = items.filter(i =>
                        p.products.some(product => {
                            return product.id == i.id;
                        })
                    );

                    let currentTotal = personItems.reduce(
                        (sum, i) => sum + i.sale_unit_price * i.quantity,
                        0
                    );

                    let fItems = this.formatItems(
                        personItems,
                        null,
                        this.percentage_igv,
                        currentTotal
                    );

                    form.items = fItems;

                    form.document_type_id = p.document_type_id;
                    form.prefix = "NV";
                    form.payments = [];

                    // Encontrar la serie correspondiente
                    let serie_id = this.series.find(
                        s => s.document_type_id == form.document_type_id
                    ).id;

                    form.customer_id = p.customer_id;
                    form.series_id = serie_id;
                    form.afectar_caja = false;

                    let resource =
                        p.document_type_id == "80" ? "sale-notes" : "documents";

                    this.payments.push({
                        amount: p.amount,
                        payment_method: this.paymentMethods.find(
                            pm => pm.text == p.payment_method
                        ).value
                    });
                    await this.sendDocument(form, resource);
                }
            }
            this.$emit("setPayments", this.payments);
            this.close();
        },
        formatItems(
            items = [],
            affectation = null,
            percentage_igv = 0.18,
            generalAmount
        ) {
            console.log("🚀 ~ items xxxxx:", items);
            let currentTotal = items.reduce(
                (sum, i) => sum + i.sale_unit_price * i.quantity,
                0
            );

            let adjustmentFactor = generalAmount / currentTotal;

            items = items.map(i => {
                let affectation_igv_type_id =
                    affectation != null && affectation != undefined
                        ? affectation
                        : i.sale_affectation_igv_type_id;

                let adjustedQuantity = i.quantity * adjustmentFactor;

                return {
                    ...i,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value:
                        affectation_igv_type_id == 10
                            ? i.sale_unit_price / (1 + percentage_igv / 100)
                            : i.sale_unit_price,
                    quantity: adjustedQuantity,
                    aux_quantity: adjustedQuantity,
                    total_base_igv:
                        affectation_igv_type_id == 10
                            ? (i.sale_unit_price * adjustedQuantity) /
                              (1 + percentage_igv / 100)
                            : i.sale_unit_price * adjustedQuantity,
                    percentage_igv: this.percentage_igv,
                    total_igv:
                        affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * adjustedQuantity) /
                                  (1 + percentage_igv / 100)) *
                              (percentage_igv / 100)
                            : 0,
                    total_base_isc: 0.0,
                    percentage_isc: 0.0,
                    total_isc: 0.0,
                    total_base_other_taxes: 0.0,
                    percentage_other_taxes: 0.0,
                    total_other_taxes: 0.0,
                    total_taxes:
                        affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * adjustedQuantity) /
                                  (1 + percentage_igv / 100)) *
                              (percentage_igv / 100)
                            : 0,
                    total_value:
                        affectation_igv_type_id == 10
                            ? (i.sale_unit_price * adjustedQuantity) /
                              (1 + percentage_igv / 100)
                            : adjustedQuantity * i.sale_unit_price,
                    total_charge: 0.0,
                    total_discount: 0.0,
                    total: i.sale_unit_price * adjustedQuantity,
                    price_type_id: "01",
                    unit_price: i.sale_unit_price,
                    unit_price_value: i.sale_unit_price,
                    has_igv: i.has_igv,
                    affectation_igv_type_id: affectation_igv_type_id,
                    presentation: null,
                    charges: [],
                    discounts: [],
                    attributes: [],
                    affectation_igv_type: affectation_igv_type_id
                };
            });

            return items;
        },
        reCalculateTotal(form) {
            let total_discount = 0;
            let total_charge = 0;

            let total_exportation = 0;
            let total_taxed = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            let total_plastic_bag_taxes = 0;
            // form.items = this.formatItems(form.items);

            form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);

                if (row.affectation_igv_type_id === "10") {
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total_value);
                }
                if (row.affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                }
                if (row.affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) > -1
                ) {
                    total_igv += parseFloat(row.total_igv);
                    total += parseFloat(row.total);
                }
                total_value += parseFloat(row.total_value);
                total_plastic_bag_taxes += isNaN(
                    parseFloat(row.total_plastic_bag_taxes)
                )
                    ? 0.0
                    : parseFloat(row.total_plastic_bag_taxes);
            });

            form.total_exportation = _.round(total_exportation, 2);
            form.total_taxed = _.round(total_taxed, 2);
            form.total_exonerated = _.round(total_exonerated, 2);
            form.total_unaffected = _.round(total_unaffected, 2);
            form.total_free = _.round(total_free, 2);
            form.total_igv = _.round(total_igv, 2);
            form.total_value = _.round(total_value, 2);
            form.total_value_without_rounding = total_value;
            form.total_taxes = _.round(total_igv, 2);
            form.total_plastic_bag_taxes = _.round(total_plastic_bag_taxes, 2);
            // this.form.total = _.round(total, 2)
            form.total = _.round(
                total_charge + total + this.form.total_plastic_bag_taxes,
                2
            );

            return form;
        },
        selectAccount(idx) {
            this.persons = this.persons.map(p => ({ ...p, selected: false }));
            this.persons[idx].selected = true;
        },
        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}`
                );
                this.customers = response.data.customers;
                //if exist a default customer
                if (this.customer_default) {
                    this.customers = [
                        this.customer_default,
                        ...this.customers.filter(
                            c => c.id != this.customer_default.id
                        )
                    ];
                }
                this.loading_search = false;
                this.input_person.number = null;
            }
        },
        totalItemSelected(products) {
            let total = 0;
            products.forEach(p => {
                total += p.quantity * p.price;
            });

            return _.round(total, 2);
        },
        removeItem(id, idx) {
            if (idx > -1) {
                let indexItem = this.persons[idx].products.findIndex(
                    p => p.id == id
                );

                if (indexItem > -1) {
                    let quantity = this.persons[idx].products[indexItem]
                        .quantity;
                    if (quantity == 1) {
                        this.persons[idx].products = [
                            ...this.persons[idx].products.filter(
                                p => p.id != id
                            )
                        ];
                    } else {
                        this.persons[idx].products[indexItem].quantity -= 1;
                    }
                    let item = this.items.find(i => i.id == id);
                    item.quantity += 1;
                }
                this.persons[idx].amount = this.totalItemSelected(
                    this.persons[idx].products
                );
            }
        },
        addItem(item) {
            if (item.quantity == 0) {
                this.$toast.warning(
                    "No quedan unidades disponibles para dividir el producto"
                );
                return;
            }
            let itemIdx = this.items.findIndex(i => i.id == item.id);
            let idx = this.persons.findIndex(p => p.selected);
            if (idx > -1) {
                let indexItem = this.persons[idx].products.findIndex(
                    p => p.id == item.id
                );

                if (indexItem > -1) {
                    this.persons[idx].products[indexItem].quantity += 1;
                } else {
                    this.persons[idx].products.push({
                        price: item.price,
                        description: item.food.description,
                        id: item.id,
                        quantity: 1,
                        background:
                            itemIdx > 19
                                ? "black"
                                : this.colorArray[itemIdx].background,
                        color:
                            itemIdx > 19
                                ? "white"
                                : this.colorArray[itemIdx].color
                    });
                }

                --item.quantity;
                this.persons[idx].amount = this.totalItemSelected(
                    this.persons[idx].products
                );
            } else {
                this.$toast.warning("Seleccione una cuenta");
            }
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
        roundUpToNearestTenth(value) {
            return Math.ceil(value * 10) / 10;
        },
        updatePayments() {
            let isAmount = this.splitByAmount == "1";
            let amount = 0;
            let remainingAmount = this.total;

            if (isAmount) {
                amount = this.total / this.number;
                amount = this.roundUpToNearestTenth(amount);
            }

            this.persons = [];

            for (let i = 0; i < this.number; i++) {
                if (isAmount) {
                    if (i === this.number - 1) {
                        let lastAmount = this.roundUpToNearestTenth(
                            remainingAmount
                        );
                        this.addPerson(lastAmount);
                    } else {
                        this.addPerson(amount);
                        remainingAmount -= amount;
                    }
                } else {
                    this.addPerson();
                }
            }

            this.restoreItems();
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
            this.items = JSON.parse(JSON.stringify(this.orden_items.items)).map(
                i => ({
                    ...i,
                    originalQuantity: i.quantity,
                    id: i.food.item.id
                })
            );
        },
        changeCustomer(idx) {
            let customer = this.customers.find(
                c => c.id == this.persons[idx].customer_id
            );
            this.persons[idx].identity_document_type_id =
                customer.identity_document_type_id;
        },
        addPerson(amount = 0) {
            this.persons.push({
                identity_document_type_id: this.customer_default
                    .identity_document_type_id,
                customer_id: this.customer_default_id,
                amount: amount,
                payment_method: "Efectivo",
                selected: false,
                document_type_id: "03",
                products: []
            });
        },
        open() {
            console.log("🚀 ~ created ~ this.orden_items ver que llega:", this.printerOn);
            this.formOrigin = JSON.parse(JSON.stringify(this.form));
            let { items } = this.orden_items;
            this.quantity = items.reduce((a, b) => a + Number(b.quantity), 0);
            this.payments = [];
            this.restoreItems();
            if (this.customer_default) {
                this.customers = [this.customer_default];
                this.customer_default_id = this.customer_default.id;
            }
            this.updatePayments();
        },
        close() {
            this.items = [];
            this.$emit("update:showSplitPayment", false);
        }
    }
};
</script>
