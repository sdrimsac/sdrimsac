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
                    <el-tab-pane label="Visual Hotel" name="hotel" v-if="isArca">
                        <div class="row">
                            <template v-if="form.hotels">
                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Tiempo de alarma de alquileres
                                            por vencer
                                        </label>

                                        <el-input-number @change="submit" v-model="form.alarm_to_end">
                                        </el-input-number>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Tiempo para el calculo del
                                            inicio del dia
                                        </label>

                                        <el-time-picker style="width: 100%;" value-format="HH:mm:ss" :format="'hh:mm A'" :picker-options="{
                                                        format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                                    }" timezone="America/Lima" v-model="form.time_to_enter"></el-time-picker>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Tiempo para el calculo del
                                            final del dia
                                        </label>

                                        <el-time-picker style="width: 100%;" value-format="HH:mm:ss" :format="'hh:mm A'" :picker-options="{
                                                        format: 'hh:mm A' // Utiliza 'hh' para las horas en formato de 12 horas y 'A' para AM/PM
                                                    }" timezone="America/Lima" v-model="form.time_to_leave"></el-time-picker>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Tiempo de mantenimiento
                                        </label>

                                        <el-input-number @change="submit" v-model="form.time_manteniment">
                                        </el-input-number>
                                    </div>
                                </div>

                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Limite de la garantía -
                                            frigobar
                                        </label>
                                        <el-input-number @change="submit" v-model="
                                                        form.credit_line_hotel_limit
                                                    ">
                                        </el-input-number>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <div class="form-group">
                                        <label class="control-label w-100">Descuento aplicado por día a
                                            cambio del servicio x habitación
                                        </label>
                                        <el-input-number @change="submit" v-model="
                                                        form.discount_amount_instead_service
                                                    ">
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
                                <span class="tab-text">Configuración de Entorno</span>
                            </div>
                        </template>
                        <div class="tab-content">
                            <!-- Tabs anidados dentro del tab de "Configuracion de entorno" -->
                            <el-tabs type="card" v-model="modes">
                                <!-- panel Modos---- -->
                                <el-tab-pane name="modes">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="el-icon-setting tab-icon"></i>
                                            <span class="tab-text">Modos</span>
                                        </div>
                                    </template>
                                    <div class="col-md-6">
                                        <label class="control-label">
                                            Buscar
                                        </label>
                                        <div class="form-group">
                                            <el-input v-model="searchQueryModes" placeholder="Buscar..." style="width: 240px" maxlength="20" show-word-limit type="text"></el-input>
                                        </div>
                                    </div>

                                    <div class="nested-tab-content" ref="modesTab">
                                        <div class="row">
                                            <!-- Crédito en Nota de Venta -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-credit-card tab-icon"></i>
                                                        Crédito en Nota de
                                                        Venta
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.credits
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Entorno Colegio -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-school tab-icon"></i>
                                                        Entorno Colegio
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.college
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Entorno Restaurant -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-utensils tab-icon"></i>
                                                        Entorno
                                                        Restaurant</label>
                                                    <el-switch v-model="
                                                                    form.restaurant
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Entorno Hotel -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-hotel tab-icon"></i>
                                                        Entorno Hotel</label>
                                                    <el-switch v-model="
                                                                    form.hotels
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Entorno Internet -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-wifi tab-icon"></i>
                                                        Entorno
                                                        Internet</label>
                                                    <el-switch v-model="
                                                                    form.internet
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Entorno Peaje -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="el-icon-tickets tab-icon"></i>
                                                        Entorno Peaje</label>
                                                    <el-switch v-model="form.toll" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Entorno Boticas & Hospital       -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-pills tab-icon"></i>
                                                        Entorno Boticas &
                                                        Hospital
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.health_network
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header bg-primary">
                                                    <h4 class="my-0 text-white">
                                                        <i class="fas fa-business-time"></i>
                                                        COMPLEMENTOS DE
                                                        MODELO DE NEGOCIO
                                                    </h4>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Habilitar Promociones -->
                                                        <div class="col-md-3">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Habilitar
                                                                Promociones
                                                                <el-tooltip class="item" effect="dark" content="Visualiza en CAJA y ADMINISTRADOR la función que permite acceder a una promoción, llegando a x items vendidos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                            form.promotions_sell
                                                                        " active-text="Si" inactive-text="No" @change="
                                                                            submit
                                                                        "></el-switch>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <el-input v-model="
                                                                            form.promotions_cant_purchase
                                                                        " placeholder="Cantidad de ventas para acceder a la promoción " size="normal" @blur="
                                                                            submit
                                                                        ">
                                                            </el-input>
                                                        </div>

                                                        <!-- Habilitar Contabilidad -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-calculator tab-icon"></i>
                                                                    Habilitar
                                                                    Contabilidad</label>
                                                                <el-switch v-model="
                                                                                form.accounting_mode
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>
                                                        <!-- Habilitar Series - Productos -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-barcode tab-icon"></i>
                                                                    Habilitar
                                                                    Series -
                                                                    Productos
                                                                </label>

                                                                <el-switch v-model="
                                                                                form.series_enabled
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar Lotes - Productos -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-boxes tab-icon"></i>
                                                                    Habilitar
                                                                    Lotes -
                                                                    Productos
                                                                </label>

                                                                <el-switch v-model="
                                                                                form.lots_enabled
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar Color & Talla - Productos -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-tshirt tab-icon"></i>
                                                                    <i class="fas fa-palette"></i>
                                                                    Habilitar
                                                                    Color &
                                                                    Talla -
                                                                    Productos
                                                                </label>

                                                                <el-switch v-model="
                                                                                form.color_size_enabled
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar Guías de Remisión (CAJA Y ADMINISTRADOR) -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-truck tab-icon"></i>
                                                                    Habilitar
                                                                    Guías de
                                                                    Remisión
                                                                    (CAJA Y
                                                                    ADMINISTRADOR)
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.dispatch
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar cotización (CAJA Y ADMINISTRADOR) -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-file-invoice-dollar tab-icon"></i>
                                                                    Habilitar
                                                                    Cotización
                                                                    (CAJA Y
                                                                    ADMINISTRADOR)
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.quotation
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar Consignación (CAJA Y ADMINISTRADOR) -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-handshake tab-icon"></i>
                                                                    Habilitar
                                                                    Consignación
                                                                    (CAJA Y
                                                                    ADMINISTRADOR)

                                                                    <el-tooltip content="Crear y liquidar consignaciones desde caja">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.consignment
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Producto penalidad - Consignación -->
                                                        <div class="col-md-3 mt-4">
                                                            <template id="select-append">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-exclamation-circle tab-icon"></i>
                                                                    Producto
                                                                    penalidad
                                                                    -
                                                                    Consignación
                                                                </label>
                                                                <div class="el-input el-input-group el-input-group--append">
                                                                    <el-select :disabled="
                                                                                    !form.consignment
                                                                                " @focus="
                                                                                    $event.target.select()
                                                                                " ref="producto" v-model="
                                                                                    form.item_consignment_id
                                                                                " @change="
                                                                                    changeItem
                                                                                " filterable remote placeholder="Buscar......" popper-class="el-select-items" @visible-change="
                                                                                    focusTotalItem
                                                                                " slot="prepend" id="select-width" :remote-method="
                                                                                    searchRemoteItems
                                                                                " :loading="
                                                                                    loading_search
                                                                                ">
                                                                        <el-option v-for="option in items" :key="
                                                                                        option.id
                                                                                    " :value="
                                                                                        option.id
                                                                                    " :label="
                                                                                        option.full_description ||
                                                                                            option.description
                                                                                    "></el-option>
                                                                    </el-select>
                                                                </div>
                                                            </template>
                                                        </div>

                                                        <!-- Habilitar Transformación de producto -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-exchange-alt tab-icon"></i>
                                                                    Habilitar
                                                                    Transformación
                                                                    de
                                                                    producto
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.transform_item
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Habilitar Tratamiento comercial Producto -->
                                                        <div class="col-md-3 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-hand-holding-usd tab-icon"></i>
                                                                    Habilitar
                                                                    Tratamiento
                                                                    comercial
                                                                    Producto
                                                                    <el-tooltip class="item" effect="dark" content="Trato comercial" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>

                                                                <el-switch v-model="
                                                                                form.commercial_treatment_items
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <!-- Panel Contable---- -->
                                <el-tab-pane name="accounting">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="el-icon-document tab-icon"></i>
                                            <span class="tab-text">Contable</span>
                                        </div>
                                    </template>
                                    <!-- Busqueda dentro de la pestaña de contable -->
                                    <div class="col-md-8">
                                        <label class="control-label text-primary">
                                            <i class="fas fa-search fa-lg"></i> Buscar
                                        </label>
                                        <div class="form-group">
                                            <el-input v-model="searchQueryAccounting" placeholder="Escribe para buscar..." style="width: 100%; max-width: 300px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);" maxlength="30" show-word-limit type="text">
                                                <template #prefix>
                                                    <i class="fas fa-search text-muted"></i>
                                                </template>
                                            </el-input>
                                        </div>
                                    </div>

                                    <div class="nested-tab-content" ref="accountingTab">
                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-exchange-alt tab-icon"></i>
                                                        Cambiar Afectación
                                                        IGV (CAJA)
                                                        <el-tooltip content="Permite cambiar la afectación de IGV en caja">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.affectation_optional
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4" v-if="
                                                            typeUser != 'integrator'
                                                        ">
                                                <label class="control-label">
                                                    <i class="fas fa-sort-numeric-up tab-icon"></i>
                                                    Cantidad decimales POS
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.decimal_quantity
                                                            }">
                                                    <el-input-number v-model="
                                                                    form.decimal_quantity
                                                                " @change="submit" :min="2" :max="10"></el-input-number>
                                                    <small class="text-danger" v-if="
                                                                    errors.decimal_quantity
                                                                " v-text="
                                                                    errors
                                                                        .decimal_quantity[0]
                                                                "></small>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mt-4" v-if="
                                                            typeUser != 'integrator'
                                                        ">
                                                <label class="control-label">
                                                    <i class="fas fa-recycle tab-icon"></i>
                                                    Impuesto bolsa plástica
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.amount_plastic_bag_taxes
                                                            }">
                                                    <el-input-number v-model="
                                                                    form.amount_plastic_bag_taxes
                                                                " @change="
                                                                    changeAmountPlasticBagTaxes
                                                                " :precision="2" :step="0.1" :max="0.5" :min="0.1"></el-input-number>
                                                    <small class="text-danger" v-if="
                                                                    errors.amount_plastic_bag_taxes
                                                                " v-text="
                                                                    errors
                                                                        .amount_plastic_bag_taxes[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.affectation_igv_type_id
                                                            }">
                                                    <label class="control-label">
                                                        <i class="fas fa-file-invoice-dollar tab-icon"></i>
                                                        Tipo de afectación
                                                        Venta
                                                        <el-tooltip class="item" effect="dark" content="Tipo de afectación predeterminada al registrar nuevo producto" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="
                                                                    form.affectation_igv_type_id
                                                                " @change="submit" filterable>
                                                        <el-option v-for="option in affectation_igv_types" :key="option.id" :value="
                                                                        option.id
                                                                    " :label="
                                                                        option.description
                                                                    "></el-option>
                                                    </el-select>
                                                    <small class="text-danger" v-if="
                                                                    errors.affectation_igv_type_id
                                                                " v-text="
                                                                    errors
                                                                        .affectation_igv_type_id[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <label class="control-label">
                                                    <i class="fas fa-paper-plane tab-icon"></i>
                                                    Envío de comprobantes
                                                    automático
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.send_auto
                                                            }">
                                                    <el-switch v-model="
                                                                    form.send_auto
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    <small class="text-danger" v-if="
                                                                    errors.send_auto
                                                                " v-text="
                                                                    errors
                                                                        .send_auto[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4" v-if="
                                                            typeUser != 'integrator'
                                                        ">
                                                <label class="control-label">
                                                    <i class="fas fa-calendar-alt tab-icon"></i>
                                                    Ejecutar Tareas
                                                    Programadas
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.cron
                                                            }">
                                                    <el-switch v-model="form.cron" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    <small class="text-danger" v-if="errors.cron" v-text="
                                                                    errors.cron[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <label class="control-label">
                                                    <i class="fas fa-calendar-check tab-icon"></i>
                                                    Cambiar fecha de emisión
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.change_date_emit
                                                            }">
                                                    <el-switch v-model="
                                                                    form.change_date_emit
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    <small class="text-danger" v-if="
                                                                    errors.change_date_emit
                                                                " v-text="
                                                                    errors
                                                                        .change_date_emit[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <label class="control-label">
                                                    <i class="fas fa-ban tab-icon"></i>
                                                    Restringir fecha de
                                                    comprobante
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.restrict_receipt_date
                                                            }">
                                                    <el-switch v-model="
                                                                    form.restrict_receipt_date
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    <small class="text-danger" v-if="
                                                                    errors.restrict_receipt_date
                                                                " v-text="
                                                                    errors
                                                                        .restrict_receipt_date[0]
                                                                "></small>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mt-4">
                                                <label class="control-label">
                                                    <i class="fas fa-calendar-day tab-icon"></i>
                                                    Días transcurridos para
                                                    emitir dcto
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.days_before_emit
                                                            }">
                                                    <el-select v-model="
                                                                    form.days_before_emit
                                                                " @change="submit">
                                                        <el-option v-for="day in days" :key="
                                                                        `${day.id}-d`
                                                                    " :value="
                                                                        day.value
                                                                    " :label="
                                                                        `${
                                                                            day.value
                                                                        } ${
                                                                            day.value >
                                                                            1
                                                                                ? ' días'
                                                                                : ' día'
                                                                        }`
                                                                    "></el-option>
                                                    </el-select>
                                                    <small class="text-danger" v-if="
                                                                    errors.days_before_emit
                                                                " v-text="
                                                                    errors
                                                                        .days_before_emit[0]
                                                                "></small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <label class="control-label">
                                                    <i class="fas fa-receipt tab-icon"></i>
                                                    Impuesto incluido en
                                                    registro de productos
                                                </label>
                                                <div class="form-group" :class="{
                                                                'has-danger':
                                                                    errors.include_igv
                                                            }">
                                                    <el-switch v-model="
                                                                    form.include_igv
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    <small class="text-danger" v-if="
                                                                    errors.include_igv
                                                                " v-text="
                                                                    errors
                                                                        .include_igv[0]
                                                                "></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <!-- Panel Configuración General---- -->
                                <el-tab-pane name="visual">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="el-icon-view tab-icon"></i>
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
                                                        <label class="control-label">
                                                            buscar
                                                        </label>
                                                        <div class="form-group">
                                                            <el-input v-model="
                                                                            searchQueryVisual
                                                                        " placeholder="Buscar..." style="width: 240px" maxlength="20" show-word-limit type="text"></el-input>
                                                        </div>
                                                    </div>
                                                    <div class="nested-tab-content" ref="visualTab">
                                                        <el-row :gutter="20">
                                                            <!-- Seccion Gestion de Documento -->
                                                            <el-col :span="12">
                                                                <el-card class="section-card" shadow="hover">
                                                                    <div slot="header" class="card-header bg-primary text-white">
                                                                        <i class="fas fa-file-alt fa-lg"></i>
                                                                        Gestiones Adicionales
                                                                    </div>

                                                                    <div class="section-content">
                                                                        <!-- Contenido de la sección 1 -->
                                                                        <div class="row">
                                                                            <!-- Recrear Documento -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <label class="control-label">
                                                                                    <i class="fas fa-sync-alt tab-icon"></i>
                                                                                    Recrear Documento
                                                                                </label>
                                                                                <div class="form-group" :class="{ 'has-danger': errors.recreat_document }">
                                                                                    <el-switch v-model="form.recreat_document" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.recreat_document" v-text="errors.recreat_document[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Eliminar Documento -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <label class="control-label">
                                                                                    <i class="fas fa-trash-alt tab-icon"></i>
                                                                                    Eliminar Documento
                                                                                </label>
                                                                                <div class="form-group" :class="{ 'has-danger': errors.delete_document }">
                                                                                    <el-switch v-model="form.delete_document" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.delete_document" v-text="errors.delete_document[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Visualiza Usuarios en Administrador -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-users-cog tab-icon"></i>
                                                                                        Habilita Usuarios (Admin)
                                                                                        <el-tooltip class="item" effect="dark" content="Visualiza Usuarios en Administrador" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.users_views" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Dar a crédito nota de venta -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-hand-holding-usd tab-icon"></i>
                                                                                        Dar a crédito nota de venta (sin cuotas)
                                                                                    </label>
                                                                                    <el-switch v-model="form.sale_note_credit_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Requerir número de operación (YAPE/PLIN/TARJETAS) -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-receipt tab-icon"></i>
                                                                                        Requerir número de operación (YAPE/PLIN/TARJETAS)
                                                                                        <el-tooltip class="item" effect="dark" content="Número de operación obligatorio para emitir comprobante de pago" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.require_code" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Cargo por pago con tarjeta -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-credit-card tab-icon"></i>
                                                                                        Cargo por pago con tarjeta
                                                                                    </label>
                                                                                    <el-switch v-model="form.credit_mode" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Ver venta diaria -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-chart-line tab-icon"></i>
                                                                                        Ver venta diaria
                                                                                    </label>
                                                                                    <el-switch v-model="form.view_daily_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Ver venta diaria con pin -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-lock tab-icon"></i>
                                                                                        Ver venta diaria con pin
                                                                                    </label>
                                                                                    <el-switch v-model="form.view_daily_cash_pin" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Descuentos variante -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-percentage tab-icon"></i>
                                                                                        Descuentos variante
                                                                                        <el-tooltip content="Permite recalcular el precio de venta de un producto con descuento a la base imponible">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.discount_with_base_variant" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Números de whatsapp para enviar actividad -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">Números de whatsapp para enviar actividad
                                                                                        <a v-if="form.number_activity" href="#" @click.prevent="addNumberWhatsapp">[Agregar +]</a>
                                                                                    </label>
                                                                                    <el-input @input="changeNumberActivity" v-model="form.number_activity"></el-input>
                                                                                    <small>
                                                                                        <el-tag class="mt-1" v-for="(number, idx) in numbers" :key="idx" closable @close="removeNumberWhatsapp(idx)">
                                                                                            {{ number.number }}
                                                                                        </el-tag>
                                                                                    </small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Usuarios con series independientes -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-user-cog tab-icon"></i>
                                                                                        Usuarios con series independientes
                                                                                        <el-tooltip content="Permite asignar una serie a un usuario">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.user_series_independientes_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Enviar XML por whatsapp -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-file-export tab-icon"></i>
                                                                                        Enviar XML por whatsapp
                                                                                    </label>
                                                                                    <el-switch v-model="form.xml_whatsapp" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Nombre Secundario - Código Externo -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-tags tab-icon"></i>
                                                                                        Mostrar Nombre secundario - Código externo
                                                                                        <el-tooltip content="Mostrar Nombre secundario - Código externo en el formulario de productos">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_second_name_external_code" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Detracción por defecto -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-piggy-bank tab-icon"></i>
                                                                                        Detracción por defecto
                                                                                        <el-tooltip content="Se elegirá la detracción por defecto al momento de crear un comprobante de venta">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-select v-model="form.detraction_type_id" @change="submit" filterable clearable>
                                                                                        <el-option v-for="option in detraction_types" :key="option.id" :value="option.id" :label="`${option.percentage}% ${option.description}`"></el-option>
                                                                                    </el-select>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Vender con stock -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-boxes tab-icon"></i>
                                                                                        Vender con stock
                                                                                    </label>
                                                                                    <el-switch v-model="form.sales_stock" active-text="Si" inactive-text="No" @change="submit; stock_control();"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar política precios ticket -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-ticket-alt tab-icon"></i>
                                                                                        Mostrar política precios ticket
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_unit_types_ticket" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Usar número personal (whatsapp) -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-phone tab-icon"></i>
                                                                                        Usar número personal (whatsapp)
                                                                                    </label>
                                                                                    <el-switch v-model="form.personal_phone" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Enviar whatsapp al ver venta diaria -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-paper-plane tab-icon"></i>
                                                                                        Enviar whatsapp al ver venta diaria
                                                                                    </label>
                                                                                    <el-switch v-model="form.send_whatsapp_daily_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Observación al hacer ajuste de stock -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-edit tab-icon"></i>
                                                                                        Observación al hacer ajuste de stock
                                                                                        <el-tooltip content="Obligar a dar razón del traslado">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.observation_translate" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Enviar whatsapp por pagos YAPE/PLIN -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-paper-plane tab-icon"></i>
                                                                                        Enviar whatsapp por pagos YAPE/PLIN
                                                                                        <el-tooltip class="item" effect="dark" content="Enviar un whatsapp al número del dueño por cada pago con YAPE/PLIN" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.send_whatsapp_digital_pay" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Permitir anulado interno -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-ban tab-icon"></i>
                                                                                        Permitir anulado interno
                                                                                    </label>
                                                                                    <el-switch v-model="form.internal_voided" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </el-card>
                                                            </el-col>

                                                            <!-- Seccion  Gestión de Caja -->
                                                            <el-col :span="12">
                                                                <el-card class="section-card" shadow="hover">
                                                                    <div slot="header" class="card-header bg-primary text-white">
                                                                        <i class="fas fa-cash-register fa-lg"></i>
                                                                        Gestión de Caja
                                                                    </div>
                                                                    <div class="section-content">
                                                                        <!-- Contenido de la sección Caja -->
                                                                        <div class="row">
                                                                            <!-- Multiples Caja (Usuario Cajero) -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-cash-register fa-lg"></i> Multiples Cajas
                                                                                        <el-tooltip class="item" effect="dark" content="Multiples Cajas, para usuario CAJERO" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.multiple_boxes" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Acciones en caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-tasks fa-lg"></i> Acciones en Caja
                                                                                        <el-tooltip class="item" effect="dark" content="Acciones en CAJA, como anulación de comprobantes, pagos, nota de crédito" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.caja_actions" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Venta Rapida (Modulo Caja) -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-bolt fa-lg"></i> Venta Rápida
                                                                                        <el-tooltip class="item" effect="dark" content="Venta Rápida módulo de CAJA (Activar en Establecimientos)" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.sales_quick" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Vendedores en caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-user-tie fa-lg"></i> Vendedores en Caja
                                                                                        <el-tooltip class="item" effect="dark" content="Activa selección de Vendedores en CAJA" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.seller_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar gastos / ingresos en caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-eye fa-lg"></i> Mostrar Gastos e Ingresos
                                                                                        <el-tooltip class="item" effect="dark" content="Mostrar Modal de Gastos e Ingresos en CAJA" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_expenses_incomes_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar Precio Venta en Caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-edit fa-lg"></i> Editar Precio de Venta
                                                                                        <el-tooltip class="item" effect="dark" content="Editar Precio de venta en CAJA" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.edit_price_sales" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.edit_price_sales" v-text="errors.edit_price_sales[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar Cantidad en Caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-calculator fa-lg"></i> Editar Cantidad
                                                                                        <el-tooltip class="item" effect="dark" content="Editar Cantidad de venta en CAJA" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.quantity_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.quantity_cash" v-text="errors.quantity_cash[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar subtotal en caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-pencil-alt fa-lg"></i> Editar Subtotal
                                                                                        <el-tooltip class="item" effect="dark" content="Editar Subtotal de venta en CAJA" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.edit_subtotal_box" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Todos los productos - caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-list fa-lg"></i> Todos los productos - caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.all_items_pos" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar nombre de productos -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-edit fa-lg"></i> Editar nombre de productos
                                                                                    </label>
                                                                                    <el-switch v-model="form.edit_name_product" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.edit_name_product" v-text="errors.edit_name_product[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar lista o tarjeta de productos -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-th-list fa-lg"></i> Mostrar lista o tarjeta de productos
                                                                                    </label>
                                                                                    <el-switch v-model="form.list_or_card" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.list_or_card" v-text="errors.list_or_card[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Lote en lista de productos -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-boxes fa-lg"></i> Lote en lista de productos
                                                                                    </label>
                                                                                    <el-switch v-model="form.lotgroup_list_or_card" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.lotgroup_list_or_card" v-text="errors.lotgroup_list_or_card[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Política de precio en lista de productos -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-tag fa-lg"></i> Política de precio en lista de productos
                                                                                    </label>
                                                                                    <el-switch v-model="form.listprice_list_or_card" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                    <small class="text-danger" v-if="errors.listprice_list_or_card" v-text="errors.listprice_list_or_card[0]"></small>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Barcode en Caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-barcode fa-lg"></i> Barcode en Caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.barcode" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Una caja por establecimiento -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-store-alt fa-lg"></i> Una caja por establecimiento
                                                                                        <el-tooltip class="item" effect="dark" content="Solo se podrá tener una caja activa por establecimiento" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.only_cash_by_establishment" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Usuarios excluidos -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-user-lock fa-lg"></i> Usuarios excluidos
                                                                                        <el-tooltip class="item" effect="dark" content="Usuarios que podrán abrir caja en el establecimiento aunque ya exista una caja abierta" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-select v-model="user_excluded_id" placeholder="Seleccione" filterable clearable style="width: 100%" @change="addUserExcluded">
                                                                                        <el-option v-for="user in users" :key="user.id" :label="user.name" :value="user.id"></el-option>
                                                                                    </el-select>
                                                                                    <br />
                                                                                    <el-tag class="m-1" v-for="user in users_excluded" :key="user.id" closable @close="removeUserExcluded(user.id)">{{ user.name }}</el-tag>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Detalle métodos - reporte -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-file-alt fa-lg"></i> Detalle métodos - reporte
                                                                                        <el-tooltip class="item" effect="dark" content="Mostrar detalle método de pago (no efectivo) en reporte" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.report_cash_methods" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </el-card>
                                                            </el-col>
                                                        </el-row>
                                                        <el-row :gutter="20">
                                                            <!-- Section 3 Gestión de Productos -->
                                                            <el-col :span="12">
                                                                <el-card class="section-card" shadow="hover">
                                                                    <div slot="header" class="card-header bg-primary text-white">
                                                                        <i class="fas fa-box fa-lg"></i>
                                                                        Gestión de Productos
                                                                    </div>
                                                                    <div class="section-content">
                                                                        <!-- Contenido de Gestion de Productos-->
                                                                        <div class="row">
                                                                            <!-- Crear Productos en caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-box fa-lg"></i> Crear Productos en caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.product_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar Producto en caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-pencil-ruler fa-lg"></i> Editar Producto en caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.edit_product_pos" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar descripción Completa del producto en Caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-align-left fa-lg"></i>Descripción Full del producto en Caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.trunc_txt" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Stock de Productos -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-eye fa-lg"></i> Mostrar Stock de Productos
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_stock_cash" active-text="Si" inactive-text="No" @change="submit; stock_control();"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar productos por vencer en caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-hourglass-half fa-lg"></i> Mostrar productos por vencer en caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.items_due_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Bloquear stock inicial -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-lock fa-lg"></i> Bloquear stock inicial
                                                                                    </label>
                                                                                    <el-switch v-model="form.init_stock" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Permitir Ajuste de Stock -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-tools fa-lg"></i> Permitir Ajuste de Stock
                                                                                    </label>
                                                                                    <el-switch v-model="form.item_adjustment" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Crear Productos Compuestos en caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-cubes fa-lg"></i> Crear Productos Compuestos en caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.item_set_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Editar Productos Compuestos en caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-box-open fa-lg"></i> Editar Productos Compuestos en caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.item_set_quantity_pos" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Imagenes de Productos en Cotización -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-image fa-lg"></i> Mostrar Imagenes de Productos en Cotización
                                                                                    </label>
                                                                                    <el-switch v-model="form.image_quotation" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Ordenar Productos por Descripción en Caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-sort-alpha-down fa-lg"></i> Ordenar Productos por Descripción
                                                                                    </label>
                                                                                    <el-switch v-model="form.ord_dscp" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Buscar por series en Caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-search fa-lg"></i> Buscar Producto por Series
                                                                                    </label>
                                                                                    <el-switch v-model="form.search_series_pos" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Stock Almacénes -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-warehouse fa-lg"></i> Mostrar Stock Almacénes
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_stock_establishment_box" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Enviar whatsapp por pagos YAPE/PLIN -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-mobile-alt fa-lg"></i> Enviar whatsapp por pagos YAPE/PLIN
                                                                                    </label>
                                                                                    <el-switch v-model="form.send_whatsapp_digital_pay" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Traslados directos -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-exchange-alt fa-lg"></i> Traslados directos
                                                                                    </label>
                                                                                    <el-switch v-model="form.translate_direct" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Visualizar administrador - usuarios -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-user-cog fa-lg"></i> Visualizar administrador - usuarios
                                                                                    </label>
                                                                                    <el-switch v-model="form.users_views" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Tratamiento comercial Categoría -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-handshake fa-lg"></i> Tratamiento comercial Categoría
                                                                                    </label>
                                                                                    <el-switch v-model="form.commercial_treatments" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Tratamiento comercial Producto -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-handshake fa-lg"></i> Tratamiento comercial Producto
                                                                                    </label>
                                                                                    <el-switch v-model="form.commercial_treatment_items" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Servicio en todos los establecimientos -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-warehouse fa-lg"></i> Servicio en todos los establecimientos
                                                                                    </label>
                                                                                    <el-switch v-model="form.create_service_all_warehouse" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Caja principal automatica -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-cash-register fa-lg"></i> Caja principal automática
                                                                                    </label>
                                                                                    <el-switch v-model="form.automatic_principal_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Reporte caja - para llevar -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-file-alt fa-lg"></i> Reporte caja - para llevar
                                                                                    </label>
                                                                                    <el-switch v-model="form.carry_cash_report" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Billetes/Monedas a recibir caja -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-coins fa-lg"></i> Billetes/Monedas a recibir caja
                                                                                    </label>
                                                                                    <el-switch v-model="form.show_coins_to_receive" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Buscar por segundo nombre -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-id-card fa-lg"></i> Buscar por segundo nombre
                                                                                    </label>
                                                                                    <el-switch v-model="form.search_by_second_name" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Whatsapp en Reimpresión de Documentos -->
                                                                            <div class="col-md-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-mobile-alt fa-lg"></i> Whatsapp en Reimpresión de Documentos
                                                                                    </label>
                                                                                    <el-switch v-model="form.reprint_whatsapp" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </el-card>
                                                            </el-col>
                                                            <!-- Section 4 -->
                                                            <el-col :span="12">
                                                                <el-card class="section-card" shadow="hover">
                                                                    <div slot="header" class="card-header bg-primary text-white">
                                                                        <i class="fas fa-box fa-lg"></i>
                                                                        Gestión de Pagos
                                                                    </div>
                                                                    <div class="section-content">
                                                                        <!-- Contenido de Gestion de Productos-->
                                                                        <div class="row">
                                                                            <!-- Mostrar culqui en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar culqui en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.culqi" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar yape en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar yape en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.yape" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar izipay en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar izipay en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.izipay" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar openpay en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar openpay en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.openpay" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar nubiz en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar nubiz en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.nubiz" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar plin en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar plin en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.plin" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Rappi en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar Rappi en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.rappi" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Pedidos-Ya en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar Pedidos-Ya en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.pedidosya" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Mostrar Didi-Foods en Métodos de Pago caja -->
                                                                            <div class="col-md-4 mt-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label w-100">
                                                                                        <i class="fas fa-wallet tab-icon"></i>
                                                                                        Mostrar Didi-Foods en Métodos de Pago caja
                                                                                        <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                                            <i class="fa fa-info-circle"></i>
                                                                                        </el-tooltip>
                                                                                    </label>
                                                                                    <el-switch v-model="form.didi" active-text="Si" inactive-text="No" @change="submit"></el-switch>
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

                                    </template>
                                </el-tab-pane>

                                <!-- Panel de Impresión -->
                                <el-tab-pane label="Impresión" v-if="!isArca">
                                    <template #label>
                                        <i class="fas fa-print fa-lg"></i> Impresión
                                    </template>
                                    <div class="row">
                                        <!-- Impresoras Nuevas -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-print fa-lg"></i> Impresoras Nuevas
                                                <el-tooltip class="item" effect="dark" content="Permite configurar si las impresoras que se usan para la impresión directa en A5/A4 son nuevas o antiguas" placement="top-start">
                                                    <i class="fa fa-info-circle"></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch v-model="form.new_old_printer" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Orientación A5 -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-arrows-alt-h fa-lg"></i> Orientación A5
                                            </label>
                                            <el-switch v-model="form.a5_orientation" active-text="Horizontal" inactive-text="Vertical" @change="submit"></el-switch>
                                        </div>

                                        <!-- Mostrar logo en documentos -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-image fa-lg"></i> Mostrar logo en documentos
                                            </label>
                                            <el-switch v-model="form.show_logo_in_documents" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Mostrar código interno en productos (ticket) -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-barcode fa-lg"></i> Mostrar código interno en productos (ticket)
                                            </label>
                                            <el-switch v-model="form.show_internal_code_ticket" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Recibir Productos (traslado) -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-dolly fa-lg"></i> Recibir Productos (traslado)
                                                    <el-tooltip class="item" effect="dark" content="Recibir Productos por TRASLADO DE MERCADERÍA en CAJA" placement="top-start">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-switch v-model="form.receive_merchandise" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir productos vendidos en reporte ticket -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-list fa-lg"></i> Imprimir productos vendidos en reporte ticket
                                            </label>
                                            <el-switch v-model="form.configurable_impresion_ticket_categoria_caja" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Imprimir correo en ticket -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-envelope fa-lg"></i> Imprimir correo en ticket
                                            </label>
                                            <el-switch v-model="form.correo_red_salud_ticket" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Imprimir número de whatsapp en ticket -->
                                        <div class="col-md-3 mt-2">
                                            <label class="control-label w-100">
                                                <i class="fas fa-phone-alt fa-lg"></i> Imprimir número de whatsapp en ticket
                                            </label>
                                            <el-switch v-model="form.numero_accion_independiente_admin" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        </div>

                                        <!-- Impresión en áreas diferentes -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión en áreas diferentes
                                                </label>
                                                <el-switch v-model="form.print_direct_just_different_areas" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Impresión Directa -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión Directa
                                                </label>
                                                <el-switch v-model="form.print_direct" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir referencia en ticket -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-receipt fa-lg"></i> Imprimir referencia en ticket
                                                </label>
                                                <el-switch v-model="form.reference_ticket" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir gastos/ingresos -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-balance-scale fa-lg"></i> Imprimir gastos/ingresos
                                                </label>
                                                <el-switch v-model="form.print_incomes_expenses" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Guardar decisión de impresión -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-save fa-lg"></i> Guardar decisión de impresión
                                                </label>
                                                <el-switch v-model="form.save_pos_printing" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Reimpresión de documentos - Caja -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Reimpresión de documentos - Caja
                                                </label>
                                                <el-switch v-model="form.print_document_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Impresión directa vendedor Cotización - Caja -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión directa vendedor Cotización - Caja
                                                </label>
                                                <el-switch v-model="form.seller_quotation_cash" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir política de precio - Cotización -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-tags fa-lg"></i> Imprimir política de precio - Cotización
                                                </label>
                                                <el-switch v-model="form.unit_type_pdf_quotation" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Guardar decisión de Impresión -->
                                        <div class="col-md-3 mt-2">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-save fa-lg"></i> Guardar decisión de Impresión
                                                </label>
                                                <el-switch v-model="form.save_pos_printing" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Texto pie de página -->
                                        <div class="col-md-3 mt-2">
                                            <label for="text-3">
                                                <i class="fas fa-quote-right fa-lg"></i> Texto pie de página
                                                <el-tooltip class="item" effect="dark" content="Texto que va en la parte inferior de los documentos" placement="top-start">
                                                    <i class="fa fa-info-circle"></i>
                                                </el-tooltip>
                                            </label>
                                            <el-input class="w-100" v-model="form.footer_text" placeholder="Pie de página" size="normal" type="textarea" rows="3" @input="saveSubmitDebounce"></el-input>
                                        </div>
                                    </div>

                                </el-tab-pane>

                                <el-tab-pane label="Crédito NV" v-if="form.credits">
                                    <div class="row">
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">Penalidades
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_penalty
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">Confirmación de
                                                    aprobación
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_confirm
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    Aceptar monto menores en
                                                    la cuotas
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_low_pay
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">Editar
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_edit
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">Enviar whatsapp a
                                                    clientes
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_send_whatsapp
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">Mostrar formatos
                                                    adicionales
                                                </label>
                                                <el-switch v-model="
                                                                form.sale_note_credit_formats
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    Whatsapp personalizado
                                                    <el-tooltip class="item" effect="dark" content="Usa su propia app de whatsapp" placement="top-start">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                </label>

                                                <el-switch v-model="
                                                                form.whatsapp_client
                                                            " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">% de crédito
                                                </label>
                                                <el-input-number class="w-100" v-model="form.rates" :precision="2" :step="0.5" :max="100" active-text="Si" inactive-text="No" @change="submit"></el-input-number>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                                <!-- Panel de Arca---- -->
                                <el-tab-pane name="Arca">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-archive tab-icon"></i>
                                            <span class="tab-text">
                                                Arca</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        Contenido de Arca
                                        <div class="row">
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-cash-register fa-lg"></i>
                                                        Manejo de caja
                                                        principal
                                                    </label>
                                                    <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.principal_cash
                                                                "></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-cogs fa-lg"></i>
                                                        Caja principal
                                                        automatica
                                                        <el-tooltip class="item" effect="dark" content="Caja principal se cierra y abre en base al turno inicial - final" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.automatic_principal_cash
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-clock fa-lg"></i>
                                                        Turno inicio
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="
                                                                    form.turn_principal
                                                                " @change="submit" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="
                                                                        turn.label
                                                                    " :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-clock fa-lg"></i>
                                                        Turno final
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="
                                                                    form.turn_end
                                                                " @change="submit" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="
                                                                        turn.label
                                                                    " :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-money-check-alt fa-lg"></i>
                                                        A cuenta
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.credit_list
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                                <!-- Panel de módulos -->

                                <el-tab-pane name="Módulos">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-cubes"></i>
                                            <span class="tab-text fa-lg"> Módulos</span>
                                        </div>
                                    </template>

                                    <!-- Sección de Pestañas -->
                                    <el-tabs type="border-card" v-model="activeSubTab" @tab-click="handleTabClick">
                                        <!-- Pestaña Mantenimiento -->
                                        <el-tab-pane label="Mantenimiento" name="tab-1">
                                            <div class="nested-tab-content">
                                                Modulo Mantenimmiento
                                                <div class="row">
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Bancos
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.bancos
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Cuentas Bancarias
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.cuentas_bancarias
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Vendedores
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.vendedores
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Registro de Actividad
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.registro_actividad
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Categorias
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.categorias
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Marca
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.marca
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Clientes
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.clientes
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Proveedores
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.provedores
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Atributos
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.atributos
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Unidad de Medida
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.unidad_medida
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña 2 -->
                                        <el-tab-pane label="Compras" name="tab-2">
                                            <div class="nested-tab-content">
                                                Modulo Compras
                                                <div class="row">
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Compras
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                            form.lista_compras
                                                            " active-text="Si" inactive-text="No" @change="
                                                            submit
                                                        "></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>
                                        <!-- Pestaña 3 -->
                                        <el-tab-pane label="Inventario" name="tab-3">
                                            <div class="nested-tab-content">
                                                Modulo Inventario
                                                <div class="row">
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Recibir
                                                                Productos
                                                                (traslado)
                                                                <el-tooltip class="item" effect="dark" content="Recibir Productos por TRASLADO DE MERCADERIA en CAJA activa 2 modulos en adminsitrador inventario" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.receive_merchandise
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Productos
                                                                <el-tooltip class="item" effect="dark" content="Modulo de productos aqui se encuentra todo los productos registrados y tambien se puede crear" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.listado_productos
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Guias de Remision
                                                                <el-tooltip class="item" effect="dark" content="Modulo de guias de remision aqui puedes generar una guia re remision por administrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.guias_remision
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Promociones y Ofertas
                                                                <el-tooltip class="item" effect="dark" content="Modulo de promociones y Ofertas para crear platos con receta" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.promocion_oferta
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Ingreso y Salida de Productos
                                                                <el-tooltip class="item" effect="dark" content="Modulo de ingreso y salida de productos aqui podemos sacar o ingresar productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.ingreso_salida_productos
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                Tipo de Transacciones Inventario
                                                                <el-tooltip class="item" effect="dark" content="Modulo de transaciones e inventario aqui podemos crear o inhabilitar los tipos de gtransacciones que nos para el ingreso o salidda de productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="
                                                                form.tipo_transacciones_inventario
                                                                " active-text="Si" inactive-text="No" @change="
                                                                submit
                                                            "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Etiquetas
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos imprimir nuestras etiquetas de nuestros productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.ver_etiqueta_logistica" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>
                                        <!-- Pestaña 4 -->
                                        <el-tab-pane label="Comprobantes de Pago" name="tab-4">
                                            <div class="nested-tab-content">
                                                Modulo Comprobantes de Pago
                                                <div class="row">
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Nuevo Comprobante
                                                                <el-tooltip class="item" effect="dark" content="Aqui podemos emitir boletas y facturas de adminsitrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nuevo_comprobante_electronico" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Listado de Comprobantes
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todo los comprobantes emitidos boletas y facturas" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.listado_boleta_factura_nuevo" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                No Enviados
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver los docuemntos que no se enviaron a sunat o vencieron el plazo de envio" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.no_enviados" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Nota de Venta
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todo las notas de venta generados y tambien renegar nuevas notas de venta" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nota_venta" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Nota de Credito
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos generar notas de credito con los documentos que por error se envio a sunat y se pedira la devolucion" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nota_credito" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Cotizaciones
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver las cotizaciones y crear nuevas cotizaciones en administrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.cotizaciones" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Resumenes
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver los resumenes generados de las boletas y tambien generar nuevos resumenes por fecha" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.resumenes" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-tags tab-icon"></i>
                                                                Anulaciones
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todo los documentos anulados" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.anulaciones" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-percentage tab-icon"></i>
                                                                Detracciones
                                                            </label>
                                                            <el-switch v-model="form.detraction" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña 5 -->
                                        <el-tab-pane label="Arqueo" name="tab-5">
                                            <div class="nested-tab-content">
                                                Modulos de arqueo 
                                                <div class="row">
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-patient-file"></i>
                                                                Reporte de Caja
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_caja
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-attachment"></i>
                                                                Reporte de Cierre De Caja
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_cierre_caja
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-globe"></i>
                                                                Reporte Globalizado
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_globalizado
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña 6 -->
                                        <el-tab-pane label="Reportes" name="tab-6">
                                            <div class="nested-tab-content">
                                                <div class="row">
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-list"></i>
                                                                Productos Vendidos
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.productos_vendidos
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-box"></i>
                                                                Reporte de metodos de pago
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_metodos_pago
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-money-bag"></i>
                                                                Reporte de Ganancias
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_ganancias
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-window-restore "></i>
                                                                Reporte de Productos
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_productos
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-dollar"></i>
                                                                Stock Valorizado
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.stock_valorizado
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-boxes"></i>
                                                                Stock Minimo
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.stock_minimo
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-box"></i>
                                                                Stock De Producto
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.stock_producto
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-chart-bar-graph"></i>
                                                                Kardex
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.kardex
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-fingerprint"></i>
                                                                Reprote De Series Vendidas
                                                            </label>
                                                            <el-switch active-text="Si" inactive-text="No" @change="submit" v-model="
                                                                    form.reporte_series_vendidas
                                                                "></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>
                                    </el-tabs>
                                </el-tab-pane>

                                <!-- Restaurant-------- -->
                                <el-tab-pane v-if="form.restaurant" name="restaurant">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-utensils tab-icon"></i>
                                            <span class="tab-text">Restaurant</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        <el-row :gutter="20">
                                            <el-col :span="12">
                                                <el-card shadow="hover">
                                                    <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                                        <i class="fas fa-cash-register" style="margin-right: 10px;"></i>
                                                        <span>Caja</span>
                                                    </div>
                                                    <div>
                                                        Contenido de la Caja.
                                                        <div class="row">
                                                            <div class="col-md-4 mt-4">
                                                                <label class="control-label">
                                                                    <i class="fa fa-receipt fa-lg"></i>
                                                                    Uso de
                                                                    Comanda
                                                                    Física
                                                                </label>
                                                                <div class="form-group" :class="{
                                                                                'has-danger':
                                                                                    errors.commands_fisico
                                                                            }">
                                                                    <el-switch v-model="
                                                                                    form.commands_fisico
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                    <small class="text-danger" v-if="
                                                                                    errors.commands_fisico
                                                                                " v-text="
                                                                                    errors
                                                                                        .commands_fisico[0]
                                                                                "></small>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-print fa-lg"></i>
                                                                        Imprimir
                                                                        Comanda
                                                                        en
                                                                        Caja
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.print_commands
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-file-alt fa-lg"></i>
                                                                        Emitir
                                                                        Documento
                                                                        Variación
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.show_variation_dcto
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <template id="select-append">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-boxes fa-lg"></i>
                                                                        Producto
                                                                        -
                                                                        Variación
                                                                    </label>
                                                                    <div class="el-input el-input-group el-input-group--append">
                                                                        <el-select :disabled="
                                                                                        !form.show_variation_dcto
                                                                                    " @focus="
                                                                                        $event.target.select()
                                                                                    " ref="producto" v-model="
                                                                                        form.item_variation_id
                                                                                    " @change="
                                                                                        changeItem
                                                                                    " filterable remote placeholder="Buscar..." popper-class="el-select-items" @visible-change="
                                                                                        focusTotalItem
                                                                                    " slot="prepend" id="select-width" :remote-method="
                                                                                        searchRemoteItems
                                                                                    " :loading="
                                                                                        loading_search
                                                                                    ">
                                                                            <el-option v-for="option in items" :key="
                                                                                            option.id
                                                                                        " :value="
                                                                                            option.id
                                                                                        " :label="
                                                                                            option.full_description ||
                                                                                                option.description
                                                                                        "></el-option>
                                                                        </el-select>
                                                                    </div>
                                                                </template>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-key fa-lg"></i>
                                                                        Pedir
                                                                        PIN
                                                                        al
                                                                        Eliminar
                                                                        Orden
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.pin_orden_delete
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-whatsapp fa-lg"></i>
                                                                        Enviar
                                                                        Whatsapp
                                                                        al
                                                                        Eliminar
                                                                        Orden
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.send_whatsapp_activity
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-list-alt fa-lg"></i>
                                                                        Categorías
                                                                        Arrastrables
                                                                        Caja
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.pos_drag_category
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-lock fa-lg"></i>
                                                                        Evitar
                                                                        Cerrar
                                                                        Caja
                                                                        con
                                                                        Ordenes
                                                                        Pendientes
                                                                        <el-tooltip content="Alerta sobre las mesas pendientes al cerrar caja, es posible emitir una nota de venta por todo">
                                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                                        </el-tooltip>
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.ordens_cash
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-clipboard fa-lg"></i>
                                                                        Reporte
                                                                        Caja
                                                                        -
                                                                        para
                                                                        llevar
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.carry_cash_report
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-coins fa-lg"></i>
                                                                        Billetes/Monedas
                                                                        a
                                                                        recibir
                                                                        Caja
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.show_coins_to_receive
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-table fa-lg"></i>
                                                                        Mostrar
                                                                        "Mesa
                                                                        Caja"
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.show_caja_table
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <label class="control-label w-100">
                                                                    <i class="fa fa-file-alt fa-lg"></i>
                                                                    Texto en
                                                                    precuenta
                                                                    <el-tooltip class="item" effect="dark" content="Permite agregar un texto en la precuenta de consumo" placement="top-start">
                                                                        <i class="fa fa-info-circle fa-lg"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.text_comanda
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4 mt-4">
                                                                    <label for="text_1">
                                                                        <i class="fa fa-file-alt fa-lg"></i>
                                                                        Primer
                                                                        texto
                                                                    </label>
                                                                    <el-input :disabled="
                                                                                    !form.text_comanda
                                                                                " class="w-100" v-model="
                                                                                    form.text_one
                                                                                " placeholder="Texto 1" size="normal" @input="
                                                                                    saveSubmitDebounce
                                                                                "></el-input>
                                                                </div>

                                                                <div class="col-md-4 mt-4">
                                                                    <label for="text-2">
                                                                        <i class="fa fa-file-alt fa-lg"></i>
                                                                        Segundo
                                                                        texto
                                                                    </label>
                                                                    <el-input :disabled="
                                                                                    !form.text_comanda
                                                                                " class="w-100" v-model="
                                                                                    form.text_two
                                                                                " placeholder="Texto 2" size="normal" @input="
                                                                                    saveSubmitDebounce
                                                                                "></el-input>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mt-4">
                                                                <label class="control-label w-100">
                                                                    <i class="fa fa-file-alt fa-lg"></i>
                                                                    PDF de
                                                                    precuenta
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.pdf_preorder
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                            <div class="col-md-4 mt-4">
                                                                <label class="control-label w-100">
                                                                    <i class="fa fa-file-alt fa-lg"></i>
                                                                    Imprimir precuenta directo en cocina
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.imprimir_precuenta_comanda
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                            <div class="col-md-4 mt-4">
                                                                <label class="control-label w-100">
                                                                    <i class="fa fa-file-alt fa-lg"></i>
                                                                    Imprimir comanda en cocina sin precuenta
                                                                </label>
                                                                <el-switch v-model="
                                                                                form.imprimir_comanda_cocina
                                                                            " active-text="Si" inactive-text="No" @change="
                                                                                submit
                                                                            "></el-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </el-card>
                                            </el-col>
                                            <!-- Restaurant-Mozo -->
                                            <el-col :span="12">
                                                <el-card shadow="hover">
                                                    <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                                        <i class="fas fa-concierge-bell" style="margin-right: 10px;"></i>
                                                        <span>Mozo</span>
                                                    </div>
                                                    <div>
                                                        Contenido del Mozo.
                                                        <div class="row">
                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-key fa-lg"></i>
                                                                        Ingresar
                                                                        pin
                                                                        mozo
                                                                        (ordenes)
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.pin_switch
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-user fa-lg"></i>
                                                                        Caja-Mozo
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.box_orden
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mt-4">
                                                                <div class="form-group" :class="{
                                                                                'has-danger':
                                                                                    errors.affectation_igv_type_id
                                                                            }">
                                                                    <label class="control-label w-100">
                                                                        <i class="fa fa-search fa-lg"></i>
                                                                        (Módulo
                                                                        de
                                                                        Mozo)
                                                                        Búsqueda
                                                                        de
                                                                        Producto
                                                                        por
                                                                    </label>
                                                                    <el-select v-model="
                                                                                    form.search_type
                                                                                " @change="
                                                                                    submit
                                                                                " filterable>
                                                                        <el-option label="Buscar por Descripción" value="0"></el-option>
                                                                        <el-option label="Buscar por Código interno" value="1"></el-option>
                                                                    </el-select>
                                                                    <small class="text-danger" v-if="
                                                                                    errors.affectation_igv_type_id
                                                                                " v-text="
                                                                                    errors
                                                                                        .affectation_igv_type_id[0]
                                                                                "></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </el-card>
                                            </el-col>
                                            <el-col :span="12">
                                                <el-card shadow="hover">
                                                    <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                                        <i class="fas fa-utensils fa-lg" style="margin-right: 10px;"></i>
                                                        <span>Zona de
                                                            Preparación</span>
                                                    </div>
                                                    <div>
                                                        Contenido de la Zona
                                                        de Preparación.
                                                        <div class="row">
                                                            <div class="col-md-3 mt-4">
                                                                <div class="form-group">
                                                                    <label class="control-label w-100">
                                                                        <i class="fas fa-print fa-lg" style="margin-right: 10px;"></i>
                                                                        Imprimir
                                                                        en
                                                                        Zona
                                                                        Preparación
                                                                    </label>
                                                                    <el-switch v-model="
                                                                                    form.print_kitchen
                                                                                " active-text="Si" inactive-text="No" @change="
                                                                                    submit
                                                                                "></el-switch>
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
                                <el-tab-pane name="Hotel" v-if="form.hotels">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-hotel tab-icon"></i>
                                            <span class="tab-text">
                                                Hotel</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        <!-- Contenido de Hotel -->
                                        <div class="row">
                                            <template v-if="form.hotels">
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-bell fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo de alarma
                                                            de alquileres
                                                            por vencer
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.alarm_to_end
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-tools fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo de
                                                            mantenimiento
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.time_manteniment
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-shield-alt fa-lg" style="margin-right: 10px;"></i>
                                                            Límite de la
                                                            garantía -
                                                            frigobar
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.credit_line_hotel_limit
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-percent fa-lg" style="margin-right: 10px;"></i>
                                                            Descuento
                                                            aplicado por día
                                                            a cambio del
                                                            servicio x
                                                            habitación
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.discount_amount_instead_service
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-sign-out-alt fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo para
                                                            aviso de salida
                                                            de habitación
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.minute_close_to_leave
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-broom fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo para
                                                            limpiar la
                                                            habitación
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.time_to_clean
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-clock fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo para el
                                                            cálculo del
                                                            inicio del día
                                                        </label>
                                                        <el-time-picker style="width: 100%;" value-format="HH:mm:ss" :format="
                                                                        'hh:mm A'
                                                                    " :picker-options="{
                                                                        format:
                                                                            'hh:mm A'
                                                                    }" timezone="America/Lima" v-model="
                                                                        form.time_to_enter
                                                                    "></el-time-picker>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-clock fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo para el
                                                            cálculo del
                                                            final del día
                                                        </label>
                                                        <el-time-picker style="width: 100%;" value-format="HH:mm:ss" :format="
                                                                        'hh:mm A'
                                                                    " :picker-options="{
                                                                        format:
                                                                            'hh:mm A'
                                                                    }" timezone="America/Lima" v-model="
                                                                        form.time_to_leave
                                                                    "></el-time-picker>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-check-circle fa-lg" style="margin-right: 10px;"></i>
                                                            Autorización de
                                                            descuento
                                                        </label>
                                                        <el-switch v-model="
                                                                        form.auth_discount
                                                                    " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-tools fa-lg" style="margin-right: 10px;"></i>
                                                            Tiempo de
                                                            mantenimiento
                                                        </label>
                                                        <el-input-number @change="submit" v-model="
                                                                        form.time_manteniment
                                                                    "></el-input-number>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-wrench fa-lg" style="margin-right: 10px;"></i>
                                                            Control de
                                                            mantenimiento
                                                        </label>
                                                        <el-switch v-model="
                                                                        form.maintenance_workers
                                                                    " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-wrench fa-lg" style="margin-right: 10px;"></i>
                                                            Emitir documento
                                                            con variación
                                                        </label>
                                                        <el-switch v-model="
                                                                        form.variation_hotel
                                                                    " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <template id="select-append">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-boxes fa-lg"></i>
                                                            Producto -
                                                            Variación
                                                        </label>
                                                        <div class="el-input el-input-group el-input-group--append">
                                                            <el-select :disabled="
                                                                            !form.variation_hotel
                                                                        " @focus="
                                                                            $event.target.select()
                                                                        " ref="producto" v-model="
                                                                            form.item_variation_id
                                                                        " @change="
                                                                            changeItem
                                                                        " filterable remote placeholder="Buscar..." popper-class="el-select-items" @visible-change="
                                                                            focusTotalItem
                                                                        " slot="prepend" id="select-width" :remote-method="
                                                                            searchRemoteItems
                                                                        " :loading="
                                                                            loading_search
                                                                        ">
                                                                <el-option v-for="option in items" :key="
                                                                                option.id
                                                                            " :value="
                                                                                option.id
                                                                            " :label="
                                                                                option.full_description ||
                                                                                    option.description
                                                                            "></el-option>
                                                            </el-select>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <!-- Créditos---- -->
                                <el-tab-pane name="Creditos" label="Créditos NV" v-if="form.credits">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-credit-card tab-icon"></i>
                                            <span class="tab-text">
                                                Créditos NV</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        Contenido de Créditos
                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-gavel fa-lg" style="margin-right: 10px;"></i>
                                                        Penalidades
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_penalty
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-check-circle fa-lg" style="margin-right: 10px;"></i>
                                                        Confirmación de
                                                        aprobación
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_confirm
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-money-bill-wave fa-lg" style="margin-right: 10px;"></i>
                                                        Aceptar montos
                                                        menores en las
                                                        cuotas
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_low_pay
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-edit fa-lg" style="margin-right: 10px;"></i>
                                                        Editar Créditos
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_edit
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-whatsapp fa-lg" style="margin-right: 10px;"></i>
                                                        Enviar whatsapp a
                                                        clientes
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_send_whatsapp
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-file-alt fa-lg" style="margin-right: 10px;"></i>
                                                        Mostrar formatos
                                                        adicionales
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.sale_note_credit_formats
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-percent fa-lg" style="margin-right: 10px;"></i>
                                                        % de crédito
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.rates" :precision="2" :step="0.5" :max="100" active-text="Si" inactive-text="No" @change="submit"></el-input-number>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-user-edit fa-lg" style="margin-right: 10px;"></i>
                                                        Whatsapp
                                                        personalizado
                                                        <el-tooltip class="item" effect="dark" content="Usa su propia app de whatsapp" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="
                                                                    form.whatsapp_client
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <!-- Colegio---- -->
                                <el-tab-pane name="Colegio" label="Colegio" v-if="form.college">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-school tab-icon"></i>
                                            <span class="tab-text">
                                                Colegios</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        Contenido de Colegios
                                    </div>
                                </el-tab-pane>

                                <!-- Internet---- -->
                                <el-tab-pane name="Internet" label="Internet" v-if="form.internet">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-wifi tab-icon"></i>
                                            <span class="tab-text">
                                                Internet</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        Contenido de Internet
                                    </div>
                                </el-tab-pane>

                                <!-- Boticas y Farmacias---- -->
                                <el-tab-pane label="Hospital &  Botica" v-if="form.health_network">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="fas fa-pills tab-icon"></i>
                                            <span class="tab-text">
                                                Boticas y Farmacias</span>
                                        </div>
                                    </template>
                                    <div class="nested-tab-content">
                                        Contenido de Boticas y Farmacias

                                        <div class="row">
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        Turno inicio
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>

                                                    <el-select v-model="
                                                                    form.turn_principal
                                                                " @change="submit" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="
                                                                        turn.label
                                                                    " :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        Turno final
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>

                                                    <el-select v-model="
                                                                    form.turn_end
                                                                " @change="submit" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="
                                                                        turn.label
                                                                    " :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        Caja principal
                                                        automatica
                                                        <el-tooltip class="item" effect="dark" content="Caja principal se cierra y abre en base al turno  inicial - final" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>

                                                    <el-switch v-model="
                                                                    form.automatic_principal_cash
                                                                " active-text="Si" inactive-text="No" @change="submit"></el-switch>
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
                                    <el-button type="primary" native-type="submit" @click="deleteDocuments" :loading="loading_submit" class="pro-button">
                                        <i class="fas fa-trash fa-lg"></i>
                                        <span>Eliminar Documentos</span>
                                        <el-tooltip content="Realiza la eliminación de todos los documentos (DEMO Y PRODUCCIÓN)" placement="top">
                                            <span>
                                                <i class="fas fa-exclamation-circle"></i>
                                            </span>
                                        </el-tooltip>
                                    </el-button>
                                </div>
                            </div>

                            <div class="col-md-6 mt-6">
                                <div class="form-group">
                                    <el-button type="primary" native-type="submit" @click="deleteItems" :loading="loading_submit" class="pro-button">
                                        <i class="fas fa-trash fa-lg"></i>
                                        <span>Eliminar Productos</span>
                                        <el-tooltip content="Realiza la eliminación de todos los Productos (DEMO Y PRODUCCIÓN)" placement="top">
                                            <span>
                                                <i class="fas fa-exclamation-circle"></i>
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

        <el-dialog :visible.sync="showAddNumberwhatsapp" @close="showAddNumberwhatsapp = false" title="Agregar número de whatsapp">
            <div class="row mt-2">
                <div class="col-12">
                    <el-input :maxlength="9" v-model="numberWhatsapp">
                    </el-input>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button icon="fas fa-times fa-lg" @click="showAddNumberwhatsapp = false">
                    Cancelar</el-button>
                <el-button icon="fas fa-save fa-lg" type="primary" @click="sendNumberWhatsapp">
                    Agregar</el-button>
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
            activeSubTab: 'tab-1', // Esta es la subpestaña que se activará por defecto

            users_excluded: [],
            user_excluded_id: null,
            turns: [{
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
            detraction_types: [],
            users: [],
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
            days: [{
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
        this.getUsersExcluded();
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

        handleTabClick(tab) {
            if (tab.name === 'Módulos') {
                this.activeSubTab = 'tab-1'; // Cambia a la subpestaña "Mantenimiento" automáticamente
            }
        },
        getUsersExcluded() {
            this.$http
                .get("/configurations/get-users-excluded")
                .then(response => {
                    this.users_excluded = response.data.users;
                });
        },
        addUserExcluded() {
            if (!this.user_excluded_id) {
                return;
            }
            this.$http
                .post("/configurations/add-user-excluded", {
                    user_id: this.user_excluded_id
                })
                .then(response => {
                    if (response.data.success) {
                        this.getUsersExcluded();
                        this.$toast.success(response.data.message);
                        this.user_excluded_id = null;
                    } else {
                        this.$toast.error(response.data.message);
                    }
                });
        },
        removeUserExcluded(user_id) {
            this.$http
                .post("/configurations/remove-user-excluded", {
                    user_id
                })
                .then(response => {
                    if (response.data.success) {
                        this.getUsersExcluded();
                        this.$toast.success(response.data.message);
                    } else {
                        this.$toast.error(response.data.message);
                    }
                });
        },
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
            let {
                number
            } = this.numbers[idx];
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
                let {
                    message
                } = e.response.data;
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
                this.detraction_types = response.data.detraction_types;
                this.items = response.data.items;
                this.users = response.data.users;
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
            this.user_excluded_id = null;
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
