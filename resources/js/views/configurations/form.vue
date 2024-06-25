<!-- Configuraciones Avanzados -->
<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="my-0 text-white">
                    <i class="fa fa-cogs"></i>
                    Configuraciones
                </h4>
            </div>
            <template>
                <div id="app" class="custom-tabs">
                    <el-tabs v-model="activeTab" type="border-card">
                        <!-- Configuracion si es Arca -->
                        <el-tab-pane
                            label="Visual Hotel"
                            name="hotel"
                            v-if="isArca"
                        >
                            <div class="row">
                                <template v-if="form.hotels">
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Tiempo de alarma de alquileres
                                                por vencer
                                            </label>

                                            <el-input-number
                                                @change="submit"
                                                v-model="form.alarm_to_end"
                                            >
                                            </el-input-number>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Tiempo para el calculo del
                                                inicio del dia
                                            </label>

                                            <el-time-picker
                                                style="width: 100%;"
                                                value-format="HH:mm:ss"
                                                :format="'hh:mm A'"
                                                :picker-options="{
                                                    format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                                }"
                                                timezone="America/Lima"
                                                v-model="form.time_to_enter"
                                            ></el-time-picker>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Tiempo para el calculo del
                                                final del dia
                                            </label>

                                            <el-time-picker
                                                style="width: 100%;"
                                                value-format="HH:mm:ss"
                                                :format="'hh:mm A'"
                                                :picker-options="{
                                                    format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                                }"
                                                timezone="America/Lima"
                                                v-model="form.time_to_leave"
                                            ></el-time-picker>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Tiempo de mantenimiento
                                            </label>

                                            <el-input-number
                                                @change="submit"
                                                v-model="form.time_manteniment"
                                            >
                                            </el-input-number>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Limite de la garantía -
                                                frigobar
                                            </label>
                                            <el-input-number
                                                @change="submit"
                                                v-model="
                                                    form.credit_line_hotel_limit
                                                "
                                            >
                                            </el-input-number>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Descuento aplicado por día a
                                                cambio del servicio x habitación
                                            </label>
                                            <el-input-number
                                                @change="submit"
                                                v-model="
                                                    form.discount_amount_instead_service
                                                "
                                            >
                                            </el-input-number>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane v-if="!isArca" name="entorno">
                            <template #label>
                                <div class="tab-label">
                                    <i class="fa fa-cogs tab-icon"></i>
                                    <span class="tab-text"
                                        >Configuración de Entorno</span
                                    >
                                </div>
                            </template>
                            <div class="tab-content">
                                <!-- Tabs anidados dentro del tab de "Configuracion de entorno" -->
                                <el-tabs type="card" v-model="modes">
                                    <!-- Modos---- -->
                                    <el-tab-pane name="modes">
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="el-icon-setting tab-icon"
                                                ></i>
                                                <span class="tab-text"
                                                    >Modos</span
                                                >
                                            </div>
                                        </template>
                                        <div class="col-md-6">
                                            <label class="control-label">
                                                Buscar
                                            </label>
                                            <div class="form-group">
                                                <el-input
                                                    v-model="searchQueryModes"
                                                    placeholder="Buscar..."
                                                    style="width: 240px"
                                                    maxlength="20"
                                                    show-word-limit
                                                    type="text"
                                                ></el-input>
                                                <!-- <el-input v-model="searchQuery" placeholder="Buscar..." style="width: 240px" maxlength="10" show-word-limit type="text"></el-input> -->
                                            </div>
                                        </div>

                                        <div
                                            class="nested-tab-content"
                                            ref="modesTab"
                                        >
                                            <div class="row">
                                                <!-- Crédito en Nota de Venta -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-credit-card tab-icon"
                                                            ></i>
                                                            Crédito en Nota de
                                                            Venta
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.credits
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Entorno Colegio -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-school tab-icon"
                                                            ></i>
                                                            Entorno Colegio
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.college
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Entorno Restaurant -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-utensils tab-icon"
                                                            ></i>
                                                            Entorno
                                                            Restaurant</label
                                                        >
                                                        <el-switch
                                                            v-model="
                                                                form.restaurant
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Entorno Hotel -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-hotel tab-icon"
                                                            ></i>
                                                            Entorno Hotel</label
                                                        >
                                                        <el-switch
                                                            v-model="
                                                                form.hotels
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Entorno Internet -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-wifi tab-icon"
                                                            ></i>
                                                            Entorno
                                                            Internet</label
                                                        >
                                                        <el-switch
                                                            v-model="
                                                                form.internet
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Peaje -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="el-icon-tickets tab-icon"
                                                            ></i>
                                                            Entorno Peaje</label
                                                        >
                                                        <el-switch
                                                            v-model="form.toll"
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Boticas & Hospital       -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-pills tab-icon"
                                                            ></i>
                                                            Entorno Boticas &
                                                            Hospital
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.health_network
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div
                                                        class="card-header bg-primary"
                                                    >
                                                        <h4
                                                            class="my-0 text-white"
                                                        >
                                                            <i
                                                                class="fas fa-business-time"
                                                            ></i>
                                                            COMPLEMENTOS DE
                                                            MODELO DE NEGOCIO
                                                        </h4>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <!-- Habilitar Promociones -->
                                                            <div
                                                                class="col-md-3"
                                                            >
                                                                <label
                                                                    class="control-label w-100"
                                                                >
                                                                    <i
                                                                        class="fas fa-tags tab-icon"
                                                                    ></i>
                                                                    Habilitar
                                                                    Promociones
                                                                    <el-tooltip
                                                                        class="item"
                                                                        effect="dark"
                                                                        content="Visualiza en CAJA y ADMINISTRADOR la función que permite acceder a una promoción, llegando a x items vendidos"
                                                                        placement="top-start"
                                                                    >
                                                                        <i
                                                                            class="fa fa-info-circle"
                                                                        ></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch
                                                                    v-model="
                                                                        form.promotions_sell
                                                                    "
                                                                    active-text="Si"
                                                                    inactive-text="No"
                                                                    @change="
                                                                        submit
                                                                    "
                                                                ></el-switch>
                                                            </div>
                                                            <div
                                                                class="col-md-3"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        form.promotions_cant_purchase
                                                                    "
                                                                    placeholder="Cantidad de ventas para acceder a la promoción "
                                                                    size="normal"
                                                                    @blur="
                                                                        submit
                                                                    "
                                                                >
                                                                </el-input>
                                                            </div>

                                                            <!-- Habilitar Contabilidad -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-calculator tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Contabilidad</label
                                                                    >
                                                                    <el-switch
                                                                        v-model="
                                                                            form.accounting_mode
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>
                                                            <!-- Habilitar Series - Productos -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-barcode tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Series -
                                                                        Productos
                                                                    </label>

                                                                    <el-switch
                                                                        v-model="
                                                                            form.series_enabled
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar Lotes - Productos -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-boxes tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Lotes -
                                                                        Productos
                                                                    </label>

                                                                    <el-switch
                                                                        v-model="
                                                                            form.lots_enabled
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar Color & Talla - Productos -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-tshirt tab-icon"
                                                                        ></i>
                                                                        <i
                                                                            class="fas fa-palette"
                                                                        ></i>
                                                                        Habilitar
                                                                        Color &
                                                                        Talla -
                                                                        Productos
                                                                    </label>

                                                                    <el-switch
                                                                        v-model="
                                                                            form.color_size_enabled
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar Guías de Remisión (CAJA Y ADMINISTRADOR) -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-truck tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Guías de
                                                                        Remisión
                                                                        (CAJA Y
                                                                        ADMINISTRADOR)
                                                                    </label>
                                                                    <el-switch
                                                                        v-model="
                                                                            form.dispatch
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar cotización (CAJA Y ADMINISTRADOR) -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-file-invoice-dollar tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Cotización
                                                                        (CAJA Y
                                                                        ADMINISTRADOR)
                                                                    </label>
                                                                    <el-switch
                                                                        v-model="
                                                                            form.quotation
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar Consignación (CAJA Y ADMINISTRADOR) -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-handshake tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Consignación
                                                                        (CAJA Y
                                                                        ADMINISTRADOR)

                                                                        <el-tooltip
                                                                            content="Crear y liquidar consignaciones desde caja"
                                                                        >
                                                                            <i
                                                                                class="fa fa-info-circle"
                                                                            ></i>
                                                                        </el-tooltip>
                                                                    </label>
                                                                    <el-switch
                                                                        v-model="
                                                                            form.consignment
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Producto penalidad - Consignación -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <template
                                                                    id="select-append"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-exclamation-circle tab-icon"
                                                                        ></i>
                                                                        Producto
                                                                        penalidad
                                                                        -
                                                                        Consignación
                                                                    </label>
                                                                    <div
                                                                        class="el-input el-input-group el-input-group--append"
                                                                    >
                                                                        <el-select
                                                                            :disabled="
                                                                                !form.consignment
                                                                            "
                                                                            @focus="
                                                                                $event.target.select()
                                                                            "
                                                                            ref="producto"
                                                                            v-model="
                                                                                form.item_consignment_id
                                                                            "
                                                                            @change="
                                                                                changeItem
                                                                            "
                                                                            filterable
                                                                            remote
                                                                            placeholder="Buscar......"
                                                                            popper-class="el-select-items"
                                                                            @visible-change="
                                                                                focusTotalItem
                                                                            "
                                                                            slot="prepend"
                                                                            id="select-width"
                                                                            :remote-method="
                                                                                searchRemoteItems
                                                                            "
                                                                            :loading="
                                                                                loading_search
                                                                            "
                                                                        >
                                                                            <el-option
                                                                                v-for="option in items"
                                                                                :key="
                                                                                    option.id
                                                                                "
                                                                                :value="
                                                                                    option.id
                                                                                "
                                                                                :label="
                                                                                    option.full_description ||
                                                                                        option.description
                                                                                "
                                                                            ></el-option>
                                                                        </el-select>
                                                                    </div>
                                                                </template>
                                                            </div>

                                                            <!-- Habilitar Transformación de producto -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-exchange-alt tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Transformación
                                                                        de
                                                                        producto
                                                                    </label>
                                                                    <el-switch
                                                                        v-model="
                                                                            form.transform_item
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>

                                                            <!-- Habilitar Tratamiento comercial Producto -->
                                                            <div
                                                                class="col-md-3 mt-4"
                                                            >
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fas fa-hand-holding-usd tab-icon"
                                                                        ></i>
                                                                        Habilitar
                                                                        Tratamiento
                                                                        comercial
                                                                        Producto
                                                                        <el-tooltip
                                                                            class="item"
                                                                            effect="dark"
                                                                            content="Trato comercial"
                                                                            placement="top-start"
                                                                        >
                                                                            <i
                                                                                class="fa fa-info-circle"
                                                                            ></i>
                                                                        </el-tooltip>
                                                                    </label>

                                                                    <el-switch
                                                                        v-model="
                                                                            form.commercial_treatment_items
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label
                                                                    for="text-3"
                                                                >
                                                                    Texto pie de
                                                                    página
                                                                    <el-tooltip
                                                                        class="item"
                                                                        effect="dark"
                                                                        content="Texto que va en la parte inferior de los documentos"
                                                                        placement="top-start"
                                                                    >
                                                                        <i
                                                                            class="fa fa-info-circle"
                                                                        ></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-input
                                                                    class="w-100"
                                                                    v-model="
                                                                        form.footer_text
                                                                    "
                                                                    placeholder="Pie de página"
                                                                    size="normal"
                                                                    type="textarea"
                                                                    rows="3"
                                                                    @input="
                                                                        saveSubmitDebounce
                                                                    "
                                                                ></el-input>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <!-- Contable---- -->
                                    <el-tab-pane name="accounting">
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="el-icon-document tab-icon"
                                                ></i>
                                                <span class="tab-text"
                                                    >Contable</span
                                                >
                                            </div>
                                        </template>
                                        <div class="col-md-6">
                                            <label class="control-label">
                                                buscar
                                            </label>
                                            <div class="form-group">
                                                <el-input
                                                    v-model="
                                                        searchQueryAccounting
                                                    "
                                                    placeholder="Buscar..."
                                                    style="width: 240px"
                                                    maxlength="20"
                                                    show-word-limit
                                                    type="text"
                                                ></el-input>
                                                <!-- <el-input v-model="searchQuery" placeholder="Buscar..." style="width: 240px" maxlength="10" show-word-limit type="text"></el-input> -->
                                            </div>
                                        </div>
                                        <div
                                            class="nested-tab-content"
                                            ref="accountingTab"
                                        >
                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-exchange-alt tab-icon"
                                                            ></i>
                                                            Cambiar Afectación
                                                            IGV (CAJA)
                                                            <el-tooltip
                                                                content="Permite cambiar la afectación de IGV en caja"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.affectation_optional
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-3 mt-4"
                                                    v-if="
                                                        typeUser != 'integrator'
                                                    "
                                                >
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-sort-numeric-up tab-icon"
                                                        ></i>
                                                        Cantidad decimales POS
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.decimal_quantity
                                                        }"
                                                    >
                                                        <el-input-number
                                                            v-model="
                                                                form.decimal_quantity
                                                            "
                                                            @change="submit"
                                                            :min="2"
                                                            :max="10"
                                                        ></el-input-number>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.decimal_quantity
                                                            "
                                                            v-text="
                                                                errors
                                                                    .decimal_quantity[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>

                                                <div
                                                    class="col-md-3 mt-4"
                                                    v-if="
                                                        typeUser != 'integrator'
                                                    "
                                                >
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-recycle tab-icon"
                                                        ></i>
                                                        Impuesto bolsa plástica
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.amount_plastic_bag_taxes
                                                        }"
                                                    >
                                                        <el-input-number
                                                            v-model="
                                                                form.amount_plastic_bag_taxes
                                                            "
                                                            @change="
                                                                changeAmountPlasticBagTaxes
                                                            "
                                                            :precision="2"
                                                            :step="0.1"
                                                            :max="0.5"
                                                            :min="0.1"
                                                        ></el-input-number>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.amount_plastic_bag_taxes
                                                            "
                                                            v-text="
                                                                errors
                                                                    .amount_plastic_bag_taxes[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.affectation_igv_type_id
                                                        }"
                                                    >
                                                        <label
                                                            class="control-label"
                                                        >
                                                            <i
                                                                class="fas fa-file-invoice-dollar tab-icon"
                                                            ></i>
                                                            Tipo de afectación
                                                            Venta
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Tipo de afectación predeterminada al registrar nuevo producto"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-select
                                                            v-model="
                                                                form.affectation_igv_type_id
                                                            "
                                                            @change="submit"
                                                            filterable
                                                        >
                                                            <el-option
                                                                v-for="option in affectation_igv_types"
                                                                :key="option.id"
                                                                :value="
                                                                    option.id
                                                                "
                                                                :label="
                                                                    option.description
                                                                "
                                                            ></el-option>
                                                        </el-select>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.affectation_igv_type_id
                                                            "
                                                            v-text="
                                                                errors
                                                                    .affectation_igv_type_id[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-paper-plane tab-icon"
                                                        ></i>
                                                        Envío de comprobantes
                                                        automático
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.send_auto
                                                        }"
                                                    >
                                                        <el-switch
                                                            v-model="
                                                                form.send_auto
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.send_auto
                                                            "
                                                            v-text="
                                                                errors
                                                                    .send_auto[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-3 mt-4"
                                                    v-if="
                                                        typeUser != 'integrator'
                                                    "
                                                >
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-calendar-alt tab-icon"
                                                        ></i>
                                                        Ejecutar Tareas
                                                        Programadas
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.cron
                                                        }"
                                                    >
                                                        <el-switch
                                                            v-model="form.cron"
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                        <small
                                                            class="text-danger"
                                                            v-if="errors.cron"
                                                            v-text="
                                                                errors.cron[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-calendar-check tab-icon"
                                                        ></i>
                                                        Cambiar fecha de emisión
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.change_date_emit
                                                        }"
                                                    >
                                                        <el-switch
                                                            v-model="
                                                                form.change_date_emit
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.change_date_emit
                                                            "
                                                            v-text="
                                                                errors
                                                                    .change_date_emit[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-ban tab-icon"
                                                        ></i>
                                                        Restringir fecha de
                                                        comprobante
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.restrict_receipt_date
                                                        }"
                                                    >
                                                        <el-switch
                                                            v-model="
                                                                form.restrict_receipt_date
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.restrict_receipt_date
                                                            "
                                                            v-text="
                                                                errors
                                                                    .restrict_receipt_date[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-calendar-day tab-icon"
                                                        ></i>
                                                        Días transcurridos para
                                                        emitir dcto
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.days_before_emit
                                                        }"
                                                    >
                                                        <el-select
                                                            v-model="
                                                                form.days_before_emit
                                                            "
                                                            @change="submit"
                                                        >
                                                            <el-option
                                                                v-for="day in days"
                                                                :key="
                                                                    `${day.id}-d`
                                                                "
                                                                :value="
                                                                    day.value
                                                                "
                                                                :label="
                                                                    `${
                                                                        day.value
                                                                    } ${
                                                                        day.value >
                                                                        1
                                                                            ? ' días'
                                                                            : ' día'
                                                                    }`
                                                                "
                                                            ></el-option>
                                                        </el-select>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.days_before_emit
                                                            "
                                                            v-text="
                                                                errors
                                                                    .days_before_emit[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <label
                                                        class="control-label"
                                                    >
                                                        <i
                                                            class="fas fa-receipt tab-icon"
                                                        ></i>
                                                        Impuesto incluido en
                                                        registro de productos
                                                    </label>
                                                    <div
                                                        class="form-group"
                                                        :class="{
                                                            'has-danger':
                                                                errors.include_igv
                                                        }"
                                                    >
                                                        <el-switch
                                                            v-model="
                                                                form.include_igv
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                        <small
                                                            class="text-danger"
                                                            v-if="
                                                                errors.include_igv
                                                            "
                                                            v-text="
                                                                errors
                                                                    .include_igv[0]
                                                            "
                                                        ></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>

                                    <!-- Visual---- -->
                                    <el-tab-pane name="visual">
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="el-icon-view tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Configuración General
                                                </span>
                                            </div>
                                        </template>
                                        <template>
                                            <div class="container mt-5">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="col-md-6">
                                                            <label
                                                                class="control-label"
                                                            >
                                                                buscar
                                                            </label>
                                                            <div
                                                                class="form-group"
                                                            >
                                                                <el-input
                                                                    v-model="
                                                                        searchQueryVisual
                                                                    "
                                                                    placeholder="Buscar..."
                                                                    style="width: 240px"
                                                                    maxlength="20"
                                                                    show-word-limit
                                                                    type="text"
                                                                ></el-input>
                                                                <!-- <el-input v-model="searchQuery" placeholder="Buscar..." style="width: 240px" maxlength="10" show-word-limit type="text"></el-input> -->
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="nested-tab-content"
                                                            ref="visualTab"
                                                        >
                                                            <el-row
                                                                :gutter="20"
                                                            >
                                                                <!-- Seccion Gestion de Documento -->
                                                                <el-col
                                                                    :span="12"
                                                                >
                                                                    <el-card
                                                                        class="section-card"
                                                                        shadow="hover"
                                                                    >
                                                                        <div
                                                                            slot="header"
                                                                            class="card-header bg-primary text-white"
                                                                        >
                                                                            <i
                                                                                class="fas fa-file-alt fa-lg"
                                                                            ></i>
                                                                            Gestiones
                                                                            Adicionales
                                                                        </div>
                                                                        <div
                                                                            class="section-content"
                                                                        >
                                                                            <!-- Contenido de la sección 1 -->
                                                                            <div
                                                                                class="row"
                                                                            >
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <label
                                                                                        class="control-label"
                                                                                    >
                                                                                        <i
                                                                                            class="fas fa-redo-alt tab-icon"
                                                                                        ></i>
                                                                                        Recrear
                                                                                        Documento
                                                                                    </label>
                                                                                    <div
                                                                                        class="form-group"
                                                                                        :class="{
                                                                                            'has-danger':
                                                                                                errors.recreat_document
                                                                                        }"
                                                                                    >
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.recreat_document
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                        <small
                                                                                            class="text-danger"
                                                                                            v-if="
                                                                                                errors.recreat_document
                                                                                            "
                                                                                            v-text="
                                                                                                errors
                                                                                                    .recreat_document[0]
                                                                                            "
                                                                                        ></small>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <label
                                                                                        class="control-label"
                                                                                    >
                                                                                        <i
                                                                                            class="fas fa-trash-alt tab-icon"
                                                                                        ></i>
                                                                                        Eliminar
                                                                                        Documento
                                                                                    </label>
                                                                                    <div
                                                                                        class="form-group"
                                                                                        :class="{
                                                                                            'has-danger':
                                                                                                errors.delete_document
                                                                                        }"
                                                                                    >
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.delete_document
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                        <small
                                                                                            class="text-danger"
                                                                                            v-if="
                                                                                                errors.delete_document
                                                                                            "
                                                                                            v-text="
                                                                                                errors
                                                                                                    .delete_document[0]
                                                                                            "
                                                                                        ></small>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Visualiza Usurios en Administrador -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-users-cog tab-icon"
                                                                                            ></i>
                                                                                            Habilita
                                                                                            Usuarios
                                                                                            (Admin)
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Visualiza Usurios en Administrador"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.users_views
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Habilita el boton para pagos de creditos -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-hand-holding-usd tab-icon"
                                                                                            ></i>
                                                                                            Dar
                                                                                            a
                                                                                            crédito
                                                                                            nota
                                                                                            de
                                                                                            venta
                                                                                            (sin
                                                                                            cuotas)
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.sale_note_credit_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-credit-card tab-icon"
                                                                                            ></i>
                                                                                            Requerir
                                                                                            número
                                                                                            de
                                                                                            operación
                                                                                            (YAPE/PLIN/TARJETAS)
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Número de operación obligatorio para emitir comprobante de pago"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.require_code
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-print tab-icon"
                                                                                            ></i>
                                                                                            Guardar
                                                                                            decisión
                                                                                            de
                                                                                            impresión
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.save_pos_printing
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-credit-card tab-icon"
                                                                                            ></i>
                                                                                            Cargo
                                                                                            por
                                                                                            pago
                                                                                            con
                                                                                            tarjeta
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.credit_mode
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-chart-line tab-icon"
                                                                                            ></i>
                                                                                            Ver
                                                                                            venta
                                                                                            diaria
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.view_daily_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-lock tab-icon"
                                                                                            ></i>
                                                                                            Ver
                                                                                            venta
                                                                                            diaria
                                                                                            con
                                                                                            pin
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.view_daily_cash_pin
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Pedidos de Villacorp -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-percentage tab-icon"
                                                                                            ></i>
                                                                                            Descuentos
                                                                                            variante
                                                                                            <el-tooltip
                                                                                                content="Permite recalcular el precio de venta de un producto con descuento a la base imponible"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.discount_with_base_variant
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Números
                                                                                            de
                                                                                            whatsapp
                                                                                            para
                                                                                            enviar
                                                                                            actividad
                                                                                            <a
                                                                                                v-if="
                                                                                                    form.number_activity
                                                                                                "
                                                                                                href="#"
                                                                                                @click.prevent="
                                                                                                    addNumberWhatsapp
                                                                                                "
                                                                                                >[Agregar
                                                                                                +]</a
                                                                                            >
                                                                                        </label>
                                                                                        <el-input
                                                                                            @input="
                                                                                                changeNumberActivity
                                                                                            "
                                                                                            v-model="
                                                                                                form.number_activity
                                                                                            "
                                                                                        >
                                                                                        </el-input>
                                                                                        <small>
                                                                                            <el-tag
                                                                                                class="mt-1"
                                                                                                v-for="(number,
                                                                                                idx) in numbers"
                                                                                                :key="
                                                                                                    idx
                                                                                                "
                                                                                                closable
                                                                                                @close="
                                                                                                    removeNumberWhatsapp(
                                                                                                        idx
                                                                                                    )
                                                                                                "
                                                                                            >
                                                                                                {{
                                                                                                    number.number
                                                                                                }}
                                                                                            </el-tag>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </el-card>
                                                                </el-col>

                                                                <!-- Seccion Caja -->
                                                                <el-col
                                                                    :span="12"
                                                                >
                                                                    <el-card
                                                                        class="section-card"
                                                                        shadow="hover"
                                                                    >
                                                                        <div
                                                                            slot="header"
                                                                            class="card-header bg-primary text-white"
                                                                        >
                                                                            <i
                                                                                class="fas fa-cash-register fa-lg"
                                                                            ></i>
                                                                            Gestión
                                                                            de
                                                                            Caja
                                                                        </div>
                                                                        <div
                                                                            class="section-content"
                                                                        >
                                                                            <!-- Contenido de la sección Caja -->
                                                                            <div
                                                                                class="row"
                                                                            >
                                                                                <!-- Multiples Caja (Usuario Cajero) -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-cash-register tab-icon"
                                                                                            ></i>
                                                                                            Multiples
                                                                                            Cajas
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Multiples Cajas, para usuario CAJERO"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.multiple_boxes
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Acciones en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-cash-register tab-icon"
                                                                                            ></i>
                                                                                            Acciones
                                                                                            en
                                                                                            Caja
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Acciones en CAJA, como anulación de comprobantes, pagos, nota de crédito"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.caja_actions
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Venta Rapida (Modulo Caja) -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-bolt tab-icon"
                                                                                            ></i>
                                                                                            Venta
                                                                                            Rapida
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Venta Rapida modulo de CAJA (Activar en Establecimientos)"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.sales_quick
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Vendedores en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-user-tie tab-icon"
                                                                                            ></i>
                                                                                            Vendedores
                                                                                            en
                                                                                            caja
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Aciva selección de Vendedores en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.seller_caja
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mostrar gastos / ingresos en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-eye tab-icon"
                                                                                            ></i>
                                                                                            Mostrar
                                                                                            Gastos
                                                                                            e
                                                                                            Ingresos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Mostrar Modal de Gastos e Ingresos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.show_expenses_incomes_caja
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Editar Precio Venta en Caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-edit tab-icon"
                                                                                            ></i>
                                                                                            Editar
                                                                                            Precio
                                                                                            Venta
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Editar Precio de venta en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <div
                                                                                            class="form-group"
                                                                                            :class="{
                                                                                                'has-danger':
                                                                                                    errors.edit_price_sales
                                                                                            }"
                                                                                        >
                                                                                            <el-switch
                                                                                                v-model="
                                                                                                    form.edit_price_sales
                                                                                                "
                                                                                                active-text="Si"
                                                                                                inactive-text="No"
                                                                                                @change="
                                                                                                    submit
                                                                                                "
                                                                                            ></el-switch>
                                                                                            <small
                                                                                                class="text-danger"
                                                                                                v-if="
                                                                                                    errors.edit_price_sales
                                                                                                "
                                                                                                v-text="
                                                                                                    errors
                                                                                                        .edit_price_sales[0]
                                                                                                "
                                                                                            ></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Editar Cantidad en Caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-calculator tab-icon"
                                                                                            ></i>
                                                                                            Editar
                                                                                            Cantidad
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Editar Cantidad de venta en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <div
                                                                                            class="form-group"
                                                                                            :class="{
                                                                                                'has-danger':
                                                                                                    errors.quantity_cash
                                                                                            }"
                                                                                        >
                                                                                            <el-switch
                                                                                                v-model="
                                                                                                    form.quantity_cash
                                                                                                "
                                                                                                active-text="Si"
                                                                                                inactive-text="No"
                                                                                                @change="
                                                                                                    submit
                                                                                                "
                                                                                            ></el-switch>
                                                                                            <small
                                                                                                class="text-danger"
                                                                                                v-if="
                                                                                                    errors.quantity_cash
                                                                                                "
                                                                                                v-text="
                                                                                                    errors
                                                                                                        .quantity_cash[0]
                                                                                                "
                                                                                            ></small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Editar subtotal en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-pencil-alt tab-icon"
                                                                                            ></i>
                                                                                            Editar
                                                                                            Subtotal
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Editar Sub Total de venta en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.edit_subtotal_box
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-print tab-icon"
                                                                                            ></i>
                                                                                            Reimpresión
                                                                                            de
                                                                                            documentos
                                                                                            -
                                                                                            caja
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.print_document_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-print tab-icon"
                                                                                            ></i>
                                                                                            Todos los productos - caja
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.all_items_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </el-card>
                                                                </el-col>
                                                            </el-row>
                                                            <el-row
                                                                :gutter="20"
                                                            >
                                                                <!-- Section 3 -->
                                                                <el-col
                                                                    :span="12"
                                                                >
                                                                    <el-card
                                                                        class="section-card"
                                                                        shadow="hover"
                                                                    >
                                                                        <div
                                                                            slot="header"
                                                                            class="card-header bg-primary text-white"
                                                                        >
                                                                            <i
                                                                                class="fas fa-box fa-lg"
                                                                            ></i>
                                                                            Gestión
                                                                            de
                                                                            Productos
                                                                            aaa
                                                                        </div>
                                                                        <div
                                                                            class="section-content"
                                                                        >
                                                                            <!-- Contenido de Gestion de Productos-->
                                                                            <div
                                                                                class="row"
                                                                            >
                                                                                <!-- Crear Productos en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-box tab-icon"
                                                                                            ></i>
                                                                                            Crear
                                                                                            Productos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Crear Productos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.product_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Ajuste de Stock (Adminsitrador) -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-tools tab-icon"
                                                                                            ></i>
                                                                                            Permitir
                                                                                            Ajuste
                                                                                            Stock
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Permite Ajustar Stock en Administrador"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.item_adjustment
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Editar producto en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-pencil-ruler tab-icon"
                                                                                            ></i>
                                                                                            Editar
                                                                                            Producto
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Editar Productos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.edit_product_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Crear productos compuestos en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-cubes tab-icon"
                                                                                            ></i>
                                                                                            Crear
                                                                                            Productos
                                                                                            Compuestos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Crear Productos Compuestos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.item_set_caja
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Modificar cantidad de productos compuestos (Caja) -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-box-open tab-icon"
                                                                                            ></i>
                                                                                            Editar
                                                                                            Productos
                                                                                            Compuestos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Modificar Cantidad de Productos Compuestos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.item_set_quantity_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mostrar stock caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-eye tab-icon"
                                                                                            ></i>
                                                                                            Mostrar
                                                                                            Sock
                                                                                            de
                                                                                            Productos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Mostrar Stock de productos en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.show_stock_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit;
                                                                                                stock_control();
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mostrar productos por vencer en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-hourglass-half tab-icon"
                                                                                            ></i>
                                                                                            Mostrar
                                                                                            Productos
                                                                                            X
                                                                                            Vencer
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Mostrar Productos por vencer en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.items_due_caja
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mostrar toda la descripción del producto en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-align-left tab-icon"
                                                                                            ></i>
                                                                                            Mostrar
                                                                                            Descripción
                                                                                            Producto
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Mostrar Nombre o Descripción completa Productos por vencer en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.trunc_txt
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- (Mod. Caja) Mostrar stock almacénes -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Mostrar
                                                                                            Stock
                                                                                            Almacénes
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Mostrar Stock de productos de todos los almacenes en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.show_stock_establishment_box
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Recibir mercaderia (caja) -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Recibir
                                                                                            Productos
                                                                                            (traslado)
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Recibir Productos por TRASLADO DE MERCADERIA en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.receive_merchandise
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Ordenar productos por descripción caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-sort-alpha-down tab-icon"
                                                                                            ></i>
                                                                                            Ordenar
                                                                                            Productos
                                                                                            X
                                                                                            Descripción
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Ordenar Productos por Descripción en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.ord_dscp
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Buscar por series en caja -->
                                                                                <div
                                                                                    class="col-md-4 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            <i
                                                                                                class="fas fa-search tab-icon"
                                                                                            ></i>
                                                                                            Buscar
                                                                                            Producto
                                                                                            X
                                                                                            Series
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Buscar Productos por SERIES en CAJA"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.search_series_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Dar
                                                                                            a
                                                                                            crédito
                                                                                            nota
                                                                                            de
                                                                                            venta
                                                                                            (sin
                                                                                            cuotas)
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.sale_note_credit_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Imagenes
                                                                                            en
                                                                                            cotizaciones
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.image_quotation
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Modificar
                                                                                            cantidad
                                                                                            de
                                                                                            productos
                                                                                            compuestos
                                                                                            (Caja)
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.item_set_quantity_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Transformación
                                                                                            de
                                                                                            producto
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.transform_item
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Mostrar
                                                                                            mesa
                                                                                            "caja"
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.show_caja_table
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Turno
                                                                                            inicio
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Turno elegido para agrupar las cajas"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-select
                                                                                            v-model="
                                                                                                form.turn_principal
                                                                                            "
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                            clearable
                                                                                        >
                                                                                            <el-option
                                                                                                v-for="turn in turns"
                                                                                                :key="
                                                                                                    turn.id
                                                                                                "
                                                                                                :label="
                                                                                                    turn.label
                                                                                                "
                                                                                                :value="
                                                                                                    turn.id
                                                                                                "
                                                                                            ></el-option>
                                                                                        </el-select>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Turno
                                                                                            final
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Turno elegido para agrupar las cajas"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-select
                                                                                            v-model="
                                                                                                form.turn_end
                                                                                            "
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                            clearable
                                                                                        >
                                                                                            <el-option
                                                                                                v-for="turn in turns"
                                                                                                :key="
                                                                                                    turn.id
                                                                                                "
                                                                                                :label="
                                                                                                    turn.label
                                                                                                "
                                                                                                :value="
                                                                                                    turn.id
                                                                                                "
                                                                                            ></el-option>
                                                                                        </el-select>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Caja
                                                                                            principal
                                                                                            automatica
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Caja principal se cierra y abre en base al turno  inicial - final"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.automatic_principal_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Impresión
                                                                                            directa
                                                                                            vendedor
                                                                                            cotización
                                                                                            -
                                                                                            Caja
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.seller_quotation_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Imprimir
                                                                                            política
                                                                                            de
                                                                                            precio
                                                                                            -
                                                                                            Cotización
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.unit_type_pdf_quotation
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Bloquear
                                                                                            stock
                                                                                            inicial
                                                                                            <el-tooltip
                                                                                                content="Stock inicial 0 en formulario de producto"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.init_stock
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Enviar
                                                                                            whatsapp
                                                                                            por
                                                                                            pagos
                                                                                            YAPE/PLIN
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Enviar un whastapp al número del dueño por cada pago con YAPE/PLIN"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.send_whatsapp_digital_pay
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Traslados
                                                                                            directos

                                                                                            <el-tooltip
                                                                                                content="Sin necesidad de insertar clave y/o código"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.translate_direct
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Ver
                                                                                            productos
                                                                                            por
                                                                                            vencer
                                                                                            en
                                                                                            caja
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.items_due_caja
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Visualizar
                                                                                            administrador
                                                                                            -
                                                                                            usuarios
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.users_views
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Tratamiento
                                                                                            comercial
                                                                                            Categoría
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Trato comercial"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.commercial_treatments
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Tratamiento
                                                                                            comercial
                                                                                            Producto
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Trato comercial"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.commercial_treatment_items
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Servicio
                                                                                            en
                                                                                            todos
                                                                                            los
                                                                                            establecimientos
                                                                                            <el-tooltip
                                                                                                class="item"
                                                                                                effect="dark"
                                                                                                content="Al crear un servicio, se creará en todos los establecimientos"
                                                                                                placement="top-start"
                                                                                            >
                                                                                                <i
                                                                                                    class="fa fa-info-circle"
                                                                                                ></i>
                                                                                            </el-tooltip>
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.create_service_all_warehouse
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >A
                                                                                            cuenta
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.credit_list
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Manejo
                                                                                            de
                                                                                            caja
                                                                                            principal
                                                                                        </label>

                                                                                        <el-switch
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                            v-model="
                                                                                                form.principal_cash
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Guardar
                                                                                            decisión
                                                                                            de
                                                                                            impresión
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.save_pos_printing
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Buscar
                                                                                            por
                                                                                            series
                                                                                            en
                                                                                            caja
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.search_series_pos
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Reporte
                                                                                            caja
                                                                                            -
                                                                                            para
                                                                                            llevar
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.carry_cash_report
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Reporte
                                                                                            caja
                                                                                            -
                                                                                            para
                                                                                            llevar
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.carry_cash_report
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Billetes/Monedas
                                                                                            a
                                                                                            recibir
                                                                                            caja
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.show_coins_to_receive
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Buscar
                                                                                            por
                                                                                            segundo
                                                                                            nombre
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.search_by_second_name
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Whatsapp
                                                                                            en
                                                                                            reimpresión
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.reprint_whatsapp
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Productos
                                                                                            en
                                                                                            caja
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.product_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                        >
                                                                                            Impresión
                                                                                            directa
                                                                                            vendedor
                                                                                            cotización
                                                                                            -
                                                                                            Caja
                                                                                        </label>

                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.seller_quotation_cash
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-md-3 mt-4"
                                                                                >
                                                                                    <div
                                                                                        class="form-group"
                                                                                    >
                                                                                        <label
                                                                                            class="control-label w-100"
                                                                                            >Mostrar
                                                                                            toda
                                                                                            la
                                                                                            descripción
                                                                                            del
                                                                                            producto
                                                                                            en
                                                                                            caja
                                                                                        </label>
                                                                                        <el-switch
                                                                                            v-model="
                                                                                                form.trunc_txt
                                                                                            "
                                                                                            active-text="Si"
                                                                                            inactive-text="No"
                                                                                            @change="
                                                                                                submit
                                                                                            "
                                                                                        ></el-switch>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </el-card>
                                                                </el-col>
                                                            </el-row>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- agregado por falta de algunos botones -->
                                        </template>
                                    </el-tab-pane>
                                    <el-tab-pane
                                        label="Impresion"
                                        v-if="!isArca"
                                    >
                                        <div class="row">
                                            <div class="col-md-3 mt-2">
                                                <label
                                                    class="control-label w-100"
                                                >
                                                    Impresoras Nuevas
                                                    <el-tooltip
                                                        class="item"
                                                        effect="dark"
                                                        content="Permite configurar si las impresoras que se usan para la impresion directa en a5/a4 son nuevas o antiguas"
                                                        placement="top-start"
                                                    >
                                                        <i
                                                            class="fa fa-info-circle"
                                                        ></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-switch
                                                    v-model="
                                                        form.new_old_printer
                                                    "
                                                    active-text="Si"
                                                    inactive-text="No"
                                                    @change="submit"
                                                ></el-switch>
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <label
                                                    class="control-label w-100"
                                                >
                                                    Orientación A5
                                                </label>
                                                <el-switch
                                                    v-model="
                                                        form.a5_orientation
                                                    "
                                                    active-text="Horizontal"
                                                    inactive-text="Vertical"
                                                    @change="submit"
                                                ></el-switch>
                                            </div>

                                            <div class="col-md-3 mt-2">
                                                <label
                                                    class="control-label w-100"
                                                >
                                                    Mostrar logo en documentos
                                                </label>
                                                <el-switch
                                                    v-model="
                                                        form.show_logo_in_documents
                                                    "
                                                    active-text="Si"
                                                    inactive-text="No"
                                                    @change="submit"
                                                ></el-switch>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label
                                                    class="control-label w-100"
                                                >
                                                    Mostrar código interno en
                                                    productos (ticket)
                                                </label>
                                                <el-switch
                                                    v-model="
                                                        form.show_internal_code_ticket
                                                    "
                                                    active-text="Si"
                                                    inactive-text="No"
                                                    @change="submit"
                                                ></el-switch>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <el-tab-pane
                                        label="Crédito NV"
                                        v-if="form.credits"
                                    >
                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        >Penalidades
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_penalty
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        >Confirmación de
                                                        aprobación
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_confirm
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                    >
                                                        Aceptar monto menores en
                                                        la cuotas
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_low_pay
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        >Editar
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_edit
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        >Enviar whatsapp a
                                                        clientes
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_send_whatsapp
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                        >Mostrar formatos
                                                        adicionales
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.sale_note_credit_formats
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                    >
                                                        Whatsapp personalizado
                                                        <el-tooltip
                                                            class="item"
                                                            effect="dark"
                                                            content="Usa su propia app de whatsapp"
                                                            placement="top-start"
                                                        >
                                                            <i
                                                                class="fa fa-info-circle"
                                                            ></i>
                                                        </el-tooltip>
                                                    </label>

                                                    <el-switch
                                                        v-model="
                                                            form.whatsapp_client
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <!-- Cotización---- -->
                                    <el-tab-pane name="Cotización">
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-file-invoice-dollar tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Cotización</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Cotización
                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-print"
                                                            ></i>
                                                            Impresión directa
                                                            vendedor cotización
                                                            - Caja
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.seller_quotation_cash
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-tag"
                                                            ></i>
                                                            Imprimir política de
                                                            precio - Cotización
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.unit_type_pdf_quotation
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label w-100"
                                                    >
                                                        <i
                                                            class="fas fa-image"
                                                        ></i>
                                                        Imagenes en cotizaciones
                                                    </label>
                                                    <el-switch
                                                        v-model="
                                                            form.image_quotation
                                                        "
                                                        active-text="Si"
                                                        inactive-text="No"
                                                        @change="submit"
                                                    ></el-switch>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>

                                    <!-- Arca---- -->
                                    <el-tab-pane name="Arca">
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-archive tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Arca</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Arca
                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fa fa-cash-register fa-lg"
                                                            ></i>
                                                            Manejo de caja
                                                            principal
                                                        </label>
                                                        <el-switch
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                            v-model="
                                                                form.principal_cash
                                                            "
                                                        ></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fa fa-clock fa-lg"
                                                            ></i>
                                                            Turno inicio
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Turno elegido para agrupar las cajas"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle fa-lg"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-select
                                                            v-model="
                                                                form.turn_principal
                                                            "
                                                            @change="submit"
                                                            clearable
                                                        >
                                                            <el-option
                                                                v-for="turn in turns"
                                                                :key="turn.id"
                                                                :label="
                                                                    turn.label
                                                                "
                                                                :value="turn.id"
                                                            ></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fa fa-clock fa-lg"
                                                            ></i>
                                                            Turno final
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Turno elegido para agrupar las cajas"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle fa-lg"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-select
                                                            v-model="
                                                                form.turn_end
                                                            "
                                                            @change="submit"
                                                            clearable
                                                        >
                                                            <el-option
                                                                v-for="turn in turns"
                                                                :key="turn.id"
                                                                :label="
                                                                    turn.label
                                                                "
                                                                :value="turn.id"
                                                            ></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fa fa-money-check-alt fa-lg"
                                                            ></i>
                                                            A cuenta
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.credit_list
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fa fa-cogs fa-lg"
                                                            ></i>
                                                            Caja principal
                                                            automatica
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Caja principal se cierra y abre en base al turno inicial - final"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle fa-lg"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.automatic_principal_cash
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <!-- Restaurant-------- -->
                                    <el-tab-pane
                                        v-if="form.restaurant"
                                        name="restaurant"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-utensils tab-icon"
                                                ></i>
                                                <span class="tab-text"
                                                    >Restaurant</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            <el-row :gutter="20">
                                                <el-col :span="12">
                                                    <el-card shadow="hover">
                                                        <div
                                                            slot="header"
                                                            style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;"
                                                        >
                                                            <i
                                                                class="fas fa-cash-register"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            <span>Caja</span>
                                                        </div>
                                                        <div>
                                                            Contenido de la
                                                            Caja.
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <label
                                                                        class="control-label"
                                                                    >
                                                                        <i
                                                                            class="fa fa-receipt fa-lg"
                                                                        ></i>
                                                                        Uso de
                                                                        Comanda
                                                                        Física
                                                                    </label>
                                                                    <div
                                                                        class="form-group"
                                                                        :class="{
                                                                            'has-danger':
                                                                                errors.commands_fisico
                                                                        }"
                                                                    >
                                                                        <el-switch
                                                                            v-model="
                                                                                form.commands_fisico
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                        <small
                                                                            class="text-danger"
                                                                            v-if="
                                                                                errors.commands_fisico
                                                                            "
                                                                            v-text="
                                                                                errors
                                                                                    .commands_fisico[0]
                                                                            "
                                                                        ></small>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-print fa-lg"
                                                                            ></i>
                                                                            Imprimir
                                                                            Comanda
                                                                            en
                                                                            Caja
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.print_commands
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-file-alt fa-lg"
                                                                            ></i>
                                                                            Emitir
                                                                            Documento
                                                                            Variación
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.show_variation_dcto
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <template
                                                                        id="select-append"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-boxes fa-lg"
                                                                            ></i>
                                                                            Producto
                                                                            -
                                                                            Variación
                                                                        </label>
                                                                        <div
                                                                            class="el-input el-input-group el-input-group--append"
                                                                        >
                                                                            <el-select
                                                                                :disabled="
                                                                                    !form.show_variation_dcto
                                                                                "
                                                                                @focus="
                                                                                    $event.target.select()
                                                                                "
                                                                                ref="producto"
                                                                                v-model="
                                                                                    form.item_variation_id
                                                                                "
                                                                                @change="
                                                                                    changeItem
                                                                                "
                                                                                filterable
                                                                                remote
                                                                                placeholder="Buscar..."
                                                                                popper-class="el-select-items"
                                                                                @visible-change="
                                                                                    focusTotalItem
                                                                                "
                                                                                slot="prepend"
                                                                                id="select-width"
                                                                                :remote-method="
                                                                                    searchRemoteItems
                                                                                "
                                                                                :loading="
                                                                                    loading_search
                                                                                "
                                                                            >
                                                                                <el-option
                                                                                    v-for="option in items"
                                                                                    :key="
                                                                                        option.id
                                                                                    "
                                                                                    :value="
                                                                                        option.id
                                                                                    "
                                                                                    :label="
                                                                                        option.full_description ||
                                                                                            option.description
                                                                                    "
                                                                                ></el-option>
                                                                            </el-select>
                                                                        </div>
                                                                    </template>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-key fa-lg"
                                                                            ></i>
                                                                            Pedir
                                                                            PIN
                                                                            al
                                                                            Eliminar
                                                                            Orden
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.pin_orden_delete
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-whatsapp fa-lg"
                                                                            ></i>
                                                                            Enviar
                                                                            Whatsapp
                                                                            al
                                                                            Eliminar
                                                                            Orden
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.send_whatsapp_activity
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-list-alt fa-lg"
                                                                            ></i>
                                                                            Categorías
                                                                            Arrastrables
                                                                            Caja
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.pos_drag_category
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-lock fa-lg"
                                                                            ></i>
                                                                            Evitar
                                                                            Cerrar
                                                                            Caja
                                                                            con
                                                                            Ordenes
                                                                            Pendientes
                                                                            <el-tooltip
                                                                                content="Alerta sobre las mesas pendientes al cerrar caja, es posible emitir una nota de venta por todo"
                                                                            >
                                                                                <i
                                                                                    class="fa fa-info-circle fa-lg"
                                                                                ></i>
                                                                            </el-tooltip>
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.ordens_cash
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-clipboard fa-lg"
                                                                            ></i>
                                                                            Reporte
                                                                            Caja
                                                                            -
                                                                            para
                                                                            llevar
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.carry_cash_report
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-coins fa-lg"
                                                                            ></i>
                                                                            Billetes/Monedas
                                                                            a
                                                                            recibir
                                                                            Caja
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.show_coins_to_receive
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-table fa-lg"
                                                                            ></i>
                                                                            Mostrar
                                                                            "Mesa
                                                                            Caja"
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.show_caja_table
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <label
                                                                        class="control-label w-100"
                                                                    >
                                                                        <i
                                                                            class="fa fa-file-alt fa-lg"
                                                                        ></i>
                                                                        Texto en
                                                                        precuenta
                                                                        <el-tooltip
                                                                            class="item"
                                                                            effect="dark"
                                                                            content="Permite agregar un texto en la precuenta de consumo"
                                                                            placement="top-start"
                                                                        >
                                                                            <i
                                                                                class="fa fa-info-circle fa-lg"
                                                                            ></i>
                                                                        </el-tooltip>
                                                                    </label>
                                                                    <el-switch
                                                                        v-model="
                                                                            form.text_comanda
                                                                        "
                                                                        active-text="Si"
                                                                        inactive-text="No"
                                                                        @change="
                                                                            submit
                                                                        "
                                                                    ></el-switch>
                                                                </div>
                                                                <div
                                                                    class="row"
                                                                >
                                                                    <div
                                                                        class="col-md-4 mt-4"
                                                                    >
                                                                        <label
                                                                            for="text_1"
                                                                        >
                                                                            <i
                                                                                class="fa fa-file-alt fa-lg"
                                                                            ></i>
                                                                            Primer
                                                                            texto
                                                                        </label>
                                                                        <el-input
                                                                            :disabled="
                                                                                !form.text_comanda
                                                                            "
                                                                            class="w-100"
                                                                            v-model="
                                                                                form.text_one
                                                                            "
                                                                            placeholder="Texto 1"
                                                                            size="normal"
                                                                            @input="
                                                                                saveSubmitDebounce
                                                                            "
                                                                        ></el-input>
                                                                    </div>

                                                                    <div
                                                                        class="col-md-4 mt-4"
                                                                    >
                                                                        <label
                                                                            for="text-2"
                                                                        >
                                                                            <i
                                                                                class="fa fa-file-alt fa-lg"
                                                                            ></i>
                                                                            Segundo
                                                                            texto
                                                                        </label>
                                                                        <el-input
                                                                            :disabled="
                                                                                !form.text_comanda
                                                                            "
                                                                            class="w-100"
                                                                            v-model="
                                                                                form.text_two
                                                                            "
                                                                            placeholder="Texto 2"
                                                                            size="normal"
                                                                            @input="
                                                                                saveSubmitDebounce
                                                                            "
                                                                        ></el-input>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </el-card>
                                                </el-col>
                                                <!-- Restaurant-Mozo -->
                                                <el-col :span="12">
                                                    <el-card shadow="hover">
                                                        <div
                                                            slot="header"
                                                            style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;"
                                                        >
                                                            <i
                                                                class="fas fa-concierge-bell"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            <span>Mozo</span>
                                                        </div>
                                                        <div>
                                                            Contenido del Mozo.
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-key fa-lg"
                                                                            ></i>
                                                                            Ingresar
                                                                            pin
                                                                            mozo
                                                                            (ordenes)
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.pin_switch
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-user fa-lg"
                                                                            ></i>
                                                                            Caja-Mozo
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.box_orden
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                        :class="{
                                                                            'has-danger':
                                                                                errors.affectation_igv_type_id
                                                                        }"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fa fa-search fa-lg"
                                                                            ></i>
                                                                            (Módulo
                                                                            de
                                                                            Mozo)
                                                                            Búsqueda
                                                                            de
                                                                            Producto
                                                                            por
                                                                        </label>
                                                                        <el-select
                                                                            v-model="
                                                                                form.search_type
                                                                            "
                                                                            @change="
                                                                                submit
                                                                            "
                                                                            filterable
                                                                        >
                                                                            <el-option
                                                                                label="Buscar por Descripción"
                                                                                value="0"
                                                                            ></el-option>
                                                                            <el-option
                                                                                label="Buscar por Código interno"
                                                                                value="1"
                                                                            ></el-option>
                                                                        </el-select>
                                                                        <small
                                                                            class="text-danger"
                                                                            v-if="
                                                                                errors.affectation_igv_type_id
                                                                            "
                                                                            v-text="
                                                                                errors
                                                                                    .affectation_igv_type_id[0]
                                                                            "
                                                                        ></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </el-card>
                                                </el-col>
                                                <el-col :span="12">
                                                    <el-card shadow="hover">
                                                        <div
                                                            slot="header"
                                                            style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;"
                                                        >
                                                            <i
                                                                class="fas fa-utensils fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            <span
                                                                >Zona de
                                                                Preparación</span
                                                            >
                                                        </div>
                                                        <div>
                                                            Contenido de la Zona
                                                            de Preparación.
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-3 mt-4"
                                                                >
                                                                    <div
                                                                        class="form-group"
                                                                    >
                                                                        <label
                                                                            class="control-label w-100"
                                                                        >
                                                                            <i
                                                                                class="fas fa-print fa-lg"
                                                                                style="margin-right: 10px;"
                                                                            ></i>
                                                                            Imprimir
                                                                            en
                                                                            Zona
                                                                            Preparación
                                                                        </label>
                                                                        <el-switch
                                                                            v-model="
                                                                                form.print_kitchen
                                                                            "
                                                                            active-text="Si"
                                                                            inactive-text="No"
                                                                            @change="
                                                                                submit
                                                                            "
                                                                        ></el-switch>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </el-card>
                                                </el-col>
                                            </el-row>
                                        </div>
                                    </el-tab-pane>

                                    <!-- Hotel---- -->
                                    <el-tab-pane
                                        name="Hotel"
                                        v-if="form.hotels"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-hotel tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Hotel</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            <!-- Contenido de Hotel -->
                                            <div class="row">
                                                <template v-if="form.hotels">
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-bell fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo de alarma
                                                                de alquileres
                                                                por vencer
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.alarm_to_end
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-tools fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo de
                                                                mantenimiento
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.time_manteniment
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-shield-alt fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Límite de la
                                                                garantía -
                                                                frigobar
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.credit_line_hotel_limit
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-percent fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Descuento
                                                                aplicado por día
                                                                a cambio del
                                                                servicio x
                                                                habitación
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.discount_amount_instead_service
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-sign-out-alt fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo para
                                                                aviso de salida
                                                                de habitación
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.minute_close_to_leave
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-broom fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo para
                                                                limpiar la
                                                                habitación
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.time_to_clean
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-clock fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo para el
                                                                cálculo del
                                                                inicio del día
                                                            </label>
                                                            <el-time-picker
                                                                style="width: 100%;"
                                                                value-format="HH:mm:ss"
                                                                :format="
                                                                    'hh:mm A'
                                                                "
                                                                :picker-options="{
                                                                    format:
                                                                        'hh:mm A'
                                                                }"
                                                                timezone="America/Lima"
                                                                v-model="
                                                                    form.time_to_enter
                                                                "
                                                            ></el-time-picker>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-clock fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo para el
                                                                cálculo del
                                                                final del día
                                                            </label>
                                                            <el-time-picker
                                                                style="width: 100%;"
                                                                value-format="HH:mm:ss"
                                                                :format="
                                                                    'hh:mm A'
                                                                "
                                                                :picker-options="{
                                                                    format:
                                                                        'hh:mm A'
                                                                }"
                                                                timezone="America/Lima"
                                                                v-model="
                                                                    form.time_to_leave
                                                                "
                                                            ></el-time-picker>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-check-circle fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Autorización de
                                                                descuento
                                                            </label>
                                                            <el-switch
                                                                v-model="
                                                                    form.auth_discount
                                                                "
                                                                active-text="Si"
                                                                inactive-text="No"
                                                                @change="submit"
                                                            ></el-switch>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-tools fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Tiempo de
                                                                mantenimiento
                                                            </label>
                                                            <el-input-number
                                                                @change="submit"
                                                                v-model="
                                                                    form.time_manteniment
                                                                "
                                                            ></el-input-number>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label w-100"
                                                            >
                                                                <i
                                                                    class="fas fa-wrench fa-lg"
                                                                    style="margin-right: 10px;"
                                                                ></i>
                                                                Control de
                                                                mantenimiento
                                                            </label>
                                                            <el-switch
                                                                v-model="
                                                                    form.maintenance_workers
                                                                "
                                                                active-text="Si"
                                                                inactive-text="No"
                                                                @change="submit"
                                                            ></el-switch>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </el-tab-pane>

                                    <!-- Créditos---- -->
                                    <el-tab-pane
                                        name="Creditos"
                                        label="Créditos NV"
                                        v-if="form.credits"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-credit-card tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Créditos NV</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Créditos
                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-gavel fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Penalidades
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_penalty
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-check-circle fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Confirmación de
                                                            aprobación
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_confirm
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-money-bill-wave fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Aceptar montos
                                                            menores en las
                                                            cuotas
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_low_pay
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-edit fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Editar Créditos
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_edit
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-whatsapp fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Enviar whatsapp a
                                                            clientes
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_send_whatsapp
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-file-alt fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Mostrar formatos
                                                            adicionales
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.sale_note_credit_formats
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-percent fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            % de crédito
                                                        </label>
                                                        <el-input-number
                                                            class="w-100"
                                                            v-model="form.rates"
                                                            :precision="2"
                                                            :step="0.5"
                                                            :max="100"
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-input-number>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            <i
                                                                class="fas fa-user-edit fa-lg"
                                                                style="margin-right: 10px;"
                                                            ></i>
                                                            Whatsapp
                                                            personalizado
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Usa su propia app de whatsapp"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch
                                                            v-model="
                                                                form.whatsapp_client
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>

                                    <!-- Colegio---- -->
                                    <el-tab-pane
                                        name="Colegio"
                                        label="Colegio"
                                        v-if="form.college"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-school tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Colegios</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Colegios
                                        </div>
                                    </el-tab-pane>

                                    <!-- Internet---- -->
                                    <el-tab-pane
                                        name="Internet"
                                        label="Internet"
                                        v-if="form.internet"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-wifi tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Internet</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Internet
                                        </div>
                                    </el-tab-pane>

                                    <!-- Boticas y Farmacias---- -->
                                    <el-tab-pane
                                        label="Hospital &  Botica"
                                        v-if="form.health_network"
                                    >
                                        <template #label>
                                            <div class="tab-label">
                                                <i
                                                    class="fas fa-pills tab-icon"
                                                ></i>
                                                <span class="tab-text">
                                                    Boticas y Farmacias</span
                                                >
                                            </div>
                                        </template>
                                        <div class="nested-tab-content">
                                            Contenido de Boticas y Farmacias

                                            <div class="row">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            Turno inicio
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Turno elegido para agrupar las cajas"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>

                                                        <el-select
                                                            v-model="
                                                                form.turn_principal
                                                            "
                                                            @change="submit"
                                                            clearable
                                                        >
                                                            <el-option
                                                                v-for="turn in turns"
                                                                :key="turn.id"
                                                                :label="
                                                                    turn.label
                                                                "
                                                                :value="turn.id"
                                                            ></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            Turno final
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Turno elegido para agrupar las cajas"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>

                                                        <el-select
                                                            v-model="
                                                                form.turn_end
                                                            "
                                                            @change="submit"
                                                            clearable
                                                        >
                                                            <el-option
                                                                v-for="turn in turns"
                                                                :key="turn.id"
                                                                :label="
                                                                    turn.label
                                                                "
                                                                :value="turn.id"
                                                            ></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label
                                                            class="control-label w-100"
                                                        >
                                                            Caja principal
                                                            automatica
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Caja principal se cierra y abre en base al turno  inicial - final"
                                                                placement="top-start"
                                                            >
                                                                <i
                                                                    class="fa fa-info-circle"
                                                                ></i>
                                                            </el-tooltip>
                                                        </label>

                                                        <el-switch
                                                            v-model="
                                                                form.automatic_principal_cash
                                                            "
                                                            active-text="Si"
                                                            inactive-text="No"
                                                            @change="submit"
                                                        ></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                </el-tabs>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane v-if="!isArca" name="reset">
                            <template #label>
                                <div class="tab-label">
                                    <i class="el-icon-refresh tab-icon"></i>
                                    <span class="tab-text">Reset</span>
                                </div>
                            </template>
                            <div class="row">
                                <div class="col-md-6 mt-6">
                                    <div class="form-group">
                                        <el-button
                                            type="primary"
                                            native-type="submit"
                                            @click="deleteDocuments"
                                            :loading="loading_submit"
                                            class="pro-button"
                                        >
                                            <i class="fas fa-trash fa-lg"></i>
                                            <span>Eliminar Documentos</span>
                                            <el-tooltip
                                                content="Realiza la eliminación de todos los documentos (DEMO Y PRODUCCIÓN)"
                                                placement="top"
                                            >
                                                <span>
                                                    <i
                                                        class="fas fa-exclamation-circle"
                                                    ></i>
                                                </span>
                                            </el-tooltip>
                                        </el-button>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-6">
                                    <div class="form-group">
                                        <el-button
                                            type="primary"
                                            native-type="submit"
                                            @click="deleteItems"
                                            :loading="loading_submit"
                                            class="pro-button"
                                        >
                                            <i class="fas fa-trash fa-lg"></i>
                                            <span>Eliminar Productos</span>
                                            <el-tooltip
                                                content="Realiza la eliminación de todos los Productos (DEMO Y PRODUCCIÓN)"
                                                placement="top"
                                            >
                                                <span>
                                                    <i
                                                        class="fas fa-exclamation-circle"
                                                    ></i>
                                                </span>
                                            </el-tooltip>
                                        </el-button>
                                    </div>
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </template>
            <!-- ----- -->

            <el-dialog
                :visible.sync="showAddNumberwhatsapp"
                @close="showAddNumberwhatsapp = false"
                title="Agregar número de whatsapp"
            >
                <div class="row mt-2">
                    <div class="col-12">
                        <el-input :maxlength="9" v-model="numberWhatsapp">
                        </el-input>
                    </div>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button
                        icon="fas fa-times fa-lg"
                        @click="showAddNumberwhatsapp = false"
                    >
                        Cancelar</el-button
                    >
                    <el-button
                        icon="fas fa-save fa-lg"
                        type="primary"
                        @click="sendNumberWhatsapp"
                    >
                        Agregar</el-button
                    >
                </span>
            </el-dialog>
        </div>
    </div>
</template>

<style scoped>
.custom-tabs {
    margin: 20px;
}

.el-tabs__header {
    background-color: #f7f7f7;
    border-bottom: 1px solid #ebeef5;
}

.el-tabs__item.is-active {
    color: #409eff;
    font-weight: bold;
    border-bottom: 2px solid #409eff;
}

.el-tabs__item {
    padding: 12px 20px;
}

.icon-with-label {
    margin-right: 8px;
}

.el-tabs__item:hover {
    color: #409eff;
}

.tab-text {
    font-size: 16px;
}

.tab-label {
    display: flex;
    align-items: center;
}

.tab-icon {
    margin-right: 8px;
    font-size: 24px;
    /* Aumentar tamaño del icono */
}

.tab-content {
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ebeef5;
    border-top: none;
    border-radius: 0 0 4px 4px;
}

.label-text {
    vertical-align: middle;
}

.pro-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    /* Espacio entre el icono y el texto */
    padding: 8px 16px;
    /* Espaciado interno */
    font-size: 16px;
    /* Tamaño de fuente */
    border-radius: 8px;
    /* Bordes redondeados */
    transition: background-color 0.3s, box-shadow 0.3s;
    /* Transiciones suaves */
}

.pro-button:hover {
    background-color: #357abd;
    /* Color más oscuro al pasar el ratón */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    /* Sombra */
}

.tooltip-icon {
    display: flex;
    align-items: center;
    margin-left: 8px;
    /* Espaciado del icono de tooltip */
    color: #fff;
    /* Color del icono */
}

.tooltip-icon i {
    font-size: 14px;
    /* Tamaño del icono de tooltip */
}
</style>

<script>
//  import TermsCondition from '@views/quotations/partials/terms_condition.vue'

export default {
    props: ["typeUser", "isArca"],
    //  components: {TermsCondition},
    //
    data() {
        return {
            turns: [
                {
                    id: 1,
                    label: "MAÑANA"
                },
                {
                    id: 2,
                    label: "TARDE"
                },
                {
                    id: 3,
                    label: "NOCHE"
                }
            ],
            modes: "modes",
            activeTab: "entorno",
            searchQueryModes: "",
            searchQueryAccounting: "",
            searchQueryVisual: "",
            /*  */
            /* activeTab: 'modes',
            searchQuery: '', */
            /*  */
            showAddNumberwhatsapp: false,
            numberWhatsapp: null,
            timer: null,
            loading_search: false,
            showDialogTermsCondition: false,
            loading_submit: false,
            resource: "configurations",
            errors: {},
            form: {},
            affectation_igv_types: [],
            placeholder: "",
            items: [],
            numbers: [],
            days: [
                {
                    id: 1,
                    value: 1
                },
                {
                    id: 2,
                    value: 2
                },
                {
                    id: 3,
                    value: 3
                },
                {
                    id: 4,
                    value: 4
                },
                {
                    id: 5,
                    value: 5
                },
                {
                    id: 6,
                    value: 6
                },
                {
                    id: 7,
                    value: 7
                }
            ]
        };
    },

    async created() {
        await this.loadTables();
        await this.initForm();
        console.log(this.isArca);
        await this.$http.get(`/${this.resource}/record`).then(response => {
            if (response.data !== "") {
                this.form = response.data.data;
            }
            // console.log(this.placeholder)
        });
    },
    watch: {
        searchQueryModes(newVal) {
            this.filterLabels(newVal, "modesTab");
        },
        searchQueryAccounting(newVal) {
            this.filterLabels(newVal, "accountingTab");
        },
        searchQueryVisual(newVal) {
            this.filterLabels(newVal, "visualTab");
        }
    },
    methods: {
        getNumbers() {
            this.$http.get("/whatsapp/numbers").then(response => {
                this.numbers = response.data.data;
                console.log(
                    "🚀 ~ file: form.vue:1633 ~ this.$http.get ~ this.numbers:",
                    this.numbers
                );
            });
        },
        async removeNumberWhatsapp(idx) {
            let { number } = this.numbers[idx];
            const response = await this.$http.post("/whatsapp/remove", {
                number
            });
            if (response.status == 200) {
                this.$toast.success("Número eliminado correctamente");
                this.showAddNumberwhatsapp = false;
                this.numberWhatsapp = null;
                this.getNumbers();
            } else {
                this.$toast.error("Ocurrió un error al eliminar el número");
            }
        },
        async sendNumberWhatsapp() {
            try {
                const response = await this.$http.post("/whatsapp/save", {
                    number: this.numberWhatsapp
                });
                if (response.status == 200) {
                    this.$toast.success("Número agregado correctamente");
                    this.showAddNumberwhatsapp = false;
                    this.numberWhatsapp = null;
                    this.getNumbers();
                } else {
                    this.$toast.error("Ocurrió un error al agregar el número");
                }
            } catch (e) {
                let { message } = e.response.data;
                if (message) {
                    this.$toast.error(message);
                } else {
                    this.$toast.error("Ocurrió un error al agregar el número");
                }
            }
        },
        addNumberWhatsapp() {
            this.showAddNumberwhatsapp = true;
        },
        saveSubmitDebounce() {
            if (this.timer != null) clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.submit();
            }, 700);
        },
        changeNumberActivity(input) {
            let number_activity = input;
            if (number_activity.length < 9) {
                return;
            }
            let v_number_activity = number_activity.replace(/\s/g, "");
            if (v_number_activity.length != 9) {
                this.$toast.error("El numero de whatsapp debe tener 9 digitos");
                return;
            }
            if (!/^\d+$/.test(v_number_activity)) {
                this.$toast.error(
                    "El numero de whatsapp debe ser un numero valido"
                );
                return;
            }

            this.submit();
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;
                await this.$http
                    .get(`/documents/search-items/?${parameters}`)
                    .then(response => {
                        this.items = response.data;
                        this.loading_search = false;
                    });
            }
        },
        async loadTables() {
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.items = response.data.items;
                if (response.data.item) {
                    this.form.item_variation_id = response.data.item.id;

                    this.items = [
                        ...this.items.filter(
                            i => i.id != response.data.item.id
                        ),
                        response.data.item
                    ];
                }
            });
            this.getNumbers();
        },
        initForm() {
            this.errors = {};
            this.form = {
                send_auto: true,
                stock: true,
                cron: true,
                id: null,
                rates: 0,
                sunat_alternate_server: false,
                subtotal_account: null,
                decimal_quantity: null,
                amount_plastic_bag_taxes: 0.1,
                colums_grid_item: 4,
                affectation_igv_type_id: "10",
                terms_condition: null,
                compact_sidebar: null,
                delete_document: null,
                recreat_document: null,
                show_restriction: null,
                print_direct: null,
                socket_channel: null,
                refresh_price_sales: null,
                search_type: "0",
                multiple_boxes: null,
                sales_stock: false,
                print_commands: false,
                commands_fisico: false,
                sales_quick: false,
                direct_printing: false,
                restaurant: false,
                print_kitchen: false
            };
        },
        async changeItem() {
            await this.submit();
        },
        focusTotalItem(change) {},

        async submit() {
            if (
                this.form.pin_orden_delete &&
                !this.form.send_whatsapp_activity
            ) {
                this.$toast.warning(
                    "Debe activar el envio de whatsapp al eliminar y notificar la orden"
                );
            }
            if (
                this.form.send_whatsapp_activity &&
                !this.form.pin_orden_delete
            ) {
                this.$toast.warning(
                    "Debe activar el pin al eliminar para notificar la orden"
                );
            }
            // let {commercial_treatment,commercial_treatment_items} = this.form

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
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        async stock_control() {
            // if(this.form.sales_stock==true){
            let form = {
                id: 1,
                stock_control: !this.form.sales_stock
            };
            const response = await this.$http.post(
                `/inventories/configuration`,
                form
            );
            if (response.data.success) {
                this.$toast.success(response.data.message);
            }
            //  }
        },
        changeAmountPlasticBagTaxes() {
            this.loading_submit = true;

            this.$http
                .post(`/${this.resource}/icbper`, this.form)
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
                    this.loading_submit = false;
                });
        },
        deleteItems() {
            this.loading_submitI = true;
            this.$http
                .post(`/options/delete_items`)
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
                        this.$toast.error(`${error.response.data.message}`);
                    }
                })
                .then(() => {
                    this.loading_submitI = false;
                });
        },
        deleteDocuments() {
            this.loading_submit = true;
            this.$http
                .post(`/options/delete_documents`)
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
                        this.$toast.error(`${error.response.data.message}`);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        /* agregado para realizar busqueda */
        filterLabels(query, refName) {
            query = query.trim().toLowerCase();
            const tabContent = this.$refs[refName];

            if (tabContent) {
                const labels = tabContent.querySelectorAll("label");
                labels.forEach(label => {
                    const labelContent = label.textContent.trim().toLowerCase();
                    const parentDiv = label.parentElement;

                    if (labelContent.includes(query)) {
                        parentDiv.style.display = ""; // Mostrar si coincide
                        this.highlight(label, query);
                    } else {
                        parentDiv.style.display = "none"; // Ocultar si no coincide
                        label.innerHTML = label.textContent; // Restaurar texto original
                    }
                });
            }
        },
        highlight(label, query) {
            const regex = new RegExp(`(${query})`, "gi");
            label.innerHTML = label.textContent.replace(
                regex,
                '<span style="background-color: yellow;">$1</span>'
            );
        }

        // deleteItems() {
        //     this.loading_submitI = true;
        //     this.$http
        //         .post(`/${this.resource}/delete_items`)
        //         .then(response => {
        //             if (response.data.success) {
        //                 this.$toast.success(response.data.message);
        //             } else {
        //                 this.$toast.error(response.data.message);
        //             }
        //         })
        //         .catch(error => {
        //             if (error.response.status === 422) {
        //                 this.errors = error.response.data.errors;
        //             } else {

        //                 this.$toast.error(`${error.response.data.message}`);
        //             }
        //         })
        //         .then(() => {
        //             this.loading_submitI = false;
        //         });
        // },
        // deleteDocuments() {
        //     this.loading_submit = true;
        //     this.$http
        //         .post(`/${this.resource}/delete_documents`)
        //         .then(response => {
        //             if (response.data.success) {
        //                 this.$toast.success(response.data.message);
        //             } else {
        //                 this.$toast.error(response.data.message);
        //             }
        //         })
        //         .catch(error => {
        //             if (error.response.status === 422) {
        //                 this.errors = error.response.data.errors;
        //             } else {
        //                 this.$toast.error(`${error.response.data.message}`);
        //             }
        //         })
        //         .then(() => {
        //             this.loading_submit = false;
        //         });
        // },
    }
};
</script>
