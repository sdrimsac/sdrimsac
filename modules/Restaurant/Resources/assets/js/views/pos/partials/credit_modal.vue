<template>
    <el-dialog
        title="Crédito"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
        width="950px"
        append-to-body
        :close-on-click-modal="false"
    >
        <div class="m-2">
            <div class="row">
                <div class="col-md-6">
                    <label>
                        Cliente
                        <a href="#" @click.prevent="showDialogNewPerson = true"
                            >[+ Nuevo]</a
                        >
                    </label>
                    <el-select
                        v-model="form.customer_id"
                        filterable
                        remote
                        class="border-left rounded-left border-info"
                        popper-class="el-select-customers"
                        dusk="customer_id"
                        placeholder="Escriba el nombre o número de documento del cliente"
                        :remote-method="searchRemoteCustomers"
                        :loading="loading_search"
                        @change="changeCustomer"
                    >
                        <el-option
                            v-for="option in customers"
                            :key="option.id"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                    <a
                        v-if="hasProblems"
                        class="text-danger"
                        href="#"
                        @click.prevent="seeProblems"
                    >
                        <i class="fa fa-exclamation-triangle"></i>
                        Cliente castigado
                    </a>
                </div>
                <div class="col-md-6">
                    <label>Fecha de emisión</label>
                    <el-date-picker
                        class="w-100"
                        v-model="form.date_of_issue"
                        type="date"
                        value-format="yyyy-MM-dd"
                        :clearable="false"
                        format="dd-MM-yyyy"
                        :readonly="!user.can_accept_credit_sale_note"
                    >
                    </el-date-picker>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label w-100">Tiempo (Mes)</label>
                        <el-input-number
                            v-model="credit.month"
                            :disabled="credit.type_payment == 'Unico'"
                            :controls="false"
                            @change="calculate"
                            :min="0"
                            :max="60"
                        ></el-input-number>
                        <small
                            class="text-danger"
                            v-if="errors.month"
                            v-text="errors.month[0]"
                        ></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="control-label w-100"
                        >Cronograma de Pago
                        <span class="text-danger">*</span></label
                    >
                    <el-radio-group
                        v-model="credit.type_payment"
                        size="mini"
                        @change="changeTypePayment"
                    >
                        <el-radio-button label="Diario"></el-radio-button>
                        <el-radio-button label="Semanal"></el-radio-button>
                        <el-radio-button label="Quincenal"></el-radio-button>
                        <el-radio-button label="Mensual"></el-radio-button>
                        <el-radio-button
                            label="Unico"
                            v-if="configuration.sale_note_credit_confirm"
                        ></el-radio-button>
                    </el-radio-group>
                    <small
                        class="text-danger"
                        v-if="errors.type_payment"
                        v-text="errors.type_payment[0]"
                    ></small>
                </div>
                <div class="col-md-2">
                    <label class="control-label w-100"
                        >Nº Cuota <span class="text-danger">*</span></label
                    >
                    <b>{{ credit.num_cuota }} </b>
                    <small
                        class="text-danger"
                        v-if="errors.num_cuota"
                        v-text="errors.num_cuota[0]"
                    ></small>
                </div>
                <div class="col-md-2">
                    <label class="control-label w-100"
                        >Tasa %<span class="text-danger">*</span></label
                    >
                    <el-input-number
                        v-model="tasaInteres"
                        :controls="false"
                        @change="calculate"
                    ></el-input-number>
                </div>
                <div class="col-md-2">
                    <label class="control-label w-100"
                        >Cuota <span class="text-danger">*</span></label
                    >
                    <b>{{ credit.amount }}</b>
                    <small
                        class="text-danger"
                        v-if="errors.amount"
                        v-text="errors.amount[0]"
                    ></small>
                </div>
                <div class="col-md-2">
                    <label class="control-label w-100"
                        >Adelanto <span class="text-danger">*</span></label
                    >
                    <el-input-number
                        v-model="credit.advances"
                        controls-position="right"
                        @blur="advances_total()"
                    ></el-input-number>
                    <small
                        class="text-danger"
                        v-if="errors.advances"
                        v-text="errors.advances[0]"
                    ></small>
                </div>
                <div class="col-md-3" v-if="credit.type_payment == 'Unico'">
                    <label for="" class="control-label w-100">
                        Fecha de Pago
                    </label>
                    <el-date-picker
                        class="w-100"
                        v-model="credit.date_of_pay"
                        type="date"
                        value-format="yyyy-MM-dd"
                        :clearable="false"
                        format="dd-MM-yyyy"
                    ></el-date-picker>
                </div>
            </div>
        </div>
        <div class="row" v-if="configuration.sale_note_credit_confirm">
            <div
                class="col-md-3 col-lg-3 col-12"
                v-if="user.can_accept_credit_sale_note"
            >
                <el-checkbox v-model="isMigration" @change="setPayment">
                    <strong>
                        Ingresar pagos anteriores
                    </strong>
                </el-checkbox>
            </div>
            <div class="col-md-3 col-lg-3 col-12 d-flex">
                <el-checkbox
                    v-model="credit.is_cash"
                    @change="changeType('cash')"
                    :disabled="true"
                >
                    <strong>
                        Efectivo
                    </strong>
                </el-checkbox>
                <el-checkbox
                    v-model="credit.is_product"
                    :disabled="true"
                    @change="changeType('product')"
                >
                    <strong>
                        Hogar
                    </strong>
                </el-checkbox>
            </div>
            <div
                class="col-md-3 col-lg-3 col-12"
                v-if="user.can_accept_credit_sale_note"
            >
                <label>Usuario</label>
                <el-select
                    v-model="credit.user_id"
                    filterable
                    clearable
                    placeholder="Seleccione un usuario"
                >
                    <el-option
                        v-for="user in users"
                        :key="user.id"
                        :label="user.name"
                        :value="user.id"
                    ></el-option>
                </el-select>
            </div>

            <div class="row">
                <div v-for="(payment, index) in payments" :key="index">
                    <el-checkbox v-model="payment.isPrepayment">
                        Cuota N° {{ index + 1 }}
                    </el-checkbox>
                </div>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <div v-if="form.total" class="d-flex justify-content-end">
                <div>
                    <strong>Monto base: </strong>
                    <span class="h6"
                        >S/.
                        {{ (form.total - credit.advances).toFixed(2) }}</span
                    >
                </div>
                <div style="margin-left:15px;">
                    <strong>
                        Monto más intereses:
                    </strong>
                    <span class="h6">
                        S/.
                        {{
                            (
                                Number(credit.amount) * Number(credit.num_cuota)
                            ).toFixed(2)
                        }}
                    </span>
                </div>
            </div>

            <template v-if="configuration.sale_note_credit_confirm">
                <el-button
                    class="left-button"
                    @click="simulate"
                    type="success"
                    style="margin-right: 15px;"
                    >Simulación</el-button
                >

                <el-checkbox class="left-button" v-model="simulateForm.print"
                    >Impresión</el-checkbox
                >
                <el-checkbox class="left-button" v-model="simulateForm.pdf"
                    >Pdf</el-checkbox
                >
                <el-checkbox class="left-button" v-model="simulateForm.whatsapp"
                    >Whatsapp</el-checkbox
                >
                <el-input
                    class="left-button"
                    v-model="simulateForm.number"
                    placeholder="Teléfono"
                    style="width: 200px; margin-left:15px; "
                    v-if="simulateForm.whatsapp"
                ></el-input>
            </template>
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Enviar</el-button>
        </div>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :external="true"
        >
        </person-form>
    </el-dialog>
</template>
<style scoped>
.dialog-footer .left-button {
    float: left;
}
</style>
<script>
import moment from "moment";

const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
        "user",
        "configuration",
        "items",
        "cash_id",
        "all_customers",
        "showDialog",
        "all_series",
        "establishments"
    ],
    components: { PersonForm },
    data() {
        return {
            simulateForm: {
                whatsapp: false,
                print: true,
                pdf: false,
                number: null
            },
            isService: false,
            isProduct: false,
            users: [],
            payments: [],
            isMigration: false,
            form: {},
            tasaInteres: 17,
            credit: {},
            showDialogNewPerson: false,
            customers: [],
            errors: {},
            resource: "sale-notes",
            loading_search: false,
            percentage_igv: 18,
            loading: false,
            hasProblems: false
        };
    },
    created() {
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });
    },
    watch: {
        all_customers(newCustomer, _) {
            this.customers = newCustomer.filter(n => n.number != "88888888");
        }
    },
    computed: {},
    methods: {
        createPayment(date_of_issue, num_cuota, type_payment) {
            let date = moment(date_of_issue);
            let payments = [];
            for (let i = 0; i < num_cuota; i++) {
                let dias;
                let date_payment;
                switch (type_payment) {
                    case "Diario":
                        dias = 1;
                        date.add(dias, "days");
                        date_payment = date.format("YYYY-MM-DD");
                        break;
                    case "Semanal":
                        dias = 7;
                        date.add(dias, "days");
                        date_payment = date.format("YYYY-MM-DD");
                        break;
                    case "Quincenal":
                        dias = 15;
                        date.add(dias, "days");
                        date_payment = date.format("YYYY-MM-DD");
                        break;
                    case "Mensual":
                        dias = 30;
                        date.add(dias, "days");
                        date_payment = date.format("YYYY-MM-DD");
                        break;
                    case "Unico":
                        date_payment = moment
                            .tz(this.date_of_pay, "America/Lima")
                            .format("YYYY-MM-DD");
                        break;
                }
                if (date.day() === 0) {
                    date.add(1, "days");
                    date_payment = date.format("YYYY-MM-DD");
                }
                payments.push({
                    day: date.day(),
                    date_of_payment: date_payment,
                    amount: this.credit.amount,
                    isPrepayment: false
                });
            }
            return payments;
        },
        simulate() {
            if (!this.validate()) return false;
            let payments = this.createPayment(
                this.form.date_of_issue,
                this.credit.num_cuota,
                this.credit.type_payment
            );

            this.$http
                .post("/sale-notes/simulate", {
                    ...this.form,
                    ...this.credit,
                    prepayments: payments,
                    tasa: this.tasaInteres,
                    whatsapp: this.simulateForm.whatsapp,
                    print: this.simulateForm.print,
                    number: this.simulateForm.number
                })
                .then(response => {
                    this.$toast.success("Simulación realizada correctamente");
                    let { url, success } = response.data;
                    if (success && this.simulateForm.pdf) {
                        window.open(url, "_blank");
                    }
                    // this.$emit("limpiarForm");
                    // this.close();
                })
                .catch(e => {
                    this.$toast.error("Ocurrió un error");
                });
        },
        seeProblems() {},
        async checkCustomerLine() {
            const response = await this.$http.get(
                "/sale-notes/check-customer-line/" + this.form.customer_id
            );
            let data = response.data;
            if (data.has_problems) {
                this.hasProblems = true;
            }
        },
        changeCustomer() {
            if (this.user.can_accept_credit_sale_note) {
                this.hasProblems = false;
                this.checkCustomerLine();
            }
        },
        changeTypePayment() {
            this.$forceUpdate();
            this.calculate();
        },
        changeType(type) {
            if (type == "cash") {
                this.credit.is_product = false;
            } else {
                this.credit.is_cash = false;
            }
        },
        setPayment() {
            if (this.isMigration) {
                let { num_cuota, amount } = this.credit;

                for (let i = 0; i < num_cuota; i++) {
                    this.payments.push({
                        amount,
                        isPrepayment: false
                    });
                }
            } else {
                this.payments = [];
            }
        },
        validate() {
            let flag = true;
            if (this.tasaInteres < 0) {
                this.$toast.error("La tasa de interes no puede ser negativa");
                flag = false;
            }
            if (this.credit.advances > this.form.total) {
                this.$toast.error(
                    "El monto de adelanto no puede ser mayor a la venta total"
                );
                flag = false;
            }
            if (this.credit.month == 0) {
                this.$toast.error("El tiempo no puede ser 0");
                flag = false;
            }

            if (this.form.customer_id == null) {
                this.$toast.error("Debe seleccionar un cliente");
                flag = false;
            }
            return flag;
        },
        initCredit() {
            this.credit = {
                is_product: false,
                is_cash: false,
                num_cuota: 0,
                amount: 0,
                month: 0,
                advances: 0,
                date_of_pay: null
            };
        },
        advances_total() {
            if (this.credit.advances > this.form.total) {
                return this.$toast.error(
                    "el monto de adelanto no puede ser mayor ala venta total"
                );
            } else {
                this.credit.total_balance = (
                    this.form.total - this.credit.advances
                ).toFixed(2);
                this.calculate(this.credit.advances);
            }
        },
        calculate(advance = 0) {
            // let dias = 0;
            console.log(
                "🚀 ~ calculate ~ this.credit.type_payment:",
                this.credit.type_payment
            );
            let tasa_interes = 0;
            if (this.form.total > 0 && this.credit.month > 0) {
                switch (this.credit.type_payment) {
                    case "Diario":
                        this.credit.num_cuota =
                            26 * parseInt(this.credit.month);
                        // dias = 26 * this.form.month;
                        break;
                    case "Semanal":
                        this.credit.num_cuota = 4 * this.credit.month;
                        // dias = 7 * this.credit.month;
                        break;
                    case "Quincenal":
                        this.credit.num_cuota = 2 * this.credit.month;
                        // dias = 15 * this.credit.month;
                        break;
                    case "Mensual":
                        this.credit.num_cuota = this.credit.month;
                        // dias = 30 * this.credit.month;
                        break;
                    default:
                        this.credit.month = 1;
                        this.credit.num_cuota = 1;
                        break;
                }
                if (this.tasaInteres > 0) {
                    let total = parseFloat(this.form.total || "0");
                    let advances = parseFloat(advance || "0");

                    let total_financiar =
                        parseFloat(this.form.total || "0") -
                        parseFloat(this.credit.advances || "0");
                    tasa_interes = this.tasaInteres * this.credit.month || 0;
                    tasa_interes = tasa_interes.toFixed(2);
                    let calcular_cuota =
                        (total_financiar *
                            ((this.tasaInteres * this.credit.month) / 100) +
                            total_financiar) /
                        this.credit.num_cuota;
                    this.credit.amount = calcular_cuota.toFixed(2);
                } else {
                    let amount =
                        (parseInt(this.form.total || "0") -
                            parseFloat(this.credit.advances || "0")) /
                        parseInt(this.credit.num_cuota);
                    this.credit.amount = amount.toFixed(2);
                }
                this.credit.tasadefault = tasa_interes;
            }
            if (this.isMigration) {
                this.payments = [];
                this.setPayment();
            }
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        },

        paymentsOrden() {
            let items = this.items;
            let ordens = items;
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                ordens[i].food.item.from_unit_type_id = item.type_id;
                ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;
                ordens[i].food.item.quantity = item.quantity;
                ordens[i].food.item.lotes = item.lotes;
                ordens[i].food.item.lots = item.series;
                ordens[i].food.item.sale_unit_price = item.price;
                ordens[i].food.price = item.price;
            }
            this.form.items = ordens.map(o => o.food.item);
            this.formatItems(ordens);
        },
        formatItems(ordens) {
            this.form.items = this.form.items.map(i => {
                return {
                    ...i,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value:
                        i.sale_affectation_igv_type_id == 10
                            ? i.sale_unit_price /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price,
                    quantity: i.quantity,
                    aux_quantity: i.quantity,
                    total_base_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price * i.quantity,
                    percentage_igv: this.percentage_igv,
                    total_igv:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_base_isc: 0.0,
                    percentage_isc: 0.0,
                    total_isc: 0.0,
                    total_base_other_taxes: 0.0,
                    percentage_other_taxes: 0.0,
                    total_other_taxes: 0.0,
                    total_taxes:
                        i.sale_affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_value:
                        i.sale_affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.quantity * i.sale_unit_price,
                    total_charge: 0.0,
                    total_discount: 0.0,
                    total: i.sale_unit_price * i.quantity,
                    price_type_id: "01",
                    unit_price: i.sale_unit_price,
                    unit_price_value: i.sale_unit_price,
                    has_igv: i.has_igv,
                    affectation_igv_type_id: i.sale_affectation_igv_type_id,
                    unit_price: i.sale_unit_price,
                    presentation: null,
                    charges: [],
                    discounts: [],
                    attributes: [],
                    affectation_igv_type: i.sale_affectation_igv_type_id
                };
            });
            this.calculateTotal(ordens);
        },
        calculateTotal(ordens) {
            let total_discount = 0;
            let total_charge = 0;
            let total_exportation = 0;
            let total_taxed = 0;
            let total_taxes = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            ordens.forEach(orden => {
                total += _.round(
                    orden.food.item.quantity * orden.food.price,
                    2
                );
            });

            //  total_igv = _.round((total / (1+(this.percentage_igv/100))) * (this.percentage_igv/100), 2);

            this.form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);

                total_taxes += parseFloat(row.total_taxes);
                if (row.sale_affectation_igv_type_id === "10") {
                    total_igv += _.round(
                        parseFloat(row.total_value) *
                            (this.percentage_igv / 100),
                        2
                    );
                    total_value += _.round(row.total_value, 2);
                    total_taxed += parseFloat(row.total_value);
                }
                if (row.sale_affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "30") {
                    total_unaffected += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (row.sale_affectation_igv_type_id === "40") {
                    total_exportation += parseFloat(row.total_value);
                    total_value += _.round(row.total_value, 2);
                }
                if (
                    ["10", "20", "30", "40"].indexOf(
                        row.affectation_igv_type_id
                    ) < 0
                ) {
                    total_free += parseFloat(row.total_value);
                }
            });

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_taxes = _.round(total_taxes, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffsected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_value = _.round(total_value, 2);
            this.form.total = _.round(total, 2);
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.customers = this.all_customers;
                        }
                    });
            } else {
                this.customers = this.all_customers;
            }
        },
        validateUniqueTypePayment() {
            let { type_payment, date_of_pay } = this.credit;
            if (type_payment == "Unico" && !date_of_pay) {
                this.$toast.error("Debe seleccionar una fecha de pago");
                return false;
            }
            return true;
        },
        async submit() {
            if (!this.validateUniqueTypePayment()) return false;
            if (!this.validate()) return false;
            let serie = this.all_series.find(
                serie => serie.document_type_id == "80"
            );

            if (!serie) {
                return this.$toast.error(
                    "No se encontró una serie para el comprobante"
                );
            }
            this.form.series_id = serie.id;
            this.form.establishment_id = this.establishments.id;
            try {
                this.loading = true;
                this.form = {
                    ...this.form,
                    ...this.credit,
                    prepayments: this.payments
                };
                this.form.time_of_issue = moment().format("HH:mm:ss");
                const response = await this.$http.post(
                    `/${this.resource}`,
                    this.form
                );
                if (response.status == 200) {
                    this.$toast.success(
                        "Se el crédito se registró correctamente"
                    );
                    this.$emit("limpiarForm");
                    this.close();
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error");
                this.$emit("");
            } finally {
                this.loading = false;
            }
        },
        async getUsers() {
            const response = await this.$http.get(`/reports/credits/filter`);
            if (response.data) {
                this.users = response.data.users;
            }
        },
        hasService() {
            let items = this.items;
            let hasService = items.some(
                item => item.food.item.unit_type_id == "ZZ"
            );
            this.credit.is_cash = hasService;
            this.credit.is_product = !hasService;
        },
        open() {
            this.simulateForm = {
                whatsapp: false,
                print: true,
                pdf: false
            };
            this.hasProblems = false;
            this.getUsers();
            this.payments = [];
            this.isMigration = false;
            let { rates } = this.configuration;
            rates = parseFloat(rates);
            this.tasaInteres = rates;
            this.initCredit();
            this.customers = this.all_customers;
            this.form = {
                id: null,
                afectar_caja: true,
                restaurant: false,
                series_id: null,
                generate: true,
                prefix: "NV",
                month: 0,
                establishment_id: null,
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                customer_id: null,
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 0,

                advances: 0,
                total_balance: 0,
                total_advances: 0,
                total_prepayment: 0,
                total_charge: 0,
                total_discount: 0,
                total_exportation: 0,
                total_free: 0,
                total_taxed: 0,
                total_unaffected: 0,
                total_exonerated: 0,
                total_igv: 0,
                total_base_isc: 0,
                total_isc: 0,
                total_base_other_taxes: 0,
                total_other_taxes: 0,
                total_taxes: 0,
                total_value: 0,
                total: 0,
                total_rounded: 0,
                total_payment: 0,
                tasadefault: 0,
                operation_type_id: null,
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                additional_information: null,
                actions: {
                    format_pdf: "a4"
                },
                apply_concurrency: false,
                type_period: null,
                quantity_period: 0,
                automatic_date_of_issue: null,
                enabled_concurrency: false,
                license_plate: null,
                paid: false,
                user_id: null,
                observation: null,
                difference: 0,
                type_payment: "Mensual",
                num_cuota: 0,
                amount: 0,
                method_pay: "Efectivo"
            };
            this.paymentsOrden();
            //if (!this.user.can_accept_credit_sale_note) {
            this.hasService();
            //}
            this.credit.month = 1;
            this.credit.type_payment = "Mensual";
            this.calculate();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
