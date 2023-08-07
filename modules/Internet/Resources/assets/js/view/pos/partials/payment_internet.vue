<template>
    <el-dialog
        :visible="is_payment"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :modal-append-to-body="true"
        :show-close="false"
        :append-to-body="true"
        width="770px"
        @open="open"
        top="2vh"
        :title="title || 'MODULO DE CAJA'"
        class="algunaClase"
    >
        <div v-loading="loading" class="mb-0">
            <div class="pt-1" v-loading="loading_submit">
                <template v-if="data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Nombre</label>
                            <el-input
                                :readonly="true"
                                :value="`${data.number} | ${data.name}`"
                            >
                            </el-input>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Celular</label>
                            <el-input :readonly="true" v-model="data.phone">
                            </el-input>
                        </div>
                        <div class="col-md-12">
                            <label for="address">Dirección</label>
                            <el-input :readonly="true" v-model="data.address">
                            </el-input>
                            <small
                                v-if="data.address_reference"
                                class="text-muted"
                            >
                                {{ data.address_reference }}</small
                            >
                        </div>
                        <div class="col-md-6" v-if="data.install">
                            <label for="name">Instalacion</label>
                            <el-input
                                :readonly="true"
                                :value="`S/. ${data.install}`"
                            >
                            </el-input>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Plan Actual</label>
                            <el-input
                                :readonly="true"
                                :value="
                                    `${data.plan.capacity} | ${data.plan_variation.description}`
                                "
                            >
                            </el-input>
                        </div>
                        <div
                            class="col-md-6"
                            v-for="(concept, idx) in data.concepts"
                            :key="idx"
                        >
                            <label for="name">Concepto {{ idx + 1 }}</label>
                            <el-input
                                :readonly="true"
                                :value="
                                    `${concept.generalConcept} | ${concept.description}`
                                "
                            >
                            </el-input>
                        </div>
                    </div>
                </template>
                <template v-if="registerInternetId">
                    <service-form
                        ref="internet"
                        :updatePlan.sync="updatePlan"
                        :registerId="registerInternetId"
                        :plan.sync="plan"
                        @updateTotal="updateTotal"
                        @updateItems="updateItems"
                        @updateObservation="updateObservation"
                        @updateCustomer="updateCustomer"
                        @createFormRegister="createFormService"
                        :member.sync="member"
                    ></service-form>
                </template>
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <div class="m-2">
                            <div class="card bg-light">
                                <div class="row">
                                    <div class="col-md-4" v-if="isReconnection">
                                        <label for="reconnection"
                                            >Fecha de reconexión</label
                                        >
                                        <el-date-picker
                                            class="w-100"
                                            @change="updateReconexionDate"
                                            v-model="form.reconnection_date"
                                            value-format="yyyy-MM-dd"
                                            format="dd/MM/yyyy"
                                        >
                                        </el-date-picker>
                                    </div>
                                    <div class="col-md-4" v-if="isReconnection">
                                        <label for="reconnection"
                                            >Precio de reconexión</label
                                        >
                                        <el-input
                                            type="number"
                                            :min="0"
                                            class="w-100 to_rigth"
                                            @input="updateReconexion"
                                            v-model="form.reconnection"
                                        >
                                        </el-input>
                                    </div>
                                </div>
                                <div class="row col-lg-6 col-xl-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Detalles</label
                                        >
                                        <el-input
                                            type="textarea"
                                            autosize
                                            readonly
                                            :value="details"
                                        ></el-input>
                                    </div>
                                </div>
                                <div class="row col-lg-6 col-xl-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Observaciones</label
                                        >
                                        <el-input
                                            type="textarea"
                                            :rows="2"
                                            v-model="observation"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-2">
                            <div class="text-center text-dark card bg-light">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="align-items-start">
                                            <label class="control-label"
                                                >Medios de Pago</label
                                            >
                                            <label
                                                role="button"
                                                class="text-primary control-label"
                                            ></label>
                                        </div>
                                        <div
                                            class="radio-tile-group2 flex-wrap"
                                        >
                                            <div
                                                v-for="(meth,
                                                idx) in paymentMethods"
                                                :key="idx"
                                                class="input-container2 border rounded-sm"
                                            >
                                                <input
                                                    id="cash"
                                                    v-model="method_payments"
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="method_payment"
                                                    :value="meth.value"
                                                    @change="
                                                        method_payment(
                                                            meth.text
                                                        )
                                                    "
                                                />
                                                <div
                                                    class="radio-tile2"
                                                    :style="
                                                        `background-image: url('../../images/${meth.img}');background-size: contain;background-repeat: no-repeat;`
                                                    "
                                                >
                                                    <div
                                                        class="icon walk-icon"
                                                    ></div>
                                                    <label
                                                        for="cash"
                                                        class="radio-tile-label2"
                                                    ></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="row">
                                                <label
                                                    class="control-label text-center"
                                                    >Emision de
                                                    comprobante</label
                                                >
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col-lg-2 col-md-5 col-xl-6"
                                                >
                                                    <label
                                                        class="
                              control-label
                              text-left
                              d-flex
                              align-items-start
                              justify-content-start
                            "
                                                    >
                                                        Ingrese Nro Celular
                                                    </label>
                                                    <el-input
                                                        v-model="
                                                            form.customer_telephone
                                                        "
                                                    >
                                                        <template slot="prepend"
                                                            ><i
                                                                class="fab fa-whatsapp fa-2x"
                                                            ></i>
                                                        </template>
                                                    </el-input>
                                                </div>
                                                <div
                                                    class="radio-tile-group2 col-lg-6 col-xl-6 d"
                                                    style="padding-top: 12px"
                                                >
                                                    <div
                                                        class="input-container2 border rounded-sm col-lg-3"
                                                    >
                                                        <input
                                                            id="imprimir"
                                                            v-model="printerOn"
                                                            class="radio-button2"
                                                            type="radio"
                                                            name="imprimir"
                                                            value="1"
                                                        />
                                                        <div
                                                            class="radio-tile2"
                                                        >
                                                            <div
                                                                class="icon walk-icon"
                                                            >
                                                                <i
                                                                    class="fa fa-print"
                                                                ></i>
                                                            </div>
                                                            <label
                                                                for="cash"
                                                                class="radio-tile-label2"
                                                                >Imprimir</label
                                                            >
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="input-container2 border rounded-sm col-lg-3"
                                                    >
                                                        <input
                                                            id="noimprimir"
                                                            v-model="printerOn"
                                                            class="radio-button2"
                                                            type="radio"
                                                            name="noimprimir"
                                                            value="0"
                                                        />
                                                        <div
                                                            class="radio-tile2"
                                                        >
                                                            <div
                                                                class="icon bike-icon"
                                                            >
                                                                <i
                                                                    class="fa fa-print"
                                                                ></i>
                                                            </div>
                                                            <label
                                                                for="Tarjeta"
                                                                class="radio-tile-label2"
                                                                >No
                                                                Imprimir</label
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div
                                                class="col-lg-8 d-flex flex-row align-items-end"
                                            ></div>
                                            <div
                                                class="d-flex flex-column"
                                            ></div>
                                        </div>
                                        <div
                                            class="row d-flex justify-content-start"
                                        >
                                            <table
                                                class="table"
                                                v-if="
                                                    currentPayments.length != 0
                                                "
                                            >
                                                <thead>
                                                    <tr>
                                                        <th
                                                            colspan="4"
                                                            class="text-left"
                                                        >
                                                            Pagos
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(paymnt,
                                                        idx) in currentPayments"
                                                        :key="idx"
                                                    >
                                                        <td>{{ idx + 1 }}</td>
                                                        <td>
                                                            {{ paymnt.method }}
                                                        </td>
                                                        <td>
                                                            <strong>{{
                                                                paymnt.amount
                                                            }}</strong>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for=""
                                                                role="button"
                                                                @click="
                                                                    removePayment(
                                                                        paymnt.id
                                                                    )
                                                                "
                                                                class="text-danger"
                                                            >
                                                                <i
                                                                    class="fa fa-trash"
                                                                ></i
                                                            ></label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-2">
                                <div class="card bg-light">
                                    <div class="row">
                                        <div
                                            class="col-xl-4 d-flex flex-column justify-content-center align-items-start"
                                            :class="{
                                                'has-danger':
                                                    form.difference < 0
                                            }"
                                        >
                                            <label
                                                v-if="credit > 0"
                                                class="control-label h1
                                                text-success
                                                "
                                                >Crédito:
                                            </label>
                                            <span
                                                v-if="credit > 0"
                                                class="
                                                d-block
                          control-label
                          font-weight-semibold
                          text-center
                          text-success
                          h3
                        "
                                            >
                                                S/ {{ " " + credit }}
                                            </span>
                                            <label class="control-label h1"
                                                >Total a cobrar:
                                            </label>
                                            <span
                                                class="
                                                d-block
                          control-label
                          font-weight-semibold
                          text-center
                          h3
                        "
                                            >
                                                S/ {{ " " + form.total }}
                                            </span>
                                        </div>
                                        <div
                                            class="col-xl-8"
                                            v-if="
                                                form_payment.payment_method_type_id ==
                                                    '01'
                                            "
                                        >
                                            <div
                                                class="
                          btn-group btn-group-square
                          m-0
                          flex-wrap
                          justify-content-around
                        "
                                                role="group"
                                                style="padding-top: 12px"
                                            >
                                                <label class="control-label"
                                                    >Ingrese monto</label
                                                >
                                                <div class="row col-12">
                                                    <div
                                                        class="col-2 col-md-2 col-xl-2"
                                                    >
                                                        <button
                                                            class="btn btn-outline-primary btn_responsive m-2"
                                                            @click="
                                                                setAmountCash(
                                                                    10
                                                                )
                                                            "
                                                        >
                                                            {{
                                                                currencyTypeActive.symbol
                                                            }}10
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-2 col-xl-2"
                                                    >
                                                        <button
                                                            class="btn btn-outline-primary btn_responsive m-2"
                                                            @click="
                                                                setAmountCash(
                                                                    20
                                                                )
                                                            "
                                                        >
                                                            {{
                                                                currencyTypeActive.symbol
                                                            }}20
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-2 col-xl-2"
                                                    >
                                                        <button
                                                            class="btn btn-outline-primary btn_responsive m-2"
                                                            @click="
                                                                setAmountCash(
                                                                    50
                                                                )
                                                            "
                                                        >
                                                            {{
                                                                currencyTypeActive.symbol
                                                            }}50
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-2 col-xl-2"
                                                    >
                                                        <button
                                                            class="btn btn-outline-primary btn_responsive m-2"
                                                            @click="
                                                                setAmountCash(
                                                                    100
                                                                )
                                                            "
                                                        >
                                                            {{
                                                                currencyTypeActive.symbol
                                                            }}100
                                                        </button>
                                                    </div>
                                                    <div
                                                        class="col-2 col-md-2 col-xl-2"
                                                    >
                                                        <button
                                                            class="btn btn-outline-primary btn_responsive m-2"
                                                            @click="
                                                                setAmountCash(
                                                                    200
                                                                )
                                                            "
                                                        >
                                                            {{
                                                                currencyTypeActive.symbol
                                                            }}200
                                                        </button>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row col-xl-12 col-12"
                                                >
                                                    <div class="col-xl-6 col-3">
                                                        <el-input
                                                            id="inputTotal"
                                                            ref="enter_amount"
                                                            :disabled="
                                                                form.total == 0
                                                            "
                                                            v-model="
                                                                form.enter_amount
                                                            "
                                                            @blur="diferen()"
                                                            @input="
                                                                enterAmount()
                                                            "
                                                            @keyup.enter.native="
                                                                sendPayment();
                                                                inputAmount(
                                                                    form.enter_amount
                                                                );
                                                            "
                                                        >
                                                            <template
                                                                slot="prepend"
                                                                >{{
                                                                    currencyTypeActive.symbol
                                                                }}
                                                            </template>
                                                        </el-input>
                                                    </div>
                                                    <div class="col-xl-2 col-2">
                                                        <el-button
                                                            type="primary"
                                                            @click="addPayment"
                                                            >Agregar</el-button
                                                        >
                                                    </div>
                                                    <!-- <div
                                                        class="m-2 col-xl-3 col-3 "
                                                    >
                                                        <el-button
                                                            type="success"
                                                            @click="
                                                                showSplitPayment = true
                                                            "
                                                            >Dividir
                                                            pago</el-button
                                                        >
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-xl-4">
                                            <div
                                                class="col-xl-5"
                                                style="margin-bottom: 10px"
                                            ></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-md-12 col-12 d-flex justify-content-end"
                                        >
                                            <div
                                                class="form-group d-flex flex-row align-items-end"
                                                :class="{
                                                    'has-danger':
                                                        form.difference < 0
                                                }"
                                            >
                                                <div>
                                                    <el-checkbox
                                                        v-if="
                                                            registerInternetId
                                                        "
                                                        v-model="emit_sale_note"
                                                        >Nota de
                                                        venta</el-checkbox
                                                    ><br />
                                                    <el-checkbox
                                                        v-if="
                                                            form.difference >
                                                                0 && data
                                                        "
                                                        @change="changeIsCredit"
                                                        v-model="isCredit"
                                                        >Adelanto</el-checkbox
                                                    >
                                                </div>
                                                <label
                                                    style="margin-left: 10px"
                                                    class="control-label display-4 "
                                                    v-text="
                                                        form.difference < 0
                                                            ? 'A cuenta: '
                                                            : isCredit
                                                            ? 'Adelanto'
                                                            : 'Vuelto: '
                                                    "
                                                ></label>
                                                <span
                                                    class="
                            control-label
                            font-weight-semibold
                            text-center
                            display-3
                          "
                                                >
                                                    {{
                                                        currencyTypeActive.symbol
                                                    }}
                                                    {{
                                                        form.difference.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-if="splitPayments.length != 0"
                    class="row m-1 p-2 bg-light rounded"
                >
                    <span style="margin-bottom: 5px">Pagos divididos</span>
                    <div class="d-flex flex-wrap">
                        <div
                            v-for="(payment, idx) in splitPayments"
                            :key="idx"
                            class="col-2"
                        >
                            Pago {{ idx + 1 }}:
                            <strong>S/. {{ payment.amount }}</strong>
                        </div>
                    </div>
                </div>
                <div
                    v-if="splitProducts.length != 0"
                    class="row m-1 p-2 bg-light rounded"
                >
                    <span style="margin-bottom: 5px"
                        >Pagos divididos por producto</span
                    >
                    <div class="d-flex flex-wrap">
                        <div
                            v-for="(payment, idx) in splitProducts"
                            :key="idx"
                            class="col-3 m-1"
                        >
                            <table
                                v-if="
                                    payment.products &&
                                        payment.products.length > 0
                                "
                                class="col-12"
                            >
                                <thead>
                                    <tr
                                        role="button"
                                        @click="selectAccount(idx)"
                                        :class="
                                            'bg-primary text-white border rounded-top'
                                        "
                                    >
                                        <th class="text-center" colspan="3">
                                            <b> CUENTA {{ idx + 1 }} </b>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="border rounded-top"
                                    v-if="
                                        payment.products &&
                                            payment.products.length > 0
                                    "
                                >
                                    <tr
                                        v-for="(product,
                                        idx) in payment.products"
                                        :key="idx"
                                    >
                                        <td>
                                            <h3 class="text-muted text-small">
                                                {{ product.quantity }}
                                            </h3>
                                        </td>
                                        <td>
                                            <h3 class="text-muted text-small">
                                                {{ product.description }}
                                            </h3>
                                        </td>
                                        <td style="text-align: right">
                                            <h3 class="text-muted text-small">
                                                {{
                                                    product.price *
                                                        product.quantity
                                                }}
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            colspan="2"
                                            class="text-muted text-small"
                                            style="text-align: right"
                                        >
                                            <b> Total</b>
                                        </td>
                                        <td class="text-muted text-small">
                                            S/.
                                            {{
                                                totalItemSelected(
                                                    payment.products
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else class="border">
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <h3 class="text-muted text-small">
                                                Sin productos seleccionados
                                            </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="row">
                        <!-- <div class="col-md-4 col-12">
                            <label class="label-control"> Elija Caja </label>
                            <el-select v-model="cash_id">
                                <el-option
                                    v-for="(cash, idx) in cashes"
                                    :key="idx"
                                    :value="cash.id"
                                    :label="cash.reference_number"
                                ></el-option>
                            </el-select>
                        </div> -->
                        <div class="col-md-6 col-12 d-flex align-items-end">
                            <div
                                class="btn-group btn-group-square"
                                role="group"
                            >
                                <button
                                    class="btn btn-block btn-primary mr-3"
                                    @click="sendPayment"
                                    :disabled="button_payment"
                                >
                                    <i class="fas fa-money-bill-alt"></i>
                                    PAGAR
                                </button>
                                <button
                                    class="btn btn-block btn-dark"
                                    @click="back(false)"
                                >
                                    <i class="fa fa-reply"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<style>
.algunaClase .el-dialog .el-dialog__header .el-dialog__title {
    font-size: 35px !important;
}
.el-scrollbar {
    z-index: 2000 !important;
}
.c-width {
    width: 80px !important;
    padding: 0 !important;
    margin-right: 0 !important;
}
.control-label,
h4,
h5,
label {
    color: #000;
}
.to_rigth .el-input__inner {
    text-align: right;
}
</style>

<script>
// import * as shajs from 'sha.js';
import _ from "lodash";
// const RegisterForm = () => import("../views/classrooms/register_form.vue");
const ServiceForm = () => import("./service_form.vue");
// const IncompleteForm = () =>
//     import("../../js/components/payment_incomplete.vue");

export default {
    components: {
        ServiceForm
        //  RegisterForm, ServiceForm, IncompleteForm
    },

    props: [
        "updatePlan",
        "serviceItem",
        "isReconnection",
        "data",
        "record",
        "title",
        "customer_default",
        "is_payment",
        "member",
        "configuration",
        "desarrollador",
        "personalWhatsapp",
        "type",
        "register",
        "services",
        "periodObservation",
        "payable",
        "paymentItems",
        "registerInternetId",
        "all_series"
    ],
    watch: {
        all_customers(newCustomer, _) {
            this.customers = newCustomer.filter(n => n.number != "88888888");
        }
    },
    data() {
        return {
            credit: 0,
            isCredit: false,
            emit_sale_note: false,
            incomplete: false,
            cash_id: null,
            documentId: null,
            registerId: null,
            showDialog: false,
            series: [],
            affectationIgvTypes: [],
            establishments: null,
            methodPayment: [],
            currencyTypes: [],
            documentsType: [],
            variation: null,
            form: {
                reconnection: 0.0,
                reconnection_date: new Date(),
                afectar_caja: true,
                orden_id: null,
                customer_telephone: null,
                restaurant: true,
                total_rounded: 0.0,
                total_payment: 0.0,
                establishment_id: null,
                series_id: null,
                prefix: null,
                number: "#",
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                currency_type_id: "PEN",
                purchase_order: null,
                exchange_rate_sale: 1,
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
                operation_type_id: "0101",
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                hotel: {},
                additional_information: null,
                payment_condition_id: "01",
                printerOn: false,
                actions: {
                    format_pdf: "a4"
                },
                difference: 0.0,
                enter_amount: 0.0,
                method_pay: "Efectivo",
                commands_fisico: null,
                to_carry: false,
                document_type_id: "01"
                //  customer_id: 1
            },
            user: null,
            company: null,
            categories: [],
            observation: null,
            percentage_igv: 18,
            started: true,
            refCustomer: null,
            currentDocumentsType: [],
            time: null,
            splitPayments: [],
            splitProducts: [],
            isInterno: false,
            showSplitPayment: false,
            currencyTypeActive: {
                symbol: "S/ "
            },
            currentPayments: [],
            input_person: {},
            customer: null,
            value: null,
            paymentsValue: {
                "01": "Efectivo",
                "02": "Culqui",
                "03": "Yape",
                "04": "PLIN",
                "05": "TARJETA: IZYPAY",
                "06": "TARJETA: NIUBIZ",
                "07": "BBVA",
                "08": "BCP",
                "09": "Scotiabank",
                "10": "BCO NACION"
            },
            last_number: {},
            showDialogNewPerson: false,
            loading: false,
            enabled_discount: false,
            discount_amount: 0,
            loading_submit: false,
            showDialogOptions: false,
            showDialogMultiplePayment: false,
            showDialogSaleNote: false,
            showDialogNewCardBrand: false,
            documentNewId: null,
            saleNotesNewId: null,
            resource_options: null,
            has_card: false,
            method_payments: "01",
            number: null,
            resource: "pos",
            resource_documents: "documents",
            resource_payments: "document_payments",
            amount: 0,
            printerOn: 0,
            button_payment: false,
            input_item: "",
            form_payment: {},
            series: [],
            cards_brand: [],
            details: "",
            cancel: false,
            form_cash_document: {},
            formRegister: null,
            statusDocument: {},
            cashes: [],
            payment_method_types: [],
            last_date: null,
            customers: [],
            datEmision: {
                disabledDate(time) {
                    return time.getTime() > moment();
                }
            },
            activeColo: "black",
            socket: null,
            plan: {},

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
            ]
        };
    },
    mounted() {},
    async created() {
        await this.getTables();
        this.loading = true;
        this.details = "";
        this.currentDocumentsType = this.documentsType;
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
        // this.form.customer_id = this.establishments.customer_id;
        // this.value = this.establishments.customer_id;
        this.isInterno = this.company.soap_type_id == "03";

        // await this.date_of_issue();
        // await this.getLastNumbersDocument();
        await this.initFormPayment();
        //    await this.setInitialAmount();

        await this.getFormPosLocalStorage();

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
                    .post("/api/qz/signing", { request: toSign })
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                        reject(error.data);
                    });
            };
        });

        this.setAmountCash(this.form.total);

        // this.filterSeries();
        this.loading = false;
        this.socketWhatsappConfig();
    },

    methods: {
        updateReconexionDate() {
            let reconnection_date = moment(this.form.reconnection_date).format(
                "YYYY-MM-DD"
            );

            if (this.$refs.internet) {
                this.$refs.internet.changeInitialDate(reconnection_date);
            }
        },

        changeIsCredit() {
            if (this.isCredit) {
                let startDate;
                let lastDate;
                if (this.data.pay_date == this.data.date) {
                    startDate = moment(this.data.pay_date).add(1, "months");
                    lastDate = moment(startDate).add(1, "months");
                } else {
                    startDate = moment(this.data.pay_date);
                    lastDate = moment(startDate).add(1, "months");
                }
                let newObservation = `\nADELANTO DEL PERIODO ${moment(
                    startDate
                ).format("DD/MM/YYYY")} AL ${moment(lastDate).format(
                    "DD/MM/YYYY"
                )} : S/. ${this.form.difference}`;
                if (this.serviceItem) {
                    let serviceItem = { ...this.serviceItem };
                    serviceItem.sale_unit_price = this.form.difference;
                    serviceItem.percentage_igv = 18;
                    serviceItem.descriptionInternet = `Pago adelantado del periodo ${moment(
                        startDate
                    ).format("DD/MM/YYYY")} al ${moment(lastDate).format(
                        "DD/MM/YYYY"
                    )}`;

                    this.paymentItems.push(serviceItem);
                    this.$emit("addAdvance", {
                        startDate,
                        lastDate,
                        amount: this.form.difference,
                        state: "incomplete"
                    });
                }

                this.details += newObservation;
            } else {
                //remove from details the word that starts with Adelanto del periodo and ends with : S/. ${this.form.difference}
                //do it
                this.$emit("addAdvance", null);
                this.details = this.details.replace(
                    /\nADELANTO DEL PERIODO.*: S\/.*/,
                    ""
                );

                if (this.paymentItems.length > 1) {
                    this.paymentItems = this.paymentItems.pop();
                }
            }
        },
        async getRegisterData() {
            const response = await this.$http(
                `/internet/register/${this.registerInternetId}`
            );
            this.plan = response.data;

            let {
                item,
                total,
                name,
                person,
                series,
                credit,
                payments,
                payment_months
            } = this.plan;
            this.credit = credit || 0.0;
            this.updateCustomer(person);
            this.form.document_type_id =
                person.identity_document_type_id == "6" ? "01" : "03";
            let serie = series.find(
                s => s.document_type_id == this.form.document_type_id
            );
            this.form.series_id = serie.id;
            item.sale_unit_price = total;
            item.percentage_igv = 18;
            item.descriptionInternet = name;

            if (this.$refs.internet) {
                this.$refs.internet.setPaymentMonths(payment_months, payments);
                if (this.isReconnection) {
                    this.updateReconexionDate();
                }
                setTimeout(() => {
                    this.$refs.internet.updateTotal(item);
                }, 300);
            }
            // this.updateItems([item]);
        },
        changePrice(price) {
            //45
            //
            let countItems = this.form.items.length;
            let div = Math.floor(price / countItems);
            this.form.items = this.form.items.map(i => ({
                ...i,
                sale_unit_price: div,
                total: div,
                total_base_igv: div,
                total_value: div,
                unit_price: div,
                unit_price_value: div,
                unit_value: div
            }));

            let newTotalItems = div * countItems;
            let diff = price - newTotalItems;
            if (diff != 0) {
                let price = this.form.items[0].total + diff;
                this.form.items[0] = {
                    ...this.form.items[0],
                    sale_unit_price: price,
                    total: price,
                    total_base_igv: price,
                    total_value: price,
                    unit_price: price,
                    unit_price_value: price,
                    unit_value: price
                };
            }
        },
        async getFile({ documentId, documentTypeId, number, message }) {
            try {
                const response = await this.$http.post(
                    "/whatsapp/get-file",

                    {
                        document_id: documentId,
                        document_type_id: documentTypeId
                    }
                );
                const { pdf, xml, name } = response.data;
                let basicMessage =
                    "Su comprobante de pago electrónico " +
                    name +
                    " de *" +
                    this.company.name +
                    "*, ha sido generado correctamente a través del facturador electrónico de "+"*"+this.$desarrollador+"*"
                if (message) {
                    basicMessage += "\n" + message;
                }
                this.socket.emit("basicMessage", {
                    message: basicMessage,
                    sender: this.sender,
                    number: `51${number}`
                });

                // file, name, number, sender }
                this.socket.emit("sendFile", {
                    file: pdf,
                    name: `${name}.pdf`,
                    number: `51${number}`,
                    sender: this.sender
                });

                if (xml) {
                    this.socket.emit("sendFile", {
                        file: xml,
                        name: `${name}.xml`,
                        number: `51${number}`,
                        sender: this.sender
                    });
                }
            } catch (e) {
                let msg = "Ocurrió un error";
                if (e.response) {
                    const { response } = e;
                    if (response.status == 404) {
                        msg = "No se encontró la ruta";
                    } else {
                        msg = response.data.message;
                    }
                }
                this.$toast.error(msg);
                console.log(e);
            } finally {
            }
        },
        socketWhatsappConfig() {
            let hostName = window.location.hostname;
            let url = `https://${hostName}`;
            this.sender = hostName
                .replace(/https?\:\/\//, "")
                .replace("/", "")
                .split(".")
                .join("");
            try {
                this.socket = io.connect(this.$socketUrl);
            } catch (e) {
                console.log(e);
            }

            this.socket.on("connected", ({ message }) => {
                this.socket.emit("getStatus", url);
            });
            this.socket.on("setStatus", ({ status, sender }) => {
                if (!status) {
                    this.sender = "sdrimsac";
                } else {
                    this.sender = sender;
                }
            });
            //MessageResponse
            this.socket.on("MessageResponse", ({ success, message }) => {
                if (success) {
                    this.$toast.success(message);
                } else {
                    this.$toast.error(message);
                }
            });
        },
        updateCustomer(person) {
            this.form.customer = person;
            this.form.customer_id = person.id;
            this.form.customer_telephone = person.telephone;
        },
        updateObservation(obs) {
            this.details = obs;
            if (this.isReconnection) {
                this.details = "RECONEXION " + this.details;
            }
            this.$forceUpdate();
        },

        async open() {
            this.emit_sale_note = false;
            this.details = "";
            this.method_payments = "01";
            this.form.difference = 0;
            this.form.reconnection = 0;

            this.plan = {};
            if (this.registerInternetId) {
                await this.getRegisterData();
            }
            if (this.data) {
                this.form.customer_telephone = this.data.phone;
                if (this.periodObservation) {
                    this.details = this.periodObservation;
                }
            }
            setTimeout(() => {
                if (this.$refs.internet) {
                    // this.$refs.internet.setMonths();
                    this.$refs.internet.getTables();
                }

                this.updateItems(this.paymentItems ?? []);
            }, 250);

            if (this.type == "incomplete") {
                this.form.items = this.services.map(s => {
                    s.item.sale_unit_price = s.price;
                    s.item.percentage_igv = 18;

                    return s.item;
                });
            }
            if (this.isReconnection) {
                this.details = "RECONEXION\n";
            }
            // this.form = { ...this.paymentForm };
        },
        createFormIncomplete(register) {
            this.formRegister = register;
        },
        createFormRegister(register) {
            this.formRegister = register;
        },
        createFormService(register) {
            this.formRegister = register;
        },
        updateTotal(total) {
            this.form.total = total;
        },
        updateReconexion() {
            if (isNaN(this.form.reconnection)) {
                this.form.reconnection = 0;
            }
            if (this.form.reconnection <= 0) {
                this.form.reconnection = 0;
            }
            this.form.reconnection = parseFloat(this.form.reconnection);
            this.updateItems(this.form.items);
        },
        async updateItems(items = []) {
            if (this.isReconnection && this.form.reconnection >= 0) {
                let servicio = this.plan.item;
                this.form.items = items;
                if (servicio) {
                    let item = { ...servicio };
                    item.percentage_igv = 18;
                    item.descriptionInternet = "Reconexión";
                    item.sale_unit_price = this.form.reconnection || 0.0;
                    this.form.items = [
                        ...this.form.items.filter(
                            i => i.descriptionInternet != "Reconexión"
                        ),
                        item
                    ];
                }
            } else {
                this.form.items = items;
            }
            this.formatItems();
            this.reCalculateTotal();
            this.form.enter_amount = this.form.total;
            this.form.difference = 0;
            if (this.$refs.enter_amount && !this.isReconnection) {
                await this.$refs.enter_amount.$el
                    .getElementsByTagName("input")[0]
                    .select();
            }
        },
        async getTables() {
            try {
                this.loading = true;
                const response = await this.$http.get(
                    `/college/registers/payment_tables`
                );
                const {
                    affectation_igv_types,
                    establishment,
                    method_payment,
                    currency_types,
                    documents_type,
                    series,
                    user,
                    company,
                    categories,
                    cash_id
                } = response.data;
                this.cash_id = cash_id;
                this.affectationIgvTypes = affectation_igv_types;
                this.establishments = establishment;
                this.methodPayment = method_payment;
                this.currencyTypes = currency_types;
                this.series = series;
                this.documentsType = documents_type;
                this.user = user;
                this.company = company;
                this.categories = categories;
                this.form.user_id = this.user.id;
                this.form.establishment_id = this.establishments.id;
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
            }
        },
        existNumber() {
            let number = this.form.customer_telephone;
            if (!number.startsWith("9")) {
                return false;
            }
            if (number.length != 9) {
                return false;
            }
            if (isNaN(Number(number))) {
                return false;
            }
            return true;
        },
        createClient() {
            this.value = null;
            this.form.document_type_id;
            this.form.customer_id = null;
            this.showDialogNewPerson = true;
        },
        async reloadDataCustomers(customer_id) {
            this.$http.get(`/pos/table/customers`).then(async response => {
                await this.$emit("update:all_customers", response.data);
                this.value = customer_id;
                this.form.customer_id = customer_id;
                this.changeCustomer();
            });
        },
        totalItemSelected(products) {
            let total = 0;
            products.forEach(p => {
                total += p.quantity * p.price;
            });

            return _.round(total, 2);
        },
        receivePayments(payments) {
            this.splitPayments = payments;
        },
        receiveProducts(payments) {
            this.splitProducts = payments;
        },
        removePayment(id) {
            this.currentPayments = this.currentPayments.filter(c => c.id != id);
            this.enterAmount();
        },
        addPayment() {
            let id = this.currentPayments.length + 1;

            let method = this.paymentsValue[this.method_payments];

            if (
                this.form.enter_amount != "" &&
                !isNaN(this.form.enter_amount) &&
                this.form.enter_amount != undefined
            ) {
                this.currentPayments.push({
                    id,
                    method_payment_id: this.method_payments,
                    method,
                    amount: this.form.enter_amount
                });
            }
        },
        customerForm(isNew) {
            if (isNew) {
                this.form.customer_id = undefined;
            } else {
                this.form.customer_id = this.value;
            }
            this.showDialogNewPerson = true;
        },
        add_customer(value) {},
        reloadDataPersons() {},
        keyupCustomer(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;
                const response = await this.$http(
                    `/caja/search_customers?value=${this.input_person.number}`
                );
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");
                this.updateAllCustomers(this.customers);
            }, 500);
        },
        async updateAllCustomers(personsFromServer) {
            let ids = this.all_customers.map(c => c.id);
            let persons = [];

            for (let person of personsFromServer) {
                let existInList = ids.find(p => p == person.id);
                if (existInList == undefined) {
                    persons.push(person);
                }
            }
            let newData = [...this.all_customers, ...persons];

            if (persons.length != 0) {
                await this.$emit("update:all_customers", newData);
            }
        },
        changeCustomer() {
            this.form.customer_id = this.value;
            let customer = _.find(this.customers, {
                id: this.form.customer_id
            });

            if (customer != null) {
                this.customer = customer;
                if (this.form.document_type_id != "80") {
                    if (
                        customer.identity_document_type_id == "1" ||
                        customer.identity_document_type_id == "4"
                    ) {
                        this.form.document_type_id = "03";
                    } else {
                        this.form.document_type_id = "01";
                    }
                }

                this.form.customer_telephone = customer.phone;
                this.setLocalStorageIndex("customer", this.customer);
            }
            this.setSeries();
        },
        setLocalStorageIndex(key, obj) {
            localStorage.setItem(key, JSON.stringify(obj));
        },
        async getLastNumbersDocument() {
            const response = await this.$http.post(
                `${this.resource}/last_number_documents`,
                { series: this.all_series, ordenId: this.idOrden }
            );
            if (response.status == 200) {
                this.last_number = response.data.result;
                this.refCustomer = response.data.customer;
                if (this.refCustomer != null) {
                    this.refCustomer.description = `${this.refCustomer.number} - ${this.refCustomer.name}`;
                    this.customers = [
                        this.refCustomer,
                        ...this.customers.filter(
                            f =>
                                f.id != this.refCustomer.id &&
                                f.number != "88888888"
                        )
                    ];

                    this.value = this.refCustomer.id;
                }
            }
        },
        changeEnabledDiscount() {
            if (!this.enabled_discount) {
                this.discount_amount = 0;
                this.deleteDiscountGlobal();
                this.reCalculateTotal();
            }
        },

        async date_of_issue() {
            // this.form.customer_id

            this.customers = this.all_customers.filter(
                n => n.number != "88888888"
            );
            this.customers = [
                ...this.customers.filter(c => c.id != this.customer_default.id),
                this.customer_default
            ];

            if (this.establishments.customer_id) {
                this.value = this.establishments.customer_id;
                this.form.customer_id = this.establishments.customer_id;
            }

            let form_efectivo = {
                enter_amount: 0,
                difference: 0
            };
            const response_efectivo = await this.$http.post(
                `/efectivo`,
                form_efectivo
            );
        },
        async Printer(
            Printer,
            linkpdf,
            copies,
            auth = null,
            multiple_boxes = false
        ) {
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
            if (this.printerOn == 1) {
                if (multiple_boxes == true) {
                    if (true) {
                        let config = qz.configs.create(Printer, {
                            scaleContent: false
                        });
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
                    }
                }
                if (multiple_boxes == false) {
                    let config = qz.configs.create(Printer, {
                        scaleContent: false
                    });
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
                }
            }
        },
        async clickSendWhatsapp(
            document_type_id,
            document_id,
            number,
            form = {}
        ) {
            if (form.customer_telephone != null) {
                let formWhatsapp = {
                    id: this.recordId,
                    document_id: document_id,
                    document_type_id: document_type_id,
                    customer_telephone: form.customer_telephone,
                    sender: "sdrimsac",
                    mensaje:
                        "Su comprobante de pago electrónico " +
                        number +
                        " de *" +
                        this.company.name +
                        "*, ha sido generado correctamente a través del facturador electrónico de "+"*"+this.$desarrollador+"*"
                };
                try {
                    this.loading = true;
                    let response = await this.$http.post(
                        `/whatsapp`,
                        formWhatsapp
                    );
                    if (response.data.success == true) {
                        this.$toast.success(response.data.message);
                        this.loading = false;
                    }

                    if (
                        this.configuration.xml_whatsapp &&
                        document_type_id != "80"
                    ) {
                        formWhatsapp.xml = true;
                        response = await this.$http.post(
                            `/whatsapp`,
                            formWhatsapp
                        );
                        if (response.data.success == true) {
                            this.$toast.success(response.data.message);
                            this.loading = false;
                        }
                    }
                } catch (e) {
                    console.log(e, " error");
                } finally {
                    this.loading = false;
                }
            }
        },
        changeDateOfIssue() {
            this.form.date_of_due = this.form.date_of_issue;
            if (
                moment(this.form.date_of_issue) < moment().day(-1) &&
                this.configuration.restrict_receipt_date
            ) {
                this.$toast.error(
                    "No puede seleccionar una fecha menor a 6 días."
                );
                this.dateValid = false;
            } else {
                this.dateValid = true;
            }
            this.form.date_of_due = this.form.date_of_issue;
            this.searchExchangeRateByDate(this.form.date_of_issue).then(
                response => {
                    this.form.exchange_rate_sale = response;
                }
            );
            this.form.exchange_rate_sale = 1;
        },

        async setInitialAmount() {
            this.enter_amount = this.form.total;
            this.form.payments = [];
            await this.$refs.enter_amount.$el
                .getElementsByTagName("input")[0]
                .focus();
            await this.$refs.enter_amount.$el
                .getElementsByTagName("input")[0]
                .select();
        },
        inputDiscountAmount() {
            if (this.enabled_discount) {
                if (
                    this.discount_amount &&
                    !isNaN(this.discount_amount) &&
                    parseFloat(this.discount_amount) > 0
                ) {
                    if (this.discount_amount >= this.form.total)
                        return this.$toast.error(
                            "El monto de descuento debe ser menor al total de venta"
                        );

                    this.reCalculateTotal();
                } else {
                    this.deleteDiscountGlobal();
                    this.reCalculateTotal();
                }
            }
        },
        discountGlobal() {
            let global_discount = parseFloat(this.discount_amount);
            let base = parseFloat(this.form.total);
            let amount = parseFloat(global_discount);
            let factor = _.round(amount / base, 4);

            let discount = _.find(this.form.discounts, {
                discount_type_id: "03"
            });

            if (global_discount > 0 && !discount) {
                this.form.total_discount = _.round(amount, 2);

                this.form.total = _.round(this.form.total - amount, 2);

                this.form.total_value = _.round(
                    this.form.total / (1 + this.percentage_igv / 100),
                    2
                );
                this.form.total_taxed = this.form.total_value;

                this.form.total_igv = _.round(
                    this.form.total_value * (this.percentage_igv / 100),
                    2
                );
                this.form.total_taxes = this.form.total_igv;

                this.form.discounts.push({
                    discount_type_id: "03",
                    description:
                        "Descuentos globales que no afectan la base imponible del IGV/IVAP",
                    factor: factor,
                    amount: amount,
                    base: base
                });
            } else {
                let index = this.form.discounts.indexOf(discount);

                if (index > -1) {
                    this.form.total_discount = _.round(amount, 2);
                    this.form.total = _.round(this.form.total - amount, 2);
                    this.form.total_value = _.round(
                        this.form.total / (1 + this.percentage_igv / 100),
                        2
                    );
                    this.form.total_taxed = this.form.total_value;
                    this.form.total_igv = _.round(
                        this.form.total_value * (this.percentage_igv / 100),
                        2
                    );
                    this.form.total_taxes = this.form.total_igv;

                    this.form.discounts[index].base = base;
                    this.form.discounts[index].amount = amount;
                    this.form.discounts[index].factor = factor;
                }
            }
        },
        method_payment(method_pay) {
            this.form.payment_condition_id = "01";
            this.form.method_pay = method_pay;
            this.form.afectar_caja = true;
        },
        reCalculateTotal() {
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
            this.form.total = _.round(total, 2);

            // this.form.total = _.round(
            //     total + this.form.total_plastic_bag_taxes,
            //     2
            // );

            // this.discountGlobal();

            // this.form.difference =
            //     this.form.total - (this.form.enter_amount || 0);
        },
        deleteDiscountGlobal() {
            let discount = _.find(this.form.discounts, {
                discount_type_id: "03"
            });
            let index = this.form.discounts.indexOf(discount);

            if (index > -1) {
                this.form.discounts.splice(index, 1);
                this.form.total_discount = 0;
            }
        },

        getFormPosLocalStorage() {
            let form_pos = localStorage.getItem("form_pos");
            form_pos = JSON.parse(form_pos);
            if (form_pos) {
                this.form.payments = form_pos.payments;
            }
        },
        clickAddPayment() {
            this.showDialogMultiplePayment = true;
        },
        reloadDataCardBrands(card_brand_id) {
            this.$http
                .get(`/${this.resource}/table/card_brands`)
                .then(response => {
                    this.cards_brand = response.data;
                    this.form_payment.card_brand_id = card_brand_id;
                    this.changePaymentMethodType();
                });
        },
        getDescriptionPaymentMethodType(id) {
            let payment_method_type = _.find(this.payment_method_types, {
                id: id
            });
            return payment_method_type ? payment_method_type.description : "";
        },
        changePaymentMethodType() {
            let payment_method_type = _.find(this.payment_method_types, {
                id: this.form_payment.payment_method_type_id
            });
            this.has_card = payment_method_type.has_card;
            this.form_payment.card_brand_id = payment_method_type.has_card
                ? this.form_payment.card_brand_id
                : null;
        },
        addRow(payments) {
            this.form.payments = payments;
            let acum_payment = 0;

            this.form.payments.forEach(item => {
                acum_payment += parseFloat(item.payment);
            });
            // this.amount = acum_payment
            this.setAmount(acum_payment);
        },
        setAmount(amount) {
            // this.amount = parseFloat(this.amount) + parseFloat(amount)
            this.form.enter_amount = amount;
            this.amount = parseFloat(amount); //+ parseFloat(amount)
            //   this.form.enter_amount =  parseFloat(amount) //+ parseFloat(amount)
            this.inputAmount(amount);
        },
        setAmountCash(amount) {
            this.setAmount(amount);
        },
        async diferen() {
            let differen =
                (parseFloat(this.form.enter_amount) || 0) +
                this.totalPayments() -
                parseFloat(this.form.total);
            if (differen < 0) {
                // this.$toast.error(
                //     "El monto de efectivo es menor al total de venta"
                // );
            }
        },
        totalPayments() {
            if (this.currentPayments.length != 0) {
                let enter_amount = 0.0;
                this.currentPayments.forEach(cp => {
                    enter_amount += parseFloat(cp.amount);
                });
                return enter_amount;
            }
            return 0;
        },
        async enterAmount(amount = 0) {
            this.isCredit = false;
            this.amount = amount;

            let enter_amount = parseFloat(this.form.enter_amount) || 0;
            // +this.totalPayments();

            let differen = enter_amount - parseFloat(this.form.total);

            this.form.difference = parseFloat(differen);

            if (this.form.difference < 0) {
                // this.button_payment = true;
                this.form.difference = differen;
            } else if (this.form.difference >= 0) {
                this.button_payment = false;
                parseFloat(this.form.enter_amount) -
                    parseFloat(this.form.total);
            } else {
                // this.button_payment = true;
            }
            //this.form.difference = _.round(this.form.difference, 2);

            // this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
            // this.setAmountCash(amount)
        },
        getLocalStoragePayment(key, re_default = null) {
            let ls_obj = localStorage.getItem(key);
            ls_obj = JSON.parse(ls_obj);

            if (ls_obj) {
                return ls_obj;
            }

            return re_default;
        },
        setLocalStoragePayment(key, obj) {
            return localStorage.setItem(key, JSON.stringify(obj));
        },
        inputAmount(amount = null) {
            this.enterAmount(amount);
            this.form.difference = this.form.enter_amount - this.form.total;
            if (isNaN(this.form.difference)) {
                // this.button_payment = true;
                this.form.difference = "-";
            } else if (this.form.difference >= 0) {
                this.button_payment = false;
                this.form.difference = this.amount - this.form.total;
            } else {
                // this.button_payment = true;
            }
            this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
        },
        lStoPayment() {
            this.setLocalStoragePayment("enter_amount", this.form.enter_amount);
            this.setLocalStoragePayment(
                "amount",
                this.amount == 0 ? this.form.total : this.amount
            );
            this.setLocalStoragePayment(
                "difference",
                this.amount == 0 ? this.form.total - this.amount : 0
            );
        },
        initFormPayment() {
            this.form.difference = 15; //this.form.total - this.form.enter_amount;
            this.form_payment = {
                id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: "01",
                reference: null,
                card_brand_id: null,
                document_id: null,
                sale_note_id: null,
                payment: this.form.total
            };

            this.form_cash_document = {
                document_id: null,
                sale_note_id: null
            };
        },

        cleanLocalStoragePayment() {
            this.setLocalStoragePayment("form_pos", null);
            this.setLocalStoragePayment("amount", null);
            this.setLocalStoragePayment("enter_amount", null);
            this.setLocalStoragePayment("difference", null);
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
        passBoxes(total, boxes) {
            let amounts = boxes.reduce((a, b) => a + b.amount, 0);
            let rest = amounts - total;
            let plus = false;
            if (rest < 0) {
                plus = true;
                rest *= -1;
            }
            let newBoxes = [...boxes];

            if (rest != 0) {
                for (let i = 0; i < newBoxes.length; i++) {
                    let box = newBoxes[i];
                    if (plus) {
                        box.amount += rest;
                        rest = 0;
                    } else {
                        if (box.amount - rest > 0) {
                            box.amount -= rest;
                            rest = 0;
                        }
                    }

                    if (rest == 0) {
                        break;
                    }
                }
            }
            return newBoxes;
        },
        async sendPayment($event, form = null) {
            if (this.formRegister && this.formRegister.update) {
                if (!this.formRegister.plan_variation_id) {
                    this.$toast.error("Seleccione un plan nuevo");
                    return;
                }
            }
            if (!this.cash_id) {
                this.$toast.error("Seleccione o abra una caja.");
                return;
            }

            let payIncomplete = false;
            let different =
                parseFloat(this.form.enter_amount) -
                parseFloat(this.form.total);
            if (different < 0) {
                try {
                    await this.$confirm(
                        `Hay un saldo por cobrar de ${different * -1}`,
                        "Saldo",
                        {
                            distinguishCancelAndClose: true,
                            confirmButtonText: "Pagar",
                            cancelButtonText: "Cambiar cantidad"
                        }
                    );
                    payIncomplete = true;
                } catch (e) {
                    return;
                }
            }

            if (payIncomplete) {
                this.incomplete = true;
                let newPrice = isNaN(parseFloat(this.form.enter_amount))
                    ? 0
                    : parseFloat(this.form.enter_amount);
                //45

                this.changePrice(newPrice);
                this.reCalculateTotal();
            }
            if (this.form.total == 0) {
                if (this.data) {
                    if (!this.data.oldClient && this.registerInternetId ) {
                        this.$toast.error("Monto inválido.");
                        return;
                    }
                } else {
                    this.$toast.error("Monto inválido.");
                    return;
                }
            }
            this.form.cash_id = this.cash_id;
            if (!form) {
                form = this.form;
            }
            if (this.data) {
                this.form.document_type_id = this.data.document_type_id;
                this.form.series_id = this.data.serie_id;
                this.form.customer_id = this.data.person_id;
            }

            form.printerOn = this.printerOn == 1 ? true : false;
            let registered = true;
            // if (this.type != "incomplete") {
            //     registered = await this.sendRegister();
            // } else {
            //     this.registerId = this.register.id;
            // }
            //esto funciona con la instalacion
            if (this.isCredit) {
                this.form.difference = 0;
                this.updateItems(this.paymentItems);
            }
            let payed = await this.clickPayment(form);
            if (payed) {
                if (this.data) {
                    await this.registerInstall(form.document_type_id);
                } else {
                    await this.registerPayment(
                        this.form.document_type_id,
                        this.documentNewId
                    );
                }

                this.$emit("getRegisters");
            }

            // if (registered) {
            //     if (payed) {
            //         await this.sendCollegePayment();
            //     }
            // }
        },
        async registerPayment(document_type_id, document_id) {
            let form = this.formRegister || {
                operation_id: this.plan.operation_id
            };

            form.document_type_id = document_type_id;
            form.document_id = document_id;
            if (this.isReconnection) {
                form.reconnection = true;
                form.reconnection_date = this.form.reconnection_date;
            }

            form.type = this.form.difference < 0 ? "incomplete" : "complete";

            if (form.update) {
                if (form.type == "incomplete") {
                    form.rest += Number(this.form.difference) * -1;
                }
            }
            let url = form.update ? `/internet/update` : `/internet/payments`;
            try {
                const response = await this.$http.post(url, form);
            } catch (e) {
                console.log(e);
            } finally {
            }
        },
        async registerInstall(document_type_id) {
            let form = this.data;
            form.documentId = this.documentNewId;
            form.document_type_id = document_type_id;
            try {
                const response = await this.$http.post(`/internet`, this.data);
            } catch (e) {
                console.log(e);
            } finally {
            }
        },

        formatItems() {
            this.form.items = this.form.items.map(i => {
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
        async clickPayment(form) {
            //identity_document_type_id
            //

            if (!this.form.cash_id) {
                this.$toast.error("Seleccione o abra una caja.");
                return;
            }
            let customer = form.customer;
            // if (
            //     customer.identity_document_type_id == "1" ||
            //     customer.identity_document_type_id == "F"
            // ) {
            //     form.document_type_id = "03";
            // } else {
            //     form.document_type_id = "01";
            // }

            // let serie = this.series.find(
            //     s => s.document_type_id == form.document_type_id
            // );
            // this.form.series_id = serie.id;
            if (
                form.customer_telephone != null &&
                form.customer_telephone != ""
            ) {
                if (!this.existNumber()) {
                    this.$toast.error("Número para envío whatsapp inválido");
                    return;
                }
            }
            if (form.customer_id == null || form.customer_id == "") {
                return this.$toast.error("Elija un cliente");
            }
            // if (
            //     customer.identity_document_type_id == "1" &&
            //     form.document_type_id == "01"
            // ) {
            //     return this.$toast.error("No puede emitir Factura con DNI");
            // }
            // if (!form.series_id) {
            //     return this.$toast.warning(
            //         "El establecimiento no tiene series disponibles para el comprobante"
            //     );
            // }
            if (this.emit_sale_note) {
                this.form.document_type_id = "80";
                this.setSeries();
            }
            if (form.document_type_id === "80") {
                form.prefix = "NV";
                form.paid = 1;
                this.resource_documents = "sale-notes";
                this.resource_payments = "sale_note_payments";
                this.resource_options = this.resource_documents;
            } else {
                form.prefix = null;
                this.resource_documents = "documents";
                this.resource_payments = "document_payments";
                this.resource_options = this.resource_documents;
            }
            // form.prefix = null;
            // this.resource_documents = "documents";
            // this.resource_payments = "document_payments";
            // this.resource_options = this.resource_documents;

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

            form.boxes = this.currentPayments;
            this.addPayment();
            this.form.observation =
                this.details + "\n" + (this.observation || "");
            this.loading_submit = true;
            this.form.items = this.form.items.filter(i => i.total > 0);
            try {
                form.orden_id = null;

                const response = await this.$http.post(
                    `/${this.resource_documents}`,
                    form
                );

                if (response.status == 200) {
                    if (response.data.success == true) {
                        this.documentId = response.data.data.id;
                        this.form_cash_document.document_id =
                            response.data.data.id;
                        this.number = response.data.data.number;
                        this.documentNewId = response.data.data.id;

                        if (response.data.success == true) {
                            if (this.form.customer_telephone) {
                                if (this.personalWhatsapp) {
                                    await this.getFile({
                                        documentId: this.documentNewId,
                                        documentTypeId: form.document_type_id,
                                        number: this.form.customer_telephone,
                                        message: this.form.message
                                    });
                                } else {
                                    await this.clickSendWhatsapp(
                                        form.document_type_id,
                                        this.documentNewId,
                                        this.number,
                                        form
                                    );
                                }
                                this.loading_submit = false;

                                this.back(true);
                            } else {
                                this.loading_submit = false;

                                this.back(true);
                            }
                        }
                        return true;
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
                    return false;
                }
            } catch (error) {
                console.log(error);
                const response = error.response;
                let {
                    data: { message }
                } = response;

                this.$toast.error(message || "Ocurrió un error");

                return false;
            } finally {
                this.loading_submit = false;
            }
        },

        async clickPrintPos(printerName, formatoPdf, userId = null) {
            try {
                let config = qz.configs.create(
                    printerName,
                    { legacy: true },
                    { scaleContent: false }
                );
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: formatoPdf
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });
            } catch (e) {
                this.$toast.error(e.message);
            }
        },
        saveCashDocument() {
            this.$http
                .post(`/cash/cash_document`, this.form_cash_document)
                .then(response => {
                    if (response.data.success) {
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        savePaymentMethod() {
            this.$http
                .post(`/${this.resource_payments}`, this.form_payment)
                .then(response => {
                    if (response.data.success) {
                        // console.log(response)
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.records[index].errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                });
        },

        async clickCancel() {
            this.loading_submit = true;

            this.loading_submit = false;
            this.cleanLocalStoragePayment();
            this.$eventHub.$emit("cancelSale");
        },
        back(val = false) {
            this.incomplete = false;
            this.currentPayments = [];
            this.form.total = 0;
            this.form.customer_telephone = null;
            this.form.enter_amount = undefined;
            
            this.observation = null;
            this.documentId = null;
            this.registerId = null;
            if (this.type == "service") {
                this.$refs.service.initForm();
            } else if (this.type == "register") {
                this.$refs.register.initForm();
            } else if (this.type == "incomplete") {
                this.$refs.incomplete.initForm();
            } else {
                // console.log("object");
            }

            this.splitPayments = [];
            //this.$emit("limpiarForm");
            if (!val) {
                this.$emit("openDrawer");
            }
            this.$emit("update:is_payment", false);
        },
        async initLStoPayment() {
            this.amount = await this.getLocalStoragePayment(
                "amount",
                this.form.total
            );
            this.form.enter_amount = await this.getLocalStoragePayment(
                "enter_amount",
                this.form.total
            );
            this.form.difference = await this.getLocalStoragePayment(
                "difference",
                this.form.total - this.form.enter_amount
            );
        },
        checkCustomers() {
            if (this.form.document_type_id == "01") {
                return this.customers.some(
                    c => c.identity_document_type_id == "6"
                );
            } else {
                return this.customers.some(
                    c => c.identity_document_type_id == "1"
                );
            }
        },
        setSeries() {
            this.form.series_id = null;
            this.series = _.filter(this.all_series, {
                document_type_id: this.form.document_type_id
            });
            this.series.forEach(s => {
                s.full_number =
                    `${s.number}-${this.last_number[s.number] || "1"}` ||
                    s.number;
            });
            this.form.series_id =
                this.series.length > 0 ? this.series[0].id : null;
        },

        filterSeries() {
            let check = this.checkCustomers();
            if (!check && !this.started) {
                let dcto = "DNI";
                if (this.form.document_type_id == "01") {
                    dcto = "RUC";
                    this.form.document_type_id = "03";
                } else {
                    this.form.document_type_id = "01";
                }
                this.$toast.warning(`Digite el número de ${dcto}`);

                this.setSeries();
                return;
            }
            this.started = false;

            if (this.form.document_type_id == "01") {
                this.currentDocumentsType = [
                    ...this.documentsType.filter(f => f.description == "RUC")
                ];
                this.form.identity_document_type_id = this.currentDocumentsType[0].id;
            } else {
                this.currentDocumentsType = this.documentsType;
            }
            this.setSeries();
        }
    }
};
</script>
