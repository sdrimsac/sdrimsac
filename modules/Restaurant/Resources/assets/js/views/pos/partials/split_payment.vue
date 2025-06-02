<template>
    <el-dialog append-to-body @open="open" @close="close" v-loading="loading" :visible="showSplitPayment"
        :title="`Dividir pago: S/. ${total} Cant. ${quantity} productos`" :width="dialogWidth" :top="dialogTop">
        <div class="row">
            <div class="col-2">
                <div class="col-md-12">
                    <label for="">Entre:</label>
                    <el-input-number class="w-100 split-input-number" :min="2" :max="5" @input="updatePayments"
                        v-model="number" size="mini"></el-input-number>
                </div>
                <div class="col-md-12">
                    <label for="type" style="display: flex; ">Cuentas</label>
                    <el-radio-group v-model="splitByAmount" @change="updatePayments" size="mini"
                        class="split-radio-group">
                        <el-tooltip content="Dividir la cuenta en partes iguales" placement="top">
                            <el-radio-button label="1">
                                <span style="display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-equals"></i>
                                </span>
                            </el-radio-button>
                        </el-tooltip>
                        <el-tooltip content="Dividir cuenta por productos consumidos" placement="top">
                            <el-radio-button label="2" :disabled="quantity == 1">
                                <span style="display: flex; align-items: center; justify-content: center;">
                                    <i class="el-icon-goods"></i>
                                </span>
                            </el-radio-button>
                        </el-tooltip>
                    </el-radio-group>
                </div>
            </div>
            <div class="col-10">
                <div class="table-responsive">
                    <table class="table">
                        <thead style="background-color: #073f68; color: #fff;">
                            <tr>
                                <th style="color: #fff;">Producto</th>
                                <th style="color: #fff; text-align: right;">P/U</th>
                                <th
                                    style="color: #fff; width: 55px; min-width: 55px; max-width: 200px; text-align: center;">
                                    Cant</th>
                                <th
                                    style="color: #fff; width: 60px; min-width: 60px; max-width: 200px; text-align: center;">
                                    Resta</th>
                                <th
                                    style="color: #fff; width: 50px; min-width: 50px; max-width: 200px; text-align: center;">
                                    <i class="fas fa-bolt" style="color: yellow;"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, idx) in items" :key="idx">
                                <td>
                                    {{ item.food.description }}
                                </td>
                                <td :style="{ width: '80px', minWidth: '80px', maxWidth: '200px', textAlign: 'right' }">
                                    {{ item.price }}</td>
                                <td class="text-primary font-weight-bold" style="text-align: center;">
                                    {{ item.originalQuantity }}
                                </td>
                                <td style="text-align: center;">{{ item.quantity }}</td>
                                <td>
                                    <el-tooltip content="Enviar producto a la cuenta seleccionada" placement="top">
                                        <el-button icon="el-icon-s-promotion" :disabled="item.quantity == 0"
                                            @click="addItem(item)"
                                            style="background-color: #073f68; color: #fff; border-color: #073f68;">
                                        </el-button>
                                    </el-tooltip>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        

            <div class="row" v-for="(person, idx) in persons" :key="idx" style="width: 103%;">
                <div class="row" :class="{ 'mt-2': idx == 0 }">
                    <div class="col-12 mb-2">
                        <div class="card" :style="{
                            background: colorArray[idx % colorArray.length].background,
                            color: colorArray[idx % colorArray.length].color,
                            borderRadius: '8px',
                            padding: '12px',
                            boxShadow: '0 2px 8px rgba(0,0,0,0.05)'
                        }">
                            <!-- Título de la cuenta -->
                            <div class="d-flex align-items-center">
                                <span style="font-weight: bold; font-size: 1.1em;">
                                    Cuenta #{{ idx + 1 }}
                                </span>
                                <span v-if="person.amount" class="ml-3"
                                    style="font-size: 1em; margin-left: auto; display: flex; align-items: center;">
                                    Monto: <b>S/. {{ Number(person.amount).toFixed(2) }}</b>
                                </span>
                            </div>
                            <!-- Botones de selección de cuenta, Tipo de documento y Cliente en una sola fila -->
                            <div class="row">
                                <!-- Botón de selección de cuenta -->
                                <div class="col-1 d-flex align-items-center justify-content-center">
                                    <el-button :type="person.selected ? 'primary' : 'default'"
                                        :icon="person.selected ? '' : ''" :disabled="splitByAmount == '1'"
                                        @click="selectAccount(idx)"
                                        style="font-size: 1em; padding: 10px 10px; min-width: 20px; min-height: 20px;">
                                        <i v-if="person.selected" class="fas fa-hand-paper"></i>
                                        <i v-else class="fas fa-hand-rock"></i>
                                    </el-button>
                                </div>
                                <!-- Botones Tipo de documento -->
                                <div class="col-4">
                                    <label for="document_type_id">Tipo de documento</label>
                                    <el-button-group v-model="person.document_type_id" filterable>
                                        <el-button v-if="establishments.documents.invoice" value="01"
                                            @click.native="person.document_type_id = '01'"
                                            class="split-btn-group-btn btn-factura">
                                            <i class="fas fa-file-invoice-dollar fa-sm" style="margin-right: 5px;"></i>
                                            FACTURA
                                        </el-button>
                                        <el-button v-if="establishments.documents.receipt" value="03"
                                            @click.native="person.document_type_id = '03'"
                                            class="split-btn-group-btn btn-boleta">
                                            <i class="fas fa-file-alt fa-sm" style="margin-right: 5px;"></i>
                                            BOLETA
                                        </el-button>
                                        <el-button v-if="establishments.documents.sale_note" value="80"
                                            @click.native="person.document_type_id = '80'"
                                            class="split-btn-group-btn btn-nota">
                                            <i class="fas fa-file-signature fa-sm" style="margin-right: 5px;"></i>
                                            NOTA
                                        </el-button>
                                    </el-button-group>
                                </div>
                                <!-- Cliente -->
                                <div class="col-7">
                                    <label for="new_customer_id">
                                        <a href="#" @click.prevent="openDialogNewPerson(idx)">Cliente [+ Nuevo]</a>
                                    </label>
                                    <el-select v-model="person.customer_id" filterable remote :class="{
                                        pperson: person.selected
                                    }" popper-class="el-select-customers"
                                        placeholder="Escriba el nombre o número de documento del cliente"
                                        :remote-method="searchRemoteCustomers" :loading="loading_search"
                                        @change="changeCustomer(idx)" :ref="`customer_${idx}`">
                                        <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <!-- Fila única para WhatsApp, Método de pago, Monto y N° de operación -->
                            <div class="row w-100">

                                <!-- Método de pago -->
                                <div class="col-4">
                                    <label for="payment_method_id">Método de pago</label>
                                    <el-select v-model="person.payment_method" filterable
                                        @change="onChangePaymentMethod(idx)">
                                        <el-option v-for="option in paymentMethods" :key="option.value"
                                            :value="option.value" :label="option.text"></el-option>
                                    </el-select>
                                </div>
                                <!-- monto -->
                                <!-- <div class="col-3">
                                        <label for="amount">Monto</label>
                                        <el-input v-model="person.amount" readonly></el-input>
                                    </div> -->
                                <!-- N° de operación -->
                                <div class="col-3" v-if="['03', '04', '05', '06'].includes(person.payment_method)">
                                    <label for="">N. Op.</label>
                                    <el-input v-if="['03', '04', '05', '06'].includes(person.payment_method)"
                                        v-model="person.operation_number"
                                        :placeholder="`N° de operación ${idx + 1}`"></el-input>
                                    <div class="col-3" v-else >
                                        <!-- Sino cumple queda vacio -->
                                    </div>
                                </div>
                                <!-- Nro de WhatsApp -->
                                <div class="col-4">
                                    <label for="" style="margin-bottom: 2px;">
                                        <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 4px;"></i>
                                        WhatsApp
                                    </label>
                                    <el-input v-model="person.customer_telephone"
                                        :placeholder="`N° de WhatsApp ${idx + 1}`" @keyup.enter="sendPayments"
                                        style="padding: 2px 6px; margin: 0;"></el-input>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 m-1" v-if="splitByAmount == '2' && person.products.length > 0">
                            <div class="split-products-list" style="padding: 0; margin: 0;">
                                <el-collapse
                                    :value="[`products_${idx}`]"
                                    class="split-products-collapse"
                                    accordion
                                >
                                    <el-collapse-item
                                        :name="`products_${idx}`"
                                        :title="`Productos (${person.products.length})`"
                                        :style="{
                                            background: colorArray[idx % colorArray.length].background,
                                            color: colorArray[idx % colorArray.length].color,
                                            borderRadius: '6px',
                                            marginBottom: '8px',
                                            border: '1px solid #e0e0e0'
                                        }"
                                    >
                                        <el-table
                                            :data="person.products"
                                            style="width: 100%; padding: 0; margin: 0;"
                                            :header-cell-style="{
                                                background: colorArray[idx % colorArray.length].background,
                                                color: colorArray[idx % colorArray.length].color,
                                                fontWeight: 'bold'
                                            }"
                                            :cell-style="{
                                                background: '#fff'
                                            }"
                                            size="mini"
                                            border
                                        >
                                            <el-table-column prop="quantity" label="Cantidad" width="90"></el-table-column>
                                            <el-table-column prop="description" label="Descripción"></el-table-column>
                                            <el-table-column label="Acciones" width="90">
                                                <template slot-scope="scope">
                                                    <el-button
                                                        size="mini"
                                                        type="danger"
                                                        @click="removeItem(scope.row.id, idx)"
                                                        icon="el-icon-delete"
                                                        circle
                                                        :style="{ background: '#e53935', color: '#fff', border: 'none' }"
                                                    ></el-button>
                                                </template>
                                            </el-table-column>
                                        </el-table>
                                    </el-collapse-item>
                                </el-collapse>
                            </div>
                        </div>

                    </div>



                </div>

            </div>
            <el-divider></el-divider>
        

        <person-form :showDialog.sync="showDialogNewPerson" type="customers" :user_id="form.user_id" :external="true"
            document_type_id="03" @reloadDataPersons="reloadDataCustomers"></person-form>
        <div class="row d-flex m-2 justify-content-end">
            <div class="col-3 d-flex justify-content-end">
                <el-button  type="primary" @click="sendPayments">Listo</el-button>
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

.split-radio-group {
    display: flex;
    gap: 8px;
}

.split-radio-group .el-radio-button__inner.is-checked,
.split-radio-group .el-radio-button.is-active .el-radio-button__inner {
    background-color: #073f68 !important;
    border-color: #073f68 !important;
    color: #fff !important;
}

.split-input-number .el-input__inner {
    width: 100%;
    min-width: 0;
    text-align: center;
}

.split-btn-group-btn {
    margin-right: 6px;
    font-size: 15px;
    font-family: Arial, sans-serif;
    padding: 4px 10px;
    font-weight: bold;
    width: 90px;
    height: 40px;
    border-radius: 4px;
    display: flex;
    justify-content: left;
    align-items: center;
}

.btn-factura {
    background-color: #4CAF50 !important;
    border-color: #4CAF50 !important;
    color: #fff !important;
}

.btn-boleta {
    background-color: #FFC107 !important;
    border-color: #FFC107 !important;
    color: #fff !important;
}

.btn-nota {
    background-color: #1E88E5 !important;
    border-color: #1E88E5 !important;
    color: #fff !important;
}

@media (max-width: 1024px) {
    .split-btn-group-btn {
        font-size: 9px;
        padding: 2px 2px;
        width: 65px;
        height: 26px;
    }
}

@media (min-width: 1025px) {
    .split-btn-group-btn {
        font-size: 14px;
        /* padding: 2px 2px; */
        width: 100px;
        height: 38px;
    }
}

@media (max-width: 1280px) {
    .split-input-number .el-input__inner {
        font-size: 1.3em;
        height: 32px;
        /* Ajusta este valor si tu el-radio-button tiene otro alto */
        line-height: 32px;
        padding-left: 0.7em;
        padding-right: 0.7em;
        min-width: 0;
        width: 100%;
        text-align: center;
        box-sizing: border-box;
    }

    .split-input-number {
        width: 100% !important;
        min-width: 0 !important;
    }

    .split-input-number .el-input-number__increase,
    .split-input-number .el-input-number__decrease {
        font-size: 1.1em;
        padding: 0 6px;
    }

    .split-radio-group .el-radio-button__inner {
        height: 32px;
        line-height: 32px;
        box-sizing: border-box;
    }
}
</style>
<script>
import Swal from 'sweetalert2';
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
        "series",
        "establishments"
    ],
    created() { },
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
    computed: {
        dialogWidth() {
            return window.innerWidth <= 1280 ? '90%' : '75%';
        },
        dialogTop() {
            // Puedes cambiar este valor según tu criterio, por ejemplo:
            return window.innerWidth <= 768 ? '2vh' : '8vh';
        }
    },
    mounted() {
        window.addEventListener('resize', this.$forceUpdate);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.$forceUpdate);
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
            this.loading = true;
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.persons[
                        this.current_index_person
                    ].customer_id = customer_id;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        openDialogNewPerson(idx) {
            this.current_index_person = idx;
            let ref = `customer_${idx}`;
            console.log("🚀 ~ openDialogNewPerson ~ ref:", ref);
            console.log(this.$refs[ref]);
            let vv = this.$refs[ref][0].$el.getElementsByTagName("input")[0]
                .value;
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

            // Validar número de operación para métodos de pago específicos
            let invalidOperation = this.persons.some(p => {
                if (["03", "04", "05", "06"].includes(p.payment_method)) {
                    return !p.operation_number || p.operation_number.trim() === '';
                }
                return false;
            });
            if (invalidOperation) {
                this.$showSAlert(
                    "Error",
                    "Debe ingresar el número de operación para para poder realizar la operacion",
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
            // Ensure sale notes are marked as paid
            if (form.document_type_id === "80") {
                newForm.credit = false;
                newForm.paid = 1;
                newForm.payment_condition_id = "01";
                newForm.prefix = "NV";

                if (!newForm.payments) {
                    newForm.payments = [
                        {
                            payment_method_type_id: "01",
                            date_of_payment: newForm.date_of_issue,
                            payment: newForm.total
                        }
                    ];
                }
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
                        payment_method: p.payment_method, // Now this is the value (e.g., '03' for Yape)
                        customer_telephone: p.customer_telephone,
                        operation_number: p.operation_number
                    });
                    await this.sendDocument(form, resource);
                }
            } else {
                for (let i = 0; i < this.persons.length; i++) {
                    let items = JSON.parse(JSON.stringify(this.form.items));
                    let p = this.persons[i];

                    // Filtrar y clonar los ítems correspondientes a la persona actual, ajustando la cantidad
                    let personItems = p.products.map(product => {
                        let original = items.find(i => i.id == product.id);
                        if (original) {
                            // Clonar el producto y asignar la cantidad que corresponde a la persona
                            return {
                                ...original,
                                quantity: product.quantity
                            };
                        }
                        return null;
                    }).filter(Boolean);

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
                        payment_method: p.payment_method, // Now this is the value (e.g., '03' for Yape)
                        customer_telephone: p.customer_telephone,
                        operation_number: p.operation_number
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
                Swal.fire("No quedan unidades disponibles para dividir el producto");
                return;
            }
            let itemIdx = this.items.findIndex(i => i.id == item.id);
            let idx = this.persons.findIndex(p => p.selected);
            if (idx > -1) {
                let indexItem = this.persons[idx].products.findIndex(
                    p => p.id == item.id
                );

                if (indexItem > -1) {
                    // Solo incrementa la cantidad asignada a esta persona
                    this.persons[idx].products[indexItem].quantity += 1;
                } else {
                    // Agrega el producto con cantidad 1, no la cantidad total
                    this.persons[idx].products.push({
                        price: item.price,
                        description: item.food.description,
                        id: item.id,
                        quantity: 1, // Solo 1 asignado
                        background:
                            itemIdx > 19
                                ? "black"
                                : this.colorArray[itemIdx].background,
                        color:
                            itemIdx > 19
                                ? "black"
                                : this.colorArray[itemIdx].color
                    });
                }

                // Resta 1 a la cantidad disponible en la lista general
                item.quantity -= 1;
                // Calcula el total solo de los productos asignados a la persona
                this.persons[idx].amount = this.totalItemSelected(
                    this.persons[idx].products
                );
            } else {
                Swal.fire("Seleccione una cuenta");
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
        /* changeCustomer(idx) {
            let customer = this.customers.find(
                c => c.id == this.persons[idx].customer_id
            );
            this.persons[idx].identity_document_type_id =
                customer.identity_document_type_id;
        }, */
        changeCustomer(idx) {
            let customer = this.customers.find(
                c => c.id == this.persons[idx].customer_id
            );
            this.persons[idx].identity_document_type_id = customer.identity_document_type_id;
            this.persons[idx].customer_telephone = customer.telephone;
        },
        onChangePaymentMethod(idx) {
            // Limpiar número de operación si cambia a método que no lo requiere
            const p = this.persons[idx];
            if (!['03', '04', '05', '06'].includes(p.payment_method)) {
                p.operation_number = '';
            }
        },
        addPerson(amount = 0) {
            this.persons.push({
                identity_document_type_id: this.customer_default
                    .identity_document_type_id,
                customer_id: this.customer_default_id,
                amount: amount,
                payment_method: "01", // Default to 'Efectivo' value
                selected: false,
                document_type_id: "03",
                products: [],
                customer_telephone: '',
                operation_number: ''
            });
        },
        open() {
            console.log(
                "🚀 ~ created ~ this.orden_items ver que llega:",
                this.printerOn
            );
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
