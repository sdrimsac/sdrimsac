<!-- Modal de Creación de Productos -->
<template>
    <el-dialog
        width="70%"
        :title="titleDialog"
        :visible="showDialog"
        :close-on-click-modal="false"
        @close="close"
        @open="create"
        append-to-body
        top="7vh"
        v-loading="loading"
        class="rounded-dialog"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <!-- Panel General -->
                <el-tabs tab-position="top">
                    <el-tab-pane label="General">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl-3">
                                <!-- <div class="col-lg-6 col-xl-3"> -->
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.internal_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-barcode"></i>
                                        Código Interno
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Código interno de la empresa para el control de sus productos"
                                            placement="top-start"
                                        >
                                            <i class="fas fa-info-circle"></i>
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
                                        v-text="errors.internal_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-3"
                                v-if="
                                    configuration.show_second_name_external_code
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.barcode }"
                                >
                                    <label class="control-label">
                                        Código Externo
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Código Barra de la empresa para el control de sus productos"
                                            placement="top-start"
                                        >
                                            <i class="fa fa-info-circle"></i>
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
                            <div
                                class="col-12 col-lg-6 col-xl-3"
                                v-if="
                                    configuration.origin
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.origin }"
                                >
                                    <label class="control-label">
                                        Código Origen
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Código Barra de la empresa para el control de sus productos"
                                            placement="top-start"
                                        >
                                            <i class="fa fa-info-circle"></i>
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
                            <div
                                :class="
                                    `col-12 col-lg-6 ${
                                        configuration.show_second_name_external_code
                                            ? 'col-xl-3'
                                            : 'col-xl-9'
                                    }`
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.description
                                    }"
                                >
                                    <label
                                        class="control-label font-weight-bold"
                                    >
                                        <i class="fas fa-tag"></i>
                                        Nombre
                                        <el-tooltip
                                            content="Campo Obligatorio, aqui se ingresa el nombre del producto o servicio"
                                        >
                                            <span class="text-danger">
                                                <i
                                                    class="fas fa-exclamation-circle"
                                                ></i>
                                            </span>
                                        </el-tooltip>
                                    </label>

                                    <el-input
                                        v-model="form.description"
                                        dusk="description"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.description"
                                        v-text="errors.description[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-3"
                                v-if="
                                    configuration.show_second_name_external_code
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.second_name
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-user-tag"></i>
                                        <i class="fas fa-tag"></i>
                                        Nombre secundario
                                    </label>
                                    <el-input
                                        v-model="form.second_name"
                                        dusk="second_name"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.second_name"
                                        v-text="errors.second_name[0]"
                                    ></small>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 col-xl-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.category_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-folder"></i>
                                        Categoría
                                        <el-tooltip content="Campo Obligatorio">
                                            <span class="text-danger">
                                                <i
                                                    class="fas fa-exclamation-circle"
                                                ></i>
                                            </span>
                                        </el-tooltip>
                                    </label>
                                    <a
                                        href="#"
                                        v-if="form_category.add == false"
                                        class="control-label font-weight-bold text-info"
                                        @click="form_category.add = true"
                                    >
                                        <i class="fas fa-plus-circle"></i> Nuevo
                                    </a>
                                    <a
                                        href="#"
                                        v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-info"
                                        @click="saveCategory()"
                                    >
                                        <i class="fas fa-save fa-lg"></i>
                                    </a>
                                    <a
                                        href="#"
                                        v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-danger"
                                        @click="form_category.add = false"
                                    >
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>
                                    <el-input
                                        v-if="form_category.add == true"
                                        v-model="form_category.name"
                                        dusk="item_code"
                                        style="margin-bottom:1.5%;"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>

                                    <el-select
                                        v-if="form_category.add == false"
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
                            <div class="col-12 col-lg-6 col-xl-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger':
                                            errors.sale_affectation_igv_type_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Zona
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Lugar en donde se despacha el producto"
                                            placement="top-start"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-select
                                        :disabled="configuration.college != 0"
                                        v-model="form.area_id"
                                    >
                                        <el-option
                                            v-for="option in areas"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
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
                                    ></small>
                                </div>
                            </div>

                            <!-- <div v-if="form.unit_type_id !='ZZ'" class="col-md-3 center-el-checkbox">
                                        <div class="form-group" :class="{'has-danger': errors.calculate_quantity}">
                                            <el-checkbox v-model="form.calculate_quantity">Calcular cantidad por precio</el-checkbox><br>
                                            <small class="text-danger" v-if="errors.calculate_quantity" v-text="errors.calculate_quantity[0]"></small>
                                        </div>
              </div>-->

                            <div class="col-xl-2 col-lg-4">
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.location }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-hand-pointer"></i>
                                        Ubicación
                                    </label>
                                    <el-input
                                        v-model="form.location"
                                        dusk="name"
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.location"
                                        v-text="errors.location[0]"
                                    ></small>
                                </div>
                            </div>

                            <div class="col-xl-2 col-lg-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.unit_type_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fa-ruler"></i>
                                        Unidad
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
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.unit_type_id"
                                        v-text="errors.unit_type_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.currency_type_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fas fas fa-coins"></i>
                                        Moneda
                                    </label>
                                    <el-select
                                        v-model="form.currency_type_id"
                                        dusk="currency_type_id"
                                    >
                                        <el-option
                                            v-for="option in currency_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.currency_type_id"
                                        v-text="errors.currency_type_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-4">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.sale_unit_price
                                    }"
                                >
                                    <label class="control-label">
                                        <i class="fa fa-tag fa-lg"></i>
                                        P. Venta
                                        <el-tooltip
                                            content="Campo Obligatorio, aqui se ingresa el precio unitario de venta"
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
                                    ></small>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 col-xl-4">
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
                                        ></el-option>
                                    </el-select>
                                    <small v-if="show_has_igv">
                                        <el-checkbox v-model="form.has_igv">
                                            Incluye Igv
                                            {{ configuration.include_igv }}
                                        </el-checkbox>
                                    </small>
                                </div>
                            </div>

                            <div
                                class="col-xl-4 col-lg-6"
                                v-if="recordId == null"
                            >
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.warehouse_id
                                    }"
                                >
                                    <label class="control-label">
                                        <i
                                            class="fas fa-warehouse red-icon fa-lg"
                                        ></i>
                                        Almacén
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-select
                                        :disabled="
                                            configuration.college ||
                                                allEstablishment
                                        "
                                        @change="changeWarehouse"
                                        v-model="form.warehouse_id"
                                    >
                                        <el-option
                                            v-for="option in warehouses"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small v-if="!recordId">
                                        <el-checkbox v-model="allEstablishment"
                                            >Todos los almacenes</el-checkbox
                                        >
                                    </small>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                v-if="
                                    recordId == null &&
                                        form.unit_type_id != 'ZZ'
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.stock }"
                                >
                                    <label
                                        v-if="!allEstablishment"
                                        class="control-label"
                                    >
                                        <i class="fa fa-boxes fa-lg"></i>
                                        Stock Inicial
                                    </label>
                                    <label v-else class="control-label"
                                        >Stock Inicial en cada
                                        establecimiento</label
                                    >
                                    <el-input
                                        :disabled="
                                            configuration.init_stock == 1
                                        "
                                        v-model="form.stock"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.stock"
                                        v-text="errors.stock[0]"
                                    ></small>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                v-if="form.unit_type_id != 'ZZ'"
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.stock_min }"
                                >
                                    <label class="control-label">
                                        <i
                                            class="fa fa-exclamation-circle fa-lg"
                                        ></i>
                                        Stock Mínimo
                                    </label>
                                    <el-input v-model="form.stock_min">
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.stock_min"
                                        v-text="errors.stock_min[0]"
                                    ></small>
                                </div>
                            </div>

                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                v-if="
                                    form.unit_type_id != 'ZZ' &&
                                        !form.has_color_size
                                "
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <i
                                            class="fa fa-tachometer-alt fa-lg"
                                        ></i>
                                        Cant.Máx
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="La cantidad máxima representada en el envase/contenedor"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        :disabled="
                                            form.item_unit_types.length != 0
                                        "
                                        v-model="form.max_quantity"
                                    ></el-input>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-2"
                            v-if="configuration.consolidated_quotations"
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <i
                                            class="fa fa-box fa-lg"
                                        ></i>
                                        Peso
                                        
                                    </label>
                                    <el-input
                                        
                                        v-model="form.weight"
                                    ></el-input>
                                </div>
                            </div>

                            <div
                                class="col-12 col-lg-6 col-xl-4"
                                v-if="
                                    form.unit_type_id != 'ZZ' &&
                                        !form.has_color_size
                                "
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <i class="fa fa-box fa-lg"></i>
                                        Contenedor de Productos
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Nombre del contenedor de la cantidad máxima Ej. Botella(s), Caja(s), Saco(s)"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        :disabled="
                                            form.max_quantity == 0 ||
                                                form.max_quantity == null
                                        "
                                        v-model="form.max_quantity_description"
                                    ></el-input>
                                </div>
                            </div>

                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                v-if="form.unit_type_id != 'ZZ'"
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <i class="fa fa-motorcycle fa-lg"></i>
                                        Add. Delivery
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Valor agregado en SOLES al enviar el producto por delivery"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        v-model="form.delivery_cost"
                                    ></el-input>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <!-- <i class="fa fa-motorcycle fa-lg"></i> -->
                                        Modelo
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="aqui va el modelo del producto"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        v-model="form.model"
                                    ></el-input>
                                </div>
                            </div>
                            <div
                                class="col-12 col-lg-6 col-xl-2"
                                v-if="form.unit_type_id != 'ZZ'"
                            >
                                <div class="form-group">
                                    <label class="control-label">
                                        <!-- <i class="fa fa-motorcycle fa-lg"></i> -->
                                        Calidad Producto
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="aqui se agrega la calidad de producto"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        v-model="form.quality"
                                    ></el-input>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 col-xl-12">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.brand_id
                                    }"
                                >
                                    <label class="control-label">Marca</label>
                                    <!-- Nuevo, Guardar y Cancelar Marca -->
                                    <a
                                        href="#"
                                        v-if="form_brand.add == false"
                                        class="control-label font-weight-bold text-info"
                                        @click="form_brand.add = true"
                                    >
                                        <i class="fas fa-plus-circle"></i>
                                        Nuevo
                                    </a>

                                    <a
                                        href="#"
                                        v-if="form_brand.add == true"
                                        class="control-label font-weight-bold text-info"
                                        @click="saveBrand()"
                                    >
                                        <i class="fas fa-save fa-lg"></i>
                                    </a>
                                    <a
                                        href="#"
                                        v-if="form_brand.add == true"
                                        class="control-label font-weight-bold text-danger"
                                        @click="form_brand.add = false"
                                    >
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>

                                    <el-input
                                        v-if="form_category.add == true"
                                        v-model="form_category.name"
                                        dusk="item_code"
                                        style="margin-bottom:1.5%;"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <el-input
                                        v-if="form_brand.add == true"
                                        v-model="form_brand.name"
                                        dusk="item_code"
                                        style="margin-bottom:1.5%;"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>

                                    <el-select
                                        v-if="form_brand.add == false"
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
                            <div
                                class="col-md-3 center-el-checkbox"
                                v-if="configuration.detraction"
                            >
                                <div class="form-group">
                                    <el-checkbox
                                        v-model="form.subject_to_detraction"
                                        >Sujeto a detracción</el-checkbox
                                    >
                                </div>
                            </div>
                            <!-- **** -->
                            <div class="d-flex row" v-if="showSeries">
                                <div
                                    class="col-12 col-lg-6 col-xl-3"
                                    v-if="configuration.series_enabled"
                                >
                                    <div
                                        v-if="form.unit_type_id != 'ZZ'"
                                        class="col-md-3 center-el-checkbox"
                                    >
                                        <div class="form-group">
                                            <el-checkbox
                                                v-model="form.series_enabled"
                                                @change="changeLotsEnabled"
                                            >
                                                ¿Maneja series?
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    content="Agregar Series"
                                                    placement="top"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </el-checkbox>
                                            <br />
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4 d-flex align-items-end"
                                        v-if="
                                            form.unit_type_id != 'ZZ' &&
                                                form.series_enabled &&
                                                recordId == null
                                        "
                                    >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.lot_code
                                            }"
                                        >
                                            <!-- <label class="control-label">series
                                                <el-tooltip class="item" effect="dark" content="ingrese series de productos" placement="top">
                                                    <i class="fa fa-info-circle"></i>
                                                </el-tooltip>
                                                <el-button style="margin-top:2%;margin-left:15px;" type="primary" icon="el-icon-edit-outline" @click.prevent="clickLotcode"></el-button>
                      </label>-->
                                            <el-button
                                                style="margin-top:2%;margin-left:15px;"
                                                type="primary"
                                                icon="el-icon-edit-outline"
                                                @click.prevent="clickLotcode"
                                            ></el-button>

                                            <small
                                                class="text-danger"
                                                v-if="errors.lot_code"
                                                v-text="errors.lot_code[0]"
                                            ></small>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="col-12 col-lg-6 col-xl-3"
                                    v-if="configuration.lots_enabled"
                                >
                                    <div
                                        v-if="form.unit_type_id != 'ZZ'"
                                        class="col-md-3 center-el-checkbox"
                                    >
                                        <div class="form-group">
                                            <el-checkbox
                                                v-model="form.lots_enabled"
                                                @change="changeLotsEnabled"
                                                >¿Maneja lotes?</el-checkbox
                                            >
                                            <br />
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-12"
                                        v-if="
                                            form.unit_type_id != 'ZZ' &&
                                                form.lots_enabled
                                        "
                                    >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.lot_code
                                            }"
                                        >
                                            <label class="control-label"
                                                >Código lote</label
                                            >
                                            <el-input v-model="form.lot_code">
                                                <i
                                                    slot="prefix"
                                                    class="el-icon-edit-outline"
                                                ></i>
                                            </el-input>
                                            <small
                                                class="text-danger"
                                                v-if="errors.lot_code"
                                                v-text="errors.lot_code[0]"
                                            ></small>
                                        </div>
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.date_of_due
                                            }"
                                            v-if="form.unit_type_id != 'ZZ'"
                                        >
                                            <label class="control-label">
                                                Fecha de Vencimiento
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    content="Fecha Vencimiento del lote"
                                                    placement="top"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-date-picker
                                                class="col-md-12"
                                                v-model="form.date_of_due"
                                                type="date"
                                                value-format="yyyy-MM-dd"
                                                :clearable="true"
                                            ></el-date-picker>
                                            <small
                                                class="text-danger"
                                                v-if="errors.date_of_due"
                                                v-text="errors.date_of_due[0]"
                                            ></small>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="col-12 col-lg-6 col-xl-3"
                                    v-if="configuration.color_size_enabled"
                                >
                                    <div
                                        v-if="form.unit_type_id != 'ZZ'"
                                        class="col-md-4 center-el-checkbox"
                                    >
                                        <div class="form-group">
                                            <el-checkbox
                                                :disabled="recordId != null"
                                                v-model="form.has_color_size"
                                            >
                                                ¿Maneja Color y Talla ?
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    content="ingresa talla y color del producto"
                                                    placement="top"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </el-checkbox>
                                            <br />
                                        </div>
                                        <div
                                            class="d-flex align-items-end"
                                            v-if="
                                                form.unit_type_id != 'ZZ' &&
                                                    form.has_color_size &&
                                                    recordId == null
                                            "
                                        >
                                            <div
                                                class="form-group"
                                                :class="{
                                                    'has-danger':
                                                        errors.has_color_size
                                                }"
                                            >
                                                <el-button
                                                    style="margin-top:2%;margin-left:15px;"
                                                    type="primary"
                                                    icon="el-icon-edit-outline"
                                                    @click.prevent="
                                                        clickColorSize
                                                    "
                                                ></el-button>

                                                <small
                                                    class="text-danger"
                                                    v-if="errors.has_color_size"
                                                    v-text="
                                                        errors.has_color_size[0]
                                                    "
                                                ></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="col-12 col-lg-6 col-xl-3"
                                    v-if="configuration.transform_item"
                                >
                                    <div
                                        v-if="form.unit_type_id != 'ZZ'"
                                        class="col-md-3 center-el-checkbox"
                                    >
                                        <div class="form-group">
                                            <el-checkbox
                                                v-model="form.is_manufactured"
                                            >
                                                ¿Se fabrica?
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    content="Producto principal para transformación"
                                                    placement="top"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </el-checkbox>
                                        </div>
                                    </div>
                                </div>
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
                                                v-model="form.is_promotion"
                                            >
                                                ¿Maneja Promoción?
                                                <el-tooltip
                                                    class="item"
                                                    effect="dark"
                                                    content="Ingrese cantidad Promoción"
                                                    placement="top"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </el-checkbox>
                                            <br />
                                        </div>
                                    </div>
                                    <!-- Sólo muestra este div si form.is_promotion es true -->
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
                                                v-model="form.promotion_count"
                                                type="number"
                                            >
                                                <i
                                                    slot="prefix"
                                                    class="el-icon-edit-outline"
                                                ></i>
                                            </el-input>
                                            <small
                                                class="text-danger"
                                                v-if="errors.promotion_count"
                                                v-text="
                                                    errors.promotion_count[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <br />
                            <div class="col-md-12">
                                <!-- <h6 class="separator-title">
                                    Campos adicionales
                </h6>-->
                            </div>
                            <div class="row col-md-12">
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Imágen
                                            <span class="text-danger"></span></label>
                                        <el-upload class="avatar-uploader" :data="{ type: 'items' }" :headers="headers" :action="`/${resource}/uploads`" :show-file-list="false" :on-success="onSuccess">
                                            <img v-if="form.image_url" :src="form.image_url" class="avatar" />
                                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                        </el-upload>
                                    </div>
                </div>-->

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
                                            <i class="fa fa-info-circle"></i>
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
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Imágen
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
                    </el-tab-pane>
                    <el-tab-pane
                        v-if="form.unit_type_id != 'ZZ'"
                        label="Almacenes"
                    >
                        <div class="row">
                            <div class="col-12">
                                <h4 class="separator-title mt-0">
                                    <strong>Precios por Almacén</strong>
                                </h4>
                                <!-- <h4  class="separator-title mt-0">
                                Precios por Almacén
                </h4>-->
                                <table>
                                    <tbody>
                                        <tr
                                            v-for="w in form.warehouse_prices"
                                            :key="w.id"
                                        >
                                            <td width="60%">
                                                <h5>{{ w.warehouse }}</h5>
                                            </td>
                                            <td>
                                                <el-input
                                                    v-model="w.price"
                                                    @input="$forceUpdate()"
                                                    placeholder="Precio de almacen"
                                                ></el-input>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="Lista de Precios">
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
                                        <i class="fa fa-info-circle"></i>
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
                                                            class="fa fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </th>
                                                <th
                                                    width="13%"
                                                    class="text-white text-center"
                                                >
                                                    Precio
                                                    <br />unitario
                                                </th>
                                                <th
                                                    width="10%"
                                                    class="text-white text-center"
                                                >
                                                    Total
                                                </th>
                                                <th
                                                    class="text-white text-center"
                                                >
                                                    Almacén
                                                </th>
                                                <!-- <th class="text-center">
                                                            P. Defecto
                        </th>-->
                                                <th class="text-white">
                                                    MAX
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Check para indicar que es la Maxima cantdad en su presentación"
                                                        placement="top"
                                                    >
                                                        <i
                                                            class="fa fa-info-circle"
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
                                                    <td class="text-center">
                                                        {{ row.unit_type_id }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ row.description }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ row.quantity_unit }}
                                                    </td>
                                                    <td class="text-center">
                                                        <el-input
                                                            v-model="row.price2"
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

                                                    <td class="text-center">
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
                                                    <td>
                                                        <div class="form-group">
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
                                                        <div class="form-group">
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
                                                        </div>
                                                    </td>
                                                    <td>
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
                                                </template>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                        <el-tab-pane label="Bonificaciones"
                        name="bonus"
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
                                        Bonificaciones de precios
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades"
                                            placement="top"
                                        >
                                            <i class="fa fa-info-circle"></i>
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
                                                                class="fa fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </th>

                                                    <th class="text-white text-center">Cant. Min.</th>
                                                    <!-- <th class="text-white text-center">Cant. Max.</th> -->
                                                    <th class="text-white text-center">Cant Bon.</th>
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
                                                        <!-- <td class="text-center">
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
                                                                type="number"
                                                                step="0.01"
                                                                pattern="^\d*(\.\d{0,2})?$"
                                                            >
                                                                <i
                                                                    slot="prefix"
                                                                    class="el-icon-edit-outline"
                                                                ></i>
                                                            </el-input>
                                                        </td> -->
                                                
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
                    <el-tab-pane label="Compras">
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
                    <el-tab-pane
                        label="Categoria Madera"
                        v-if="configuration.maderera"
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
                </el-tabs>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()"
                    >Cancelar</el-button
                >
                <el-button
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
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
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}

@media screen and (max-width: 1280px) {
    .label-text {
        display: none;
        /* Oculta el texto del label */
    }
}
</style>

<script>
// import PercentagePerception from './partials/percentage_perception.vue'
import LotsForm from "./partials/lots.vue";
import ColorSize from "./partials/color_size.vue";
export default {
    props: ["showDialog", "recordId", "external", "worker"],
    components: {
        LotsForm,
        ColorSize
    },

    data() {
        return {
            loading: true,
            allEstablishment: false,
            showDialogLots: false,
            showDialogColorSize: false,
            form_category: {
                add: false,
                name: null,
                id: null
            },
            form_brand: {
                add: false,
                name: null,
                id: null
            },
            warehouses: [],
            categoria_madera: [],
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
                promotion_count: null
            },
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
                price_default: 2
            },
            attribute_types: [],
            area_id: 2,
            timer: null,
            madera: []
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.unit_types = response.data.unit_types;
            this.accounts = response.data.accounts;
            this.currency_types = response.data.currency_types;
            this.system_isc_types = response.data.system_isc_types;
            this.affectation_igv_types = response.data.affectation_igv_types;
            this.warehouses = response.data.warehouses;
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
    },

    methods: {
        updateCommercialTreatmentItem(idx) {
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
        clickDelete(id) {
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
                });
        },
        changeHasPerception() {
            if (!this.form.has_perception) {
                this.form.percentage_perception = null;
            }
        },
        clickAddRow() {
            this.form.item_unit_types.push({
                id: null,
                description: null,
                unit_type_id: "NIU",
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 2,
                warehouse_id: null
            });
        },
        clickCancel(index) {
            this.form.item_unit_types.splice(index, 1);
            // this.initDocumentTypes()
            // this.showAddButton = true
        },
        initForm() {
            (this.loading_submit = false), (this.errors = {});
            this.form = {
                categoria_madera: [],
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
                origin: null
            };
            this.show_has_igv = true;
            this.enabled_percentage_of_profit = false;
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
            }
            // if(!this.record){
            //     this.form.has_igv= true
            // }
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
                    total: (Number(i.price2) * Number(i.quantity_unit)).toFixed(
                        2
                    )
                };
            });
        },
        loadRecord() {
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.changeAffectationIgvType();
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
            // if (this.configuration.maderera) {
            //   let sale_unit_price = this.form.sale_unit_price;
            //   for (let i = 0; i < this.form.item_unit_types.length; i++) {
            //     let unit_type = this.form.item_unit_types[i];
            //     this.form.item_unit_types[i].price2 = sale_unit_price;
            //     this.undToTotal(i, sale_unit_price, unit_type.quantity_unit);
            //   }
            // }
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
            if (this.form.max_quantity && !this.form.max_quantity_description) {
                this.$toast.warning(
                    "Ingrese una descripción del contenedor para la cantidad máxima"
                );
                return false;
            }
            if (!this.form.category_id) {
                this.$toast.warning("Seleccione una categoria");
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
                // if (!this.form.lot_code)
                //     return this.$toast.error("Código de lote es requerido");
                // if (!this.form.date_of_due)
                //     return this.$toast.error(
                //         "Fecha de vencimiento es requerido si lotes esta habilitado."
                //     );
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

            this.loading_submit = true;
            this.form.all_establishment = this.allEstablishment;
            this.form.categoria_madera = this.categoria_madera.filter(
                c => c.precio != null && c.precio > 0
            );
            console.log(
                "🚀 ~ file: form.vue:2309 ~ submit ~ this.form:",
                this.form
            );
            await this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        if (this.external) {
                            this.$emit("add", response.data.data);
                            //this.$eventHub.$emit('reloadDataItems', response.data.id)
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
            /* this.form.categoria_madera = [...this.categoria_madera]; */
            /* this.form.categoria_madera = this.categoria_madera; */
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
        saveCategory() {
            this.form_category.add = false;

            this.$http
                .post(`/items/categories`, this.form_category)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.categories.push(response.data.data);
                        this.form.category_id = response.data.data.id;
                        this.form_category.name = null;
                    } else {
                        this.$toast.error("No se guardaron los cambios");
                    }
                })
                .catch(error => {});
        },
        saveBrand() {
            this.form_brand.add = false;

            this.$http
                .post(`/brands`, this.form_brand)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.brands.push(response.data.data);
                        this.form_brand.name = null;
                    } else {
                        this.$toast.error("No se guardaron los cambios");
                    }
                })
                .catch(error => {});
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
        maderaUpdate() {
            /* this.reloadTables(); */
        }
        /* maderaUpdate(idx) {
      if (this.timer) clearTimeout(this.timer);
      this.timer = setTimeout(async () => {
        let categoria_madera = this.form.categoria_madera[idx];
        const response = await this.$http.post(
          `/items/store/${ItemCategoriaMadera}`,
          item_categoria_madera
        );
        if (response.data.success) {
          this.$toast.success("Se actualizó correctamente");
        }
      }, 700);
    }, */
    }
};
</script>
