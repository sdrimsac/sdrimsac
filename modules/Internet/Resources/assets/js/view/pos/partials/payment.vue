<template>
    <el-dialog
        :visible="is_payment"
        @open="date_of_issue"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :modal-append-to-body="true"
        :show-close="false"
        :append-to-body="true"
        @close="close"
        width="770px"
        top="2vh"
        :title="`MODULO DE COBRO ${variation ? '- Variación' : ''}`"
        class="algunaClase"
    >
        <div v-loading="loading" class=" mb-0">
            <div class="pt-1" v-loading="loading_submit">
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <div class="mb-2">
                            <div class="card bg-light">
                                <div class="row ">
                                    <div class="  col-md-6 col-lg-5 col-sm-6">
                                        <label class="control-label"
                                            >Comprobante de Pago
                                        </label>
                                        <div class="form-group">
                                            <el-radio-group
                                                v-model="form.document_type_id"
                                                size="small"
                                                @change="
                                                    date_of_issue();
                                                    filterSeries();
                                                "
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
                                                        !variation && sale_note
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
                                                readonly
                                                :picker-options="datEmision"
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
                                                        >Seleccion de
                                                        Cliente</label
                                                    >
                                                    <el-button
                                                        :disabled="!value"
                                                        @click="
                                                            openDialogPerson
                                                        "
                                                        >Editar
                                                        cliente</el-button
                                                    >
                                                    <el-button
                                                        v-if="
                                                            !configuration.college
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
                                            @keyup.enter.native="
                                                keyupCustomer()
                                            "
                                        >
                                            <el-option
                                                v-for="option in customers"
                                                :key="option.id"
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
                                <div class="row col-lg-6 col-xl-12">
                                    <div class="form-group">
                                        <label class="control-label"
                                            >Observaciones</label
                                        >
                                        <el-input
                                            type="textarea"
                                            :rows="2"
                                            v-model="form.observation"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class=" mb-2 ">
                            <div
                                class=" text-center text-dark card  bg-light  "
                            >
                                <div class="row">
                                    <div class="  col-lg-12 ">
                                        <div class=" align-items-start ">
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
                                                class="input-container2 border rounded-sm"
                                            >
                                                <input
                                                    id="cash"
                                                    v-model="method_payments"
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="method_payment"
                                                    value="01"
                                                    @change="
                                                        method_payment(
                                                            'Efectivo'
                                                        )
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
                                                    id="yape"
                                                    v-model="method_payments"
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="method_payment"
                                                    value="03"
                                                    @change="
                                                        method_payment('Yape')
                                                    "
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
                                                    id="plin"
                                                    v-model="method_payments"
                                                    class="radio-button2"
                                                    type="radio"
                                                    name="method_payment"
                                                    value="04"
                                                    @change="
                                                        method_payment('PLIN')
                                                    "
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
                                                class="col-lg-8  d-flex flex-row align-items-end"
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

                                    <div
                                        class=" card  bg-light col-lg-12  "
                                    ></div>
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
                                                'has-danger':
                                                    form.difference < 0
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
                                                <div class="row col-12">
                                                    <div
                                                        class="col-2 col-md-2  col-xl-2"
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
                                                        class="col-2 col-md-2  col-xl-2"
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
                                                        class="col-2 col-md-2  col-xl-2"
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
                                                        class="col-2 col-md-2  col-xl-2"
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
                                                        class="col-2 col-md-2  col-xl-2"
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
                                                                }}</template
                                                            >
                                                        </el-input>
                                                    </div>
                                                    <div
                                                        class="m-2 col-xl-2 col-2"
                                                    >
                                                        <el-button
                                                            type="primary"
                                                            @click="addPayment"
                                                            >Agregar</el-button
                                                        >
                                                    </div>
                                                    <div
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
                                        <div class="col-xl-5"></div>
                                        <div class="col-xl-4">
                                            <div
                                                class="form-group d-flex flex-row align-items-end"
                                                :class="{
                                                    'has-danger':
                                                        form.difference < 0
                                                }"
                                            >
                                                <label
                                                    class="control-label display-4"
                                                    v-text="
                                                        form.difference < 0
                                                            ? 'Faltante: '
                                                            : 'Vuelto: '
                                                    "
                                                ></label>
                                                <span
                                                    class="control-label font-weight-semibold text-center display-3 "
                                                >
                                                    {{
                                                        currencyTypeActive.symbol
                                                    }}{{
                                                        form.difference.toFixed(
                                                            2
                                                        )
                                                    }}</span
                                                >
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
                                    class="border rounded-top "
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
                                        <td style="text-align:right">
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
                                            style="text-align:right"
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
                    <div class="row ">
                        <div class="col-lg-4">
                            <div
                                class="btn-group btn-group-square"
                                role="group"
                            >
                                <button
                                    class="btn btn-block btn-primary"
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
        PersonCollegeForm,
        CardBrandsForm,
        MultiplePaymentForm,
        PersonForm,
        ShowSplitPaymentForm
    },

    props: [
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
        "personalWhatsapp"
    ],
    watch: {
        all_customers(newCustomer, _) {
            this.customers = newCustomer.filter(n => n.number != "88888888");
        },
        
    },
    data() {
        return {
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
                "06": "TARJETA: NIUBIZ"
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
        };
    },

    

    async created() {
        this.conf = this.establishments.conf ?? {};
        this.loading = true;
        this.currentDocumentsType = this.documentsType;
        this.form.identity_document_type_id = this.currentDocumentsType[0].id;
        this.form.customer_id = this.establishments.customer_id;
        this.value = this.establishments.customer_id;
        this.isInterno = this.company.soap_type_id == "03";

        // await this.getTables();
        await this.date_of_issue();
        if (!this.conf.direct_sale) {
            await this.getLastNumbersDocument();
        }
        await this.initFormPayment();
        await this.setInitialAmount();
        this.$eventHub.$on("reloadDataCardBrands", card_brand_id => {
            this.reloadDataCardBrands(card_brand_id);
        });
        await this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });

        await this.getFormPosLocalStorage();

        if (this.conf.direct_sale) {
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

        this.filterSeries();

        this.loading = false;
        let { conf } = this.establishments;
        if (conf && conf.direct_sale) {
            this.sendPayment(null, this.form);
        }
    },
    mounted() {},
    methods: {
     
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
                this.form.enter_amount = undefined;
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
                    `/restaurant/search_customers?value=${this.input_person.number}`
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
            this.form.student_id = null;
            this.students = [];
            this.form.customer_id = this.value;
            let customer = _.find(this.customers, {
                id: this.form.customer_id
            });
            if (customer != null) {
                this.students = customer.students || [];
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
        async date_of_issue() {
            // this.form.customer_id
            // this.form.student_id = null;
            let { documents } = this.establishments;
            if (documents) {
                let { invoice, sale_note, receipt } = documents;
                this.invoice = invoice;
                this.sale_note = sale_note;
                this.receipt = receipt;
            }
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
            // const response_efectivo = await this.$http.post(
            //     `/efectivo`,
            //     form_efectivo
            // );
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
                    if (this.auth_login == auth) {
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
                        "*, ha sido generado correctamente a través del facturador electrónico de *Sdrimsac Solutions*"
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
        NuevaVenta() {
            this.$parent.nueva_venta();
        },

        async setInitialAmount() {
            this.enter_amount = this.form.total;
            this.form.payments = this.payments;
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
            // this.form.total = _.round(total, 2)

            this.form.total = _.round(
                total + this.form.total_plastic_bag_taxes,
                2
            );

            this.discountGlobal();
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
            if (differen < 0) {
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
        close(){
            
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
            if (!form) {
                form = this.form;
            }
            form.printerOn = this.printerOn == 1 ? true : false;
            if (this.conf.direct_sale) {
                form.printerOn = form.printDocument;
            }
            await this.clickPayment(form);

            if (this.formVariation.items.length != 0) {
                let formVariation = this.formVariation;
                formVariation.printerOn = false;
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
        async clickPayment(form) {
            if (!this.form.series_id && this.conf.direct_sale) {
                this.setSeries();
            }
            if (this.configuration.college && !this.conf.direct_sale) {
                if (!this.form.student_id) {
                    this.$toast.error("El alumno es obligatorio");

                    return;
                }
            }
            let customer = this.customers.find(c => c.id == form.customer_id);

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
            if (this.orden != null) {
                form.additional_information = `Orden N°${this.orden}`;
            }
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

            form.cash_id = this.cash_id;
            form.boxes = this.currentPayments;
            this.addPayment();

            this.loading_submit = true;

            try {
                let form_efectivo = {
                    enter_amount: form.enter_amount,
                    difference: form.difference
                };
                let ordenId = this.idOrden;
                if (
                    (ordenId == undefined || ordenId == null) &&
                    (form.variation == undefined || form.variation == null) &&
                    !this.conf.direct_sale
                ) {
                    const responses = await this.$http.post(
                        "/restaurant/worker/send-orden",
                        this.orden_items
                    );
                    ordenId = responses.data.id;
                    if (responses.status != 200) {
                        return;
                    }
                }
                form.orden_id = ordenId;
                // const response_efectivo = await this.$http.post(`/efectivo`,form_efectivo);

                const response = await this.$http.post(
                    `/${this.resource_documents}`,
                    form
                );

                if (response.status == 200) {
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
                                if (response2.data.success == true) {
                                    if (this.form.customer_telephone) {
                                        if (this.personalWhatsapp) {
                                            await this.$emit("getFile", {
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
                                        this.back(true);
                                    } else {
                                        this.$emit("limpiarForm");
                                        this.loading_submit = false;
                                        this.back(true);
                                    }
                                }
                            } else {
                                if (this.conf.direct_sale) {
                                    this.$toast.success("Venta realizada.");
                                }
                                this.$emit("limpiarForm");
                                this.loading_submit = false;

                                this.back(true);
                            }
                        }
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
        back(val = false) {
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

            if (this.form.document_type_id == "01") {
                this.customers = this.all_customers.filter(
                    f => f.identity_document_type_id == "6"
                );
                if (this.customers.length == 0) {
                    this.$toast.warning("Digite el número de RUC");
                    this.form.document_type_id == "03";

                    // this.customers = this.all_customers;
                } else {
                    if (
                        currentClient &&
                        this.customers.some(c => c.id == currentClient.id)
                    ) {
                        return;
                    }
                    this.value = this.customers[0].id;
                    this.form.customer_telephone = this.customers[0].phone;
                }
            } else if (
                this.form.document_type_id == "03" ||
                this.form.document_type_id == "80"
            ) {
                this.customers = this.all_customers.filter(
                    f => f.identity_document_type_id != "6"
                );
                if (this.form.total > 300) {
                    this.customers = this.customers.filter(
                        c => c.identity_document_type_id == "1"
                    );
                }

                if (
                    currentClient &&
                    this.customers.some(c => c.id == currentClient.id)
                ) {
                    return;
                }
                let client = this.customers.find(c => {
                    return c.name.toLowerCase().includes("varios");
                });
                if (client) {
                    this.value = client.id;
                    this.form.customer_telephone = client.phone;
                } else {
                    this.value = this.customers[0].id;
                    this.form.customer_telephone = this.customers[0].phone;
                }
            } else {
                this.customers = this.all_customers;
            }
            this.customers = this.customers.filter(n => n.number != "88888888");
            this.customers = [
                ...this.customers.filter(n => n.id != this.customer_default.id),
                this.customer_default
            ];
            this.changeCustomer();
        }
    }
};
</script>
