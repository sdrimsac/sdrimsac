<!-- Nuevo y Editar Establecimiento -->
<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="rounded-dialog"
        width="60%" :modal-append-to-body="false" :top="dialogTop">

        <form autocomplete="off" @submit.prevent="submit">
            <div class="row mb-1">
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.description }">
                        <div class="d-flex align-items-center">
                            <label class="control-label mb-0" style="margin-right: 15px;">Establecimiento</label>
                            <el-input ref="inputDescription" v-model="form.description"
                                style="width: 390px;"></el-input>
                        </div>
                        <small class="form-control-feedback" v-if="errors.description"
                            v-text="errors.description[0]"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.code }">
                        <div class="d-flex align-items-center">
                            <label class="control-label mb-0" style="margin-right: 15px;">Código Domicilio
                                Fiscal</label>
                            <el-input v-model="form.code" :maxlength="4" style="width: 120px;">
                            </el-input>

                        </div>
                        <small class="form-control-feedback" v-if="errors.code" v-text="errors.code[0]"></small>
                    </div>
                </div>
            </div>


            <div class="row mb-1">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body" style="padding: 8px;">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="control-label">Logo</label>
                                    <div class="d-flex align-items-center">
                                        <el-input v-model="form.logo" :readonly="true"
                                            placeholder="Nombre del archivo Logo" style="flex: 1; margin-right: 8px;"
                                            clearable>
                                        </el-input>
                                        <el-upload :headers="headers" :data="{
                                            type: 'logo',
                                            id: form.id
                                        }" :action="action" :show-file-list="false" :on-success="successUpload">
                                            <el-tooltip content="Subir Logo" placement="top">
                                                <el-button :disabled="!form.id" type="primary" icon="el-icon-upload"
                                                    size="small" style="border-radius: 20px;">
                                                    Subir
                                                </el-button>
                                            </el-tooltip>
                                        </el-upload>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img
                                        v-if="form.logo && form.logo !== '0'"
                                        class="img-thumbnail"
                                        :src="`/storage/uploads/logos/${form.logo}`"
                                        style="max-height: 100px;"
                                    />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body" style="padding: 8px;">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="control-label">Logo Documento</label>
                                    <div class="d-flex align-items-center">
                                        <el-input v-model="form.document_logo" :readonly="true"
                                            placeholder="Nombre del archivo Logo Documento"
                                            style="flex: 1; margin-right: 8px;" clearable>
                                        </el-input>
                                        <el-upload :headers="headers" :data="{
                                            type: 'document_logo',
                                            id: form.id
                                        }" :action="action" :show-file-list="false" :on-success="successUpload">
                                            <el-tooltip content="Subir Logo Documento" placement="top">
                                                <el-button :disabled="!form.id" type="primary" icon="el-icon-upload"
                                                    size="small" style="border-radius: 20px;">
                                                    Subir
                                                </el-button>
                                            </el-tooltip>
                                        </el-upload>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img class="img-thumbnail" :src="form.document_logo
                                        ? `/storage/uploads/logos/${form.document_logo}`
                                        : ''
                                        " style="max-height: 100px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="padding: 8px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.country_id }">
                                        <label class="control-label">País</label>
                                        <el-select v-model="form.country_id" filterable>
                                            <el-option v-for="option in countries" :key="option.id" :value="option.id"
                                                :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.country_id"
                                            v-text="errors.country_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.department_id }">
                                        <label class="control-label">Departamento</label>
                                        <el-select v-model="form.department_id" filterable @change="filterProvince">
                                            <el-option v-for="option in all_departments" :key="option.id"
                                                :value="option.id" :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.department_id"
                                            v-text="errors.department_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.province_id }">
                                        <label class="control-label">Provincia</label>
                                        <el-select v-model="form.province_id" filterable @change="filterDistrict">
                                            <el-option v-for="option in provinces" :key="option.id" :value="option.id"
                                                :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.province_id"
                                            v-text="errors.province_id[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.district_id }">
                                        <label class="control-label">Distrito</label>
                                        <el-select v-model="form.district_id" filterable>
                                            <el-option v-for="option in districts" :key="option.id" :value="option.id"
                                                :label="option.description"></el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.district_id"
                                            v-text="errors.district_id[0]"></small>
                                    </div>
                                </div>


                                <div class="col-md-6 mt-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.address }">
                                        <div class="d-flex align-items-center">
                                            <label class="control-label mb-0" style="margin-right: 8px;">Dir. Fiscal
                                                :</label>
                                            <el-input ref="address_input" v-model="form.address"
                                                style="flex: 1; width: 390px;"></el-input>
                                        </div>
                                        <small class="form-control-feedback" v-if="errors.address"
                                            v-text="errors.address[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.trade_address }">
                                        <div class="d-flex align-items-center">
                                            <label class="control-label" style="margin-right: 8px;">Dir.
                                                Comercial:</label>
                                            <el-input v-model="form.trade_address" style="flex: 1; width: 350px;">
                                            </el-input>
                                        </div>

                                        <small class="form-control-feedback" v-if="errors.trade_address"
                                            v-text="errors.trade_address[0]"></small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" :class="{ 'has-danger': errors.telephone }">
                                        <label class="control-label">Teléfono</label>
                                        <el-input v-model="form.telephone"> </el-input>
                                        <small class="form-control-feedback" v-if="errors.telephone"
                                            v-text="errors.telephone[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{ 'has-danger': errors.email }">
                                        <label class="control-label">Correo de contacto</label>
                                        <el-input ref="emailInput" v-model="form.email">
                                        </el-input>
                                        <small class="form-control-feedback" v-if="errors.email"
                                            v-text="errors.email[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{ 'has-danger': errors.web_address }">
                                        <label class="control-label">Dirección web</label>
                                        <el-input v-model="form.web_address"> </el-input>
                                        <small class="form-control-feedback" v-if="errors.web_address"
                                            v-text="errors.web_address[0]"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-body" style="padding: 8px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-printer" style="margin-right: 4px;"></i>
                                            Datos de Establecimiento
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="conf.company_address" />
                                    </div>
                                </div>
                                <div class="col-md-3" v-if="configuration.restaurant">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-printer" style="margin-right: 4px;"></i>
                                            Comandas
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="conf.print_command" />
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-discount" style="margin-right: 4px;"></i>
                                            Dto. Caja
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="conf.show_discounts_payment" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-money" style="margin-right: 4px;"></i>
                                            Método Pago
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="conf.show_payment_method" />
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-mobile-phone" style="margin-right: 4px;"></i>
                                            Modo Android
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="form.android_configuration" />
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-coin" style="margin-right: 4px;"></i>
                                            Créditos NV
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="form.credit_warehouse" />
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div style="display: flex; justify-content: center;">
                                        <label class="control-label w-100 mb-1" style="text-align: center;">
                                            <i class="el-icon-coin" style="margin-right: 4px;"></i>
                                            A cuenta Trabajadores
                                        </label>
                                    </div>
                                    <div style="display: flex; justify-content: center;">
                                        <vs-switch color="#073f68" v-model="form.account_workers" />
                                    </div>
                                </div>
                                <div v-if="configuration.health_network" class="col-md-9 mt-3">
                                    <div class="card mb-3">
                                        <div class="card-body" style="padding: 8px;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div style="display: flex; justify-content: center;">
                                                        <label class="control-label w-100 mb-1"
                                                            style="text-align: center;">
                                                            <i class="el-icon-service" style="margin-right: 4px;"></i>
                                                            Servicio
                                                        </label>
                                                    </div>
                                                    <div style="display: flex; justify-content: center;">
                                                        <vs-switch color="#073f68" v-model="form.is_service" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div style="display: flex; justify-content: center;">
                                                        <label class="control-label w-100 mb-1"
                                                            style="text-align: center;">
                                                            <i class="el-icon-goods" style="margin-right: 4px;"></i>
                                                            Producto
                                                        </label>
                                                    </div>
                                                    <div style="display: flex; justify-content: center;">
                                                        <vs-switch color="#073f68" v-model="form.is_product" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div style="display: flex; justify-content: center;">
                                                        <label class="control-label w-100 mb-1"
                                                            style="text-align: center;">
                                                            <i class="el-icon-document" style="margin-right: 4px;"></i>
                                                            Reporte Tabulado
                                                        </label>
                                                    </div>
                                                    <div style="display: flex; justify-content: center;">
                                                        <vs-switch color="#073f68" v-model="form.tab_single" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body" style="padding: 8px;">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.direct_printing }">
                                        <div style="text-align: center;">
                                            <label class="control-label d-block">Impresión</label>
                                            <label class="control-label d-block">Directa</label>
                                        </div>
                                        <div style="display: flex; justify-content: center;">
                                            <vs-switch color="#073f68" v-model="form.direct_printing" />
                                        </div>
                                        <small class="form-control-feedback" v-if="errors.direct_printing"
                                            v-text="errors.direct_printing[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.etiquetadora }">
                                        <label class="control-label">Etiquetadora</label>
                                        <el-input v-model="form.etiquetadora"> </el-input>
                                        <small class="form-control-feedback" v-if="errors.etiquetadora"
                                            v-text="errors.etiquetadora[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.printer }">
                                        <label class="control-label">Impresora</label>
                                        <el-input v-model="form.printer"> </el-input>
                                        <small class="form-control-feedback" v-if="errors.printer"
                                            v-text="errors.printer[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.copies }">
                                        <label class="control-label">Copias </label>
                                        <el-input v-model="form.copies"> </el-input>
                                        <small class="form-control-feedback" v-if="errors.copies"
                                            v-text="errors.copies[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.format_printer }">
                                        <label class="control-label">Tamaño hoja </label>
                                        <el-select v-model="form.format_printer" slot="prepend"
                                            placeholder="Seleccione el Tipo de Papel">
                                            <el-option label="A4" value="1">
                                                <span style="color: #1976d2;">A4</span>
                                            </el-option>
                                            <el-option label="A5" value="2">
                                                <span style="color: #388e3c;">A5</span>
                                            </el-option>
                                            <el-option label="Ticket 80MM" value="3">
                                                <span style="color: #fbc02d;">Ticket 80MM</span>
                                            </el-option>
                                            <el-option label="Ticket 50MM" value="4">
                                                <span style="color: #d32f2f;">Ticket 50MM</span>
                                            </el-option>
                                        </el-select>
                                        <small class="form-control-feedback" v-if="errors.format_printer"
                                            v-text="errors.format_printer[0]"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" :class="{ 'has-danger': errors.customer_id }">
                        <label class="control-label">Cliente por defecto</label>
                        <el-select v-model="form.customer_id" slot="prepend" @change="checkDocument"
                            placeholder="Seleccione el Cliente por defecto">
                            <el-option v-for="option in customers" :key="option.id" :value="option.id"
                                :label="option.name"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.customer_id"
                            v-text="errors.customer_id[0]"></small>
                    </div>

                    <div class="form-group" :class="{ 'has-danger': errors.document_default }">
                        <label class="control-label">CPE por defecto</label>
                        <el-select @change="checkDocument" v-model="form.document_default" slot="prepend"
                            placeholder="Seleccione el Comprobante">
                            <template v-if="soap_type_id != '03'">
                                <el-option label="Factura Electrónica" value="01"></el-option>
                                <el-option label="Boleta de Venta" value="03"></el-option>
                            </template>
                            <el-option label="Nota de Venta" value="80"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.document_default"
                            v-text="errors.document_default[0]"></small>
                    </div>
                    <div class="col-md-12" v-if="soap_type_id != '03' && configuration.restaurant">
                        <label class="control-label"></label>
                        <div class="form-group" :class="{ 'has-danger': errors.has_igv_31556 }">
                            <vs-checkbox color="#073f68" v-model="form.has_igv_31556">
                                Sujeto al IGV - Ley 31556 (Restaurant)
                            </vs-checkbox>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="control-label">Comprobantes habilitados</label>
                    <div class="form-group">
                        <vs-checkbox color="#073f68" v-model="documents.invoice">
                            Factura
                        </vs-checkbox>
                        <vs-checkbox color="#073f68" v-model="documents.receipt">
                            Boleta
                        </vs-checkbox>
                        <vs-checkbox color="#073f68" @change="checkDirectSale" v-model="documents.sale_note">
                            Nota de venta
                        </vs-checkbox>
                    </div>
                </div>
                <div class="col-md-4" v-loading="loadingSerie" v-if="seriesDefault.length != 0 && !recordId">
                    <label class="control-label">
                        <vs-checkbox color="#073f68" v-model="createSeries">
                            Series predeterminadas
                        </vs-checkbox>
                    </label>
                    <div class="form-group" :class="{ 'has-danger': errors.has_igv_31556 }">
                        <el-input-number @input="reloadSeries" :min="1" :max="99" :controls="false"
                            :disabled="!createSeries" v-model="numberLocal"></el-input-number>
                        <label class="mt-1">
                            <strong class="h5">
                                {{
                                    seriesDefault
                                        .map(m => m.serie)
                                        .join(" / ")
                                }}
                            </strong>
                        </label>
                    </div>
                </div>
                <div class="col-md-4" v-if="configuration.restaurant">
                    <div class="col-md-12" v-if="seriesDefault.length == 0 || recordId">
                        <label class="control-label">QR yape</label>
                        <div class="d-flex align-items-center">
                            <el-input v-model="form.image_yape" :readonly="true"
                                placeholder="Nombre del archivo QR Yape" style="flex: 1; margin-right: 8px;" clearable>
                            </el-input>
                            <el-upload :headers="headers" :data="{
                                type: 'image_yape',
                                id: form.id
                            }" :action="action" :show-file-list="false" :on-success="successUpload">
                                <el-tooltip content="Subir QR Yape" placement="top">
                                    <el-button :disabled="!form.id" type="primary" icon="el-icon-upload" size="small"
                                        style="border-radius: 20px;">
                                        Subir
                                    </el-button>
                                </el-tooltip>
                            </el-upload>
                        </div>
                        <div v-if="form.image_yape" class="d-flex justify-content-center mt-2">
                            <img class="img-thumbnail" :src="`/storage/uploads/logos/${form.image_yape}`" alt="QR Yape"
                                style="max-height: 100px;" />
                        </div>
                    </div>
                </div>



            </div>
            <!-- <div class="row">
                

                <div class="col-md-4">
                    <el-tooltip
                        content="Se Habilita para hacer Venta Rápida con Nota de venta sin ingresar clientes ni metodos"
                        placement="top">
                        <label class="control-label">Venta Rápida</label>
                    </el-tooltip>
                    <div class="col-1 center con-switch">
                        <vs-switch color="#073f68" v-model="conf.direct_sale" :disabled="!documents.sale_note"
                            @change="updateAll" size="small" />
                    </div>
                </div>


            </div> -->

            <div class="rowm mt-3">
                <div class="col-12 d-flex justify-content-end">

                    <el-button class="btn_cancelarsmall" @click.prevent="close()">Cancelar</el-button>
                    <el-button class="btn_guardarsmall" type="primary" native-type="submit"
                        :loading="loading_submit">Guardar</el-button>

                </div>
            </div>


        </form>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
:deep(.el-switch.is-checked .el-switch__core) {
    background-color: #073f68 !important;
    border-color: #073f68 !important;
    box-shadow: 0 0 2px #073f68 !important;
}

:deep(.el-switch__core) {
    background-color: #bdbdbd !important;
    border-color: #bdbdbd !important;
    box-shadow: 0 0 2px #bdbdbd !important;
}
</style>

<script>
export default {
    props: [
        "showDialog",
        "recordId",
        "soap_type_id",
        "seriesDefault",
        "number",
        "configuration"
    ],
    data() {
        return {
            createSeries: true,
            numberLocal: 0,
            loading_submit: false,
            titleDialog: null,
            resource: "establishments",
            errors: {},
            form: { conf: {} },
            headers: headers_token,
            documents: {
                invoice: true,
                receipt: true,
                sale_note: true
            },
            countries: [],
            all_departments: [],
            all_provinces: [],
            all_districts: [],
            customers: [],
            provinces: [],
            districts: [],
            action: "/establishments/uploads",
            loadingSerie: false,
            oldNumber: null,
            conf: {},
            dialogTop: '20px' // Valor inicial para la posición superior
            
        };
    },
    async created() {
        await this.initForm();

        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.countries = response.data.countries;
            this.all_departments = response.data.departments;
            this.all_provinces = response.data.provinces;
            this.customers = response.data.customers;
            this.all_districts = response.data.districts;
        });
    },
    mounted() {
        //     console.log('res1');
        //     qz.security.setCertificatePromise((resolve, reject) => {
        //         this.$http.get('/api/qz/crt/override', {
        //             responseType: 'text'
        //         }).then(response => {
        //             console.log('res2');
        //             resolve(response.data);
        //         }).catch(error => {
        //             reject(error.data);
        //         });
        //     });
        //    console.log('res2');
        //     qz.security.setSignaturePromise((toSign) => {
        //         return (resolve, reject) => {
        //             this.$http.post('/api/qz/signing', {request: toSign})
        //                 .then(response => {
        //                    console.log('res2');
        //                     resolve(response.data);
        //                 }).catch(error => {
        //                 reject(error.data);
        //             });
        //         };
        //     });
    },
    methods: {
        checkDirectSale() {
            let { sale_note } = this.documents;
            if (!sale_note && this.conf.direct_sale) {
                this.conf.direct_sale = false;
                this.$toast.error(
                    "Deshabilitando venta directa, es necesaria la nota de venta."
                );
            }
        },
        updateAll() {
            this.$forceUpdate();
        },
        async checkSerie() {
            if (this.numberLocal == 0) {
                this.$toast.error("Número inválido");
                return false;
            }
            let pass = false;
            try {
                this.loadingSerie = true;
                let [f, b, n] = this.seriesDefault;
                let query = `f=${f.serie}&b=${b.serie}&n=${n.serie}`;
                const response = await this.$http.get(`/series/check?${query}`);
                if (response.status == 200) {
                    const {
                        data: { success, message }
                    } = response;

                    if (success) {
                        pass = true;
                        this.$toast.success(message);
                    } else {
                        this.$toast.error(message);
                    }
                }
                //check_series
            } catch (e) {
                console.log(e);
                this.$toast.error(e);
            } finally {
                this.loadingSerie = false;
                return pass;
            }
        },
        async reloadSeries() {
            this.oldNumber = this.number;
            await this.$emit("update:number", this.numberLocal);
            await this.$emit("generateSerie");
            // let pass = await this.checkSerie();
            // if (!pass) {
            //     this.numberLocal = oldNumber;
            //     this.$emit("update:number", oldNumber);
            //     this.$emit("generateSerie");
            // }
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$toast.success(response.message);
                this.form[response.type] = response.name;
            } else {
                this.$toast.error("Error al subir el archivo");
            }
        },
        checkDocument() {
            let idSearch = this.form.customer_id;
            let idDocument = this.form.document_default;
            let customer = this.customers.find(c => idSearch == c.id);
            if (customer) {
                let { number } = customer;
                if (idDocument == "01" && number.length != "11") {
                    this.form.document_default = "03";
                    return this.$toast.error(
                        "El cliente por defecto no cuenta con ruc."
                    );
                }
                if (idDocument != "01" && number.length == "11") {
                    this.form.document_default = "01";
                    return this.$toast.error(
                        "El cliente por defecto es una empresa (factura)."
                    );
                }
            }
        },
        initForm() {
            this.errors = {};
            this.form = {
                conf: {},
                id: null,
                description: null,
                country_id: "PE",
                department_id: null,
                province_id: null,
                district_id: null,
                address: null,
                telephone: null,
                email: null,
                code: null,
                trade_address: null,
                web_address: null,
                aditional_information: null,
                format_printer: null,
                printer: null,
                direct_printing: null,
                document_default: null,
                printer_serve: null,
                customer_id: null,
                copies: 0,

                has_igv_31556: false
            };
        },
        async create() {
            this.numberLocal = this.number;
            this.titleDialog = this.recordId
                ? "Editar Establecimiento"
                : "Nuevo Establecimiento";
            if (this.recordId) {
                await this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        if (response.data !== "") {
                            this.form = response.data.data;
                            if (this.form.direct_printing == "1") {
                                this.form.direct_printing = true;
                            } else {
                                this.form.direct_printing = false;
                            }
                            this.conf = this.form.conf ?? {};
                            let { documents } = this.form;
                            if (documents) {
                                this.documents = documents;
                            }
                            this.filterProvinces();
                            this.filterDistricts();
                        }
                    });
            }
        },
        async submit() {
            if (this.form.description == null || this.form.description == "") {
                this.$refs.inputDescription.$el.querySelector("input").focus();
                this.$toast.error(
                    'El campo "Descripción" no puede estar vacio',
                    { icon: "fas fa-poo" }
                );
                return;
            }
            if (this.form.address == null || this.form.address == "") {
                this.$refs.address_input.$el.querySelector("input").focus();
                this.$toast.error(
                    'El campo "Direccion Fiscal" no puede estar vacio',
                    { icon: "fas fa-poo" }
                );
                return;
            }
            if (this.form.email == null || this.form.email == "") {
                this.$refs.emailInput.$el.querySelector("input").focus();
                this.$toast.error(
                    'El campo "Correo de Contacto" no puede estar vacio',
                    { icon: "fas fa-poo" }
                );
                return;
            }
            this.loading_submit = true;
            this.form.documents = this.documents;
            if (this.createSeries && !this.recordId) {
                this.form.series = this.seriesDefault;
                let pass = await this.checkSerie();

                if (!pass) {
                    this.loading_submit = false;
                    return;
                }
            }
            this.form.conf = this.conf;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    console.log(response);
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    console.log(error.response);
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
        filterProvince() {
            this.form.province_id = null;
            this.form.district_id = null;
            this.filterProvinces();
        },
        filterProvinces() {
            this.provinces = this.all_provinces.filter(f => {
                return f.department_id === this.form.department_id;
            });
        },
        filterDistrict() {
            this.form.district_id = null;
            this.filterDistricts();
        },
        filterDistricts() {
            this.districts = this.all_districts.filter(f => {
                return f.province_id === this.form.province_id;
            });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
