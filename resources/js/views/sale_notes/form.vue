<template>
    <div
        class="card mb-0"
        v-loading="loader"
        :element-loading-text="text_loader"
    >
        <div class="card-header bg-primary">
            <h6 class="my-0 text-white">Nota de Venta</h6>
        </div>

        <div class="tab-content ">
            <div class="invoice" v-if="company != null">
                <header class="clearfix">
                    <div class="row">
                        <div class="col-sm-2 text-center mt-3 mb-0">
                            <logo
                                url="/"
                                :path_logo="
                                    company.logo != null
                                        ? `/storage/uploads/logos/${company.logo}`
                                        : ''
                                "
                            ></logo>
                        </div>
                        <div class="col-sm-7 text-left mt-3 mb-0">
                            <address class="ib mr-2">
                                <span class="font-weight-bold d-block"
                                    >NOTA DE VENTA</span
                                >
                                <span class="font-weight-bold">{{
                                    company.name
                                }}</span>
                                <br />
                                <div v-if="establishment.address != '-'">
                                    {{ establishment.address }},
                                </div>
                                {{ establishment.district.description }},
                                {{ establishment.province.description }},
                                {{ establishment.department.description }} -
                                {{ establishment.country.description }}
                                {{ establishment.email }} -
                                <span v-if="establishment.telephone != '-'">{{
                                    establishment.telephone
                                }}</span>
                            </address>
                        </div>
                    </div>
                </header>
                <form autocomplete="off" @submit.prevent="submit">
                    <div class="form-body">
                        <div class="row mt-1">
                            <div class="col-md-12">
                                <el-card class="box-card">
                                    <div slot="header" class="clearfix">
                                        <span
                                            ><i class="el-icon-document"></i>
                                            Información de Facturación</span
                                        >
                                    </div>
                                    <div class="text item">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label"
                                                        >Vendedor</label
                                                    >
                                                    <el-select
                                                        v-model="form.user_id"
                                                        filterable
                                                        @change="
                                                            filterCustomersUser()
                                                        "
                                                    >
                                                        <el-option
                                                            v-for="option in array_users"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="option.name"
                                                        ></el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 pb-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.customer_id
                                                    }"
                                                >
                                                    <label
                                                        class="control-label font-weight-bold text-primary"
                                                    >
                                                        Cliente
                                                        <a
                                                            href="#"
                                                            @click.prevent="
                                                                showDialogNewPerson = true
                                                            "
                                                            >[+ Nuevo]</a
                                                        >
                                                    </label>
                                                    <el-select
                                                        v-model="
                                                            form.customer_id
                                                        "
                                                        filterable
                                                        remote
                                                        class="border-left rounded-left border-info"
                                                        popper-class="el-select-customers"
                                                        dusk="customer_id"
                                                        placeholder="Escriba el nombre o número de documento del cliente"
                                                        :remote-method="
                                                            searchRemoteCustomers
                                                        "
                                                        :loading="
                                                            loading_search
                                                        "
                                                    >
                                                        <el-option
                                                            v-for="option in customers"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="
                                                                option.description
                                                            "
                                                        ></el-option>
                                                    </el-select>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.customer_id
                                                        "
                                                        v-text="
                                                            errors
                                                                .customer_id[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.establishment_id
                                                    }"
                                                >
                                                    <label class="control-label"
                                                        >Establecimiento</label
                                                    >
                                                    <el-select
                                                        v-model="
                                                            form.establishment_id
                                                        "
                                                        @change="
                                                            changeEstablishment
                                                        "
                                                    >
                                                        <el-option
                                                            v-for="option in establishments"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="
                                                                option.description
                                                            "
                                                        ></el-option>
                                                    </el-select>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.establishment_id
                                                        "
                                                        v-text="
                                                            errors
                                                                .establishment_id[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.series_id
                                                    }"
                                                >
                                                    <label class="control-label"
                                                        >Serie</label
                                                    >
                                                    <el-select
                                                        v-model="form.series_id"
                                                    >
                                                        <el-option
                                                            v-for="option in series"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="
                                                                option.number
                                                            "
                                                        ></el-option>
                                                    </el-select>
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.series_id"
                                                        v-text="
                                                            errors.series_id[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.currency_type_id
                                                    }"
                                                >
                                                    <label class="control-label"
                                                        >Moneda</label
                                                    >
                                                    <el-select
                                                        v-model="
                                                            form.currency_type_id
                                                        "
                                                        @change="
                                                            changeCurrencyType
                                                        "
                                                    >
                                                        <el-option
                                                            v-for="option in currency_types"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="
                                                                option.description
                                                            "
                                                        ></el-option>
                                                    </el-select>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.currency_type_id
                                                        "
                                                        v-text="
                                                            errors
                                                                .currency_type_id[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <table>
                                                    <thead>
                                                        <tr width="100%">
                                                            <th
                                                                v-if="
                                                                    form
                                                                        .payments
                                                                        .length >
                                                                        0
                                                                "
                                                            >
                                                                Método de pago
                                                            </th>
                                                            <th
                                                                v-if="
                                                                    form
                                                                        .payments
                                                                        .length >
                                                                        0
                                                                "
                                                            >
                                                                Destino
                                                            </th>
                                                            <th
                                                                v-if="
                                                                    form
                                                                        .payments
                                                                        .length >
                                                                        0
                                                                "
                                                            >
                                                                Referencia
                                                            </th>
                                                            <th
                                                                v-if="
                                                                    form
                                                                        .payments
                                                                        .length >
                                                                        0
                                                                "
                                                            >
                                                                Monto
                                                            </th>
                                                            <th width="15%">
                                                                <a
                                                                    href="#"
                                                                    @click.prevent="
                                                                        clickAddPayment
                                                                    "
                                                                    class="text-center font-weight-bold text-info"
                                                                    >[+
                                                                    Agregar]</a
                                                                >
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(row,
                                                            index) in form.payments"
                                                            :key="index"
                                                        >
                                                            <td>
                                                                <div
                                                                    class="form-group mb-2 mr-1"
                                                                >
                                                                    <el-select
                                                                        v-model="
                                                                            row.payment_method_type_id
                                                                        "
                                                                        @change="
                                                                            monto_efectivo()
                                                                        "
                                                                    >
                                                                        <el-option
                                                                            v-for="option in payment_method_types"
                                                                            :key="
                                                                                option.id
                                                                            "
                                                                            :value="
                                                                                option.id
                                                                            "
                                                                            :label="
                                                                                option.description
                                                                            "
                                                                        ></el-option>
                                                                    </el-select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-2 mr-1"
                                                                >
                                                                    <el-select
                                                                        v-model="
                                                                            row.payment_destination_id
                                                                        "
                                                                        filterable
                                                                    >
                                                                        <el-option
                                                                            v-for="option in payment_destinations"
                                                                            :key="
                                                                                option.id
                                                                            "
                                                                            :value="
                                                                                option.id
                                                                            "
                                                                            :label="
                                                                                option.description
                                                                            "
                                                                        ></el-option>
                                                                    </el-select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-2 mr-1"
                                                                >
                                                                    <el-input
                                                                        v-model="
                                                                            row.reference
                                                                        "
                                                                    >
                                                                        <i
                                                                            slot="prefix"
                                                                            class="el-icon-edit-outline"
                                                                        ></i
                                                                    ></el-input>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="form-group mb-2 mr-1"
                                                                >
                                                                    <el-input
                                                                        v-model="
                                                                            row.payment
                                                                        "
                                                                    >
                                                                        <i
                                                                            slot="prefix"
                                                                            class="el-icon-edit-outline"
                                                                        ></i
                                                                    ></el-input>
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="series-table-actions text-center"
                                                            >
                                                                <!-- <button  type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickCancel(index)">
                                                                <i class="fa fa-trash"></i>
                                                            </button> -->
                                                            </td>
                                                            <br />
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        Tipo periodo
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Creación recurrente de N. Venta de forma automática, por periodo."
                                                            placement="top-start"
                                                        >
                                                            <i
                                                                class="fa fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select
                                                        v-model="
                                                            form.type_period
                                                        "
                                                        clearable
                                                    >
                                                        <el-option
                                                            v-for="option in type_periods"
                                                            :key="option.id"
                                                            :value="option.id"
                                                            :label="
                                                                option.description
                                                            "
                                                        ></el-option>
                                                    </el-select>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.type_period
                                                        "
                                                        v-text="
                                                            errors
                                                                .type_period[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label"
                                                        >N° Periodos</label
                                                    >
                                                    <el-input-number
                                                        v-model="
                                                            form.quantity_period
                                                        "
                                                        :min="0"
                                                    ></el-input-number>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.date_of_issue
                                                    }"
                                                >
                                                    <!--<label class="control-label">Fecha de emisión</label>-->
                                                    <label class="control-label"
                                                        >Fec. Emisión</label
                                                    >
                                                    <el-date-picker
                                                        v-model="
                                                            form.date_of_issue
                                                        "
                                                        type="date"
                                                        value-format="yyyy-MM-dd"
                                                        :clearable="false"
                                                        @change="
                                                            changeDateOfIssue
                                                        "
                                                    ></el-date-picker>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.date_of_issue
                                                        "
                                                        v-text="
                                                            errors
                                                                .date_of_issue[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.exchange_rate_sale
                                                    }"
                                                >
                                                    <label class="control-label"
                                                        >Tipo de cambio
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Tipo de cambio del día, extraído de SUNAT"
                                                            placement="top-end"
                                                        >
                                                            <i
                                                                class="fa fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-input
                                                        v-model="
                                                            form.exchange_rate_sale
                                                        "
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-icon-edit-outline"
                                                        ></i
                                                    ></el-input>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.exchange_rate_sale
                                                        "
                                                        v-text="
                                                            errors
                                                                .exchange_rate_sale[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg-2  col-md-2"
                                                v-if="
                                                    configuration.show_restriction ==
                                                        true
                                                "
                                            >
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.payment_condition_id
                                                    }"
                                                >
                                                    <label
                                                        class="control-label w-100"
                                                        >Restringir Stock</label
                                                    >
                                                    <el-switch
                                                        v-model="
                                                            form_control.stock_control
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="update_stock()"
                                                    ></el-switch>
                                                    <small
                                                        class="form-control-feedback"
                                                        v-if="
                                                            errors.stock_control
                                                        "
                                                        v-text="
                                                            errors
                                                                .stock_control[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label"
                                                        >Descuentos</label
                                                    >
                                                    <el-switch
                                                        @change="
                                                            changeEnabledDiscount
                                                        "
                                                        v-model="
                                                            enabled_discount
                                                        "
                                                        class="control-label font-weight-semibold m-0 text-center m-b-0"
                                                        active-text="descuento Global"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-card>
                            </div>
                            <div
                                class="col-md-12 mt-2"
                                v-if="configuration.credits == true"
                            >
                                <el-card class="box-card  pb-1">
                                    <div slot="header" class="clearfix">
                                        <span
                                            ><i class="el-icon-date"></i>
                                            Cronograma de Pago</span
                                        >
                                    </div>
                                    <div class="text item">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label
                                                    class="control-label w-100"
                                                    :class="{
                                                        'text-danger':
                                                            errors.amount
                                                    }"
                                                    >Generar Cronograma
                                                    <span class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <el-switch
                                                    active-text="Si"
                                                    v-model="form.generate"
                                                    inactive-text="No"
                                                    @change="disable_month()"
                                                ></el-switch>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.amount"
                                                    v-text="errors.amount[0]"
                                                ></small>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        :class="{
                                                            'text-danger':
                                                                errors.month
                                                        }"
                                                        >Tiempo (Mes)</label
                                                    >
                                                    <el-input-number
                                                        v-model="form.month"
                                                        :disabled="
                                                            disabled_month
                                                        "
                                                        :controls="false"
                                                        @change="Calculate()"
                                                        :min="0"
                                                        :max="60"
                                                    ></el-input-number>
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.month"
                                                        v-text="errors.month[0]"
                                                    ></small>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label
                                                    class="control-label w-100"
                                                    :class="{
                                                        'text-danger':
                                                            errors.seller_id
                                                    }"
                                                    >Cronograma de Pago
                                                    <span class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <el-radio-group
                                                    v-model="form.type_payment"
                                                    size="medium"
                                                    @change="Calculate()"
                                                >
                                                    <el-radio-button
                                                        label="Diario"
                                                    ></el-radio-button>
                                                    <el-radio-button
                                                        label="Semanal"
                                                    ></el-radio-button>
                                                    <el-radio-button
                                                        label="Mensual"
                                                    ></el-radio-button>
                                                </el-radio-group>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.type_payment"
                                                    v-text="
                                                        errors.type_payment[0]
                                                    "
                                                ></small>
                                            </div>
                                            <div class="col-md-2">
                                                <label
                                                    class="control-label w-100"
                                                    :class="{
                                                        'text-danger':
                                                            errors.num_cuota
                                                    }"
                                                    >Nº Cuota
                                                    <span class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <b>{{ form.num_cuota }} </b>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.num_cuota"
                                                    v-text="errors.num_cuota[0]"
                                                ></small>
                                            </div>
                                            <div class="col-md-2">
                                                <label
                                                    class="control-label w-100"
                                                    >Tasa %<span
                                                        class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <el-input-number
                                                    v-model="tasaInteres"
                                                    :controls="false"
                                                    @change="Calculate()"
                                                ></el-input-number>
                                            </div>
                                            <div class="col-md-2">
                                                <label
                                                    class="control-label w-100"
                                                    :class="{
                                                        'text-danger':
                                                            errors.amount
                                                    }"
                                                    >Cuota
                                                    <span class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <b>{{ form.amount }}</b>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.amount"
                                                    v-text="errors.amount[0]"
                                                ></small>
                                            </div>
                                            <div class="col-md-2">
                                                <label
                                                    class="control-label w-100"
                                                    :class="{
                                                        'text-danger':
                                                            errors.advances
                                                    }"
                                                    >Adelanto
                                                    <span class="text-danger"
                                                        >*</span
                                                    ></label
                                                >
                                                <el-input-number
                                                    v-model="form.advances"
                                                    controls-position="right"
                                                    @blur="advances_total()"
                                                ></el-input-number>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.advances"
                                                    v-text="errors.advances[0]"
                                                ></small>
                                            </div>
                                        </div>
                                    </div>
                                </el-card>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label class="control-label"
                                        >Observacion</label
                                    >
                                    <el-input
                                        type="textarea"
                                        v-model="form.additional_information"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="40px">#</th>
                                                <th
                                                    class="text-center font-weight-bold"
                                                >
                                                    Afectar Stock
                                                </th>
                                                <th class="font-weight-bold">
                                                    Descripción
                                                </th>
                                                <th
                                                    class="text-center font-weight-bold"
                                                >
                                                    Unidad
                                                </th>
                                                <th
                                                    class="text-end font-weight-bold"
                                                >
                                                    Cantidad
                                                </th>
                                                <th
                                                    class="text-end font-weight-bold"
                                                >
                                                    Precio Unitario
                                                </th>
                                                <th
                                                    class="text-end font-weight-bold"
                                                >
                                                    Subtotal
                                                </th>
                                                <!--<th class="text-end font-weight-bold">Cargo</th>-->
                                                <th
                                                    class="text-end font-weight-bold"
                                                >
                                                    Total
                                                </th>
                                                <th
                                                    class="text-end font-weight-bold"
                                                >
                                                    <button
                                                        type="button"
                                                        class="btn waves-effect waves-light btn-primary btn-sm"
                                                        @click.prevent="
                                                            clickAddItemInvoice()
                                                        "
                                                    >
                                                        + Agregar Producto
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="form.items.length > 0">
                                            <tr
                                                v-for="(row,
                                                index) in form.items"
                                                :key="index"
                                            >
                                                <td>{{ index + 1 }}</td>
                                                <th
                                                    class="text-center font-weight-bold"
                                                >
                                                    {{ row.item.is_stock }}
                                                </th>
                                                <td>
                                                    {{ row.item.description }}
                                                    <template
                                                        v-if="
                                                            row.item
                                                                .presentation
                                                        "
                                                        >{{
                                                            row.item.presentation.hasOwnProperty(
                                                                "description"
                                                            )
                                                                ? row.item
                                                                      .presentation
                                                                      .description
                                                                : ""
                                                        }} </template
                                                    ><br />
                                                    <small>
                                                        {{
                                                            row
                                                                .affectation_igv_type
                                                                .description
                                                        }}
                                                    </small>
                                                </td>
                                                <td class="text-center">
                                                    {{ row.item.unit_type_id }}
                                                </td>
                                                <td
                                                    class="text-end"
                                                    width="90px"
                                                >
                                                    {{ row.quantity }}
                                                </td>
                                                <td class="text-end">
                                                    {{
                                                        row.unit_price.toFixed(
                                                            2
                                                        )
                                                    }}
                                                </td>

                                                <td class="text-end">
                                                    {{ currency_type.symbol }}
                                                    {{ row.total_value }}
                                                </td>
                                                <!--<td class="text-end">{{ currency_type.symbol }} {{ row.total_charge }}</td>-->
                                                <td class="text-end">
                                                    {{ currency_type.symbol }}
                                                    {{ row.total }}
                                                </td>
                                                <td class="text-end">
                                                    <template v-if="row.id">
                                                        <button
                                                            type="button"
                                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                                            @click.prevent="
                                                                clickDeleteSNItem(
                                                                    row.id,
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            x
                                                        </button>
                                                    </template>
                                                    <template v-else>
                                                        <button
                                                            type="button"
                                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                                            @click.prevent="
                                                                clickRemoveItem(
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            x
                                                        </button>
                                                    </template>

                                                    <button
                                                        type="button"
                                                        class="btn waves-effect waves-light btn-sm btn-info"
                                                        @click="
                                                            ediItem(
                                                                row,
                                                                index,
                                                                row.id
                                                            )
                                                        "
                                                    >
                                                        <span
                                                            style="font-size:10px;"
                                                            >&#9998;</span
                                                        >
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div
                                class="col-md-12"
                                style="display: flex; flex-direction: column; align-items: flex-end;"
                            >
                                <p
                                    class="text-end"
                                    v-if="form.total_exportation > 0"
                                >
                                    OP.EXPORTACIÓN: {{ currency_type.symbol }}
                                    {{ form.total_exportation }}
                                </p>
                                <p class="text-end" v-if="form.total_free > 0">
                                    OP.GRATUITAS: {{ currency_type.symbol }}
                                    {{ form.total_free }}
                                </p>
                                <p
                                    class="text-end"
                                    v-if="form.total_unaffected > 0"
                                >
                                    OP.INAFECTAS: {{ currency_type.symbol }}
                                    {{ form.total_unaffected }}
                                </p>
                                <p
                                    class="text-end"
                                    v-if="form.total_exonerated > 0"
                                >
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
                                <p class="text-end" v-if="enabled_discount">
                                    Descuentos Global:

                                    <el-input-number
                                        v-model="discount_amount"
                                        :precision="2"
                                        :controls="false"
                                        size="mini"
                                        @input="inputDiscountAmount()"
                                        :disabled="!enabled_discount"
                                        class="col-md-6"
                                    >
                                        <template slot="prepend">{{
                                            currency_type.symbol
                                        }}</template>
                                    </el-input-number>
                                </p>

                                <template v-if="form.total > 0">
                                    <p class="text-end" v-if="form.total > 0">
                                        <b>TOTAL VENTA: </b
                                        >{{ currency_type.symbol }}
                                        {{ form.total }}
                                    </p>
                                </template>
                                <p class="text-end" v-if="form.advances > 0">
                                    ADELANTOS : {{ currency_type.symbol }}
                                    {{ form.advances }}
                                </p>

                                <template v-if="form.total > 0">
                                    <p class="text-end" v-if="form.total > 0">
                                        <b>REDONDEO: </b
                                        >{{ currency_type.symbol }}
                                        {{ form.total_rounded }}
                                    </p>
                                </template>

                                <template v-if="form.total > 0">
                                    <h6 class="text-end" v-if="form.total > 0">
                                        <b>TOTAL A PAGAR: </b
                                        >{{ currency_type.symbol
                                        }}{{
                                            (
                                                form.total_payment -
                                                form.advances
                                            ).toFixed(2)
                                        }}
                                    </h6>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-end pt-2 pb-2">
                        <el-button @click.prevent="close()">Cancelar</el-button>
                        <el-button
                            class="submit"
                            type="primary"
                            native-type="submit"
                            :loading="loading_submit"
                            v-if="
                                form.items.length > 0 ||
                                    form.advances < form.total
                            "
                            >Generar</el-button
                        >
                    </div>
                </form>
            </div>
        </div>

        <sale-notes-form-item
            :showDialog.sync="showDialogAddItem"
            :recordItem="recordItem"
            :restringir_stock="restringir_stock"
            :idDetalle="idDetalle"
            :isEditItemNote="false"
            :operation-type-id="form.operation_type_id"
            :currency-type-id-active="form.currency_type_id"
            :exchange-rate-sale="form.exchange_rate_sale"
            :typeUser="typeUser"
            :configuration="configuration"
            :editNameProduct="configuration.edit_name_product"
            :percentage_igv="percentage_igv"
            @add="addRow"
        ></sale-notes-form-item>

        <person-form
            :showDialog.sync="showDialogNewPerson"
            type="customers"
            :user_id="form.user_id"
            :external="true"
            :document_type_id="form.document_type_id"
        ></person-form>

        <sale-notes-options
            :showDialog.sync="showDialogOptions"
            :editSale="editSale"
            :configuration="configuration"
            :showSchedule.sync="showSchedule"
            :recordId="saleNotesNewId"
            :showClose.sync="showClose"
        ></sale-notes-options>
    </div>
</template>
<style>
/* .el-card__header {
    padding: 10px !important;
    border-bottom: 1px solid #ebeef5  !important;
    -webkit-box-sizing: border-box  !important;
    box-sizing: border-box !important;
} */
</style>
<script>
import SaleNotesFormItem from "./partials/item.vue";
import PersonForm from "../persons/form.vue";
import SaleNotesOptions from "./partials/options.vue";
import { functions, exchangeRate } from "../../mixins/functions";
import { calculateRowItem } from "../../helpers/functions";
import Logo from "../companies/logo.vue";
export default {
    props: ["id", "typeUser", "configuration"],
    components: { SaleNotesFormItem, PersonForm, SaleNotesOptions, Logo },
    mixins: [functions, exchangeRate],
    data() {
        return {
            resource: "sale-notes",
            showDialogAddItem: false,
            showDialogNewPerson: false,
            showDialogOptions: false,
            loading_submit: false,
            loading_form: false,
            recordItem: null,
            idDetalle: null,
            showSchedule: false,
            errors: {},
            percentage_igv: null,
            form: {},
            currency_types: [],
            discount_types: [],
            charges_types: [],
            all_customers: [],
            array_users: [],
            customers: [],
            company: null,
            establishments: [],
            establishment: null,
            currency_type: {},
            saleNotesNewId: null,
            form_payment: {},
            payment_method_types: [],
            activePanel: 0,

            loading_search: false,
            type_periods: [],
            series: [],
            all_series: [],
            is_contingency: false,
            payment_destinations: [],
            validarForm: false,
            enabled_discount: false,
            discount_amount: 0.0,
            showClose: false,
            restringir_stock: false,
            loader: false,
            text_loader: "Espere porfavor....",
            form_control: {},
            editSale: false,
            tasa_interes: 0,
            tasaInteres: 0,
            disabled_month: true
        };
    },
    async created() {
        await this.initForm();
        await this.getTables();
        this.loading_form = true;
        this.$eventHub.$on("reloadDataPersons", customer_id => {
            this.reloadDataCustomers(customer_id);
        });

        await this.isUpdate(this.form.user_id);
        this.loader = false;
        this.form_control = {
            id: null,
            stock_control: false
        };
        await this.$http
            .get(`/inventories/configuration/record`)
            .then(response => {
                // if (response.data !== '')
                this.form_control = response.data.data;
                this.restringir_stock = response.data.data.stock_control;
            });
        await this.calculateTotal();
    },
    methods: {
        update_stock() {
            this.$http
                .post(`/inventories/configuration`, this.form_control)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.restringir_stock = this.form_control.stock_control;
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
                    this.loading_submit = false;
                });
        },
        advances_total() {
            if (this.form.advances > this.form.total) {
                return this.$toast.error(
                    "el monto de adelanto no puede ser mayor ala venta total"
                );
            } else {
                this.form.total_balance = (
                    this.form.total - this.form.advances
                ).toFixed(2);
                this.Calculate(this.form.advances);
            }
        },
        disable_month() {
            if (this.form.generate == true) {
                this.disabled_month = false;
            } else {
                this.disabled_month = true;
            }
        },
        async getTables() {
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                this.currency_types = response.data.currency_types;
                this.establishments = response.data.establishments;
                this.all_customers = response.data.customers;
                this.discount_types = response.data.discount_types;
                this.charges_types = response.data.charges_types;
                this.payment_method_types = response.data.payment_method_types;
                //     this.configuration= response.data.configuration
                this.company = response.data.company;
                this.array_users = response.data.users;
                this.form.currency_type_id =
                    this.currency_types.length > 0
                        ? this.currency_types[0].id
                        : null;
                this.form.establishment_id =
                    this.establishments.length > 0
                        ? this.establishments[0].id
                        : null;
                this.type_periods = [
                    { id: "month", description: "Mensual" },
                    { id: "year", description: "Anual" }
                ];
                this.all_series = response.data.series;
                this.payment_destinations = response.data.payment_destinations;
                this.form.user_id = response.data.user_select.id;
                this.tasa_interes = response.data.tasa_interes;
                this.form.tasadefault = response.data.tasa_interes;
                this.tasaInteres = this.tasa_interes;
                this.restringir_stock = response.data.restringir_stock;
                this.changeEstablishment();
                this.changeDateOfIssue();
                this.changeCurrencyType();
                this.allCustomers();
            });
            let form_data = {
                establishment_id: this.form.establishment_id,
                date: moment().format("YYYY-MM-DD")
            };
            const response = await this.$http.post("/get_igv", form_data);
            this.percentage_igv = response.data;
        },
        Calculate(advance = 0) {
            let dias = 0;
            let tasa_interes = 0;
            if (
                this.form.total > 0 &&
                this.form.month > 0 &&
                this.form.generate == true
            ) {
                switch (this.form.type_payment) {
                    case "Diario":
                        this.form.num_cuota = 26 * parseInt(this.form.month);
                        dias = 26 * this.form.month;
                        break;
                    case "Semanal":
                        this.form.num_cuota = 4 * this.form.month;
                        dias = 7 * this.form.month;
                        break;
                    case "Mensual":
                        this.form.num_cuota = this.form.month;
                        dias = 30 * this.form.month;
                        break;
                }
                if (this.tasa_interes > 0) {
                    let total_financiar =
                        parseFloat(this.form.total) -
                        parseFloat(this.form.advances);
                    tasa_interes = this.tasaInteres * this.form.month;
                    tasa_interes = tasa_interes.toFixed(2);
                    let calcular_cuota =
                        (total_financiar *
                            ((this.tasaInteres * this.form.month) / 100) +
                            total_financiar) /
                        this.form.num_cuota;
                    this.form.amount = calcular_cuota.toFixed(2);
                } else {
                    let amount =
                        parseInt(this.form.total) /
                        parseInt(this.form.num_cuota);
                    this.form.amount = amount.toFixed(2);
                }
            }
            this.form.tasadefault = tasa_interes;
        },
        monto_efectivo() {
            if (
                this.form.payments[0].payment_method_type_id == "02" ||
                this.form.payments[0].payment_method_type_id == "03" ||
                this.form.payments[0].payment_method_type_id == "05" ||
                this.form.payments[0].payment_method_type_id == "07" ||
                this.form.payments[0].payment_method_type_id == "08" ||
                this.form.payments[0].payment_method_type_id == "09"
            ) {
                this.form.payments[0].payment = 0.0;
                //this.form.generate=true
            } else {
                if (!this.form.generate) {
                    this.form.payments[0].payment = this.form.total;
                }
            }
            this.Calculate();
        },
        clickAddItemInvoice: function() {
            this.recordItem = null;
            this.showDialogAddItem = true;
        },
        changeEnabledDiscount() {
            if (!this.enabled_discount) {
                this.discount_amount = 0;
                this.deleteDiscountGlobal();
                this.reCalculateTotal();
            } else {
                this.deleteDiscountGlobal();
                this.reCalculateTotal();
            }
        },
        inputDiscountAmount() {
            if (this.enabled_discount) {
                if (
                    this.discount_amount &&
                    !isNaN(this.discount_amount) &&
                    parseFloat(this.discount_amount) > 0
                ) {
                    //   if(this.discount_amount >= this.form.total)
                    //       return this.$toast.error("El monto de descuento debe ser menor al total de venta")

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

            this.difference = this.enter_amount - this.form.total;
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
            this.form.total_rounded = Math.abs(
                Math.round(parseFloat(this.form.total) * 10) / 10 -
                    this.form.total
            ).toFixed(2);
            this.form.total_payment =
                Math.round(parseFloat(this.form.total) * 10) / 10;
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

        ediItem(row, index, id) {
            this.idDetalle = id;
            row.indexi = index;
            this.recordItem = row;
            this.showDialogAddItem = true;
        },
        teclasInit() {
            document.onkeydown = e => {
                const key = e.key;
                if (key == "F4") {
                    this.$nextTick(() => {
                        let input = this.$refs.cliente;
                        input.focus();
                        return false;
                    });
                }
                if (key == "F5") {
                    //Agregar cliente
                    this.showDialogNewPerson = true;
                    return false;
                }
                if (key == "F6") {
                    //Agregar Producto
                    this.showDialogAddItem = true;
                }
                if (key == "F7" && this.form.items.length > 0) {
                    //Guardar
                    this.submit();
                }
                if (key == "F8") {
                    //Cancelar
                    this.close();
                }
            };
        },
        filterCustomersUser() {
            this.form.customer_id = null;
            let customer_filter = _.filter(this.all_customers, {
                seller_id: this.form.user_id
            });
            this.customers = customer_filter;
        },

        filterSeries() {
            this.form.series_id = null;
            this.series = _.filter(this.all_series, {
                establishment_id: this.form.establishment_id,
                document_type_id: "80",
                contingency: this.is_contingency
            });
            this.form.series_id =
                this.series.length > 0 ? this.series[0].id : null;
        },
        async clickDeleteSNItem(id, index) {
            await this.$http
                .delete(`/${this.resource}/destroy_sale_note_item/${id}`)
                .then(res => {
                    this.clickRemoveItem(index);
                    this.$eventHub.$emit("reloadDataItems", null);
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$toast.error("Error al intentar eliminar");
                    } else {
                        console.log(error.response.data.message);
                    }
                });
            this.recordItem = null;
            await this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.isUpdate(this.form.user_id);
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
                });
            this.Calculate();
        },
        getFormatUnitPriceRow(unit_price) {
            return _.round(unit_price, 6);
            // return unit_price.toFixed(6)
        },
        async isUpdate(user_id) {
            if (this.id) {
                this.showClose = true;
                await this.$http
                    .get(`/${this.resource}/record2/${this.id}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.searchRemoteCustomers(this.form.customer.number);
                        this.form.discounts = [];
                        this.editSale = true;
                        this.form.user_id = user_id;
                    });
            }
        },
        clickAddPayment() {
            if (this.form.payments.length == 0)
                this.form.payments.push({
                    id: null,
                    document_id: null,
                    date_of_payment: moment().format("YYYY-MM-DD"),
                    payment_method_type_id: "01",
                    reference: null,
                    payment_destination_id: "cash",
                    payment: this.form.total
                });
        },
        clickCancel(index) {
            this.form.payments.splice(index, 1);
        },
        searchRemoteCustomers(input) {
            if (input.length > 0) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/${this.resource}/search/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.customers;
                        this.loading_search = false;
                        if (this.customers.length == 0) {
                            this.allCustomers();
                        }
                    });
            } else {
                this.allCustomers();
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                afectar_caja: true,
                restaurant: false,
                series_id: null,
                generate: false,
                prefix: "NV",
                month: 0,
                establishment_id: null,
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                customer_id: null,
                currency_type_id: null,
                purchase_order: null,
                exchange_rate_sale: 0,
                advances: 0,
                total_balance: 0,
                total_advances: 0,
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
                total_rounded: 0,
                total_payment: 0,
                tasadefault: 0,
                operation_type_id: null,
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                additional_information: null,
                actions: {
                    format_pdf: "a4"
                },
                apply_concurrency: false,
                type_period: null,
                quantity_period: 0,
                automatic_date_of_issue: null,
                enabled_concurrency: false,
                license_plate: null,
                paid: false,
                user_id: null,
                observation: null,
                difference: 0,
                type_payment: "Diario",
                num_cuota: 0,
                amount: 0,
                method_pay: "Efectivo"
            };
            //this.form.sss=0
            this.clickAddPayment();
        },
        resetForm() {
            this.activePanel = 0;
            this.initForm();
            this.getTables();
            this.form.currency_type_id =
                this.currency_types.length > 0
                    ? this.currency_types[0].id
                    : null;
            this.form.establishment_id =
                this.establishments.length > 0
                    ? this.establishments[0].id
                    : null;
            this.changeEstablishment();
            this.changeDateOfIssue();
            this.changeCurrencyType();
            this.allCustomers();
        },
        changeEstablishment() {
            this.establishment = _.find(this.establishments, {
                id: this.form.establishment_id
            });
            this.filterSeries();
        },
        cleanCustomer() {
            this.form.customer_id = null;
        },
        changeDateOfIssue() {
            this.searchExchangeRateByDate(this.form.date_of_issue).then(
                response => {
                    this.form.exchange_rate_sale = response;
                }
            );
        },
        assignmentDateOfPayment() {
            this.form.payments.forEach(payment => {
                payment.date_of_payment = this.form.date_of_issue;
            });
        },
        allCustomers() {
            this.customers = this.all_customers;
            this.filterCustomersUser();
        },
        addRow(row) {
            if (this.recordItem) {
                this.form.items[this.recordItem.indexi] = row;
                this.recordItem = null;
            } else {
                this.form.items.push(JSON.parse(JSON.stringify(row)));
            }
            this.calculateTotal();
            this.Calculate();
            if (
                this.form.payments[0].payment_method_type_id == "02" ||
                this.form.payments[0].payment_method_type_id == "03" ||
                this.form.payments[0].payment_method_type_id == "05" ||
                this.form.payments[0].payment_method_type_id == "07" ||
                this.form.payments[0].payment_method_type_id == "08" ||
                this.form.payments[0].payment_method_type_id == "09"
            ) {
                this.form.payments[0].payment = 0.0;
            } else {
                this.form.payments[0].payment = this.form.total;
            }

            if (this.form.generate) {
                this.form.payments[0].payment = 0.0;
            }
        },
        clickRemoveItem(index) {
            this.form.items.splice(index, 1);
            this.calculateTotal();
            this.Calculate();
        },
        changeCurrencyType() {
            this.currency_type = _.find(this.currency_types, {
                id: this.form.currency_type_id
            });
            let items = [];
            this.form.items.forEach(row => {
                items.push(
                    calculateRowItem(
                        row,
                        this.form.currency_type_id,
                        this.form.exchange_rate_sale
                    )
                );
            });
            this.form.items = items;
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
            let total_rounded = 0;
            let total_payment = 0;

            this.form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);
                total_rounded += row.total_rounded;
                total_payment += row.total_payment;

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
            });
            let total_venta = 0;
            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            this.form.total_value = _.round(total_value, 2);
            this.form.total_taxes = _.round(total_igv, 2);
            this.form.total = _.round(total, 2);
            this.form.total_rounded = Math.abs(
                Math.round(parseFloat(total) * 10) / 10 - total
            ).toFixed(2);
            this.form.total_payment = Math.round(parseFloat(total) * 10) / 10;
            this.form_payment.payment = this.form.total;
            this.setTotalDefaultPayment();
        },
        setTotalDefaultPayment() {
            if (
                this.form.payments.length > 0 &&
                this.form.payments[0].payment_method_type_id == "01"
            ) {
                this.form.payments[0].payment = this.form.total;
            } else {
                if (this.form.payments.length > 0) {
                    this.form.payments[0].payment = 0;
                }
            }

            // this.form.total_rounded= Math.abs(Math.round(parseFloat(total_venta)* 10) / 10 -total_venta).toFixed(2)
            // this.form.total_payment=Math.round(parseFloat(total_venta)* 10) / 10
        },
        async print_pdf(PrinterName, FileLink) {
            try {
                let config = qz.configs.create(PrinterName, {
                    scaleContent: false
                });
                if (!qz.websocket.isActive()) {
                    await qz.websocket.connect(config);
                }
                let data = [
                    {
                        type: "pdf",
                        format: "file",
                        data: FileLink
                    }
                ];
                qz.print(config, data).catch(e => {
                    this.$toast.error(e.message);
                });

                this.$toast.success(
                    "se esta imprimiendo el comprobante con exito"
                );
                location.href = `/${this.resource}`;
            } catch (e) {
                this.$toast.error(e.message);
            }
        },

        async submit() {
            if (this.id) {
                this.showClose = true;
            }

            let validate = await this.validate_payments();
            if (
                this.form.generate == true &&
                this.form.payments.length == 0 &&
                this.form.month == 0
            ) {
                return this.$toast.error(
                    "Debe seleccionar el Nº de Mes para generar el cronograma"
                );
                this.validarForm = true;
            } else {
                this.validarForm = false;
            }
            if (this.enabled_discount == false) {
                if (
                    validate.acum_total > parseFloat(this.form.total) ||
                    validate.error_by_item > 0
                ) {
                    return this.$toast.error(
                        "Los montos ingresados superan al monto a pagar o son incorrectos"
                    );
                    this.validarForm = true;
                } else {
                    this.validarForm = false;
                }
            }

            if (this.form.type_period) {
                if (this.form.quantity_period == 0) {
                    return this.$toast.error(
                        "La cantidad de periodos debe ser mayor a 0"
                    );
                }
                this.form.enabled_concurrency =
                    this.form.quantity_period > 0 ? true : false;
            } else {
                this.validarForm = false;
            }
            if (validate.acum_total == parseFloat(this.form.total)) {
                this.form.paid = true;
            }
            if (this.validarForm == false) {
                if (this.form.generate == true) {
                    this.showSchedule = true;
                    this.form.paid = false;
                } else {
                    this.showSchedule = false;
                }
                this.enabled_discount = false;
                this.loading_submit = true;

                let form_efectivo = {
                    enter_amount: 0,
                    difference: 0
                };
                const response_efectivo = await this.$http.post(
                    `/efectivo`,
                    form_efectivo
                );

                if (response_efectivo.data.success == true) {
                    this.$http
                        .post(`/${this.resource}`, this.form)
                        .then(response => {
                            if (response.data.success) {
                                if (
                                    this.configuration.show_restriction == true
                                ) {
                                    this.update_stock();
                                }
                                this.form_payment.sale_note_id =
                                    response.data.data.id;
                                this.isUpdate();
                                this.resetForm();
                                this.saleNotesNewId = response.data.data.id;
                                this.showDialogOptions = true;
                                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                }
            }
        },
        validate_payments() {
            for (let index = 0; index < this.form.payments.length; index++) {
                if (parseFloat(this.form.payments[index].payment) == 0)
                    this.form.payments.splice(index, 1);
            }

            let error_by_item = 0;
            let acum_total = 0;

            this.form.payments.forEach(item => {
                acum_total += parseFloat(item.payment);
                if (item.payment <= 0 || item.payment == null) error_by_item++;
            });

            return {
                error_by_item: error_by_item,
                acum_total: acum_total
            };
        },
        close() {
            this.$confirm("Desea Cancelar?", "Warning", {
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                type: "warning"
            }).then(() => {
                location.href = "/sale-notes";
            });
            //
        },
        reloadDataCustomers(customer_id) {
            this.$http
                .get(`/${this.resource}/search/customer/${customer_id}`)
                .then(response => {
                    this.customers = response.data.customers;
                    this.form.customer_id = customer_id;
                });
        }
    },
    mounted() {
        //   this.teclasInit();
        //   this.loader=true
        //prueba haber
        //nada
    }
};
</script>
