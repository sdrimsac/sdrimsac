<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Lista de créditos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted">A cuenta</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-0">
                        <div class="card-header bg-primary rounded-top">
                            <h6 class="my-0  text-white">
                                Listado de créditos
                            </h6>
                        </div>
                        <div class="data-table-visible-columns"></div>
                        <div class="card-body">
                            <div class="row m-2">
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="client">
                                        Cliente/Personal
                                    </label>
                                    <el-select
                                        ref="cliente"
                                        filterable
                                        remote
                                        popper-class="el-select-customers"
                                        dusk="customer_id"
                                        placeholder="Escriba el nombre o número de documento del cliente"
                                        :remote-method="searchRemoteCustomers"
                                        :loading="loading_search"
                                        @change="changeCustomer"
                                        v-model="form.person_id"
                                    >
                                        <el-option
                                            v-for="option in customers"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="establishment_id">
                                        Establecimiento
                                    </label>
                                    <el-select
                                        v-model="form.establishment_id"
                                        placeholder="Seleccione"
                                    >
                                        <el-option
                                            v-for="item in establishments"
                                            :key="item.id"
                                            :label="item.description"
                                            :value="item.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="date">
                                        Mes
                                    </label>
                                    <el-date-picker
                                        class="w-100"
                                        v-model="form.date"
                                        type="month"
                                        placeholder="Seleccione"
                                        value-format="yyyy-MM"
                                        :picker-options="{
                                            disabledDate(time) {
                                                return (
                                                    time.getTime() > Date.now()
                                                );
                                            }
                                        }"
                                    ></el-date-picker>
                                </div>
                                <div class="col-md-3 col-lg-3 col-12">
                                    <label for="state">Estado</label>
                                    <el-select
                                        v-model="form.paid"
                                        placeholder="Seleccione"
                                    >
                                        <el-option
                                            label="Pagado"
                                            value="1"
                                        ></el-option>
                                        <el-option
                                            label="Pendiente"
                                            value="0"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="row m-2 text-end">
                                <div class="col-12">
                                    <!-- boton para buscar -->
                                    <button
                                        v-if="showPaid"
                                        type="button"
                                        class="btn btn-success"
                                        @click="getItemsOrdenClientId"
                                    >
                                        <i class="fa fa-card"></i>
                                        Pagar
                                        {{
                                            total != 0
                                                ? `S/ ${total.toFixed(2)}`
                                                : ""
                                        }}
                                    </button>
                                    <button
                                        v-if="records.length > 0"
                                        type="button"
                                        class="btn btn-success"
                                        @click="clickDownload"
                                    >
                                        <i class="fa fa-download"></i>
                                        Exportar
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click="getRecords"
                                    >
                                        Buscar
                                    </button>
                                </div>
                            </div>

                            <div
                                class="row
                            table-responsive"
                            >
                                <table class="table" v-if="records.length > 0">
                                    <thead>
                                        <th>#</th>
                                        <th>ESTABLECIMIENTO</th>
                                        <th>FECHA</th>
                                        <th>PRODUCTO</th>
                                        <th>CANTIDAD</th>
                                        <th class="text-center">TOTAL</th>
                                        <th>VENDEDOR</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(record, idx) in records"
                                            :key="idx"
                                        >
                                            <td>{{ idx + 1 }}</td>
                                            <td>{{ record.establishment }}</td>
                                            <td>{{ record.date }}</td>
                                            <td>{{ record.product }}</td>
                                            <td>{{ record.quantity }}</td>
                                            <td class="text-center">
                                                {{ record.price }}
                                            </td>
                                            <td>{{ record.seller }}</td>
                                            <td>
                                                <el-button
                                                    @click="
                                                        clickPrint(record.credit_list_id)
                                                    "
                                                    type="success"
                                                    size="mini"
                                                >
                                                    <i class="fa fa-print"></i>
                                                </el-button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <el-dialog
                    append-to-body
                    :visible.sync="showDialogPrinters"
                    title="Seleccione una impresora"
                >
                    <el-select
                        class="m-2"
                        v-model="printer_id"
                        placeholder="Seleccione una impresora"
                    >
                        <el-option
                            v-for="printer in printers"
                            :key="printer.id"
                            :label="printer.printer"
                            :value="printer.id"
                        ></el-option>
                    </el-select>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="showDialogPrinters = false"
                            >Cancelar</el-button
                        >
                        <el-button type="primary" @click="Printer"
                            >Aceptar</el-button
                        >
                    </span>
                </el-dialog>
            </div>
        </div>
    </div>
</template>

<script>
import { deletable } from "../../mixins/deletable";
import queryString from "query-string";
export default {
    mixins: [deletable],
    props: [
        "company",
        "isAccountant",
        "isClient",
        "typeUser",
        "import_documents",
        "import_documents_second",
        "configuration"
    ],
    components: {},
    data() {
        return {
            showDialogPrinters: false,
            showPaid: false,
            total: 0,
            loading: false,
            resource: "credit-list",
            records: [],
            establishments: [],
            form: {
                paid: "0"
            },
            input_person: {},
            loading_search: false,
            customers: [],
            formDocument: {},
            ordens: [],
            orden_items: [],
            resource_documents: "sale-notes",
            series: [],
            resource_payments: "",
            loading_submit: false,
            list_ordens: [],
            loading_print: true,
            printers: [],
            currentCreditList: null,
            printer_id: null
        };
    },
    created() {
        this.getTables();
        // this.$http.get(`/${this.resource}/tables`)
        //         .then(response => {
        //           this.closeBox=response.data.closebox
        //         })
    },
    mounted() {
        qz.security.setCertificatePromise((resolve, reject) => {
            this.$http
                .get("/api/qz/crt/override", {
                    responseType: "text"
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.data);
                });
        });
        qz.security.setSignaturePromise(toSign => {
            return (resolve, reject) => {
                this.$http
                    .post("/api/qz/signing", {
                        request: toSign
                    })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });
    },
    methods: {
        async Printer() {
            let paperConfig = {
                scaleContent: false
            };

            let printer = this.printers.find(printer => {
                return printer.id == this.printer_id;
            });

            let config = qz.configs.create(printer.printer, paperConfig);
            let linkpdf = `/credit-list/receipt/${this.currentCreditList}/ticket`;
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

            // qz.print(config, data).catch(e => {
            //     this.$toast.error(e.message);
            // });
            for (let index = 0; index < 2; index++) {
                await new Promise(resolve => setTimeout(resolve, 1500));
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            }
        },

        clickPrint(credit_list) {
            this.showDialogPrinters = true;
            this.currentCreditList = credit_list;

            // this.Printer(url);
        },
        setSeries() {
            this.formDocument.series_id = null;
            this.series = _.filter(this.all_series, {
                document_type_id: this.formDocument.document_type_id
            });
            this.series.forEach(s => {
                s.full_number = s.number;
            });
            this.formDocument.series_id =
                this.series.length > 0 ? this.series[0].id : null;
        },

        async clickPayment(form) {
            // this.reCalculateTotal();
            // return;

            this.setSeries();

            let customer = this.customers.find(
                c => c.id == this.form.person_id
            );

            if (!form.series_id) {
                return this.$toast.warning(
                    "El establecimiento no tiene series disponibles para el comprobante"
                );
            }

            if (form.document_type_id === "80") {
                form.prefix = "NV";
                form.paid = 1;
                this.resource_documents = "sale-notes";
                this.resource_payments = "sale_note_payments";
            }

            form.advances = 0.0;
            form.prefix = "NV";
            form.total_advances = 0.0;
            form.total_payment = form.total;
            form.exchange_rate_sale = 1;
            form.list_ordens = this.list_ordens;
            form.currency_type_id = "PEN";
            form.date_of_issue = moment().format("YYYY-MM-DD");
            form.time_of_issue = moment().format("HH:mm:ss");
            form.is_pay_credit_list = true;
            form.payments = [
                {
                    payment_method_type_id: "01",
                    date_of_payment: form.date_of_issue,
                    payment: form.total
                }
            ];

            this.loading_submit = true;
            this.formDocument.items = this.formDocument.items.filter(
                item => Number(item.quantity) > 0
            );

            try {
                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);

                const response = await this.$http.post(
                    `/${this.resource_documents}`,
                    form
                );
                console.log(
                    "🚀 ~ file: index.vue:300 ~ clickPayment ~ response:",
                    response
                );
                let { data } = response;
                if (response.status == 200 && data.data) {
                    let data = response.data.data;
                    let { print_ticket } = data;
                    window.open(`${print_ticket}`, "_blank");
                    this.getRecords();

                    if (response.data.success == true) {
                    }
                }
                let { success, message } = data;
                if (!success) {
                    this.$toast.error(message);
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
        async getItemsOrdenClientId() {
            try {
                await this.$confirm(
                    "¿Desea cancelar la cuenta?",
                    "Advertencia",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                try {
                    this.loading = true;
                    let { person_id } = this.form;
                    if (!person_id) {
                        this.$toast.error(
                            "Debe seleccionar un cliente/personal"
                        );
                        return;
                    }
                    const response = await this.$http.post(
                        `/${this.resource}/records_by_person_to_pay`,
                        this.form
                    );
                    let {
                        data: { records }
                    } = response;
                    this.list_ordens = records.map(o => o.orden_id);
                    //unique list_ordens
                    this.list_ordens = [...new Set(this.list_ordens)];

                    this.paymentsOrden({ items: records });
                    await this.clickPayment(this.formDocument);
                } catch (error) {
                    this.$toast.error("Ocurrió un error");
                } finally {
                    this.loading = false;
                }
            } catch (e) {}

            // this.records = response.data.data;
        },
        async paymentsOrden(form) {
            this.orden_items = form;
            // this.formDocument.printDocument = form.printDocument;
            // this.formDocument.is_room = form.is_room;
            // if (this.formDocument.is_room) {
            //     this.formDocument.is_list_credit = form.is_list_credit;
            //     this.fformDocumentorm.orden_ids = form.orden_ids;
            //     this.formDocument.hotel_rent_item_ids = form.hotel_rent_item_ids;
            //     this.formDocument.is_advance = form.is_advance;
            //     this.formDocument.hotel_rent_id = form.hotel_rent_id;
            //     this.formDocument.hotel_customer_number = form.customer_number;
            // }
            let { items } = form;
            this.ordens = items;
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                this.ordens[i].food.item.from_unit_type_id = item.type_id;
                this.ordens[i].food.item.from_unit_type_id_desc =
                    item.type_description;

                this.ordens[i].food.item.quantity = item.quantity;
                this.ordens[i].food.item.lotes = item.lotes;
                this.ordens[i].food.item.lots = item.series;
                this.ordens[i].food.item.sale_unit_price = item.price;
                this.ordens[i].food.price = item.price;
                // this.ordens[i].food.item.price = item.price;
                this.ordens[i].food.item.toWarehouse = item.toWarehouse;
                this.ordens[i].food.item.consignment_item_id =
                    item.consignment_item_id;
            }

            this.formDocument.items = this.ordens.map(o => o.food.item);
            this.formatItems();
            this.calculateTotal();
            this.formDocument.enter_amount = this.formDocument.total;
            this.formDocument.difference = 0;
            this.formDocument.establishment_id = this.form.establishment_id;
            if (this.formDocument.establishment_id == null) {
                this.formDocument.establishment_id = this.establishments[0].id;
            }
            this.formDocument.customer_id = this.form.person_id;
            this.formDocument.document_type_id = "80";
        },
        formatItems() {
            this.formDocument.items = this.formDocument.items.map(i => {
                return {
                    ...i,
                    attributes: i.attributes || [],
                    toWarehouse: i.toWarehouse || 0,
                    consignment_item_id: i.consignment_item_id,
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
                    affectation_igv_type: i.sale_affectation_igv_type_id
                };
            });
            this.calculateTotal();
        },
        calculateTotal(sale_unit_price = 0) {
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
            this.ordens.forEach(orden => {
                let t = parseFloat(
                    _.round(
                        parseFloat(orden.food.item.quantity) *
                            parseFloat(orden.food.price),
                        2
                    )
                );
                total += t;
            });

            this.formDocument.items.forEach(row => {
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

            this.formDocument.total_exportation = _.round(total_exportation, 2);
            this.formDocument.total_taxed = _.round(total_taxed, 2);
            this.formDocument.total_taxes = _.round(total_taxes, 2);
            this.formDocument.total_exonerated = _.round(total_exonerated, 2);
            this.formDocument.total_unaffsected = _.round(total_unaffected, 2);
            this.formDocument.total_free = _.round(total_free, 2);
            this.formDocument.total_igv = _.round(total_igv, 2);
            this.formDocument.total_value = _.round(total_value, 2);
            this.formDocument.total = _.round(total, 2);
            if (this.ordens.length > 0) {
                if (this.selectOption == 2) {
                    this.ordens[0].food.item.sale_unit_price = sale_unit_price;
                }
            }
        },
        getQueryParameters() {
            return queryString.stringify({ ...this.form });
        },
        clickDownload() {
            let parameters = this.getQueryParameters();
            window.open(
                `/${this.resource}/records_by_person/download?${parameters}`,
                "_blank"
            );
        },
        async getRecords() {
            let { person_id } = this.form;
            if (!person_id) {
                this.$toast.error("Debe seleccionar un cliente/personal");
                return;
            }
            const response = await this.$http.post(
                `/${this.resource}/records_by_person`,
                this.form
            );

            this.records = response.data.data;

            this.total = this.records.reduce(
                (a, b) => a + (Number(b.price) || 0),
                0
            );

            if (this.total > 0 && this.form.paid == "0") {
                this.showPaid = true;
            } else {
                this.showPaid = false;
            }
        },
        changeCustomer() {},
        async searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {

                this.loading_search = true;
                let parameters = `input=${input}`;
                const response = await this.$http.get(
                    `/documents/search/customers?${parameters}`
                );
                this.customers = response.data.customers;
                this.loading_search = false;
                this.input_person.number = null;
            }
        },
        async getTables() {
            const response = await this.$http.get(`/${this.resource}/tables`);

            if (response.status == 200) {
                let { data } = response;
                this.printers = data.printers;
                this.establishments = data.establishments;
                this.all_series = data.series;
            }
        },
        search() {}
    }
};
</script>
