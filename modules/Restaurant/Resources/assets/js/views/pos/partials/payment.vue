<template>
    <el-dialog
        :visible="is_payment"
        @open="date_of_issue"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :modal-append-to-body="true"
        :show-close="false"
        :append-to-body="true"
        width="850px"
        top="2vh"
        :title="`MODULO DE COBRO ${variation ? '- Variación' : ''}`"
        class="algunaClase"
    >
        <div v-loading="loading" class=" mb-0">
            <div
                class="pt-1"
                v-loading="loading_submit"
                :element-loading-text="loadingText"
            >
                <div class="d-flex pt-2 justify-content-end">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="showListItems = true"
                    >
                        <i class="fas fa-clipboard-list"></i>
                    </el-button>
                </div>
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <div class="mb-2">
                            <div class="card bg-light">
                                <div class="row" v-if="configuration.college">
                                    <el-checkbox
                                        @change="chageRegister"
                                        v-model="notRegister"
                                        >No registrado</el-checkbox
                                    >
                                </div>
                                <div class="row ">
                                    <div class="  col-md-6 col-lg-5 col-sm-6">
                                        <label class="control-label"
                                            >Comprobante de Pago
                                        </label>
                                        <div class="form-group">
                                            <el-radio-group
                                                v-model="form.document_type_id"
                                                size="small"
                                                @change="filterSeries()"
                                            >
                                                <template v-if="!isInterno">
                                                    <el-radio-button
                                                        v-if="invoice"
                                                        label="01"
                                                        >FACTURA
                                                    </el-radio-button>
                                                    <el-radio-button
                                                        v-if="receipt"
                                                        label="03"
                                                    >
                                                        BOLETA
                                                    </el-radio-button>
                                                </template>
                                                <el-radio-button
                                                    v-if="
                                                        !variation &&
                                                            sale_note &&
                                                            !clientSaleNoteNumber
                                                    "
                                                    label="80"
                                                >
                                                    N. VENTA
                                                </el-radio-button>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                    <div
                                        class="col-6 col-md-3 col-lg-3 col-xl-3"
                                    >
                                        <label class="control-label">
                                            Serie
                                        </label>
                                        <div class="form-group">
                                            <el-select
                                                v-model="form.series_id"
                                                class="w-100"
                                            >
                                                <el-option
                                                    style="z-index:2000 !important;"
                                                    v-for="option in series"
                                                    :key="option.id"
                                                    :label="option.full_number"
                                                    :value="option.id"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-4 col-lg-4 ">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Fecha de Emisión</label
                                            >
                                            <el-date-picker
                                                style="width:100%;"
                                                v-model="form.date_of_issue"
                                                type="date"
                                                value-format="yyyy-MM-dd"
                                                :clearable="false"
                                                format="dd-MM-yyyy"
                                                :readonly="
                                                    this.configuration
                                                        .restrict_receipt_date
                                                "
                                                @change="changeDateOfIssue"
                                            >
                                            </el-date-picker>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-lg-6 ">
                                        <div class="form-group">
                                            <template>
                                                <div
                                                    class="el-input el-input-group col-md-6 "
                                                    style="margin-bottom:3px;"
                                                >
                                                    <label
                                                        class="control-label"
                                                        style="margin-right:3px;"
                                                        >Cliente</label
                                                    >
                                                    <el-button
                                                        :disabled="
                                                            !value ||
                                                                isClientesVarios()
                                                        "
                                                        @click="
                                                            openDialogPerson
                                                        "
                                                        >Editar
                                                        cliente</el-button
                                                    >
                                                    <el-button
                                                        v-if="
                                                            !configuration.college ||
                                                                notRegister
                                                        "
                                                        @click="createClient"
                                                        >Nuevo
                                                        cliente</el-button
                                                    >
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <el-select
                                            class="col-md-6"
                                            ref="select_person"
                                            v-model="value"
                                            filterable
                                            clearable
                                            size="small"
                                            placeholder="Cliente"
                                            :disabled="loading"
                                            @change="changeCustomer"
                                            @keyup.native="keyupCustomer"
                                        >
                                            <el-option
                                                v-for="(option,
                                                idx) in customers"
                                                :key="idx"
                                                :label="option.description"
                                                :value="option.id"
                                            ></el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div
                                    v-if="students.length != 0"
                                    class="row col-lg-6 col-xl-12"
                                >
                                    <div class="form-group">
                                        <label class="control-label w-100"
                                            >Estudiante</label
                                        >
                                        <el-select
                                            @change="changeStudent"
                                            v-model="form.student_id"
                                        >
                                            <el-option
                                                v-for="(student,
                                                idx) in students"
                                                :key="idx"
                                                :label="
                                                    `${student.name} - ${student.class}`
                                                "
                                                :value="student.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div
                                    class="row"
                                    v-if="configuration.seller_caja"
                                >
                                    <div class="col-md-4 col-12">
                                        <label for="seller">Vendedor</label>
                                        <el-select v-model="form.seller_id">
                                            <el-option
                                                v-for="(option, idx) in sellers"
                                                :key="idx"
                                                :label="option.name"
                                                :value="option.id"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row col-lg-12 col-xl-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Observaciones</label
                                        >
                                        <el-input
                                            ref="observation"
                                            type="textarea"
                                            :rows="2"
                                            :placeholder="bank"
                                            v-model="form.observation"
                                        ></el-input>
                                    </div>
                                </div>
                                <template
                                    v-if="configuration.show_coins_to_receive"
                                >
                                    <div
                                        class="m-2 d-flex justify-content-center align-items"
                                    >
                                        <template v-if="sumCoins.length == 0">
                                            Billetes/Monedas a recibir
                                        </template>
                                        <template v-else>
                                            {{ formatSumCoins }}
                                        </template>
                                    </div>
                                    <div
                                        class="d-flex justify-content-center align-items-center"
                                    >
                                        <el-button-group
                                            class="d-flex flex-wrap justify-content-center"
                                        >
                                            <el-button
                                                v-for="(coin, idx) in coins"
                                                type="primary"
                                                :key="idx"
                                                @click="addCoin(coin.id)"
                                                size="small"
                                                round
                                            >
                                                {{ coin.id }}</el-button
                                            >
                                            <!-- un boton con el icono de tacho de basura que al dar click setee sumCoins a null -->
                                            <el-button
                                                type="danger"
                                                @click="clearSumCoins"
                                                size="small"
                                                round
                                            >
                                                <i class="fas fa-trash"></i>
                                            </el-button>
                                        </el-button-group>
                                    </div>
                                </template>
                                <div class="col-md-4 form-group">
                                    <label class="control-label"
                                        >Monto Descuento</label
                                    >
                                    <el-input-number
                                        :min="0"
                                        controls-position="right"
                                        @change="inputDiscountAmount"
                                        class="w-100"
                                        v-model="discount_amount"
                                    ></el-input-number>
                                </div>
                                <div
                                    v-if="
                                        configuration.affectation_igv_type_id ==
                                            '10'
                                    "
                                    class="col-md-4 form-group"
                                >
                                    <label class="control-label"
                                        >Tipo de descuento</label
                                    >
                                    <el-checkbox
                                        v-model="discountTotal"
                                        @change="reCalculateTotal"
                                    >
                                        {{
                                            discountTotal
                                                ? "Descuento del total"
                                                : "Descuento a la base"
                                        }}
                                    </el-checkbox>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class=" mb-2 ">
                        <div class=" text-center text-dark card  bg-light  ">
                            <div class="row">
                                <div class="  col-lg-6 ">
                                    <div class=" align-items-start ">
                                        <label class="control-label"
                                            >Medios de Pago</label
                                        >
                                        <label
                                            role="button"
                                            class="text-primary control-label"
                                        ></label>
                                    </div>
                                    <div class="radio-tile-group2 flex-wrap">
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="cash"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="01"
                                                @change="
                                                    method_payment('Efectivo')
                                                "
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/botonEfectivo.png') ; background-size: contain ; background-repeat: no-repeat"
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
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="culqui"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="02"
                                                @change="
                                                    method_payment('Culqui')
                                                "
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/CulquiIcon.png') ; background-size: contain ; background-repeat: no-repeat"
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="plin"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="05"
                                                @change="
                                                    method_payment(
                                                        'TARJETA: IZYPAY'
                                                    )
                                                "
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/botonIzipay.png') ; background-size: contain ; background-repeat: no-repeat; "
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="plin"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="07"
                                                @change="
                                                    method_payment(
                                                        'TARJETA: OPENPAY'
                                                    )
                                                "
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/botonOpenpay.png') ; background-size: contain ; background-repeat: no-repeat; "
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="plin"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="06"
                                                @change="
                                                    method_payment(
                                                        'TARJETA: NIUBIZ'
                                                    )
                                                "
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/botonNiubiz.png') ; background-size: contain ; background-repeat: no-repeat; "
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="yape"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="03"
                                                @change="method_payment('Yape')"
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat"
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                        <div
                                            class="input-container2 border rounded-sm"
                                        >
                                            <input
                                                :disabled="form_payment.is_bank"
                                                id="plin"
                                                v-model="method_payments"
                                                class="radio-button2"
                                                type="radio"
                                                name="method_payment"
                                                value="04"
                                                @change="method_payment('PLIN')"
                                            />
                                            <div
                                                class="radio-tile2"
                                                style="background-image: url('../../images/plin-logo-0C4106153C-seeklogo.com.png') ; background-size: contain ; background-repeat: no-repeat; "
                                            >
                                                <div
                                                    class="icon bike-icon"
                                                ></div>
                                                <label
                                                    for="Tarjeta"
                                                    class="radio-tile-label2"
                                                ></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <div
                                            class="mt-2 d-flex justify-content-start align-items-end"
                                            v-if="
                                                hasCreditCardCharge &&
                                                    configuration.credit_mode
                                            "
                                        >
                                            <div class="col-md-6">
                                                <label
                                                    class="w-100"
                                                    style="text-align:left;"
                                                >
                                                    {{
                                                        chargeCredit.credit_type ==
                                                        "1"
                                                            ? "Porcentaje"
                                                            : "Monto"
                                                    }}
                                                </label>
                                                <el-input
                                                    type="number"
                                                    @input="calculateCharge"
                                                    class="w-100"
                                                    v-model="
                                                        chargeCredit.amount
                                                    "
                                                >
                                                </el-input>
                                            </div>
                                            <div
                                                class="col-md-3"
                                                style="text-align:left;margin-left:5px;"
                                            >
                                                <el-radio-group
                                                    class="d-flex"
                                                    @change="calculateCharge"
                                                    v-model="
                                                        chargeCredit.credit_type
                                                    "
                                                    size="small"
                                                >
                                                    <el-radio-button label="1"
                                                        >%</el-radio-button
                                                    >
                                                    <el-radio-button label="2"
                                                        >S/</el-radio-button
                                                    >
                                                </el-radio-group>
                                            </div>
                                            <div
                                                class="col-md-3 align-self-center mt-4"
                                                style="text-align:left;margin-left:5px;"
                                            >
                                                <label
                                                    class="h5"
                                                    v-if="
                                                        chargeCredit.total_charge !=
                                                            0 &&
                                                            chargeCredit.amount
                                                    "
                                                >
                                                    S/
                                                    {{
                                                        chargeCredit.total_charge.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <template v-if="bank_accounts.length != 0">
                                        <label for="banks">
                                            <el-checkbox
                                                @change="transferPayment"
                                                v-model="form_payment.is_bank"
                                            ></el-checkbox>
                                            Transferencia / Depositos</label
                                        >
                                        <el-select
                                            :disabled="!form_payment.is_bank"
                                            v-model="form.bank_account_id"
                                            @change="changeBankAccount"
                                        >
                                            <el-option
                                                v-for="bank in bank_accounts"
                                                :key="bank.id"
                                                :label="
                                                    `${bank.description}-${bank.number}`
                                                "
                                                :value="bank.id"
                                            >
                                            </el-option>
                                        </el-select>
                                        <el-input
                                            :disabled="!form_payment.is_bank"
                                            class="mt-1"
                                            placeholder="Nro Operación"
                                            v-model="form.reference_number"
                                        ></el-input
                                    ></template>
                                    <template v-else>
                                        <span class="text-danger"
                                            >No hay cuentas bancarias
                                            registradas</span
                                        >
                                    </template>
                                </div>
                                <div class="col-lg-12">
                                    <div
                                        class="row"
                                        v-if="
                                            methodsValidate.includes(
                                                form.method_pay
                                            )
                                        "
                                    >
                                        <div class="col-md-6 col-lg-6 col-12">
                                            <label
                                                class="control-label text-left  d-flex align-items-start justify-content-start"
                                            >
                                                N° de operación
                                            </label>
                                            <el-input
                                                v-model="operation_number"
                                            >
                                                <template slot="prepend"
                                                    ><i
                                                        class="fa fa-mobile"
                                                    ></i>
                                                </template>
                                            </el-input>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-5 col-xl-6">
                                            <label
                                                class="control-label text-left  d-flex align-items-start justify-content-start"
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
                                            class="radio-tile-group2 col-lg-6 col-xl-6 d "
                                            style="padding-top: 12px;"
                                        >
                                            <div
                                                class="input-container2 border rounded-sm col-lg-3"
                                            >
                                                <input
                                                    id="imprimir"
                                                    v-model="printerOn"
                                                    @change="
                                                        updateConfigutation
                                                    "
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="imprimir"
                                                    value="1"
                                                />
                                                <div class="radio-tile2">
                                                    <div class="icon walk-icon">
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
                                                    @change="
                                                        updateConfigutation
                                                    "
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="noimprimir"
                                                    value="0"
                                                />
                                                <div class="radio-tile2">
                                                    <div class="icon bike-icon">
                                                        <i
                                                            class="fa fa-print"
                                                        ></i>
                                                    </div>
                                                    <label
                                                        for="Tarjeta"
                                                        class="radio-tile-label2"
                                                        >No Imprimir</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-lg-8  d-flex flex-row align-items-end"
                                        ></div>
                                        <div class="d-flex flex-column"></div>
                                    </div>
                                    <div
                                        class="row d-flex justify-content-start"
                                    >
                                        <table
                                            class="table"
                                            v-if="currentPayments.length != 0"
                                        >
                                            <thead>
                                                <tr>
                                                    <th
                                                        colspan="4"
                                                        class="text-left"
                                                    >
                                                        {{
                                                            form.payment_condition_id !==
                                                            "01"
                                                                ? "Cuotas"
                                                                : "Pagos"
                                                        }}
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
                                                    <td
                                                        v-if="
                                                            form.payment_condition_id !==
                                                                '01'
                                                        "
                                                    >
                                                        <el-date-picker
                                                            v-model="
                                                                paymnt.date
                                                            "
                                                        >
                                                        </el-date-picker>
                                                    </td>
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
                            <div class=" card  bg-light ">
                                <div class="row">
                                    <div
                                        class=" col-xl-4"
                                        style="margin-top: 10px;padding-top: 5px;"
                                        :class="{
                                            'has-danger': form.difference < 0
                                        }"
                                    >
                                        <label class="control-label h1"
                                            >Total a cobrar: </label
                                        ><br />
                                        <span
                                            class="control-label font-weight-semibold text-center h3"
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
                                            class="btn-group btn-group-square m-0 flex-wrap justify-content-around"
                                            role="group"
                                            style="padding-top: 12px"
                                        >
                                            <label class="control-label"
                                                >Ingrese monto</label
                                            >
                                            <div
                                                class="d-flex flex-wrap justify-content-around"
                                            >
                                                <div
                                                    class="col-3 col-lg-2 col-md-2  col-xl-2"
                                                >
                                                    <button
                                                        class="btn btn-outline-primary  m-2"
                                                        @click="
                                                            setAmountCash(10)
                                                        "
                                                    >
                                                        10
                                                    </button>
                                                </div>
                                                <div
                                                    class="col-3 col-lg-2 col-md-2  col-xl-2"
                                                >
                                                    <button
                                                        class="btn btn-outline-primary  m-2"
                                                        @click="
                                                            setAmountCash(20)
                                                        "
                                                    >
                                                        20
                                                    </button>
                                                </div>
                                                <div
                                                    class="col-3  col-lg-2 col-md-2  col-xl-2"
                                                >
                                                    <button
                                                        class="btn btn-outline-primary  m-2"
                                                        @click="
                                                            setAmountCash(50)
                                                        "
                                                    >
                                                        50
                                                    </button>
                                                </div>
                                                <div
                                                    class="col-3 col-lg-2 col-md-2  col-xl-2"
                                                >
                                                    <button
                                                        class="btn btn-outline-primary  m-2"
                                                        @click="
                                                            setAmountCash(100)
                                                        "
                                                    >
                                                        100
                                                    </button>
                                                </div>
                                                <div
                                                    class="col-3 col-lg-2 col-md-2  col-xl-2"
                                                >
                                                    <button
                                                        class="btn btn-outline-primary m-2"
                                                        @click="
                                                            setAmountCash(200)
                                                        "
                                                    >
                                                        200
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row col-xl-12 col-12">
                                                <div
                                                    class=" col-xl-6 col-md-3 col-lg-3 col-12"
                                                >
                                                    <el-input
                                                        id="inputTotal"
                                                        ref="enter_amount"
                                                        v-model="
                                                            form.enter_amount
                                                        "
                                                        @blur="diferen()"
                                                        @input="enterAmount()"
                                                    >
                                                        <template
                                                            slot="prepend"
                                                            >{{
                                                                currencyTypeActive.symbol
                                                            }}</template
                                                        >
                                                    </el-input>
                                                </div>
                                                <div
                                                    class="col-xl-2 col-md-2 col-lg-2 col-6"
                                                >
                                                    <el-button
                                                        type="primary"
                                                        @click="addPayment"
                                                        :disabled="
                                                            disabledAddPayment()
                                                        "
                                                    >
                                                        <span
                                                            v-if="
                                                                form.payment_condition_id ==
                                                                    '01'
                                                            "
                                                        >
                                                            Agregar
                                                        </span>
                                                        <span v-else>
                                                            Agregar cuota
                                                        </span>
                                                    </el-button>
                                                </div>
                                                <div
                                                    v-if="
                                                        form.payment_condition_id ==
                                                            '01'
                                                    "
                                                    class="col-xl-3 col-md-3 col-lg-3 col-6 "
                                                >
                                                    <el-button
                                                        type="success"
                                                        @click="
                                                            showSplitPayment = true
                                                        "
                                                        >Dividir pago</el-button
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" row col-xl-4">
                                        <div
                                            class="col-xl-5"
                                            style="margin-bottom: 10px"
                                        ></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl-2"></div>
                                    <div class="col-xl-3">
                                        <el-select
                                            v-if="
                                                form.document_type_id == '01' ||
                                                    form.document_type_id ==
                                                        '03'
                                            "
                                            v-model="form.payment_condition_id"
                                        >
                                            <el-option
                                                value="01"
                                                label="Contado"
                                            >
                                            </el-option>
                                            <el-option
                                                value="02"
                                                label="Crédito"
                                            >
                                            </el-option>
                                            <el-option
                                                value="03"
                                                label="Crédito a cuotas"
                                            ></el-option>
                                        </el-select>
                                        <!-- <el-switch
                                                v-if="
                                                    form.document_type_id ==
                                                        '01' ||
                                                        form.document_type_id ==
                                                            '03'
                                                "
                                                active-text="Crédito"
                                                inactive-text="Contado"
                                                v-model="form.is_credit"
                                            ></el-switch> -->
                                    </div>
                                    <div class="col-xl-4">
                                        <div
                                            class="form-group d-flex flex-row align-items-end"
                                            :class="{
                                                'has-danger':
                                                    form.difference < 0
                                            }"
                                        >
                                            <label
                                                :class="
                                                    `${
                                                        form.difference < 0
                                                            ? 'text-danger'
                                                            : ''
                                                    }`
                                                "
                                                class="control-label fs-4"
                                                v-text="
                                                    form.difference < 0
                                                        ? 'Faltante: '
                                                        : 'Vuelto: '
                                                "
                                            ></label>
                                            <span
                                                :class="
                                                    `${
                                                        form.difference < 0
                                                            ? 'text-danger'
                                                            : ''
                                                    }`
                                                "
                                                class="control-label font-weight-semibold text-center fs-4"
                                            >
                                                {{ currencyTypeActive.symbol
                                                }}{{
                                                    form.difference
                                                        .toFixed(2)
                                                        .replace("-", "")
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div
                                    v-if="hasExceedBank"
                                    class="d-flex justify-content-center"
                                >
                                    <div class="col-12 text-center">
                                        <span class="text-danger">
                                            Recuerde que debido al monto deberá
                                            hacer esta operación mediante
                                            Bancarización, y en el campo <br />
                                            "Observaciones" ingresar el numero
                                            de voucher o numero de operación.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                v-if="splitPayments.length != 0"
                class="row m-1 p-2  bg-light rounded"
            >
                <span style="margin-bottom:5px;">Pagos divididos</span>
                <div class="d-flex flex-wrap ">
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
                class="row m-1 p-2  bg-light rounded"
            >
                <span style="margin-bottom:5px;"
                    >Pagos divididos por producto</span
                >
                <div class="d-flex flex-wrap ">
                    <div
                        v-for="(payment, idx) in splitProducts"
                        :key="idx"
                        class="col-3 m-1"
                    >
                        <table
                            v-if="
                                payment.products && payment.products.length > 0
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
                                class="border rounded-top "
                                v-if="
                                    payment.products &&
                                        payment.products.length > 0
                                "
                            >
                                <tr
                                    v-for="(product, idx) in payment.products"
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
                                    <td style="text-align:right">
                                        <h3 class="text-muted text-small">
                                            {{
                                                product.price * product.quantity
                                            }}
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        colspan="2"
                                        class="text-muted text-small"
                                        style="text-align:right"
                                    >
                                        <b> Total</b>
                                    </td>
                                    <td class="text-muted text-small">
                                        S/.
                                        {{
                                            totalItemSelected(payment.products)
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
                    <template v-if="configuration.affectation_optional">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label>
                                Afectación IGV para el documento
                            </label>
                            <el-select
                                v-model="affectation_optional_id"
                                clearable
                                filterable
                            >
                                <el-option
                                    v-for="option in affectation_igv_types.filter(
                                        affectation => affectation.id == '10'
                                    )"
                                    :key="option.id"
                                    :label="option.description"
                                    :value="option.id"
                                >
                                </el-option>
                            </el-select>
                        </div>
                    </template>
                    <div
                        class="col-lg-4 col-md-4 col-12 d-flex align-items-end justify-content-center"
                    >
                        <div>
                            <button
                                class="btn btn-block btn-primary"
                                @click="sendPayment"
                                :disabled="button_payment"
                            >
                                <i class="fas fa-money-bill-alt"></i>
                                PAGAR
                            </button>
                        </div>
                        <div>
                            <button
                                class="btn btn-block btn-dark"
                                @click="back(false)"
                            >
                                <i class="fa fa-reply"></i> Cerrar
                            </button>
                        </div>
                    </div>
                    <template v-if="form.is_room">
                        <div class="col-lg-3 col-md-3 col-12">
                            <label for="vacate">Desocupar habitación</label>
                            <el-checkbox v-model="form.vacate"></el-checkbox>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <multiple-payment-form
            :showDialog.sync="showDialogMultiplePayment"
            :payments="payments"
            @add="addRow"
        ></multiple-payment-form>

        <!-- <sale-notes-options :showDialog.sync="showDialogSaleNote"
                          :recordId="saleNotesNewId"
                          :showClose="true"></sale-notes-options>  -->

        <card-brands-form
            :showDialog.sync="showDialogNewCardBrand"
            :external="true"
            :recordId="null"
        ></card-brands-form>
        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :input_person="input_person"
            :external="true"
            :user_id.sync="form.user_id"
            :document_type_id="form.document_type_id"
            @add_customer="add_customer"
            :recordId="form.customer_id"
        >
        </person-form>
        <show-split-payment-form
            :orden_items="orden_items"
            @receivePayments="receivePayments"
            @receiveProducts="receiveProducts"
            :total="form.total"
            :showSplitPayment.sync="showSplitPayment"
        >
        </show-split-payment-form>
        <person-college-form
            :showDialog.sync="showCollegePersonDialog"
            :extern="true"
            :fromPerson="true"
            :recordId="collegePersonId"
        >
        </person-college-form>

        <list-items :showDialog.sync="showListItems" :form="form"> </list-items>
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
/* .el-dialog__header {
    padding: 0px;
}
.el-dialog__body {
    padding: 0px !important;
} */
</style>

<script>
// import * as shajs from 'sha.js';
import _ from "lodash";
import printjs from "print-js";
//import CardBrandsForm from "../../../../../../../../resources/js/views/card_brands/form.vue";
// import SaleNotesOptions from '../../sale_notes/partials/options.vue'
//import OptionsForm from './options.vue'
//import MultiplePaymentForm from "./multiple_payment.vue";
//import PersonForm from "../../../../../../../../resources/js/views/persons/form.vue";
//import ShowSplitPaymentForm from "./split_payment.vue";
const ListItems = () => import("./list_items.vue");
const CardBrandsForm = () =>
    import("../../../../../../../../resources/js/views/card_brands/form.vue");
const MultiplePaymentForm = () => import("./multiple_payment.vue");
const PersonForm = () =>
    import("../../../../../../../../resources/js/views/persons/form.vue");
const ShowSplitPaymentForm = () => import("./split_payment.vue");
const PersonCollegeForm = () =>
    import(
        "../../../../../../../College/Resources/assets/js/views/persons/form.vue"
    );
export default {
    components: {
        ListItems,
        PersonCollegeForm,
        CardBrandsForm,
        MultiplePaymentForm,
        PersonForm,
        ShowSplitPaymentForm
    },

    props: [
        "clientSaleNoteNumber",
        "clientSaleNoteDiscount",
        "ordens_all_table",
        "consignment_id",
        "isConsignment",
        "affectation_igv_types",
        "printer",
        "printing",
        "customer_default",
        "customer_variation",
        "variation",
        "establishments",
        "formVariation",
        "documentsType",
        "orden_items",
        "cash_id",
        "form",
        "exchangeRateSale",
        "is_payment",
        "soapCompany",
        "direct_printing",
        "auth_login",
        "payments",
        "configuration",
        "idOrden",
        "company",
        "desarrollador",
        "percentage_igv",
        "all_series",
        "all_customers",
        "personalWhatsapp",
        "sellers"
    ],
    watch: {
        all_customers(newCustomer, _) {
            this.customers = newCustomer.filter(n => n.number != "88888888");
        },
        method_payments(newMethod, _) {
            this.checkTotal(newMethod);
        }
    },
    data() {
        return {
            methodsValidate: [
                "Yape",
                "PLIN",
                "TARJETA: IZYPAY",
                "Culqui",
                "TARJETA: NIUBIZ",
                "TARJETA: OPENPAY"
            ],
            notRegister: false,
            sumCoins: [],
            coins: [
                {
                    id: "0.10",
                    value: 0.1
                },
                {
                    id: "0.20",
                    value: 0.2
                },
                {
                    id: "0.50",
                    value: 0.5
                },
                {
                    id: "1",
                    value: 1
                },
                {
                    id: "2",
                    value: 2
                },
                {
                    id: "5",
                    value: 5
                },
                {
                    id: "10",
                    value: 10
                },
                {
                    id: "20",
                    value: 20
                },
                {
                    id: "50",
                    value: 50
                },
                {
                    id: "100",
                    value: 100
                },
                {
                    id: "200",
                    value: 200
                }
            ],
            loadingText: "Cargando...",
            gotClient: false,
            showListItems: false,
            discountTotal: false,
            paymentCondition: "01",
            payment_condition: [
                {
                    id: "01",
                    description: "Contado"
                },
                {
                    id: "02",
                    description: "Crédito"
                }
            ],
            affectation_optional_id: null,
            hasCreditCardCharge: false,
            chargeCredit: {
                credit_type: "1",
                total_charge: 0,
                amount: 5
            },
            collegePersonId: null,
            conf: {},
            started: true,
            refCustomer: null,
            currentDocumentsType: [],
            time: null,
            splitPayments: [],
            splitProducts: [],
            showCollegePersonDialog: false,
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
                "07": "TARJETA: OPENPAY"
            },
            last_number: {},
            showDialogNewPerson: false,
            loading: false,
            enabled_discount: true,
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
            operation_number: null,
            printerOn: 0,
            button_payment: false,
            input_item: "",
            form_payment: {
                is_bank: false
            },
            series: [],
            cards_brand: [],
            cancel: false,
            form_cash_document: {},
            statusDocument: {},
            payment_method_types: [],
            invoice: true,
            receipt: true,
            sale_note: true,
            last_date: null,
            customers: [],
            datEmision: {
                disabledDate(time) {
                    return time.getTime() > moment();
                }
            },
            activeColo: "black",
            students: [],
            bank: null,
            hasExceedBank: false,
            bank_accounts: []
            // percentage_igv: 18
        };
    },
    computed: {
        formatSumCoins() {
            //regresa un string en formato (cantidad) moneda | (cantidad) moneda
            let sumCoins = this.sumCoins;
            //ordenar por valor de moneda
            sumCoins.sort((a, b) => {
                return a.value - b.value;
            });
            let sum = 0;
            let format = "";
            sumCoins.forEach((coin, index) => {
                sum += coin.value * coin.quantity;
                format += `(${coin.quantity}) ${coin.value.toFixed(2)} | `;
            });
            format += `Total: ${sum.toFixed(2)}`;
            return format;
        }
    },
    async created() {
        this.$eventHub.$on("initInputPerson", () => {
            this.initInputPerson();
        });
        console.log(
            "🚀 ~ file: payment.vue:1645 ~ created ~ this.form.customer_id:",
            this.form.customer_id
        );
        this.conf = this.establishments.conf ?? {};
        this.button_payment = true;
        this.currentDocumentsType = this.documentsType;
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
        if (!this.form.customer_id && !this.form.promotion_sale) {
            this.form.customer_id = this.establishments.customer_id;
            this.value = this.establishments.customer_id;
        } else {
            this.value = this.form.customer_id;
        }

        this.isInterno = this.company.soap_type_id == "03";
        if (!this.conf.pos_quick_sale) {
            await this.getLastNumbersDocument();
        }
        // await this.getTables();
        await this.date_of_issue();

        await this.initFormPayment();
        await this.setInitialAmount();
        this.$eventHub.$on("reloadDataCardBrands", card_brand_id => {
            this.reloadDataCardBrands(card_brand_id);
        });
        await this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });

        await this.getFormPosLocalStorage();

        if (this.conf.pos_quick_sale) {
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
        }

        this.setAmountCash(this.form.total);

        // this.filterSeries();

        this.button_payment = false;
        let { conf } = this.establishments;
        if (
            (conf && conf.pos_quick_sale) ||
            this.ordens_all_table ||
            this.form.promotion_sale
        ) {
            this.sendPayment(null, this.form);
        }
        this.getBankAccounts();

        if (!this.configuration.discount_with_base_variant) {
            this.discountTotal = true;
        }

        if (this.form.is_room) {
            if (this.form.credit_line && this.form.credit_line > 0) {
                this.form.enter_amount = this.form.credit_line;

                this.enterAmount();
            }
        }
    },
    mounted() {},
    methods: {
        initInputPerson() {
            this.input_person = {
                number: null,
                identity_document_type_id: null
            };
        },
        chageRegister() {
            if (this.notRegister) {
                this.bank = "Colocar el nombre del alumno";
            } else {
                this.bank = "";
            }
        },
        clearSumCoins() {
            this.sumCoins = [];
        },
        addCoin(id) {
            let coin = this.coins.find(c => c.id == id);
            //encuentra en sumCoins la moneda si no existe insertala agregando la cantidad, si existe solo sumale la cantidad
            let index = this.sumCoins.findIndex(c => c.id == id);
            if (index == -1) {
                this.sumCoins.push({
                    id: coin.id,
                    value: coin.value,
                    quantity: 1
                });
            } else {
                this.sumCoins[index].quantity++;
            }
        },
        verifyBoxesDuplicate() {
            let boxes = this.form.boxes;
            if (boxes) {
                let { total } = this.form;
                let total_boxes = 0;
                if (boxes.length > 0) {
                    total_boxes = boxes.reduce(
                        (a, b) => a + (parseFloat(b["amount"]) || 0),
                        0
                    );
                    total = parseFloat(total);
                    if (total_boxes > total) {
                        let difference = total_boxes - total;
                        //remove box with difference
                        let index = boxes.findIndex(
                            b => parseFloat(b["amount"]) == difference
                        );
                        if (index >= 0) {
                            boxes.splice(index, 1);
                        }
                    }
                    this.form.boxes = boxes;
                    let new_total = boxes.reduce(
                        (a, b) => a + (parseFloat(b["amount"]) || 0),
                        0
                    );
                    this.form.difference = total - new_total;
                }
            }
        },
        async updateConfigutation() {
            if (!this.configuration.save_pos_printing) return;
            this.configuration.print_in_pos =
                this.printerOn == 1 ? true : false;
            this.$http
                .post(`/configurations`, this.configuration)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    // this.loading_submit = false;
                });
        },
        transferPayment() {
            let { is_bank } = this.form_payment;
            let value = is_bank ? null : "01";
            this.method_payments = value;
        },
        changeBankAccount() {
            if (this.form_payment.is_bank) {
                let bank_account = this.bank_accounts.find(
                    b => b.id == this.form.bank_account_id
                );

                this.form.boxes = [
                    {
                        id: null,
                        bank_account_id: bank_account.id,
                        number_operation: this.form.reference_number,
                        amount: this.form.total,
                        method: `${bank_account.description}-${bank_account.number}`
                    }
                ];
            } else {
                this.form.boxes = [];
            }
        },
        async getBankAccounts() {
            const response = await this.$http.get(`/bank_accounts/records`);
            if (response.status == 200) {
                this.bank_accounts = response.data.data;
                if (this.bank_accounts.length > 0) {
                    this.form.bank_account_id = this.bank_accounts[0].id;
                }
            }
        },
        checkLimitReceipt() {
            let { customer_id, document_type_id, total } = this.form;
            if (total > 699 && document_type_id == "03") {
                let customer = this.customers.find(c => c.id == customer_id);
                if (customer) {
                    if (
                        customer.number == "99999999" ||
                        (customer.identity_document_type_id != "6" &&
                            customer.identity_document_type_id != "1")
                    ) {
                        return true;
                    }
                }
            }
            return false;
        },

        isClientesVarios() {
            let id = this.value;
            if (id != null) {
                let customer = this.customers.find(c => c.id == id);
                if (customer && customer.number == "99999999") {
                    return true;
                }
            }

            return false;
        },
        checkTotal(newMethod) {
            //xd
            if (newMethod == "01") {
                let { total } = this.form;
                if (total > 2000) {
                    this.bank =
                        "Bancarización: Ingresar voucher de pago o nro de operación";
                    this.hasExceedBank = true;
                }
            } else {
                this.bank = null;
                this.hasExceedBank = false;
            }
        },
        formatItems(items = [], affectation = null) {
            items = items.map(i => {
                let affectation_igv_type_id =
                    affectation != null && affectation != undefined
                        ? affectation
                        : i.sale_affectation_igv_type_id;
                return {
                    ...i,
                    warehouse_id: null,
                    item: i,
                    item_id: i.id,
                    unit_value:
                        affectation_igv_type_id == 10
                            ? i.sale_unit_price /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price,
                    quantity: i.quantity,
                    aux_quantity: i.quantity,
                    total_base_igv:
                        affectation_igv_type_id == 10
                            ? (i.sale_unit_price * i.quantity) /
                              (1 + this.percentage_igv / 100)
                            : i.sale_unit_price * i.quantity,
                    percentage_igv: this.percentage_igv,
                    total_igv:
                        affectation_igv_type_id == 10
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
                        affectation_igv_type_id == 10
                            ? ((i.sale_unit_price * i.quantity) /
                                  (1 + this.percentage_igv / 100)) *
                              (this.percentage_igv / 100)
                            : 0,
                    total_value:
                        affectation_igv_type_id == 10
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
                    affectation_igv_type_id: affectation_igv_type_id,
                    unit_price: i.sale_unit_price,
                    presentation: null,
                    charges: [],
                    discounts: [],
                    attributes: [],
                    affectation_igv_type: affectation_igv_type_id
                };
            });
            return items;
        },
        setItemsNewPrice(prices) {
            let copyPrices = [...prices];
            let items = [...this.form.items.map(m => m.item)];
            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                if (item.cOlPrice) {
                    item.sale_unit_price = item.cOlPrice;
                    item.cOlPrice = null;
                    item.cNewPrice = null;
                }
                const quantity = item.quantity;
                let sum = copyPrices.splice(0, 1).reduce((a, b) => a + b, 0);
                let newPrice = sum / quantity;
                item.cOlPrice = item.sale_unit_price;
                item.cNewPrice = newPrice;
                item.sale_unit_price = Number(item.sale_unit_price) + newPrice;
            }
            return items;
        },
        toFixedTwoNumber(number) {
            return Number(number.toFixed(2));
        },
        divideCharge(parts) {
            let { total_charge: amount } = this.chargeCredit;
            let part = amount / parts;
            let decimal = this.toFixedTwoNumber(part);
            let array = Array(parts).fill(decimal);
            let total = decimal * parts;
            let difference = (amount - total).toFixed(2);
            if (difference != 0) {
                array[0] = this.toFixedTwoNumber(array[0] + Number(difference));
            }
            return array;
        },
        calculateCharge() {
            if (this.form.original_total == undefined) {
                this.form.original_total = this.form.total;
            }
            let { amount, credit_type } = this.chargeCredit;
            if (credit_type == "1") {
                this.chargeCredit.total_charge =
                    this.form.original_total * (amount / 100);
            } else {
                this.chargeCredit.total_charge = Number(amount);
            }
            this.chargeCredit.total_charge = Number(
                this.chargeCredit.total_charge.toFixed(1)
            );
            if (this.form.total < this.chargeCredit.total_charge) {
                this.chargeCredit.total_charge = 0;
                this.chargeCredit.amount = 0;
                this.$toast.error(
                    "El monto a adicionar no puede ser mayor al total"
                );
                // this.reCalculateTotal();
                // return;
            }

            let prices = this.divideCharge(this.form.items.length);
            let items = this.setItemsNewPrice(prices);
            items = this.formatItems(items);
            this.form.items = items;
            this.reCalculateTotal();
            this.form.enter_amount = this.form.total;
            this.enterAmount();
        },
        openDialogPerson() {
            if (this.configuration.college) {
                if (
                    this.customer_default &&
                    this.customer_default.id == this.value
                ) {
                    this.showDialogNewPerson = true;
                } else {
                    this.collegePersonId = this.value;
                    this.showCollegePersonDialog = true;
                }
            } else {
                this.showDialogNewPerson = true;
            }
        },
        changeStudent() {
            this.$forceUpdate();
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
        async reloadDataCustomer(customer_id) {
            if (customer_id) {
                const response = await this.$http.get(
                    `/pos/table/customerId/${customer_id}`
                );
                await this.$emit("update:all_customers", response.data);
                this.value = customer_id;
                this.form.customer_id = customer_id;
                this.changeCustomer();
            }
        },
        async reloadDataCustomers(customer_id) {
            const response = await this.$http.get(
                `/pos/table/customers?customer_id=${customer_id || ""}`
            );
            await this.$emit("update:all_customers", response.data);
            this.value = customer_id;
            this.form.customer_id = customer_id;
            this.changeCustomer();
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
        checkPaymentTotal() {
            let total = this.currentPayments.reduce(
                (a, b) => a + Number(b.amount),
                0
            );
            return total != this.form.total
                ? Number(this.form.total) - total
                : 0.0;
        },
        disabledAddPayment() {
            if (this.form.payment_condition_id == "03") {
                return this.checkPaymentTotal() == 0.0;
            }
            if (this.form.payment_condition_id == "02") {
                return this.currentPayments.length > 0;
            }
            return false;
        },
        addPayment() {
            let id = this.currentPayments.length + 1;
            let method = this.paymentsValue[this.method_payments];
            let bank_account_id = null;
            if (method == null && this.form_payment.is_bank) {
                let bank = this.bank_accounts.find(
                    b => b.id == this.form.bank_account_id
                );
                method = `${bank.description}-${bank.number}`;
                bank_account_id = this.form.bank_account_id;
            }
            if (this.form.total + 200 <= this.form.enter_amount) {
                this.$toast.error(
                    "el monto a agregar no puede ser 200 soles mayor al pago total "
                );
                return;
            }
            if (
                this.form.enter_amount != "" &&
                !isNaN(this.form.enter_amount) &&
                this.form.enter_amount != undefined
            ) {
                if (this.form.payment_condition_id != "01") {
                    let total = this.currentPayments.reduce(
                        (a, b) => a + Number(b.amount),
                        0
                    );
                    if (
                        this.form.total <
                        total + Number(this.form.enter_amount)
                    ) {
                        this.$toast.error(
                            "El monto a agregar no puede ser mayor al pago total "
                        );
                        return;
                    }
                }

                let days = this.currentPayments.length + 1;

                let date = moment()
                    .add(5, "hours")
                    .add(days, "days");
                this.currentPayments.push({
                    id,
                    method_payment_id: this.method_payments,
                    method,
                    bank_account_id,
                    date,
                    amount: this.form.enter_amount,
                    operation_number: this.operation_number
                });
                if (this.form.payment_condition_id == "03") {
                    this.form.enter_amount = this.checkPaymentTotal();
                    this.enterAmount();
                } else {
                    this.form.enter_amount = 0.0;
                }
            }
            this.operation_number = null;
            this.form_payment.is_bank = false;
            this.transferPayment();
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
             async searchClientOne(number) {
 let url = `/caja/search_customers?value=${number}`;
                
                const response = await this.$http(url);
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");
                this.updateAllCustomers(this.customers);
             },
        async keyupCustomer(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;
                console.log("🚀 ~ file: payment.vue:2139 ~ this.time=setTimeout ~ this.input_person.number:", this.input_person.number)
                let url = `/caja/search_customers?value=${this.input_person.number}`;
                if (this.configuration.college) {
                    url = `${url}&parents=${this.notRegister ? 0 : 1}`;
                }
                const response = await this.$http(url);
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
            persons = [...persons, ...this.all_customers];
            let newData = [];
            if (this.clientSaleNoteNumber || this.form.hotel_customer_number) {
                newData = personsFromServer;
            } else {
                newData = [...this.all_customers, ...persons];
            }
            newData = newData.filter(
                (thing, index, self) =>
                    index === self.findIndex(t => t.id === thing.id)
            );
            if (persons.length != 0) {
                await this.$emit("update:all_customers", newData);
                if (newData.length == 1) {
                    this.value = newData[0].id;
                    this.form.customer_id = newData[0].id;
                    this.changeCustomer();
                }
            }
        },
        changeCustomer() {
            this.form.student_id = null;
            this.students = [];
            this.form.customer_id = this.value;

            let customer = _.find(this.customers, {
                id: this.form.customer_id
            });

            if (customer != null) {
                this.students = customer.students || [];
                this.customer = customer;
                if (this.form.document_type_id == "01") {
                    if (
                        customer.identity_document_type_id == "1" ||
                        customer.identity_document_type_id == "4" ||
                        customer.identity_document_type_id == "-"
                    ) {
                        this.form.customer_id = null;
                        this.value = null;
                    }
                }

                this.form.customer_telephone = customer.phone;
                this.setLocalStorageIndex("customer", this.customer);
                if (
                    this.clientSaleNoteNumber &&
                    customer.identity_document_type_id !== "6"
                ) {
                    this.form.document_type_id = "03";
                }
            }
            //in this.customers remove duplicate id propertie
            this.customers = this.customers.filter(
                (thing, index, self) =>
                    index === self.findIndex(t => t.id === thing.id)
            );
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
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;

                if (key == "F4") {
                    //Agregar cliente
                    // this.clickPayment();
                }
                if (key == "F6") {
                    //Agregar Producto
                    //this.clickAddItemInvoice()
                    //return false;
                }
                if (key == "F7" && this.form.items.length > 0) {
                    //Guardar
                    // this.submit()
                }
                if (key == "F8") {
                    //Cancelar
                    // this.close()
                }
            };
        },
        checkForCustomer() {
            let { customer_id } = this.form;
            if (customer_id) {
                let customer = this.customers.find(c => c.id == customer_id);
                if (customer == null) {
                    this.reloadDataCustomer(customer_id);
                }
            }
        },
        async date_of_issue() {
            console.log(
                "🚀 ~ file: payment.vue:2329 ~ date_of_issue ~ this.value:",
                this.value
            );
            // this.discount_amount = 0;
            // this.form.customer_id
            // this.form.student_id = null;

            this.sumCoins = [];
            if (!this.form.is_room) {
                this.value = null;
                this.form.customer_id = null;
            }

            if (!this.configuration.restrict_receipt_date) {
                this.form.date_of_issue = moment().format("YYYY-MM-DD");
            }
            let { documents, document_default } = this.establishments;
            if (documents) {
                let { invoice, sale_note, receipt } = documents;
                this.invoice = invoice;
                this.sale_note = sale_note;
                this.receipt = receipt;
            }
            if (document_default) {
                this.form.document_type_id = document_default;
            }
            this.customers = this.all_customers.filter(
                n => n.number != "88888888"
            );
            // this.customers = [
            //     ...this.customers.filter(c => c.id != this.customer_default.id)
            // ];
            // if (this.form.document_type_id != "01") {
            //     this.customers = [...this.customers, this.customer_default];

            // }

            if (this.establishments.customer_id) {
                let isRuc = this.checkCustomerDocument("6");
                if (isRuc && this.form.document_type_id != "01") {
                    // this.value = this.establishments.customer_id;
                    // this.form.customer_id = this.establishments.customer_id;
                }
            }
            this.checkForCustomer();
            let form_efectivo = {
                enter_amount: 0,
                difference: 0
            };
            // const response_efectivo = await this.$http.post(
            //     `/efectivo`,
            //     form_efectivo
            // );
            if (this.clientSaleNoteNumber) {
                if (!this.gotClient) {
                    setTimeout(() => {
                        this.$refs.select_person.$el.getElementsByTagName(
                            "input"
                        )[0].value = this.clientSaleNoteNumber;
                        this.keyupCustomer();
                    }, 800);
                    this.discount_amount = this.clientSaleNoteDiscount;
                    this.inputDiscountAmount();
                    this.discountTotal = true;
                    this.reCalculateTotal();
                    this.gotClient = true;
                }
            }
            this.checkTotal("01");

              
            if (this.configuration.save_pos_printing) {
                this.printerOn = this.configuration.print_in_pos ? 1 : 0;
            }
            this.filterSeries();
        },
        checkCustomerDocument(type) {
            let { customer_id } = this.form;
            let customer = this.customers.find(c => c.id == customer_id);
            if (customer) {
                return customer.identity_document_type_id == type;
            }
            return false;
        },

        async printerDocument(Printer, linkpdf) {
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
            // if (this.printerOn == 1) {
            //     if (multiple_boxes == true) {
            //         if (this.auth_login == auth) {
            //             let config = qz.configs.create(Printer, {
            //                 scaleContent: false
            //             });
            //             if (!qz.websocket.isActive()) {
            //                 await qz.websocket.connect(config);
            //             }
            //             let data = [
            //                 {
            //                     type: "pdf",
            //                     format: "file",
            //                     data: linkpdf
            //                 }
            //             ];
            //             qz.print(config, data).catch(e => {
            //                 this.$toast.error(e.message);
            //             });
            //             for (let index = 0; index < copies; index++) {
            //                 qz.print(config, data).catch(e => {
            //                     this.$toast.error(e.message);
            //                 });
            //             }
            //         }
            //     }
            //     if (multiple_boxes == false) {
            //         let config = qz.configs.create(Printer, {
            //             scaleContent: false
            //         });
            //         if (!qz.websocket.isActive()) {
            //             await qz.websocket.connect(config);
            //         }
            //         let data = [
            //             {
            //                 type: "pdf",
            //                 format: "file",
            //                 data: linkpdf
            //             }
            //         ];

            //         qz.print(config, data).catch(e => {
            //             this.$toast.error(e.message);
            //         });
            //         for (let index = 0; index < copies; index++) {
            //             qz.print(config, data).catch(e => {
            //                 this.$toast.error(e.message);
            //             });
            //         }
            //     }
            // }
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
                        "por S/" +
                        this.form.total +
                        " de *" +
                        this.establishments.description +
                        "*, ha sido generado correctamente a través del facturador electrónico de " +
                        "*" +
                        this.$desarrollador +
                        "*"
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
            let { days_before_emit } = this.configuration;
            //si el document es una factura verificar que la fecha de emision no sea menor a la fecha actual menos days_before_emit sin tomar en cuenta la hora
            if (this.form.document_type_id == "01") {
                let date = moment();
                if (
                    moment(this.form.date_of_issue).isBefore(
                        date
                            .subtract(days_before_emit, "days")
                            .format("YYYY-MM-DD")
                    )
                ) {
                    this.$toast.error(
                        "La fecha de emisión no puede ser menor a " +
                            days_before_emit +
                            " días"
                    );
                    this.form.date_of_issue = moment().format("YYYY-MM-DD");
                }
            }

            //si el documento es una boleta solo permitir emitir si la fecha de emision tiene el mismo mes que la fecha actual
            if (this.form.document_type_id == "03") {
                let date = moment();
                if (moment(this.form.date_of_issue).month() != date.month()) {
                    this.$toast.error(
                        "La fecha de emisión debe ser del mismo mes"
                    );
                    this.form.date_of_issue = moment().format("YYYY-MM-DD");
                }
            }
            // if(this.configuration.restrict_receipt_date){
            //     return;
            // }
            // this.form.date_of_due = this.form.date_of_issue;
            // if (
            //     moment(this.form.date_of_issue) < moment().day(-1) &&
            //     this.configuration.restrict_receipt_date
            // ) {
            //     this.$toast.error(
            //         "No puede seleccionar una fecha menor a 6 días."
            //     );
            //     this.dateValid = false;
            // } else {
            //     this.dateValid = true;
            // }
            // this.form.date_of_due = this.form.date_of_issue;
            // this.searchExchangeRateByDate(this.form.date_of_issue).then(
            //     response => {
            //         this.form.exchange_rate_sale = response;
            //     }
            // );
            this.form.exchange_rate_sale = 1;
        },
        NuevaVenta() {
            this.$parent.nueva_venta();
        },

        async setInitialAmount() {
            this.enter_amount = this.form.total;
            this.form.payments = this.payments;
            //get with screen size
            let width = window.innerWidth;
            if (width > 800) {
                await this.$refs.enter_amount.$el
                    .getElementsByTagName("input")[0]
                    .focus();
                await this.$refs.enter_amount.$el
                    .getElementsByTagName("input")[0]
                    .select();
            } else {
                await this.$refs.observation.$el
                    .getElementsByTagName("textarea")[0]
                    .focus();
            }
        },
        inputDiscountAmount() {
            if (this.enabled_discount) {
                if (
                    this.discount_amount &&
                    !isNaN(this.discount_amount) &&
                    parseFloat(this.discount_amount) > 0
                ) {
                    this.form.total = this.form.total_value;
                    if (this.discount_amount >= this.form.total)
                        return this.$toast.error(
                            "El monto de descuento debe ser menor al total de venta"
                        );

                    this.reCalculateTotal();
                    this.enterAmount();
                } else {
                    this.deleteDiscountGlobal();
                    this.reCalculateTotal();
                    this.enterAmount();
                }
            }
        },
        discountGlobal() {
            // this.form.total = this.form.total_value;
            let global_discount = parseFloat(this.discount_amount);
            let total = parseFloat(this.form.total);
            let base = parseFloat(this.form.total_value);
            if (global_discount > total) {
                this.discount_amount = 0;
                this.$forceUpdate();
                return this.$toast.error(
                    "El descuento no puede ser mayor al total"
                );
            }
            // let total_value = parseFloat(this.form.total_value);
            let new_total = total - global_discount;
            let factor = _.round(global_discount / total, 4);
            this.form.discounts = [
                {
                    discount_type_id: "03",
                    description:
                        "Descuentos globales que no afectan la base imponible del IGV/IVAP",
                    factor,
                    amount: global_discount,
                    base: total
                }
            ];
            this.form.total_discount = global_discount;
            if (this.discountTotal) {
                this.form.total = new_total;
            } else {
                let global_discount_amount = global_discount;
                let global_discount_amount_without_rounding = global_discount;
                let { discount_with_base_variant } = this.configuration;
                if (discount_with_base_variant) {
                    global_discount_amount = Number(
                        (global_discount / 1.18).toFixed(2)
                    );
                    global_discount_amount_without_rounding =
                        global_discount / 1.18;
                }
                let factor = _.round(global_discount_amount / base, 4);
                this.form.discounts = [
                    {
                        discount_type_id: "02",
                        description:
                            "Descuentos globales que afectan la base imponible del IGV/IVAP",
                        factor,
                        amount: global_discount_amount,
                        base
                    }
                ];

                let new_base = this.form.total_value_without_rounding;
                this.form.total_taxed = _.round(
                    new_base - global_discount_amount_without_rounding,
                    2
                );
                this.form.total_value = this.form.total_taxed;
                if (this.configuration.affectation_igv_type_id == "10") {
                    this.form.total_igv = _.round(
                        this.form.total_taxed * (this.percentage_igv / 100),
                        2
                    );
                } else {
                    this.form.total_igv = 0;
                }

                //impuestos (isc + igv + icbper)
                this.form.total_taxes = _.round(
                    this.form.total_igv +
                        this.form.total_isc +
                        this.form.total_plastic_bag_taxes,
                    2
                );
                this.form.total = _.round(
                    this.form.total_taxed + this.form.total_taxes,
                    2
                );
                this.form.subtotal = this.form.total;
            }
        },
        discountGlobal3() {
            let global_discount = parseFloat(this.discount_amount);
            let total = parseFloat(this.form.total);
            if (global_discount > total) {
                this.discount_amount = 0;
                this.$forceUpdate();
                return this.$toast.error(
                    "El descuento no puede ser mayor al total"
                );
            }
            let amount = parseFloat(global_discount);
            let discounts = this.splitDiscount(amount, this.form.items.length);
            this.setDiscountItems(discounts);
        },
        setDiscountItems(discounts) {
            for (let index = 0; index < this.form.items.length; index++) {
                const item = this.form.items[index];
                const discount = discounts[index];
                if (item.originalTotal == undefined) {
                    item.originalTotal = item.total;
                    item.originalTotalValue = item.total_value;
                }
                item.discounts = [
                    {
                        discount_type_id: "01",
                        discount_type: {
                            id: "01",
                            active: 1,
                            base: 0,
                            level: "item",
                            type: "discount",
                            description:
                                "Descuentos que no afectan la base imponible del IGV/IVAP"
                        },
                        is_amount: true,
                        description: "Dscto",
                        factor: _.round(discount / item.originalTotalValue, 4),
                        amount: discount,
                        base: item.originalTotalValue
                    }
                ];

                item.total_discount = discount;
                item.total = item.originalTotal - discount;
                item.total_value = item.originalTotalValue - discount;
            }
        },
        splitDiscount(amount, n) {
            let parts = new Array(n).fill(Math.floor(amount / n));
            for (let i = 0; i < amount % n; i++) {
                parts[i]++;
            }
            return parts;
        },
        discountGlobal2() {
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
                    this.form.total / (1 + this.percentage_igv || 18 / 100),
                    2
                );
                this.form.total_taxed = this.form.total_value;

                this.form.total_igv = _.round(
                    this.form.total_value * (this.percentage_igv || 18 / 100),
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
                        this.form.total / (1 + this.percentage_igv || 18 / 100),
                        2
                    );
                    this.form.total_taxed = this.form.total_value;
                    this.form.total_igv = _.round(
                        this.form.total_value *
                            (this.percentage_igv || 18 / 100),
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
            this.hasCreditCardCharge = false;
            this.form.payment_condition_id = "01";
            this.form.method_pay = method_pay;
            this.form.afectar_caja = true;
            if (this.configuration.credit_mode) {
                if (
                    method_pay == "TARJETA: IZYPAY" ||
                    method_pay == "TARJETA: OPENPAY" ||
                    method_pay == "TARJETA: NIUBIZ" ||
                    method_pay == "Culqui"
                ) {
                    this.hasCreditCardCharge = true;
                } else {
                    this.chargeCredit.amount = 0;
                }

                this.calculateCharge();
            }
            if (method_pay !== "Yape" || method_pay !== "PLIN") {
                this.operation_number = null;
            }
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
            if (
                this.affectation_optional_id != null &&
                this.affectation_optional_id != undefined &&
                this.affectation_optional_id != ""
            ) {
                this.form.items = this.formatItems(
                    this.form.items,
                    this.affectation_optional_id
                );
            }

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
            this.form.total_value_without_rounding = total_value;
            this.form.total_taxes = _.round(total_igv, 2);
            this.form.total_plastic_bag_taxes = _.round(
                total_plastic_bag_taxes,
                2
            );
            // this.form.total = _.round(total, 2)
            this.form.total = _.round(
                total_charge + total + this.form.total_plastic_bag_taxes,
                2
            );

            if (this.discount_amount) {
                this.discountGlobal();
            }

            // this.discountGlobal();
        },
        chargeGlobal() {
            let base = parseFloat(this.form.total);
            let amount = parseFloat(this.chargeCredit.total_charge);
            let factor = _.round(amount / base, 5);
            // console.log(base,factor, amount)
            if (amount > 0) {
                this.form.total_charge = _.round(amount, 2);
                this.form.total = _.round(
                    this.form.total + this.form.total_charge,
                    2
                );
                this.form.charges.push({
                    charge_type_id: "50",
                    description:
                        "Cargos globales que no afectan la base imponible del IGV/IVAP",
                    factor: factor,
                    amount: amount,
                    base: base
                });
            }
        },
        deleteChargeGlobal() {
            this.form.total_charge = 0;
        },
        deleteDiscountGlobal() {
            // console.log("disque borrando");
            // let discount = _.find(this.form.discounts, {
            //     discount_type_id: "03"
            // });
            // let index = this.form.discounts.indexOf(discount);

            // if (index > -1) {
            //     this.form.discounts.splice(index, 1);
            //     this.form.total_discount = 0;
            // }
            for (let index = 0; index < this.form.items.length; index++) {
                const item = this.form.items[index];
                item.discounts = [];

                item.total_discount = 0;
                item.total = item.originalTotal || item.total;
                item.total_value = item.originalTotalValue || item.total_value;
            }
        },
        deleteDiscountGlobal2() {
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

            // console.log(this.form.payments)
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
            if (
                differen < 0 &&
                this.form.payment_condition_id == "01" &&
                !this.configuration.sale_note_credit_cash
            ) {
                this.$toast.error(
                    "El monto de efectivo es menor al total de venta"
                );
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
            this.amount = amount;

            let enter_amount =
                (parseFloat(this.form.enter_amount) || 0) +
                this.totalPayments();

            let differen = enter_amount - parseFloat(this.form.total);

            this.form.difference = parseFloat(differen);

            if (this.form.difference < 0) {
                this.button_payment = true;
                this.form.difference = differen;
            } else if (this.form.difference >= 0) {
                this.button_payment = false;
                parseFloat(this.form.enter_amount) -
                    parseFloat(this.form.total);
            } else {
                this.button_payment = true;
            }
            if (this.configuration.sale_note_credit_cash) {
                this.button_payment = false;
            }
            //this.form.difference = _.round(this.form.difference, 2);

            this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
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
                this.button_payment = true;
                this.form.difference = "-";
            } else if (this.form.difference >= 0) {
                this.button_payment = false;
                this.form.difference = this.amount - this.form.total;
            } else {
                this.button_payment = true;
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
            this.form.difference = this.form.total - this.form.enter_amount;
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
            // if (this.discount_amount) {
            //     let global_discount = parseFloat(this.discount_amount);
            //     let total = parseFloat(this.form.total);

            //     if (global_discount > total) {
            //         return this.$toast.error(
            //             "El descuento no puede ser mayor al total"
            //         );
            //     }
            // }
            //$confirm check if form.observation is null or empty confirmation
            let pass = true;
            if (
                (this.hasExceedBank && this.form.observation == null) ||
                (this.form.observation == "" && this.hasExceedBank)
            ) {
                try {
                    await this.$confirm(
                        "¿Desea continuar sin registrar la bancarización?",
                        "Advertencia",
                        {
                            confirmButtonText: "Sí",
                            cancelButtonText: "No",
                            type: "warning"
                        }
                    );
                } catch (e) {
                    pass = false;
                }
            }
            if (!pass) {
                return;
            }
            if (!form) {
                form = this.form;
            }
            form.printerOn = this.printerOn == 1 ? true : false;
            if (this.conf.pos_quick_sale) {
                form.printerOn = form.printDocument;
            }
            await this.clickPayment(form);

            if (this.formVariation.items.length != 0) {
                let formVariation = this.formVariation;
                formVariation.printerOn = false;
                formVariation.variation_document_id = this.documentNewId;
                formVariation.document_type_id = "80";
                formVariation.customer_telephone = null;
                formVariation.customer_id = this.customer_variation.id;
                this.customers = [
                    ...this.customers.filter(
                        c => c != this.customer_variation.id
                    ),
                    this.customer_variation
                ];
                formVariation.boxes = this.passBoxes(
                    this.formVariation.total,
                    this.form.boxes
                );

                let noteVariation = this.all_series.find(
                    s => s.document_type_id == "80"
                );
                if (noteVariation) {
                    formVariation.series_id = noteVariation.id;
                    await this.clickPayment(formVariation);
                } else {
                    this.$toast.error("Sin serie en nota de venta");
                }
            }
        },
        checkPaymentsIsOk() {
            let total = 0;
            this.currentPayments.forEach(p => {
                total += parseFloat(p.amount);
            });
            return total == this.form.total;
        },
        checkBankAccount() {
            let pass = true;
            let { is_bank } = this.form_payment;
            if (is_bank) {
                if (!this.form.bank_account_id) {
                    this.$toast.error("Debe seleccionar una cuenta bancaria");
                    pass = false;
                }
                if (!this.form.reference_number) {
                    this.$toast.error("Debe ingresar el número de operación");
                    pass = false;
                }
            }

            return pass;
        },
        verifyHasOperationNumber() {
            //itera sobre this.currentPayments si el method es "Yape" o "PLIN" verifica que tengan el operation_number, en caso que no regresa un error
            let pass = true;

            this.currentPayments.forEach(p => {
                console.log(
                    "🚀 ~ file: payment.vue:3298 ~ verifyHasOperationNumber ~ p:",
                    p
                );
                if (this.methodsValidate.includes(p.method)) {
                    console.log(
                        "🚀 ~ file: payment.vue:3301 ~ verifyHasOperationNumber ~ p.operation_number:",
                        p.operation_number
                    );
                    if (!p.operation_number) {
                        console.log(
                            "🚀 ~ file: payment.vue:3302 ~ verifyHasOperationNumber ~ operation_number:",
                            "entr aqui.."
                        );
                        this.$toast.error(
                            "Debe ingresar el número de operación"
                        );
                        pass = false;
                    }
                }
            });
            return pass;
        },
        async validOperationNumber(form) {
            console.log(
                "🚀 ~ file: payment.vue:3310 ~ validOperationNumber ~ form:",
                form
            );
            let { payments } = form;
            for (let i = 0; i < payments.length; i++) {
                let { operation_number } = payments[i];
                if (!operation_number) {
                    this.$toast.error("Debe ingresar el número de operación");
                    return false;
                }
            }

            const response = await this.$http.post(
                "/caja/boxes/validation",
                form
            );
            const { success, message } = response.data;
            if (success) {
                return true;
            } else {
                this.$toast.error(message);
                return false;
            }
        },
        async clickPayment(form) {
            if (
                this.configuration.sale_note_credit_cash &&
                this.enter_amount != this.form.total &&
                this.form.document_type_id == "80"
            ) {
                try {
                    await this.$confirm(
                        "¿Desear realizar la nota de venta al crédito?",
                        "Advertencia",
                        {
                            confirmButtonText: "Sí",
                            cancelButtonText: "No",
                            type: "warning"
                        }
                    );
                } catch (e) {
                    return;
                }
            }

            if (this.configuration.auth_discount && this.discount_amount > 0) {
                this.loading_submit = true;
                //con async y await deten el flujo por 5 segundos
                this.loadingText =
                    "VERIFICANDO AUTORIZACIÓN PARA EL DESCUENTO...";
                await this.sleep(3000);
                this.loadingText = "DESCUENTO AUTORIZADO";
                await this.sleep(2000);
                this.loadingText = "CARGANDO...";
                this.loading_submit = false;
            }
            if (this.form.promotion_sale) {
                this.form.document_type_id = "80";
                this.setSeries();
            }
            if (!this.checkBankAccount()) {
                return;
            }

            let how_is;
            this.reCalculateTotal();
            // return;
            if (
                (!this.form.series_id && this.conf.pos_quick_sale) ||
                this.ordens_all_table
            ) {
                this.setSeries();
            }
            if (
                this.configuration.college &&
                !this.conf.pos_quick_sale &&
                !this.notRegister
            ) {
                if (!this.form.student_id) {
                    this.$toast.error("El alumno es obligatorio");

                    return;
                }
            }
            if (
                (form.document_type_id == "01" ||
                    form.document_type_id == "03") &&
                form.total <= 0
            ) {
                this.$toast.error(
                    "El monto total no puede ser menor o igual a 0"
                );
                return;
            }
            if (form.total + 200 <= form.enter_amount) {
                this.$toast.error(
                    "El monto ingresado no puede ser S/. 200 mayor del Total a cobrar "
                );
                return;
            }

            let customer = this.customers.find(c => c.id == form.customer_id);

            if (customer == undefined) {
                console.log("entrando...");
                await this.reloadDataCustomers(form.customer_id);
                customer = this.customers.find(c => c.id == form.customer_id);
            }

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

            if (form.document_type_id === "80") {
                form.prefix = "NV";
                form.paid = this.form.total == this.form.enter_amount;
                this.resource_documents = "sale-notes";
                this.resource_payments = "sale_note_payments";
                this.resource_options = this.resource_documents;
            } else {
                form.prefix = null;
                this.resource_documents = "documents";
                this.resource_payments = "document_payments";
                this.resource_options = this.resource_documents;
            }
            if (this.orden != null) {
                form.additional_information = `Orden N°${this.orden}`;
            }
            form.advances = 0.0;
            form.total_advances = 0.0;
            form.total_payment = form.total;

            // {
            //     payment_method_type_id: "01",
            //     date_of_payment: form.date_of_issue,
            //     payment: this.form.enter_amount,
            // }

            console.log(
                "🚀 ~ file: payment.vue:3475 ~ clickPayment ~ this.currentPayments:",
                this.currentPayments
            );
            form.cash_id = this.cash_id;
            if (this.form.payment_condition_id == "01") {
                form.boxes = this.currentPayments;

                console.log(
                    "🚀 ~ file: payment.vue:3464 ~ clickPayment ~ form.payments:",
                    JSON.stringify(form.payments)
                );
                if (this.form_payment.is_bank) {
                    this.changeBankAccount();
                }
            } else {
                let isOk = this.checkPaymentsIsOk();
                if (!isOk) {
                    this.$toast.error("Las cuotas no coinciden con el total");
                    return;
                }
            }

            if (this.form.payment_condition_id !== "01") {
                console.log(
                    "🚀 ~ file: payment.vue:3447 ~ clickPayment ~ this.currentPayments:",
                    this.currentPayments
                );
                form.fee = this.currentPayments.map(b => ({
                    id: null,
                    currency_type_id: "PEN",
                    amount: b.amount,
                    date: b.date
                }));
                form.payment_condition_id = "02";
            } else {
                this.addPayment();
                if (this.configuration.require_code) {
                    if (!this.verifyHasOperationNumber()) {
                        this.currentPayments.pop();
                        this.enterAmount();
                        return;
                    } else {
                        if (
                            this.currentPayments
                                .filter(p =>
                                    this.methodsValidate.includes(p.method)
                                )
                                .map(p => ({
                                    method: p.method,
                                    operation_number: p.operation_number
                                })).length > 0
                        ) {
                            if (
                                !(await this.validOperationNumber({
                                    payments: this.currentPayments
                                        .filter(p =>
                                            this.methodsValidate.includes(
                                                p.method
                                            )
                                        )
                                        .map(p => ({
                                            method: p.method,
                                            operation_number: p.operation_number
                                        }))
                                }))
                            ) {
                                this.currentPayments.pop();
                                this.method_payment("Efectivo");
                                if (this.currentPayments.length == 0) {
                                    this.form.enter_amount = this.form.total;
                                }
                                this.enterAmount();
                                return;
                            }
                        }
                    }
                }
            }
            if (this.checkLimitReceipt()) {
                this.$toast.error(
                    "Las boletas mayores a 699 deben tener un dni o ruc válido."
                );
                return;
            }
            this.verifyBoxesDuplicate();
            if (this.form.boxes) {
                form.payments = this.form.boxes.map(p => ({
                    payment_method_type_id: p.method_payment_id,
                    date_of_payment: form.date_of_issue,
                    payment: p.amount
                }));
            }
            this.loading_submit = true;
            this.button_payment = true;

            this.form.items = this.form.items.filter(
                item => Number(item.quantity) > 0
            );
            if (this.isConsignment) {
                this.form.from_consignment = true;
            }

            try {
                let ordenId = this.idOrden;

                let hotels = this.configuration.hotels;
                let printOrdenHotel = true;

                if (hotels) {
                    let resultado =
                        this.form.is_room !== undefined &&
                        this.form.promotion_sale !== undefined
                            ? this.form.is_room && this.form.promotion_sale
                            : false;
                    printOrdenHotel = resultado;
                }

                if (
                    (ordenId == undefined || ordenId == null) &&
                    (form.variation == undefined || form.variation == null) &&
                    !this.conf.pos_quick_sale &&
                    !this.ordens_all_table &&
                    printOrdenHotel
                ) {
                    const responses = await this.$http.post(
                        "/caja/worker/send-orden",
                        this.orden_items
                    );
                    ordenId = responses.data.id;
                    if (responses.status != 200) {
                        return;
                    }
                }
                form.orden_id = ordenId;
                if (this.ordens_all_table) {
                    form.all_ordens = true;
                }
                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);
                if (this.sumCoins.length > 0) {
                    form.sumCoins = this.sumCoins;
                }
                const response = await this.$http.post(
                    `/${this.resource_documents}`,
                    form
                );
                let { data } = response;
                if (response.status == 200 && data.data) {
                    let format = null;
                    let data = response.data.data;
                    switch (data.format_printer) {
                        case 1:
                            format = data.print_a4;
                            break;
                        case 2:
                            format = data.print_a5;
                            break;
                        default:
                            format = data.print_ticket;
                            break;
                    }
                    if (this.printer && format && this.printerOn == 1) {
                        // this.printerDocument(this.printer,format)
                    }
                    this.operation_number = null;
                    if (response.data.success == true) {
                        let document_id = 0;
                        if (form.document_type_id === "80") {
                            this.number = response.data.data.number;
                            document_id = response.data.data.id;
                            this.form_cash_document.sale_note_id =
                                response.data.data.id;
                        } else {
                            document_id = response.data.data.id;
                            this.form_cash_document.document_id =
                                response.data.data.id;
                            this.number = response.data.data.number;
                        }
                        this.documentNewId = response.data.data.id;

                        if (response.data.success == true) {
                            /* let customer = this.all_customers.find(
                                c => c.id == form.customer_id
                            ); */

                            if (ordenId) {
                                if (
                                    this.configuration.college &&
                                    this.form.student_id
                                ) {
                                    const registerCollegeResponse = await this.$http.post(
                                        "/college/registers/sale",
                                        {
                                            is_sale_note:
                                                form.document_type_id == "80",
                                            document_id: this.documentNewId,
                                            detail: {
                                                items: this.form.items.map(
                                                    s => s.item
                                                )
                                            },
                                            student_id: this.form.student_id
                                        }
                                    );
                                }

                                if (
                                    this.configuration.consignment &&
                                    this.consignment_id &&
                                    this.isConsignment
                                ) {
                                    const consigmentLiquidate = await this.$http.post(
                                        `/consignment/liquidated`,
                                        {
                                            id: this.consignment_id,
                                            items: this.form.items.map(i => ({
                                                consignment_item_id:
                                                    i.consignment_item_id,
                                                toWarehouse: i.toWarehouse,
                                                quantity: i.quantity
                                            })),
                                            document_id: this.documentNewId,
                                            document_type_id:
                                                form.document_type_id
                                        }
                                    );
                                    if (consigmentLiquidate.status == 200) {
                                        this.$toast.success(
                                            "Liquidación de consignación realizada."
                                        );
                                    }
                                }
                                const response2 = await this.$http.post(
                                    "pos/orden_payment",
                                    {
                                        id: ordenId,
                                        customer_id: customer.id,
                                        document: {
                                            isNoteSale:
                                                form.document_type_id === "80",
                                            id: this.documentNewId
                                        }
                                    }
                                );

                                if (this.configuration.promotions_sell) {
                                    how_is = this.all_customers.find(
                                        c => c.id == form.customer_id
                                    );
                                    if (!how_is.name.includes("VARIOS")) {
                                        let itemspromo = form.items;

                                        const procesarOferta = await axios.post(
                                            `pos/processPromo`,
                                            { itemspromo, how_is }
                                        );
                                    }
                                }

                                if (response2.data.success == true) {
                                    if (this.form.customer_telephone) {
                                        if (this.personalWhatsapp) {
                                            await this.$emit("getFile", {
                                                total: this.form.total,
                                                documentId: this.documentNewId,
                                                documentTypeId:
                                                    form.document_type_id,
                                                number: this.form
                                                    .customer_telephone,
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
                                        this.$emit("limpiarForm");
                                        this.loading_submit = false;
                                        this.$emit("removeConsignment");

                                        this.back(true);
                                    } else {
                                        this.$emit("limpiarForm");
                                        this.loading_submit = false;
                                        this.$emit("removeConsignment");
                                        this.back(true);
                                    }
                                } else {
                                    console.log(response2);
                                }
                            } else {
                                if (this.conf.pos_quick_sale) {
                                    this.$toast.success("Venta realizada.");
                                }
                                if (this.form.customer_telephone) {
                                    if (this.personalWhatsapp) {
                                        await this.$emit("getFile", {
                                            total: this.form.total,
                                            documentId: this.documentNewId,
                                            documentTypeId:
                                                form.document_type_id,
                                            number: this.form
                                                .customer_telephone,
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
                                }
                                this.$emit("limpiarForm");
                                this.$emit("removeConsignment");
                                this.loading_submit = false;

                                this.back(true);
                            }
                        }
                    }
                } else {
                    this.loading_submit = true;
                    let {
                        data: { message }
                    } = response;
                    this.$toast.error(message || "Ocurrió un error");
                    this.loading_submit = false;
                }
            } catch (error) {
                console.log(error);
                const response = error.response;
                let {
                    data: { message }
                } = response;

                this.$toast.error(message || "Ocurrió un error");
                this.loading_submit = false;
            } finally {
                this.button_payment = false;
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
                        // console.log(response)
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
        getTables() {
            this.filterSeries();
        },

        async clickCancel() {
            this.loading_submit = true;

            this.loading_submit = false;
            this.cleanLocalStoragePayment();
            this.$eventHub.$emit("cancelSale");
        },
        async deleteHotelRentItem(id) {
            const response = await this.$http.delete(
                `/caja/rooms/hotel/rents/${id}`
            );
            console.log(
                "🚀 ~ file: payment.vue:3711 ~ deleteHotelRentItem ~ response:",
                response
            );
        },
        back(val = false) {
          
            let { is_advance, hotel_rent_id } = this.form;
            if (is_advance && hotel_rent_id && !val) {
                this.$emit("limpiarForm");
                this.deleteHotelRentItem(hotel_rent_id);
            }
            this.splitPayments = [];
            this.value = null;

            if (!val) {
                this.$emit("openDrawer");
            }
            this.$emit("update:is_payment", false);
            // this.$emit("limpiarForm");
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
            if (
                this.form.document_type_id == "01" ||
                this.form.document_type_id == "03"
            ) {
                return this.customers.some(
                    c =>
                        c.identity_document_type_id == "6" ||
                        c.identity_document_type_id == "1"
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
            let series = this.series.find(s => s.id == this.form.series_id);
        },
        filterCustomers() {
            let { document_type_id } = this.form;
            let isForRuc = document_type_id == "01";
            if (isForRuc) {
                this.customers = this.all_customers.filter(
                    f => f.identity_document_type_id == "6"
                );
            } else {
                this.customers = this.all_customers;
            }
            //si this.form.customer_id no es nulo y existe en this.customers
            if (
                this.form.customer_id &&
                this.customers.some(c => c.id == this.form.customer_id)
            ) {
                this.value = this.form.customer_id;

                this.form.customer_telephone = this.customers.find(
                    c => c.id == this.form.customer_id
                ).phone;
            } else {
                if (this.customers.length > 0) {
                    let hasCustomerDefault = false;
                    console.log(
                        "🚀 ~ file: payment.vue:3928 ~ filterCustomers ~ this.customer_default:",
                        this.customer_default
                    );
                    console.log(
                        "🚀 ~ file: payment.vue:3933 ~ filterCustomers ~ this.customers:",
                        this.customers
                    );
                    if (this.customer_default) {
                        let { id } = this.customer_default;
                        hasCustomerDefault = this.customers.some(
                            c => c.id == id
                        );
                    }
                    if (hasCustomerDefault) {
                        let { id } = this.customer_default;
                        this.value = id;
                        this.form.customer_id = id;
                    } else if (!hasCustomerDefault && this.customer_default) {
                        this.customers.unshift(this.customer_default);
                        this.value = this.customer_default.id;
                        this.form.customer_id = this.customer_default.id;
                    } else {
                        this.value = this.customers[0].id;
                        this.form.customer_id = this.customers[0].id;
                        console.log(
                            "🚀 ~ file: payment.vue:3939 ~ filterCustomers ~ this.form.customer_id:",
                            this.form.customer_id
                        );
                    }
                    this.changeCustomer();
                } else {
                    this.value = null;
                    this.form.customer_id = null;
                    this.form.customer_telephone = null;
                }
            }
        },

       async filterSeries() {
            this.filterCustomers();
            // let check = this.checkCustomers();
            // if (!check && !this.started) {
            //     let dcto = "DNI";
            //     if (this.form.document_type_id == "01") {
            //         dcto = "RUC";
            //         this.form.document_type_id = "03";
            //     } else {
            //         this.form.document_type_id = "01";
            //     }
            //     this.$toast.warning(`Digite el número de ${dcto}`);

            //     this.setSeries();
            //     return;
            // }
            // this.started = false;

            if (this.form.document_type_id == "01") {
                this.currentDocumentsType = [
                    ...this.documentsType.filter(f => f.description == "RUC")
                ];
                this.form.identity_document_type_id = this.currentDocumentsType[0].id;
            } else {
                this.currentDocumentsType = this.documentsType;
            }

            this.setSeries();
            //aqui
            //factura solo ruc
            //boletas solo dni
            //note de venta todo
            let currentClient = null;
            if (this.value != null) {
                currentClient = this.all_customers.find(
                    c => c.id == this.value
                );

                // if (currentClient.identity_document_type_id == "1") {
                //     this.form.document_type_id = "03";
                // }
            }

            // if (
            //     this.form.document_type_id == "01" &&
            //     currentClient &&
            //     currentClient.identity_document_type_id !== "6"
            // ) {
            //     this.customers = this.all_customers.filter(
            //         f => f.identity_document_type_id == "6"
            //     );
            //     if (this.customers.length == 0) {
            //         this.$toast.warning("Digite el número de RUC");
            //         this.form.document_type_id = "03";

            //         // this.customers = this.all_customers;
            //     } else {
            //         if (
            //             currentClient &&
            //             this.customers.some(c => c.id == currentClient.id)
            //         ) {
            //             this.form.customer_telephone = currentClient.phone;
            //             return;
            //         }

            //         this.value = this.customers[0].id;
            //         this.form.customer_telephone = this.customers[0].phone;
            //     }
            // }
            // else if (
            //     this.form.document_type_id == "03" ||
            //     this.form.document_type_id == "80"
            // ) {
            //     this.customers = this.all_customers.filter(
            //         f => f.identity_document_type_id != "6"
            //     );
            //     if (this.form.total > 300) {
            //         this.customers = this.customers.filter(
            //             c => c.identity_document_type_id == "1"
            //         );
            //     }

            //     if (
            //         currentClient &&
            //         this.customers.some(c => c.id == currentClient.id)
            //     ) {
            //         this.form.customer_telephone = currentClient.phone;
            //         return;
            //     }
            //     let client = this.customers.find(c => {
            //         return c.name.toLowerCase().includes("varios");
            //     });
            //     if (client) {
            //         this.value = client.id;
            //         this.form.customer_telephone = client.phone;
            //     } else {
            //         this.value = this.customers[0].id;
            //         this.form.customer_telephone = this.customers[0].phone;
            //     }
            // }
            // else {
            //     this.customers = this.all_customers;
            // }

            this.customers = this.customers.filter(n => n.number != "88888888");
            this.customers = [
                ...this.customers.filter(n => n.id != this.customer_default.id)
            ];
            if (this.form.document_type_id != "01") {
                this.customers = [...this.customers, this.customer_default];
            }
            console.log(
                "🚀 ~ file: payment.vue:4120 ~ filterSeries ~ this.form:",
                this.form
            );
              if (this.form.hotel_customer_number) {
                  await  this.searchClientOne(this.form.hotel_customer_number);
                    this.changeCustomer();
                } 
            this.changeCustomer();
            if (this.form.document_type_id == "80") {
                this.discount_amount = 0;
                this.inputDiscountAmount();
            }
        }
    }
};
</script>
