<template>
    <div>
        <el-dialog
            :title="titleDialog"
            :visible="showDialog"
            @open="create"
            width="50%"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
            @close="clickClose"
            :show-close="false"
            append-to-body
        >
            <div class="row" v-loading="loading_documents">
                <div class="col-lg-8">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.document_type_id }"
                    >
                        <label class="control-label">Tipo comprobante</label>
                        <el-select
                            v-model="document.document_type_id"
                            @change="changeDocumentType"
                            popper-class="el-select-document_type"
                            dusk="document_type_id"
                            class="border-left rounded-left border-info"
                        >
                            <el-option
                                v-for="option in document_types"
                                :key="option.id"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                        <small
                            class="text-danger"
                            v-if="errors.document_type_id"
                            v-text="errors.document_type_id[0]"
                        ></small>
                        <!-- <el-checkbox  v-model="generate_dispatch">Generar Guía Remisión</el-checkbox> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.series_id }"
                    >
                        <label class="control-label">Serie</label>
                        <el-select v-model="document.series_id">
                            <el-option
                                v-for="option in series"
                                :key="option.id"
                                :value="option.id"
                                :label="option.number"
                            ></el-option>
                        </el-select>
                        <small
                            class="text-danger"
                            v-if="errors.series_id"
                            v-text="errors.series_id[0]"
                        ></small>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.document_type_id }"
                    >
                        <label class="control-label"
                            >Cliente
                            <a
                                href="#"
                                class="text-primary"
                                @click.prevent="showDialogNewPerson = true"
                                >[+ Nuevo]</a
                            >
                        </label>
                        <el-select
                            ref="cliente"
                            v-model="document.customer_id"
                            filterable
                            remote
                            class="border-left rounded-left border-info"
                            popper-class="el-select-customers"
                            dusk="customer_id"
                            placeholder="Escriba el nombre o número de documento del cliente"
                            :remote-method="searchRemoteCustomers"
                            @keyup.enter.native="keyupCustomer"
                            :loading="loading_search"
                        >
                            <el-option
                                v-for="option in customers"
                                :key="option.id"
                                :value="option.id"
                                :label="option.name"
                            ></el-option>
                        </el-select>

                        <small
                            class="text-danger"
                            v-if="errors.document_type_id"
                            v-text="errors.document_type_id[0]"
                        ></small>
                        <!-- <el-checkbox  v-model="generate_dispatch">Generar Guía Remisión</el-checkbox> -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.operation_type_id }"
                    >
                        <label class="control-label">Tipo Operación </label>
                        <el-select
                            v-model="document.operation_type_id"
                            @change="changeOperationType"
                        >
                            <el-option
                                v-for="option in operation_types"
                                :key="option.id"
                                :value="option.id"
                                :label="option.description"
                            ></el-option>
                        </el-select>
                        <small
                            class="form-control-feedback"
                            v-if="errors.operation_type_id"
                            v-text="errors.operation_type_id[0]"
                        ></small>
                    </div>
                </div>
                <div class="col-lg-12" v-if="document.items.length > 0">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <h6>Detalle</h6>
                            <div class="table-responsive">
                                <table class="table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cantidad</th>
                                            <th>producto</th>
                                            <th>Precio</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row,
                                            index) in document.items"
                                            :key="index"
                                        >
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger"
                                                    @click.prevent="
                                                        clickRemoveItem(index)
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>{{ row.quantity }}</td>
                                            <td>
                                                {{ row.item.description }}
                                                <br /><small>{{
                                                    row.affectation_igv_type
                                                        .description
                                                }}</small>
                                            </td>
                                            <td class="text-center">
                                                {{ row.item.sale_unit_price }}
                                            </td>
                                            <td class="text-end">
                                                {{
                                                    (
                                                        row.quantity *
                                                        row.item.sale_unit_price
                                                    ).toFixed(2)
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tr></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Observaciones</label>
                        <el-input
                            type="textarea"
                            autosize
                            v-model="document.additional_information"
                        >
                            <i slot="prefix" class="el-icon-edit-outline"></i
                        ></el-input>
                    </div>
                </div>
                <div class="col-lg-8 mt-3">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.dipatch_id }"
                    >
                        <!-- <label class="control-label">Tipo comprobante</label> -->
                        <el-checkbox v-model="generate_dispatch"
                            >Generar Guía Remisión</el-checkbox
                        >
                        <el-select
                            v-model="dispatch_id"
                            popper-class="el-select-document_type"
                            filterable
                            class="border-left rounded-left border-info"
                            v-if="generate_dispatch"
                        >
                            <el-option
                                v-for="option in dispatches"
                                :key="option.id"
                                :value="option.id"
                                :label="option.number_full"
                            ></el-option>
                        </el-select>
                        <small
                            class="text-danger"
                            v-if="errors.dipatch_id"
                            v-text="errors.dipatch_id[0]"
                        ></small>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="clickClose">Cerrar</el-button>
                <el-button
                    class="submit"
                    type="primary"
                    @click="submit"
                    :loading="loading_submit"
                    v-if="flag_generate"
                    >Generar</el-button
                >
            </span>

            <document-options
                :showDialog.sync="showDialogDocumentOptions"
                :recordId="documentNewId"
                :generatDispatch="generate_dispatch"
                :dispatchId="dispatch_id"
                :isContingency="false"
                :showClose="true"
                :configuration="configuration"
            >
            </document-options>
            <person-form
                :showDialog.sync="showDialogNewPerson"
                type="customers"
                :external="true"
                :user_id="document.user_id"
                :input_person="input_person"
                :document_type_id="document.document_type_id"
                @add="addRowCliente"
            >
            </person-form>
        </el-dialog>
    </div>
</template>

<script>
import DocumentOptions from "../../documents/partials/options.vue";
import PersonForm from "../../persons/form.vue";

export default {
    components: { DocumentOptions, PersonForm },

    props: ["showDialog", "recordId", "showClose", "showGenerate", "fromCaja","configuration"],
    data() {
        return {
            titleDialog: null,
            loading: false,
            resource: "sale-notes",
            resource_documents: "documents",
            errors: {},
            form: {},
            document: {},
            document_types: [],
            all_document_types: [],
            all_series: [],
            all_customers: [],
            series: [],
            generate: false,
            loading_submit: false,
            loading_documents: false,
            showDialogDocumentOptions: false,
            documentNewId: null,
            flag_generate: true,
            dispatches: [],
            generate_dispatch: false,
            dispatch_id: null,
            loading_search: false,
            has_data_detraction: false,
            customers: [],
            operation_types: [],
            input_person: {},
            showDialogNewPerson: false,
            document_type_03_filter: null
        };
    },
    created() {
        this.initForm();
        this.initDocument();
    },
    methods: {
        initForm() {
            this.generate = this.showGenerate ? true : false;
            this.errors = {};
            this.form = {
                id: null,
                external_id: null,
                identifier: null,
                date_of_issue: null,
                sale_note: null
            };
            this.generate_dispatch = false;
        },
        async changeOperationType() {
            await this.filterCustomers();
            await this.setDataDetraction();
        },
        clickRemoveItem(index) {
            this.document.items.splice(index, 1);
            this.calculateTotal();
        },
        keyupCustomer() {
            if (this.input_person.number) {
                if (!isNaN(parseInt(this.input_person.number))) {
                    switch (this.input_person.number.length) {
                        case 8:
                            this.input_person.identity_document_type_id = "1";
                            this.showDialogNewPerson = true;
                            break;

                        case 11:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                        default:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                    }
                }
            }
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/documents/search/customer/${customer_id}`)
                .then(response => {
                    this.searchRemoteCustomers(response.data.customers.name);
                    //this.customers = response.data.customers
                    this.form.customer_id = customer_id;
                });
        },

        searchRemoteCustomers(input) {
            if (input.length > 0) {
                // if (input!="") {
                this.loading_search = true;
                let parameters = `input=${input}&document_type_id=${this.document.document_type_id}&operation_type_id=${this.document.operation_type_id}&seller_id=${this.document.user_id}`;
                this.$http
                    .get(`/${this.resource}/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        this.input_person.number = null;
                        if (this.customers.length == 0) {
                            this.input_person.number = input;
                            this.filterCustomers();
                        }
                    });
            } else {
                // this.customers = []
                this.filterCustomers();

                this.input_person.number = null;
            }

            // this.filterCustomers()
        },
        addRowCliente(data) {
            //console.log(data)
            this.document.customer_id = data.id;
            this.searchRemoteCustomers(data.number);
        },
        filterCustomers() {
            if (
                this.document.operation_type_id === "0101" ||
                this.document.operation_type_id === "1001"
            ) {
                if (this.document.document_type_id === "01") {
                    let customers_alll = _.filter(this.all_customers, {
                        identity_document_type_id: "6",
                        seller_id: this.document.user_id
                    });
                    this.customers = customers_alll;
                } else {
                    if (this.document_type_03_filter) {
                        this.customers = _.filter(this.all_customers, c => {
                            return c.identity_document_type_id !== "6";
                        });
                    } else {
                        this.customers = this.all_customers;
                    }
                }
            } else {
                this.customers = this.all_customers;
            }
        },
        initDocument() {
            this.document = {
                afectar_caja: false,
                user_id: null,
                payment_condition_id: "01",
                document_type_id: null,
                total_rounded: 0,
                total_payment: 0,
                all_customers: [],
                series_id: null,
                establishment_id: null,
                number: "#",
                date_of_issue: null,
                time_of_issue: null,
                customer_id: null,
                currency_type_id: null,
                purchase_order: null,
                exchange_rate_sale: 0,
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
                operation_type_id: "1001",
                prepayment_deduction: false,
                date_of_due: null,
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                additional_information: null,
                actions: {
                    format_pdf: "a4"
                },
                quotation_id: null,
                sale_note_id: null,
                payments: [],
                hotel: {},
                orden_id: null
            };
        },
        resetDocument() {
            this.generate = this.showGenerate ? true : false;
            this.initDocument();
            this.document.document_type_id =
                this.document_types.length > 0
                    ? this.document_types[0].id
                    : null;
            this.changeDocumentType();
        },
        async submit() {
            let filtrar = this;
            let findCustomer = _.find(this.all_customers, {
                id: this.document.customer_id
            });
            if (
                findCustomer.number.length < 11 &&
                this.document.document_type_id == "01"
            ) {
                return this.$toast.error(
                    "Ingrese un numero de Ruc de 11 digitos valido para emitir Factura "
                );
            }
            if (
                findCustomer.number.length < 8 &&
                this.document.document_type_id == "03"
            ) {
                return this.$toast.error(
                    "Ingrese un numero de DNI de 8 digitos valido para emitir Boleta "
                );
            }
            if (this.generate_dispatch) {
                if (!this.dispatch_id) {
                    return this.$toast.error("Debe seleccionar una guía base");
                }
            }
            this.loading_submit = true;

            this.document.exchange_rate_sale = 1;

            await this.$http
                .post(`/${this.resource_documents}`, this.document)
                .then(response => {
                    if (response.data.success) {
                        this.documentNewId = response.data.data.id;

                        if (this.fromCaja) {
                               this.$http
                            .get(`/${this.resource}/changed/${this.recordId}`)
                            .then(() => {
                                this.$emit("getRecords");
                               
                            });
                               this.showDialogDocumentOptions = true;
                            this.clickClose();
                        } else {
                              this.$http
                            .get(`/${this.resource}/changed/${this.form.id}`)
                            .then(() => {
                                this.$eventHub.$emit("reloadData");
                                this.flag_generate = false;
                            });
                        this.resetDocument();
                            this.showDialogDocumentOptions = true;
                        }
                      

                        // this.clickClose();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        this.$toast.error(error.response.data.message);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        async setDataDetraction() {
            if (this.document.operation_type_id === "1001") {
                this.showDialogDocumentDetraction = true;
                let legend = await _.find(this.form.legends, { code: "2006" });
                if (!legend)
                    this.form.legends.push({
                        code: "2006",
                        value: "Operación sujeta a detracción"
                    });
                this.form.detraction.bank_account = this.company.detraction_account;
            } else {
                _.remove(this.form.legends, { code: "2006" });
                this.document.detraction = {};
            }
        },
        assignDocument() {
            let q = this.form.sale_note;

            if (q.paid == 1 || q.paid == "1") {
                this.document.payment_condition_id = "01";
            } else {
                this.document.payment_condition_id = "02";
            }
            for (let index = 0; index < q.items.length; index++) {
                q.items[index].item.is_stock = "No";
            }
            this.total_plastic_bag_taxes = 0;
            this.document.user_id = q.user_id;
            (this.document.afectar_caja = false),
                (this.document.establishment_id = q.establishment_id);
            this.document.date_of_issue = moment().format("YYYY-MM-DD"); //q.date_of_issue
            this.document.date_of_due = moment().format("YYYY-MM-DD"); //q.date_of_issue
            this.document.time_of_issue = q.time_of_issue;
            this.document.customer_id = q.customer_id;
            this.document.currency_type_id = q.currency_type_id;
            this.document.purchase_order = null;
            this.document.exchange_rate_sale = q.exchange_rate_sale;
            this.document.total_prepayment = q.total_prepayment;
            this.document.total_charge = q.total_charge;
            this.document.total_discount = q.total_discount;
            this.document.total_exportation = q.total_exportation;
            this.document.total_free = q.total_free;
            this.document.total_taxed = q.total_taxed;
            this.document.total_unaffected = q.total_unaffected;
            this.document.total_exonerated = q.total_exonerated;
            this.document.total_igv = q.total_igv;
            this.document.total_base_isc = q.total_base_isc;
            this.document.total_isc = q.total_isc;
            this.document.total_base_other_taxes = q.total_base_other_taxes;
            this.document.total_other_taxes = q.total_other_taxes;
            this.document.total_taxes = q.total_taxes;
            this.document.total_value = q.total_value;
            this.document.total = q.total;
            this.document.operation_type_id = "0101";
            this.document.items = q.items;
            this.document.charges = q.charges;
            this.document.discounts = q.discounts;
            this.document.attributes = [];
            this.document.guides = q.guides;
            this.document.additional_information = null;
            this.document.actions = {
                format_pdf: "a4"
            };
            this.document.sale_note_id = this.form.id;
            this.document.payments = q.payments;
        },
        calculateTotal() {
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
            this.document.items.forEach(row => {
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
                total_plastic_bag_taxes += parseFloat(
                    row.total_plastic_bag_taxes
                );
            });

            this.document.total_exportation = _.round(total_exportation, 2);
            this.document.total_taxed = _.round(total_taxed, 2);
            this.document.total_exonerated = _.round(total_exonerated, 2);
            this.document.total_unaffected = _.round(total_unaffected, 2);
            this.document.total_free = _.round(total_free, 2);
            this.document.total_igv = _.round(total_igv, 2);
            this.document.total_value = _.round(total_value, 2);
            this.document.total_taxes = _.round(total_igv, 2);
            this.document.total_plastic_bag_taxes = isNaN(
                parseFloat(total_plastic_bag_taxes)
            )
                ? 0
                : total_plastic_bag_taxes;
            this.document.total = _.round(
                total + this.document.total_plastic_bag_taxes,
                2
            );
            // if (this.enabled_discount_global)
            //     this.discountGlobal()
            // if (this.prepayment_deduction)
            //     this.discountGlobalPrepayment()
            // if (this.form.operation_type_id === '1001')
            //     this.changeDetractionType()
            // this.setTotalDefaultPayment()
            this.document.total_rounded = 0;
            this.document.total_payment = 0;
        },

        async create() {
            console.log(this.configuration, " la configuracion");
            this.loading_documents = true;
            await this.$http
                .get(`/${this.resource}/option/tables`)
                .then(response => {
                    this.all_document_types =
                        response.data.document_types_invoice;
                    this.all_series = response.data.series;
                    this.all_customers = response.data.customers;
                    this.operation_types = response.data.operation_types;
                    this.document_type_03_filter =
                        response.data.document_type_03_filter;
                    //this.document.operation_type_id = (this.operation_types.length > 0) ? this.operation_types[0].id : null;
                    // this.document.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null;
                    // this.changeDocumentType();
                });

            await this.$http
                .get(`/${this.resource}/record/${this.recordId}`)
                .then(response => {
                    this.form = response.data.data;
                    this.validateIdentityDocumentType();
                    this.assignDocument();
                    this.titleDialog =
                        "Nota de venta registrada: " + this.form.identifier;
                    this.searchRemoteCustomers(
                        response.data.data.sale_note.customer.name
                    );
                    this.document.customer_id =
                        response.data.data.sale_note.customer_id;
                    this.document.user_id =
                        response.data.data.sale_note.user_id;
                });
            // await this.$http
            //     .get(`/${this.resource}/dispatches`)
            //     .then(response => {
            //         this.dispatches = response.data;
            //     });
            this.loading_documents = false;
        },
        changeDocumentType() {
            this.filterSeries();
        },
        async validateIdentityDocumentType() {
            // let identity_document_types = ['0','1']
            // if(identity_document_types.includes(this.form.sale_note.customer.identity_document_type_id)){

            //     this.document_types = _.filter(this.all_document_types,{'id':'03'})

            // }else{
            this.document_types = this.all_document_types;

            // }

            this.document.document_type_id =
                this.document_types.length > 0
                    ? this.document_types[0].id
                    : null;
            await this.changeDocumentType();
        },
        filterSeries() {
            this.document.series_id = null;
            this.series = _.filter(this.all_series, {
                document_type_id: this.document.document_type_id
            });
            this.document.series_id =
                this.series.length > 0 ? this.series[0].id : null;
        },
        clickFinalize() {
            location.href = `/${this.resource}`;
        },
        clickNewQuotation() {
            this.clickClose();
        },
        clickClose() {
            this.$emit("update:showDialog", false);
            this.initForm();
            this.resetDocument();
            this.flag_generate = true;
        },
        clickToPrint() {
            window.open(
                `/downloads/saleNote/sale_note/${this.form.external_id}`,
                "_blank"
            );
        }
    }
};
</script>
