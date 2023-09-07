<template>
    <el-dialog
        title="Crédito"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
        width="950px"
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
                    >
                        <el-option
                            v-for="option in customers"
                            :key="option.id"
                            :value="option.id"
                            :label="option.description"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-md-6">
                    <label>Fecha de emisión</label>
                    <el-date-picker
                        class="w-100"
                        value-format="Y-m-d"
                        v-model="form.date_of_issue"
                    >
                    </el-date-picker>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label w-100">Tiempo (Mes)</label>
                        <el-input-number
                            v-model="credit.month"
                            :disabled="disabled_month"
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

                <div class="col-md-4">
                    <label class="control-label w-100"
                        >Cronograma de Pago
                        <span class="text-danger">*</span></label
                    >
                    <el-radio-group
                        v-model="credit.type_payment"
                        size="mini"
                        @change="calculate"
                    >
                        <el-radio-button label="Diario"></el-radio-button>
                        <el-radio-button label="Semanal"></el-radio-button>
                        <el-radio-button label="Mensual"></el-radio-button>
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

                <!-- <div class="col-md-12">
                    <label>Descripción</label>
                    <el-input
                        class="w-100"
                        type="textarea"
                        :rows="2"
                        placeholder="Descripción"
                        v-model="form.description"
                    >
                    </el-input>
                </div> -->
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <span
                v-if="form.total"
                style="margin-right:auto;display:inline-block"
            >
                <h6>S/. {{ form.total }}</h6>
            </span>
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

<script>
import moment from "moment";
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: [
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
            form: {},
            tasaInteres: 17,
            disabled_month: false,
            credit: {},
            showDialogNewPerson: false,
            customers: [],
            errors: {},
            resource: "sale-notes",
            loading_search: false,
            percentage_igv: 18,
            loading: false
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
    methods: {
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
                num_cuota: 0,
                amount: 0,
                month: 0,
                advances: 0
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
                    case "Mensual":
                        this.credit.num_cuota = this.credit.month;
                        // dias = 30 * this.credit.month;
                        break;
                }
                if (this.tasaInteres > 0) {
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
                        parseInt(this.form.total) /
                        parseInt(this.credit.num_cuota);
                    this.credit.amount = amount.toFixed(2);
                }
                this.credit.tasadefault = tasa_interes;
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
        async submit() {
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
                    ...this.credit
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
        open() {
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
                type_payment: "Diario",
                num_cuota: 0,
                amount: 0,
                method_pay: "Efectivo"
            };
            this.paymentsOrden();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
