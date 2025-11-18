<template>

    <div class="container-fluid p-l-0 p-r-0">
        <div v-loading="loading" class="">
            <el-tabs style="padding: 4px; margin-bottom: 0; margin-top: 0;" v-model="activeTab" class="custom-tabs"
                @tab-click="handleTabClick">
                <el-tab-pane label="Datos Empresa" name="empresa" class="custom-tab-pane mt-0" style="padding: 8px;">
                    <!-- Contenido original: Datos de la Empresa -->
                    <div class="card custom-card border-info mb-0" style="padding: 4px;">
                        <h4 class="my-0">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-building mr-2"></i>
                                Datos de la Empresa
                            </div>
                        </h4>
                        <div class="card-body" style="padding: 4px;">
                            <div class="row g-3">
                                <!-- RUC y Nombre de Empresa -->
                                <div class="col-md-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.number }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-file-alt"></i> RUC
                                            <el-tooltip content="El RUC es un campo obligatorio">
                                                <span class="text-danger"><i class="fas fa-asterisk"></i></span>
                                            </el-tooltip>
                                        </label>
                                        <vs-input color="#073f68" v-model="form.number" placeholder="Ingrese RUC"
                                            :maxlength="11" @input="searchDocument()" clearable />
                                        <small class="text-danger" v-if="errors.number"
                                            v-text="errors.number[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" :class="{ 'has-danger': errors.name }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-building"></i> Razón Social
                                        </label>
                                        <vs-input color="#073f68" v-model="form.name" placeholder="Nombre de la empresa"
                                            clearable style="width: 100%;" @input="toUppercase($event, 'name')" />
                                        <small class="text-danger" v-if="errors.name" v-text="errors.name[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" :class="{ 'has-danger': errors.trade_name }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-trademark"></i> Nombre Comercial
                                            <el-tooltip content="Campo obligatorio">
                                                <span class="text-danger"><i class="fas fa-asterisk fa-xs"></i></span>
                                            </el-tooltip>
                                        </label>
                                        <vs-input color="#073f68" v-model="form.trade_name"
                                            placeholder="Nombre comercial" clearable style="width: 100%;" @input="toUppercase($event, 'trade_name')" />
                                        <small class="text-danger" v-if="errors.trade_name"
                                            v-text="errors.trade_name[0]"></small>
                                    </div>
                                </div>

                                <!-- Representante Legal -->
                                <div class="col-md-2">
                                    <div class="form-group" :class="{ 'has-danger': errors.representative_number }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-id-card"></i> DNI Representante
                                            <el-tooltip content="Campo obligatorio">
                                                <span class="text-danger" style="font-size: 0.7em;"><i
                                                        class="fas fa-asterisk"></i></span>
                                            </el-tooltip>
                                        </label>
                                        <vs-input color="#073f68" v-model="form.representative_number" placeholder="DNI"
                                            :maxlength="8" clearable style="width: 100%;"
                                            @input="searchDocument(false)" />
                                        <small class="text-danger" v-if="errors.representative_number"
                                            v-text="errors.representative_number[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" :class="{ 'has-danger': errors.representative }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-user-tie"></i> Representante Legal
                                        </label>
                                        <vs-input color="#073f68" v-model="form.representative"
                                            placeholder="Nombre del representante" clearable style="width: 100%;" />
                                        <small class="text-danger" v-if="errors.representative"
                                            v-text="errors.representative[0]"></small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" :class="{ 'has-danger': errors.representative_address }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-map-marker-alt"></i> Dirección Representante
                                        </label>
                                        <vs-input color="#073f68" v-model="form.representative_address"
                                            placeholder="Dirección" clearable style="width: 100%;" />
                                        <small class="text-danger" v-if="errors.representative_address"
                                            v-text="errors.representative_address[0]"></small>
                                    </div>
                                </div>

                                <!-- Slogan y Cuenta de Detracción -->
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.eslogan }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-quote-right"></i> Slogan de la Empresa
                                        </label>
                                        <vs-input color="#073f68" v-model="form.eslogan" placeholder="Slogan" clearable
                                            style="width: 100%;" />
                                        <small class="text-danger" v-if="errors.eslogan"
                                            v-text="errors.eslogan[0]"></small>
                                    </div>
                                </div>


                                <!-- App Name y Pago Digital -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-mobile-alt"></i> Nombre de la App
                                        </label>
                                        <vs-input color="#073f68" v-model="form.app_name" placeholder="Nombre de la app"
                                            clearable style="width: 100%;" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-money-check-alt"></i> Nº Pago Digital (Yape/Plin)
                                        </label>
                                        <vs-input color="#073f68" v-model="form.number_pay_digital"
                                            placeholder="Número de pago digital" clearable :maxlength="9"
                                            style="width: 100%;" />
                                    </div>
                                </div>

                                <div class="col-md-3" v-if="configuration.detraction">
                                    <div class="form-group" :class="{ 'has-danger': errors.detraction_account }">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-file-invoice-dollar"></i> Cuenta de Detracción
                                        </label>
                                        <vs-input color="#073f68" v-model="form.detraction_account"
                                            placeholder="Cuenta de detracción" clearable style="width: 100%;" />
                                        <small class="text-danger" v-if="errors.detraction_account"
                                            v-text="errors.detraction_account[0]"></small>
                                    </div>
                                </div>
                                <!-- Clientes con mismo RUC -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold" style="color: #073f68;">
                                            <i class="fas fa-users"></i> Clientes con mismo RUC
                                        </label>
                                        <el-select v-model="same_ruc_id" placeholder="Seleccione" clearable filterable
                                            @change="saveSameRuc" style="width: 100%;">
                                            <el-option v-for="(item, idx) in companies" :key="idx" :label="item.name + ' - ' + item.number"
                                                :value="item.id"></el-option>
                                        </el-select>
                                        <div class="mt-2">
                                            <el-tag class="m-1" v-for="(item, idx) in same_rucs" :key="idx" closable
                                                @close="removeSameRuc(item.id)">
                                                {{ item.name }}
                                            </el-tag>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.operation_amazonia }">

                                        <div>
                                            <vs-checkbox color="#073f68" v-model="form.operation_amazonia">
                                                <span style="color: #073f68;">¿Emite en la Amazonía?</span>
                                            </vs-checkbox>
                                        </div>
                                    </div>
                                </div>
                                <!-- Es Prico y Amazonía -->
                                <div class="col-md-3">
                                    <div class="form-group" :class="{ 'has-danger': errors.is_prico }">

                                        <div>
                                            <vs-checkbox color="#073f68" v-model="form.is_prico">
                                                <span style="color: #073f68;">¿Es Prico?</span>
                                            </vs-checkbox>
                                        </div>
                                        <small class="text-danger" v-if="errors.is_prico"
                                            v-text="errors.is_prico[0]"></small>
                                    </div>
                                </div>

                                <div class="card-body mt-0" style="padding: 4px;">
                                    <div class="card">
                                        <div class="card-header bg-primary" style="padding: 4px;">
                                            <h4 class="text-white my-0">
                                                <i class="fab fa-whatsapp"></i>
                                                Whatsapp Externo
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="url">
                                                        URL
                                                    </label>
                                                    <el-input v-model="form.api_extern_whatsapp_url"></el-input>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="url">
                                                        ID DEVICE
                                                    </label>
                                                    <el-input v-model="form.api_extern_whatsapp_token"></el-input>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="url">
                                                        API TOKEN
                                                    </label>
                                                    <el-input v-model="form.api_extern_whatsapp_token_2
                                                        "></el-input>
                                                </div>
                                            </div>

                                            <!-- <div class="form-actions text-end pt-2 pb-2">
                                                <el-button icon="fas fa-save fa-lg" type="primary"
                                                    :loading="loading_submit" @click="submit()">
                                                    Guardar</el-button>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="form-actions pt-2 pb-2">
                                        <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary"
                                            :loading="loading_submit" @click="submit()">
                                            Guardar
                                        </el-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="Imágenes" name="imagenes" class="custom-tab-pane mt-0" style="padding: 8px;">
                    <!-- Contenido: Imágenes del Sistema -->
                    <div class="card custom-card border-info mb-0" style="padding: 4px;">
                        <div class="card-header bg-primary">
                            <h4 class="text-white my-0 card-title">
                                <i class="fas fa-images fa-lg"></i>
                                Imágenes del Sistema
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row custom-row-spacing" style="padding: 4px;">
                                <div class="col-md-3 mb-2">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Logo</h5>
                                        </div>
                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.logo" :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload"
                                                                    @click="selectImage('logo')"></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="text-danger">
                                                            <small>Resolución 700px x 300px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail"
                                                            :src="form.logo ? `/storage/uploads/logos/${form.logo}` : ''"
                                                            style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Logo de Documento</h5>
                                        </div>
                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <!-- Sección para 'Logo Documento' -->

                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.document_logo" :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'document_logo'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="text-danger">
                                                            <small>Resolución 700px x 300px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
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
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Imagen de Fondo</h5>
                                        </div>
                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.img_bg" :readonly="true">
                                                            <el-upload slot="append" :headers="headers"
                                                                :data="{ type: 'img_bg' }" action="/companies/img_bg"
                                                                :show-file-list="false" :on-success="successUpload">
                                                                <el-button type="primary"
                                                                    icon="el-icon-upload"></el-button>
                                                            </el-upload>
                                                        </el-input>
                                                        <div class="text-danger">
                                                            <small>Resoluciones 1280px x 599px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail"
                                                            :src="form.img_bg ? `/storage/uploads/img_bg/${form.img_bg}` : ''"
                                                            style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Favicon</h5>
                                        </div>

                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.favicon" :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'favicon'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="text-danger">
                                                            <small>Resoluciones
                                                                32px x 32px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.favicon
                                                            ? `/storage/uploads/favicon/${form.favicon}`
                                                            : ''
                                                            " style="max-height: 65px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Header A5</h5>
                                        </div>

                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.a5_image" :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'a5_image'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="badge text-danger">
                                                            <vs-checkbox color="#073f68" v-model="show_image_a5"
                                                                @change="setConfiguration">
                                                                Mostrar imagen en A5
                                                            </vs-checkbox>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.a5_image
                                                            ? `/storage/uploads/logos/${form.a5_image}`
                                                            : ''
                                                            " style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Marca de Agua</h5>
                                        </div>


                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.backgroud_image_document
                                                            " :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'backgroud_image_document'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="text-danger">
                                                            <small>Resolución
                                                                800px x 600px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.backgroud_image_document
                                                            ? `/storage/uploads/logos/${form.backgroud_image_document}`
                                                            : ''
                                                            " style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>cuentas trade_name_max</h5>
                                        </div>

                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.account_img_trade_name_max
                                                            " :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'account_img_trade_name_max'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="badge text-danger">
                                                            <small>Se recomienda resoluciones
                                                                500x100 máximo</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.account_img_trade_name_max
                                                            ? `/storage/uploads/logos/${form.account_img_trade_name_max}`
                                                            : ''
                                                            " style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Dólares trade_name_max</h5>
                                        </div>

                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.file_nuevo_dolares_img
                                                            " :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'file_nuevo_dolares_img'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                        <div class="badge text-danger">
                                                            <small>Resolución 300px x 80px</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.file_nuevo_dolares_img
                                                            ? `/storage/uploads/logos/${form.file_nuevo_dolares_img}`
                                                            : ''
                                                            " style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card custom-card-spacing" style="padding: 4px;">
                                        <div class="card-header custom-header-spacing" style="padding: 4px;">
                                            <h5>Reporte Tabulado (Red Pki)</h5>
                                        </div>
                                        <div class="card-body" style="padding: 4px;">
                                            <div class="col-md-12">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <el-input v-model="form.health_network_image
                                                            " :readonly="true">
                                                            <template slot="append">
                                                                <el-button type="primary" icon="el-icon-upload" @click="
                                                                    selectImage(
                                                                        'health_network_image'
                                                                    )
                                                                    "></el-button>
                                                            </template>
                                                        </el-input>
                                                    </div>
                                                    <div class="col-4">
                                                        <img class="img-thumbnail" :src="form.health_network_image
                                                            ? `/storage/uploads/logos/${form.health_network_image}`
                                                            : ''
                                                            " style="max-height: 100px;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="Entorno Sunat" name="entorno" class="custom-tab-pane mt-0" style="padding: 3px;">
                    <!-- Contenido: Entorno del sistema -->
                    <div class="row">
                        <div class="col-6">
                            <div class="card-body mb-2" style="padding: 2px;">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h4 class="text-white my-0">
                                            <i class="fas fa-cogs"></i>
                                            Entorno
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" :class="{
                                                    'has-danger': errors.soap_type_id
                                                }">
                                                    <label class="control-label">SOAP Tipo</label>
                                                    <el-select v-model="form.soap_type_id">
                                                        <el-option v-for="option in soap_types" :key="option.id"
                                                            :value="option.id" :label="option.description"></el-option>
                                                    </el-select>

                                                    <el-checkbox v-if="
                                                        form.soap_send_id == '02' &&
                                                        form.soap_type_id == '01'
                                                    " v-model="toggle" label="Ingresar Usuario">
                                                    </el-checkbox>
                                                    <small class="text-danger" v-if="errors.soap_type_id"
                                                        v-text="errors.soap_type_id[0]"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6" v-if="form.soap_type_id != '03'">
                                                <div class="form-group" :class="{
                                                    'has-danger': errors.soap_send_id
                                                }">
                                                    <label class="control-label">SOAP Envio</label>
                                                    <el-select v-model="form.soap_send_id" >
                                                        <el-option v-for="(option, index) in soap_sends" :key="index"
                                                             :value="index" :label="option">
                                                        </el-option>
                                                    </el-select>
                                                    <small class="text-danger" v-if="errors.soap_send_id"
                                                        v-text="errors.soap_send_id[0]"></small>
                                                </div>
                                                <div class="col-md-12" v-if="form.soap_type_id == '02'">
                                                    <div class="form-group" :class="{
                                                        'has-danger':
                                                            errors.soap_send_id
                                                    }">
                                                        <label class="control-label">Certificado Digital</label>
                                                        <tenant-certificates-index></tenant-certificates-index>
                                                    </div>
                                                </div>
                                            </div>
                                            <template v-if="form.soap_send_id == '02'">
                                                <div class="col-md-3">
                                                    <label for="soap_ose_user">Usuario OSE</label>
                                                    <el-input v-model="form.ose_user"></el-input>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="soap_ose_password">Contraseña OSE</label>
                                                    <el-input v-model="form.ose_password"></el-input>
                                                </div>
                                            </template>
                                        </div>
                                        <template v-if="form.soap_type_id == '02' || toggle == true">
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    Datos del Usuario Secundario SUNAT

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group" :class="{
                                                        'has-danger':
                                                            errors.soap_username
                                                    }">
                                                        <label class="control-label">SOAP Usuario
                                                            <span class="text-danger">*</span></label>
                                                        <el-input v-model="form.soap_username"
                                                            style="text-transform: none !important;"
                                                            autocomplete="off">
                                                        </el-input>
                                                        <div class=" ">
                                                            <small>RUC + Usuario. Ejemplo:
                                                                10205687985ELUSUARIO</small>
                                                        </div>
                                                        <small class="text-danger" v-if="errors.soap_username"
                                                            v-text="errors.soap_username[0]"
                                                            style="color: #073f68;"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group" :class="{
                                                        'has-danger': errors.soap_password
                                                    }">
                                                        <label class="control-label">SOAP Password
                                                            <span class="text-danger">*</span></label>
                                                        <el-input
                                                            v-model="form.soap_password"
                                                            :maxlength="50"
                                                            show-password
                                                            autocomplete="off"
                                                            style="text-transform: none !important;"
                                                        ></el-input>
                                                        <small class="text-danger" v-if="errors.soap_password"
                                                            v-text="errors.soap_password[0]"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                        <div class="row" v-if="form.soap_send_id == '02'">
                                            <div class="col-md-10">
                                                <div class="form-group" :class="{
                                                    'has-danger': errors.soap_url
                                                }">
                                                    <label class="control-label">SOAP Url</label>
                                                    <el-input v-model="form.soap_url" style="text-transform: none !important;">
                                                    </el-input>
                                                    <small class="text-danger" v-if="errors.soap_url"
                                                        v-text="errors.soap_url[0]"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions d-flex justify-content-end text-end pt-2 pb-2 mt-2">
                                            <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary"
                                                :loading="loading_submit" @click="submit()">
                                                Guardar
                                            </el-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card-body mb-2" style="padding: 2px;">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h4 class="my-0 text-white">
                                            <i class="fas fa-file-alt"></i>
                                            <!-- Icono de archivo -->
                                            Guías Electrónicas
                                        </h4>
                                        <!-- <h4 class="my-0 text-white">Guías electrónicas</h4> -->
                                    </div>
                                    <div class="card-body">
                                        <form autocomplete="off" @submit.prevent="submit">
                                            <div class="form-body">
                                                < <div class="row">
                                                    <div class="col-md-6">
                                                        <div :class="{
                                                            'has-danger':
                                                                errors.soap_sunat_username
                                                        }" class="form-group">
                                                            <label class="control-label">SOAP Usuario</label>
                                                            <el-input v-model="form.soap_sunat_username"
                                                                style="text-transform: none !important;"
                                                                autocomplete="off"></el-input>
                                                            <div class="sub-title">
                                                                <small>RUC + Usuario. Ejemplo:
                                                                    20443618687ELUSUARIO</small>
                                                            </div>
                                                            <small v-if="
                                                                errors.soap_sunat_username
                                                            " class="form-control-feedback" v-text="errors
                                                                .soap_sunat_username[0]
                                                                "></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div :class="{
                                                            'has-danger':
                                                                errors.soap_sunat_password
                                                        }" class="form-group">
                                                            <label class="control-label">SOAP Password</label>
                                                            <el-input v-model="form.soap_sunat_password"
                                                                style="text-transform: none !important;"
                                                                show-password autocomplete="off"></el-input>
                                                            <small v-if="
                                                                errors.soap_sunat_password
                                                            " class="form-control-feedback" v-text="errors
                                                                .soap_sunat_password[0]
                                                                "></small>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div :class="{
                                                        'has-danger':
                                                            errors.api_sunat_id
                                                    }" class="form-group">
                                                        <label class="control-label">Client ID</label>
                                                        <el-input v-model="form.api_sunat_id"></el-input>
                                                        <small v-if="errors.api_sunat_id" class="form-control-feedback"
                                                            v-text="errors.api_sunat_id[0]
                                                                "></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div :class="{
                                                        'has-danger':
                                                            errors.api_sunat_secret
                                                    }" class="form-group">
                                                        <label class="control-label">Client Secret
                                                            (Clave)</label>
                                                        <el-input v-model="form.api_sunat_secret
                                                            "></el-input>
                                                        <small v-if="
                                                            errors.api_sunat_secret
                                                        " class="form-control-feedback" v-text="errors
                                                                .api_sunat_secret[0]
                                                                "></small>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="form-actions d-flex justify-content-end text-end pt-2 mt-2">
                                        <el-button class="btn_guardarsmall" icon="fas fa-save" :loading="loading_submit"
                                            native-type="submit" type="primary">
                                            Guardar
                                        </el-button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>


        </el-tab-pane>

        <el-tab-pane label="Establecimientos" name="whatsapp" class="custom-tab-pane mt-0" style="padding: 8px;">
            <!-- Establecimientos  -->
            <div class="card-body">
                <establishments-index :configuration="configuration"
                    :soap_type_id="form.soap_type_id"></establishments-index>
            </div>
        </el-tab-pane>
        </el-tabs>
    </div>
    </div>
</template>




<style scoped>
.custom-tabs {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px 8px 8px 8px;
    margin-bottom: 20px;
}

.custom-tab-pane {
    background: #fff;
    border-radius: 8px;
    padding: 24px 18px 18px 18px;
    min-height: 200px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.el-tabs__item.is-active {
    color: #fff !important;
    background: #007bff !important;
    border-radius: 6px 6px 0 0;
}

.el-tabs__item {
    font-weight: bold;
    font-size: 1.1em;
    color: #007bff;
    margin-right: 8px;
    padding: 10px 24px;
    transition: background 0.2s;
}

.el-tabs__nav {
    border-bottom: 2px solid #007bff;
}

.no-radius.card-header {
    border-radius: 0px !important;
}

/* ******** gradiente */
.bg-gradient-custom {
    background: radial-gradient(circle, #eeb310, #a5d8ec);
    /* Degradado radial de azul a celeste */
}

.custom-card {
    border: none;
    border-radius: 10px;
    /* Borde redondeado */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* Sombra */
}

.custom-card .card-body {
    padding: 1.5rem;
    /* Espaciado del contenido */
}

.custom-card h5 {
    font-weight: bold;
    font-size: 1.25rem;
    /* Tamaño del texto */
}

.custom-card i {
    font-size: 1.25rem;
    /* Tamaño del icono */
}
</style>

<script>
import Swal from "sweetalert2";

// tenant-certificates-index
const TenantCertificatesIndex = () => import("../certificates/index.vue");
const EstablishmentsIndex = () => import("../establishments/index.vue");
export default {
    props: ["configuration"],
    components: {
        TenantCertificatesIndex,
        EstablishmentsIndex
    },
    data() {
        return {
            form: {
                logo: "",
                document_logo: "",
                img_bg: "",
                favicon: "",
                a5_image: "",
                backgroud_image_document: "",
                account_img_trade_name_max: "",
                file_nuevo_dolares_img: "",
                health_network_image: ""
            },
            activeTab: 'empresa',
            same_ruc_id: null,
            companies: [],
            loading_submit: false,
            headers: headers_token,
            resource: "companies",
            errors: {},
            time: null,
            form: {},
            soap_sends: [],
            soap_types: [],
            loading: false,
            same_rucs: [],
            show_image_a5: false,
            toggle: false, //Creando el objeto a retornar con v-model
            // Variables reactivas para estilos dinámicos
            rowMargin: 10,
            rowPadding: 10,
            cardPadding: 10,
            cardMargin: 10,
            headerPadding: 10,
            headerMargin: 10
        };
    },
    async created() {
        await this.initForm();
        await this.getTables();

        await this.$http.get(`/${this.resource}/record`).then(response => {
            if (response.data !== "") {
                this.form = response.data.data;
            }
        });
        this.show_image_a5 = this.configuration.show_image_a5;
    },
    methods: {
        handleTabClick(tab) {
            // Puedes agregar lógica si necesitas al cambiar de tab
        },
        async selectImage(field) {
            const { value: file } = await Swal.fire({
                title: "Selecciona una imagen",
                input: "file",
                inputAttributes: {
                    accept: "image/*",
                    "aria-label": "Sube tu imagen"
                }
            });

            if (file) {
                // Previsualización de la imagen
                const reader = new FileReader();
                reader.onload = e => {
                    Swal.fire({
                        title: "Vista previa de la imagen",
                        imageUrl: e.target.result,
                        imageAlt: "La imagen subida",
                        showCancelButton: true,
                        confirmButtonText: "Subir imagen",
                        cancelButtonText: "Cancelar"
                    }).then(async result => {
                        if (result.isConfirmed) {
                            // Proceder con la subida de la imagen al servidor
                            const formData = new FormData();
                            formData.append("file", file);
                            formData.append("type", field);


                            try {
                                let url = "/companies/uploads";
                                if (field === "favicon") {
                                    url = "/companies/favicon";
                                }
                                const response = await this.$http.post(
                                    url,
                                    formData,
                                    {
                                        headers: this.headers
                                    }
                                );

                                if (response.data.success) {

                                    // Asegurarse de que la URL de la imagen sea correcta y única para evitar problemas de caché
                                    this.form[field] = `${response.data.name
                                        }`;
                                    Swal.fire({
                                        icon: "success",
                                        title: "Imagen subida correctamente",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    this.$forceUpdate();
                                    // Actualiza la vista para mostrar la imagen subida
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error al subir la imagen",
                                        text:
                                            response.data.message ||
                                            "Inténtelo nuevamente.",
                                        showConfirmButton: true
                                    });
                                }
                            } catch (error) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error al subir la imagen",
                                    text:
                                        error.message ||
                                        "Inténtelo nuevamente.",
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                };
                reader.readAsDataURL(file); // Leer el archivo para la previsualización
            }
        },

        successUpload(response, file, fileList) {
            if (response.success) {
                this.form[response.type] = response.name;
                this.$forceUpdate(); // Asegura la actualización de la visualización de la imagen
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error al subir la imagen",
                    text: response.message || "Inténtelo nuevamente.",
                    showConfirmButton: true
                });
            }
        },
        async uploadImage(field, file) {
            // Lógica para subir la imagen al servidor
            // Simulación de la respuesta del servidor
            return new Promise(resolve => {
                setTimeout(() => {
                    resolve({
                        success: true,
                        name: `uploaded_${field}.jpg`
                    });
                }, 1000);
            });
        },
        async getTables() {
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                this.soap_sends = response.data.soap_sends;
                this.soap_types = response.data.soap_types;
                this.companies = response.data.companies;
                this.same_rucs = response.data.same_rucs;
            });
        },
        saveSameRuc() {
            let same_ruc_id = this.companies.find(
                item => item.id == this.same_ruc_id
            );
            this.$http
                .post(`/companies/save_same_ruc`, {
                    name: same_ruc_id.name,
                    website_id: same_ruc_id.website_id,
                    uuid: same_ruc_id.uuid
                })
                .then(response => {
                    if (response.data.success) {
                        this.getTables();
                        this.same_ruc_id = null;
                        Swal.fire({ icon: 'success', title: response.data.message });
                    } else {
                        Swal.fire({ icon: 'error', title: response.data.message });
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        removeSameRuc(id) {
            this.$http
                .delete(`/companies/remove_same_ruc/${id}`)
                .then(response => {
                    if (response.data.success) {
                        this.getTables();
                        this.same_ruc_id = null;
                        Swal.fire({ icon: 'success', title: response.data.message });
                    } else {
                        Swal.fire({ icon: 'error', title: response.data.message });
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        async setConfiguration() {
            await this.$http
                .post(`/configurations`, {
                    ...this.configuration,
                    show_image_a5: this.show_image_a5
                })
                .then(response => {
                    if (response.data.success) {
                        Swal.fire({ icon: 'success', title: response.data.message });
                    } else {
                        Swal.fire({ icon: 'error', title: response.data.message });
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        async searchDocument(isRuc = true) {
            if (this.time) {
                clearTimeout(this.time);
            }
            this.time = setTimeout(async () => {
                let number = isRuc
                    ? this.form.number
                    : this.form.representative_number;
                if (!number) {
                    return Swal.fire({ icon: 'warning', title: 'No puede ser un campo vacio' });
                }
                if (isRuc && number.length != 11) {
                    return;
                }

                ///service/ruc/xxxx
                try {
                    this.loading = true;
                    const response = await this.$http(
                        `/service/${isRuc ? "ruc" : "dni"}/${number}`
                    );
                    if (response.status == 200) {
                        const { success, data } = response.data;
                        if (success) {
                            if (isRuc) {
                                //direccion_completa
                                this.form.name = data.nombre_o_razon_social;
                                this.form.trade_name =
                                    data.nombre_o_razon_social;
                            } else {
                                this.form.representative_address =
                                    data.direccion_completa;
                                this.form.representative = data.nombre_completo;
                            }
                        } else {
                            Swal.fire({ icon: 'warning', title: `El número ${number} es incorrecto` });
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Ocurrió un error al buscar: ' + number });
                    }
                } catch (e) {
                    console.log(e);
                    Swal.fire({ icon: 'error', title: 'Ocurrió un error' });
                } finally {
                    this.loading = false;
                }
            }, 600);
        },
        initForm() {
            this.errors = {};
            this.form = {
                api_extern_whatsapp_url: null,
                api_extern_whatsapp_token: null,
                api_extern_whatsapp_token_2: null,
                id: null,
                identity_document_type_id: "06000006",
                number: null,
                name: null,
                trade_name: null,
                soap_send_id: "01",
                soap_type_id: "01",
                soap_username: null,
                soap_password: null,
                soap_url: null,
                //moddatos
                //20602339972VILLACOR
                ose_user: null,
                ose_password: null,
                certificate: null,
                logo: null,
                favicon: null,
                key: null,
                logo_store: null,
                img_bg: null,
                detraction_account: null,
                operation_amazonia: false,
                toggle: false,
                config_system_env: false,
                representative: null,
                representative_number: null,
                representative_address: null,
                eslogan: null,
                pusher_app_key: null,
                pusher_app_secret: null,
                pusher_app_id: null,
                pusher_app_cluster: null
            };
        },
        toUppercase(value, field) {
            // Convierte el valor recibido a mayúsculas y lo asigna al campo del formulario
            this.form[field] = value ? value.toUpperCase() : '';
        },
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        Swal.fire({ icon: 'success', title: response.data.message });
                    } else {
                        Swal.fire({ icon: 'error', title: response.data.message });
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error.response.data.errors.name[0]);
                        Swal.fire({ icon: 'error', title: error.response.data.errors.name[0] });
                        this.errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        }
    }
};
</script>
