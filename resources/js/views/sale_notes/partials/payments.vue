<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @close="close"
        @open="getData"
        width="90%"
        append-to-body
    >
        <div class="row mt-2">
            <div class="col-lg-6 col-md-6 col-12 d-flex justify-content-start">
                <h4>
                    {{ document.customer_name }}
                </h4>
            </div>
            <div class="col-lg-6 col-md-6 col-12 d-flex justify-content-end">
                <template
                    v-if="
                        document.current_payment &&
                            document.current_payment.num &&
                            document.credit_cash == 0
                    "
                >
                    <h4>
                        <div>
                            Cuota N° {{ document.current_payment.num }} de
                            {{
                                Number(document.current_payment.amount).toFixed(
                                    2
                                )
                            }}

                            <span
                                class="text-danger"
                                v-if="document.current_payment.penalty > 0"
                            >
                                Penalidad:
                                {{ Number(document.current_payment.diff_days) }}
                                días
                            </span>
                        </div>
                        <div>
                            Total a pagar:
                            {{
                                Number(
                                    document.current_payment
                                        .amount_withouth_penalty
                                ).toFixed(2)
                            }}
                            +
                            {{
                                Number(
                                    document.current_payment.penalty
                                ).toFixed(2)
                            }}
                            =
                            {{
                                Number(document.current_payment.amount).toFixed(
                                    2
                                )
                            }}
                        </div>
                    </h4>
                </template>
            </div>
        </div>
        <div class="form-body">
            <div class="row">
                <div class="col-md-12" v-if="records.length > 0">
                    <div class="container table-responsive">
                        <table
                            class="table table-hover table-striped table-condensed  table-responsive"
                            style="width: 100%; white-space: nowrap;"
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de pago</th>
                                    <th>Método de pago</th>
                                    <th>Destino</th>
                                    <th>Referencia</th>
                                    <th>Archivo</th>
                                    <th class="text-end">Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(row, index) in records"
                                    :key="index"
                                >
                                    <template v-if="row.id">
                                        <td>PAGO-{{ row.id }}</td>
                                        <td>{{ row.date_of_payment }}</td>
                                        <td>
                                            {{
                                                row.payment_method_type_description
                                            }}
                                        </td>
                                        <td>
                                            {{ row.destination_description }}
                                        </td>
                                        <td>{{ row.reference }}</td>
                                        <td class="text-center">
                                            <template v-if="row.filename">
                                                <button
                                                    v-if="isImage(row.filename)"
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-primary"
                                                    @click.prevent="
                                                        clickImagePreview(
                                                            row.filename
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-file-image"
                                                    ></i>
                                                </button>
                                                <button
                                                    v-else
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-primary"
                                                    @click.prevent="
                                                        clickDownloadFile(
                                                            row.filename
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-file-download"
                                                    ></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td class="text-end">
                                            {{ row.payment }}
                                        </td>
                                        <td
                                            class="series-table-actions text-end"
                                        >
                                            <!-- <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickDelete(row.id)
                                                "
                                            >
                                                Eliminar
                                            </button> -->
                                            <button
                                                v-if="
                                                    row.receipt_link &&
                                                        row.receipt_link != ''
                                                "
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-primary"
                                                @click.prevent="
                                                    ClickPrint(row.receipt_link)
                                                "
                                            >
                                                Imprimir
                                            </button>
                                            <!--<el-button type="danger" icon="el-icon-delete" plain @click.prevent="clickDelete(row.id)"></el-button>-->
                                        </td>
                                    </template>
                                    <template v-else>
                                        <td></td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .date_of_payment
                                                }"
                                            >
                                                <el-date-picker
                                                    v-model="
                                                        row.date_of_payment
                                                    "
                                                    type="date"
                                                    :clearable="false"
                                                    format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"
                                                ></el-date-picker>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .date_of_payment
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .date_of_payment[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .payment_method_type_id
                                                }"
                                            >
                                                <el-select
                                                    v-model="
                                                        row.payment_method_type_id
                                                    "
                                                >
                                                    <el-option
                                                        v-for="option in payment_method_types"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .payment_method_type_id
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .payment_method_type_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                style="min-width: 200px;"
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors
                                                            .payment_destination_id
                                                }"
                                            >
                                                <el-select
                                                    v-model="
                                                        row.payment_destination_id
                                                    "
                                                    filterable
                                                    :disabled="
                                                        row.payment_destination_disabled
                                                    "
                                                >
                                                    <el-option
                                                        v-for="option in payment_destinations"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="
                                                        row.errors
                                                            .payment_destination_id
                                                    "
                                                    v-text="
                                                        row.errors
                                                            .payment_destination_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                style="min-width: 200px;"
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors.reference
                                                }"
                                            >
                                                <el-input
                                                    v-model="row.reference"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i
                                                ></el-input>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="row.errors.reference"
                                                    v-text="
                                                        row.errors.reference[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-upload
                                                    :data="{ index: index }"
                                                    :headers="headers"
                                                    :multiple="false"
                                                    :on-remove="handleRemove"
                                                    :action="
                                                        `/finances/payment-file/upload`
                                                    "
                                                    :show-file-list="true"
                                                    :file-list="fileList"
                                                    :on-success="onSuccess"
                                                    :limit="1"
                                                >
                                                    <el-button
                                                        slot="trigger"
                                                        type="primary"
                                                        >Seleccione un
                                                        archivo</el-button
                                                    >
                                                </el-upload>
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                style="min-width: 200px;"
                                                class="form-group mb-0"
                                                :class="{
                                                    'has-danger':
                                                        row.errors.payment
                                                }"
                                            >
                                                <el-input
                                                    :readonly="row.blocked"
                                                    v-model="row.payment"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i
                                                ></el-input>
                                                <small
                                                    class="form-control-feedback"
                                                    v-if="row.errors.payment"
                                                    v-text="
                                                        row.errors.payment[0]
                                                    "
                                                ></small>
                                            </div>
                                        </td>
                                        <td
                                            class="series-table-actions text-end"
                                        >
                                            <button
                                                :disabled="is_paying"
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info"
                                                @click.prevent="
                                                    clickSubmit(index)
                                                "
                                            >
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickCancel(index)
                                                "
                                            >
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </template>
                                </tr>
                            </tbody>
                            <tfoot v-if="!document.paid">
                                <tr>
                                    <td colspan="6" class="text-end">
                                        TOTAL PAGADO
                                    </td>
                                    <td class="text-end">
                                        {{ document.total_paid }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-end">
                                        TOTAL A PAGAR
                                    </td>
                                    <td class="text-end">
                                        {{ document.total }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr v-if="cancelCredit">
                                    <td colspan="6" class="text-end">
                                        DESCUENTO
                                    </td>
                                    <td class="text-end">
                                        <el-input-number
                                            @input="calculateDiscountCredit"
                                            v-model="creditDiscount"
                                        >
                                        </el-input-number>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr v-if="hasPenalty">
                                    <td colspan="6" class="text-end">
                                        DESCUENTO PENALIDAD
                                    </td>
                                    <td class="text-end">
                                        <el-input-number
                                            @input="
                                                calculateDiscountAmountCredit
                                            "
                                            v-model="creditDiscountPenalty"
                                        >
                                        </el-input-number>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr v-if="!cancelCredit && !hasPenalty">
                                    <td colspan="6" class="text-end">
                                        PENDIENTE DE PAGO
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_difference).toFixed(2) }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr v-else>
                                    <td colspan="6" class="text-end">
                                        PENDIENTE DE PAGO
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_difference_credit).toFixed(2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div
                    class="col-md-12 text-center pt-2"
                    v-if="showAddButton && document.total_difference > 0"
                >
                    <el-button
                        type="primary"
                        icon="el-icon-plus"
                        @click="clickAddRow"
                        >Nuevo</el-button
                    >
                    <el-button
                        type="primary"
                        icon="el-icon-payment"
                        @click="clickAddCancelCredit"
                    >
                        Cancelar crédito</el-button
                    >
                </div>
            </div>
            <image-preview-modal
                :showDialog.sync="showImagePreviewModal"
                :image="imagePreview"
            >
            </image-preview-modal>
        </div>
    </el-dialog>
</template>

<script>
import { deletable } from "../../../mixins/deletable";
import ImagePreviewModal from "../../../components/ImagePreviewModal.vue";
export default {
    props: ["showDialog", "documentId", "configuration"],
    mixins: [deletable],
    components: {
        ImagePreviewModal
    },
    data() {
        return {
            creditDiscountPenalty: 0,
            customerName: null,
            currentPayment: {},
            is_paying: false,
            showImagePreviewModal: false,
            imagePreview: null,
            creditDiscount: 0,
            cancelCredit: false,
            title: null,
            resource: "sale_note_payments",
            records: [],
            payment_destinations: [],
            payment_method_types: [],
            headers: headers_token,
            index_file: null,
            fileList: [],
            showAddButton: true,
            document: {},
            receipt_link: null
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.payment_destinations = response.data.payment_destinations;
            this.payment_method_types = response.data.payment_method_types;
            //this.initDocumentTypes()
        });
    },
    computed: {
        hasPenalty() {
            return (
                this.configuration &&
                this.configuration.sale_note_credit_penalty &&
                this.document.current_payment.penalty > 0
            );
        }
    },
    methods: {
        calculateDiscountAmountCredit() {
            this.document.total_difference_credit =
                this.document.total_difference - this.creditDiscountPenalty || 0;
        },
        isImage(url) {
            return url.match(/\.(jpeg|jpg|gif|png)$/) != null;
        },
        clickImagePreview(url) {
            this.imagePreview = `/finances/payment-file/download-file/${url}/sale_notes`;
            this.showImagePreviewModal = true;
        },
        calculateDiscountCredit() {
            this.document.total_difference_credit =
                this.document.total_difference - this.creditDiscount;

            this.records[
                this.records.length - 1
            ].payment = this.document.total_difference_credit;
        },
        clickAddCancelCredit() {
            this.records.push({
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: null,
                payment_destination_id: null,
                reference: null,
                filename: null,
                temp_path: null,
                payment: 0,
                errors: {},
                loading: false,
                blocked: true
            });
            this.cancelCredit = true;
            this.showAddButton = false;
            this.document.total_difference_credit = this.document.total_difference;
        },
        clickDownloadFile(filename) {
            window.open(
                `/finances/payment-file/download-file/${filename}/sale_notes`,
                "_blank"
            );
        },
        ClickPrint(receipt_link) {
            console.log(
                "🚀 ~ ClickPrint ~ this.configuration:",
                this.configuration
            );
            if (this.configuration.print_payment_credit_sale_note) {
                this.$http.post("/caja/re-print", {
                    url: receipt_link
                });
            } else {
                window.open(receipt_link, "_blank");
            }
        },
        onSuccess(response, file, fileList) {
            // console.log(response, file, fileList)
            this.fileList = fileList;

            if (response.success) {
                this.index_file = response.data.index;
                this.records[this.index_file].filename = response.data.filename;
                this.records[this.index_file].temp_path =
                    response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }

            // console.log(this.records)
        },
        handleRemove(file, fileList) {
            this.records[this.index_file].filename = null;
            this.records[this.index_file].temp_path = null;
            this.fileList = [];
            this.index_file = null;
        },
        initForm() {
            this.records = [];
            this.fileList = [];
            this.showAddButton = true;
            this.cancelCredit = false;
        },
        async getData() {
            this.initForm();
            await this.$http
                .get(`/${this.resource}/document/${this.documentId}`)
                .then(response => {
                    this.document = response.data;
                    this.document.total_difference_credit = this.document.total_difference;
                    this.title =
                        "Pagos del comprobante: " +
                        this.document.series +
                        "-" +
                        this.document.number;
                });
            await this.$http
                .get(`/${this.resource}/records/${this.documentId}`)
                .then(response => {
                    this.records = response.data.data;
                });
            this.$eventHub.$emit("reloadDataUnpaid");
        },
        clickAddRow() {
            let payment_destination_id = null;
            if (this.payment_destinations.length > 0) {
                let payment_with_cash_id = this.payment_destinations.find(
                    item => item.cash_id
                );
                if (payment_with_cash_id) {
                    payment_destination_id = payment_with_cash_id.id;
                }
            }
            this.records.push({
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: "01",
                payment_destination_id,
                reference: null,
                filename: null,
                temp_path: null,
                payment: 0,
                errors: {},
                loading: false
            });
            this.showAddButton = false;
        },
        clickCancel(index) {
            this.records.splice(index, 1);
            this.showAddButton = true;
            this.cancelCredit = false;
            this.fileList = [];
        },
        async clickSubmit(index) {
            if (
                this.creditDiscountPenalty >
                this.document.current_payment.penalty
            ) {
                this.creditDiscountPenalty = this.document.current_payment.penalty;
                this.$toast.error(
                    "El descuento no puede ser mayor a la penalidad"
                );
                return;
            }
            let { num_schedule, amount_schedule } = this.document;
            let payment = this.records[index].payment;
            if (payment <= 0) {
                this.$toast.error("El monto ingresado debe ser mayor a 0.");
                return;
            }
            let difference = parseFloat(this.document.total_difference);
            let passLowPay = false;
            if (
                this.configuration &&
                this.configuration.sale_note_credit_low_pay
            ) {
                passLowPay = true;
            }
            if (
                difference > amount_schedule &&
                payment < amount_schedule &&
                !passLowPay
            ) {
                this.$toast.error(
                    "El monto ingresado debe ser igual o mayor a la cuota: " +
                        amount_schedule +
                        " para poder realizar el pago."
                );
                return;
            }
            // if (num_schedule == 1) {
            //     if (
            //         this.records[index].payment <
            //         parseFloat(this.document.total_difference)
            //     ) {
            //         this.$toast.error(
            //             "No se puede hacer pago parcial teniendo una sola cuota por cancelar."
            //         );
            //         return;
            //     }
            // }
            if (
                this.records[index].payment >
                parseFloat(
                    this.document.total_difference +
                        this.document.current_payment.penalty
                )
            ) {
                this.$toast.error(
                    "El monto ingresado supera al monto pendiente de pago, verifique."
                );
                return;
            }

            let paid = false;
            if (
                this.records[index].payment ==
                    parseFloat(this.document.total_difference) ||
                this.cancelCredit
            ) {
                paid = true;
            }

            let form = {
                id: this.records[index].id,
                sale_note_id: this.documentId,
                date_of_payment: this.records[index].date_of_payment,
                payment_method_type_id: this.records[index]
                    .payment_method_type_id,
                payment_destination_id: this.records[index]
                    .payment_destination_id,
                reference: this.records[index].reference,
                filename: this.records[index].filename,
                temp_path: this.records[index].temp_path,
                payment: this.records[index].payment,
                paid: paid,
                creditDiscount: this.creditDiscount,
                creditDiscountPenalty: this.creditDiscountPenalty
            };
            try {
                this.is_paying = true;

                const response = await this.$http.post(
                    `/${this.resource}`,
                    form
                );

                if (response.data.success) {
                    this.$toast.success(response.data.message);
                    this.getData();
                    // this.receipt_link=response.data.pdf
                    //this.ClickPrint()
                    // this.ClickPrint(response.data.pdf)
                    this.creditDiscountPenalty = 0;
                    this.$eventHub.$emit("reloadData");
                    this.$emit("reloadData");
                    this.showAddButton = true;
                    this.cancelCredit = false;
                } else {
                    this.$toast.error(response.data.message);
                }
            } catch (error) {
                if (error.response.status === 422) {
                    this.records[index].errors = error.response.data;
                } else {
                    console.log(error);
                }
            } finally {
                this.is_paying = false;
            }
        },
        // filterDocumentType(row){
        //
        //     if(row.contingency){
        //         this.document_types = _.filter(this.all_document_types, item => (item.id == '01' || item.id =='03'))
        //         row.document_type_id = (this.document_types.length > 0)?this.document_types[0].id:null
        //     }else{
        //         row.document_type_id = null
        //         this.document_types = this.all_document_types
        //     }
        // },
        // initDocumentTypes(){
        //     this.document_types = (this.all_document_types.length > 0) ? this.all_document_types : []
        // },
        close() {
            this.$emit("update:showDialog", false);
            // this.initDocumentTypes()
            // this.initForm()
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(
                () => {
                    this.getData();
                    this.$eventHub.$emit("reloadData");
                }
                // this.initDocumentTypes()
            );
        }
    }
};
</script>
