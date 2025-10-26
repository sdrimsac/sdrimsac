<template>
    <el-dialog :title="title" :visible="showDialog" @close="close" @open="getData" width="90%" append-to-body
        v-loading="loading">
        <div class="row mt-2">
            <div class="col-6 d-flex justify-content-start">
                <h2 style="font-size: 1.2em;">
                    {{ document.customer_name }}
                </h2>
            </div>
            <div class="col-4 d-flex justify-content-end">
                <template v-if="
                    document.current_payment &&
                    document.current_payment.num &&
                    document.credit_cash == 0
                ">
                    <h4>
                        <div>
                            Cuota N° {{ document.current_payment.num }} de
                            {{ Number(document.current_payment.amount).toFixed(2) }}
                            <!-- Penalidad eliminada -->
                        </div>
                        <div>
                            Total a pagar:
                            {{ Number(document.current_payment.amount_withouth_penalty).toFixed(2) }}
                            =
                            {{ Number(document.current_payment.amount).toFixed(2) }}
                        </div>
                    </h4>
                </template>
            </div>
            <div class="col-2 d-flex justify-content-end align-items-center"
                v-if="showAddButton && document.total_difference > 0">
                <el-button class="btn_guardarsmall" type="primary" icon="el-icon-plus" @click="clickAddRow">
                    Nuevo
                </el-button>
            </div>
        </div>
        <div class="form-body">
            <div class="row">

                <div class="col-md-12" v-if="records.length > 0">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead style="background-color: #073f68; color: #fff;">
                                <tr>
                                    <th style="color: #fff; width:40px;">#</th>
                                    <th style="color: #fff; width:160px;">Fecha de pago</th>
                                    <!-- <th style="color: #fff;">Método de pago</th> -->
                                    <!-- <th style="color: #fff;">Usuario</th> -->
                                    <th style="color: #fff; width:240px;">Método/Destino</th>
                                    <!-- <th style="color: #fff;">Destino</th> -->
                                    <!-- <th style="color: #fff;">Referencia</th> -->
                                    <th style="color: #fff; width:160px;">N° de Operacion</th>
                                    <th style="color: #fff; width:120px;" class="text-end">Monto</th>
                                    <th style="color: #fff; width:120px;" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in records" :key="index"
                                    :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                                    <!-- Nuevo pago -->
                                    <template v-if="!row.id">
                                        <!-- <td>{{ customIndex(index) }}</td> -->

                                        <td class="text-center">
                                            <i class="fa fa-money fa-2x" aria-hidden="true" title="Billete"></i>
                                        </td>
                                        <td>
                                            <div class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors
                                                        .date_of_payment
                                            }">
                                                <el-date-picker v-model="row.date_of_payment
                                                    " type="date" :clearable="false" format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"></el-date-picker>
                                                <small class="form-control-feedback" v-if="
                                                    row.errors
                                                        .date_of_payment
                                                " v-text="row.errors
                                                    .date_of_payment[0]
                                                    "></small>
                                            </div>
                                        </td>
                                        <!-- Celda vacía para alinear con cabecera vacía -->
                                        <!-- <td></td> -->
                                        <!-- Usuario (no editable, mostrar usuario actual o vacío) -->

                                        <!-- <td></td> -->

                                        <!-- Metodo de Pago -->
                                        <td>
                                            <div class="form-group mb-0" :class="{'has-danger':row.errors.payment_method_type_id}">
                                                <el-select v-model="row.payment_method_type_id">
                                                    <el-option v-for="(option, idx) in payment_method_types"
                                                        :key="option.id + '-' + idx" :value="option.id" :label="option.description
                                                            "></el-option>
                                                </el-select>
                                                <small class="form-control-feedback" v-if="
                                                    row.errors
                                                        .payment_method_type_id
                                                " v-text="row.errors
                                                    .payment_method_type_id[0]
                                                    "></small>
                                                <br>
                                                 <el-select v-model="row.payment_destination_id
                                                    " filterable :disabled="row.payment_destination_disabled
                                                        ">
                                                    <el-option v-for="(option, idx) in payment_destinations"
                                                        :key="option.id + '-' + idx" :value="option.id" :label="option.description
                                                            "></el-option>
                                                </el-select>
                                                <small class="form-control-feedback"
                                                    v-if="row.errors.payment_destination_id"
                                                    v-text="row.errors.payment_destination_id[0]">

                                                </small>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <div style="min-width: 200px;" class="form-group mb-0"
                                                :class="{ 'has-danger': row.errors.payment_destination_id }">
                                                <el-select v-model="row.payment_destination_id
                                                    " filterable :disabled="row.payment_destination_disabled
                                                        ">
                                                    <el-option v-for="(option, idx) in payment_destinations"
                                                        :key="option.id + '-' + idx" :value="option.id" :label="option.description
                                                            "></el-option>
                                                </el-select>
                                                <small class="form-control-feedback"
                                                    v-if="row.errors.payment_destination_id"
                                                    v-text="row.errors.payment_destination_id[0]">

                                                </small>
                                                <br>
                                                <el-input v-model="row.number_method"
                                                    :disabled="row.payment_method_type_id === '01' || getPaymentMethodDescription(row.payment_method_type_id) === 'Efectivo'">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                                </el-input>
                                            </div>
                                        </td> -->
                                        <!-- <td>
                                            <div style="min-width: 200px;" class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors.reference
                                            }">
                                                <el-input v-model="row.reference">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                                <small class="form-control-feedback" v-if="row.errors.reference" v-text="row.errors.reference[0]
                                                    "></small>
                                            </div>
                                        </td> -->
                                        <td>
                                            <el-input v-model="row.number_method"
                                                :disabled="row.payment_method_type_id === '01' || getPaymentMethodDescription(row.payment_method_type_id) === 'Efectivo'">
                                                <i slot="prefix" class="el-icon-edit-outline"></i>
                                            </el-input>
                                        </td>
                                        <td>
                                            <div style="min-width: 200px;" class="form-group mb-0" :class="{
                                                'has-danger':
                                                    row.errors.payment
                                            }">
                                                <el-input :readonly="row.blocked" v-model="row.payment" type="number"
                                                    step="0.1">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                                <small class="form-control-feedback" v-if="row.errors.payment" v-text="row.errors.payment[0]
                                                    "></small>
                                            </div>
                                        </td>
                                        <td class="series-table-actions text-end">
                                            <!-- <button :disabled="is_paying" v-if="
                                                configuration.sale_note_credit_penalty
                                            " type="button" class="btn waves-effect waves-light btn-sm btn-success"
                                                @click.prevent="payLastPayment">
                                                <i class="fa fa-check"></i>
                                            </button> -->
                                            <button :disabled="is_paying" type="button"
                                                class="btn waves-effect waves-light btn-sm btn-info" @click.prevent="
                                                    clickSubmit(index)
                                                    ">
                                                <i class="fa fa-check"></i>
                                            </button>

                                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger"
                                                @click.prevent="
                                                    clickCancel(index)
                                                    ">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </template>
                                    <!-- Lista de pagos realizados -->
                                    <template v-else>
                                        <td :class="{'text-danger': row.extorned}">
                                            <template v-if="row.extorned">
                                                PAGO - {{ row.id }} <br>
                                                Extornado por: <br>
                                                {{ row.user_name }}
                                            </template>
                                            <template v-else>
                                                PAGO-{{ row.id }}
                                            </template>
                                        </td>
                                        <!-- <td v-if="row.extorned" class="text-danger">
                                            PAGO-{{ row.id }}
                                        </td> -->
                                        <td :class="{ 'text-danger': row.extorned }">
                                            {{ row.user_name }}
                                            <br>
                                            {{ row.date_time_issue }}
                                        </td>
                                        <!-- <td :class="{'text-danger': row.extorned}">
                                            {{ row.quote_date }}
                                        </td> -->
                                        <!-- <td :class="{
                                            'text-danger': row.extorned
                                        }">
                                            {{ row.user_name }}
                                        </td> -->
                                        <td :class="{ 'text-danger': row.extorned }">
                                            {{ row.method }}
                                            <br>
                                            {{ row.destination_description }}
                                        </td>
                                        <!-- <td :class="{'text-danger': row.extorned}">
                                            {{ row.destination_description }}
                                        </td> -->
                                        <!-- <td :class="{'text-danger': row.extorned}">
                                            {{ row.reference }}
                                        </td> -->

                                        <td :class="{ 'text-danger': row.extorned }" class="text-center">
                                            <template v-if="row.number_method">
                                                {{ row.number_method }}
                                            </template>
                                            <template v-else>
                                                -
                                            </template>
                                        </td>
                                        <td :class="{'text-danger': row.extorned}" class="text-end">
                                            {{ row.payment }}
                                        </td>
                                        <td class="series-table-actions text-end">
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button
                                                    v-if="row.can_extorned && row.canCancel && !row.extorned"
                                                    type="button"
                                                    class="btn_cancelarsmall me-2"
                                                    @click.prevent="returnPaymentNotes(row)"
                                                >
                                                    Extornar
                                                </button>

                                                <button
                                                    v-if="row.receipt_link && row.receipt_link != ''"
                                                    type="button"
                                                    class="btn_guardarsmall"
                                                    @click.prevent="ClickPrint(row.receipt_link)"
                                                >
                                                    Recibo
                                                </button>
                                            </div>
                                        </td>
                                    </template>
                                </tr>
                            </tbody>
                            <!-- Pie de totales -->
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        Total Pagado
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_paid).toFixed(2) }}

                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        Total a Pagar
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total).toFixed(2) }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        Pendiente de Pago
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_difference || 0).toFixed(2) }}
                                    </td>
                                    <td></td>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Totales -->
                    <!-- <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                <tr v-if="!document.paid">
                                    <td class="text-end" :colspan="colspanValue">
                                        Total Pagado
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_paid).toFixed(2) }}
                                    </td>
                                    <td class="text-end" :colspan="colspanValue">
                                        Total a Pagar
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total).toFixed(2) }}
                                    </td>
                                    <td v-if="cancelCredit" class="text-end">
                                        Descuento
                                    </td>
                                    <td v-if="cancelCredit" class="text-end">
                                        <el-input-number @input="calculateDiscountCredit" v-model="creditDiscount">
                                        </el-input-number>
                                    </td>
                                    Descuento penalidad eliminado
                                </tr>

                                <tr v-if="!cancelCredit">
                                    <td :colspan="colspanValue" class="text-end">
                                        Pendiente por Pagar
                                    </td>
                                    <td class="text-end">
                                        {{ Number(document.total_difference).toFixed(2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            
                        </table>
                    </div> -->
                </div>
            </div>
            <image-preview-modal :showDialog.sync="showImagePreviewModal" :image="imagePreview">
            </image-preview-modal>
            <detail-ajusment :dialogAjustment.sync="showDetails" :recordId="documentId" @updateRecord="getData">
            </detail-ajusment>
        </div>
    </el-dialog>
</template>

<script>
import { deletable } from "../../../mixins/deletable";
import ImagePreviewModal from "../../../components/ImagePreviewModal.vue";
import DetailAjusment from "./detail_ajustment.vue";
export default {
    props: ["showDialog", "documentId", "configuration"],
    mixins: [deletable],
    components: {
        ImagePreviewModal,
        DetailAjusment
    },
    data() {
        return {
            showDetails: false,
            // creditDiscountPenalty eliminado
            customerName: null,
            currentPayment: {},
            is_paying: false,
            showImagePreviewModal: false,
            imagePreview: null,
            creditDiscount: 0,
            // Reintroducido para evitar warnings ya que aún se referencia en clickSubmit
            creditDiscountPenalty: 0,
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
            receipt_link: null,
            loading: false
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.payment_destinations = response.data.payment_destinations;
            this.payment_method_types = response.data.payment_method_types;
            this.establishments = response.data.establishments;
            //this.initDocumentTypes()
        });
    },
    computed: {
        // hasPenalty eliminado
        colspanValue() {
            let colspan = 4; // Base colspan for TOTAL PAGADO and TOTAL A PAGAR
            if (this.cancelCredit) {
                colspan += 2; // Solo para DESCUENTO
            }
            return colspan;
        }
    },
    methods: {
        // Devuelve el índice visible (1-based). Si se desea otro criterio (ej. inverso), ajustar aquí.
        customIndex(i) {
            return i + 1;
        },

        getPaymentMethodDescription(id) {
            const method = this.payment_method_types.find(m => m.id == id);
            return method ? method.description : '';
        },

        async returnPaymentNotes(record) {
            try {
                await this.$confirm(
                    "¿Está seguro de extornar el pago?",
                    "Extornar Pago",
                    {
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        type: "warning"
                    }
                );
                this.loading = true;
                this.$http
                    .get(`/sale-notes/return-payment-notes/${record.id}`)
                    .then(response => {
                        this.$toast.success(response.data.message);
                        this.getData();
                        this.$eventHub.$emit("reloadData");
                        this.$emit("reloadData");
                        console.log("🚀 ~ returnPayment ~ response:", response);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        payLastPayment() {
            this.is_paying = true;
            this.loading = true;
            let [payment] = this.records;
            let amount = payment.payment;
            let payment_method_type_id = payment.payment_method_type_id;
            let payment_destination_id = payment.payment_destination_id;
            this.$http
                .post(`/sale-notes/pay-last-payment/${this.documentId}`, {
                    amount,
                    payment_method_type_id,
                    payment_destination_id
                })
                .then(response => {
                    this.$toast.success(response.data.message);
                    this.getData();
                    this.$eventHub.$emit("reloadData");
                    this.$emit("reloadData");
                })
                .finally(() => {
                    this.is_paying = false;
                    this.loading = false;
                });
        },
        seeDetail() {
            this.showDetails = true;
        },
        // calculateDiscountAmountCredit eliminado
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
            this.records.unshift({
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
                blocked: true,
                number_method: null

            });
            this.cancelCredit = true;
            this.showAddButton = false;
            this.document.total_difference_credit = this.document.total_difference;
            console.log(
                "🚀 ~ clickAddCancelCredit ~ this.document.total_difference_credit:",
                this.document.total_difference_credit
            );

            this.records[0].payment = this.document.total_difference_credit;
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
            this.loading = true;
            this.initForm();
            await this.$http
                .get(`/${this.resource}/document-notes/${this.documentId}`)
                .then(response => {
                    this.document = response.data;
                    this.document.total_difference_credit = this.document.total_difference;
                    this.title =
                        "Pagos del comprobante: " +
                        this.document.series +
                        "-" +
                        this.document.number;
                })
                .catch(e => {
                    this.$toast.error(e.message);
                });
            await this.$http
                .get(`/${this.resource}/records/${this.documentId}`)
                .then(response => {
                    this.records = response.data.data;
                    this.records = this.records.reverse();
                    if (this.records.length > 0) {
                        let [record] = this.records;
                        if (record.date_time_issue) {
                            this.records[0].canCancel = true;
                        }
                    }
                })
                .catch(e => {
                    this.$toast.error(e.message);
                })
                .finally(() => {
                    this.loading = false;
                });
            this.$eventHub.$emit("reloadDataUnpaid");
        },
        roundUpToOneDecimal(number) {
            return Math.ceil(number * 10) / 10;
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
            let payment = 0;
            if (
                this.document.current_payment &&
                this.document.current_payment.amount
            ) {
                payment = this.roundUpToOneDecimal(
                    this.document.current_payment.amount
                );
            }

            this.records.unshift({
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: "01",
                payment_destination_id,
                reference: null,
                filename: null,
                temp_path: null,
                payment,
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
            /* if (this.configuration.sale_note_credit_cash) { */
            if (
                this.records[index].payment > this.document.total_difference
            ) {
                this.$showSAlert(
                    "Error",
                    "El monto ingresado no puede ser mayor al monto de la cuota.",
                    "error"
                );
                return;
            }
            /* } */
            // Validación de penalidad eliminada
            let { num_schedule, amount_schedule } = this.document;
            let payment = this.records[index].payment;
            if (payment <= 0) {
                this.$toast.error("El monto ingresado debe ser mayor a 0.");
                return;
            }
            // Validar que current_payment exista antes de acceder a amount
            const documentRealAmount = this.document.current_payment?.amount ?? 0;
            //si el monto ingresado tiene dos decimales
            if (payment % 1 != 0) {
                //si el segundo decimal es mayor a 0
                let paymentString = payment.toString().split(".")[1];

                if (paymentString.length >= 2 && !this.cancelCredit) {
                    this.$toast.error(
                        "El monto ingresado no puede tener dos o más decimales."
                    );
                    return;
                }
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
            /* if (
                this.records[index].payment >
                parseFloat(
                    this.document.total_difference +
                    this.document.current_payment.penalty
                ) +
                0.1
            ) {
                this.$toast.error(
                    "El monto ingresado supera al monto pendiente de pago, verifique."
                );
                return;
            } */

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
                payment_method_type_id: this.records[index].payment_method_type_id,
                payment_destination_id: this.records[index].payment_destination_id,
                reference: this.records[index].reference,
                filename: this.records[index].filename,
                temp_path: this.records[index].temp_path,
                payment: this.records[index].payment,
                number_method: this.records[index].number_method,
                paid: paid,
                creditDiscount: this.creditDiscount,
                creditDiscountPenalty: this.creditDiscountPenalty,
                documentRealAmount: documentRealAmount
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

<style scoped>
.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    white-space: nowrap;
}

@media (max-width: 992px) {
    .table-responsive {
        font-size: 0.95em;
    }

    th,
    td {
        padding: 0.4em 0.6em;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9em;
    }

    th,
    td {
        padding: 0.3em 0.4em;
    }

    /* Oculta columnas menos importantes en móviles si es necesario */
    th:nth-child(4),
    td:nth-child(4),
    th:nth-child(8),
    td:nth-child(8),
    th:nth-child(9),
    td:nth-child(9) {
        display: none;
    }
}
</style>
