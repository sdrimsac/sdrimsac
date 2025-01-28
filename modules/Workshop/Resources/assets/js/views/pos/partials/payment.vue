<template>
    <el-dialog
        :visible="is_payment"
        @open="date_of_issue"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :modal-append-to-body="true"
        :show-close="false"
        :append-to-body="true"
        width="60%"
        top="2vh"
        :title="`MODULO DE COBRO ${variation ? '- Variación' : ''}`"
    >
        <div v-loading="loading" class="mb-0">
            <div
                class="pt-1"
                v-loading="loading_submit"
                :element-loading-text="loadingText"
            >
                <!-- Cabecera del  Modal de Cobro                 -->
                <div class="col-lg-12">
                    <div class="mb-1">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row" v-if="configuration.college">
                                    <el-checkbox
                                        @change="chageRegister"
                                        v-model="notRegister"
                                        >No registrado</el-checkbox
                                    >
                                </div>

                                <!-- Comprobante de Pago  -->
                                <div
                                    class="form-row d-flex align-items-center justify-content-between"
                                >
                                    <div
                                        class="form-group col-md-5 d-flex flex-column"
                                    >
                                        <label
                                            class="control-label fw-bold d-flex align-items-center"
                                        >
                                            <i
                                                class="fas fa-file-invoice-dollar me-2"
                                            ></i>
                                            Comprobante de Pago
                                        </label>
                                        <div
                                            class="shadow-box d-flex justify-content-between"
                                        >
                                            <el-button-group
                                                v-model="form.document_type_id"
                                                @change="filterSeries"
                                            >
                                                <!-- Botón Factura -->
                                                <el-button
                                                    v-if="invoice"
                                                    label="01"
                                                    :style="{
                                                        backgroundColor:
                                                            form.document_type_id ===
                                                            '01'
                                                                ? '#4CAF50'
                                                                : '#B0B0B0',
                                                        borderColor:
                                                            form.document_type_id ===
                                                            '01'
                                                                ? '#4CAF50'
                                                                : '#ccc',
                                                        color:
                                                            form.document_type_id ===
                                                            '01'
                                                                ? '#fff'
                                                                : '#000',
                                                        marginRight: '10px',
                                                        fontSize: '16px',
                                                        fontFamily:
                                                            'Arial, sans-serif',
                                                        padding: '8px 20px',
                                                        fontWeight: 'bold',
                                                        width: '130px',
                                                        height: '50px',
                                                        borderRadius: '5px',
                                                        display: 'flex',
                                                        justifyContent:
                                                            'center',
                                                        alignItems: 'center'
                                                    }"
                                                    @click="
                                                        selectDocumentType('01')
                                                    "
                                                    title="FACTURA"
                                                >
                                                    <i
                                                        class="fas fa-file-invoice-dollar fa-lg"
                                                        style="margin-right: 8px;"
                                                    ></i>
                                                    FACTURA
                                                </el-button>
                                                <!-- Botón Boleta -->
                                                <el-button
                                                    v-if="receipt"
                                                    label="03"
                                                    :style="{
                                                        backgroundColor:
                                                            form.document_type_id ===
                                                            '03'
                                                                ? '#FFC107'
                                                                : '#B0B0B0',
                                                        borderColor:
                                                            form.document_type_id ===
                                                            '03'
                                                                ? '#FFC107'
                                                                : '#ccc',
                                                        color:
                                                            form.document_type_id ===
                                                            '03'
                                                                ? '#fff'
                                                                : '#000',
                                                        marginRight: '10px',
                                                        fontSize: '16px',
                                                        fontFamily:
                                                            'Arial, sans-serif',
                                                        padding: '8px 20px',
                                                        fontWeight: 'bold',
                                                        width: '130px',
                                                        height: '50px',
                                                        borderRadius: '5px',
                                                        display: 'flex',
                                                        justifyContent:
                                                            'center',
                                                        alignItems: 'center'
                                                    }"
                                                    @click="
                                                        selectDocumentType('03')
                                                    "
                                                    title="BOLETA"
                                                >
                                                    <i
                                                        class="fas fa-file-alt fa-lg"
                                                        style="margin-right: 8px;"
                                                    ></i>
                                                    BOLETA
                                                </el-button>
                                                <!-- Botón Nota de Venta -->
                                                <el-button
                                                    v-if="sale_note"
                                                    label="80"
                                                    :style="{
                                                        backgroundColor:
                                                            form.document_type_id ===
                                                            '80'
                                                                ? '#1E88E5'
                                                                : '#B0B0B0',
                                                        borderColor:
                                                            form.document_type_id ===
                                                            '80'
                                                                ? '#1E88E5'
                                                                : '#ccc',
                                                        color:
                                                            form.document_type_id ===
                                                            '80'
                                                                ? '#fff'
                                                                : '#000',
                                                        fontSize: '16px',
                                                        fontFamily:
                                                            'Arial, sans-serif',
                                                        padding: '8px 20px',
                                                        fontWeight: 'bold',
                                                        width: '130px',
                                                        height: '50px',
                                                        borderRadius: '5px',
                                                        display: 'flex',
                                                        justifyContent:
                                                            'center',
                                                        alignItems: 'center'
                                                    }"
                                                    @click="
                                                        selectDocumentType('80')
                                                    "
                                                    title="NOTA"
                                                >
                                                    <i
                                                        class="fas fa-file-signature fa-lg"
                                                        style="margin-right: 8px;"
                                                    ></i>
                                                    NOTA
                                                </el-button>
                                            </el-button-group>
                                        </div>
                                    </div>
                                    <!-- Contenedor de Serie, Fecha de Emisión y Botón -->
                                    <div
                                        class="d-flex col-md-7 justify-content-end align-items-center"
                                    >
                                        <!-- Serie -->
                                        <div
                                            class="form-group me-3 series-container"
                                        >
                                            <label
                                                class="control-label fw-bold"
                                            >
                                                <i
                                                    class="fas fa-hashtag me-2"
                                                ></i>
                                                Serie
                                            </label>
                                            <el-select
                                                v-model="form.series_id"
                                                class="w-100"
                                            >
                                                <el-option
                                                    v-for="option in series"
                                                    :key="option.id"
                                                    :label="option.full_number"
                                                    :value="option.id"
                                                ></el-option>
                                            </el-select>
                                        </div>

                                        <!-- Fecha de Emisión -->
                                        <div class="form-group me-3">
                                            <label
                                                class="control-label fw-bold"
                                            >
                                                <i
                                                    class="fas fa-calendar-alt me-2"
                                                ></i>
                                                Fecha de Emisión
                                            </label>
                                            <el-date-picker
                                                v-model="form.date_of_issue"
                                                type="date"
                                                value-format="yyyy-MM-dd"
                                                format="dd-MM-yyyy"
                                                :clearable="false"
                                                style="width: 100%;"
                                                :readonly="
                                                    this.configuration
                                                        .restrict_receipt_date ==
                                                        1
                                                "
                                                @change="changeDateOfIssue"
                                            ></el-date-picker>
                                        </div>

                                        <!-- Botón de Visualización de Lista de venta -->
                                        <div class="form-group">
                                            <el-tooltip
                                                content="Visualiza los productos que se agregaron a la compra"
                                                placement="top"
                                            >
                                                <el-button
                                                    icon="fas fa-eye"
                                                    size="medium"
                                                    type="primary"
                                                    @click="
                                                        showListItems = true
                                                    "
                                                ></el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fila 2 -->
                                <div class="row">
                                    <!-- Clientes -->
                                    <div
                                        class="col-12 client-section border-gray"
                                    >
                                        <div
                                            class="row align-items-center justify-content-between py-2"
                                        >
                                            <!-- Columna 1: Botones -->
                                            <div
                                                class="col-lg-2 d-flex align-items-center justify-content-start"
                                            >
                                                <!-- Botón Nuevo -->
                                                <el-button
                                                    v-if="
                                                        !configuration.college ||
                                                            notRegister
                                                    "
                                                    @click="createClient"
                                                    class="fw-bold button-custom me-2"
                                                    type="primary"
                                                >
                                                    <i
                                                        class="fas fa-user fa-2x"
                                                    ></i>
                                                    Nuevo
                                                </el-button>

                                                <!-- Botón Editar -->
                                                <el-button
                                                    :disabled="
                                                        !value ||
                                                            isClientesVarios()
                                                    "
                                                    @click="openDialogPerson"
                                                    class="fw-bold button-custom"
                                                    type="success"
                                                >
                                                    <i
                                                        class="fas fa-edit fa-2x"
                                                    ></i>
                                                    Editar
                                                </el-button>
                                            </div>

                                            <!-- Columna 2: Buscar Clientes -->
                                            <div
                                                class="col-lg-6 d-flex flex-column"
                                            >
                                                <label>Buscar Clientes</label>
                                                <el-select
                                                    class="client-select w-100"
                                                    ref="select_person"
                                                    v-model="value"
                                                    filterable
                                                    clearable
                                                    size="large"
                                                    placeholder="Cliente"
                                                    :disabled="loading"
                                                    @change="changeCustomer"
                                                    @keyup.native="
                                                        keyupCustomer
                                                    "
                                                >
                                                    <el-option
                                                        v-for="(option,
                                                        idx) in customers"
                                                        :key="idx"
                                                        :label="
                                                            option.description
                                                        "
                                                        :value="option.id"
                                                    ></el-option>
                                                </el-select>
                                            </div>

                                            <!-- Columna 3: WhatsApp -->
                                            <div
                                                class="col-lg-3 d-flex flex-column"
                                            >
                                                <label>WhatsApp</label>
                                                <el-input
                                                    v-model="
                                                        form.customer_telephone
                                                    "
                                                    class="w-100"
                                                >
                                                    <template slot="prepend">
                                                        <i
                                                            class="fab fa-whatsapp fa-2x bg-success"
                                                        ></i>
                                                    </template>
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Observaciones y Vendedor -->
                                    <div class="row">
                                        <!-- Observaciones -->
                                        <div class="col-lg-8 col-xl-8">
                                            <div class="form-group">
                                                <label
                                                    class="control-label fw-bold"
                                                    >Observaciones</label
                                                >
                                                <el-input
                                                    ref="observation"
                                                    type="textarea"
                                                    :rows="2"
                                                    :placeholder="bank"
                                                    v-model="form.observation"
                                                    class="observation-textarea"
                                                ></el-input>
                                            </div>
                                        </div>

                                        <!-- Vendedor -->
                                        <div
                                            class="col-lg-4 col-xl-4"
                                            v-if="configuration.seller_caja"
                                        >
                                            <label for="seller">Vendedor</label>
                                            <el-select
                                                v-model="form.seller_id"
                                                clearable
                                            >
                                                <el-option
                                                    v-for="(option,
                                                    idx) in sellers"
                                                    :key="idx"
                                                    :label="option.name"
                                                    :value="option.id"
                                                ></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estudieante -->
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
                                            ></el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Operaciones de Pago -->
                <div class="row">
                    <!-- Column 1: Total Venta -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <div
                            class="radio-tile-group2 d-flex justify-content-between align-items-center p-3"
                            style="background-color: #f8f9fa; border-radius: 5px;"
                        >
                            <label
                                class="control-label text-primary fs-4 fw-bold mb-0"
                                >Total Venta</label
                            >
                            <span
                                class="control-label text-primary fs-4 fw-bold mb-0 text-right"
                                >S/ {{ " " + form.total }}</span
                            >
                        </div>
                    </div>

                    <!-- Column 2: Descuento -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <div
                            class="radio-tile-group2 d-flex justify-content-between align-items-center p-3"
                            style="background-color: #e9ecef; border-radius: 5px;"
                        >
                            <label
                                class="control-label fs-4 fw-bold text-success mb-0"
                                >Descuento S/</label
                            >
                            <!-- <input
                                type="number"
                                class="form-control w-25 text-right ml-2"
                                v-model="discount_amount"
                                @change="inputDiscountAmount"
                                style="appearance: none; -moz-appearance: textfield; -webkit-appearance: none;"
              />-->
                            <input
                                type="number"
                                class="form-control w-25 text-right ml-2"
                                v-model="discount_amount"
                                @input="inputDiscountAmount"
                                style="appearance: none; -moz-appearance: textfield; -webkit-appearance: none;"
                            />

                            <el-checkbox
                                v-model="discountTotal"
                                @change="reCalculateTotal"
                                class="ml-3 is-success text-success"
                                >{{
                                    discountTotal ? "del total" : "a la base"
                                }}</el-checkbox
                            >
                        </div>
                    </div>

                    <!-- Column 3: Faltante/Vuelto -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <div
                            class="radio-tile-group2 d-flex align-items-center justify-content-between w-100 p-3"
                            style="border-radius: 5px;"
                            :class="{
                                'bg-danger text-white': form.difference < 0,
                                'bg-primary text-white': form.difference >= 0
                            }"
                        >
                            <label
                                class="control-label fs-4 fw-bold text-white"
                                v-text="
                                    form.difference < 0
                                        ? 'Faltante: '
                                        : 'Vuelto: '
                                "
                            ></label>
                            <span class="control-label fs-4 fw-bold text-white">
                                {{ currencyTypeActive.symbol
                                }}{{
                                    form.difference.toFixed(2).replace("-", "")
                                }}
                            </span>
                        </div>
                        <div class="row" v-if="hasPromotionText">
                            <div
                                class="alert alert-success col-lg-6 col-md-6 col-sm-12"
                            >
                                {{ hasPromotionText }}
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <el-checkbox v-model="form.receive_promotion"
                                    >Aplicar promoción</el-checkbox
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Medios de Pago / Operaciones y Cargos por tarjeta Transferencias -->
                <div class="row">
                    <!-- Column 1: Medios de Pago -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <div
                            class="text-center text-dark card bg-light"
                            v-if="conf.show_payment_method"
                        >
                            <div class="align-items-start">
                                <label class="control-label"
                                    >Medios de Pago</label
                                >
                                <label
                                    role="button"
                                    class="text-primary control-label"
                                ></label>
                            </div>
                            <div class="radio-tile-group2 d-flex flex-wrap">
                                <!-- Botón Efectivo -->
                                <div class="input-container2 border rounded-sm">
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="cash"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="01"
                                        @change="method_payment('Efectivo')"
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonEfectivo.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="cash"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Culqui -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.culqi"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="culqui"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="02"
                                        @change="method_payment('Culqui')"
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/CulquiIcon.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="culqui"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Izipay -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.izipay"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="izipay"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="05"
                                        @change="
                                            method_payment('TARJETA: IZYPAY')
                                        "
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonIzipay.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="izipay"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Openpay -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.openpay"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="openpay"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="07"
                                        @change="
                                            method_payment('TARJETA: OPENPAY')
                                        "
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonOpenpay.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="openpay"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Niubiz -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.nubiz"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="nubiz"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="06"
                                        @change="
                                            method_payment('TARJETA: NIUBIZ')
                                        "
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonNiubiz.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="nubiz"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Yape -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.yape"
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
                                        style="background-image: url('../../images/yape-logo-3E473EE7E5-seeklogo.com.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="yape"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Plin -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.plin"
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
                                        style="background-image: url('../../images/plin-logo-0C4106153C-seeklogo.com.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="plin"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Didi Food -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.didi"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="didi"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="08"
                                        @change="method_payment('DIDI FOOD')"
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonDidi.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="didi"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Pedidos Ya -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.pedidosya"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="pedidosya"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="09"
                                        @change="method_payment('PEDIDOS YA')"
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonPedidosYa.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="pedidosya"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>

                                <!-- Rappi -->
                                <div
                                    class="input-container2 border rounded-sm"
                                    v-if="configuration.rappi"
                                >
                                    <input
                                        :disabled="form_payment.is_bank"
                                        id="rappi"
                                        v-model="method_payments"
                                        class="radio-button2"
                                        type="radio"
                                        name="method_payment"
                                        value="10"
                                        @change="method_payment('RAPPI')"
                                    />
                                    <div
                                        class="radio-tile2"
                                        style="background-image: url('../../images/botonRappi.png'); background-size: contain; background-repeat: no-repeat"
                                    >
                                        <label
                                            for="rappi"
                                            class="radio-tile-label2"
                                        ></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: N° de Operación y Cargos de Tarjeta -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <div class="row">
                            <!-- N° de Operación -->
                            <div
                                class="col-12 d-flex align-items-center"
                                v-if="methodsValidate.includes(form.method_pay)"
                            >
                                <label
                                    class="control-label font-weight-bold text-muted mr-2"
                                    style="font-size: 0.9em; white-space: nowrap;"
                                    >Nº Op. :</label
                                >
                                <el-input
                                    v-model="operation_number"
                                    size="mini"
                                    class="d-inline-flex"
                                ></el-input>
                            </div>

                            <!-- Cargos de Tarjeta -->
                            <div
                                class="col-12 mt-3"
                                v-if="
                                    hasCreditCardCharge &&
                                        configuration.credit_mode
                                "
                            >
                                <!-- Label "Porcentaje" o "Monto" alineado a la izquierda -->
                                <label
                                    class="font-weight-bold mb-1"
                                    style="text-align: left;"
                                    >{{
                                        chargeCredit.credit_type == "1"
                                            ? "Porcentaje"
                                            : "Monto"
                                    }}</label
                                >

                                <!-- Fila para el Input, Radio Group y Total Calculado -->
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                >
                                    <!-- Input de Monto/Porcentaje alineado a la izquierda, más grande y en negrita -->
                                    <el-input
                                        type="number"
                                        @input="calculateCharge"
                                        style="max-width: 100px; font-weight: bold;"
                                        v-model="chargeCredit.amount"
                                        size="mini"
                                    ></el-input>

                                    <!-- Radio Group centrado en la fila, en azul oscuro -->
                                    <div
                                        class="d-flex justify-content-center mx-3"
                                    >
                                        <el-radio-group
                                            @change="calculateCharge"
                                            v-model="chargeCredit.credit_type"
                                            size="mini"
                                            style="color: #004085;"
                                        >
                                            <el-radio-button
                                                label="1"
                                                style="background-color: #004085; color: white;"
                                                >%</el-radio-button
                                            >
                                            <el-radio-button
                                                label="2"
                                                style="background-color: #004085; color: white;"
                                                >S/</el-radio-button
                                            >
                                        </el-radio-group>
                                    </div>

                                    <!-- Total Calculado alineado a la derecha -->
                                    <span
                                        class="h6 font-weight-bold"
                                        style="margin-left: auto;"
                                        v-if="
                                            chargeCredit.total_charge !== 0 &&
                                                chargeCredit.amount
                                        "
                                        >S/
                                        {{
                                            chargeCredit.total_charge.toFixed(2)
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Transferencia / Depósitos -->
                    <div class="col-lg-4 col-md-12 mb-2">
                        <template v-if="bank_accounts.length != 0">
                            <label for="banks">
                                <el-checkbox
                                    @change="transferPayment"
                                    v-model="form_payment.is_bank"
                                ></el-checkbox
                                >Transferencia / Depositos
                            </label>
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
                                ></el-option>
                            </el-select>
                            <el-input
                                :disabled="!form_payment.is_bank"
                                class="mt-1"
                                placeholder="Nro Operación"
                                v-model="form.reference_number"
                            ></el-input>
                        </template>
                        <template v-else>
                            <span class="text-danger">
                                No hay cuentas bancarias registradas
                            </span>
                        </template>
                    </div>
                </div>
                <!-- Ingreso de pagos/dividir pagos / pagos con metodo de pago/promocion -->
                <div class="row">
                    <!-- Columna 1: Ingreso de Montos -->
                    <div
                        class="col-xl-4"
                        v-if="form_payment.payment_method_type_id == '01'"
                    >
                        <!-- Título -->
                        <div class="mb-3">
                            <label class="control-label fw-bold"
                                >Ingrese Monto</label
                            >
                        </div>

                        <!-- Campo de entrada y botón "Agregar" -->
                        <div class="mb-3 d-flex align-items-center">
                            <el-input
                                id="inputTotal"
                                ref="enter_amount"
                                v-model="form.enter_amount"
                                @blur="diferen()"
                                @input="enterAmount()"
                                class="me-3"
                            >
                                <template slot="prepend">{{
                                    currencyTypeActive.symbol
                                }}</template>
                            </el-input>
                            <el-button
                                type="primary"
                                @click="addPayment"
                                :disabled="disabledAddPayment()"
                            >
                                <span v-if="form.payment_condition_id == '01'"
                                    >Agregar</span
                                >
                                <span v-else>Agregar cuota</span>
                            </el-button>
                        </div>

                        <!-- Botones de montos (10, 20, 50, 100, 200) en una fila -->
                        <div class="mb-3 d-flex justify-content-between">
                            <button
                                class="btn btn-outline-primary fw-bold"
                                @click="setAmountCash(10)"
                            >
                                10
                            </button>
                            <button
                                class="btn btn-outline-primary fw-bold"
                                @click="setAmountCash(20)"
                            >
                                20
                            </button>
                            <button
                                class="btn btn-outline-primary fw-bold"
                                @click="setAmountCash(50)"
                            >
                                50
                            </button>
                            <button
                                class="btn btn-outline-primary fw-bold"
                                @click="setAmountCash(100)"
                            >
                                100
                            </button>
                            <button
                                class="btn btn-outline-primary fw-bold"
                                @click="setAmountCash(200)"
                            >
                                200
                            </button>
                        </div>
                    </div>

                    <div class="col-xl-4"></div>

                    <!-- Columna 3: Promoción / Imprimir No imprimir -->
                    <div class="col-xl-4">
                        <!-- Sección Promoción -->
                        <div
                            class="form-group mb-3"
                            v-if="configuration.is_promotion_document"
                        >
                            <label for="promotion" class="fw-bold"
                                >Promoción</label
                            >
                            <el-select
                                v-model="form.promotion_id"
                                filterable
                                clearable
                                placeholder="Seleccione una promoción"
                                class="w-100"
                            >
                                <el-option
                                    v-for="(option, idx) in promotions_document"
                                    :key="idx"
                                    :label="option.description"
                                    :value="option.id"
                                ></el-option>
                            </el-select>
                        </div>
                        <div class="radio-tile-group2 d-flex mb-3">
                            <div
                                class="input-container2 border rounded-sm me-2"
                                :class="{ selected: printerOn === '1' }"
                            >
                                <input
                                    id="imprimir"
                                    v-model="printerOn"
                                    @change="updateConfigutation"
                                    class="radio-button2"
                                    type="radio"
                                    name="imprimir"
                                    value="1"
                                />
                                <div class="radio-tile2">
                                    <div class="icon">
                                        <i class="fa fa-print"></i>
                                    </div>
                                    <label
                                        for="imprimir"
                                        class="radio-tile-label2"
                                        >Imprimir</label
                                    >
                                </div>
                            </div>
                            <div
                                class="input-container2 border rounded-sm"
                                :class="{ selected: printerOn === '0' }"
                            >
                                <input
                                    id="noimprimir"
                                    v-model="printerOn"
                                    @change="updateConfigutation"
                                    class="radio-button2"
                                    type="radio"
                                    name="imprimir"
                                    value="0"
                                />
                                <div class="radio-tile2">
                                    <div class="icon">
                                        <i class="fa fa-ban"></i>
                                    </div>
                                    <label
                                        for="noimprimir"
                                        class="radio-tile-label2"
                                        >No Imprimir</label
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Desocupar habitación -->
                        <template>
                            <div class="mb-3" v-if="form.is_room">
                                <label for="vacate">Desocupar habitación</label>
                                <el-checkbox
                                    v-model="form.vacate"
                                ></el-checkbox>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!-- Pagos con método de pago (Tabla) -->
            <div class="mb-3 d-flex align-items-center">
                <table
                    class="table"
                    v-if="currentPayments.length != 0"
                    :disabled="button_payment"
                >
                    <thead>
                        <tr>
                            <th colspan="5" class="text-left">
                                {{
                                    form.payment_condition_id !== "01"
                                        ? "Cuotas"
                                        : "Pagos"
                                }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(paymnt, idx) in currentPayments"
                            :key="idx"
                            :class="{ 'table-secondary': idx % 2 === 0 }"
                        >
                            <td>{{ idx + 1 }}</td>
                            <td v-if="form.payment_condition_id !== '01'">
                                <el-date-picker
                                    v-model="paymnt.date"
                                ></el-date-picker>
                            </td>
                            <td>{{ paymnt.method }}</td>
                            <td>
                                <strong>{{
                                    Number(paymnt.amount).toFixed(2)
                                }}</strong>
                            </td>
                            <td>
                                <el-tooltip
                                    content="Eliminar pago"
                                    placement="top"
                                >
                                    <el-button
                                        type="danger"
                                        icon="el-icon-delete"
                                        circle
                                        @click="removePayment(paymnt.id)"
                                    ></el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--Billetes y Monedas a recibir por delivery -->
            <template v-if="configuration.show_coins_to_receive">
                <div
                    class="m-2 p-3"
                    style="background-color: #f5f7fa; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"
                >
                    <!-- Leyenda o Suma de Monedas -->
                    <div
                        class="text-center mb-2"
                        style="font-size: 1rem; font-weight: bold; color: #004085;"
                    >
                        <template v-if="sumCoins.length == 0"
                            >Billetes/Monedas a Recibir</template
                        >
                        <template v-else>{{ formatSumCoins }}</template>
                    </div>

                    <!-- Grupo de Botones de Monedas/Billetes -->
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
                                style="background-color: #007bff; border-color: #007bff; color: white; margin: 0 5px 5px 0;"
                                round
                                >{{ coin.id }}</el-button
                            >

                            <!-- Botón de Limpiar -->
                            <el-button
                                type="danger"
                                @click="clearSumCoins"
                                size="small"
                                style="background-color: #dc3545; border-color: #dc3545; color: white; margin: 0 0 5px 5px;"
                                round
                            >
                                <i class="fas fa-trash"></i>
                            </el-button>
                        </el-button-group>
                    </div>
                </div>
            </template>

            <div class="col-lg-12">
                <!-- condicon no debe estar ahi -->
                <div class="card bg-light text-dark p-3">
                    <div class="row">
                        <!-- Columna 1 -->
                        <div class="col-lg-4">
                            <!-- Modo de Pago Contado/Crédito/Crédito a Cuotas -->
                            <div
                                class="mb-3 w-100"
                                v-if="
                                    form.document_type_id == '01' ||
                                        form.document_type_id == '03'
                                "
                            >
                                <label class="fw-bold">Modo de Pago</label>
                                <el-select v-model="form.payment_condition_id">
                                    <el-option
                                        value="01"
                                        label="Contado"
                                    ></el-option>
                                    <el-option
                                        value="02"
                                        label="Crédito"
                                    ></el-option>
                                    <el-option
                                        value="03"
                                        label="Crédito a cuotas"
                                    ></el-option>
                                </el-select>
                            </div>

                            <!-- Afectación IGV -->
                            <template v-if="configuration.affectation_optional">
                                <div class="mb-3">
                                    <label
                                        >Afectación IGV para el documento</label
                                    >
                                    <el-select
                                        v-model="affectation_optional_id"
                                        clearable
                                        filterable
                                        class="w-100"
                                    >
                                        <el-option
                                            v-for="option in affectation_igv_types.filter(
                                                affectation =>
                                                    affectation.id == '10'
                                            )"
                                            :key="option.id"
                                            :label="option.description"
                                            :value="option.id"
                                        ></el-option>
                                    </el-select>
                                </div>
                            </template>
                        </div>

                        <!-- Columna 2 -->
                        <div class="col-lg-4">
                            <!-- Detracción -->
                            <div
                                v-if="hasDetraction"
                                class="p-3 border rounded bg-light mb-3"
                            >
                                <h6 class="fw-bold mb-2">Detracción</h6>

                                <!-- Cta Bancaria y botón "Más..." -->
                                <div class="mb-2 d-flex align-items-center">
                                    <label for="account" class="fw-bold me-2"
                                        >Cta Bancaria</label
                                    >
                                    <el-input
                                        class="flex-grow-1 me-2"
                                        v-model="company.detraction_account"
                                        readonly
                                    ></el-input>
                                    <button
                                        @click="
                                            showDialogDocumentDetraction = true
                                        "
                                        class="btn btn-outline-primary"
                                    >
                                        Más...
                                    </button>
                                </div>

                                <!-- Monto en la misma fila -->
                                <div class="d-flex align-items-center">
                                    <label for="amount" class="fw-bold me-2"
                                        >Monto</label
                                    >
                                    <el-input
                                        v-model="form.detraction.amount"
                                        readonly
                                        class="flex-shrink-1"
                                        style="width: 70px;"
                                    ></el-input>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 3 -->
                        <div class="col-lg-4">
                            <!-- Botón Dividir Pago -->
                            <div
                                class="mb-3"
                                v-if="
                                    form.payment_condition_id == '01' &&
                                        configuration.split_payments_pos
                                "
                            >
                                <el-button
                                    type="success"
                                    icon="el-icon-scissors"
                                    size="large"
                                    @click="showSplitPayment = true"
                                    class="w-100"
                                    >Dividir pago</el-button
                                >
                            </div>
                            <br />
                            <!-- Pagar y Cerrar -->
                            <div class="d-flex justify-content-between mb-3">
                                <button
                                    class="btn btn-primary w-100 me-2"
                                    @click="sendPayment"
                                    :disabled="button_payment"
                                >
                                    <i class="fas fa-money-bill-alt"></i> PAGAR
                                </button>
                                <button
                                    class="btn btn-dark w-100"
                                    @click="back(false)"
                                >
                                    <i class="fa fa-reply"></i> Cerrar
                                </button>
                            </div>

                            <!-- Mensaje de Exceso de Monto (Bancarización) -->
                            <div
                                v-if="hasExceedBank"
                                class="text-center text-danger"
                            >
                                <span
                                    >Recuerde que debido al monto deberá hacer
                                    esta operación mediante Bancarización.
                                    Ingrese en el campo "Observaciones" el
                                    número de voucher o número de
                                    operación.</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-if="splitPayments.length != 0"
                class="row m-1 p-2 bg-light rounded"
            >
                <span style="margin-bottom:5px;">Pagos divididos</span>
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
                <span style="margin-bottom:5px;"
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
                                        <b>CUENTA {{ idx + 1 }}</b>
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
                                        <b>Total</b>
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
            <div class="p-3"></div>
        </div>

        <multiple-payment-form
            :showDialog.sync="showDialogMultiplePayment"
            :payments="payments"
            @add="addRow"
        ></multiple-payment-form>

        <!-- <sale-notes-options :showDialog.sync="showDialogSaleNote"
                          :recordId="saleNotesNewId"
    :showClose="true"></sale-notes-options>-->

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
            :document_type_id.sync="form.document_type_id"
            @add_customer="add_customer"
            :recordId="form.customer_id"
        ></person-form>
        <show-split-payment-form
            :orden_items="orden_items"
            @receivePayments="receivePayments"
            @receiveProducts="receiveProducts"
            :total="form.total"
            :showSplitPayment.sync="showSplitPayment"
        ></show-split-payment-form>
        <person-college-form
            :showDialog.sync="showCollegePersonDialog"
            :extern="true"
            :fromPerson="true"
            :recordId="collegePersonId"
        ></person-college-form>
        <document-detraction
            v-if="form && form.total > 0 && form.detraction"
            :currency-type-id-active="form.currency_type_id"
            :detraction="form.detraction"
            :exchange-rate-sale="form.exchange_rate_sale"
            :operation-type-id="form.operation_type_id"
            :showDialog.sync="showDialogDocumentDetraction"
            :total="form.total"
            @addDocumentDetraction="addDocumentDetraction"
        ></document-detraction>
        <list-items :showDialog.sync="showListItems" :form="form"></list-items>
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
const DocumentDetraction = () =>
    import(
        "../../../../../../../../resources/js/views/documents/partials/detraction.vue"
    );
export default {
    components: {
        ListItems,
        PersonCollegeForm,
        CardBrandsForm,
        MultiplePaymentForm,
        PersonForm,
        ShowSplitPaymentForm,
        DocumentDetraction
    },

    props: [
        "promotions_document",
        "itemDefault",
        "company",
        "quotationId",
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
        "sellers",
        "vehiculo_id"
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
            hasPromotionText: null,
            paymentVariation: {
                description: "Consumo",
                price: 0
            },
            isRestaurantWarehouse: false,
            showDialogDocumentDetraction: false,
            hasDetraction: false,
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
                "07": "TARJETA: OPENPAY",
                "08": "DIDI FOOD",
                "09": "PEDIDOS YA",
                "10": "RAPPI"
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
            detraction_types: [],
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
            cat_payment_method_types: [],
            datEmision: {
                disabledDate(time) {
                    return time.getTime() > moment();
                }
            },
            activeColo: "black",
            students: [],
            bank: null,
            hasExceedBank: false,
            bank_accounts: [],
            vehicle: null
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
        await this.$http.get(`/documents/detraction/tables`).then(response => {
            this.detraction_types = response.data.detraction_types;
            this.cat_payment_method_types =
                response.data.cat_payment_method_types;
        });
        this.$eventHub.$on("initInputPerson", () => {
            this.initInputPerson();
        });
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
    },
    mounted() {},
    methods: {
        verifyPromotionCustomer() {
            this.hasPromotionText = null;
            this.$http
                .get(
                    `/promotions-document/records-customers/${this.form.customer_id}`
                )
                .then(response => {
                    if (response.status == 200) {
                        let { data } = response;
                        this.hasPromotionText = data
                            .map(p => p.message)
                            .join("\n");
                    }
                });
        },
        /* async getvehicle() {
      const response = await this.$http.get(
        `/workshop/vehiculo/payment/${this.vehiculo_id}`
      );
      if (response.status == 200) {
        this.vehiculo = response.data;
        this.form.items = this.formatItems(this.vehiculo.items);
        this.form.establishment_id = this.vehiculo.establishment_id;
        this.form.vehiculo_id = this.vehiculo_id;
        this.reCalculateTotal();
        this.form.enter_amount = this.form.total;
        console.log("🚀 ~ file: form.vue ~ line 566 ~ response", this.form);
        this.reloadDataCustomers(this.vehiculo.customer_id);
      } catch (error) {
        if (error.response && error.response.status === 400) {
          this.$toast.error(error.response.data.error);
        } else if (error.response && error.response.status === 404) {
          this.$toast.error(error.response.data.error);
        } else {
          this.$toast.error('Ocurrió un error inesperado.');
        }

      }
    }, */
        async getvehicle() {
            if (!this.vehiculo_id) {
                return;
            }
            try {
                const response = await axios.get(
                    `/workshop/vehiculo/payment/${this.vehiculo_id}`
                );
                if (response.status === 200) {
                    this.vehiculo = response.data;
                    this.form.items = this.formatItems(this.vehiculo.items);
                    this.form.services = this.formatItems(
                        this.vehiculo.services
                    );
                    this.form.establishment_id = this.vehiculo.establishment_id;
                    this.form.vehiculo_id = this.vehiculo_id;
                    this.reCalculateTotal();
                    this.form.enter_amount = this.form.total;
                    console.log(
                        "🚀 ~ file: form.vue ~ line 566 ~ response",
                        this.form
                    );
                    this.reloadDataCustomers(this.vehiculo.customer_id);
                }
            } catch (error) {
                if (error.response && error.response.status === 400) {
                    this.$showSAlert(
                        "error",
                        error.response.data.error,
                        "error"
                    );
                } else {
                    this.$showSAlert(
                        "error",
                        "Ocurrió un error inesperado.",
                        "error"
                    );
                }
            }
        },
        insertReferenceNumber() {
            console.log("entra a referencia");
            let pass = false;
            if (this.form.reference_number && this.form.bank_account_id) {
                let bank = this.bank_accounts.find(
                    b => b.id == this.form.bank_account_id
                );
                let message = `Se ha ingresado el número de referencia: ${this.form.reference_number} y la cuenta bancaria: ${bank.description} - ${bank.number}`;
                if (
                    this.form.observation == null ||
                    this.form.observation == ""
                ) {
                    this.form.observation = message;
                } else {
                    this.form.observation += "\n" + this.form.reference_number;
                }
                pass = true;
            }
            console.log(
                "🚀 ~ insertReferenceNumber ~ this.form.observatio:",
                this.form.observatio
            );
            return pass;
        },
        focusObservation() {
            this.$nextTick(() => {
                this.$refs.observation.focus();
            });
        },
        addDocumentDetraction(detraction) {
            //si  detraction no es objecto vacio
            if (Object.keys(detraction).length === 0) {
                return;
            }
            this.form.detraction = detraction;

            // this.has_data_detraction = (detraction.pay_constancy || detraction.detraction_type_id || detraction.payment_method_id || (detraction.amount && detraction.amount >0)) ? true:false
            this.has_data_detraction = detraction
                ? detraction.has_data_detraction
                : false;
        },
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
        selectDocumentType(id) {
            this.form.document_type_id = id;
            this.filterSeries();
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

            this.$forceUpdate();
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
                    item_id: i.item_id,
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
                    "El monto a agregar no puede ser 200 soles mayor al pago total "
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
            if (
                this.clientSaleNoteNumber ||
                this.form.hotel_customer_number ||
                this.form.quotation_customer_number
            ) {
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
            // this.discount_amount = 0;
            // this.form.customer_id
            // this.form.student_id = null;
            console.log("ver pasar el id del vehiculo", this.vehiculo_id);
            this.form.promotion_document_id =
                this.promotions_document.length > 0
                    ? this.promotions_document[0].id
                    : null;

            this.sumCoins = [];
            if (!this.form.is_room) {
                this.value = null;
                this.form.customer_id = null;
            }
            if (this.configuration.restrict_receipt_date) {
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
            if (this.variation) {
                this.form.document_type_id = "03";
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
            if (!this.hotel_customer_number) {
                this.checkForCustomer();
            }
            // this.checkForCustomer();
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
            this.hasDetraction = this.checkDetraction();
            if (
                this.hasDetraction &&
                this.company.detraction_account &&
                this.form.total > 700
            ) {
                let { detraction_type_id } = this.configuration;
                if (detraction_type_id) {
                    let detraction = this.detraction_types.find(
                        d => d.id == detraction_type_id
                    );
                    if (detraction) {
                        let amount =
                            this.form.total * (detraction.percentage / 100);
                        amount = Math.round(amount * 100) / 100;
                        this.form.detraction = {
                            amount,
                            bank_account: this.company.detraction_account,
                            detraction_type_id: detraction.id,
                            percentage: detraction.percentage,
                            payment_method_id: "001",
                            has_data_detraction: true
                        };
                    }
                }
            }
            this.getvehicle();
        },
        checkDetraction() {
            if (!this.configuration.detraction) return false;
            let { items } = this.form;
            return items.some(i => i.subject_to_detraction == 1);
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
                        " por S/" +
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
            // if (this.form.document_type_id == "03") {
            //     let date = moment();
            //     if (moment(this.form.date_of_issue).month() != date.month()) {
            //         this.$toast.error(
            //             "La fecha de emisión debe ser del mismo mes"
            //         );
            //         this.form.date_of_issue = moment().format("YYYY-MM-DD");
            //     }
            // }
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
                let total_taxed_without_rounding =
                    new_base - global_discount_amount_without_rounding;
                this.form.total_value = this.form.total_taxed;
                if (this.configuration.affectation_igv_type_id == "10") {
                    this.form.total_igv = _.round(
                        total_taxed_without_rounding *
                            (this.percentage_igv / 100),
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

            //
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
                (this.form.observation == "" &&
                    this.hasExceedBank &&
                    this.form.reference_number &&
                    this.form.bank_account_id)
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
            form.detraction = this.form.detraction;
            if (this.formVariation.items.length == 0) {
                form.variation = false;
            }
            if (this.variation == true) {
                form.variation = true;
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
                    // this.$emit("clearVariation");
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
                if (this.methodsValidate.includes(p.method)) {
                    if (!p.operation_number) {
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
            // form.date_of_issue = moment().format("YYYY-MM-DD");
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
            form.cash_id = this.cash_id;
            if (this.form.payment_condition_id == "01") {
                form.boxes = this.currentPayments;
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
            if (this.quotationId) {
                form.quotation_id = this.quotationId;
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

                console.log(
                    "🚀 ~ clickPayment ~ form.variation:",
                    form.variation
                );
                if (
                    (ordenId == undefined || ordenId == null) &&
                    (form.variation == undefined ||
                        form.variation == null ||
                        form.variation == false) &&
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
                        //this.$emit("printer",this.printer,format,1);
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
                            if (this.configuration.all_items_pos) {
                                this.$emit("reloadItems");
                            }
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
        },
        back(val = false) {
            // this.$emit()
            this.form.original_total = undefined;
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

            if (this.form.document_type_id == "01") {
                this.currentDocumentsType = [
                    ...this.documentsType.filter(f => f.description == "RUC")
                ];
                this.form.identity_document_type_id = this.currentDocumentsType[0].id;
            } else {
                this.currentDocumentsType = this.documentsType;
            }

            this.setSeries();
            let currentClient = null;
            if (this.value != null) {
                currentClient = this.all_customers.find(
                    c => c.id == this.value
                );
            }

            this.customers = this.customers.filter(n => n.number != "88888888");
            this.customers = [
                ...this.customers.filter(n => n.id != this.customer_default.id)
            ];
            if (this.form.document_type_id != "01") {
                this.customers = [...this.customers, this.customer_default];
            }

            if (this.form.hotel_customer_number) {
                await this.searchClientOne(this.form.hotel_customer_number);
            }
            if (this.form.quotation_customer_number) {
                await this.searchClientOne(this.form.quotation_customer_number);
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
