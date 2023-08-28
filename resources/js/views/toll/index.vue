yst<template>
    <div v-loading="loading" class="d-flex justify-content-center">
        <div class="card col-lg-8 col-md-12 col-sm-12">
            <div class="d-flex justify-content-between">
                <div class="col-md-3">
                    <label>Impresión directa</label><br />
                    <el-switch
                        v-model="direct_printing"
                        @change="changeConfiguration"
                    >
                    </el-switch>
                </div>
                <el-button
                    class=" text-primary"
                    v-if="elements.length"
                    @click="addElement"
                >
                    Agregar <i class="fas fa-plus"></i>
                </el-button>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div
                    class="w-100 d-flex flex-wrap justify-content-center"
                    v-if="elements.length != 0"
                    style="margin-bottom:10px"
                >
                    <div
                        role="button"
                        @click="selectElement(item)"
                        :class="
                            `col-md-3 col-sm-4  col-6 col-lg-3 ${
                                item.selected ? 'border border-primary' : ''
                            }`
                        "
                        v-for="(item, idx) in elements"
                        :key="idx"
                    >
                        <element-card
                        
                          @reloadData="getRecords"
                         :item="item"></element-card>
                    </div>
                </div>
                <div v-else class="p-3">
                    <span
                        class="text-primary strong"
                        role="button"
                        @click="addElement"
                    >
                        Agregar elementos a la lista
                        <i class="fas fa-plus"></i>
                    </span>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-6 col-12">
                    <label for="number" class="control-label">Documento</label>
                    <el-input
                        class="to_left"
                        style="
                    width:100%;"
                        v-model="documentNumber"
                        :controls="false"
                    >
                        <el-button
                            slot="append"
                            :loading="loading_search"
                            icon="el-icon-search"
                            @click.prevent="searchCustomer"
                        ></el-button>
                    </el-input>
                </div>
                <div class="col-md-6 col-12">
                    <label for="number" class="control-label">Nombres</label>

                    <label class="control-label">Cliente </label>

                    <el-select
                        v-model="form.customer_id"
                        filterable
                        remote
                        popper-class="el-select-customers"
                        clearable
                        placeholder="Nombre o número de documento"
                        :remote-method="searchRemotePersons"
                        :loading="loading_search"
                        @change="changeCustomer"
                    >
                        <el-option
                            v-for="(customer, idx) in customers"
                            :key="idx"
                            :label="customer.name"
                            :value="customer.id"
                        ></el-option>
                    </el-select>

                    <!-- <el-input
                        style="
                    width:100%;"
                        v-model="form.name"
                    >
                    </el-input> -->
                </div>
                <div class="col-md-6 col-12">
                    <label for="number" class="control-label">Placa</label>
                    <el-input
                        style="
                    width:100%;"
                        v-model="form.placa"
                    >
                        <el-button
                            class="text-white"
                            type="primary"
                            v-if="currentElement"
                            slot="append"
                        >
                            {{ currentElement.description }}
                        </el-button>
                    </el-input>
                </div>
                <div
                    class="col-md-6 col-12 d-flex align-items-end"
                    style="margin-top:15px"
                >
                    <div>
                        <el-button @click="sendDocument">Emitir</el-button>
                    </div>
                </div>
            </div>
        </div>
        <form-add
            :elements="elements"
            @reloadData="getRecords"
            :showDialog.sync="showFormElement"
        >
        </form-add>
    </div>
</template>
<style>
.to_left .el-input .el-input__inner {
    text-align: left !important;
}
</style>
<script>
const ElementCard = () => import("./element_card.vue");
const FormAdd = () => import("./form_add.vue");
export default {
    props: ["user", "configuration"],
    components: { FormAdd, ElementCard },
    data() {
        return {
            direct_printing: true,
            resource: "toll",
            elements: [],
            showFormElement: false,
            loading: false,
            form: {},
            series: [],
            timer: null,
            loading_search: false,
            currentElement: null,
            currentCustomer: null,
            documentNumber: null,
            customers: [],
            defaultCustomers: [],
            percentage_igv: 18,
            printer: null
        };
    },
    mounted() {
        this.getTables();
        this.getRecords();
        this.initForm();

        Echo.channel("print_orden").listen(
            `.print-order-${this.configuration.socket_channel}`,
            e => {
                console.log("imprimiendo", e);
                if (e.data.direct_printing == true) {
                    if (e.data.printing == true) {
                        this.Printer(
                            e.data.printer,
                            e.data.print,
                            e.data.copies,
                            e.data.user_id,
                            e.data.multiple_boxes,
                            e.data.typeuser,
                            e.data.printing
                        );
                    }else{
                        let url = e.data.print;
                        window.open(url, "_blank");
                    }
                }
            }
        );
    },
    methods: {
        async changeConfiguration() {
            try {
                this.loading = true;
                const response = await this.$http.post(`/configurations`, {
                    ...this.configuration,
                    print_direct: this.direct_printing
                });
                this.$toast.success("Configuración actualizada");
            } catch (e) {
                this.$toast.error("Ocurrió un problema");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async Printer(Printer, linkpdf, copies) {
            let paperConfig = {
                scaleContent: false
            };

            let config = qz.configs.create(Printer, paperConfig);

            if (!qz.websocket.isActive()) {
                await qz.websocket.connect(config);
            }
            let data = [
                {
                    type: "pdf",
                    format: "file",
                    data: linkpdf
                }
            ];

            qz.print(config, data).catch(e => {
                this.$toast.error(e.message);
            });
            for (let index = 0; index < copies; index++) {
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
        },
        checking() {
            let { placa, customer_id } = this.form;
            let error = false;
            if (!placa) {
                error = true;
                this.$toast.error("La placa es obligatoria.");
            }
            if (!customer_id) {
                error = true;
                this.$toast.error("El cliente es obligatorio");
            }
            if (!this.currentElement) {
                error = true;
                this.$toast.error("Elija un tipo de vehículo");
            }

            return error;
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http(`${this.resource}/tables`);
                this.customers = response.data.customers;
                this.defaultCustomers = response.data.customers;
                this.series = response.data.series;
                this.printer = response.data.printer;
                if (this.customers) {
                    let [customer] = this.customers;
                    this.documentNumber = customer.number;
                }
            } catch (e) {
                this.$toast.error("Ocurrió un problema");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        changeCustomer() {
            this.documentNumber = this.customers.find(
                c => c.id == this.form.customer_id
            ).number;
        },

        async sendDocument() {
            if (this.checking()) {
                return;
            }
            try {
                this.loading = true;
                this.formatItems();
                this.reCalculateTotal();
                await this.clickPayment(this.form);
                this.initForm();
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        initForm() {
            this.form = {
                hotel: {},
                placa: null,
                total_rounded: 0.0,
                total_payment: 0.0,
                additional_information: "",
                afectar_caja: false,
                currency_type_id: "PEN",
                customer_id: 1,
                customer_telephone: null,
                date_of_due: "2023-01-23",
                date_of_issue: "2023-01-23",
                document_type_id: "03",
                establishment_id: 1,
                exchange_rate_sale: 1,
                identity_document_type_id: "1",
                percentage_igv: 18,
                method_pay: "Efectivo",
                number: "#",
                operation_type_id: "0101",
                payment_condition_id: "01",
                payments: [
                    {
                        date_of_payment: "2023-01-23",
                        payment: 6,
                        payment_method_type_id: "01"
                    }
                ],
                series_id: 2,
                purchase_order: null,
                user_id: this.user.id,
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss")
            };

            this.direct_printing = this.configuration.print_direct == 1;
            if (this.defaultCustomers.length != 0) {
                let [customer] = this.defaultCustomers;
                this.form.customer_id = customer.id;
                this.documentNumber = customer.number;
                this.customers = this.defaultCustomers;
            }
        },
        reCalculateTotal() {
            let total_exportation = 0;
            let total_taxed = 0;
            let total_exonerated = 0;
            let total_unaffected = 0;
            let total_free = 0;
            let total_igv = 0;
            let total_value = 0;
            let total = 0;
            let total_plastic_bag_taxes = 0;

            this.form.items.forEach(row => {
                // total_discount += parseFloat(row.total_discount);
                // total_charge += parseFloat(row.total_charge);

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

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_value = _.round(total_value, 2);
            this.form.total_taxes = _.round(total_igv, 2);
            this.form.total_plastic_bag_taxes = _.round(
                total_plastic_bag_taxes,
                2
            );
            // this.form.total = _.round(total, 2)

            this.form.total = _.round(
                total + this.form.total_plastic_bag_taxes,
                2
            );
        },
        formatItems() {
            this.form.items = [this.currentElement].map(i => {
                i.quantity = 1;

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
        },
        selectElement(item) {
            let { id } = item;
            this.currentElement = item;
            this.elements = this.elements.map(e => {
                e.selected = e.id == id;

                return e;
            });
        },
        async clickPayment(form) {
            let customer = this.customers.find(c => c.id == form.customer_id);

            // if (form.customer_telephone != null) {
            //     if (!this.existNumber()) {
            //         this.$toast.error("Número para envío whatsapp inválido");
            //         return;
            //     }
            // }
            if (form.customer_id == null || form.customer_id == "") {
                return this.$toast.error("Elija un cliente");
            }
            if (
                customer.identity_document_type_id == "1" &&
                form.document_type_id == "01"
            ) {
                return this.$toast.error("No puede emitir Factura con DNI");
            }
            if (!form.series_id) {
                return this.$toast.warning(
                    "El establecimiento no tiene series disponibles para el comprobante"
                );
            }

            form.prefix = null;
            let resource_documents = "documents";
            // let resource_payments = "document_payments";
            // let resource_options = this.resource_documents;
            // form.additional_information = `Orden N°${this.orden}`;
            form.advances = 0.0;
            form.total_advances = 0.0;
            form.total_payment = form.total;
            form.payments = [
                {
                    payment_method_type_id: "01",
                    date_of_payment: form.date_of_issue,
                    payment: form.total
                }
            ];

            // form.cash_id = this.cash_id;
            // form.boxes = this.currentPayments;
            // this.addPayment();

            // this.loading_submit = true;
            form.observation = `PLACA ${this.form.placa}`;

            let currentCustomer = this.customers.find(
                c => c.id == this.form.customer_id
            );

            this.form.document_type_id =
                currentCustomer.number.length == 8 ? "03" : "01";

            this.form.series_id = this.series.find(
                s => s.document_type_id == this.form.document_type_id
            ).id;

            try {
                let form_efectivo = {
                    enter_amount: form.enter_amount,
                    difference: form.difference
                };
                // let ordenId = this.idOrden;

                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);

                const response = await this.$http.post(
                    `/${resource_documents}`,
                    form
                );

                this.$toast.success("Documento emitido");
                if (response.status == 200) {
                    if (response.data.success == true) {
                        console.log(response);
                    }
                } else {
                    this.loading_submit = true;
                    this.$alert(
                        "<strong>Ocurrio un error </strong>" +
                            response.statusCode +
                            "<br>" +
                            this.resource_documents,
                        "HTML String",
                        {
                            dangerouslyUseHTMLString: true
                        }
                    );
                }
            } catch (error) {
                console.log(error);
                const response = error.response;
                let {
                    data: { message }
                } = response;

                this.$toast.error(message || "Ocurrió un error");
                this.loading_submit = false;
            }
        },
        addElement() {
            this.showFormElement = true;
        },
        async getRecords() {
            try {
                this.loading = true;
                const response = await this.$http(`${this.resource}/records`);
                this.elements = response.data.records.map(r =>({
                    ...r.item,
                    tollId:r.id
                }));
            } catch (e) {
                this.$toast.error("Ocurrió un problema");
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        async searchRemotePersons(input) {
            if (input.length > 2) {
                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    try {
                        this.currentCustomer = null;
                        this.loading_search = true;
                        const response = await this.$http(
                            `/toll/${input}?name=true`
                        );

                        if (response.status == 200) {
                            let { data: customers, message } = response;

                            if (customers) {
                                console.log(customers);
                                this.customers = customers.customers;
                            } else {
                                this.$toast.error(message);
                            }
                        }
                    } catch (e) {
                        this.$toast.error("No se pudo obtener los datos");
                    } finally {
                        this.loading_search = false;
                    }
                }, 250);
            }
        },
        async searchCustomer() {
            if (this.documentNumber == null || this.documentNumber == "")
                return;
            if (
                this.documentNumber.length != 8 &&
                this.documentNumber.length != 11
            ) {
                this.$toast.error("Ingrese un documento válido");
                return;
            }
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(async () => {
                try {
                    this.currentCustomer = null;
                    this.loading_search = true;
                    const response = await this.$http(
                        `/toll/${this.documentNumber}`
                    );

                    if (response.status == 200) {
                        let { data: customers, message } = response;

                        if (customers) {
                            this.customers = customers.customers;
                            if (this.customers.length != 0) {
                                let [customer] = this.customers;
                                this.form.customer_id = customer.id;
                            }
                        } else {
                            this.$toast.error(message);
                        }
                        // this.form.name =
                        //     type == "dni"
                        //         ? data.nombre_completo
                        //         : data.nombre_o_razon_social;
                        // this.$forceUpdate();
                    } else {
                    }
                } catch (e) {
                    this.$toast.error("No se pudo obtener los datos");
                } finally {
                    this.loading_search = false;
                }
            }, 250);
        }
    }
};
</script>
