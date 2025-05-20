<!-- Crear y Editar Productos Principal -->
<template>
    <el-dialog
        width="80%"
        :title="titleDialog"
        :visible="showDialog"
        :close-on-click-modal="false"
        @close="close"
        @open="create"
        append-to-body
        top="2vh"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body p-2">
                <!-- Panel General -->
                <el-tabs
                    tab-position="top"
                    v-model="activeTab"
                    class="card-body"
                >
                    <el-tab-pane label="General" name="general">
                        <!-- Primer bloque de fila-->
                        <div class="container">
                            <div class="row">
                                <!-- Apartado de Código  Nombre y Almacén-->
                                <div class="col-9">
                                    <div class="row col-12">
                                        <!-- Código Interno -->
                                        <div class="col-12 col-lg-6 col-xl-4">
                                            <div
                                                class="form-group"
                                                :class="{
                                                    'has-danger':
                                                        errors.internal_id
                                                }"
                                            >
                                                <label class="control-label">
                                                    <i
                                                        class="fas fa-barcode"
                                                    ></i>
                                                    <i class="fas fa-key"></i>
                                                    Código Interno
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Código interno de la empresa para el control de sus productos"
                                                        placement="top-start"
                                                    >
                                                        <i
                                                            class="fas fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </label>

                                                <el-input
                                                    ref="internal_id"
                                                    v-model="form.internal_id"
                                                    dusk="internal_id"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i>
                                                </el-input>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.internal_id"
                                                    v-text="
                                                        errors.internal_id[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                        <!-- Código Externo -->
                                        <div
                                            class="col-12 col-lg-6 col-xl-4"
                                            v-if="
                                                configuration.show_second_name_external_code
                                            "
                                        >
                                            <div
                                                class="form-group"
                                                :class="{
                                                    'has-danger': errors.barcode
                                                }"
                                            >
                                                <label class="control-label">
                                                    <i
                                                        class="fas fa-qrcode"
                                                    ></i>
                                                    Código Externo
                                                    <el-tooltip
                                                        content="Código interno de la empresa para el control de sus productos"
                                                        placement="top-start"
                                                    >
                                                        <i
                                                            class="fas fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-input
                                                    v-model="form.barcode"
                                                    dusk="barcode"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i>
                                                </el-input>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.barcode"
                                                    v-text="errors.barcode[0]"
                                                ></small>
                                            </div>
                                        </div>
                                        <!-- Código Origen -->
                                        <div
                                            class="col-12 col-lg-6 col-xl-4"
                                            v-if="configuration.origin"
                                        >
                                            <div
                                                class="form-group"
                                                :class="{
                                                    'has-danger': errors.origin
                                                }"
                                            >
                                                <label class="control-label">
                                                    <i class="fas fa-globe"></i>
                                                    Código Origen
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Código Barra de la empresa para el control de sus productos"
                                                        placement="top-start"
                                                    >
                                                        <i
                                                            class="fas fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-input
                                                    v-model="form.origin"
                                                    dusk="barcode"
                                                >
                                                    <i
                                                        slot="prefix"
                                                        class="el-icon-edit-outline"
                                                    ></i>
                                                </el-input>
                                                <small
                                                    class="text-danger"
                                                    v-if="errors.origin"
                                                    v-text="errors.origin[0]"
                                                ></small>
                                            </div>
                                        </div>
                                        <!-- Nombre y Servicio -->
                                        <div class="col-12">
                                            <div
                                                :class="
                                                    `col-12 col-lg-12 ${
                                                        configuration.show_second_name_external_code
                                                            ? 'col-xl-12'
                                                            : 'col-xl-12'
                                                    }`
                                                "
                                            >
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.description
                                                    }"
                                                >
                                                    <label
                                                        class="control-label font-weight-bold"
                                                    >
                                                        <i
                                                            class="fas fa-tag"
                                                        ></i>
                                                        Nombre/Servicio
                                                        <el-tooltip
                                                            content="Campo Obligatorio, aqui se ingresa el nombre del producto o servicio"
                                                        >
                                                            <span
                                                                class="text-danger"
                                                            >
                                                                <i
                                                                    class="fas fa-exclamation-circle"
                                                                ></i>
                                                            </span>
                                                        </el-tooltip>
                                                    </label>

                                                    <el-input
                                                        v-model="
                                                            form.description
                                                        "
                                                        @input="
                                                            handleDescriptionInput
                                                        "
                                                        ref="descriptionInput"
                                                        dusk="description"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-icon-edit-outline"
                                                        ></i>
                                                    </el-input>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.description
                                                        "
                                                        v-text="
                                                            errors
                                                                .description[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                        </div>
                                        <template>
                                            <div class="row align-items-start">
                                                <!-- Nombre Secundario -->
                                                <div
                                                    class="col-md-6 px-2"
                                                    v-if="
                                                        configuration.show_second_name_external_code
                                                    "
                                                >
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.second_name
                                                        }"
                                                    >
                                                        <label
                                                            class="control-label"
                                                        >
                                                            <i
                                                                class="fas fa-user-tag"
                                                            ></i>
                                                            <i
                                                                class="fas fa-tag"
                                                            ></i>
                                                            Nombre Secundario
                                                        </label>

                                                        <el-input
                                                            @input="
                                                                value =>
                                                                    (form.second_name = value.toUpperCase())
                                                            "
                                                            v-model="
                                                                form.second_name
                                                            "
                                                            dusk="second_name"
                                                        >
                                                            <i
                                                                slot="prefix"
                                                                class="el-icon-edit-outline"
                                                            ></i>
                                                        </el-input>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.second_name
                                                            "
                                                            v-text="
                                                                errors
                                                                    .second_name[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>

                                                <!-- Almacenes -->
                                                <div
                                                    class="col-md-6 px-2"
                                                    v-if="recordId == null"
                                                >
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.warehouse_id
                                                        }"
                                                    >
                                                        <label
                                                            class="control-label d-flex align-items-center"
                                                        >
                                                            <i
                                                                class="fas fa-warehouse red-icon fa-lg me-1"
                                                            ></i>
                                                            Almacén
                                                            <el-tooltip
                                                                class="item ms-2"
                                                                effect="dark"
                                                                content="Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento"
                                                                placement="top"
                                                            >
                                                                <i
                                                                    class="fas fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-select
                                                            :disabled="
                                                                allEstablishment
                                                            "
                                                            @change="
                                                                changeWarehouse
                                                            "
                                                            v-model="
                                                                form.warehouse_id
                                                            "
                                                            class="full-width-select"
                                                        >
                                                            <el-option
                                                                v-for="option in warehouses"
                                                                :key="option.id"
                                                                :value="
                                                                    option.id
                                                                "
                                                                :label="
                                                                    option.description
                                                                "
                                                            >
                                                            </el-option>
                                                        </el-select>
                                                        <small v-if="!recordId">
                                                            <el-checkbox
                                                                v-model="
                                                                    allEstablishment
                                                                "
                                                            >
                                                                Todos los
                                                                almacenes</el-checkbox
                                                            >
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <!-- Apartado Imagen -->
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Imagen
                                            <span class="text-danger"></span>
                                        </label>
                                        <el-upload
                                            class="avatar-uploader"
                                            :data="{ type: 'items' }"
                                            :headers="headers"
                                            :action="`/${resource}/uploads`"
                                            :show-file-list="false"
                                            :on-success="onSuccess"
                                        >
                                            <img
                                                v-if="form.image_url"
                                                :src="form.image_url"
                                                class="avatar"
                                            />
                                            <i
                                                v-else
                                                class="el-icon-plus avatar-uploader-icon"
                                            ></i>
                                        </el-upload>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- segundo bloque de fila-->
                        <div class="container">
                            <div class="row">
                                <!-- Categoría -->
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.category_id
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-baseline justify-content-between"
                                        >
                                            <span
                                                ><i class="fas fa-folder"></i>
                                                Categoría</span
                                            >
                                            <div class="btn-group">
                                                <!-- Modificar los botones para usar los nuevos métodos -->
                                                <!-- Para Categoría -->
                                                <button
                                                    type="button"
                                                    v-if="!form_category.add"
                                                    class="btn btn-sm btn-primary btn-circle mx-1"
                                                    @click="
                                                        activateCategoryForm
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-plus-circle"
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    v-if="form_category.add"
                                                    class="btn btn-sm btn-success btn-circle mx-1"
                                                    @click="saveCategoryForm"
                                                >
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    v-if="form_category.add"
                                                    class="btn btn-sm btn-danger btn-circle mx-1"
                                                    @click="cancelCategoryForm"
                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </label>

                                        <el-input
                                            v-if="form_category.add"
                                            ref="categoryInput"
                                            @input="
                                                value =>
                                                    (form_category.name = value.toUpperCase())
                                            "
                                            v-model="form_category.name"
                                            placeholder="Ingrese el nombre de la categoría"
                                        ></el-input>

                                        <el-select
                                            v-if="!form_category.add"
                                            v-model="form.category_id"
                                            filterable
                                            clearable
                                        >
                                            <el-option
                                                v-for="option in categories"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.name"
                                            ></el-option>
                                        </el-select>

                                        <small
                                            class="text-danger"
                                            v-if="errors.category_id"
                                            v-text="errors.category_id[0]"
                                        ></small>
                                    </div>
                                </div>

                                <!-- Marca -->
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.brand_id
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-baseline justify-content-between"
                                        >
                                            <span
                                                ><i class="fas fa-tags"></i>
                                                Marca</span
                                            >
                                            <div class="btn-group">
                                                <!-- Modificar los botones para usar los nuevos métodos -->
                                                <!-- Para Marca -->
                                                <button
                                                    type="button"
                                                    v-if="!form_brand.add"
                                                    class="btn btn-sm btn-primary btn-circle mx-1"
                                                    @click="activateBrandForm"
                                                >
                                                    <i
                                                        class="fas fa-plus-circle"
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    v-if="form_brand.add"
                                                    class="btn btn-sm btn-success btn-circle mx-1"
                                                    @click="saveBrandForm"
                                                >
                                                    <i class="fas fa-save"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    v-if="form_brand.add"
                                                    class="btn btn-sm btn-danger btn-circle mx-1"
                                                    @click="cancelBrandForm"
                                                >
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </label>

                                        <el-input
                                            v-if="form_brand.add"
                                            ref="brandInput"
                                            @input="
                                                value =>
                                                    (form_brand.name = value.toUpperCase())
                                            "
                                            v-model="form_brand.name"
                                            placeholder="Ingrese el nombre de la marca"
                                        ></el-input>

                                        <el-select
                                            v-if="!form_brand.add"
                                            v-model="form.brand_id"
                                            filterable
                                            clearable
                                        >
                                            <el-option
                                                v-for="option in brands"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.name"
                                            ></el-option>
                                        </el-select>

                                        <small
                                            class="text-danger"
                                            v-if="errors.brand_id"
                                            v-text="errors.brand_id[0]"
                                        ></small>
                                    </div>
                                </div>
                                <!-- Modelo -->
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-baseline"
                                        >
                                            <span
                                                ><i class="fas fa-box-open"></i>
                                                Modelo</span
                                            >
                                        </label>
                                        <el-input
                                            v-model="form.model"
                                        ></el-input>
                                    </div>
                                </div>

                                <!-- Calidad -->
                                <div
                                    class="col-12 col-lg-6 col-xl-3 px-2"
                                    v-if="form.unit_type_id != 'ZZ'"
                                >
                                    <div class="form-group">
                                        <label class="control-label">
                                            <!-- <i class="fa fa-motorcycle fa-lg"></i> -->
                                            Calidad
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Aquí se agrega la Calidad de Producto"
                                                placement="top"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            v-model="form.quality"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- tercer bloque de fila-->
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Afectación -->
                                <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.sale_affectation_igv_type_id
                                        }"
                                    >
                                        <label class="control-label"
                                            >Afectación</label
                                        >
                                        <el-select
                                            v-model="
                                                form.sale_affectation_igv_type_id
                                            "
                                            @change="changeAffectationIgvType"
                                        >
                                            <el-option
                                                v-for="option in affectation_igv_types"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.description"
                                            >
                                            </el-option>
                                        </el-select>
                                        <small v-if="show_has_igv">
                                            <el-checkbox v-model="form.has_igv">
                                                Incluye Igv
                                                {{ configuration.include_igv }}
                                            </el-checkbox>
                                        </small>
                                    </div>
                                </div>
                                <!-- Moneda -->
                                <div class="col-12 col-lg-6 col-xl-3 px-2">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.currency_type_id
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i class="fas fa-coins me-2"></i>
                                            Moneda
                                        </label>
                                        <el-select
                                            v-model="form.currency_type_id"
                                            dusk="currency_type_id"
                                            class="uniform-input"
                                        >
                                            <el-option
                                                v-for="option in currency_types"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.description"
                                            >
                                            </el-option>
                                        </el-select>
                                        <small
                                            class="text-danger"
                                            v-if="errors.currency_type_id"
                                            v-text="errors.currency_type_id[0]"
                                        >
                                        </small>
                                    </div>
                                </div>
                                <!-- Precio de Venta -->
                                <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.sale_unit_price
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i class="fa fa-tag fa-lg me-1"></i>
                                            P. Venta
                                            <el-tooltip
                                                class="ms-2"
                                                content="Campo Obligatorio, aquí se ingresa el precio unitario de venta"
                                            >
                                                <span class="text-danger">
                                                    <i
                                                        class="fas fa-exclamation-circle"
                                                    ></i>
                                                </span>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            v-model="form.sale_unit_price"
                                            dusk="sale_unit_price"
                                            @input="
                                                calculatePercentageOfProfitBySale
                                            "
                                        >
                                            <i
                                                slot="prefix"
                                                class="el-icon-edit-outline"
                                            ></i>
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.sale_unit_price"
                                            v-text="errors.sale_unit_price[0]"
                                        >
                                        </small>
                                    </div>
                                </div>

                                <!-- Delivery -->
                                <div
                                    class="col-xl-3 col-lg-4 col-md-6 px-2"
                                    v-if="form.unit_type_id != 'ZZ'"
                                >
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i
                                                class="fa fa-motorcycle fa-lg me-1"
                                            ></i>
                                            Add. Delivery
                                            <el-tooltip
                                                class="ms-2"
                                                effect="dark"
                                                content="Valor agregado en SOLES al enviar el producto por delivery"
                                                placement="top"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            v-model="form.delivery_cost"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- cuarto bloque de fila-->
                        <div class="container">
                            <div class="row">
                                <!-- Zona -->
                                <div class="col-12 col-lg-6 col-xl-3 px-2">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger':
                                                errors.sale_affectation_igv_type_id
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i
                                                class="fas fa-map-marker-alt me-2"
                                            ></i>
                                            Zona
                                            <el-tooltip
                                                class="ms-2"
                                                effect="dark"
                                                content="Lugar en donde se despacha e iprime el producto "
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-select
                                            v-model="form.area_id"
                                            class="uniform-input"
                                        >
                                            <el-option
                                                v-for="option in areas"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.description"
                                            >
                                            </el-option>
                                        </el-select>
                                        <small
                                            class="form-control-feedback"
                                            v-if="
                                                errors.sale_affectation_igv_type_id
                                            "
                                            v-text="
                                                errors
                                                    .sale_affectation_igv_type_id[0]
                                            "
                                        >
                                        </small>
                                    </div>
                                </div>

                                <!-- Ubicación -->
                                <div class="col-12 col-lg-6 col-xl-3 px-2">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.location
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i
                                                class="fas fa-hand-pointer me-2"
                                            ></i>
                                            Ubicación
                                        </label>
                                        <el-input
                                            v-model="form.location"
                                            dusk="name"
                                            class="uniform-input"
                                        >
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.location"
                                            v-text="errors.location[0]"
                                        >
                                        </small>
                                    </div>
                                </div>

                                <!-- Stock Mínimo -->
                                <div
                                    class="col-12 col-lg-6 col-xl-3 px-2"
                                    v-if="form.unit_type_id != 'ZZ'"
                                >
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.stock_min
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i
                                                class="fa fa-exclamation-circle fa-lg me-2"
                                            ></i>
                                            Stock Mínimo
                                        </label>
                                        <el-input
                                            v-model="form.stock_min"
                                            class="uniform-input"
                                        >
                                            <i
                                                slot="prefix"
                                                class="el-icon-edit-outline"
                                            ></i>
                                        </el-input>
                                        <small
                                            class="text-danger"
                                            v-if="errors.stock_min"
                                            v-text="errors.stock_min[0]"
                                        >
                                        </small>
                                    </div>
                                </div>

                                <!-- Unidad de Medida -->
                                <div class="col-12 col-lg-6 col-xl-3">
                                    <div
                                        class="form-group"
                                        :class="{
                                            'has-danger': errors.unit_type_id
                                        }"
                                    >
                                        <label
                                            class="control-label d-flex align-items-baseline"
                                        >
                                            <span
                                                ><i class="fas fa-ruler"></i>
                                                Unidad Medida</span
                                            >
                                        </label>
                                        <el-select
                                            v-model="form.unit_type_id"
                                            dusk="unit_type_id"
                                        >
                                            <el-option
                                                v-for="option in unit_types"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.description"
                                            >
                                            </el-option>
                                        </el-select>
                                        <small
                                            class="text-danger"
                                            v-if="errors.unit_type_id"
                                            v-text="errors.unit_type_id[0]"
                                        ></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- quinto bloque de fila-->
                        <div class="container">
                            <div class="row">
                                <!-- Cantidad Máxima -->
                                <div
                                    class="col-12 col-lg-6 col-xl-3 px-2"
                                    v-if="
                                        form.unit_type_id != 'ZZ' &&
                                            !form.has_color_size
                                    "
                                >
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i
                                                class="fa fa-tachometer-alt fa-lg me-2"
                                            ></i>
                                            Cant.Máx
                                            <el-tooltip
                                                class="ms-2"
                                                effect="dark"
                                                content="La cantidad máxima representada en el envase/contenedor"
                                                placement="top"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            :disabled="
                                                form.item_unit_types.length != 0
                                            "
                                            v-model="form.max_quantity"
                                            class="uniform-input"
                                        >
                                        </el-input>
                                    </div>
                                </div>

                                <!-- Contenedor de Productos -->
                                <div
                                    class="col-12 col-lg-6 col-xl-3 px-2"
                                    v-if="
                                        form.unit_type_id != 'ZZ' &&
                                            !form.has_color_size
                                    "
                                >
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i class="fa fa-box fa-lg me-2"></i>
                                            Contenedor
                                            <el-tooltip
                                                class="ms-2"
                                                effect="dark"
                                                content="Nombre del contenedor de la cantidad máxima Ej. Botella(s), Caja(s), Saco(s)"
                                                placement="top"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-input
                                            :disabled="
                                                form.max_quantity == 0 ||
                                                    form.max_quantity == null
                                            "
                                            v-model="
                                                form.max_quantity_description
                                            "
                                            class="uniform-input"
                                        >
                                        </el-input>
                                    </div>
                                </div>

                                <!-- Peso -->
                                <div
                                    class="col-12 col-lg-6 col-xl-3 px-2"
                                    v-if="configuration.consolidated_quotations"
                                >
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i class="fa fa-box fa-lg me-2"></i>
                                            Peso
                                        </label>
                                        <el-input
                                            v-model="form.weight"
                                            class="uniform-input"
                                        >
                                        </el-input>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-3 px-2">
                                    <div class="form-group">
                                        <label
                                            class="control-label d-flex align-items-center"
                                        >
                                            <i class="fa fa-box fa-lg me-2"></i>
                                            Comision por producto
                                        </label>
                                        <el-input
                                            v-model="form.commission"
                                            class="uniform-input"
                                        >
                                        </el-input>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <!-- Columna 1 - Sujeto a Detracción y Se Fabrica -->
                                <div class="col-md-3">
                                    <div
                                        class="form-group"
                                        v-if="configuration.detraction"
                                    >
                                        <el-checkbox
                                            v-model="form.subject_to_detraction"
                                            style="color: black;"
                                        >
                                            Sujeto a Detracción
                                        </el-checkbox>
                                    </div>
                                    <div
                                        class="form-group"
                                        v-if="configuration.transform_item"
                                    >
                                        <el-checkbox
                                            v-model="form.is_manufactured"
                                            style="color: black;"
                                        >
                                            ¿Se fabrica?
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Aquí se indica si el Producto es Principal para TRANSFORMACIÓN"
                                                placement="top"
                                            >
                                                <i
                                                    class="fas fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </el-checkbox>
                                    </div>
                                </div>

                                <!-- Columna 2 - Maneja series, Maneja lotes, Talla y Color -->
                                <div class="col-md-9">
                                    <div class="d-flex flex-wrap">
                                        <!-- Maneja Series -->
                                        <div
                                            class="col-12 col-lg-4 col-xl-3"
                                            v-if="configuration.series_enabled"
                                        >
                                            <div
                                                v-if="form.unit_type_id != 'ZZ'"
                                                class="col-md-3 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        v-model="
                                                            form.series_enabled
                                                        "
                                                        @change="
                                                            changeLotsEnabled
                                                        "
                                                        style="color: black;"
                                                    >
                                                        Series
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Agregar Series"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </el-checkbox>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Maneja Lotes -->
                                        <div
                                            class="col-12 col-lg-4 col-xl-3"
                                            v-if="configuration.lots_enabled"
                                        >
                                            <div
                                                v-if="form.unit_type_id != 'ZZ'"
                                                class="col-md-3 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        v-model="
                                                            form.lots_enabled
                                                        "
                                                        @change="
                                                            changeLotsEnabled
                                                        "
                                                        style="color: black;"
                                                    >
                                                        Lotes
                                                    </el-checkbox>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Maneja Color y Talla -->
                                        <div
                                            class="col-12 col-lg-4 col-xl-3"
                                            v-if="
                                                configuration.color_size_enabled
                                            "
                                        >
                                            <div
                                                v-if="form.unit_type_id != 'ZZ'"
                                                class="col-md-4 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        :disabled="
                                                            recordId != null
                                                        "
                                                        v-model="
                                                            form.has_color_size
                                                        "
                                                        style="color: black;"
                                                    >
                                                        Talla y Color
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Ingresa talla y color del producto"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </el-checkbox>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Columna de promoción -->
                                        <div
                                            class="col-xl-2 col-lg-4"
                                            v-if="configuration.promotions_sell"
                                        >
                                            <div
                                                v-if="form.unit_type_id != 'ZZ'"
                                                class="col-md-3 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        v-model="
                                                            form.is_promotion
                                                        "
                                                        style="color: black;"
                                                    >
                                                        Promoción
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Ingrese cantidad Promoción"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </el-checkbox>
                                                </div>
                                            </div>
                                            <div
                                                class="col-xl-6 col-lg-12"
                                                v-if="
                                                    form.unit_type_id != 'ZZ' &&
                                                        form.is_promotion
                                                "
                                            >
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.promotion_count
                                                    }"
                                                >
                                                    <el-input
                                                        v-model="
                                                            form.promotion_count
                                                        "
                                                        type="number"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-icon-edit-outline"
                                                        ></i>
                                                    </el-input>
                                                    <small
                                                        class="text-danger"
                                                        v-if="
                                                            errors.promotion_count
                                                        "
                                                        v-text="
                                                            errors
                                                                .promotion_count[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                configuration.warranty_product
                                            "
                                            class="col-12 col-lg-6 col-xl-3"
                                        >
                                            <div
                                                v-if="form.unit_type_id != 'ZZ'"
                                                class="col-md-3 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        v-model="
                                                            form.has_warranty
                                                        "
                                                        @change="
                                                            changeHasWarranty
                                                        "
                                                        >¿Tiene
                                                        Garantia?</el-checkbox
                                                    >
                                                    <br />
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-12"
                                                v-if="
                                                    form.unit_type_id != 'ZZ' &&
                                                        form.has_warranty
                                                "
                                            >
                                                <div
                                                    class="form-group"
                                                    :class="{
                                                        'has-danger':
                                                            errors.month_day
                                                    }"
                                                >
                                                    <label class="control-label"
                                                        >Meses Garantia
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Ingresa el numero de meses de garantia"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-input
                                                        v-model="form.month_day"
                                                        type="number"
                                                    >
                                                        <i
                                                            slot="prefix"
                                                            class="el-icon-edit-outline"
                                                        ></i>
                                                    </el-input>
                                                    <small
                                                        class="text-danger"
                                                        v-if="errors.month_day"
                                                        v-text="
                                                            errors.month_day[0]
                                                        "
                                                    ></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-xl-3">
                                            <div
                                                v-if="
                                                    form.unit_type_id != 'ZZ' &&
                                                        typeUser ===
                                                            'superadmin'
                                                "
                                                class="col-md-4 center-el-checkbox"
                                            >
                                                <div class="form-group">
                                                    <el-checkbox
                                                        v-model="
                                                            form.init_report
                                                        "
                                                        style="color: black;"
                                                    >
                                                        Ver Reporte de stock en
                                                        el roporte de cierre de
                                                        caja
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="aqui cuando se activa esta opcion el producto se visualizara en el reporte de ciere de caja se podra ver los productos con estock de venta cuanto se vendio durante el dia y cuanto sobro"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </el-checkbox>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12"></div>
                            <div class="row col-md-12">
                                <!-- Atributos -->
                                <div
                                    v-if="attribute_types.length > 0"
                                    class="col-12 col-lg-12 col-xl-12"
                                >
                                    <h6 class="separator-title">
                                        Atributos
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Diferentes presentaciones para la venta del producto"
                                            placement="top"
                                        >
                                            <i class="fas fa-info-circle"></i>
                                        </el-tooltip>
                                        <a
                                            href="#"
                                            class="control-label font-weight-bold text-info"
                                            @click.prevent="clickAddAttribute"
                                            >[+ Agregar]</a
                                        >
                                    </h6>

                                    <div v-if="form.attributes.length > 0">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr
                                                        slot="heading"
                                                        class="bg-primary"
                                                    >
                                                        <th class="text-white">
                                                            Tipo
                                                        </th>
                                                        <th class="text-white">
                                                            Descripción
                                                        </th>
                                                        <th
                                                            class="text-white"
                                                        ></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(row,
                                                        index) in form.attributes"
                                                        :key="index"
                                                    >
                                                        <td>
                                                            <el-select
                                                                v-model="
                                                                    row.attribute_type_id
                                                                "
                                                                filterable
                                                                @change="
                                                                    changeAttributeType(
                                                                        index
                                                                    )
                                                                "
                                                            >
                                                                <el-option
                                                                    v-for="option in attribute_types"
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
                                                        </td>
                                                        <td>
                                                            <el-input
                                                                v-model="
                                                                    row.value
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </td>
                                                        <td>
                                                            <button
                                                                type="button"
                                                                class="btn btn-danger"
                                                                @click.prevent="
                                                                    clickRemoveAttribute(
                                                                        index
                                                                    )
                                                                "
                                                            >
                                                                x
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botones de Guardar y Candelar dentro del tab-pane -->
                    </el-tab-pane>

                    <!-- Almacenes  -->
                    <el-tab-pane label="Almacenes" name="warehouses">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="separator-title mt-0">
                                    <strong>Precios por Almacén</strong>
                                </h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Almacén</th>
                                                <th>Precio Venta</th>
                                                <th
                                                    v-if="
                                                        form.unit_type_id !=
                                                            'ZZ'
                                                    "
                                                >
                                                    Stock Inicial
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="warehouse in warehouses"
                                                :key="warehouse.id"
                                            >
                                                <td>
                                                    {{ warehouse.description }}
                                                </td>
                                                <td>
                                                    <el-input
                                                        v-model="
                                                            getPriceForWarehouse(
                                                                warehouse.id
                                                            ).price
                                                        "
                                                        type="number"
                                                        step="0.01"
                                                        placeholder="Precio de venta"
                                                    >
                                                        <template slot="prepend"
                                                            >S/.</template
                                                        >
                                                    </el-input>
                                                </td>
                                                <td
                                                    v-if="
                                                        form.unit_type_id !=
                                                            'ZZ'
                                                    "
                                                >
                                                    <el-input
                                                        v-model="
                                                            getStockForWarehouse(
                                                                warehouse.id
                                                            ).stock
                                                        "
                                                        :disabled="!!recordId"
                                                        min="0"
                                                        @input="
                                                            calculateTotalStock
                                                        "
                                                        placeholder="Stock inicial"
                                                    >
                                                        <template
                                                            slot="append"
                                                        ></template>
                                                    </el-input>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot v-if="form.unit_type_id != 'ZZ'">
                                            <tr>
                                                <td
                                                    colspan="2"
                                                    class="text-end"
                                                >
                                                    <strong
                                                        >Stock Total:</strong
                                                    >
                                                </td>
                                                <td>
                                                    <strong
                                                        >{{ totalStock }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- Botones de Guardar y Candelar dentro del tab-pane -->
                        </div>
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="configuration.quantity_prices"
                        label="Precios por rango de cantidad"
                        name="price-ranges"
                    >
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                <a
                                                    href="#"
                                                    class="control-label font-weight-bold text-info"
                                                    @click.prevent="
                                                        addPriceRange
                                                    "
                                                    >[ + Nuevo]</a
                                                >
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row,
                                            index) in form.item_price_ranges"
                                            :key="index"
                                        >
                                            <td>
                                                <el-input
                                                    v-model="row.quantity_min"
                                                ></el-input>
                                            </td>
                                            <td>
                                                <el-input
                                                    v-model="row.price"
                                                ></el-input>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-danger"
                                                    @click.prevent="
                                                        clickDeletePriceRange(
                                                            index
                                                        )
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Lista de Precios" name="price-list">
                        <div class="row">
                            <div
                                v-if="form.unit_type_id != 'ZZ'"
                                class="col-md-12"
                            >
                                <h6 class="separator-title">
                                    <i
                                        class="fa-solid fa-money-bill-transfer"
                                    ></i>
                                    Política de precios
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades"
                                        placement="top"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </el-tooltip>
                                    <a
                                        href="#"
                                        class="control-label font-weight-bold text-info"
                                        @click="clickAddRow"
                                        >[ + Nuevo]</a
                                    >
                                </h6>
                            </div>
                            <div
                                v-if="
                                    form.unit_type_id != 'ZZ' &&
                                        form.item_unit_types.length > 0
                                "
                                class="col-md-12"
                            >
                                <div class="price-policy-table-wrapper">
                                    <table
                                        class="table table-striped price-policy-table"
                                    >
                                        <thead>
                                            <tr
                                                slot="heading"
                                                class="bg-primary"
                                            >
                                                <th class="text-white" v-if="configuration.unit_type_select_barcode">
                                                    Codigo de politica
                                                </th>
                                                <th
                                                    width="12%"
                                                    class="text-white text-center"
                                                >
                                                    Unidad de
                                                    <br />Medida
                                                </th>
                                                <th
                                                    width="20%"
                                                    class="text-white text-center"
                                                >
                                                    Descripción
                                                </th>
                                                <th
                                                    width="8%"
                                                    class="text-white text-center"
                                                >
                                                    Cantidad
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Cantidad de unidades"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fas fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </th>
                                                <th
                                                    width="8%"
                                                    class="text-white text-center"
                                                >
                                                    Precio
                                                    <br />unitario 1
                                                </th>
                                                <template
                                                    v-if="
                                                        configuration.price_item_unit_type
                                                    "
                                                >
                                                    <th
                                                        width="8%"
                                                        class="text-white text-center"
                                                    >
                                                        Precio
                                                        <br />unitario 2
                                                    </th>
                                                    <th
                                                        width="8%"
                                                        class="text-white text-center"
                                                    >
                                                        Precio
                                                        <br />unitario 3
                                                    </th>
                                                </template>
                                                <th
                                                    width="8%"
                                                    class="text-white text-center"
                                                    v-if="
                                                        !configuration.price_item_unit_type
                                                    "
                                                >
                                                    Total
                                                </th>
                                                <template
                                                    v-if="
                                                        configuration.price_item_unit_type
                                                    "
                                                >
                                                    <th
                                                        width="8%"
                                                        class="text-white text-center"
                                                    >
                                                        Precio x defecto
                                                    </th>
                                                </template>
                                                <th
                                                    class="text-white text-center"
                                                >
                                                    Almacén
                                                </th>

                                                <th class="text-white">
                                                    MAX
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Check para indicar que es la Maxima cantdad en su presentación"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fas fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(row,
                                                index) in form.item_unit_types"
                                                :key="index"
                                            >
                                                <template v-if="row.id">
                                                    <td v-if="configuration.unit_type_select_barcode">
                                                        <div class="form-group">
                                                            <el-input
                                                                v-model="
                                                                    row.unique_code
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ row.unit_type_id }}
                                                    </td>
                                                    <!-- <td class="text-center">
                                                    {{ row.description }}
                                                    </td> -->
                                                    <td>
                                                        <el-input
                                                            v-model="
                                                                row.description
                                                            "
                                                        >
                                                            <i
                                                                slot="prefix"
                                                                class="el-icon-edit-outline"
                                                            ></i>
                                                        </el-input>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ row.quantity_unit }}
                                                    </td>
                                                    <template
                                                        v-if="
                                                            configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.price1
                                                                "
                                                            ></el-input>
                                                        </td>
                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.price2
                                                                "
                                                            ></el-input>
                                                        </td>
                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.price3
                                                                "
                                                            ></el-input>
                                                        </td>
                                                    </template>
                                                    <template v-else>
                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.price2
                                                                "
                                                                @input="
                                                                    undToTotal(
                                                                        index,
                                                                        row.price2,
                                                                        row.quantity_unit
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </td>
                                                    </template>

                                                    <td
                                                        class="text-center"
                                                        v-if="
                                                            !configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <el-input
                                                            v-model="row.total"
                                                            @input="
                                                                totalToUnd(
                                                                    index,
                                                                    row.total,
                                                                    row.quantity_unit
                                                                )
                                                            "
                                                            type="number"
                                                            step="0.01"
                                                            pattern="^\d*(\.\d{0,2})?$"
                                                        >
                                                            <i
                                                                slot="prefix"
                                                                class="el-icon-edit-outline"
                                                            ></i>
                                                        </el-input>
                                                    </td>
                                                    <template
                                                        v-if="
                                                            configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <td>
                                                            <el-select
                                                                v-model="
                                                                    row.price_default
                                                                "
                                                            >
                                                                <el-option
                                                                    value="1"
                                                                    >Precio
                                                                    1</el-option
                                                                >
                                                                <el-option
                                                                    value="2"
                                                                    >Precio
                                                                    2</el-option
                                                                >
                                                                <el-option
                                                                    value="3"
                                                                    >Precio
                                                                    3</el-option
                                                                >
                                                            </el-select>
                                                        </td>
                                                    </template>
                                                    <td>
                                                        <el-select
                                                            clearable
                                                            v-model="
                                                                row.warehouse_id
                                                            "
                                                        >
                                                            <el-option
                                                                v-for="w in warehouses"
                                                                :key="w.id"
                                                                :value="w.id"
                                                                :label="
                                                                    w.description
                                                                "
                                                            ></el-option>
                                                        </el-select>
                                                    </td>
                                                    <td class="text-center">
                                                        <el-checkbox
                                                            v-model="
                                                                row.selected
                                                            "
                                                            @change="
                                                                selectedMax(
                                                                    index
                                                                )
                                                            "
                                                        ></el-checkbox>
                                                    </td>

                                                    <td
                                                        class="series-table-actions text-end"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                                            @click.prevent="
                                                                clickDelete(
                                                                    row.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </template>
                                                <template v-else>
                                                    <td>
                                                        <div class="form-group">
                                                            <el-select
                                                                v-model="
                                                                    row.unit_type_id
                                                                "
                                                                dusk="item_unit_type.unit_type_id"
                                                            >
                                                                <el-option
                                                                    v-for="option in unit_types"
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
                                                        <div class="form-group">
                                                            <el-input
                                                                v-model="
                                                                    row.description
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </div>
                                                    </td>

                                                    <template
                                                        v-if="
                                                            configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        row.quantity_unit
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        row.price1
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        row.price2
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        row.price3
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                    </template>
                                                    <template v-else>
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    @input="
                                                                        undToTotal(
                                                                            index,
                                                                            row.price2,
                                                                            row.quantity_unit
                                                                        )
                                                                    "
                                                                    v-model="
                                                                        row.quantity_unit
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    @input="
                                                                        undToTotal(
                                                                            index,
                                                                            row.price2,
                                                                            row.quantity_unit
                                                                        )
                                                                    "
                                                                    v-model="
                                                                        row.price2
                                                                    "
                                                                >
                                                                    <i
                                                                        slot="prefix"
                                                                        class="el-icon-edit-outline"
                                                                    ></i>
                                                                </el-input>
                                                            </div>
                                                        </td>
                                                    </template>

                                                    <td
                                                        v-if="
                                                            !configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <div class="form-group">
                                                            <el-input
                                                                v-model="
                                                                    row.total
                                                                "
                                                                @input="
                                                                    totalToUnd(
                                                                        index,
                                                                        row.total,
                                                                        row.quantity_unit
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </div>
                                                    </td>
                                                    <template
                                                        v-if="
                                                            configuration.price_item_unit_type
                                                        "
                                                    >
                                                        <td>
                                                            <el-select
                                                                v-model="
                                                                    row.price_default
                                                                "
                                                            >
                                                                <el-option
                                                                    value="1"
                                                                    >Precio
                                                                    1</el-option
                                                                >
                                                                <el-option
                                                                    value="2"
                                                                    >Precio
                                                                    2</el-option
                                                                >
                                                                <el-option
                                                                    value="3"
                                                                    >Precio
                                                                    3</el-option
                                                                >
                                                            </el-select>
                                                        </td>
                                                    </template>
                                                    <td>
                                                        <el-select
                                                            clearable
                                                            v-model="
                                                                row.warehouse_id
                                                            "
                                                        >
                                                            <el-option
                                                                v-for="w in warehouses"
                                                                :key="w.id"
                                                                :value="w.id"
                                                                :label="
                                                                    w.description
                                                                "
                                                            ></el-option>
                                                        </el-select>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <el-input
                                                                v-model="
                                                                    row.unique_code
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <el-checkbox
                                                            v-model="
                                                                row.selected
                                                            "
                                                            @change="
                                                                selectedMax(
                                                                    index
                                                                )
                                                            "
                                                        ></el-checkbox>
                                                    </td>
                                                    <td
                                                        class="series-table-actions text-end"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                                            @click.prevent="
                                                                clickCancel(
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </button>
                                                    </td>

                                                    <td
                                                        class="series-table-actions text-end"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="btn waves-effect waves-light btn-sm btn-danger"
                                                            @click.prevent="
                                                                clickCancel(
                                                                    index
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="
                            configuration.quantity_prices &&
                                form.item_unit_types &&
                                form.item_unit_types.length > 0
                        "
                        label="Precios por rango en politica de precio"
                        name="price-range-policy"
                    >
                        <div class="row">
                            <div class="table-responsive">
                                <table
                                    class="table"
                                    v-for="(unit_type,
                                    index) in form.item_unit_types"
                                    :key="index"
                                    v-show="unit_type.description"
                                >
                                    <thead>
                                        <tr>
                                            <th class="text-left" colspan="3">
                                                {{ unit_type.description }}
                                                <a
                                                    href="#"
                                                    class="control-label font-weight-bold text-info"
                                                    @click.prevent="
                                                        addUnitTypePriceRange(
                                                            index
                                                        )
                                                    "
                                                    >[ + Nuevo]</a
                                                >
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(row,
                                            indexx) in unit_type.item_unit_type_price_ranges"
                                            :key="indexx"
                                        >
                                            <td>
                                                <el-input
                                                    v-model="row.quantity_min"
                                                ></el-input>
                                            </td>
                                            <td>
                                                <el-input
                                                    v-model="row.price"
                                                ></el-input>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn waves-effect waves-light btn-sm btn-danger"
                                                    @click.prevent="
                                                        clickDeleteUnitTypePriceRange(
                                                            index,
                                                            indexx
                                                        )
                                                    "
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <template
                        v-if="
                            configuration.consolidated_quotations &&
                                form.item_unit_types &&
                                form.item_unit_types.length > 0
                        "
                    >
                        <el-tab-pane label="Bonificaciones" name="bonus">
                            <div class="row">
                                <div
                                    v-if="form.unit_type_id != 'ZZ'"
                                    class="col-md-12"
                                >
                                    <h6 class="separator-title">
                                        <i
                                            class="fa-solid fa-money-bill-transfer"
                                        ></i>
                                        Bonificaciones de precios
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades"
                                            placement="top"
                                        >
                                            <i class="fas fa-info-circle"></i>
                                        </el-tooltip>
                                    </h6>
                                </div>
                                <div
                                    v-if="
                                        form.unit_type_id != 'ZZ' &&
                                            form.item_unit_types.length > 0
                                    "
                                    class="col-md-12"
                                >
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr
                                                    slot="heading"
                                                    class="bg-primary"
                                                >
                                                    <th
                                                        width="12%"
                                                        class="text-white text-center"
                                                    >
                                                        Unidad de
                                                        <br />Medida
                                                    </th>
                                                    <th
                                                        width="20%"
                                                        class="text-white text-center"
                                                    >
                                                        Descripción
                                                    </th>
                                                    <th
                                                        width="8%"
                                                        class="text-white text-center"
                                                    >
                                                        Cantidad
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Cantidad de unidades"
                                                            placement="top"
                                                        >
                                                            <i
                                                                class="fas fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </th>

                                                    <th
                                                        class="text-white text-center"
                                                    >
                                                        Cant. Min.
                                                    </th>
                                                    <!-- <th class="text-white text-center">Cant. Max.</th> -->
                                                    <th
                                                        class="text-white text-center"
                                                    >
                                                        Cant Bon.
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(row,
                                                    index) in form.item_unit_types"
                                                    :key="index"
                                                >
                                                    <template v-if="row.id">
                                                        <td class="text-center">
                                                            {{
                                                                row.unit_type_id
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{
                                                                row.description
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{
                                                                row.quantity_unit
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.qty_min
                                                                "
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </td>

                                                        <td class="text-center">
                                                            <el-input
                                                                v-model="
                                                                    row.qty_free
                                                                "
                                                                type="number"
                                                                step="1"
                                                                pattern="^\d*(\.\d{0,2})?$"
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </td>
                                                    </template>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </el-tab-pane>
                    </template>
                    <el-tab-pane
                        v-if="configuration.commercial_treatment_items"
                        label="Tratamiento Comercial"
                        name="commercial-treatment"
                    >
                        <div class="row m-2">
                            <table>
                                <tbody>
                                    <tr
                                        v-for="(commercial_treatment_item,
                                        index) in form.commercial_treatments"
                                        :key="`${index}treatment`"
                                    >
                                        <td>
                                            {{
                                                commercial_treatment_item.commercial_treatment_description
                                            }}
                                        </td>
                                        <td width="15%">
                                            <el-input
                                                step="0.01"
                                                @input="
                                                    updateCommercialTreatmentItem(
                                                        index
                                                    )
                                                "
                                                type="number"
                                                v-model="
                                                    commercial_treatment_item.amount
                                                "
                                            ></el-input>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Compras" name="purchases">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger':
                                            errors.purchase_affectation_igv_type_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Tipo de afectación (Compra)</label
                                    >
                                    <el-select
                                        v-model="
                                            form.purchase_affectation_igv_type_id
                                        "
                                    >
                                        <el-option
                                            v-for="option in affectation_igv_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="
                                            errors.purchase_affectation_igv_type_id
                                        "
                                        v-text="
                                            errors
                                                .purchase_affectation_igv_type_id[0]
                                        "
                                    ></small>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.purchase_unit_price
                                    }"
                                >
                                    <label class="control-label"
                                        >Precio Unitario (Compra)</label
                                    >
                                    <el-input
                                        v-model="form.purchase_unit_price"
                                        dusk="purchase_unit_price"
                                        @input="
                                            calculatePercentageOfProfitByPurchase
                                        "
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.purchase_unit_price"
                                        v-text="errors.purchase_unit_price[0]"
                                    ></small>
                                </div>
                            </div>
                            <!-- <div class="short-div col-md-4"> -->
                            <div class="col-12 col-lg-6 col-xl-6">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger':
                                            errors.percentage_of_profit
                                    }"
                                >
                                    <label class="control-label">
                                        <el-checkbox
                                            v-model="
                                                enabled_percentage_of_profit
                                            "
                                            @change="
                                                changeEnabledPercentageOfProfit
                                            "
                                        ></el-checkbox
                                        >Porcentaje de ganancia (%)
                                    </label>
                                    <el-input
                                        v-model="form.percentage_of_profit"
                                        :disabled="
                                            !enabled_percentage_of_profit
                                        "
                                        @input="
                                            calculatePercentageOfProfitByPercentage
                                        "
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.percentage_of_profit"
                                        v-text="errors.percentage_of_profit[0]"
                                    ></small>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>

                    <!-- Categoria madera -->
                    <el-tab-pane
                        label="Categoria Madera"
                        v-if="configuration.maderera"
                        name="wood-category"
                    >
                        <div class="row">
                            <div class="col-12">
                                <h4 class="separator-title mt-0">
                                    <strong>Categoria Madera</strong>
                                </h4>
                                <table>
                                    <tbody>
                                        <tr
                                            v-for="madera in categoria_madera"
                                            :key="madera.id"
                                        >
                                            <td width="60%">
                                                <h5>
                                                    {{ madera.description }}
                                                </h5>
                                            </td>
                                            <td>
                                                <el-input
                                                    v-model="madera.precio"
                                                    @input="maderaUpdate()"
                                                    placeholder="Precio Categoria Madera"
                                                ></el-input>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="configuration.unique_code_unit_types"
                        label="Lista de codigos de barras"
                        name="barcodes"
                    >
                        <div class="row">
                            <div
                                v-if="form.unit_type_id != 'ZZ'"
                                class="col-md-12"
                            >
                                <h6 class="separator-title">
                                    <i
                                        class="fa-solid fa-money-bill-transfer"
                                    ></i>
                                    Codigos de barras
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades"
                                        placement="top"
                                    >
                                        <i class="fas fa-info-circle"></i>
                                    </el-tooltip>
                                    <a
                                        href="#"
                                        class="control-label font-weight-bold text-info"
                                        @click="clickAddBarcode"
                                        >[ + Nuevo]</a
                                    >
                                </h6>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr
                                                slot="heading"
                                                class="bg-primary"
                                            >
                                                <th
                                                    width="20%"
                                                    class="text-white text-center"
                                                >
                                                    Codigo de barras
                                                </th>
                                                <th
                                                    width="20%"
                                                    class="text-white text-center"
                                                >
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(barcode,
                                                index) in form.item_codes"
                                                :key="index"
                                            >
                                                <td>
                                                    <el-input
                                                        v-model="
                                                            barcode.code_barcode
                                                        "
                                                        placeholder="Codigo de barras"
                                                    ></el-input>
                                                </td>
                                                <td>
                                                    <button
                                                        type="button"
                                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                                        @click.prevent="
                                                            clickDeleteBarcode(
                                                                index
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fa fa-trash"
                                                        ></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                    <div
                        class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
                    >
                        <!-- Botón Cancelar -->
                        <el-button
                            class="btn-cancel btn-cancel:hover"
                            icon="fas fa-times fa-lg"
                            @click.prevent="close()"
                        >
                            <span>Cancelar</span>
                        </el-button>
                        <!-- Botón Guardar -->
                        <el-button
                            class="btn-save btn-save:hover"
                            icon="fas fa-save fa-lg"
                            type="primary"
                            native-type="submit"
                        >
                            <span>Guardar</span>
                        </el-button>
                    </div>
                </el-tabs>
            </div>
        </form>
        <!-- <percentage-perception
                          :showDialog.sync="showPercentagePerception"
                          :percentage_perception="percentage_perception">
      </percentage-perception>-->

        <lots-form
            :showDialog.sync="showDialogLots"
            :stock="form.stock"
            :recordId="recordId"
            :lots="form.lots"
            @addRowLot="addRowLot"
        ></lots-form>
        <color-size
            :showDialog.sync="showDialogColorSize"
            :recordId="recordId"
            :colorSizes="form.color_sizes"
            @addRowColorSize="addRowColorSize"
            :stock="form.stock"
        ></color-size>
    </el-dialog>
</template>

<style>
/* .el-dialog {
    border-radius: 10px;
    overflow: hidden;
} */

@media screen and (max-width: 1280px) {
    .label-text {
        display: none;
        /* Oculta el texto del label */
    }
}

.btn-circle {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 0;
}

/* Estilo botón Cancelar */
/* Estilo botón Guardar */
.avatar {
    width: 100%;
    /* Ocupar todo el ancho del contenedor */
    height: 100%;
    /* Ocupar todo el alto del contenedor */
    object-fit: contain;
    /* Mantener la proporción de la imagen */
    display: block;
    /* Asegurar que no haya espacio extra alrededor de la imagen */
    margin: 0 auto;
    /* Centrar la imagen dentro del contenedor */
    border-radius: 10px;
    /* Opcional: Bordes redondeados para darle un toque más profesional */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
}

.avatar-uploader {
    width: 100%;
    /* Hacer que el uploader ocupe todo el espacio disponible */
    height: 200px;
    /* Altura fija para el uploader (ajustable según el diseño) */
    border: 2px dashed #d9d9d9;
    /* Borde estilo dashed */
    border-radius: 10px;
    /* Bordes redondeados */
    display: flex;
    align-items: center;
    /* Centrar contenido verticalmente */
    justify-content: center;
    /* Centrar contenido horizontalmente */
    background-color: #f9f9f9;
    /* Fondo claro para el uploader */
    transition: background-color 0.3s;
    /* Transición suave al pasar el mouse */
}

.avatar-uploader:hover {
    background-color: #f0f0f0;
    /* Fondo ligeramente más oscuro al pasar el mouse */
}

.avatar-uploader-icon {
    font-size: 2em;
    /* Tamaño del ícono */
    color: #999;
    /* Color del ícono */
    transition: color 0.3s;
    /* Transición suave del color */
}

.avatar-uploader:hover .avatar-uploader-icon {
    color: #666;
    /* Cambiar a un color más oscuro al pasar el mouse */
}

/* Mejora para tablas responsivas en el tab de política de precios */
.price-policy-table-wrapper {
    width: 100%;
    overflow-x: auto;
}
.price-policy-table {
    min-width: 1100px;
    /* Aumenta el ancho mínimo para más espacio */
}
.price-policy-table th,
.price-policy-table td {
    white-space: nowrap;
    /* Evita que el contenido se divida en varias líneas */
}
.price-policy-table td input,
.price-policy-table td .el-input__inner {
    min-width: 110px;
    /* Espacio suficiente para números largos */
    width: 100%;
    box-sizing: border-box;
}
.price-policy-table td .el-input {
    width: 100%;
}
@media (max-width: 768px) {
    .price-policy-table {
        font-size: 13px;
        min-width: 900px;
    }
    .price-policy-table td input,
    .price-policy-table td .el-input__inner {
        min-width: 90px;
    }
}
</style>

<script>
// import PercentagePerception from './partials/percentage_perception.vue'
import LotsForm from "./partials/lots.vue";
import ColorSize from "./partials/color_size.vue";

export default {
    props: ["showDialog", "recordId", "external", "worker", "typeUser"],
    components: {
        LotsForm,
        ColorSize
    },

    data() {
        return {
            showCategoryForm: false,
            form_category: {
                add: false,
                name: ""
            },
            form_brand: {
                add: false,
                name: ""
            },
            categories: [], // Lista de categorías
            errors: {}, // Errores de validación
            loading: false,
            allEstablishment: false,
            showDialogLots: false,
            showDialogColorSize: false,
            form_brand: {
                add: false,
                name: null,
                id: null
            },
            warehouses: [],
            categoria_madera: [],
            item_codes: [],
            loading_submit: false,
            showPercentagePerception: false,
            has_percentage_perception: false,
            percentage_perception: null,
            enabled_percentage_of_profit: false,
            titleDialog: null,
            resource: "items",
            errors: {},
            headers: headers_token,
            form: {
                promotion_count: null,
                item_price_ranges: [],
                categoria_madera: [],
                item_codes: [],
                category_id: null,
                brand_id: null,
                warehouse_prices: [],
                item_warehouses: []
            },
            sale_unit_price: null,
            configuration: {},
            unit_types: [],
            areas: [],
            currency_types: [],
            system_isc_types: [],
            affectation_igv_types: [],
            categories: [],
            brands: [],
            accounts: [],
            show_has_igv: true,
            have_account: false,
            showSeries: false,
            item_unit_type: {
                id: null,
                unit_type_id: null,
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 2,
                unique_code: null
            },
            attribute_types: [],
            area_id: 2,
            timer: null,
            madera: [],
            all_commercial_treatments: [],
            activeTab: "general",
            totalStock: 0
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.unit_types = response.data.unit_types;
            this.accounts = response.data.accounts;
            this.currency_types = response.data.currency_types;
            this.all_commercial_treatments =
                response.data.all_commercial_treatments;
            this.system_isc_types = response.data.system_isc_types;
            this.affectation_igv_types = response.data.affectation_igv_types;
            this.warehouses = response.data.warehouses;
            this.item_codes = response.data.item_codes;
            // this.form.categoria_madera = response.data.categoria_madera;
            this.categoria_madera = response.data.categoria_madera.map(x => {
                x.precio = 0;
                return x;
            });

            console.log("Categoria Madera:", this.form.categoria_madera);
            if (this.warehouses.length > 0) {
                this.form.warehouse_id = this.warehouses[0].id;
                this.form.warehouse_prices = this.warehouses.map(w => ({
                    id: null,
                    item_id: null,
                    warehouse_id: w.id,
                    price: null,
                    warehouse: w.description
                }));
            }
            if (this.worker) {
                this.warehouses = this.warehouses.filter(
                    w => w.establishment_id == this.worker.establishment_id
                );
                this.form.warehouse_id = this.warehouses[0].id;
            }
            this.categories = response.data.categories;
            this.brands = response.data.brands;
            this.attribute_types = response.data.attribute_types;
            this.configuration = response.data.configuration;
            console.log(
                "🚀 ~ awaitthis.$http.get ~ this.configuration:",
                this.configuration
            );
            this.areas = response.data.areas;

            this.form.sale_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.form.purchase_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;

            if (!this.configuration.restaurant) {
                this.areas = this.areas.filter(
                    a =>
                        !["BARRA", "COCINA", "MOZO", "MESA"].some(
                            p => p == a.description
                        )
                );
            }
            //agregar opciones para entorno restaurante
        });

        this.$eventHub.$on("submitPercentagePerception", data => {
            this.form.percentage_perception = data;
            if (!this.form.percentage_perception)
                this.has_percentage_perception = false;
        });

        this.$eventHub.$on("reloadTables", () => {
            this.reloadTables();
        });

        await this.setDefaultConfiguration();
        this.create();
    },

    computed: {
        /* totalStock() {
            return this.form.item_warehouses.reduce(
                (sum, w) => sum + Number(w.stock || 0),
                0
            );
        }, */
        formattedSaleUnitPrice: {
            get() {
                // Formatea el valor con dos decimales siempre que sea numérico
                return this.form.sale_unit_price !== null
                    ? parseFloat(this.form.sale_unit_price).toFixed(2)
                    : "";
            },
            set(value) {
                // Elimina caracteres no numéricos y actualiza el valor original
                const numericValue = parseFloat(value.replace(/[^0-9.]/g, ""));
                this.form.sale_unit_price = isNaN(numericValue)
                    ? null
                    : numericValue;
            }
        }
    },
    closeForm() {
        // Lógica para cerrar el formulario principal
        this.resetCategoryForm();
    },
    /* resetCategoryForm() {
        // Reiniciar el estado de la categoría
        this.form_category = {
            add: false,
            name: ""
        };
    }, */

    methods: {
        clickDeleteUnitTypePriceRange(index, indexx) {
            this.form.item_unit_types[index].item_unit_type_price_ranges.splice(
                indexx,
                1
            );
        },
        addUnitTypePriceRange(index) {
            this.form.item_unit_types[index].item_unit_type_price_ranges.push({
                quantity_min: null,
                price: null
            });
        },
        validatePriceRange() {
            if (this.form.item_price_ranges.length == 0) return true;
            return this.form.item_price_ranges.every(
                row => row.quantity_min && row.price
            );
        },
        addPriceRange() {
            this.form.item_price_ranges.push({
                quantity_min: null,
                price: null
            });
        },
        async clickDeletePriceRange(index) {
            this.$confirm("¿Estás seguro de eliminar este registro?")
                .then(() => {
                    this.form.item_price_ranges.splice(index, 1);
                })
                .catch(() => {});
        },

        async clickDeleteBarcode(index) {
            this.$confirm("¿Estás seguro de eliminar este registro?")
                .then(() => {
                    this.form.item_codes.splice(index, 1);
                })
                .catch(() => {});
        },

        // Activar el formulario (Categoría o Marca)
        activateForm(type) {
            if (type == "category") {
                this.form_category.add = true;
                this.showCategoryForm = true;
                console.log("corriendo?");
                this.$nextTick(() => {
                    if (this.$refs.categoryInput) {
                        this.$refs.categoryInput.focus(); // Coloca el cursor en el input
                    }
                });
            } else if (type == "brand") {
                this.form_brand.add = true;
                this.$nextTick(() => {
                    if (this.$refs.brandInput) {
                        this.$refs.brandInput.focus(); // Coloca el cursor en el input
                    }
                });
            }
        },
        // Guardar (Categoría o Marca)
        saveForm(type) {
            let endpoint = "";
            let form = {};
            let list = [];
            let successMessage = "";

            if (type === "category") {
                endpoint = "/items/categories";
                form = this.form_category;
                list = this.categories;
                successMessage = "Categoría registrada correctamente.";
            } else if (type === "brand") {
                endpoint = "/brands";
                form = this.form_brand;
                list = this.brands;
                successMessage = "Marca registrada correctamente.";
            }

            if (!form.name) {
                this.$showSAlert(
                    "Campo Requerido",
                    `Debe ingresar un nombre para la ${
                        type === "category" ? "categoría" : "marca"
                    }.`,
                    "warning"
                );
                return;
            }

            this.$http
                .post(endpoint, form)
                .then(response => {
                    if (response.data.success) {
                        this.$showSAlert("Éxito", successMessage, "success");

                        // Actualiza la lista (categorías o marcas)
                        list.push(response.data.data);
                        console.log("List:", list);
                        let lastElement = list[list.length - 1];
                        // Selecciona automáticamente la nueva categoría o marca
                        if (type === "category") {
                            this.form.category_id = lastElement.id;
                            this.showCategoryForm = false;
                            this.categories = [...list];
                            this.form_category.name = "";
                            this.form_category.add = false;
                        } else if (type === "brand") {
                            this.form.brand_id = lastElement.id;
                            this.brands = [...list];
                            this.form_brand.name = "";
                            this.form_brand.add = false;
                            this.form.brand_id = lastElement.id;
                        }

                        // Reinicia el formulario y fuerza la actualización del DOM
                        // this.resetForm(type);
                        this.$forceUpdate(); // Fuerza la reactividad de Vue
                        console.log(this.form.category_id);
                    } else {
                        this.$showSAlert(
                            "Error",
                            `No se pudo guardar la ${
                                type === "category" ? "categoría" : "marca"
                            }.`,
                            "error"
                        );
                    }
                })
                .catch(error => {
                    console.error(`Error al guardar la ${type}:`, error);
                    this.$showSAlert(
                        "Error",
                        `Ocurrió un error al guardar la ${
                            type === "category" ? "categoría" : "marca"
                        }.`,
                        "error"
                    );
                });
        },
        cancelForm(type) {
            console.log(`Cancel form for ${type}`);
            if (type == "category") {
                this.showCategoryForm = false;
                this.$nextTick(() => {
                    this.form_category = {
                        add: false,
                        name: ""
                    };
                });

                console.log(
                    "form_category",
                    JSON.stringify(this.form_category)
                );
            } else if (type == "brand") {
                this.$nextTick(() => {
                    this.form_brand = {
                        add: false,
                        name: ""
                    };
                });
                console.log("form_brand", JSON.stringify(this.form_brand));
            }
            this.$forceUpdate();
        },

        updateCommercialTreatmentItem(idx) {
            if (!this.recordId) return;
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(async () => {
                let commercial_treatment_item = this.form.commercial_treatments[
                    idx
                ];
                const response = await this.$http.post(
                    `/commercial_treatment/items/update/${commercial_treatment_item.id}`,
                    commercial_treatment_item
                );
                if (response.data.success) {
                    this.$toast.success("Se actualizó correctamente");
                }
            }, 700);
        },
        addRowColorSize(color_sizes) {
            this.form.color_sizes = color_sizes;
            if (this.form.stock == 0) {
                this.form.stock = color_sizes.reduce(
                    (acc, color_size) => acc + Number(color_size.stock),
                    0
                );
            }
        },
        clickColorSize() {
            this.showDialogColorSize = true;
        },
        selectedMax(idx) {
            let selected = this.form.item_unit_types[idx].selected;
            for (let i = 0; i < this.form.item_unit_types.length; i++) {
                let it = this.form.item_unit_types[i];
                it.selected = false;
            }

            this.form.item_unit_types[idx].selected = selected;
            if (selected) {
                let qty = Number(this.form.item_unit_types[idx].quantity_unit);
                !isNaN(qty) && (this.form.max_quantity = qty);
            } else {
                this.form.max_quantity = null;
            }
            this.$forceUpdate();
        },
        undToTotal(idx, amount, qty) {
            let arr = this.form.item_unit_types;
            if (qty > 0) {
                arr[idx].total = Number(amount) * Number(qty);
            } else {
                this.$toast.warning("Ingrese una cantidad válida");
                arr[idx].price2 = 0;
            }
        },
        totalToUnd(idx, amount, qty) {
            let arr = this.form.item_unit_types;
            if (qty > 0) {
                arr[idx].price2 = Number(amount) / Number(qty);
            } else {
                this.$toast.warning("Ingrese una cantidad válida");
                arr[idx].total = 0;
            }
        },
        setDefaultConfiguration() {
            this.form.sale_affectation_igv_type_id = this.configuration
                ? this.configuration.affectation_igv_type_id
                : "10";

            this.$http.get(`/configurations/record`).then(response => {
                this.form.has_igv = response.data.data.include_igv;
            });
            this.changeAffectationIgvType();
        },
        clickAddAttribute() {
            this.form.attributes.push({
                attribute_type_id: null,
                description: null,
                value: null,
                start_date: null,
                end_date: null,
                duration: null
            });
        },
        async reloadTables() {
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                this.unit_types = response.data.unit_types;
                this.accounts = response.data.accounts;
                this.currency_types = response.data.currency_types;
                this.system_isc_types = response.data.system_isc_types;
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.warehouses = response.data.warehouses;
                this.categories = response.data.categories;
                this.brands = response.data.brands;
                // this.form.categoria_madera = this.categoria_madera.map(madera => ({
                //   id: madera.id,
                //   description: madera.description,
                //   precio: madera.precio
                // }));
                this.form.sale_affectation_igv_type_id =
                    this.affectation_igv_types.length > 0
                        ? this.affectation_igv_types[0].id
                        : null;
                this.form.purchase_affectation_igv_type_id =
                    this.affectation_igv_types.length > 0
                        ? this.affectation_igv_types[0].id
                        : null;
            });
        },
        changeLotsEnabled() {
            // if(!this.form.lots_enabled){
            //     this.form.lot_code = null
            //     this.form.lots = []
            // }
        },
        changeHasWarranty() {
            /* if (!this.form.has_warranty) {
                this.form.warranty = null;
            } */
        },
        addRowLot(lots) {
            this.form.lots = lots;
        },
        clickLotcode() {
            // if(this.form.stock <= 0)
            //     return this.$toast.error('El stock debe ser mayor a 0')

            this.showDialogLots = true;
        },
        changeHaveAccount() {
            if (!this.have_account) this.form.account_id = null;
        },
        changeEnabledPercentageOfProfit() {
            // if(!this.enabled_percentage_of_profit) this.form.percentage_of_profit = 0
        },
        async clickDelete(id) {
            try {
                await this.$confirm("¿Estás seguro de eliminar este registro?");

                this.loading = true;
                console.log("before ", this.loading);
                this.$http
                    .delete(`/${this.resource}/item-unit-type/${id}`)
                    .then(res => {
                        if (res.data.success) {
                            this.loadRecord();
                            this.$toast.success(
                                "Se eliminó correctamente el registro"
                            );
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 500) {
                            this.$toast.error("Error al intentar eliminar");
                        } else {
                            console.log(error.response.data.message);
                        }
                    })
                    .finally(() => {
                        console.log("finally ", this.loading);
                        this.loading = false;
                        console.log("finally ", this.loading);
                    });
            } catch (error) {}
        },
        changeHasPerception() {
            if (!this.form.has_perception) {
                this.form.percentage_perception = null;
            }
        },
        clickAddRow() {
            this.form.item_unit_types.push({
                item_unit_type_price_ranges: [],
                id: null,
                description: null,
                unit_type_id: "NIU",
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 1,
                warehouse_id: 1,
                unique_code: null
            });
        },
        clickAddBarcode() {
            this.form.item_codes.push({
                id: null,
                code_barcode: null
            });
        },
        clickCancel(index) {
            this.form.item_unit_types.splice(index, 1);
            // this.initDocumentTypes()
            // this.showAddButton = true
        },
        initForm() {
            this.form_category.add = false;
            this.form_brand.add = false;
            (this.loading_submit = false), (this.errors = {});
            this.form = {
                item_price_ranges: [],
                categoria_madera: [],
                item_codes: [],
                subject_to_detraction: false,
                is_manufactured: false,
                id: null,
                color_sizes: [],
                item_type_id: "01",
                location: null,
                internal_id: null,
                item_code: null,
                item_code_gs1: null,
                description: null,
                name: null,
                second_name: null,
                unit_type_id: "NIU",
                currency_type_id: "PEN",
                sale_unit_price: 0,
                purchase_unit_price: 0,
                has_isc: false,
                system_isc_type_id: null,
                percentage_isc: 0,
                suggested_price: 0,
                sale_affectation_igv_type_id: null,
                purchase_affectation_igv_type_id: null,
                calculate_quantity: false,
                stock: 0,
                stock_min: 1,
                has_igv: true,
                has_perception: false,
                item_unit_types: [],
                percentage_of_profit: 0,
                percentage_perception: 0,
                image: null,
                image_url: null,
                temp_path: null,
                is_set: false,
                account_id: null,
                category_id: null,
                brand_id: null,
                date_of_due: null,
                lot_code: null,
                lots_enabled: false,
                lots: [],
                attributes: [],
                series_enabled: false,
                area_id: 2,
                model: null,
                quality: null,
                origin: null,
                month_day: null,
                init_report: 0,
                commission: 0,
                warehouse_prices: [],
                item_warehouses: []
            };
            this.show_has_igv = true;
            this.enabled_percentage_of_profit = false;

            // Inicializar arrays de almacenes
            if (this.warehouses.length > 0) {
                // Precios por almacén
                this.form.warehouse_prices = this.warehouses.map(w => ({
                    warehouse_id: w.id,
                    price: 0,
                    warehouse: w.description
                }));

                // Stock por almacén
                this.form.item_warehouses = this.warehouses.map(w => ({
                    warehouse_id: w.id,
                    stock: 0
                }));
            }
        },
        onSuccess(response, file, fileList) {
            if (response.success) {
                this.form.image = response.data.filename;
                this.form.image_url = response.data.temp_image;
                this.form.temp_path = response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }
        },
        changeAffectationIgvType() {
            let affectation_igv_type_exonerated = [
                20,
                21,
                30,
                31,
                32,
                33,
                34,
                35,
                36,
                37
            ];
            let is_exonerated = affectation_igv_type_exonerated.includes(
                parseInt(this.form.sale_affectation_igv_type_id)
            );

            if (is_exonerated) {
                this.show_has_igv = false;
                this.form.has_igv = true;
            } else {
                this.show_has_igv = true;
            }
        },
        resetForm() {
            this.initForm();
            this.form.sale_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.form.purchase_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.setDefaultConfiguration();
        },
        async generateCode() {
            this.loading = true;
            const response = await this.$http(`/items/generate_code`);
            this.form.internal_id = response.data;
            this.loading = false;
        },
        async create() {
            console.log("dsadasda");
            /* console.log("🚀 ~ create ~ this.configuration:", this.configuration);
        console.log("🚀 ~ create ~ this.configuration:", this.allEstablishment); */
            this.categoria_madera = this.categoria_madera.map(c => {
                c.precio = 0;
                return c;
            });
            this.titleDialog = this.recordId
                ? "Editar Producto"
                : "Nuevo Producto";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        console.log("🚀 ~ create ~ this.form:", this.form);

                        if (this.form.warehouse_prices.length == 0) {
                            if (this.warehouses.length > 0) {
                                this.form.warehouse_id = this.warehouses[0].id;
                                this.form.warehouse_prices = this.warehouses.map(
                                    w => ({
                                        id: null,
                                        item_id: null,
                                        warehouse_id: w.id,
                                        price: null,
                                        warehouse: w.description
                                    })
                                );
                            }
                        } else {
                            this.form.warehouse_prices = this.warehouses.map(
                                w => {
                                    let exist = this.form.warehouse_prices.find(
                                        ww => ww.warehouse_id == w.id
                                    );
                                    if (exist) {
                                        return exist;
                                    }
                                    return {
                                        id: null,
                                        item_id: null,
                                        warehouse_id: w.id,
                                        price: null,
                                        warehouse: w.description
                                    };
                                }
                            );
                        }
                        if (this.form.item_unit_types.length != 0) {
                            this.restoreUnitTypes();
                        }
                        this.has_percentage_perception = this.form
                            .percentage_perception
                            ? true
                            : false;
                        this.changeAffectationIgvType();
                        this.showSeries = true;
                        if (this.form.categoria_madera_item.length > 0) {
                            this.categoria_madera = this.categoria_madera.map(
                                c => {
                                    let exists = this.form.categoria_madera_item.find(
                                        ci => ci.categoria_madera_id == c.id
                                    );
                                    if (exists) {
                                        c.precio = exists.precio;
                                    }
                                    return c;
                                }
                            );
                        }
                        if (this.form.series_enabled == 1) {
                            this.form.series_enabled = true;
                        } else this.form.series_enabled = false;

                        // Sincronizar stocks de almacenes al editar
                        if (
                            this.form.warehouses &&
                            this.form.warehouses.length > 0
                        ) {
                            this.form.item_warehouses = this.warehouses.map(
                                warehouse => {
                                    // Buscar el stock existente en warehouses
                                    const existingWarehouse = this.form.warehouses.find(
                                        w => w.warehouse_id === warehouse.id
                                    );
                                    return {
                                        warehouse_id: warehouse.id,
                                        stock: existingWarehouse
                                            ? Number(existingWarehouse.stock)
                                            : 0
                                    };
                                }
                            );
                        }
                    });
            } else {
                if (this.warehouses.length > 0) {
                    this.form.warehouse_id = this.warehouses[0].id;
                    this.form.warehouse_prices = this.warehouses.map(w => ({
                        id: null,
                        item_id: null,
                        warehouse_id: w.id,
                        price: null,
                        warehouse: w.description
                    }));
                }
                await this.generateCode();
                this.showSeries = true;
                this.form.area_id = 2;
                this.form.commercial_treatments = this.all_commercial_treatments;

                // Inicializar stock para nuevo producto
                this.form.item_warehouses = this.warehouses.map(w => ({
                    warehouse_id: w.id,
                    stock: 0
                }));
            }
        },
        restoreUnitTypes() {
            let hasSelected = false;
            this.form.item_unit_types = this.form.item_unit_types.map(i => {
                let selected = false;
                if (
                    !hasSelected &&
                    Number(this.form.max_quantity) == Number(i.quantity_unit)
                ) {
                    selected = true;
                    hasSelected = true;
                }
                return {
                    ...i,
                    selected,
                    total: i.total
                    // total: (Number(i.price2) * Number(i.quantity_unit)).toFixed(
                    //     2
                    // )
                };
            });
        },
        loadRecord() {
            if (this.recordId) {
                this.loading = true;
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.changeAffectationIgvType();
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
        changeWarehouse() {
            this.$toast.warning(
                "Cambió el destino del producto, verifique los PRECIOS DE ALMACÉN"
            );

            let w = this.form.warehouse_prices.find(
                ww => ww.warehouse_id == this.form.warehouse_id
            );
            if (w) {
                w.price = this.form.sale_unit_price;
            }

            this.$forceUpdate();
        },
        calculatePercentageOfProfitBySale() {
            console.log(this.configuration);

            let w = this.form.warehouse_prices.find(
                ww => ww.warehouse_id == this.form.warehouse_id
            );
            if (w) {
                w.price = this.form.sale_unit_price;
            }
            let difference =
                parseFloat(this.form.sale_unit_price) -
                parseFloat(this.form.purchase_unit_price);

            if (parseFloat(this.form.purchase_unit_price) === 0) {
                this.form.percentage_of_profit = 0;
            } else {
                if (this.enabled_percentage_of_profit)
                    this.form.percentage_of_profit =
                        (difference /
                            parseFloat(this.form.purchase_unit_price)) *
                        100;
            }
        },
        calculatePercentageOfProfitByPurchase() {
            if (this.form.percentage_of_profit === "") {
                this.form.percentage_of_profit = 0;
            }

            if (this.enabled_percentage_of_profit)
                this.form.sale_unit_price =
                    (this.form.purchase_unit_price *
                        (100 + parseFloat(this.form.percentage_of_profit))) /
                    100;
        },
        calculatePercentageOfProfitByPercentage() {
            if (this.form.percentage_of_profit === "") {
                this.form.percentage_of_profit = 0;
            }

            if (this.enabled_percentage_of_profit)
                this.form.sale_unit_price =
                    (this.form.purchase_unit_price *
                        (100 + parseFloat(this.form.percentage_of_profit))) /
                    100;
        },
        async submit() {
            if (!this.validatePriceRange()) {
                this.$toast.warning("Ingrese los rangos de precios");
                return false;
            }

            if (this.form.max_quantity && !this.form.max_quantity_description) {
                this.$showSAlert(
                    "ALERTA",
                    "Ingrese una descripción del contenedor para la cantidad máxima",
                    "warning"
                );
                return false;
            }
            if (!this.form.category_id) {
                this.$showSAlert(
                    "ALERTA",
                    "Seleccione una categoria",
                    "warning"
                );
                return false;
            }

            if (this.form.internal_id == null || this.form.internal_id == "") {
                this.$refs.internal_id.$el.querySelector("input").focus();
                return this.$toast.warning(
                    "No puede guardar Un nuevo Producto sin codigo interno "
                );
            }

            if (this.form.has_perception && !this.form.percentage_perception)
                return this.$toast.error("Ingrese un porcentaje");

            if (!this.form.warehouse_id)
                return this.$toast.error("Seleccione un almacen");
            if (!this.recordId && this.form.lots_enabled) {
            }

            if (!this.recordId && this.form.series_enabled) {
                if (this.form.lots.length > this.form.stock)
                    return this.$toast.error(
                        "La cantidad de series registradas es superior al stock"
                    );

                if (this.form.lots.length != this.form.stock)
                    return this.$toast.error(
                        "La cantidad de series registradas son diferentes al stock"
                    );
            }

            // Validar que cada almacén tenga stock definido
            if (!this.recordId) {
                const invalidStock = this.form.item_warehouses.some(w => {
                    return (
                        w.stock === null || w.stock === undefined || w.stock < 0
                    );
                });

                if (invalidStock) {
                    this.$showSAlert(
                        "Error",
                        "Debe especificar un stock inicial válido para cada almacén",
                        "warning"
                    );
                    return;
                }
            }

            this.loading_submit = true;
            this.form.all_establishment = this.allEstablishment;
            this.form.categoria_madera = this.categoria_madera.filter(
                c => c.precio != null && c.precio > 0
            );
            console.log(
                "🚀 ~ file: form.vue:2309 ~ submit ~ this.form:",
                this.form
            );

            // Preparar datos para enviar asegurándose que los arrays existan
            const formData = {
                ...this.form,
                warehouse_prices: Array.isArray(this.form.warehouse_prices)
                    ? this.form.warehouse_prices.map(w => ({
                          warehouse_id: w.warehouse_id,
                          price: Number(w.price || 0) // Asegurar que price tenga un valor numérico
                      }))
                    : [],

                item_warehouses: Array.isArray(this.form.item_warehouses)
                    ? this.form.item_warehouses.map(w => ({
                          warehouse_id: w.warehouse_id,
                          stock: Number(w.stock || 0) // Asegurar que stock tenga un valor numérico
                      }))
                    : []
            };

            await this.$http
                .post(`/${this.resource}`, formData)
                .then(response => {
                    if (response.data.success) {
                        this.$showSAlert(
                            "SUCCESS",
                            response.data.message,
                            "success"
                        );
                        if (this.external) {
                            this.$emit("add", response.data.data);
                        } else {
                            this.$eventHub.$emit("reloadData");
                        }
                        this.close();
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
        // ****
        close() {
            this.$emit("update:showDialog", false);
            this.showSeries = false;
            this.resetForm();
            this.form.warehouse_prices = this.warehouses.map(w => ({
                id: null,
                item_id: null,
                warehouse_id: w.id,
                price: null,
                warehouse: w.description
            }));
            this.form.categoria_madera = this.categoria_madera.map(madera => ({
                id: null,
                description: null
            }));
        },

        changeHasIsc() {
            this.form.system_isc_type_id = null;
            this.form.percentage_isc = 0;
            this.form.suggested_price = 0;
        },
        changeSystemIscType() {
            if (this.form.system_isc_type_id !== "03") {
                this.form.suggested_price = 0;
            }
        },
        // saveCategory() {
        //     this.form_category.add = false;

        //     this.$http
        //         .post(`/items/categories`, this.form_category)
        //         .then(response => {
        //             if (response.data.success) {
        //                 this.$toast.success(response.data.message);
        //                 this.categories.push(response.data.data);
        //                 this.form.category_id = response.data.data.id;
        //                 this.form_category.name = null;
        //             } else {
        //                 this.$toast.error("No se guardaron los cambios");
        //             }
        //         })
        //         .catch(error => {});
        // },
        saveCategory() {
            // Desactivar el estado "add"
            this.form_category.add = false;

            // Enviar la solicitud al backend
            this.$http
                .post(`/items/categories`, this.form_category)
                .then(response => {
                    if (response.data.success) {
                        // Mostrar mensaje de éxito con SweetAlert2
                        this.$showSAlert(
                            "Éxito",

                            response.data.message ||
                                "Categoría guardada correctamente.",
                            "success"
                        );

                        // Actualizar la lista de categorías y seleccionar la nueva
                        this.categories.push(response.data.data);
                        this.form.category_id = response.data.data.id;

                        // Reiniciar el formulario
                        this.form_category.name = null;
                    } else {
                        // Mostrar mensaje de error con SweetAlert2
                        this.$showSAlert(
                            "Error",
                            "No se guardaron los cambios en la categoría.",
                            "error"
                        );
                    }
                })
                .catch(error => {
                    // Manejar errores de red u otros problemas
                    console.error("Error al guardar la categoría:", error);
                    this.$showSAlert(
                        "Error",

                        "Ocurrió un error al guardar la categoría. Por favor, intente de nuevo.",
                        "error"
                    );
                });
        },
        saveBrand() {
            // Desactivar el estado "add"
            this.form_brand.add = false;

            // Enviar la solicitud al backend
            this.$http
                .post(`/brands`, this.form_brand)
                .then(response => {
                    if (response.data.success) {
                        // Mostrar mensaje de éxito con SweetAlert2
                        this.$showSAlert(
                            "Éxito",

                            response.data.message ||
                                "Marca guardada correctamente.",
                            "success"
                        );

                        // Actualizar la lista de marcas y reiniciar el formulario
                        this.brands.push(response.data.data);
                        this.form_brand.name = null;
                    } else {
                        // Mostrar mensaje de error con SweetAlert2
                        this.$showSAlert(
                            "Error",
                            "No se guardaron los cambios en la marca.",
                            "error"
                        );
                    }
                })
                .catch(error => {
                    // Manejar errores de red u otros problemas
                    console.error("Error al guardar la marca:", error);
                    this.$showSAlert(
                        "Error",

                        "Ocurrió un error al guardar la marca. Por favor, intente de nuevo.",
                        "error"
                    );
                });
        },

        changeAttributeType(index) {
            let attribute_type_id = this.form.attributes[index]
                .attribute_type_id;
            let attribute_type = _.find(this.attribute_types, {
                id: attribute_type_id
            });
            this.form.attributes[index].description =
                attribute_type.description;
        },
        clickRemoveAttribute(index) {
            this.form.attributes.splice(index, 1);
        },
        maderaUpdate() {},
        activateCategoryForm() {
            // Asegurarse de que ambos estados se actualizan juntos
            this.$nextTick(() => {
                this.form_category.add = true;
                this.showCategoryForm = true;
                if (this.$refs.categoryInput) {
                    this.$refs.categoryInput.focus();
                }
            });
        },

        saveCategoryForm() {
            if (!this.form_category.name) {
                this.$showSAlert(
                    "Campo Requerido",
                    "Debe ingresar un nombre para la categoría.",
                    "warning"
                );
                return;
            }

            this.$http
                .post("/items/categories", this.form_category)
                .then(response => {
                    if (response.data.success) {
                        this.$showSAlert(
                            "Éxito",
                            "Categoría registrada correctamente.",
                            "success"
                        );
                        this.categories.push(response.data.data);
                        let lastElement = this.categories[
                            this.categories.length - 1
                        ];
                        this.form.category_id = lastElement.id;
                        this.showCategoryForm = false;
                        this.form_category.name = "";
                        this.form_category.add = false;
                        this.$forceUpdate();
                    } else {
                        this.$showSAlert(
                            "Error",
                            "No se pudo guardar la categoría.",
                            "error"
                        );
                    }
                })
                .catch(error => {
                    console.error("Error al guardar la categoría:", error);
                    this.$showSAlert(
                        "Error",
                        "Ocurrió un error al guardar la categoría.",
                        "error"
                    );
                });
        },

        cancelCategoryForm(event) {
            // Prevenir la propagación del evento si existe
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Asegurarse de que ambos estados se actualizan juntos
            this.$nextTick(() => {
                this.showCategoryForm = false;
                this.form_category = {
                    add: false,
                    name: ""
                };
                // Forzar la actualización del DOM
                this.$forceUpdate();
            });
        },

        // Métodos para Marca
        activateBrandForm() {
            this.form_brand.add = true;
            this.$nextTick(() => {
                if (this.$refs.brandInput) {
                    this.$refs.brandInput.focus();
                }
            });
        },

        saveBrandForm() {
            if (!this.form_brand.name) {
                this.$showSAlert(
                    "Campo Requerido",
                    "Debe ingresar un nombre para la marca.",
                    "warning"
                );
                return;
            }

            this.$http
                .post("/brands", this.form_brand)
                .then(response => {
                    if (response.data.success) {
                        this.$showSAlert(
                            "Éxito",
                            "Marca registrada correctamente.",
                            "success"
                        );
                        this.brands.push(response.data.data);
                        let lastElement = this.brands[this.brands.length - 1];
                        this.form.brand_id = lastElement.id;
                        this.brands = [...this.brands];
                        this.form_brand.name = "";
                        this.form_brand.add = false;
                        this.$forceUpdate();
                    } else {
                        this.$showSAlert(
                            "Error",
                            "No se pudo guardar la marca.",
                            "error"
                        );
                    }
                })
                .catch(error => {
                    console.error("Error al guardar la marca:", error);
                    this.$showSAlert(
                        "Error",
                        "Ocurrió un error al guardar la marca.",
                        "error"
                    );
                });
        },

        cancelBrandForm(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            this.$nextTick(() => {
                this.form_brand = {
                    add: false,
                    name: ""
                };
                this.$forceUpdate();
            });
        },
        // Obtener precio para un almacén específico
        getPriceForWarehouse(warehouseId) {
            if (!this.form.warehouse_prices) {
                this.form.warehouse_prices = [];
            }

            let price = this.form.warehouse_prices.find(
                w => w.warehouse_id === warehouseId
            );
            if (!price) {
                price = {
                    warehouse_id: warehouseId,
                    price: this.form.sale_unit_price || 0
                };
                this.form.warehouse_prices.push(price);
            }
            return price;
        },

        // Obtener stock para un almacén específico
        getStockForWarehouse(warehouseId) {
            if (!this.form.item_warehouses) {
                this.form.item_warehouses = [];
            }

            let stockItem = this.form.item_warehouses.find(
                w => w.warehouse_id === warehouseId
            );

            // Si estamos editando y existe data en warehouses
            if (this.recordId && this.form.warehouses && !stockItem) {
                const existingWarehouse = this.form.warehouses.find(
                    w => w.warehouse_id === warehouseId
                );
                if (existingWarehouse) {
                    stockItem = {
                        warehouse_id: warehouseId,
                        stock: Number(existingWarehouse.stock)
                    };
                    this.form.item_warehouses.push(stockItem);
                }
            }

            // Si aún no existe el stock para ese almacén, creamos uno nuevo
            if (!stockItem) {
                stockItem = {
                    warehouse_id: warehouseId,
                    stock: 0
                };
                this.form.item_warehouses.push(stockItem);
            }

            return stockItem;
        },

        // Calcular stock total
        calculateTotalStock() {
            const total = this.form.item_warehouses.reduce(
                (sum, w) => sum + Number(w.stock || 0),
                0
            );
            this.totalStock = total;
        },
        handleDescriptionInput(value) {
            // Guardar la posición actual del cursor
            const input = this.$refs.descriptionInput.$el.querySelector(
                "input"
            );
            const cursorPosition = input.selectionStart;

            // Convertir a mayúsculas
            this.form.description = value.toUpperCase();

            // Restaurar la posición del cursor en el siguiente tick
            this.$nextTick(() => {
                input.setSelectionRange(cursorPosition, cursorPosition);
            });
        }
    },
    watch: {
        "form_category.add": {
            handler(newVal, oldVal) {
                console.trace();
                console.log("form_category.add changed", {
                    oldValue: oldVal,
                    newValue: newVal,
                    trace: new Error().stack
                });
            }
        }
    }
    // Métodos para Categoría
};
</script>
