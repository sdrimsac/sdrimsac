<template>
    <div class="container-fluid p-l-0 p-r-0">
        <div v-loading="loading" class="">
            <div class="card custom-card border-info mb-3">
                <h4 class="my-0">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-building mr-2"></i>
                        Datos de la Empresa
                    </div>
                </h4>
                <!-- Datos de la Empresa -->
                <div class="card-body">
                    <form autocomplete="off">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.number }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-file-alt"></i>
                                            Número de RUC :
                                        </label>
                                        <el-input
                                            @input="searchDocument()"
                                            v-model="form.number"
                                            :maxlength="11"
                                            :show-word-limit="true"
                                        >
                                            <template v-slot:prepend>
                                                <i class="fa-id-card"></i>
                                            </template>
                                            <template v-slot:append>
                                                (Max 11 dígitos)
                                            </template>
                                            <input
                                                type="number"
                                                pattern="[0-9]*"
                                            />
                                        </el-input>

                                        <small
                                            class="text-danger"
                                            v-if="errors.number"
                                            v-text="errors.number[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{ 'has-danger': errors.name }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-building"></i>
                                            Nombre de Empresa
                                        </label>

                                        <el-input v-model="form.name" disabled>
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.name"
                                            v-text="errors.name[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.representative
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            Representante Legal
                                        </label>

                                        <el-input
                                            v-model="form.representative"
                                            disabled
                                        >
                                        </el-input>

                                        <small
                                            class="text-danger"
                                            v-if="errors.representative"
                                            v-text="errors.representative[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.representative_number
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            Nº DNI Representante Legal
                                        </label>

                                        <el-tooltip content="Campo Obligatorio">
                                            <span class="text-danger">
                                                <i
                                                    class="fas fa-exclamation-circle"
                                                ></i>
                                            </span>
                                        </el-tooltip>

                                        <el-input
                                            :maxlength="8"
                                            @input="searchDocument(false)"
                                            v-model="form.representative_number"
                                            :show-word-limit="true"
                                        >
                                            <template v-slot:prepend>
                                                <i class="el-icon-user"></i>
                                            </template>
                                            <template v-slot:append>
                                                (Max 8 dígitos)
                                            </template>
                                            <input
                                                type="number"
                                                pattern="[0-9]*"
                                            />
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.representative_number"
                                            v-text="
                                                errors.representative_number[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.representative_address
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i
                                                class="fas fa-map-marker-alt"
                                            ></i>
                                            Dirección Representante Legal
                                        </label>
                                        <el-input
                                            v-model="
                                                form.representative_address
                                            "
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.representative_address"
                                            v-text="
                                                errors.representative_address[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.trade_name
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-trademark"></i>
                                            Nombre Comercial
                                            <el-tooltip
                                                content="Campo Obligatorio"
                                            >
                                                <span class="text-danger">
                                                    <i
                                                        class="fas fa-exclamation-circle"
                                                    ></i>
                                                    <!-- Icono de dato obligatorio -->
                                                </span>
                                            </el-tooltip>
                                        </label>
                                        <el-input v-model="form.trade_name">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.trade_name"
                                            v-text="errors.trade_name[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.eslogan
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-quote-right"></i>
                                            Slogan de la Empresa
                                        </label>

                                        <el-input v-model="form.eslogan">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.eslogan"
                                            v-text="errors.eslogan[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.detraction_account
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-file-alt"></i>
                                            Cuenta de detracción
                                        </label>

                                        <el-input
                                            v-model="form.detraction_account"
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.detraction_account"
                                            v-text="
                                                errors
                                                    .eslogdetraction_accountan[0]
                                            "
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.is_prico
                                        }"
                                    >
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            <i class="fas fa-check"></i>
                                            Es prico
                                        </label>
                                        <br />
                                        <el-checkbox
                                            v-model="form.is_prico"
                                        ></el-checkbox>

                                        <small
                                            class="text-danger"
                                            v-if="errors.is_prico"
                                            v-text="errors.is_prico[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label
                                            class="control-label font-weight-bold h5"
                                        >
                                            Clientes con mismo ruc
                                        </label>
                                        <el-select
                                            v-model="same_ruc_id"
                                            placeholder="Seleccione"
                                            clearable
                                            filterable
                                            @change="saveSameRuc"
                                        >
                                            <el-option
                                                v-for="(item, idx) in companies"
                                                :key="idx"
                                                :label="item.name"
                                                :value="item.id"
                                            ></el-option>
                                        </el-select>
                                        <br />
                                        <el-tag
                                            class="m-2"
                                            v-for="(item, idx) in same_rucs"
                                            :key="idx"
                                            closable
                                            @close="removeSameRuc(item.id)"
                                        >
                                            {{ item.name }}
                                        </el-tag>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4" v-show="false">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.operation_amazonia
                                    }"
                                >
                                    <el-checkbox
                                        v-model="form.operation_amazonia"
                                        >¿Emite en la Amazonía?</el-checkbox
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Imagenes  para el sistema -->

                        <div class="card mb-4">
                            <div class="card-header bg-primary">
                                <h4 class="text-white my-0 card-title">
                                    <i class="fas fa-images fa-lg"></i>
                                    Imágenes del Sistema
                                    <button
                                        class="btn btn-secundary"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#collapseExample"
                                        aria-expanded="false"
                                        aria-controls="collapseExample"
                                    >
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </h4>
                            </div>
                            <div
                                class="card-body collapse"
                                id="collapseExample"
                            >
                                <div class="row">
                                    <!-- Sección para 'Logo' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Logo</label
                                            >
                                            <el-input
                                                v-model="form.logo"
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage('logo')
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    700x300</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.logo
                                                    ? `/storage/uploads/logos/${form.logo}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Logo Documento' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Logo Documento</label
                                            >
                                            <el-input
                                                v-model="form.document_logo"
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'document_logo'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    700x300</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.document_logo
                                                    ? `/storage/uploads/logos/${form.document_logo}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Imagen Fondo</label
                                            >
                                            <el-input
                                                v-model="form.img_bg"
                                                :readonly="true"
                                            >
                                                <el-upload
                                                    slot="append"
                                                    :headers="headers"
                                                    :data="{ type: 'img_bg' }"
                                                    action="/companies/img_bg"
                                                    :show-file-list="false"
                                                    :on-success="successUpload"
                                                >
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                    ></el-button>
                                                </el-upload>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    700x300</small
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                `/storage/uploads/img_bg/${form.img_bg}`
                                            "
                                            style="  max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Favicon' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Favicon</label
                                            >
                                            <el-input
                                                v-model="form.favicon"
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'favicon'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    32x32</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.favicon
                                                    ? `/storage/uploads/favicon/${form.favicon}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Imagen A5' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Imagen A5</label
                                            >
                                            <el-input
                                                v-model="form.a5_image"
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'a5_image'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <el-checkbox
                                                    @change="setConfiguration"
                                                    v-model="show_image_a5"
                                                >
                                                    Mostrar imagen en A5
                                                </el-checkbox>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.a5_image
                                                    ? `/storage/uploads/logos/${form.a5_image}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Imagen de fondo - documentos' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Imagen de fondo -
                                                documentos</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.backgroud_image_document
                                                "
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'backgroud_image_document'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.backgroud_image_document
                                                    ? `/storage/uploads/logos/${form.backgroud_image_document}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Imagen cuentas plantilla trade_name_max' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Imagen cuentas plantilla
                                                trade_name_max</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.account_img_trade_name_max
                                                "
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'account_img_trade_name_max'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    500x100 máximo</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.account_img_trade_name_max
                                                    ? `/storage/uploads/logos/${form.account_img_trade_name_max}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Imagen Dolares plantilla trade_name_max' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Imagen Dolares plantilla
                                                trade_name_max</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.file_nuevo_dolares_img
                                                "
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'file_nuevo_dolares_img'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                            <div class="badge text-danger">
                                                <small
                                                    >Se recomienda resoluciones
                                                    300x80 máximo</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.file_nuevo_dolares_img
                                                    ? `/storage/uploads/logos/${form.file_nuevo_dolares_img}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>

                                    <!-- Sección para 'Reporte red de salud' -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label"
                                                >Reporte red de salud</label
                                            >
                                            <el-input
                                                v-model="
                                                    form.health_network_image
                                                "
                                                :readonly="true"
                                            >
                                                <template slot="append">
                                                    <el-button
                                                        type="primary"
                                                        icon="el-icon-upload"
                                                        @click="
                                                            selectImage(
                                                                'health_network_image'
                                                            )
                                                        "
                                                    ></el-button>
                                                </template>
                                            </el-input>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img
                                            class="img-thumbnail"
                                            :src="
                                                form.health_network_image
                                                    ? `/storage/uploads/logos/${form.health_network_image}`
                                                    : ''
                                            "
                                            style="max-height: 100px;"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="text-white my-0">
                                <i class="fas fa-cogs"></i>
                                Entorno del sistema
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.soap_type_id
                                        }"
                                    >
                                        <label class="control-label"
                                            >SOAP Tipo</label
                                        >
                                        <el-select v-model="form.soap_type_id">
                                            <el-option
                                                v-for="option in soap_types"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.description"
                                            ></el-option>
                                        </el-select>

                                        <el-checkbox
                                            v-if="
                                                form.soap_send_id == '02' &&
                                                    form.soap_type_id == '01'
                                            "
                                            v-model="toggle"
                                            label="Ingresar Usuario"
                                        >
                                        </el-checkbox>
                                        <small
                                            class="text-danger"
                                            v-if="errors.soap_type_id"
                                            v-text="errors.soap_type_id[0]"
                                        ></small>
                                    </div>
                                </div>
                                <div
                                    class="col-md-3"
                                    v-if="form.soap_type_id != '03'"
                                >
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.soap_send_id
                                        }"
                                    >
                                        <label class="control-label"
                                            >SOAP Envio</label
                                        >
                                        <el-select v-model="form.soap_send_id">
                                            <el-option
                                                v-for="(option,
                                                index) in soap_sends"
                                                :key="index"
                                                :value="index"
                                                :label="option"
                                            ></el-option>
                                        </el-select>
                                        <small
                                            class="text-danger"
                                            v-if="errors.soap_send_id"
                                            v-text="errors.soap_send_id[0]"
                                        ></small>
                                    </div>
                                    <div
                                        class="col-md-4"
                                        v-if="form.soap_type_id == '02'"
                                    >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.soap_send_id
                                            }"
                                        >
                                            <label class="control-label"
                                                >Certificado Digital</label
                                            >
                                            <tenant-certificates-index></tenant-certificates-index>
                                        </div>
                                    </div>
                                </div>
                                <!-- <template v-if="form.soap_send_id == '02'">
                                    <div class="col-md-3">
                                        <label for="soap_ose_user"
                                            >Usuario OSE</label
                                        >
                                        <el-input
                                            v-model="form.ose_user"
                                        ></el-input>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="soap_ose_password"
                                            >Contraseña OSE</label
                                        >
                                        <el-input
                                            v-model="form.ose_password"
                                        ></el-input>
                                    </div>
                                </template> -->
                            </div>
                            <template
                                v-if="
                                    form.soap_type_id == '02' || toggle == true
                                "
                            >
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <h6 class="border-bottom">
                                            Usuario Secundario Sunat
                                        </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.soap_username
                                            }"
                                        >
                                            <label class="control-label"
                                                >SOAP Usuario
                                                <span class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <el-input
                                                v-model="form.soap_username"
                                            >
                                            </el-input>
                                            <div class="badge text-muted">
                                                <small
                                                    >RUC + Usuario. Ejemplo:
                                                    01234567890ELUSUARIO</small
                                                >
                                            </div>
                                            <small
                                                class="text-danger"
                                                v-if="errors.soap_username"
                                                v-text="errors.soap_username[0]"
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.soap_password
                                            }"
                                        >
                                            <label class="control-label"
                                                >SOAP Password
                                                <span class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <el-input
                                                v-model="form.soap_password"
                                            >
                                            </el-input>
                                            <small
                                                class="text-danger"
                                                v-if="errors.soap_password"
                                                v-text="errors.soap_password[0]"
                                            ></small>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div class="row" v-if="form.soap_send_id == '02'">
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.soap_url
                                        }"
                                    >
                                        <label class="control-label"
                                            >SOAP Url</label
                                        >
                                        <el-input v-model="form.soap_url">
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.soap_url"
                                            v-text="errors.soap_url[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions text-end pt-2 pb-2">
                                <el-button
                                    icon="fas fa-save fa-lg"
                                    type="primary"
                                    :loading="loading_submit"
                                    @click="submit()"
                                >
                                    Guardar</el-button
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="text-white my-0">
                                <i class="fas fab fa-whatsapp"></i>
                                Whatsapp Externo
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="url">
                                        URL
                                    </label>
                                    <el-input
                                        v-model="form.api_extern_whatsapp_url"
                                    ></el-input>
                                </div>
                                <div class="col-md-4">
                                    <label for="url">
                                        ID DEVICE
                                    </label>
                                    <el-input
                                        v-model="form.api_extern_whatsapp_token"
                                    ></el-input>
                                </div>
                                <div class="col-md-4">
                                    <label for="url">
                                        API TOKEN
                                    </label>
                                    <el-input
                                        v-model="
                                            form.api_extern_whatsapp_token_2
                                        "
                                    ></el-input>
                                </div>
                            </div>

                            <div class="form-actions text-end pt-2 pb-2">
                                <el-button
                                    icon="fas fa-save fa-lg"
                                    type="primary"
                                    :loading="loading_submit"
                                    @click="submit()"
                                >
                                    Guardar</el-button
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="card-body">
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="border-bottom">
                                                Usuario Secundario Sunat
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                :class="{
                                                    'has-danger':
                                                        errors.soap_sunat_username
                                                }"
                                                class="form-group"
                                            >
                                                <label class="control-label"
                                                    >SOAP Usuario</label
                                                >
                                                <el-input
                                                    v-model="
                                                        form.soap_sunat_username
                                                    "
                                                ></el-input>
                                                <div
                                                    class="sub-title text-muted"
                                                >
                                                    <small
                                                        >RUC + Usuario. Ejemplo:
                                                        20443618687ELUSUARIO</small
                                                    >
                                                </div>
                                                <small
                                                    v-if="
                                                        errors.soap_sunat_username
                                                    "
                                                    class="form-control-feedback"
                                                    v-text="
                                                        errors
                                                            .soap_sunat_username[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                :class="{
                                                    'has-danger':
                                                        errors.soap_sunat_password
                                                }"
                                                class="form-group"
                                            >
                                                <label class="control-label"
                                                    >SOAP Password</label
                                                >
                                                <el-input
                                                    v-model="
                                                        form.soap_sunat_password
                                                    "
                                                ></el-input>
                                                <small
                                                    v-if="
                                                        errors.soap_sunat_password
                                                    "
                                                    class="form-control-feedback"
                                                    v-text="
                                                        errors
                                                            .soap_sunat_password[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div
                                                :class="{
                                                    'has-danger':
                                                        errors.api_sunat_id
                                                }"
                                                class="form-group"
                                            >
                                                <label class="control-label"
                                                    >Client ID</label
                                                >
                                                <el-input
                                                    v-model="form.api_sunat_id"
                                                ></el-input>
                                                <small
                                                    v-if="errors.api_sunat_id"
                                                    class="form-control-feedback"
                                                    v-text="
                                                        errors.api_sunat_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div
                                                :class="{
                                                    'has-danger':
                                                        errors.api_sunat_secret
                                                }"
                                                class="form-group"
                                            >
                                                <label class="control-label"
                                                    >Client Secret
                                                    (Clave)</label
                                                >
                                                <el-input
                                                    v-model="
                                                        form.api_sunat_secret
                                                    "
                                                ></el-input>
                                                <small
                                                    v-if="
                                                        errors.api_sunat_secret
                                                    "
                                                    class="form-control-feedback"
                                                    v-text="
                                                        errors
                                                            .api_sunat_secret[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-right pt-2">
                                    <el-button
                                        icon="fas fa-save"
                                        :loading="loading_submit"
                                        native-type="submit"
                                        type="primary"
                                    >
                                        Guardar
                                    </el-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Establecimientos  -->
                <div class="card-body">
                    <establishments-index
                        :configuration="configuration"
                        :soap_type_id="form.soap_type_id"
                    ></establishments-index>
                </div>

                <!-- <br>
            <establishments-index :configuration="configuration" :soap_type_id="form.soap_type_id"></establishments-index> -->
            </div>
        </div>
    </div>
</template>

<style>
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

/* ****************** Fin Gradiente */
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
            toggle: false //Creando el objeto a retornar con v-model
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
                                const response = await this.$http.post(
                                    "/companies/uploads",
                                    formData,
                                    {
                                        headers: this.headers
                                    }
                                );

                                if (response.data.success) {

                                    // Asegurarse de que la URL de la imagen sea correcta y única para evitar problemas de caché
                                    this.form[field] = `${
                                        response.data.name
                                    }?timestamp=${new Date().getTime()}`;
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
                });
        },
        removeSameRuc(id) {
            this.$http
                .delete(`/companies/remove_same_ruc/${id}`)
                .then(response => {
                    if (response.data.success) {
                        this.getTables();
                        this.same_ruc_id = null;
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
                    return this.$toast.warning(`No puede ser un campo vacio`);
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
                            this.$toast.warning(
                                `El número ${number} es incorrecto`
                            );
                        }
                    } else {
                        this.$toast.error(
                            "Ocurrió un error al buscar: " + number
                        );
                    }
                } catch (e) {
                    console.log(e);
                    this.$toast.error("Ocurrió un error ");
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
        submit() {
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error.response.data.errors.name[0]);
                        this.$toast.error(error.response.data.errors.name[0]);
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
