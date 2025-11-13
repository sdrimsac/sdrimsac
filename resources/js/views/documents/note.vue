<template>
    <div class="card mb-0">
        <div class="card-header bg-primary text-white" style="padding: 10px;">
            <h4 class="mb-0" style="color: #fff; font-weight: bold;">
                <i class="fa fa-file-alt me-2"></i>
                Nueva Nota de Crédito ({{ document.series }}-{{ document.number }})
            </h4>
        </div>
        <div class="card-body" :class="{ 'document-generated': documentGenerated }">
            <form autocomplete="off" @submit.prevent="submit" :class="{ 'form-disabled': documentGenerated }">
                <div class="form-body">
                    <!-- <div class="row">
                        <div class="col-md-12 text-end">
                            <el-checkbox
                                v-model="is_contingency"
                                @change="changeDocumentType"
                                >¿Es comprobante de contigencia?</el-checkbox
                            >
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group" :class="{
                                'has-danger': errors.document_type_id
                            }">
                                <label class="control-label">Tipo comprobante</label>
                                <el-select v-model="form.document_type_id" @change="changeDocumentType">
                                    <el-option v-for="option in document_types" :key="option.id" :value="option.id"
                                        :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.document_type_id"
                                    v-text="errors.document_type_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" :class="{ 'has-danger': errors.series_id }">
                                <label class="control-label">Serie</label>
                                <el-select v-model="form.series_id">
                                    <el-option v-for="option in series" :key="option.id" :value="option.id"
                                        :label="option.number"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.series_id"
                                    v-text="errors.series_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <template v-if="form.document_type_id === '08'">
                                <div class="form-group" :class="{
                                    'has-danger':
                                        errors['note.note_debit_type_id']
                                }">
                                    <label class="control-label">Tipo Nota de Débito</label>
                                    <el-select v-model="form.note_credit_or_debit_type_id
                                        " clearable filterable>
                                        <el-option v-for="option in note_debit_types" :key="option.id"
                                            :value="option.id" :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors['note.note_debit_type_id']"
                                        v-text="errors['note.note_debit_type_id'][0]
                                            "></small>
                                </div>
                            </template>
                            <template v-else>
                                <div class="form-group" :class="{
                                    'has-danger':
                                        errors['note.note_credit_type_id']
                                }">
                                    <label class="control-label">Tipo Nota de Crédito</label>
                                    <el-select v-model="form.note_credit_or_debit_type_id
                                        ">
                                        <el-option v-for="option in note_credit_types" :key="option.id"
                                            :value="option.id" :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="
                                        errors['note.note_credit_type_id']
                                    " v-text="errors[
                                        'note.note_credit_type_id'
                                    ][0]
                                        "></small>
                                </div>
                            </template>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group" :class="{
                                'has-danger':
                                    errors['note.note_description']
                            }">
                                <label class="control-label">Motivo</label>
                                <el-input v-model="form.note_description">
                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                <small class="form-control-feedback" v-if="errors['note.note_description']"
                                    v-text="errors['note.note_description'][0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Formato de PDF</label>
                                <el-select v-model="form.actions.format_pdf">
                                    <el-option key="a4" value="a4" label="Tamaño A4"></el-option>
                                    <el-option key="ticket" value="ticket" label="Tamaño Ticket"></el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" :class="{ 'has-danger': errors.customer_id }">
                                <label class="control-label">Cliente</label>
                                <el-select v-model="form.customer_id" filterable :disabled="true">
                                    <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                        :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.customer_id"
                                    v-text="errors.customer_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" :class="{
                                'has-danger': errors.currency_type_id
                            }">
                                <label class="control-label">Moneda</label>
                                <el-select v-model="form.currency_type_id" :disabled="true">
                                    <el-option v-for="option in currency_types" :key="option.id" :value="option.id"
                                        :label="option.description"></el-option>
                                </el-select>
                                <small class="form-control-feedback" v-if="errors.currency_type_id"
                                    v-text="errors.currency_type_id[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" :class="{ 'has-danger': errors.date_of_issue }">
                                <label class="control-label">Fec. Emisión</label>
                                <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd"
                                    :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                <small class="form-control-feedback" v-if="errors.date_of_issue"
                                    v-text="errors.date_of_issue[0]"></small>
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <div class="form-group" :class="{ 'has-danger': errors.purchase_order }">
                                <label class="control-label">Orden Compra</label>
                                <el-input v-model="form.purchase_order">
                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                <small class="form-control-feedback" v-if="errors.purchase_order"
                                    v-text="errors.purchase_order[0]"></small>
                            </div>
                        </div> -->
                        <div class="col-md-2">
                            <div class="form-group" :class="{
                                'has-danger': errors.exchange_rate_sale
                            }">
                                <label class="control-label">Tipo de cambio
                                    <el-tooltip class="item" effect="dark"
                                        content="Tipo de cambio del día, extraído de SUNAT" placement="top-end">
                                        <i class="fa fa-info-circle"></i>
                                    </el-tooltip>
                                </label>
                                <el-input v-model="form.exchange_rate_sale">
                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                <small class="form-control-feedback" v-if="errors.exchange_rate_sale"
                                    v-text="errors.exchange_rate_sale[0]"></small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" v-if="form.items.length > 0">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th class="ct-header ct-cod">#</th>
                                            <th class="ct-header ct-desc">Descripción</th>
                                            <th class="ct-header ct-unit">Unidad</th>
                                            <th class="ct-header ct-cant">Cantidad</th>
                                            <th class="ct-header ct-price">Precio Unitario</th>
                                            <th class="ct-header ct-discount">Descuento</th>
                                            <th class="ct-header ct-charge">Cargo</th>
                                            <th class="ct-header ct-total">Total</th>
                                            <th class="ct-header ct-actions">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(row, index) in form.items" :key="index" :class="{ 'ct-row-alt': index % 2 === 0 }">
                                            <td class="ct-cod">{{ index + 1 }}</td>
                                            <td class="ct-desc">
                                                <span class="ct-desc-main">{{ row.item.description }}</span>
                                                <br />
                                                <span class="ct-desc-sub">{{ row.affectation_igv_type.description }}</span>
                                            </td>
                                            <td class="ct-unit">{{ row.item.unit_type_id }}</td>
                                            <td class="ct-cant">{{ parseFloat(row.quantity).toFixed(2) }}</td>
                                            <td class="ct-price">{{ currency_type.symbol }}{{ parseFloat(row.unit_price).toFixed(2) }}</td>
                                            <td class="ct-discount">{{ currency_type.symbol }}{{ row.total_discount }}</td>
                                            <td class="ct-charge">{{ currency_type.symbol }}{{ row.total_charge }}</td>
                                            <td class="ct-total">{{ currency_type.symbol }}{{ row.total }}</td>
                                            <td class="ct-actions">
                                                <button type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-danger"
                                                    @click.prevent="clickRemoveItem(index)">
                                                    x
                                                </button>
                                                <button type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-info" @click.prevent="ediItem(row, index)">
                                                    <span style="font-size:10px;">&#9998;</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">

                            </div>
                            <div class="col-4">
                                <div class="col-md-12">
                            <hr />
                            <p class="text-end" v-if="form.total_exportation > 0">
                                OP.EXPORTACIÓN: {{ currency_type.symbol }}
                                {{ form.total_exportation }}
                            </p>
                            <p class="text-end" v-if="form.total_free > 0">
                                OP.GRATUITAS: {{ currency_type.symbol }}
                                {{ form.total_free }}
                            </p>
                            <p class="text-end" v-if="form.total_unaffected > 0">
                                OP.INAFECTAS: {{ currency_type.symbol }}
                                {{ form.total_unaffected }}
                            </p>
                            <p class="text-end" v-if="form.total_exonerated > 0">
                                OP.EXONERADAS: {{ currency_type.symbol }}
                                {{ form.total_exonerated }}
                            </p>
                            <p class="text-end" v-if="form.total_taxed > 0">
                                OP.GRAVADA: {{ currency_type.symbol }}
                                {{ form.total_taxed }}
                            </p>
                            <p class="text-end" v-if="form.total_igv > 0">
                                IGV: {{ currency_type.symbol }}
                                {{ form.total_igv }}
                                
                            </p>
                            <p>
                               <hr />
                            </p>
                            <h6 class="text-end" v-if="form.total > 0">
                                <b>TOTAL A PAGAR: </b>{{ currency_type.symbol }} {{ form.total }}
                            </h6>
                        </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </form>
            
            <!-- Botones fuera del formulario para que no se deshabiliten -->
            <div class="form-actions d-flex justify-content-end pt-2 pb-2">
                <el-button class="btn_cancelarsmall" type="primary" @click.prevent="close()">
                    {{ documentGenerated ? 'Cerrar' : 'Cancelar' }}
                </el-button>
                <el-button class="btn_guardarsmall" type="primary" @click.prevent="submit" :loading="loading_submit"
                    v-if="form.items.length > 0 && form.total > 0 && !documentGenerated">Generar</el-button>
            </div>
        </div>

        <document-form-item :showDialog.sync="showDialogAddItem" :recordItem="recordItem"
            :isEditItemNote="isEditItemNote" :operation-type-id="form.operation_type_id"
            :currency-type-id-active="form.currency_type_id" :user="user" :exchange-rate-sale="form.exchange_rate_sale"
            :configuration="configuration" :editNameProduct="configuration.edit_name_product"
            @add="addRow"></document-form-item>

        <document-options :showDialog.sync="showDialogOptions" :recordId="documentNewId"
            :showClose="false"></document-options>
    </div>
</template>

<script>
import DocumentFormItem from "./partials/item.vue";
import DocumentOptions from "../documents/partials/options.vue";
import { functions, exchangeRate } from "../../mixins/functions";
import Swal from "sweetalert2";

export default {
    components: { DocumentFormItem, DocumentOptions },
    mixins: [functions, exchangeRate],
    props: ["document_affected", "configuration", "external"],
    data() {
        return {
            recordItem: null,
            isEditItemNote: false,
            showDialogAddItem: false,
            showDialogOptions: false,
            loading_submit: false,
            resource: "documents",
            errors: {},
            form: {},
            document_types: [],
            currency_types: [],
            customers: [],
            all_series: [],
            series: [],
            currency_type: {},
            documentNewId: null,
            note_credit_types: [],
            note_debit_types: [],
            user: {},
            document: {},
            operation_types: [],
            is_contingency: false,
            isCreditNote: true,
            documentGenerated: false // Controla si ya se generó el documento
        };
    },
    computed: {
        hasDiscounts: function () {
            return parseFloat(this.document_affected.total_discount) > 0;
        }
    },
    created() {
        this.checkDocumentStatus();
        this.initComponent();
    },
    mounted() { },
    methods: {
        initComponent() {
            this.document = this.document_affected;
            this.initForm();
            this.$http.get(`/${this.resource}/tables`).then(response => {
                this.document_types = response.data.document_types_note;
                this.currency_types = response.data.currency_types;
                this.all_series = response.data.series;
                // this.customers = response.data.customers
                this.note_credit_types = response.data.note_credit_types;
                this.note_debit_types = response.data.note_debit_types;
                this.operation_types = response.data.operation_types;
                this.user = response.data.user;

                this.currency_type = _.find(this.currency_types, {
                    id: this.form.currency_type_id
                });
                this.form.document_type_id =
                    this.document_types.length > 0
                        ? this.document_types[0].id
                        : null;
                this.form.operation_type_id =
                    this.operation_types.length > 0
                        ? this.operation_types[0].id
                        : null;

                this.changeDocumentType();
                this.changeDateOfIssue();
            });

            this.getCustomer();
        },
        async initForm() {
            this.errors = {};
            
            this.form = {
                user_id: 1,
                affect_cash: false,
                afectar_caja: false,
                additional_information: null,
                establishment_id: this.document.establishment_id,
                document_type_id: null,
                series_id: null,
                number: "#",
                total_rounded: 0,
                total_payment: 0,
                date_of_issue: moment().format("YYYY-MM-DD"),
                date_of_due: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                customer_id: this.document.customer_id,
                currency_type_id: this.document.currency_type_id,
                purchase_order: null,
                exchange_rate_sale: 0,
                total_prepayment: this.document.total_prepayment,
                total_charge: this.document.total_charge,
                total_discount: 0,
                total_exportation: 0, // Se recalculará
                total_free: 0, // Se recalculará  
                total_taxed: 0, // Se recalculará
                total_unaffected: 0, // Se recalculará
                total_exonerated: 0, // Se recalculará
                total_igv: 0, // Se recalculará
                total_base_igv: 0, // Se recalculará - agregado
                total_base_isc: this.document.total_base_isc,
                total_isc: this.document.total_isc,
                total_base_other_taxes: this.document.total_base_other_taxes,
                total_other_taxes: this.document.total_other_taxes,
                total_plastic_bag_taxes: this.document.total_plastic_bag_taxes,
                total_taxes: 0, // Se recalculará
                total_value: 0, // Se recalculará
                total: 0, // Se recalculará
                items: this.document.items,
                affected_document_id: this.document.id,
                note_credit_or_debit_type_id: null,
                note_description: null,
                actions: {
                    format_pdf: "a4"
                },
                operation_type_id: null,
                hotel: {}
            };

            await this.form.items.forEach(item => {
                
                // Si el documento original tiene descuentos, calcular el precio unitario efectivo
                if (this.hasDiscounts) {
                    
                    // Verificar si este item específico tiene descuento
                    let itemHasDiscount = parseFloat(item.total_discount) > 0;
                    
                    if (itemHasDiscount) {
                        // Caso 1: El item tiene descuento específico
                        let totalAfterDiscount = parseFloat(item.total) - parseFloat(item.total_discount);
                        let effectiveUnitPrice = totalAfterDiscount / parseFloat(item.quantity);
                        
                        item.input_unit_price_value = _.round(effectiveUnitPrice, 2);
                        item.unit_price = _.round(effectiveUnitPrice, 2);
                        
                        // Recalcular valores basados en el precio efectivo
                        let subtotal = parseFloat(item.quantity) * effectiveUnitPrice;
                        
                        // Determinar el tipo de afectación del IGV
                        if (item.affectation_igv_type_id === "10") { // Gravado
                            item.total_value = _.round(subtotal / 1.18, 2);
                            item.total_igv = _.round(subtotal - item.total_value, 2);
                            item.total = _.round(subtotal, 2);
                            item.total_base_igv = _.round(item.total_value, 2); // Agregar para gravado
                            item.unit_value = _.round(effectiveUnitPrice / 1.18, 6); // Valor unitario sin IGV
                        } else {
                            // Para productos exonerados, inafectos, etc.
                            item.total_value = _.round(subtotal, 2);
                            item.total_igv = 0;
                            item.total = _.round(subtotal, 2);
                            item.total_base_igv = _.round(subtotal, 2); // Agregar para exonerado/inafecto
                            item.unit_value = _.round(effectiveUnitPrice, 6); // Valor unitario (sin IGV ya que está exonerado)
                        }
                        
                        // Resetear descuentos ya que están incluidos en el nuevo precio
                        item.total_discount = 0;
                        item.total_charge = 0;
                        
                    } else {
                        // Caso 2: El descuento está a nivel general del documento
                        
                        // Calcular la proporción de descuento para este item
                        let documentSubtotal = parseFloat(this.document_affected.total_taxed) + 
                                             parseFloat(this.document_affected.total_exonerated) + 
                                             parseFloat(this.document_affected.total_unaffected);
                        let documentDiscount = parseFloat(this.document_affected.total_discount);
                        let discountRate = documentDiscount / documentSubtotal;
                        
                        
                        // Aplicar la proporción de descuento a este item
                        let itemSubtotal = parseFloat(item.total);
                        let itemDiscountAmount = itemSubtotal * discountRate;
                        let totalAfterDiscount = itemSubtotal - itemDiscountAmount;
                        let effectiveUnitPrice = totalAfterDiscount / parseFloat(item.quantity);
                        
                        
                        item.input_unit_price_value = _.round(effectiveUnitPrice, 2);
                        item.unit_price = _.round(effectiveUnitPrice, 2);
                        
                        // Recalcular valores basados en el precio efectivo
                        let subtotal = parseFloat(item.quantity) * effectiveUnitPrice;
                        
                        // Determinar el tipo de afectación del IGV
                        if (item.affectation_igv_type_id === "10") { // Gravado
                            item.total_value = _.round(subtotal / 1.18, 2);
                            item.total_igv = _.round(subtotal - item.total_value, 2);
                            item.total = _.round(subtotal, 2);
                            item.total_base_igv = _.round(item.total_value, 2); // Agregar para gravado
                            item.unit_value = _.round(effectiveUnitPrice / 1.18, 6); // Valor unitario sin IGV
                        } else {
                            // Para productos exonerados, inafectos, etc.
                            item.total_value = _.round(subtotal, 2);
                            item.total_igv = 0;
                            item.total = _.round(subtotal, 2);
                            item.total_base_igv = _.round(subtotal, 2); // Agregar para exonerado/inafecto
                            item.unit_value = _.round(effectiveUnitPrice, 6); // Valor unitario (sin IGV ya que está exonerado)
                        }
                        
                        item.total_discount = 0;
                        item.total_charge = 0;
                    
                    }
                } else {
                    
                    item.input_unit_price_value = item.unit_price;
                }
                item.additional_information = null;
                item.IdLoteSelected = item.item.IdLoteSelected;
            });
            
            // Recalcular totales después de ajustar precios por descuentos
            this.calculateTotal();
            this.validateHasDiscounts();
        },
        clickAddItemNote() {
            this.recordItem = null;
            this.isEditItemNote = false;
            this.showDialogAddItem = true;
        },
        ediItem(row, index) {
            row.indexi = index;
            this.recordItem = row;
            this.isEditItemNote = true;
            this.showDialogAddItem = true;
        },
        async resetForm() {
            await this.getNote();
            await this.initForm();
            this.form.operation_type_id =
                this.operation_types.length > 0
                    ? this.operation_types[0].id
                    : null;
            this.form.document_type_id =
                this.document_types.length > 0
                    ? this.document_types[0].id
                    : null;
            this.changeDocumentType();
            this.changeDateOfIssue();
        },
        getNote() {
            this.$http
                .get(
                    `/${this.resource}/note/record/${this.form.affected_document_id}`
                )
                .then(response => {
                    // console.log(response)
                    this.document = response.data;
                });
        },
        changeDocumentType() {
            this.form.note_credit_or_debit_type_id = null;
            this.form.series_id = null;
            if (this.is_contingency) {
                this.series = _.filter(this.all_series, {
                    document_type_id: this.form.document_type_id,
                    contingency: this.is_contingency
                });
            } else {
                let document_type = _.find(this.document_types, {
                    id: this.form.document_type_id
                });
                let firstChar = this.document.group_id === "01" ? "F" : "B";
                this.series = _.filter(this.all_series, s => {
                    return (
                        s.document_type_id === document_type.id &&
                        s.number.substr(0, 1) === firstChar
                    );
                });

                // Autoselección de serie para nota de crédito
                if (this.form.document_type_id == "07" && this.document.series) {
                    let originalSeries = this.document.series;
                    let prefix = originalSeries.substr(0, 1); // B o F
                    let number = originalSeries.substr(1); // 043 o 001
                    let targetSeries = "";
                    if (prefix === "B") {
                        targetSeries = `BC${number.substr(number.length - 2)}`;
                    } else if (prefix === "F") {
                        targetSeries = `FC${number.substr(number.length - 2)}`;
                    }
                    let found = this.series.find(s => s.number === targetSeries);
                    if (found) {
                        this.form.series_id = found.id;
                    } else {
                        this.form.series_id = this.series.length > 0 ? this.series[0].id : null;
                    }
                } else {
                    this.form.series_id = this.series.length > 0 ? this.series[0].id : null;
                }
            }

            this.isCreditNote = this.form.document_type_id == "07";
        },
        changeDateOfIssue() {
            this.searchExchangeRateByDate(this.form.date_of_issue).then(
                response => {
                    this.form.exchange_rate_sale = response;
                }
            );
        },
        addRow(row) {
            if (this.recordItem) {
                this.form.items[this.recordItem.indexi] = row;
                this.recordItem = null;
            } else {
                this.form.items.push(JSON.parse(JSON.stringify(row)));
            }

            // this.form.items.push(row)
            this.calculateTotal();
        },
        clickRemoveItem(index) {
            this.form.items.splice(index, 1);
            this.calculateTotal();
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
            this.form.items.forEach(row => {
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
                total_value += parseFloat(row.total_value);
                total_igv += parseFloat(row.total_igv);
                total += parseFloat(row.total);
                total_plastic_bag_taxes += parseFloat(
                    row.total_plastic_bag_taxes
                );
            });

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_base_igv = _.round(total_taxed + total_exonerated + total_unaffected + total_exportation, 2); // Base para IGV
            this.form.total_value = _.round(total_value, 2);
            this.form.total_taxes = _.round(total_igv, 2);
            this.form.total_plastic_bag_taxes = _.round(
                total_plastic_bag_taxes,
                2
            );
            // this.form.total = _.round(total, 2)
            this.form.total =
                _.round(total, 2) + this.form.total_plastic_bag_taxes;
                
            // Debug logs para verificar los cálculos
            console.log('Calculated totals:', {
                total_taxed: this.form.total_taxed,
                total_exonerated: this.form.total_exonerated,
                total_unaffected: this.form.total_unaffected,
                total_exportation: this.form.total_exportation,
                total_base_igv: this.form.total_base_igv,
                total_igv: this.form.total_igv,
                total: this.form.total
            });
        },
        async validateHasDiscounts() {
            console.log(this.isCreditNote, " ", this.hasDiscounts);
            // Ya no necesitamos limpiar los productos porque ahora calculamos automáticamente 
            // los precios con descuento incluido en initForm()
            if (this.isCreditNote && this.hasDiscounts) {
                // Mensaje informativo sobre el ajuste automático
                this.$toast.info(
                    "Descuentos detectados: Los precios han sido ajustados automáticamente al valor efectivamente pagado"
                );
            }
        },
        async submit() {
            // Preguntar si desea afectar la caja antes de continuar
            if (this.isCreditNote) {
                const result = await Swal.fire({
                    title: "¿Desea afectar la caja origen donde fue emitido el documento?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Sí",
                    cancelButtonText: "No",
                    reverseButtons: true
                });
                this.form.affect_cash = result.isConfirmed;
            }

            if (
                this.isCreditNote &&
                this.hasDiscounts &&
                this.form.total > this.document.total
            ) {
                return this.$toast.error(
                    `El monto total de la nota de credito debe ser menor o igual al monto del documento relacionado (${this.document.total})`
                );
            }

            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        // Marcar el documento como generado para evitar múltiples generaciones
                        this.documentGenerated = true;
                        
                        // Guardar en localStorage para persistir después de recargas
                        const affectedDocumentId = this.form.affected_document_id;
                        if (affectedDocumentId) {
                            const generatedKey = `document_generated_${affectedDocumentId}`;
                            localStorage.setItem(generatedKey, 'true');
                        }
                        
                        // Mostrar mensaje de éxito
                        this.$toast.success("Nota de crédito generada exitosamente");
                        
                        if (!this.external) {
                            // No resetear el formulario, solo almacenar el ID y mostrar opciones
                            this.documentNewId = response.data.data.id;
                            this.showDialogOptions = true;
                        } else {
                            this.$emit("success");
                        }
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                        // Mostrar todos los mensajes de error en alertas
                        if (error.response.data.errors) {
                            Object.values(error.response.data.errors).forEach(messages => {
                                messages.forEach(msg => {
                                    this.$toast.error(msg);
                                });
                            });
                        }
                    } else {
                        this.$toast.error(error.response.data.message);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        getCustomer() {
            this.$http
                .get(
                    `/${this.resource}/search/customer/${this.document.customer_id}`
                )
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = this.document.customer_id;
                });
        },
        checkDocumentStatus() {
            // Verificar si ya existe una nota de crédito para este documento
            const affectedDocumentId = this.document_affected?.id;
            if (affectedDocumentId) {
                // Verificar en localStorage si ya se generó
                const generatedKey = `document_generated_${affectedDocumentId}`;
                const wasGenerated = localStorage.getItem(generatedKey);
                
                if (wasGenerated === 'true') {
                    this.documentGenerated = true;
                    console.log('Document was already generated, blocking form');
                }
                
                // Alternativamente, podrías hacer una consulta al backend para verificar
                // si ya existe una nota de crédito para este documento
                /*
                this.$http.get(`/documents/check-credit-note/${affectedDocumentId}`)
                .then(response => {
                    if (response.data.has_credit_note) {
                        this.documentGenerated = true;
                    }
                });
                */
            }
        },
        close() {
            // Opcional: limpiar el localStorage al cerrar correctamente
            // const affectedDocumentId = this.document_affected?.id;
            // if (affectedDocumentId) {
            //     const generatedKey = `document_generated_${affectedDocumentId}`;
            //     localStorage.removeItem(generatedKey);
            // }
            
            if (this.external) {
                this.$emit("close");
            } else {
                location.href = "/documents";
            }
        }
    }
};
</script>

<style scoped>
.custom-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}
.custom-table thead {
    background: #073f68;
}
.ct-header {
    color: #fff;
    font-weight: bold;
    padding: 12px 8px;
    border: none;
    font-size: 1.1em;
}
.ct-cod {
    width: 110px;
    text-align: left;
}
.ct-unit {
    width: 80px;
    text-align: left;
}
.ct-desc {
    width: 350px;
    text-align: left;
}
.ct-actions {
    width: 120px;
    text-align: center;
}
.custom-table tbody tr {
    background: #ede5d6;
}
.custom-table tbody tr.ct-row-alt {
    background: #f7f7f7;
}
.custom-table td {
    padding: 10px 8px;
    border-bottom: 1px solid #e0e0e0;
    font-size: 1em;
}
.ct-desc-main {
    font-size: 1.1em;
    font-weight: bold;
    color: #073f68;
}
.ct-desc-sub {
    font-size: 0.95em;
    color: #555;
}

/* Estilos para documento generado */
.document-generated {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9f7ef 100%);
    border: 2px solid #28a745;
    border-radius: 8px;
    position: relative;
}

.document-generated::before {
    content: "✓ DOCUMENTO GENERADO EXITOSAMENTE";
    position: absolute;
    top: -15px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 5px 15px;
    border-radius: 15px;
    font-weight: bold;
    font-size: 12px;
    z-index: 10;
}

.form-disabled {
    pointer-events: none;
    opacity: 0.7;
}
</style>