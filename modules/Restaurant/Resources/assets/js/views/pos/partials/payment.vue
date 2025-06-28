<!-- MODULO DE COBRO CAJA 8800 -->
<template>
    <el-dialog
        :visible="is_payment"
        @open="date_of_issue"
        @close="unlockButton"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :modal-append-to-body="true"
        :show-close="false"
        :append-to-body="true"
        :width="dialogWidth"
        top="2vh"
        :title="`MODULO DE COBRO ${variation ? '- Variación' : ''}`"
    >
        <!-- Ensure loading_submit covers the entire modal -->
        <div v-loading="loading_submit" :element-loading-text="loadingText">
            <div class=" mb-0">
                <div class="pt-1">
                    <!-- Cabecera del Modal de Cobro -->
                    <div class="">
                        <div class="card bg-light" style="margin-top: 2px; margin-bottom: 5px;">
                            <div class="card-body">
                                <div class="row" v-if="configuration.college">
                                    <el-checkbox
                                        @change="chageRegister"
                                        v-model="notRegister"
                                        >No registrado
                                    </el-checkbox>
                                </div>
                                <!-- Comprobante de Pago  -->
                                <div
                                    class="form-row d-flex align-items-center justify-content-between flex-wrap no-padding"
                                >
                                    <!-- Columna 1: Comprobante de Pago (Factura, Boleta, Nota) -->
                                    <div
                                        class="form-group col-12 col-md-6 d-flex flex-column pt-0 pb-0"
                                    >
                                        Comprobante de Pago
                                        <div
                                            class="shadow-box d-flex justify-content-between flex-wrap pt-0 pb-0"
                                        >
                                            <el-button-group
                                                v-model="form.document_type_id"
                                                @change="filterSeries"
                                            >
                                                <!-- Botón Factura -->
                                                <el-button
                                                    v-if="invoice"
                                                    label="01"
                                                    class="responsive-btn"
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
                                                    class="responsive-btn"
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
                                                    class="responsive-btn"
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
                                    <!-- Columna 2: Serie, Fecha de Emisión y Botón -->
                                    <div
                                        class="form-group col-12 col-md-6 d-flex flex-wrap pt-0 pb-0 justify-content-between"
                                    >
                                        <div
                                            class="d-flex justify-content-between w-100 align-items-center"
                                        >
                                            <!-- Serie -->
                                            <div
                                                class="form-group me-1"
                                                style="flex: 1 1 auto;"
                                            >
                                                <label
                                                    class="control-label fw-bold"
                                                    style="font-size: 1rem;"
                                                >
                                                    <i
                                                        class="fas fa-hashtag me-2"
                                                        style="font-size: 1.2rem;"
                                                    ></i>
                                                    Serie
                                                </label>
                                                <el-select v-model="form.series_id"
                                                    class="custom-select responsive-series-select" :style="{
                                                        backgroundColor:
                                                            form.document_type_id ===
                                                            '01'
                                                                ? '#4CAF50'
                                                                : form.document_type_id ===
                                                                  '03'
                                                                ? '#FFC107'
                                                                : form.document_type_id ===
                                                                  '80'
                                                                ? '#1E88E5'
                                                                : '#B0B0B0',
                                                        color: '#fff',
                                                        borderRadius: '5px',
                                                        height: '35px',
                                                        fontSize: '9px',
                                                        fontWeight: 'bold',
                                                        textAlign: 'center',
                                                        display: 'flex',
                                                        justifyContent:
                                                            'center',
                                                        alignItems: 'center'
                                                    }"
                                                    style="width: 100%;"
                                                >
                                                    <el-option
                                                        v-for="option in series"
                                                        :key="option.id"
                                                        :label="
                                                            option.full_number
                                                        "
                                                        :value="option.id"
                                                    ></el-option>
                                                </el-select>
                                            </div>
                                            <!-- Fecha de Emisión -->
                                            <div
                                                class="form-group me-1"
                                                style="flex: 1 1 auto;"
                                            >
                                                <label
                                                    class="control-label fw-bold"
                                                    style="font-size: 1rem;"
                                                >
                                                    <i
                                                        class="fas fa-calendar-alt me-2"
                                                        style="font-size: 1.2rem;"
                                                    ></i>
                                                    Emisión
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
                                                            .restrict_receipt_date
                                                    "
                                                    @change="changeDateOfIssue"
                                                ></el-date-picker>
                                            </div>
                                            <!-- Botón de Visualización de Lista de venta -->
                                            <div
                                                class="form-group me-1"
                                                style="flex: 1 1 auto;"
                                            >
                                                <el-tooltip
                                                    content="Visualiza los productos que se agregaron a la compra"
                                                    placement="top"
                                                >
                                                    <el-button
                                                        icon="fas fa-eye"
                                                        size="mini"
                                                        type="primary"
                                                        @click="
                                                            showListItems = true
                                                        "
                                                        style="font-size: 1.2rem; padding: 0 10px; height: 32px; border-radius: 16px; display: flex; align-items: center; justify-content: center;"
                                                    >
                                                    </el-button>
                                                </el-tooltip>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Clientes y Whatsapp -->
                        <div class="card" style="margin-bottom: 5px;">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <label class="mb-0">
                                                <i class="fas fa-user me-2"></i> Cliente
                                            </label>
                                            <div class="d-flex align-items-center gap-2 ms-auto">
                                                <!-- Botón Nuevo -->
                                                <el-tooltip content="Crear Cliente" placement="top">
                                                    <el-button v-if="!configuration.college || notRegister"
                                                        @click="createClient" class="btn_buscarsmall me-2"
                                                        type="primary" size="small">
                                                        <i class="fas fa-user fa-lg"></i>
                                                        Nuevo
                                                    </el-button>
                                                </el-tooltip>
                                                <!-- Botón Editar -->
                                                <el-tooltip content="Editar Cliente" placement="top">
                                                    <el-button
                                                        v-if="configuration.edit_clients && value && !isClientesVarios()"
                                                        @click="openDialogPerson" class="btn_excelsmall" type="success"
                                                        size="small">
                                                        <i class="fas fa-edit fa-lg"></i>
                                                        Editar
                                                    </el-button>
                                                </el-tooltip>
                                            </div>
                                        </div>
                                        <el-select class="w-100" ref="select_person" :loading="loading" v-model="value"
                                            filterable clearable size="small" placeholder="Cliente" :disabled="loading"
                                            @change="changeCustomer" @keyup.native="keyupCustomer">
                                            <el-option v-for="(option, idx) in customers" :key="idx"
                                                :label="option.description" :value="option.id"></el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="whatsapp">WhatsApp</label>
                                        <el-input v-model="form.customer_telephone" type="text" class="w-100"
                                            placeholder="Número de WhatsApp" size="large" maxlength="9" show-word-limit>
                                        </el-input>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-lg-6">
                                        <div class="flex-fill">
                                            <!-- <label for="observations">Observaciones</label> -->
                                            <el-input v-model="form.observation" type="text" class="w-100"
                                                placeholder="Observaciones" size="large"></el-input>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <el-select v-model="form.seller_id" class="w-100"
                                            placeholder="Seleccionar Vendedor" size="large">
                                            <el-option v-for="(option, idx) in sellers" :key="idx" :label="option.name"
                                                :value="option.id"></el-option>
                                        </el-select>
                                    </div>
                                    <!-- Estudiante -->
                                    <div v-if="students.length != 0" class="col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label w-100">
                                                Estudiante
                                            </label>
                                            <el-select @change="changeStudent" v-model="form.student_id">
                                                <el-option v-for="(student,
                                                    idx) in students" :key="idx" :label="`${student.name} - ${student.class}`
                                                        " :value="student.id">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 0; margin-bottom: 5px;">
                        <div class="col-lg-3">
                            <div class="card  h-100" style="background-color: #4CAF50 !important;">
                                <div class="card-body d-flex flex-column justify-content-center"
                                    style="padding: 4px 4px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="control-label text-primary fw-bold mb-0">
                                            Total Venta
                                        </label>
                                        <span class="control-label text-primary fw-bold mb-0 text-right">
                                            {{
                                                currencyIdChoice == "PEN"
                                                    ? "S/ "
                                                    : "$ "
                                            }}
                                            {{ " " + Number(form.total).toFixed(2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center justify-content-center" style="padding: 0;">
                            <div class="h-100 w-100" style="padding: 0; margin: 0;">
                                <div class="card-body d-flex justify-content-center align-items-center"
                                    :style="{ padding: 0, height: '100%' }">
                                    <div v-if="conf.show_discounts_payment" class="w-100">
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <label class="control-label fw-bold me-2">
                                                Descuento:
                                            </label>
                                            <input
                                                class="form-control w-25 text-right"
                                                v-model="discount_amount"
                                                @input="validateAndProcess"
                                                maxlength="8"
                                                placeholder="Descuento"
                                                style="appearance: none; -moz-appearance: textfield; -webkit-appearance: none; height: 20px;" 
                                            />
                                            <el-checkbox v-model="discountTotal" @change="reCalculateTotal"
                                                class="is-success ms-3"
                                                :style="{
                                                    transform: 'scale(0.8)',
                                                    marginLeft: '10px',
                                                    color: discountTotal ? '#388e3c' : '#1976d2',
                                                    fontWeight: 'bold'
                                                }">
                                                <span :style="{ color: discountTotal ? '#388e3c' : '#1976d2' }">
                                                    {{
                                                        discountTotal
                                                            ? "del total"
                                                            : "a la base"
                                                    }}
                                                </span>
                                            </el-checkbox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card bg-light h-100">

                                <div class="card-body d-flex flex-column justify-content-center" :style="{
                                    borderRadius: '5px',
                                    height: '100%',
                                    backgroundColor: form.difference < 0 ? '#dc3545' : '#073f68',
                                    color: '#fff',
                                    padding: '4px 4px'
                                }">
                                    <div class="d-flex justify-content-between align-items-center"
                                        style="height: 100%;">
                                        <label class="control-label fw-bold text-white mb-0" v-text="form.difference < 0
                                            ? 'Faltante: '
                                            : 'Vuelto: '
                                            "></label>
                                        <span v-if="is_payment == true" class="control-label fw-bold text-white">
                                            {{ currencySymbol }}
                                            {{
                                                form.difference
                                                    .toFixed(2)
                                                    .replace("-", "")
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Medios de Pago / Operaciones y Cargos por tarjeta Transferencias -->
                <div class="row">
                    <!-- Column 1: Medios de Pago -->
                    <div class="col-lg-6 col-md-12 mb-2">
                        <div class="text-center text-dark card bg-light" v-if="conf.show_payment_method">
                            <div class="align-items-start mb-2">
                                <label class="control-label">Medios de Pago</label>
                            </div>
                            <div class="btn-group flex-wrap radio-tile-group2" role="group" aria-label="Métodos de pago"
                                style="gap: 10px; display: flex; flex-wrap: wrap;">
                                <button type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '01' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonEfectivo.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '01'; method_payment('Efectivo')"></button>
                                <button v-if="configuration.culqi" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '02' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/CulquiIcon.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '02'; method_payment('Culqui')"></button>
                                <button v-if="configuration.izipay" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '05' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonIzipay.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '05'; method_payment('TARJETA: IZYPAY')"></button>
                                <button v-if="configuration.openpay" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '07' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonOpenpay.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '07'; method_payment('TARJETA: OPENPAY')"></button>
                                <button v-if="configuration.nubiz" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '06' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonNiubiz.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '06'; method_payment('TARJETA: NIUBIZ')"></button>
                                <button v-if="configuration.yape" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '03' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/yape-logo-3E473EE7E5-seeklogo.com.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '03'; method_payment('Yape')"></button>
                                <button v-if="configuration.plin" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '04' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/plin-logo-0C4106153C-seeklogo.com.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '04'; method_payment('PLIN')"></button>
                                <button v-if="configuration.didi" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '08' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonDidi.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '08'; method_payment('DIDI FOOD')"></button>
                                <button v-if="configuration.pedidosya" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '09' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonPedidosYa.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '09'; method_payment('PEDIDOS YA')"></button>
                                <button v-if="configuration.rappi" type="button" class="btn payment-btn-size"
                                    :class="['input-container2', 'border', 'rounded-sm', method_payments === '10' ? 'active' : '', form_payment.is_bank ? 'disabled' : '']"
                                    :style="{ backgroundImage: 'url(../../images/botonRappi.png)', backgroundSize: 'contain', backgroundRepeat: 'no-repeat' }"
                                    :disabled="form_payment.is_bank"
                                    @click="method_payments = '10'; method_payment('RAPPI')"></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 mb-2">
                        <div class="row">
                            <div class="" v-if="
                                methodsValidate.includes(
                                    form.method_pay
                                )
                            ">

                                <div class="d-flex align-items-center">
                                    <el-input type="number" v-model="operation_number" size="mini"
                                        placeholder="Nº Operación" class="d-inline-flex">
                                    </el-input>
                                </div>
                            </div>

                            <!-- Cargos de Tarjeta -->
                            <div class="col-12 mt-3" v-if="
                                hasCreditCardCharge &&
                                configuration.credit_mode
                            ">
                                <!-- Label "Porcentaje" o "Monto" alineado a la izquierda -->
                                <div class="d-flex align-items-center justify-content-between">
                                    <label class="font-weight-bold mb-1" style="text-align: left;">
                                        {{
                                            chargeCredit.credit_type == "1"
                                                ? "Porcentaje"
                                                : "Monto"
                                        }}
                                    </label>
                                    <span class="h6 font-weight-bold" style="margin-left: auto;" v-if="
                                        chargeCredit.total_charge !==
                                        0 && chargeCredit.amount">
                                        {{ chargeCredit.total_charge.toFixed(2) }}
                                    </span>
                                </div>

                                <!-- Fila para el Input, Radio Group y Total Calculado -->
                                <div class="d-flex align-items-center justify-content-between">
                                    <el-input type="number" @input="calculateCharge"
                                        style="max-width: 100px; font-weight: bold;" v-model="chargeCredit.amount"
                                        size="mini">
                                    </el-input>
                                    <div class="d-flex justify-content-center mx-3">
                                        <el-radio-group class="radio-buttons-group" @change="calculateCharge"
                                            v-model="chargeCredit.credit_type" size="mini"
                                            style="color: #004085; display: flex; flex-direction: row; align-items: center; gap: 0;">
                                            <el-tooltip
                                                content="Agrega en porcentaje (%) la comisión por pago con tarjeta"
                                                placement="top">
                                                <el-radio-button label="1"
                                                    style="color: white; border-top-right-radius: 0; border-bottom-right-radius: 0; margin-right: 0;">
                                                    <i class="fas fa-percent"></i>
                                                </el-radio-button>
                                            </el-tooltip>
                                            <el-tooltip
                                                content="Agrega un monto específico de comisión por pago con tarjeta"
                                                placement="top">
                                                <el-radio-button label="2"
                                                    style="color: white; border-top-left-radius: 0; border-bottom-left-radius: 0; margin-left: 0;">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </el-radio-button>
                                            </el-tooltip>
                                        </el-radio-group>
                                    </div>

                                    <!-- Total Calculado alineado a la derecha -->
                                    <!-- <span class="h6 font-weight-bold" style="margin-left: auto;" v-if="
                                            chargeCredit.total_charge !==
                                            0 && chargeCredit.amount
                                        ">
                                            S/
                                            {{
                                                chargeCredit.total_charge.toFixed(
                                                    2
                                                )
                                            }}
                                        </span> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transferencia / Depósitos -->
                    <div class="col-lg-3 col-md-12 mb-2">
                        <template v-if="bank_accounts.length != 0">
                            <div class="d-flex align-items-center">
                                <el-checkbox @change="transferPayment" v-model="form_payment.is_bank"></el-checkbox>
                                <label for="banks" class="mb-0 ms-2">
                                    Transferencia / Depósitos
                                </label>
                            </div>
                            <el-select :disabled="!form_payment.is_bank" v-model="form.bank_account_id"
                                @change="changeBankAccount">
                                <el-option v-for="bank in bank_accounts" :key="bank.id" :label="`${bank.description}-${bank.number}`
                                    " :value="bank.id">
                                </el-option>
                            </el-select>
                            <el-input :disabled="!form_payment.is_bank" class="mt-1" placeholder="Nro Operación"
                                v-model="form.reference_number"></el-input>
                        </template>
                        <template v-else>
                            <span class="text-danger">Sin cuentas registradas</span>
                        </template>
                    </div>
                </div>
                <!-- Ingreso de pagos/dividir pagos / pagos con metodo de pago/promocion -->
                <div class="row">
                    <div class="col-6" v-if="form_payment.payment_method_type_id == '01'">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label class="control-label fw-bold mb-0">Ingrese Monto</label>
                            <el-tooltip
                                :content="form.payment_condition_id == '01' ? 'Agregar Pago' : 'Agregar Cuota(s)'"
                                placement="top">
                                <el-button class="btn_buscarsmall ms-2" type="primary" @click="addPayment"
                                    :disabled="disabledAddPayment()">
                                    <span v-if="form.payment_condition_id == '01'">Agregar Pago</span>
                                    <span v-else>Agregar Cuota(s)</span>
                                </el-button>
                            </el-tooltip>
                        </div>

                        <div class="mb-1">
                            <el-input id="inputTotal" ref="enter_amount" v-model="form.enter_amount" @blur="diferen()"
                                @input="enterAmount()" class="me-3 flex-grow-1 w-100"
                                style="margin-right: 0px; min-width: 0; width: 100%;">
                                {{ currencyTypeActive.symbol }}
                            </el-input>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2" style="padding:0;">
                            <div class="quick-cash-btns d-flex justify-content-between align-items-center w-100"
                                style="gap: 8px; padding:0;" v-if="method_payments == '01'">
                                <button class="btn_buscarsmall"
                                    style="background-color: #1976d2; color: #fff; width: 50px;"
                                    @click="setAmountCash(10)">10</button>
                                <button class="btn_buscarsmall"
                                    style="background-color: #388e3c; color: #fff; width: 50px;"
                                    @click="setAmountCash(20)">20</button>
                                <button class="btn_buscarsmall"
                                    style="background-color: #fbc02d; color: #fff; width: 50px;"
                                    @click="setAmountCash(50)">50</button>
                                <button class="btn_buscarsmall"
                                    style="background-color: #d32f2f; color: #fff; width: 50px;"
                                    @click="setAmountCash(100)">100</button>
                                <button class="btn_buscarsmall"
                                    style="background-color: #7b1fa2; color: #fff; width: 50px;"
                                    @click="setAmountCash(200)">200</button>
                            </div>
                        </div>
                    </div>
                    <!-- Pagos  y Cuotas con método de pago -->
                    <div class="col-6">
                        <table class="table" v-if="currentPayments.length != 0">
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
                                <tr v-for="(paymnt, idx) in currentPayments" :key="idx"
                                    :class="{ 'table-secondary': idx % 2 === 0 }">
                                    <td>{{ idx + 1 }}</td>
                                    <td v-if="form.payment_condition_id !== '01'"
                                        style="min-width: 120px; max-width: 150px;">
                                        <el-date-picker :clearable="false" v-model="paymnt.date"
                                            style="width: 120px;"></el-date-picker>
                                    </td>
                                    <td>{{ paymnt.method }}</td>
                                    <td>
                                        <strong v-if="!isNaN(paymnt.amount)">{{
                                            Number(paymnt.amount).toFixed(2)
                                            }}</strong>
                                    </td>
                                    <td>
                                        <el-tooltip content="Eliminar pago" placement="top">
                                            <el-button type="danger" icon="el-icon-delete" circle
                                                @click="removePayment(paymnt.id)"></el-button>
                                        </el-tooltip>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" v-if="configuration.is_promotion_document || configuration.promotions_by_points">
                    <div class="col-6">
                        <div class="promotion-points-box text-center flex-fill me-1 mb-1"
                            style="min-width: 140px; padding: 4px 4px;">
                            <span class="fw-bold text-primary" style="font-size: 0.9rem;">
                                Puntos Acumulados :
                            </span>
                            {{ Number(pointsMessage || 0) }}
                        </div>
                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                            <el-select :disabled="isClientesVarios()" v-model="form.promotion_id" filterable clearable
                                placeholder="Promoción" @change="changePromotion" style="width: 100%;">
                                <el-option v-for="(option, idx) in promotions_document" :key="idx"
                                    :label="option.description" :value="option.id"></el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="promotion-points-box text-center flex-fill ms-1 mb-1"
                            style="min-width: 140px; padding: 4px 4px;">
                            <span class="fw-bold text-primary" style="font-size: 0.9rem;">
                                Puntos Ganados
                            </span>
                            {{ Math.floor(ventalista || 0) }}
                        </div>
                        <div class="col-md-12 d-flex flex-column ">
                            <div v-if="promotionDocument && hasPromotionText"
                                class="mb-1 d-flex align-items-center justify-content-center">
                                <el-checkbox @change="receivePromotion" v-model="form.receive_promotion"
                                    class="me-2"></el-checkbox>
                                <span class="fw-bold">Aplicar PROMO</span>
                                <span class="ms-2 text-success" style="font-size: 0.8rem;"> | {{
                                    hasPromotionText
                                }}</span>
                            </div>
                            <div v-if="promotionByPoints && hasPromotionText && listPromotionItems.length > 0"
                                class="d-flex ">
                                <el-button class="btn_canjearsmall" @click="Promotion()" type="">
                                    <i class="fas fa-gift me-1"></i> Canjear
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <!-- Pagos con método de pago (Tabla) -->
            <!-- <div class="mb-3 d-flex align-items-center">
                <table class="table" v-if="currentPayments.length != 0">
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
                        <tr v-for="(paymnt, idx) in currentPayments" :key="idx"
                            :class="{ 'table-secondary': idx % 2 === 0 }">
                            <td>{{ idx + 1 }}</td>
                            <td v-if="form.payment_condition_id !== '01'">
                                <el-date-picker :clearable="false" v-model="paymnt.date"></el-date-picker>
                            </td>
                            <td>{{ paymnt.method }}</td>
                            <td>
                                <strong v-if="!isNaN(paymnt.amount)">{{
                                    Number(paymnt.amount).toFixed(2)
                                }}</strong>
                            </td>
                            <td>
                                <el-tooltip content="Eliminar pago" placement="top">
                                    <el-button type="danger" icon="el-icon-delete" circle
                                        @click="removePayment(paymnt.id)"></el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <!--Billetes y Monedas a recibir por delivery -->
            <template v-if="configuration.show_coins_to_receive">
                <div class="m-2 p-0"
                    style="background-color: #f5f7fa; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <!-- Leyenda o Suma de Monedas -->
                    <div class="text-center mb-2" style="font-size: 1rem; font-weight: bold; color: #004085;">
                        <template v-if="sumCoins.length == 0">
                            Billetes/Monedas a Recibir
                        </template>
                        <template v-else>
                            {{ formatSumCoins }}
                        </template>
                    </div>

                    <!-- Grupo de Botones de Monedas/Billetes -->
                    <div class="d-flex justify-content-center align-items-center">
                        <el-button-group class="d-flex flex-wrap justify-content-center">
                            <el-button v-for="(coin, idx) in coins" type="primary" :key="idx" @click="addCoin(coin.id)"
                                size="small"
                                style="background-color: #007bff; border-color: #007bff; color: white; margin: 0 5px 5px 0; width: 60px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                round>
                                {{ coin.id }}
                            </el-button>

                            <!-- Botón de Limpiar -->
                            <el-tooltip content="Limpiar el conteo de monedas y billetes" placement="top">
                                <el-button type="danger" @click="clearSumCoins" size="small"
                                    style="background-color: #dc3545; border-color: #dc3545; color: white; margin: 0 0 5px 5px; width: 60px; height: 40px; display: flex; align-items: center; justify-content: center;"
                                    round>
                                    <i class="fas fa-trash"></i>
                                </el-button>
                            </el-tooltip>
                        </el-button-group>
                    </div>
                </div>
            </template>

            <div class="col-lg-12">
                <div class="card bg-light text-dark p-2" style="padding-bottom: 0 !important;">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Modo de Pago Contado/Crédito/Crédito a Cuotas -->
                            <div class="mb-0 w-100"
                                :class="{ 'disabled': !(form.document_type_id == '01' || form.document_type_id == '03') }">
                                <label class="fw-bold">Modo de Pago</label>
                                <el-select v-model="form.payment_condition_id"
                                    :disabled="!(form.document_type_id == '01' || form.document_type_id == '03')">
                                    <el-option value="01" label="Contado"></el-option>
                                    <el-option value="02" label="Crédito"></el-option>
                                    <el-option value="03" label="Crédito a cuotas"></el-option>
                                </el-select>
                            </div>

                            <!-- Afectación IGV -->
                            <template v-if="configuration.affectation_optional">
                                <div class="mb-3">
                                    <label>
                                        Afectación IGV
                                    </label>
                                    <el-select v-model="affectation_optional_id" clearable filterable>
                                        <el-option v-for="option in affectation_igv_types.filter(
                                            affectation =>
                                                affectation.id == '10'
                                        )" :key="option.id" :label="option.description" :value="option.id">
                                        </el-option>
                                    </el-select>
                                </div>
                            </template>
                            <!-- Si NO cumple la condición, todo debe estar habilitado (enabled) -->
                            <template v-else>
                                <div class="mb-3">
                                    <label>
                                        Afectación IGV
                                    </label>
                                    <el-select v-model="affectation_optional_id" clearable filterable :disabled="false">
                                        <el-option v-for="option in affectation_igv_types" :key="option.id"
                                            :label="option.description" :value="option.id">
                                        </el-option>
                                    </el-select>
                                </div>
                            </template>
                        </div>


                        <div class="col-lg-4">
                            <!-- Detracción -->
                            <div class="p-3 border rounded bg-light mb-0" :class="{ 'opacity-50': !hasDetraction }">
                                <h6 class="fw-bold mb-2">Detracción</h6>

                                <!-- Cta Bancaria y botón "Más..." -->
                                <div class="mb-2 d-flex align-items-center">
                                    <label for="account" class="fw-bold me-2">Cta Bancaria</label>
                                    <el-input class="flex-grow-1 me-2" v-model="company.detraction_account"
                                        :readonly="!hasDetraction" :disabled="!hasDetraction"></el-input>
                                    <button @click="showDialogDocumentDetraction = true" class="btn btn-outline-primary"
                                        :disabled="!hasDetraction">
                                        Más...
                                    </button>
                                </div>

                                <!-- Monto en la misma fila -->
                                <div class="d-flex align-items-center">
                                    <label for="amount" class="fw-bold me-2">Monto</label>
                                    <el-input v-model="form.detraction.amount" :readonly="!hasDetraction"
                                        :disabled="!hasDetraction" class="flex-shrink-1"
                                        style="width: 70px;"></el-input>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <br />
                            <div class="d-flex mb-0 justify-content-center">
                                <el-button :type="printerOn === 1 || printerOn === '1' ? 'primary' : 'default'"
                                    icon="fa fa-print" class="btn_buscarsmall"
                                    @click="printerOn = 1; updateConfigutation()" style="min-width: 120px;"
                                    :style="{ opacity: !printerOn ? 0.5 : 1 }">
                                    Imprimir
                                </el-button>
                                <el-button :type="printerOn === 0 || printerOn === '0' ? 'danger' : 'default'"
                                    icon="fa fa-ban" class="btn_noimprimirsmall"
                                    @click="printerOn = 0; updateConfigutation()" style="min-width: 120px;"
                                    :style="{ opacity: printerOn === 1 || printerOn === '1' ? 0.5 : 1 }">
                                    No Imprimir
                                </el-button>
                            </div>
                            <!-- Botón Dividir Pago -->
                            <!-- <div class="mb-3 d-flex justify-content-center" v-if="
                                form.payment_condition_id == '01' &&
                                configuration.split_payments_pos
                            ">
                                <el-button type="success" icon="el-icon-split" size="large" @click="handleDividirPagos"
                                    class="btn_dividirpagossmall ">
                                    Dividir Pago
                                </el-button>
                            </div> -->
                            <br />

                            <!-- Pagar y Cerrar -->
                            <div class="d-flex justify-content-between mb-3">
                                <button class="btn_buscarsmall" @click="handleOneClick" :disabled="isLocked">
                                    <i class="fas fa-money-bill-alt"></i>
                                    Pagar
                                </button>
                                <el-button v-if="
                                    form.payment_condition_id == '01' &&
                                    configuration.split_payments_pos
                                " type="success" size="large" @click="handleDividirPagos"
                                    class="btn_dividirpagossmall ">
                                    <i class="fas fa-cut me-1"></i>
                                    Dividir Pago
                                </el-button>
                                <button class="btn_noimprimirsmall" @click="back(false)">
                                    <i class="fa fa-reply"></i> Cerrar
                                </button>
                            </div>

                            <!-- Mensaje de Exceso de Monto (Bancarización) -->

                        </div>
                    </div>
                    <div v-if="hasExceedBank" class="text-center text-danger">
                        <span class="blinking">
                            El Monto a cobrar Requiere Bancarización, Desea ingresar Numero de Operación "Observaciones"
                        </span>
                    </div>
                </div>
            </div>

            <div v-if="splitPayments.length != 0" class="row m-1 p-2  bg-light rounded">
                <span style="margin-bottom:5px;">Pagos divididos</span>
                <div class="d-flex flex-wrap ">
                    <div v-for="(payment, idx) in splitPayments" :key="idx" class="col-2">
                        Pago {{ idx + 1 }}:
                        <strong>{{ currencyIdChoice }}
                            {{ payment.amount }}</strong>
                    </div>
                </div>
            </div>

            <div v-if="splitProducts.length != 0" class="row m-1 p-2  bg-light rounded">
                <span style="margin-bottom:5px;">Pagos divididos por producto</span>
                <div class="d-flex flex-wrap ">
                    <div v-for="(payment, idx) in splitProducts" :key="idx" class="col-3 m-1">
                        <table v-if="
                            payment.products &&
                            payment.products.length > 0
                        " class="col-12">
                            <thead>
                                <tr role="button" @click="selectAccount(idx)" :class="'bg-primary text-white border rounded-top'
                                    ">
                                    <th class="text-center" colspan="3">
                                        <b> CUENTA {{ idx + 1 }} </b>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border rounded-top " v-if="
                                payment.products &&
                                payment.products.length > 0
                            ">
                                <tr v-for="(product,
                                    idx) in payment.products" :key="idx">
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
                                    <td colspan="2" class="text-muted text-small" style="text-align:right">
                                        <b> Total</b>
                                    </td>
                                    <td class="text-muted text-small">
                                        {{ currencySymbol }}
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
            <!-- <div class="p-3"></div> -->
        </div>

        <multiple-payment-form
            v-if="showDialogMultiplePayment"
            :showDialog.sync="showDialogMultiplePayment"
            :payments="payments"
            @add="addRow"
        ></multiple-payment-form>

        <!-- <sale-notes-options :showDialog.sync="showDialogSaleNote"
                                    :recordId="saleNotesNewId"
                                    :showClose="true"></sale-notes-options>  -->

        <card-brands-form :showDialog.sync="showDialogNewCardBrand" :external="true"
            :recordId="null"></card-brands-form>
        <person-form v-if="showDialogNewPerson" :showDialog.sync="showDialogNewPerson" type="customers"
            :input_person="input_person" :external="true" :user_id.sync="form.user_id"
            :document_type_id.sync="form.document_type_id" @add_customer="add_customer" :recordId="form.customer_id"
            :fromPos="true">
        </person-form>
        <show-split-payment-form
            :form="form"
            :series="all_series"
            :orden_items="orden_items"
            @receivePayments="receivePayments"
            @receiveProducts="receiveProducts"
            :total="form.total"
            :showSplitPayment.sync="showSplitPayment"
            :customer_default="customer_default"
            @setPayments="setPayments"
            :printerOn="printerOn"
            :establishments="establishments"
        >
        </show-split-payment-form>
        <person-college-form
            v-if="showCollegePersonDialog"
            :showDialog.sync="showCollegePersonDialog"
            :extern="true"
            :fromPerson="true"
            :recordId="collegePersonId"
        >
        </person-college-form>
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
        <list-items :showDialog.sync="showListItems" :form="form"> </list-items>
        <Promotion-Box
            :showDialog.sync="showDialogPromotionBox"
            :listPromotionItems="listPromotionItems"
            :hasPromotionText="hasPromotionText"
            @update:showDialog="showDialog = $event"
            @submit="handleSubmit"
        >
        </Promotion-Box>
    </el-dialog>
</template>

<style scoped>
.custom-image-btn:focus {
    outline: 2px solid #1976d2;
}

.promotion-section {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    border: 1px solid #e0e0e0;
}

.promotion-points-box {
    background: #f5f7fa;
    border-radius: 8px;
    padding: 12px 8px;
    min-width: 120px;
    margin-bottom: 0;
}

@media (max-width: 992px) {
    .promotion-section {
        padding: 10px 5px;
    }

    .promotion-points-box {
        font-size: 1rem;
        padding: 8px 4px;
    }
}



.input-container2 {
    width: 100px;
    /* Ancho del botón */
    height: 50px;
    /* Alto del botón */
    border-radius: 8px;
    /* Bordes redondeados */
    overflow: hidden;
    /* Asegura que la imagen no sobresalga */
    cursor: pointer;
    /* Muestra el cursor interactivo */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    /* Transiciones suaves */
}

.input-container2:hover {
    transform: scale(1.05);
    /* Agranda ligeramente el botón al pasar el cursor */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    /* Sombra más pronunciada */
}



.radio-tile2 {
    background-size: 80% 80%;
    background-position: center;
    background-repeat: no-repeat;
    width: 80%;
    height: 80%;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10), 0 1.5px 3px rgba(0, 0, 0, 0.07);
    transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
}

.input-container2:has(.radio-button2:checked) .radio-tile2,
.input-container2.active .radio-tile2 {
    border: 2px solid #1976d2;
    box-shadow: 0 4px 16px rgba(25, 118, 210, 0.15);
    transform: scale(1.04);
}

.input-container2:hover .radio-tile2 {
    border: 2px solid #90caf9;
    box-shadow: 0 6px 18px rgba(25, 118, 210, 0.18);
    transform: scale(1.03);
}

.radio-tile-label2 {
    display: none;
    /* Oculta el label por defecto */
}


.container-fluid {
    width: 100%;
    /* Ocupa el ancho completo */
    padding-right: 0px;
    /* Padding interno para mantener contenido alineado */
    padding-left: 0px;
    /* Padding interno */
    margin-right: auto;
    /* Centra el contenedor en dispositivos grandes */
    margin-left: auto;
    /* Centra el contenedor en dispositivos grandes */
}

.no-padding {
    padding: 0 !important;
}

/* Para el icono de los botones */
.custom-radio-button i {
    color: inherit !important;
    /* Asegura que el icono también herede el color */
}

.custom-select {
    width: 70% !important;
    /* Agregamos !important para asegurar que no se sobreescriba */
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

/* Estilo por defecto para pantallas grandes (muestra el texto y el ícono) */
.radio-buttons-group .el-radio-button {
    padding: 5px 15px;
    /* Ajusta el espacio entre íconos y texto */
    display: flex;
    align-items: center;
}

/* Oculta el texto en pantallas pequeñas, solo muestra los íconos */
.radio-buttons-group .el-radio-button .radio-button-text {
    margin-left: 10px;
    /* Espacio entre el ícono y el texto */
}

/* Media query para pantallas de tamaño 1280x768px */
@media (max-width: 1280px) and (max-height: 768px) {
    /* Ajuste en los botones para pantallas pequeñas */
    .radio-buttons-group .el-radio-button {
        padding: 5px;
        /* Reduce el padding en pantallas pequeñas */
    }

    .radio-buttons-group .el-radio-button .radio-button-text {
        display: none;
        /* Oculta el texto */
    }

    .radio-buttons-group .el-radio-button i {
        font-size: 20px;
        /* Ajusta el tamaño del ícono */
    }

    .radio-buttons-group .el-radio-button {
        width: 40px;
        /* Ajusta el tamaño del botón */
        height: 40px;
        /* Ajusta el tamaño del botón */
    }
}

/* Media query para pantallas muy pequeñas (como móviles) */
@media (max-width: 576px) {
    /* Ajuste aún más pequeño en los íconos y botones */
    .radio-buttons-group .el-radio-button i {
        font-size: 18px;
        /* Tamaño de ícono más pequeño */
    }

    .radio-buttons-group .el-radio-button {
        width: 35px;
        /* Ajusta el tamaño aún más pequeño */
        height: 35px;
    }
}

.responsive-btn {
    transition: all 0.2s;
}

@media (max-width: 1280px) {
    .responsive-btn {
        font-size: 12px !important;
        padding: 4px 8px !important;
        width: 90px !important;
        height: 36px !important;
    }
}

.blinking {
    animation: blinkingText 1.2s infinite;
}

@keyframes blinkingText {
    0% {
        opacity: 1;
    }

    80% {
        opacity: 1;
    }

    90% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

/* Tamaño personalizado para los botones de medios de pago */
.payment-btn-size {
    width: 20px;
    height: 40px;
    min-width: 20px;
    min-height: 40px;
    background-position: center;
}

.payment-btn-size.active {
    background-color: #077927 !important;
    /* Si el botón tiene imagen, puedes agregar un overlay si lo deseas */
    /* box-shadow: 0 0 0 2px #073f68; */
}

.tile-unselected {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.radio-tile2 {
    opacity: 1;
    transition: opacity 0.2s;
}
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
const PromotionBox = () => import("./promotion_box.vue");
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
import Swal from "sweetalert2";
export default {
    components: {
        PromotionBox,
        ListItems,
        PersonCollegeForm,
        CardBrandsForm,
        MultiplePaymentForm,
        PersonForm,
        ShowSplitPaymentForm,
        DocumentDetraction
    },

    props: [
        "user",
        "currencyIdChoice",
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
        "desarrollador",
        "percentage_igv",
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
            isLocked: false,
            all_series: [],
            listPromotionItems: [],
            promotionItems: [],
            showDialogPromotionBox: false,
            promotionItems: [],
            showDialogPromotionBox: false,
            dialogWidth: "70%",
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
                "Plin",
                "TARJETA: Izipay",
                "TARJETA: Culqui",
                "TARJETA: Niubiz",
                "TARJETA: Openpay"
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
            pointsMessage: "",
            ventalista: 0,
            time: null,
            typing: false,
            typingDelay: 1000
        };
    },
    computed: {
        isAndroid() {
            return this.establishments.android_configuration;
        },
        isCreditCash() {
            return this.establishments.credit_warehouse;
        },
        promotionByPoints() {
            return this.configuration.promotions_by_points;
        },
        promotionDocument() {
            return this.configuration.is_promotion_document;
        },
        currencySymbol() {
            return this.currencyIdChoice == "PEN" ? "S/ " : "$";
        },
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
        await this.$http.get(`/caja/pos/series`).then(response => {
            this.all_series = response.data.series;
        });
        if (this.configuration.detraction) {
            await this.$http
                .get(`/documents/detraction/tables`)
                .then(response => {
                    this.detraction_types = response.data.detraction_types;
                    this.cat_payment_method_types =
                        response.data.cat_payment_method_types;
                });
        }
        this.$eventHub.$on("initInputPerson", () => {
            this.initInputPerson();
        });
        this.conf = this.establishments.conf ?? {};
        this.button_payment = true;
        this.currentDocumentsType = this.documentsType;
        if (this.currentDocumentsType.length > 0) {
            this.form.identity_document_type_id = this.currentDocumentsType[0].id;
        }
        if (!this.form.customer_id && !this.form.promotion_sale) {
            this.form.customer_id = this.establishments.customer_id;
            this.value = this.establishments.customer_id;
        } else {
            this.value = this.form.customer_id;
        }

        this.isInterno = this.company.soap_type_id == "03";

        // await this.getTables();
        await this.date_of_issue();

        this.$eventHub.$on("reloadDataCardBrands", card_brand_id => {
            this.reloadDataCardBrands(card_brand_id);
        });
        await this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });

        // await this.getFormPosLocalStorage();

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
    // mounted() {},
    mounted() {
        this.updateDialogWidth();
        window.addEventListener("resize", this.updateDialogWidth);

        this.$on("auto-payment", async form => {
            if (this.printerOn === 1 || this.printerOn === true) {
                this.printerOn = 0;
                await this.updateConfigutation();
            }

            this.sendPayment(null, form);
        });
    },
    beforeDestroy() {
        window.removeEventListener("resize", this.updateDialogWidth);
    },
    methods: {
        async handleOneClick() {
            if (this.isLocked) return;

            this.isLocked = true;

            try {
                await this.sendPayment();
            } catch (error) {
                console.error("Error en el pago:", error);
            }
        },

        handleDividirPagos() {
            this.form.document_type_id = "80";
            this.filterSeries();
            this.showSplitPayment = true;
        },
        someItemAffected20() {
            if (!this.form.items) return false;
            return this.form.items.some(
                item => item.affectation_igv_type_id == "20"
            );
        },
        //agragado para poder agregar la cantidad de promociones que se puede canjear
        handleSubmit(updatedPromotionItems) {
            this.listPromotionItems = updatedPromotionItems;
            this.applySelectedPromotions();
        },
        Promotion() {
            this.showDialogPromotionBox = true;
        },
        changePromotion() {
            if (!this.form.promotion_id) return;
            if (this.configuration.is_promotion_document) {
                this.verifyPromotionCustomer();
            } else if (this.promotionByPoints) {
                if (!this.isClientesVarios()) {
                    this.verifyPromotionPointsCustomer();
                }
            }
        },
        receivePromotion() {
            // console.log(this.form.items);
            if (this.form.receive_promotion) {
                this.fetchPromotionItems();
            } else {
                this.clearPromotionPointsItem();
            }
        },
        //aqui tamsforma los item y valida si la quantity es mayor a 0
        applySelectedPromotions() {
            const validItems = this.listPromotionItems.filter(
                item => item.quantity > 0
            );
            validItems.forEach(item => {
                this.form.item_promotion_id = item.id;

                this.promotionPointsItem();
            });
            if (validItems.length === 0) {
            }
        },
        validateAndProcess(event) {
            const value = event.target.value;

            if (isNaN(value)) {
                // Mostrar alerta sin botón de confirmación y con temporizador
                Swal.fire({
                    icon: "error",
                    title: "Entrada no válida",
                    text: "Solo se aceptan números.",
                    timer: 2000, // 2 segundos
                    showConfirmButton: false,
                    toast: true, // Aparece como un pequeño mensaje flotante
                    position: "top-end" // Posición en la esquina superior derecha
                });

                // Limpiar el campo
                this.discount_amount = "";
            } else {
                // Actualizar el modelo y llamar a inputDiscountAmount
                this.discount_amount = value;
                this.inputDiscountAmount();
            }
        },

        reCalculateTotal() {
            // ...existing code...

            // Calcula puntos basado en el total de venta (form.total) y el monto de promocion (total)
            let saleTotal = this.form.total; // Monto total de la venta
            let promotionTotal = this.total || 0; // Monto que tiene la promoción
            let points_value = this.points_value || 0.1; // Valor de puntos por unidad monetaria

            // Calcula puntos solo si hay un monto de venta
            if (saleTotal > 0) {
                // Si hay monto de promoción, usa ese para calcular puntos
                if (promotionTotal > 0) {
                    this.ventalista = parseFloat(
                        (saleTotal / promotionTotal).toFixed(2)
                    );
                } else {
                    // Si no hay monto de promoción, usa el cálculo estándar
                    this.ventalista = parseFloat(
                        (saleTotal * points_value).toFixed(2)
                    );
                }
            } else {
                this.ventalista = 0;
            }

            // ...existing code...
        },
        formatNumber(value) {
            return new Intl.NumberFormat("es-PE", {
                style: "decimal",
                minimumFractionDigits: 2
            }).format(value);
        },
        selectDocumentType(id) {
            this.form.document_type_id = id;
            this.filterSeries();
        },
        updateDialogWidth() {
            // Cambiar el ancho según el tamaño de la pantalla
            if (window.innerWidth <= 1280) {
                // Si la pantalla es pequeña
                this.dialogWidth = "85%"; // Ajustar a 90% en pantallas pequeñas
            } else {
                this.dialogWidth = "60%"; // Mantener 70% en pantallas grandes
            }
        },
        sendAjustment(amount) {
            this.$http.post("/cash/adjustment", {
                amount,
                cash_id: this.cash_id
            });
        },
        setPayments(payments) {
            this.currentPayments = [];
            payments.forEach(payment => {
                this.form.enter_amount = payment.amount;
                this.method_payments = payment.payment_method;
                this.addPayment();
            });
            this.enterAmount();
            let diffence = _.round(this.form.difference, 2);

            if (diffence > 0) {
                this.sendAjustment(diffence);
            }
            this.printerOn = 0;
            this.sendPayment();
        },
        insertReferenceNumber() {
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

            return pass;
        },
        focusObservation() {
            if (!this.isAndroid) {
                this.$nextTick(() => {
                    this.$refs.observation.focus();
                });
            }
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
                        //amount: this.form.total,
                        amount: this.form.enter_amount,
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
                            customer.identity_document_type_id != "1" &&
                            customer.identity_document_type_id != "4")
                    ) {
                        return true;
                    }
                }
            }
            return false;
        },

        isClientesVarios() {
            if (!this.value) return false;

            const customer = this.customers.find(c => c.id === this.value);

            return !!(
                customer &&
                (customer.number === "99999999" ||
                    customer.name.toLowerCase().includes("clientes varios"))
            );
        },
        checkTotal(newMethod) {
            /* let hasExceedBank = false; */
            /* if (hasExceedBank) {
                Swal.fire({
                    icon: "warning", // Icono de alerta
                    title: "Atención",
                    html: `
                        <div class="text-danger">
                            Recuerde que debido al monto deberá hacer
                            esta operación mediante Bancarización.
                            Ingrese en el campo "Observaciones" el
                            número de voucher o número de operación.
                        </div>
                    `,
                    confirmButtonText: "Entendido",
                    customClass: {
                        htmlContainer: "text-center" // Para centrar el texto
                    }
                });
            } */

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
        getFreeAfectation(affectation_igv_type_id) {
            if (affectation_igv_type_id == 10) {
                return "15";
            }
            if (affectation_igv_type_id == 20) {
                return "21";
            }
            return affectation_igv_type_id;
        },
        addFreeItem(i) {
            let affectation_igv_type_id = this.getFreeAfectation(
                i.sale_affectation_igv_type_id
            );
            //  i.sale_affectation_igv_type_id ==
            let item = {
                ...i,
                warehouse_id: null,
                item: i,
                item_id: i.id,
                unit_value: 0,
                quantity: i.quantity,
                aux_quantity: i.quantity,
                total_base_igv:
                    affectation_igv_type_id == 10
                        ? (i.sale_unit_price * i.quantity) /
                          (1 + this.percentage_igv / 100)
                        : i.sale_unit_price * i.quantity,
                percentage_igv: this.percentage_igv,
                total_igv:
                    affectation_igv_type_id == 10 ||
                    affectation_igv_type_id == 15
                        ? (i.sale_unit_price *
                              i.quantity *
                              this.percentage_igv) /
                          100
                        : 0,
                total_base_isc: 0.0,
                percentage_isc: 0.0,
                total_isc: 0.0,
                total_base_other_taxes: 0.0,
                percentage_other_taxes: 0.0,
                total_other_taxes: 0.0,
                total_taxes: 0,
                total_value: i.quantity * i.sale_unit_price,
                total_charge: 0.0,
                total_discount: 0.0,
                // total: i.sale_unit_price * i.quantity,
                price_type_id: "02",
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

            this.form.items.push(item);
            this.reCalculateTotal();
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
            const originalTotal = this.form.original_total;
            let { amount, credit_type } = this.chargeCredit;
            if (credit_type == "1") {
                this.chargeCredit.total_charge = originalTotal * (amount / 100);
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
            // No permitir más de 5 métodos de pago
            /* if (this.currentPayments.length >= 5) {
                return true;
            }
            // No permitir más de un pago en efectivo
            if (
                this.method_payments === "01" &&
                this.currentPayments.some(p => p.method_payment_id === "01")
            ) {
                return true;
            }
            // No permitir que la suma de pagos supere el total
            let totalPagos = this.currentPayments.reduce((a, b) => a + Number(b.amount), 0);
            if (Number(this.form.enter_amount) + totalPagos > Number(this.form.total)) {
                return true;
            } */
            if (this.form.payment_condition_id == "03") {
                return this.checkPaymentTotal() == 0.0;
            }
            if (this.form.payment_condition_id == "02") {
                return this.currentPayments.length > 0;
            }
            return false;
        },
        addPayment() {
            if (this.currentPayments.length >= 5) {
                this.$toast.error("Solo se pueden agregar hasta 5 métodos de pago.");
                return;
            }
            // No permitir más de un pago en efectivo
            if (
                this.method_payments === "01" &&
                this.currentPayments.some(p => p.method_payment_id === "01")
            ) {
                this.$toast.error("Solo se puede agregar un pago en efectivo.");
                return;
            }
            // No permitir que la suma de pagos supere el total
            let totalPagos = this.currentPayments.reduce((a, b) => a + Number(b.amount), 0);
            if (Number(this.form.enter_amount) + totalPagos > Number(this.form.total)) {
                this.$toast.error("El monto total de los pagos no puede superar el total a cobrar.");
                return;
            }
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
        /* async keyupCustomer(e) {
            //buscar
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;

                if (!this.input_person.number) {
                    return;
                }

                let url = `/caja/search_customers?value=${this.input_person.number}`;
                if (this.configuration.college) {
                    url = `${url}&parents=${this.notRegister ? 0 : 1}`;
                }
                const response = await this.$http(url);
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");
                this.updateAllCustomers(this.customers);
            }, 1000);
        }, */

        async keyupCustomer(e) {
            if (this.time) {
                clearTimeout(this.time);
            }

            this.typing = true;

            const isRUC = this.form.identity_document_type_id === "6";
            const delay = isRUC ? 500 : this.typingDelay;

            this.time = setTimeout(async () => {
                this.typing = false;

                const inputEl = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0];
                this.input_person.number = inputEl.value;

                if (!this.input_person.number) {
                    return;
                }
                if (this.input_person.number.length < 3) {
                    return;
                }

                let url = `/caja/search_customers?value=${this.input_person.number}`;
                if (this.configuration.college) {
                    url += `&parents=${this.notRegister ? 0 : 1}`;
                }

                const response = await this.$http(url);
                const { persons } = response.data;

                this.customers = persons.filter(n => n.number != "88888888");

                if (this.customers.length === 0) {
                    this.value = null;
                    this.form.customer_id = null;
                    return;
                }

                this.updateAllCustomers(this.customers);
            }, delay);
        },
        async updateAllCustomers(personsFromServer) {
            if (personsFromServer.length === 0) {
                return;
            }

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

        verifyPromotionPointsCustomer() {
            this.$http
                .get(
                    `/promotions-document/points-customers/${this.form.customer_id}/${this.form.promotion_id}`
                )
                .then(response => {
                    if (response.status == 200) {
                        let { data } = response;
                        if (data.success) {
                            this.hasPromotionText = data.message;
                            this.pointsMessage = data.message; // Store the points value here
                            this.points_value = data.points_value;
                            this.total = data.total;
                            this.listPromotionItems = data.items;

                            // Calculate points to be earned from this sale
                            this.calculatePointsEarned();
                        } else {
                            this.hasPromotionText = null;
                            this.pointsMessage = "";
                            this.points_value = "";
                            this.total = "";
                            this.listPromotionItems = [];
                            this.ventalista = 0;
                        }
                    }
                });
        },
        calculatePointsEarned() {
            if (this.points_value && this.form.total && this.total) {
                // Calculate points earned based on total sale and points_value
                this.ventalista = parseFloat(
                    (
                        (this.form.total * this.points_value) /
                        this.total
                    ).toFixed(2)
                );
            } else {
                this.ventalista = 0;
            }
        },
        verifyPromotionCustomer() {
            this.hasPromotionText = null;
            this.$http
                .get(
                    `/promotions-document/records-customers/${this.form.customer_id}/${this.form.promotion_id}`
                )
                .then(response => {
                    if (response.status == 200) {
                        let { promotions, success } = response.data;
                        if (success) {
                            this.hasPromotionText = promotions
                                .map(p => p.message)
                                .join("\n");
                        } else {
                            this.$toast.error(data.message);
                        }
                    }
                });
        },
        changeCustomer() {
            this.hasPromotionText = null;
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

                // Resetear la promoción si es Clientes Varios o seleccionar la primera disponible
                if (this.isClientesVarios()) {
                    this.form.promotion_id = null;
                } else if (
                    this.promotions_document &&
                    this.promotions_document.length > 0
                ) {
                    this.form.promotion_id = this.promotions_document[0].id;
                }

                this.form.customer_telephone = customer.phone;
                this.setLocalStorageIndex("customer", this.customer);
                if (
                    this.clientSaleNoteNumber &&
                    customer.identity_document_type_id !== "6"
                ) {
                    this.form.document_type_id = "03";
                }
                this.changePromotion();
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
            this.loadingLastNumber = true;
            try {
                const response = await this.$http.post(
                    `${this.resource}/last_number_documents`,
                    {
                        series: this.all_series,
                        ordenId: this.idOrden
                    }
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
                    this.selectDocumentType(this.form.document_type_id);
                }
            } catch (e) {
                this.$toast.error(
                    "Error al obtener el ultimo numero de documento"
                );
            } finally {
                this.loadingLastNumber = false;
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
        resetForm() {
            this.currentPayments = [];
            this.hasPromotionText = null;
            this.paymentVariation = {
                description: "Consumo",
                price: 0
            };
            this.isRestaurantWarehouse = false;
            this.showDialogDocumentDetraction = false;
            this.hasDetraction = false;
            this.notRegister = false;
            this.loadingText = "Cargando...";
            this.gotClient = false;
            this.showListItems = false;
            this.discountTotal = false;
            this.paymentCondition = "01";
            this.affectation_optional_id = null;
            this.hasCreditCardCharge = false;
            this.chargeCredit = {
                credit_type: "1",
                total_charge: 0,
                amount: 5
            };
            this.collegePersonId = null;
            this.started = true;
            this.refCustomer = null;
            this.time = null;
            this.splitPayments = [];
            this.splitProducts = [];
            this.showCollegePersonDialog = false;
            this.isInterno = false;
            this.showSplitPayment = false;
            this.currencyTypeActive = {
                symbol: "S/ "
            };
            this.currentPayments = [];
            this.input_person = {};
            this.customer = null;
            this.value = null;
            this.enabled_discount = true;
            this.discount_amount = 0;
            this.loading_submit = false;
            this.showDialogOptions = false;
            this.showDialogMultiplePayment = false;
            this.showDialogSaleNote = false;
            this.showDialogNewCardBrand = false;
            this.documentNewId = null;
            this.saleNotesNewId = null;
            this.resource_options = null;
            this.has_card = false;
            this.method_payments = "01";
            this.number = null;

            this.amount = 0;
            this.operation_number = null;
            this.printerOn = 0;
            this.button_payment = false;
            this.input_item = "";
            this.form_payment = {
                is_bank: false
            };

            this.cancel = false;
            this.form_cash_document = {};

            this.invoice = true;
            this.receipt = true;
            this.sale_note = true;
            this.last_date = null;

            this.bank = null;
            this.hasExceedBank = false;
        },
        async date_of_issue() {
            this.resetForm();

            console.log("this.form_variation", this.formVariation);
            // this.discount_amount = 0;
            // this.form.customer_id
            // this.form.student_id = null;

            if (!this.conf.pos_quick_sale) {
                this.getLastNumbersDocument();
            }
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
                if (!this.gotClient && this.$refs.select_person) {
                    setTimeout(() => {
                        this.$refs.select_person.$el.getElementsByTagName(
                            "input"
                        )[0].value = this.clientSaleNoteNumber;
                        this.keyupCustomer();
                    }, 50);
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

            // Modificar la asignación de promoción por defecto
            if (
                this.promotions_document &&
                this.promotions_document.length > 0 &&
                !this.isClientesVarios()
            ) {
                this.form.promotion_id = this.promotions_document[0].id;
                if (this.form.promotion_id) {
                    this.changePromotion();
                }
            } else {
                this.form.promotion_id = null;
            }

            if (this.form.offert) {
                this.form.items = this.form.items.map(item => {
                    let key = Math.random()
                        .toString(36)
                        .substring(2, 7);
                    return { ...item, temp_key: key };
                });
                this.setSaleOffert();
                this.setOffertObservation();
            }
            await this.initFormPayment();
            await this.setInitialAmount();
            this.setAmountCash(this.form.total);
            this.discountTotal = this.someItemAffected20();
        },
        setOffertObservation() {
            let offert = this.form.offert;
            let { quantity_free, quantity_total } = offert;
            this.form.observation = `Oferta de ${quantity_free} x ${quantity_total}`;
        },
        setSaleOffert() {
            let offert = this.form.offert;
            let { quantity_free, quantity_total } = offert;
            let quantity = quantity_free - quantity_total;

            let itemsOrdenados = [...this.form.items].sort((a, b) => {
                return a.unit_price - b.unit_price;
            });

            let itemsSeleccionados = itemsOrdenados.slice(0, quantity);

            itemsSeleccionados.forEach(item => {
                let index = this.form.items.findIndex(
                    i => i.temp_key === item.temp_key
                );
                if (index !== -1) {
                    this.form.items.splice(index, 1);
                }
            });

            itemsSeleccionados.forEach(item => {
                this.addFreeItem(item.item);
            });
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
            if (this.$refs.enter_amount) {
                if (width > 800) {
                    if (!this.isAndroid) {
                        await this.$refs.enter_amount.$el
                            .getElementsByTagName("input")[0]
                            .focus();
                    }
                    await this.$refs.enter_amount.$el
                        .getElementsByTagName("input")[0]
                        .select();
                } else {
                    if (!this.isAndroid) {
                        await this.$refs.observation.$el
                            .getElementsByTagName("textarea")[0]
                            .focus();
                    }
                }
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
        getTotalAffected() {
            let { items } = this.form;
            let total_affected = 0;
            items.forEach(item => {
                if (item.affectation_igv_type_id === "10") {
                    total_affected += item.total_value;
                }
            });
            return total_affected;
        },
        getTotalExonerated() {
            let { items } = this.form;
            let total_exonerated = 0;
            items.forEach(item => {
                if (item.affectation_igv_type_id === "20") {
                    total_exonerated += item.total_value;
                }
            });
            return total_exonerated;
        },
        // para calcular el descuento global que se puede canjear a toda la venta
        /* discountGlobal() {
            // this.form.total = this.form.total_value;
            let global_discount = parseFloat(this.discount_amount);
            let total = parseFloat(this.form.total);
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
                    description: "Descuentos globales que no afectan la base imponible del IGV/IVAP",
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
                console.log("ver si paso pro aqui", discount_with_base_variant);
                if (discount_with_base_variant) {
                    console.log("paso por aqui");
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
            // para calcular descuentos
            if (
                this.configuration.sale_note_credit_cash &&
                this.form.document_type_id == "80"
            ) {
            } else {
                this.form.enter_amount = this.form.total;
                this.enterAmount();
            }
        }, */
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
            if (
                this.configuration.sale_note_credit_cash &&
                this.form.document_type_id == "80"
            ) {
            } else {
                this.form.enter_amount = this.form.total;
                this.enterAmount();
            }
        },

        discountGlobal3() {
            let global_discount = parseFloat(this.discount_amount);
            let total = parseFloat(this.form.total);
            let base = parseFloat(this.form.total_value);
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

        // aqui es donde se considera todo los metodos de pago
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
        // aqui hace el proceso de recalculo de los montos
        reCalculateTotal() {
            if (!this.form.items || this.form.items.length == 0) {
                return;
            }
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
            /* console.log("Items antes del cálculo:", JSON.stringify(this.form.items)); */
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
                    ["11", "12", "13", "14", "15", "16"].includes(
                        row.affectation_igv_type_id
                    )
                ) {
                    let unit_value = row.total_value / row.quantity;
                    let total_value_partial = unit_value * row.quantity;
                    row.total_taxes =
                        row.total_value -
                        total_value_partial +
                        isNaN(parseFloat(row.total_plastic_bag_taxes))
                            ? 0.0
                            : parseFloat(row.total_plastic_bag_taxes);
                    row.total_igv =
                        total_value_partial * (row.percentage_igv / 100);
                    row.total_base_igv = total_value_partial;
                    total_value -= row.total_value;
                    total += parseFloat(row.total);
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
                if (!["21", "37"].includes(row.affectation_igv_type_id)) {
                    total_value += row.total_value;
                }
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
            //para el calculo de venta en descuento global
            /* if (!(
                boxes + amount1 < amount2 &&
                this.form.document_type_id == "80")){
                this.form.enter_amount = this.form.total;
                this.enterAmount();
            } */

            if (this.discount_amount) {
                this.discountGlobal();
            }

            console.log(this.form);

            console.log("Totales después del redondeo:", {
                total_taxed: this.form.total_taxed,
                total_igv: this.form.total_igv,
                total_value: this.form.total_value
            });
            // this.discountGlobal();

            let saleTotal = this.form.total; // Monto total de la venta
            let promotionTotal = this.total || 0; // Monto que tiene la promoción
            let points_value = this.points_value || 0.1; // Valor de puntos por unidad monetaria

            // Calcula puntos solo si hay un monto de venta
            if (saleTotal > 0) {
                // Si hay monto de promoción, usa ese para calcular puntos
                if (promotionTotal > 0) {
                    this.ventalista = parseFloat(
                        (saleTotal / promotionTotal).toFixed(2)
                    );
                } else {
                    // Si no hay monto de promoción, usa el cálculo estándar
                    this.ventalista = parseFloat(
                        (saleTotal * points_value).toFixed(2)
                    );
                }
            } else {
                this.ventalista = 0;
            }
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
            if (this.form.items) {
                for (let index = 0; index < this.form.items.length; index++) {
                    const item = this.form.items[index];
                    item.discounts = [];

                    item.total_discount = 0;
                    item.total = item.originalTotal || item.total;
                    item.total_value =
                        item.originalTotalValue || item.total_value;
                }
            }
            this.form.total_discount = 0;
            this.form.discounts = [];
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

            // Redondear a 2 decimales para evitar números extraños
            this.form.difference = Number(differen.toFixed(2));

            if (this.form.difference < 0) {
                this.button_payment = true;
                this.form.difference = Number(differen.toFixed(2));
            } else if (this.form.difference >= 0) {
                this.button_payment = false;
                // parseFloat(this.form.enter_amount) - parseFloat(this.form.total);
            } else {
                this.button_payment = true;
            }

            if (this.configuration.sale_note_credit_cash) {
                this.button_payment = false;
            }

            this.$eventHub.$emit("eventSetFormPosLocalStorage", this.form);
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
            let pass = true;
            if (
                (this.hasExceedBank && this.form.observation == null) ||
                (this.form.observation == "" &&
                    this.hasExceedBank &&
                    this.form.reference_number &&
                    this.form.bank_account_id)
            ) {
                try {
                    const result = await Swal.fire({
                        title: "Advertencia",
                        /* text: '¿Desea continuar sin registrar la bancarización?', */
                        html: `
                        <div class="text-danger">
                            Recuerde que debido al monto deberá hacer
                            esta operación mediante Bancarización.
                            Ingrese en el campo "Observaciones" el
                            número de voucher o número de operación.
                        </div>
                        <p class="fw-bold">
                            ¿Desea continuar sin registrar la bancarización?
                        </p>
                        `,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sí",
                        cancelButtonText: "No",
                        reverseButtons: true
                    });

                    if (!result.isConfirmed) {
                        /* this.loading = false;
                        this.loading_submit = false;
                        this.button_payment = false; */
                        return;
                    }
                } catch (e) {
                    pass = false;
                }
            }
            if (!pass) {
                /* this.loading = false;
                this.loading_submit = false;
                this.button_payment = false; */
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
                    this.$emit("update:variation", false);
                    await this.clickPayment(formVariation);
                    // this.$emit("clearVariation");
                } else {
                    this.$toast.error("Sin serie en nota de venta");
                }
            } else {
                console.log("no envio variation");
            }
        },
        unlockButton() {
            this.isLocked = false;
        },
        async clickPrintPos(printerName, formatoPdf, userId = null) {
            try {
                let config = qz.configs.create(
                    printerName,
                    {
                        legacy: true
                    },
                    {
                        scaleContent: false
                    }
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
                    f =>
                        f.identity_document_type_id == "6" &&
                        f.number != "99999999" &&
                        f.number != "88888888"
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

                this.form.customer_id = this.customer_default.id;
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

            if (this.form.hotel_customer_number) {
                await this.searchClientOne(this.form.hotel_customer_number);
                //                    this.changeCustomer();
            }
            if (this.form.quotation_customer_number) {
                await this.searchClientOne(this.form.quotation_customer_number);
            }

            this.changeCustomer();
            if (this.form.document_type_id == "80") {
                this.discount_amount = 0;
                this.inputDiscountAmount();
            }
        },
        clearPromotionPointsItem() {
            this.form.items = this.form.items.filter(i => !i.is_promotion);
            this.reCalculateTotal();
        },
        //aqui modifique para que pueda recibir los item filtrado
        async promotionPointsItem() {
            let item = this.listPromotionItems.find(
                i => i.id == this.form.item_promotion_id
            );
            /* console.log("ver como esta llegando el item:", item); */

            if (!item || item.quantity <= 0) {
                /* console.warn("No hay cantidad válida para este ítem."); */
                return;
            }

            if (!this.form.item_promotion_id) {
                this.clearPromotionPointsItem();
                this.form.receive_promotion = false;
                return;
            }

            if (item) {
                if (item.quantity > 0) {
                    /* this.addFreeItem(item.item, item.quantity); */
                    //aqui se mofico para que se agrege la cantidad seleccionado del modal box
                    this.addFreeItem({ ...item.item, quantity: item.quantity });
                    console.log("Quantity from modal:", item.quantity);
                    this.form.receive_promotion = true;
                } else {
                    this.form.receive_promotion = false;
                }
            }
        },
        async fetchPromotionItems() {
            if (!this.form.customer_id) {
                this.$toast.error("El cliente es requerido");
                return;
            }

            const loading = this.$loading({
                lock: true,
                text: "Cargando..."
            });
            try {
                const response = await this.$http.get(
                    `/promotion-document/items-by-person/${this.form.customer_id}`
                );
                //
                if (response.data) {
                    let items = response.data;
                    items = items.reduce((a, b) => a.concat(b), []);
                    this.promotionItems = items;
                    this.promotionItems.forEach(item => {
                        this.addFreeItem(item);
                    });
                } else {
                    this.$toast.error("No se encontraron items de promoción");
                }
            } catch (error) {
                this.$toast.error("Ocurrió un error");
            } finally {
                this.showDialogPromotionBox = false;
                loading.close();
            }
        }
    }
};
</script>

<style>
.input-container2 {
    width: 100px;
    /* Ancho del botón */
    height: 50px;
    /* Alto del botón */
    border-radius: 8px;
    /* Bordes redondeados */
    overflow: hidden;
    /* Asegura que la imagen no sobresalga */
    cursor: pointer;
    /* Muestra el cursor interactivo */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    /* Transiciones suaves */
}

.input-container2:hover {
    transform: scale(1.05);
    /* Agranda ligeramente el botón al pasar el cursor */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    /* Sombra más pronunciada */
}

.radio-tile2 {
    background-size: 80% 80%;
    background-position: center;
    background-repeat: no-repeat;
    width: 80%;
    height: 80%;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10), 0 1.5px 3px rgba(0, 0, 0, 0.07);
    transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
}

.input-container2:has(.radio-button2:checked) .radio-tile2,
.input-container2.active .radio-tile2 {
    border: 2px solid #1976d2;
    box-shadow: 0 4px 16px rgba(25, 118, 210, 0.15);
    transform: scale(1.04);
}

.input-container2:hover .radio-tile2 {
    border: 2px solid #90caf9;
    box-shadow: 0 6px 18px rgba(25, 118, 210, 0.18);
    transform: scale(1.03);
}

.radio-tile-label2 {
    display: none;
    /* Oculta el label por defecto */
}

.tile-unselected {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.radio-tile2 {
    opacity: 1;
    transition: opacity 0.2s;
}


.container-fluid {
    width: 100%;
    /* Ocupa el ancho completo */
    padding-right: 0px;
    /* Padding interno para mantener contenido alineado */
    padding-left: 0px;
    /* Padding interno */
    margin-right: auto;
    /* Centra el contenedor en dispositivos grandes */
    margin-left: auto;
    /* Centra el contenedor en dispositivos grandes */
}

.no-padding {
    padding: 0 !important;
}

/* Para el icono de los botones */
.custom-radio-button i {
    color: inherit !important;
    /* Asegura que el icono también herede el color */
}

.custom-select {
    width: 70% !important;
    /* Agregamos !important para asegurar que no se sobreescriba */
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

/* Estilo por defecto para pantallas grandes (muestra el texto y el ícono) */
.radio-buttons-group .el-radio-button {
    padding: 5px 15px;
    /* Ajusta el espacio entre íconos y texto */
    display: flex;
    align-items: center;
}

/* Oculta el texto en pantallas pequeñas, solo muestra los íconos */
.radio-buttons-group .el-radio-button .radio-button-text {
    margin-left: 10px;
    /* Espacio entre el ícono y el texto */
}

/* Media query para pantallas de tamaño 1280x768px */
@media (max-width: 1280px) and (max-height: 768px) {
    /* Ajuste en los botones para pantallas pequeñas */
    .radio-buttons-group .el-radio-button {
        padding: 5px;
        /* Reduce el padding en pantallas pequeñas */
    }

    .radio-buttons-group .el-radio-button .radio-button-text {
        display: none;
        /* Oculta el texto */
    }

    .radio-buttons-group .el-radio-button i {
        font-size: 20px;
        /* Ajusta el tamaño del ícono */
    }

    .radio-buttons-group .el-radio-button {
        width: 40px;
        /* Ajusta el tamaño del botón */
        height: 40px;
        /* Ajusta el tamaño del botón */
    }
}

/* Media query para pantallas muy pequeñas (como móviles) */
@media (max-width: 576px) {
    /* Ajuste aún más pequeño en los íconos y botones */
    .radio-buttons-group .el-radio-button i {
        font-size: 18px;
        /* Tamaño de ícono más pequeño */
    }

    .radio-buttons-group .el-radio-button {
        width: 35px;
        /* Ajusta el tamaño aún más pequeño */
        height: 35px;
    }
}

.responsive-btn {
    transition: all 0.2s;
}

@media (max-width: 1280px) {
    .responsive-btn {
        font-size: 12px !important;
        padding: 4px 8px !important;
        width: 90px !important;
        height: 36px !important;
    }
}

.blinking {
    animation: blinkingText 1.2s infinite;
}

@keyframes blinkingText {
    0% {
        opacity: 1;
    }

    80% {
        opacity: 1;
    }

    90% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

/* Tamaño personalizado para los botones de medios de pago */
.payment-btn-size {
    width: 80px;
    height: 80px;
    min-width: 80px;
    min-height: 80px;
    background-position: center;
}

.payment-btn-size.active {
    background-color: #073f68 !important;
    /* Si el botón tiene imagen, puedes agregar un overlay si lo deseas */
    /* box-shadow: 0 0 0 2px #073f68; */
}
</style>
