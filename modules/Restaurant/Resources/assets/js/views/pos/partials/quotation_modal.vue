<template>
    <el-dialog
        title="Cotización"
        :visible="showDialog"
        @open="open"
        @close="close"
        v-loading="loading"
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
                <div class="col-md-6">
                    <label>Vencimiento</label>
                    <el-date-picker class="w-100" v-model="form.date_of_due">
                    </el-date-picker>
                </div>
                 <div class="col-md-6">
                    <label>
                        Vendedor
                     
                    </label>
                    <el-select
                        v-model="form.seller_id"
                        filterable

                    >
                        <el-option
                            v-for="(option,idx) in sellers"
                            :key="idx"
                            :value="option.id"
                            :label="option.name"
                        ></el-option>
                    </el-select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Descripción</label>
                    <el-input
                        class="w-100"
                        type="textarea"
                        :rows="2"
                        placeholder="Descripción"
                        v-model="form.description"
                    >
                    </el-input>
                </div>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <span
                v-if="form.total"
                style="margin-right:auto;display:inline-block"
            >
                <h6>S/. {{ form.total.toFixed(2) }}</h6>
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
         <quotation-options
            :showDialog.sync="showDialogOptions"
            :recordId="quotationNewId"
            :showGenerate="false"
            :showClose="true"
            :external="true"
            @close="close"
        ></quotation-options>
    </el-dialog>
</template>

<script>
import moment from "moment";
const QuotationOptions = () =>
    import("../../../../../../../../resources/js/views/quotations/partials/options.vue");
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
export default {
    props: ["items", "cash_id", "all_customers", "showDialog","sellers"],
    components: { PersonForm,QuotationOptions },
    data() {
        return {
            quotationNewId: null,
            form: {},
            showDialogNewPerson: false,
            customers: [],
            resource: "quotations",
            loading_search: false,
            percentage_igv: 18,
            loading: false,
            showDialogOptions: false,
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
            try {
                this.loading = true;
                this.form.time_of_issue = moment().format("HH:mm:ss");
                const response = await this.$http.post(
                    `/${this.resource}`,
                    this.form
                );
                if (response.status == 200) {
                               this.quotationNewId = response.data.data.id;
                    this.$emit("limpiarForm");
                              this.showDialogOptions = true;
                    this.$toast.success('Cotizacion creada con exito');
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
            this.customers = this.all_customers;
            this.form = {
                date_of_issue: new Date(),
                currency_type_id: "PEN",
                exchange_rate_sale: 1,
                establishment_id: 1,
                prefix: "COT",
                purchase_order: null,
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
                operation_type_id: null,
                date_of_due: null,
                delivery_date: null,
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payment_method_type_id: "10",
                additional_information: null,
                shipping_address: null,
                account_number: null,
                terms_condition: null,
                active_terms_condition: false,
                actions: {
                    format_pdf: "a4"
                },
                payments: [],
                sale_opportunity_id: null
            };
            this.paymentsOrden();
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
