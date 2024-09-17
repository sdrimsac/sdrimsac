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
                                    <!-- Contenido filtrado -->
                                    <div class="nested-tab-content" ref="modesTab">
                                        <div class="container mt-4">
                                            <div class="row">
                                                <!-- Créditos en Nota de Venta y otros elementos -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="creditIcon" class="fas fa-credit-card tab-icon"></i>
                                                            Crédito en Nota de Venta
                                                        </label>
                                                        <el-switch v-model="form.credits" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Crédito en Nota de Venta', form.credits, 'creditIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Colegio -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="collegeIcon" class="fas fa-school tab-icon"></i>
                                                            Entorno Colegio
                                                        </label>
                                                        <el-switch v-model="form.college" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Colegio', form.college, 'collegeIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Restaurant -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="restaurantIcon" class="fas fa-utensils tab-icon"></i>
                                                            Entorno Restaurant
                                                        </label>
                                                        <el-switch v-model="form.restaurant" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Restaurant', form.restaurant, 'restaurantIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Hotel -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="hotelIcon" class="fas fa-hotel tab-icon"></i>
                                                            Entorno Hotel
                                                        </label>
                                                        <el-switch v-model="form.hotels" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Hotel', form.hotels, 'hotelIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Internet -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="internetIcon" class="fas fa-wifi tab-icon"></i>
                                                            Entorno Internet
                                                        </label>
                                                        <el-switch v-model="form.internet" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Internet', form.internet, 'internetIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Peaje -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="tollIcon" class="el-icon-tickets tab-icon"></i>
                                                            Entorno Peaje
                                                        </label>
                                                        <el-switch v-model="form.toll" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Peaje', form.toll, 'tollIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Entorno Boticas & Hospital -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="healthIcon" class="fas fa-pills tab-icon"></i>
                                                            Entorno Boticas & Hospital
                                                        </label>
                                                        <el-switch v-model="form.health_network" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno Boticas & Hospital', form.health_network, 'healthIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="healthIcon" class="el-icon-baseball tab-icon"></i>
                                                            Entorno Billar
                                                        </label>
                                                        <el-switch v-model="form.modo_billar" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Entorno billar', form.modo_billar, 'healthIcon')"></el-switch>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>

                                <!-- Modelo de Negocio -->
                                <el-tab-pane name="complementos">
                                    <template #label>
                                        <div class="tab-label">
                                            <i class="el-icon-setting tab-icon fa-lg"></i>
                                            <span class="tab-text">Modelo de Negocio</span>
                                        </div>
                                    </template>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Habilitar Contabilidad -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="accountingIcon" class="fas fa-calculator tab-icon"></i> Habilitar Contabilidad
                                                        </label>
                                                        <el-switch v-model="form.accounting_mode" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Contabilidad', form.accounting_mode, 'accountingIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Manejo de Series -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="seriesIcon" class="fas fa-barcode tab-icon"></i> Habilitar Manejo de Series
                                                        </label>
                                                        <el-switch v-model="form.series_enabled" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Series - Productos', form.series_enabled, 'seriesIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Manejo de Lotes -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="lotsIcon" class="fas fa-boxes tab-icon"></i> Habilitar Manejo de Lotes
                                                        </label>
                                                        <el-switch v-model="form.lots_enabled" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Lotes - Productos', form.lots_enabled, 'lotsIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Manejo de Color & Talla -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="colorSizeIcon" class="fas fa-tshirt tab-icon"></i> <i class="fas fa-palette"></i> Habilitar Manejo de Color & Talla
                                                        </label>
                                                        <el-switch v-model="form.color_size_enabled" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Color & Talla - Productos', form.color_size_enabled, 'colorSizeIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Manejo de Guías de Remisión -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="dispatchIcon" class="fas fa-truck tab-icon"></i> Habilitar Manejo de Guías de Remisión
                                                        </label>
                                                        <el-switch v-model="form.dispatch" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Guías de Remisión', form.dispatch, 'dispatchIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Manejo de Cotización -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="quotationIcon" class="fas fa-file-invoice-dollar tab-icon"></i> Habilitar Manejo de Cotización
                                                        </label>
                                                        <el-switch v-model="form.quotation" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Cotización', form.quotation, 'quotationIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Transformación de producto -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="transformIcon" class="fas fa-exchange-alt tab-icon"></i> Habilitar Transformación de producto
                                                        </label>
                                                        <el-switch v-model="form.transform_item" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Transformación de producto', form.transform_item, 'transformIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Tratamiento comercial Producto -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="commercialTreatmentIcon" class="fas fa-hand-holding-usd tab-icon"></i> Habilitar Tratamiento Comercial
                                                            <el-tooltip class="item" effect="dark" content="Trato comercial" placement="top-start">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.commercial_treatment_items" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Tratamiento comercial Producto', form.commercial_treatment_items, 'commercialTreatmentIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Habilitar Consignación -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="consignmentIcon" class="fas fa-handshake tab-icon"></i> Habilitar Consignación
                                                            <el-tooltip content="Crear y liquidar consignaciones desde caja">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.consignment" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Consignación', form.consignment, 'consignmentIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <!-- Producto penalidad - Consignación -->
                                                <div class="col-md-3 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="penaltyProductIcon" class="fas fa-exclamation-circle tab-icon"></i> Producto Penalidad - Consignación
                                                        </label>
                                                        <div class="el-input el-input-group el-input-group--append">
                                                            <el-select :disabled="!form.consignment" @focus="$event.target.select()" ref="producto" v-model="form.item_consignment_id" @change="changeItem" filterable remote placeholder="Buscar..." popper-class="el-select-items" @visible-change="focusTotalItem" :remote-method="searchRemoteItems" :loading="loading_search">
                                                                <el-option v-for="option in items" :key="option.id" :value="option.id" :label="option.full_description || option.description"></el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Habilitar Promociones -->
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="promotionsIcon" class="fas fa-tags tab-icon"></i> Habilitar Promociones
                                                            <el-tooltip class="item" effect="dark" content="Visualiza en CAJA y ADMINISTRADOR la función que permite acceder a una promoción, llegando a x items vendidos" placement="top-start">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.promotions_sell" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Promociones', form.promotions_sell, 'promotionsIcon')"></el-switch>
                                                        <el-input v-model="form.promotions_cant_purchase" :disabled="!form.promotions_sell" placeholder="Cantidad de ventas para acceder a la promoción" size="normal" class="mt-2" @blur="submit('Cantidad de ventas para promoción', form.promotions_cant_purchase, 'promotionsIcon')"></el-input>
                                                    </div>
                                                </div>
                                                    <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i ref="promotionsIcon" class="fas fa-tags tab-icon"></i> Habilitar Promociones Documento
                                                            <el-tooltip class="item" effect="dark" content="Por cada cierto total de compra el cliente adquiere un producto gratis" placement="top-start">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.is_promotion_document" active-text="HABILITADO" inactive-text="DESHABILITADO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="() => submit('Habilitar Promociones Documento', form.is_promotion_document, 'promotionsIcon')"></el-switch>
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

                                    <div class="nested-tab-content" ref="accountingTab">
                                        <div class="container mt-4">
                                            <div class="row">
                                                <!-- Cambiar Afectación IGV (CAJA) -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            <i class="fas fa-exchange-alt tab-icon"></i>
                                                            Cambiar Afectación IGV (CAJA)
                                                            <el-tooltip content="Permite cambiar la afectación de IGV en caja">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.affectation_optional" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Cambiar Afectación IGV (CAJA)', form.affectation_optional, 'affectation_optional', 'exchangeIcon')">
                                                        </el-switch>
                                                    </div>
                                                </div>

                                                <!-- Cantidad decimales POS -->
                                                <div class="col-md-2 mt-4" v-if="typeUser != 'integrator'">
                                                    <label class="control-label">
                                                        <i class="fas fa-sort-numeric-up tab-icon"></i>
                                                        Cantidad decimales POS
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.decimal_quantity}">
                                                        <el-input-number v-model="form.decimal_quantity" @change="submit('Cantidad decimales POS', true, 'decimal_quantity', 'numericIcon')" :min="2" :max="10">
                                                        </el-input-number>
                                                        <small class="text-success" v-if="!errors.decimal_quantity">ACTUALIZADO</small>
                                                        <small class="text-danger" v-if="errors.decimal_quantity" v-text="errors.decimal_quantity[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Impuesto bolsa plástica -->
                                                <div class="col-md-2 mt-4" v-if="typeUser != 'integrator'">
                                                    <label class="control-label">
                                                        <i class="fas fa-recycle tab-icon"></i>
                                                        Impuesto bolsa plástica
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.amount_plastic_bag_taxes}">
                                                        <el-input-number v-model="form.amount_plastic_bag_taxes" @change="submit('Impuesto bolsa plástica', true, 'amount_plastic_bag_taxes', 'recycleIcon')" :precision="2" :step="0.1" :max="0.5" :min="0.1">
                                                        </el-input-number>
                                                        <small class="text-success" v-if="!errors.amount_plastic_bag_taxes">ACTUALIZADO</small>
                                                        <small class="text-danger" v-if="errors.amount_plastic_bag_taxes" v-text="errors.amount_plastic_bag_taxes[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Tipo de afectación Venta -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group" :class="{'has-danger': errors.affectation_igv_type_id}">
                                                        <label class="control-label">
                                                            <i class="fas fa-file-invoice-dollar tab-icon"></i>
                                                            Tipo de afectación Venta
                                                            <el-tooltip content="Tipo de afectación predeterminada al registrar nuevo producto">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-select v-model="form.affectation_igv_type_id" @change="submit('Tipo de afectación Venta', true, 'affectation_igv_type_id', 'invoiceIcon')" filterable>
                                                            <el-option v-for="option in affectation_igv_types" :key="option.id" :value="option.id" :label="option.description">
                                                            </el-option>
                                                        </el-select>
                                                        <small class="text-success" v-if="!errors.affectation_igv_type_id">ACTUALIZADO</small>
                                                        <small class="text-danger" v-if="errors.affectation_igv_type_id" v-text="errors.affectation_igv_type_id[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Envío de comprobantes automático -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-paper-plane tab-icon"></i>
                                                        Envío de comprobantes automático
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.send_auto}">
                                                        <el-switch v-model="form.send_auto" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Envío de comprobantes automático', form.send_auto, 'send_auto', 'planeIcon')">
                                                        </el-switch>
                                                        <small class="text-danger" v-if="errors.send_auto" v-text="errors.send_auto[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Ejecutar Tareas Programadas -->
                                                <div class="col-md-2 mt-4" v-if="typeUser != 'integrator'">
                                                    <label class="control-label">
                                                        <i class="fas fa-calendar-alt tab-icon"></i>
                                                        Ejecutar Tareas Programadas
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.cron}">
                                                        <el-switch v-model="form.cron" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ejecutar Tareas Programadas', form.cron, 'cron', 'calendarIcon')">
                                                        </el-switch>
                                                        <small class="text-danger" v-if="errors.cron" v-text="errors.cron[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Cambiar fecha de emisión -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-calendar-check tab-icon"></i>
                                                        Cambiar fecha de emisión
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.change_date_emit}">
                                                        <el-switch v-model="form.change_date_emit" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Cambiar fecha de emisión', form.change_date_emit, 'change_date_emit', 'dateIcon')">
                                                        </el-switch>
                                                        <small class="text-danger" v-if="errors.change_date_emit" v-text="errors.change_date_emit[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Restringir fecha de comprobante -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-ban tab-icon"></i>
                                                        Restringir fecha de comprobante
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.restrict_receipt_date}">
                                                        <el-switch v-model="form.restrict_receipt_date" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Restringir fecha de comprobante', form.restrict_receipt_date, 'restrict_receipt_date', 'banIcon')">
                                                        </el-switch>
                                                        <small class="text-danger" v-if="errors.restrict_receipt_date" v-text="errors.restrict_receipt_date[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Días transcurridos para emitir dcto -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-calendar-day tab-icon"></i>
                                                        Días transcurridos para emitir dcto
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.days_before_emit}">
                                                        <el-select v-model="form.days_before_emit" @change="submit('Días transcurridos para emitir dcto', true, 'days_before_emit', 'dayIcon')">
                                                            <el-option v-for="day in days" :key="`${day.id}-d`" :value="day.value" :label="`${day.value} ${day.value > 1 ? 'días' : 'día'}`">
                                                            </el-option>
                                                        </el-select>
                                                        <small class="text-success" v-if="!errors.days_before_emit">ACTUALIZADO</small>
                                                        <small class="text-danger" v-if="errors.days_before_emit" v-text="errors.days_before_emit[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Impuesto incluido en registro de productos -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-receipt tab-icon"></i>
                                                        Impuesto incluido en registro de productos
                                                    </label>
                                                    <div class="form-group" :class="{'has-danger': errors.include_igv}">
                                                        <el-switch v-model="form.include_igv" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Impuesto incluido en registro de productos', form.include_igv, 'include_igv', 'receiptIcon')">
                                                        </el-switch>
                                                        <small class="text-danger" v-if="errors.include_igv" v-text="errors.include_igv[0]"></small>
                                                    </div>
                                                </div>

                                                <!-- Recrear Documento -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-sync-alt tab-icon"></i>
                                                        Recrear Documento
                                                    </label>
                                                    <div class="form-group">
                                                        <el-switch v-model="form.recreat_document" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Recrear Documento', form.recreat_document, 'recreat_document', 'syncAltIcon')">
                                                        </el-switch>
                                                    </div>
                                                </div>

                                                <!-- Eliminar Documento -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-trash-alt tab-icon"></i>
                                                        Eliminar Documento
                                                    </label>
                                                    <div class="form-group">
                                                        <el-switch v-model="form.delete_document" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Eliminar Documento', form.delete_document, 'delete_document', 'trashAltIcon')">
                                                        </el-switch>
                                                    </div>
                                                </div>

                                                <!-- Detracciones -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-percentage tab-icon"></i>
                                                            Detracciones
                                                        </label>
                                                        <el-switch v-model="form.detraction" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Detracciones', form.detraction, 'detraction', 'percentageIcon')">
                                                        </el-switch>
                                                    </div>
                                                </div>

                                                <!-- Detracción por defecto -->
                                                <div class="col-md-2 mt-4">
                                                    <label class="control-label">
                                                        <i class="fas fa-piggy-bank tab-icon"></i>
                                                        Detracción por defecto
                                                        <el-tooltip content="Se elegirá la detracción por defecto al momento de crear un comprobante de venta">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <div class="form-group">
                                                        <el-select v-model="form.detraction_type_id" @change="submit('Detracción por defecto', form.detraction_type_id, 'detraction_type_id', 'piggyBankIcon')" filterable clearable>
                                                            <el-option v-for="option in detraction_types" :key="option.id" :value="option.id" :label="`${option.percentage}% ${option.description}`">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                </div>

                                                <!-- Descuentos variante -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-percentage tab-icon"></i>
                                                            Descuentos variante
                                                            <el-tooltip content="Permite recalcular el precio de venta de un producto con descuento a la base imponible">
                                                                <i class="fa fa-info-circle"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.discount_with_base_variant" active-text="SI" inactive-text="NO" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Descuentos variante', form.discount_with_base_variant, 'discount_with_base_variant', 'percentageIcon')">
                                                        </el-switch>
                                                    </div>
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
                                        <div class="container mt-8">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Busqueda de Contenido
                                                </label>
                                                <el-input v-model="searchQueryVisual" placeholder="Ingrese contenido a Buscar..." style="width: 240px" maxlength="50" show-word-limit type="text"></el-input>
                                            </div>
                                            <div class="nested-tab-content" ref="visualTab">
                                                <!-- Seccion Gestión Adicionales -->
                                                <div slot="header" class="card-header bg-primary text-white">
                                                    <i class="fas fa-file-alt fa-lg"></i>
                                                    Gestiones Adicionales
                                                </div>
                                                <!-- Sección Gestiones Adicionales -->
                                                <div class="section-content">
                                                    <div class="row">
                                                        <!-- Habilita Usuarios (Admin) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-users-cog tab-icon"></i>
                                                                    Habilitar Usuarios (Admin)
                                                                    <el-tooltip content="Visualiza Usuarios en Administrador">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.users_views" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Habilita Usuarios (Admin)', form.users_views, 'users_views', 'usersCogIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Permitir anulado interno -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-ban tab-icon"></i>
                                                                    Permitir anulado interno
                                                                    <el-tooltip class="item" effect="dark" content=" CAJA Y ADMIN" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.internal_voided" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Permitir anulado interno', form.internal_voided, 'internal_voided', 'banIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sección Gestión de Caja -->
                                                <div slot="header" class="card-header bg-primary text-white">
                                                    <i class="fas fa-cash-register fa-lg"></i>
                                                    Gestión de Caja
                                                </div>
                                                <div class="section-content">
                                                    <div class="row">
                                                        <!-- Multiples Caja (Usuario Cajero) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-cash-register fa-lg"></i> Multiples Cajas
                                                                    <el-tooltip class="item" effect="dark" content="Multiples Cajas, para usuario CAJERO" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.multiple_boxes" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Multiples Cajas', form.multiple_boxes, 'multiple_boxes', 'cashRegisterIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Usuarios con series independientes -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-user-cog tab-icon"></i>
                                                                    Usuarios con series independientes
                                                                    <el-tooltip content="Permite asignar una serie a un usuario">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.user_series_independientes_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Usuarios con series independientes', form.user_series_independientes_caja, 'user_series_independientes_caja', 'userCogIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Acciones en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-tasks fa-lg"></i> Acciones en Caja
                                                                    <el-tooltip class="item" effect="dark" content="Acciones en CAJA, como anulación de comprobantes, pagos, nota de crédito" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.caja_actions" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Acciones en Caja', form.caja_actions, 'caja_actions', 'tasksIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Venta Rapida (Modulo Caja) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-bolt fa-lg"></i> Venta Rápida
                                                                    <el-tooltip class="item" effect="dark" content="Venta Rápida módulo de CAJA (Activar en Establecimientos)" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.sales_quick" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Venta Rápida', form.sales_quick, 'sales_quick', 'boltIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Vendedores en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-user-tie fa-lg"></i> Vendedores en Caja
                                                                    <el-tooltip class="item" effect="dark" content="Activa selección de Vendedores en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.seller_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Vendedores en Caja', form.seller_caja, 'seller_caja', 'userTieIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar gastos / ingresos en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-eye fa-lg"></i> Mostrar Gastos e Ingresos
                                                                    <el-tooltip class="item" effect="dark" content="Mostrar Modal de Gastos e Ingresos en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.show_expenses_incomes_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Gastos e Ingresos', form.show_expenses_incomes_caja, 'show_expenses_incomes_caja', 'eyeIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Editar Precio Venta en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-edit fa-lg"></i> Editar Precio de Venta
                                                                    <el-tooltip class="item" effect="dark" content="Editar Precio de venta en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.edit_price_sales" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Precio de Venta', form.edit_price_sales, 'edit_price_sales', 'editIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.edit_price_sales" v-text="errors.edit_price_sales[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Editar Cantidad en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-calculator fa-lg"></i> Editar Cantidad
                                                                    <el-tooltip class="item" effect="dark" content="Editar Cantidad de venta en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.quantity_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Cantidad', form.quantity_cash, 'quantity_cash', 'calculatorIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.quantity_cash" v-text="errors.quantity_cash[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Editar subtotal en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-pencil-alt fa-lg"></i> Editar Subtotal
                                                                    <el-tooltip class="item" effect="dark" content="Editar Subtotal de venta en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.edit_subtotal_box" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Subtotal', form.edit_subtotal_box, 'edit_subtotal_box', 'pencilAltIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Todos los productos - caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-list fa-lg"></i> Todos los productos - caja
                                                                </label>
                                                                <el-switch v-model="form.all_items_pos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Todos los productos - caja', form.all_items_pos, 'all_items_pos', 'listIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Editar nombre de productos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-edit fa-lg"></i> Editar nombre de productos
                                                                </label>
                                                                <el-switch v-model="form.edit_name_product" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar nombre de productos', form.edit_name_product, 'edit_name_product', 'editIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.edit_name_product" v-text="errors.edit_name_product[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar lista o tarjeta de productos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-th-list fa-lg"></i> Mostrar lista o tarjeta de productos
                                                                </label>
                                                                <el-switch v-model="form.list_or_card" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar lista o tarjeta de productos', form.list_or_card, 'list_or_card', 'thListIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.list_or_card" v-text="errors.list_or_card[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Lote en lista de productos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-boxes fa-lg"></i> Lote en lista de productos
                                                                </label>
                                                                <el-switch v-model="form.lotgroup_list_or_card" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Lote en lista de productos', form.lotgroup_list_or_card, 'lotgroup_list_or_card', 'boxesIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.lotgroup_list_or_card" v-text="errors.lotgroup_list_or_card[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Política de precio en lista de productos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-tag fa-lg"></i> Política de precio en lista de productos
                                                                </label>
                                                                <el-switch v-model="form.listprice_list_or_card" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Política de precio en lista de productos', form.listprice_list_or_card, 'listprice_list_or_card', 'tagIcon')"></el-switch>
                                                                <small class="text-danger" v-if="errors.listprice_list_or_card" v-text="errors.listprice_list_or_card[0]"></small>
                                                            </div>
                                                        </div>

                                                        <!-- Barcode en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-barcode fa-lg"></i> Barcode en Caja
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.barcode" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Barcode en Caja', form.barcode, 'barcode', 'barcodeIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Una caja por establecimiento -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-store-alt fa-lg"></i> Una caja por establecimiento
                                                                    <el-tooltip class="item" effect="dark" content="Solo se podrá tener una caja activa por establecimiento" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.only_cash_by_establishment" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Una caja por establecimiento', form.only_cash_by_establishment, 'only_cash_by_establishment', 'storeAltIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Usuarios excluidos -->
                                                        <div class="col-md-2 mt-4">
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
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-file-alt fa-lg"></i> Detalle métodos - reporte
                                                                    <el-tooltip class="item" effect="dark" content="Mostrar detalle método de pago (no efectivo) en reporte" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.report_cash_methods" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Detalle métodos - reporte', form.report_cash_methods, 'report_cash_methods', 'fileAltIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                        <!-- Ver venta diaria -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-chart-line tab-icon"></i>
                                                                    Ver venta diaria
                                                                </label>
                                                                <el-switch v-model="form.view_daily_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ver venta diaria', form.view_daily_cash, 'view_daily_cash', 'chartLineIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Ver venta diaria con pin -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-lock tab-icon"></i>
                                                                    Ver venta diaria con pin
                                                                </label>
                                                                <el-switch v-model="form.view_daily_cash_pin" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ver venta diaria con pin', form.view_daily_cash_pin, 'view_daily_cash_pin', 'lockIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="el-icon-s-grid icon-tab"></i>
                                                                    Historial Compra Venta En Caja
                                                                </label>
                                                                <el-switch v-model="form.compra_venta" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Activar historial compra venta', form.compra_venta, 'view_daily_cash_pin', 'lockIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="el-icon-s-grid icon-tab"></i>
                                                                   Permitir Editar Politica De Precio En Caja
                                                                </label>
                                                                <el-switch v-model="form.editar_precio_politica" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Politica de Precios En Caja', form.editar_precio_politica, 'view_daily_cash_pin', 'lockIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div slot="header" class="card-header bg-primary text-white">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    Gestión de WhatsApp
                                                </div>
                                                <div class="section-content">
                                                    <!-- Contenido de Gestion de WhatsApp-->
                                                    <div class="row">
                                                        <!-- Enviar whatsapp por pagos YAPE/PLIN -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-mobile-alt fa-lg"></i> Enviar whatsapp por pagos YAPE/PLIN
                                                                </label>
                                                                <el-switch v-model="form.send_whatsapp_digital_pay" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Enviar whatsapp por pagos YAPE/PLIN', form.send_whatsapp_digital_pay, 'send_whatsapp_digital_pay', 'mobileAltIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Usar número personal (whatsapp) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-phone tab-icon"></i>
                                                                    Usar número personal (whatsapp)
                                                                </label>
                                                                <el-switch v-model="form.personal_phone" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Usar número personal (whatsapp)', form.personal_phone, 'personal_phone', 'phoneIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Enviar whatsapp al ver venta diaria -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-paper-plane tab-icon"></i>
                                                                    Enviar whatsapp al ver venta diaria
                                                                </label>
                                                                <el-switch v-model="form.send_whatsapp_daily_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Enviar whatsapp al ver venta diaria', form.send_whatsapp_daily_cash, 'send_whatsapp_daily_cash', 'paperPlaneIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Enviar XML por whatsapp -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-file-export tab-icon"></i>
                                                                    Enviar XML por whatsapp
                                                                </label>
                                                                <el-switch v-model="form.xml_whatsapp" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Enviar XML por whatsapp', form.xml_whatsapp, 'xml_whatsapp', 'fileExportIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Números de whatsapp para enviar actividad -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-phone tab-icon"></i>
                                                                    Números de whatsapp para enviar actividad
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

                                                        <!-- Whatsapp en Reimpresión de Documentos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-mobile-alt fa-lg"></i> Whatsapp en Reimpresión de Documentos
                                                                </label>
                                                                <el-switch v-model="form.reprint_whatsapp" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Whatsapp en Reimpresión de Documentos', form.reprint_whatsapp, 'reprint_whatsapp', 'mobileAltIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sección Gestión de Productos -->
                                                <div slot="header" class="card-header bg-primary text-white">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    Gestión de Productos
                                                </div>
                                                <div class="section-content">
                                                    <!-- Contenido de Gestion de Productos-->
                                                    <div class="row">
                                                        <!-- Crear Productos en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-box fa-lg"></i> Crear Productos en caja
                                                                </label>
                                                                <el-switch v-model="form.product_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Crear Productos en caja', form.product_cash, 'product_cash', 'boxIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Editar Producto en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-pencil-ruler fa-lg"></i> Editar Producto en caja
                                                                </label>
                                                                <el-switch v-model="form.edit_product_pos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Producto en caja', form.edit_product_pos, 'edit_product_pos', 'pencilRulerIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar descripción Completa del producto en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-align-left fa-lg"></i> Descripción Full del producto en Caja
                                                                </label>
                                                                <el-switch v-model="form.trunc_txt" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar descripción Completa del producto en Caja', form.trunc_txt, 'trunc_txt', 'alignLeftIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Stock de Productos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-eye fa-lg"></i> Mostrar Stock de Productos
                                                                </label>
                                                                <el-switch v-model="form.show_stock_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Stock de Productos', form.show_stock_cash, 'show_stock_cash', 'eyeIcon'); stock_control();">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar productos por vencer en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-hourglass-half fa-lg"></i> Mostrar productos por vencer en caja
                                                                </label>
                                                                <el-switch v-model="form.items_due_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar productos por vencer en caja', form.items_due_caja, 'items_due_caja', 'hourglassHalfIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Nombre secundario - Código externo -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-tags tab-icon"></i>
                                                                    Mostrar Nombre secundario - Código externo
                                                                    <el-tooltip content="Mostrar Nombre secundario - Código externo en el formulario de productos">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.show_second_name_external_code" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Nombre secundario - Código externo', form.show_second_name_external_code, 'show_second_name_external_code', 'tagsIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                        <!-- Recibir Productos (traslado) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-dolly fa-lg"></i> Recibir Productos (traslado)
                                                                    <el-tooltip class="item" effect="dark" content="Recibir Productos por TRASLADO DE MERCADERÍA en CAJA" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.receive_merchandise" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Recibir Productos (traslado)', form.receive_merchandise, 'receive_merchandise', 'dollyIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Bloquear stock inicial -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-lock fa-lg"></i> Bloquear stock inicial
                                                                </label>
                                                                <el-switch v-model="form.init_stock" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Bloquear stock inicial', form.init_stock, 'init_stock', 'lockIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Permitir Ajuste de Stock -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-tools fa-lg"></i> Permitir Ajuste de Stock
                                                                </label>
                                                                <el-switch v-model="form.item_adjustment" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Permitir Ajuste de Stock', form.item_adjustment, 'item_adjustment', 'toolsIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Vender con stock -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-boxes tab-icon"></i>
                                                                    Vender con stock
                                                                </label>
                                                                <el-switch v-model="form.sales_stock" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Vender con stock', form.sales_stock, 'sales_stock', 'boxesIcon'); stock_control();"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Observación al hacer ajuste de stock -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-edit tab-icon"></i>
                                                                    Observación al hacer ajuste de stock
                                                                    <el-tooltip content="Obligar a dar razón del traslado">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.observation_translate" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Observación al hacer ajuste de stock', form.observation_translate, 'observation_translate', 'editIcon')"></el-switch>
                                                            </div>
                                                        </div>
                                                        <!-- Crear Productos Compuestos en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-cubes fa-lg"></i> Crear Productos Compuestos en caja
                                                                </label>
                                                                <el-switch v-model="form.item_set_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Crear Productos Compuestos en caja', form.item_set_caja, 'item_set_caja', 'cubesIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Editar Productos Compuestos en caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-box-open fa-lg"></i> Editar Productos Compuestos en caja
                                                                </label>
                                                                <el-switch v-model="form.item_set_quantity_pos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Productos Compuestos en caja', form.item_set_quantity_pos, 'item_set_quantity_pos', 'boxOpenIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Imagenes de Productos en Cotización -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-image fa-lg"></i> Mostrar Imagenes de Productos en Cotización
                                                                </label>
                                                                <el-switch v-model="form.image_quotation" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Imagenes de Productos en Cotización', form.image_quotation, 'image_quotation', 'imageIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Ordenar Productos por Descripción en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-sort-alpha-down fa-lg"></i> Ordenar Productos por Descripción
                                                                </label>
                                                                <el-switch v-model="form.ord_dscp" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ordenar Productos por Descripción en Caja', form.ord_dscp, 'ord_dscp', 'sortAlphaDownIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Buscar por series en Caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-search fa-lg"></i> Buscar Producto por Series
                                                                </label>
                                                                <el-switch v-model="form.search_series_pos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Buscar por series en Caja', form.search_series_pos, 'search_series_pos', 'searchIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Stock Almacénes -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-warehouse fa-lg"></i> Mostrar Stock Almacénes
                                                                </label>
                                                                <el-switch v-model="form.show_stock_establishment_box" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Stock Almacénes', form.show_stock_establishment_box, 'show_stock_establishment_box', 'warehouseIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Traslados directos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-exchange-alt fa-lg"></i> Traslados directos
                                                                </label>
                                                                <el-switch v-model="form.translate_direct" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Traslados directos', form.translate_direct, 'translate_direct', 'exchangeAltIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Visualizar administrador - usuarios -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-user-cog fa-lg"></i> Visualizar administrador - usuarios
                                                                </label>
                                                                <el-switch v-model="form.users_views" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Visualizar administrador - usuarios', form.users_views, 'users_views', 'userCogIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Tratamiento comercial Categoría -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-handshake fa-lg"></i> Tratamiento comercial Categoría
                                                                </label>
                                                                <el-switch v-model="form.commercial_treatments" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Tratamiento comercial Categoría', form.commercial_treatments, 'commercial_treatments', 'handshakeIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Tratamiento comercial Producto -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-handshake fa-lg"></i> Tratamiento comercial Producto
                                                                </label>
                                                                <el-switch v-model="form.commercial_treatment_items" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Tratamiento comercial Producto', form.commercial_treatment_items, 'commercial_treatment_items', 'handshakeIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Servicio en todos los establecimientos -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-warehouse fa-lg"></i> Servicio en todos los establecimientos
                                                                </label>
                                                                <el-switch v-model="form.create_service_all_warehouse" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Servicio en todos los establecimientos', form.create_service_all_warehouse, 'create_service_all_warehouse', 'warehouseIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Caja principal automatica -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-cash-register fa-lg"></i> Caja principal automática
                                                                </label>
                                                                <el-switch v-model="form.automatic_principal_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Caja principal automática', form.automatic_principal_cash, 'automatic_principal_cash', 'cashRegisterIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Reporte caja - para llevar -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-file-alt fa-lg"></i> Reporte caja - para llevar
                                                                </label>
                                                                <el-switch v-model="form.carry_cash_report" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte caja - para llevar', form.carry_cash_report, 'carry_cash_report', 'fileAltIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Billetes/Monedas a recibir caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-coins fa-lg"></i> Billetes/Monedas a recibir caja
                                                                </label>
                                                                <el-switch v-model="form.show_coins_to_receive" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Billetes/Monedas a recibir caja', form.show_coins_to_receive, 'show_coins_to_receive', 'coinsIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Buscar por segundo nombre -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-id-card fa-lg"></i> Buscar por segundo nombre
                                                                </label>
                                                                <el-switch v-model="form.search_by_second_name" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Buscar por segundo nombre', form.search_by_second_name, 'search_by_second_name', 'idCardIcon')">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Sección Gestión de Pagos -->

                                                <div slot="header" class="card-header bg-primary text-white">
                                                    <i class="fas fa-box fa-lg"></i>
                                                    Gestión de Pagos
                                                </div>
                                                <!-- Sección Gestion de Metodos de Pago visual-->
                                                <div class="section-content">
                                                    <div class="row">
                                                        <!-- Mostrar culqui en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/CulquiIcon.png" alt="Culqui Logo" class="payment-logo" />
                                                                    Culqui
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.culqi" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Culqui', form.culqi, '/images/CulquiIcon.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar yape en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/yape-logo-3E473EE7E5-seeklogo.com.png" alt="Yape Logo" class="payment-logo" />
                                                                    Yape
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.yape" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Yape', form.yape, '/images/yape-logo-3E473EE7E5-seeklogo.com.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar izipay en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonIzipay.png" alt="Izipay Logo" class="payment-logo" />
                                                                    Izipay
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.izipay" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Izipay', form.izipay, '/images/botonIzipay.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar openpay en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonOpenpay.png" alt="Openpay Logo" class="payment-logo" />
                                                                    Openpay
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.openpay" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Openpay', form.openpay, '/images/botonOpenpay.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar nubiz en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonNiubiz.png" alt="Niubiz Logo" class="payment-logo" />
                                                                    Nubiz
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.nubiz" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Nubiz', form.nubiz, '/images/botonNiubiz.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar plin en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/plin-logo-0C4106153C-seeklogo.com.png" alt="Plin Logo" class="payment-logo" />
                                                                    Plin
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.plin" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Plin', form.plin, '/images/plin-logo-0C4106153C-seeklogo.com.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Rappi en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonRappi.png" alt="Rappi Logo" class="payment-logo" />
                                                                    Rappi
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.rappi" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Rappi', form.rappi, '/images/botonRappi.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Pedidos-Ya en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonPedidosYa.png" alt="Pedidos-Ya Logo" class="payment-logo" />
                                                                    Pedidos-Ya
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.pedidosya" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Pedidos-Ya', form.pedidosya, '/images/botonPedidosYa.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Mostrar Didi-Foods en Métodos de Pago caja -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <img src="/images/botonDidi.png" alt="Didi-Foods Logo" class="payment-logo" />
                                                                    Didi-Foods
                                                                    <el-tooltip class="item" effect="dark" content="Método de pago en caja" placement="top-start">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.didi" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Didi-Foods', form.didi, '/images/botonDidi.png', 'walletIcon', true)">
                                                                </el-switch>
                                                            </div>
                                                        </div>
                                                        <!-- Requerir número de operación (YAPE/PLIN/TARJETAS) -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-receipt tab-icon"></i>
                                                                    Solicitar Número de Operación
                                                                    <el-tooltip content="YAPE/PLIN/TARJETAS, Obligatorio para emitir comprobante de pago">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </el-tooltip>
                                                                </label>
                                                                <el-switch v-model="form.require_code" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Requerir número de operación (YAPE/PLIN/TARJETAS)', form.require_code, 'require_code', 'receiptIcon')"></el-switch>
                                                            </div>
                                                        </div>

                                                        <!-- Cargo por pago con tarjeta -->
                                                        <div class="col-md-2 mt-4">
                                                            <div class="form-group">
                                                                <label class="control-label w-100">
                                                                    <i class="fas fa-credit-card tab-icon"></i>
                                                                    Cargo por pago con tarjeta
                                                                </label>
                                                                <el-switch v-model="form.credit_mode" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Cargo por pago con tarjeta', form.credit_mode, 'credit_mode', 'creditCardIcon')"></el-switch>
                                                            </div>
                                                        </div>
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
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresoras Nuevas
                                                    <el-tooltip class="item" effect="dark" content="Permite configurar si las impresoras que se usan para la impresión directa en A5/A4 son nuevas o antiguas" placement="top-start">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-switch v-model="form.new_old_printer" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Impresoras Nuevas', form.new_old_printer, 'new_old_printer', 'printIcon')"></el-switch>
                                            </div>
                                        </div>
                                        <!-- alias -->
                                            <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Alias en documentos
                                                    <el-tooltip class="item" effect="dark" content="Agrega el alias del cliente en los documentos pdf" placement="top-start">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-switch v-model="form.alias_pdf" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Alias en pdf', form.alias_pdf, 'alias_pdf', 'printIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Orientación A5 -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-arrows-alt-h fa-lg"></i> Orientación A5
                                                </label>
                                                <el-switch v-model="form.a5_orientation" active-text="Horizontal" inactive-text="Vertical" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Orientación A5', form.a5_orientation, 'a5_orientation', 'arrowsAltIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Mostrar logo en documentos -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-image fa-lg"></i> Mostrar logo en documentos
                                                </label>
                                                <el-switch v-model="form.show_logo_in_documents" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar logo en documentos', form.show_logo_in_documents, 'show_logo_in_documents', 'imageIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Mostrar código interno en productos (ticket) -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-barcode fa-lg"></i> Imprimir código interno (ticket)
                                                    <el-tooltip class="item" effect="dark" content="Mostrar e Imprimir Código Interno  en TICKET" placement="top-start">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                </label>
                                                <el-switch v-model="form.show_internal_code_ticket" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar código interno en productos (ticket)', form.show_internal_code_ticket, 'show_internal_code_ticket', 'barcodeIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir correo en ticket -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-envelope fa-lg"></i> Imprimir correo en ticket
                                                </label>
                                                <el-switch v-model="form.correo_red_salud_ticket" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir correo en ticket', form.correo_red_salud_ticket, 'correo_red_salud_ticket', 'envelopeIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Impresión en áreas diferentes -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión en áreas diferentes
                                                </label>
                                                <el-switch v-model="form.print_direct_just_different_areas" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Impresión en áreas diferentes', form.print_direct_just_different_areas, 'print_direct_just_different_areas', 'printIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Impresión Directa -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión Directa
                                                </label>
                                                <el-switch v-model="form.print_direct" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Impresión Directa', form.print_direct, 'print_direct', 'printIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir referencia en ticket -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-receipt fa-lg"></i> Imprimir referencia en ticket
                                                </label>
                                                <el-switch v-model="form.reference_ticket" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir referencia en ticket', form.reference_ticket, 'reference_ticket', 'receiptIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Imprimir gastos/ingresos -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-balance-scale fa-lg"></i> Imprimir gastos/ingresos
                                                </label>
                                                <el-switch v-model="form.print_incomes_expenses" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir gastos/ingresos', form.print_incomes_expenses, 'print_incomes_expenses', 'balanceScaleIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Reimpresión de documentos - Caja -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Reimpresión de documentos - Caja
                                                </label>
                                                <el-switch v-model="form.print_document_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reimpresión de documentos - Caja', form.print_document_cash, 'print_document_cash', 'printIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Impresión directa vendedor Cotización - Caja -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-print fa-lg"></i> Impresión directa vendedor Cotización - Caja
                                                </label>
                                                <el-switch v-model="form.seller_quotation_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Impresión directa vendedor Cotización - Caja', form.seller_quotation_cash, 'seller_quotation_cash', 'printIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Guardar decisión de Impresión -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-save fa-lg"></i> Guardar decisión de Impresión
                                                </label>
                                                <el-switch v-model="form.save_pos_printing" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Guardar decisión de Impresión', form.save_pos_printing, 'save_pos_printing', 'saveIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <!-- Mostrar política precios ticket -->
                                        <div class="col-md-2 mt-4">
                                            <div class="form-group">
                                                <label class="control-label w-100">
                                                    <i class="fas fa-ticket-alt tab-icon"></i>
                                                    Mostrar política precios ticket
                                                </label>
                                                <el-switch v-model="form.show_unit_types_ticket" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar política precios ticket', form.show_unit_types_ticket, 'show_unit_types_ticket', 'ticketAltIcon')"></el-switch>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Imprimir política de precio - Cotización -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-tags fa-lg"></i> Imprimir política de precio - Cotización
                                                    </label>
                                                    <el-switch v-model="form.unit_type_pdf_quotation" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir política de precio - Cotización', form.unit_type_pdf_quotation, 'unit_type_pdf_quotation', 'tagsIcon')"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Imprimir número de whatsapp en ticket -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-phone-alt fa-lg"></i> Imprimir número de whatsapp en ticket
                                                    </label>
                                                    <el-switch v-model="form.numero_accion_independiente_admin" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir número de whatsapp en ticket', form.numero_accion_independiente_admin, 'numero_accion_independiente_admin', 'phoneIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Imprimir productos vendidos en reporte ticket -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-list fa-lg"></i> Imprimir productos vendidos en reporte ticket
                                                    </label>
                                                    <el-switch v-model="form.configurable_impresion_ticket_categoria_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir productos vendidos en reporte ticket', form.configurable_impresion_ticket_categoria_caja, 'configurable_impresion_ticket_categoria_caja', 'listIcon')"></el-switch>
                                                </div>
                                            </div>
                                            <!-- Texto pie de página -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label for="text-3">
                                                        <i class="fas fa-quote-right fa-lg"></i> Imrpimir Texto pie de página
                                                        <el-tooltip class="item" effect="dark" content="Imprimir Texto que va en la parte inferior de los documentos" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-input class="w-100" v-model="form.footer_text" placeholder="Pie de página" size="normal" type="textarea" rows="3" @input="saveSubmitDebounce"></el-input>
                                                </div>
                                            </div>
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
                                            <!-- Manejo de caja principal -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-cash-register fa-lg"></i>
                                                        Manejo de caja principal
                                                    </label>
                                                    <el-switch v-model="form.principal_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Manejo de caja principal', form.principal_cash, 'principal_cash', 'cashRegisterIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Caja principal automatica -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-cogs fa-lg"></i>
                                                        Caja principal automatica
                                                        <el-tooltip class="item" effect="dark" content="Caja principal se cierra y abre en base al turno inicial - final" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="form.automatic_principal_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Caja principal automatica', form.automatic_principal_cash, 'automatic_principal_cash', 'cogsIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Turno inicio -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-clock fa-lg"></i>
                                                        Turno inicio
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="form.turn_principal" @change="submit('Turno inicio', form.turn_principal, 'turn_principal', 'clockIcon')" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="turn.label" :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <!-- Turno final -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-clock fa-lg"></i>
                                                        Turno final
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle fa-lg"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="form.turn_end" @change="submit('Turno final', form.turn_end, 'turn_end', 'clockIcon')" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="turn.label" :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <!-- A cuenta -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fa fa-money-check-alt fa-lg"></i>
                                                        A cuenta
                                                    </label>
                                                    <el-switch v-model="form.credit_list" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('A cuenta', form.credit_list, 'credit_list', 'moneyCheckAltIcon')"></el-switch>
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
                                                Modulo Mantenimiento
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-university"></i> Bancos
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.bancos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Bancos', form.bancos, 'bancos', 'universityIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-credit-card"></i> Cuentas Bancarias
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.cuentas_bancarias" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Cuentas Bancarias', form.cuentas_bancarias, 'cuentas_bancarias', 'creditCardIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-users"></i> Vendedores
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.vendedores" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Vendedores', form.vendedores, 'vendedores', 'usersIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-tasks"></i> Registro de Actividad
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.registro_actividad" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Registro de Actividad', form.registro_actividad, 'registro_actividad', 'tasksIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-list-alt"></i> Categorias
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.categorias" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Categorias', form.categorias, 'categorias', 'listAltIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-trademark"></i> Marca
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.marca" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Marca', form.marca, 'marca', 'trademarkIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-user"></i> Clientes
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.clientes" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Clientes', form.clientes, 'clientes', 'userIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-truck"></i> Proveedores
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.provedores" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Proveedores', form.provedores, 'provedores', 'truckIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-cogs"></i> Atributos
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.atributos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Atributos', form.atributos, 'atributos', 'cogsIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-balance-scale"></i> Unidad de Medida
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.unidad_medida" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Unidad de Medida', form.unidad_medida, 'unidad_medida', 'balanceScaleIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña Compras -->
                                        <el-tab-pane label="Compras" name="tab-2">
                                            <div class="nested-tab-content">
                                                Modulo Compras
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-shopping-cart"></i> Compras
                                                                <el-tooltip class="item" effect="dark" content="" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.lista_compras" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Compras', form.lista_compras, 'lista_compras', 'shoppingCartIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña Inventario -->
                                        <el-tab-pane label="Inventario" name="tab-3">
                                            <div class="nested-tab-content">
                                                Modulo Inventario
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-box"></i> Recibir Productos (traslado)
                                                                <el-tooltip class="item" effect="dark" content="Recibir Productos por TRASLADO DE MERCADERIA en CAJA activa 2 modulos en adminsitrador inventario" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.receive_merchandise" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Recibir Productos (traslado)', form.receive_merchandise, 'receive_merchandise', 'boxIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-boxes"></i> Productos
                                                                <el-tooltip class="item" effect="dark" content="Modulo de productos aquí se encuentra todo los productos registrados y también se puede crear" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.listado_productos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Productos', form.listado_productos, 'listado_productos', 'boxesIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-truck-loading"></i> Guias de Remisión
                                                                <el-tooltip class="item" effect="dark" content="Modulo de guias de remisión aquí puedes generar una guia de remisión por administrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.guias_remision" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Guias de Remisión', form.guias_remision, 'guias_remision', 'truckLoadingIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-tags"></i> Promociones y Ofertas
                                                                <el-tooltip class="item" effect="dark" content="Modulo de promociones y Ofertas para crear platos con receta" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.promocion_oferta" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Promociones y Ofertas', form.promocion_oferta, 'promocion_oferta', 'tagsIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-exchange-alt"></i> Ingreso y Salida de Productos
                                                                <el-tooltip class="item" effect="dark" content="Modulo de ingreso y salida de productos aquí podemos sacar o ingresar productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.ingreso_salida_productos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ingreso y Salida de Productos', form.ingreso_salida_productos, 'ingreso_salida_productos', 'exchangeAltIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-cogs"></i> Tipo de Transacciones Inventario
                                                                <el-tooltip class="item" effect="dark" content="Modulo de transaciones e inventario aquí podemos crear o inhabilitar los tipos de transacciones que nos para el ingreso o salida de productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.tipo_transacciones_inventario" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Tipo de Transacciones Inventario', form.tipo_transacciones_inventario, 'tipo_transacciones_inventario', 'cogsIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-tags"></i> Etiquetas
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos imprimir nuestras etiquetas de nuestros productos" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.ver_etiqueta_logistica" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Etiquetas', form.ver_etiqueta_logistica, 'ver_etiqueta_logistica', 'tagsIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña Comprobantes de Pago -->
                                        <el-tab-pane label="Comprobantes de Pago" name="tab-4">
                                            <div class="nested-tab-content">
                                                Modulo Comprobantes de Pago
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-file-invoice"></i> Nuevo Comprobante
                                                                <el-tooltip class="item" effect="dark" content="Aqui podemos emitir boletas y facturas de administrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nuevo_comprobante_electronico" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Nuevo Comprobante', form.nuevo_comprobante_electronico, 'nuevo_comprobante_electronico', 'fileInvoiceIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-list-alt"></i> Listado de Comprobantes
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todo los comprobantes emitidos boletas y facturas" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.listado_boleta_factura_nuevo" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Listado de Comprobantes', form.listado_boleta_factura_nuevo, 'listado_boleta_factura_nuevo', 'listAltIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-times-circle"></i> No Enviados
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver los documentos que no se enviaron a SUNAT o vencieron el plazo de envio" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.no_enviados" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('No Enviados', form.no_enviados, 'no_enviados', 'timesCircleIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-receipt"></i> Nota de Venta
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todas las notas de venta generadas y también crear nuevas notas de venta" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nota_venta" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Nota de Venta', form.nota_venta, 'nota_venta', 'receiptIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-credit-card"></i> Nota de Crédito
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos generar notas de crédito con los documentos que por error se enviaron a SUNAT y se pedirá la devolución" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.nota_credito" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Nota de Crédito', form.nota_credito, 'nota_credito', 'creditCardIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-file-alt"></i> Cotizaciones
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver las cotizaciones y crear nuevas cotizaciones en administrador" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.cotizaciones" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Cotizaciones', form.cotizaciones, 'cotizaciones', 'fileAltIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-book"></i> Resumenes
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver los resumenes generados de las boletas y también generar nuevos resumenes por fecha" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.resumenes" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Resumenes', form.resumenes, 'resumenes', 'bookIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-ban"></i> Anulaciones
                                                                <el-tooltip class="item" effect="dark" content="Aquí podemos ver todos los documentos anulados" placement="top-start">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </el-tooltip>
                                                            </label>
                                                            <el-switch v-model="form.anulaciones" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Anulaciones', form.anulaciones, 'anulaciones', 'banIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fa fa-percentage"></i> Detracciones
                                                            </label>
                                                            <el-switch v-model="form.detraction" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Detracciones', form.detraction, 'detraction', 'percentageIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña Arqueo -->
                                        <el-tab-pane label="Arqueo" name="tab-5">
                                            <div class="nested-tab-content">
                                                Modulos de arqueo
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-patient-file"></i> Reporte de Caja
                                                            </label>
                                                            <el-switch v-model="form.reporte_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte de Caja', form.reporte_caja, 'reporte_caja', 'patientFileIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-attachment"></i> Reporte de Cierre De Caja
                                                            </label>
                                                            <el-switch v-model="form.reporte_cierre_caja" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte de Cierre De Caja', form.reporte_cierre_caja, 'reporte_cierre_caja', 'attachmentIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-globe"></i> Reporte Globalizado
                                                            </label>
                                                            <el-switch v-model="form.reporte_globalizado" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte Globalizado', form.reporte_globalizado, 'reporte_globalizado', 'globeIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                        <!-- Pestaña Reportes -->
                                        <el-tab-pane label="Reportes" name="tab-6">
                                            <div class="nested-tab-content">
                                                <div class="row">
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-list"></i> Productos Vendidos
                                                            </label>
                                                            <el-switch v-model="form.productos_vendidos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Productos Vendidos', form.productos_vendidos, 'productos_vendidos', 'listIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-box"></i> Reporte de métodos de pago
                                                            </label>
                                                            <el-switch v-model="form.reporte_metodos_pago" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte de métodos de pago', form.reporte_metodos_pago, 'reporte_metodos_pago', 'boxIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-money-bag"></i> Reporte de Ganancias
                                                            </label>
                                                            <el-switch v-model="form.reporte_ganancias" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte de Ganancias', form.reporte_ganancias, 'reporte_ganancias', 'moneyBagIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-window-restore"></i> Reporte de Productos
                                                            </label>
                                                            <el-switch v-model="form.reporte_productos" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte de Productos', form.reporte_productos, 'reporte_productos', 'windowRestoreIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-dollar"></i> Stock Valorizado
                                                            </label>
                                                            <el-switch v-model="form.stock_valorizado" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Stock Valorizado', form.stock_valorizado, 'stock_valorizado', 'dollarIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-boxes"></i> Stock Minimo
                                                            </label>
                                                            <el-switch v-model="form.stock_minimo" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Stock Minimo', form.stock_minimo, 'stock_minimo', 'boxesIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-box"></i> Stock De Producto
                                                            </label>
                                                            <el-switch v-model="form.stock_producto" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Stock De Producto', form.stock_producto, 'stock_producto', 'boxIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="icofont-chart-bar-graph"></i> Kardex
                                                            </label>
                                                            <el-switch v-model="form.kardex" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Kardex', form.kardex, 'kardex', 'chartBarGraphIcon')"></el-switch>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-4">
                                                        <div class="form-group">
                                                            <label class="control-label w-100">
                                                                <i class="fas fa-fingerprint"></i> Reporte De Series Vendidas
                                                            </label>
                                                            <el-switch v-model="form.reporte_series_vendidas" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte De Series Vendidas', form.reporte_series_vendidas, 'reporte_series_vendidas', 'fingerprintIcon')"></el-switch>
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
                                        <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                            <i class="fas fa-cash-register" style="margin-right: 10px;"></i>
                                            <span>Caja</span>
                                        </div>
                                        <div>
                                            Contenido de la Caja.
                                            <div class="row">
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            <i class="fa fa-receipt fa-lg"></i> Uso de Comanda Física
                                                        </label>
                                                        <el-switch v-model="form.commands_fisico" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Uso de Comanda Física', form.commands_fisico, 'commands_fisico', 'receiptIcon')"></el-switch>
                                                        <small class="text-danger" v-if="errors.commands_fisico" v-text="errors.commands_fisico[0]"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-print fa-lg"></i> Imprimir Comanda en Caja
                                                        </label>
                                                        <el-switch v-model="form.print_commands" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir Comanda en Caja', form.print_commands, 'print_commands', 'printIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-file-alt fa-lg"></i> Emitir Documento Variación
                                                        </label>
                                                        <el-switch v-model="form.show_variation_dcto" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Emitir Documento Variación', form.show_variation_dcto, 'show_variation_dcto', 'fileAltIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-boxes fa-lg"></i> Producto - Variación
                                                        </label>
                                                        <el-select :disabled="!form.show_variation_dcto" ref="producto" v-model="form.item_variation_id" @change="changeItem" filterable remote placeholder="Buscar..." popper-class="el-select-items" :remote-method="searchRemoteItems" :loading="loading_search">
                                                            <el-option v-for="option in items" :key="option.id" :value="option.id" :label="option.full_description || option.description"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-key fa-lg"></i> Pedir PIN al Eliminar Orden
                                                        </label>
                                                        <el-switch v-model="form.pin_orden_delete" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Pedir PIN al Eliminar Orden', form.pin_orden_delete, 'pin_orden_delete', 'keyIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fab fa-whatsapp fa-lg"></i>

                                                            Enviar Whatsapp al Eliminar Orden
                                                        </label>
                                                        <el-switch v-model="form.send_whatsapp_activity" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Enviar Whatsapp al Eliminar Orden', form.send_whatsapp_activity, 'send_whatsapp_activity', 'whatsappIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-list-alt fa-lg"></i> Categorías Arrastrables Caja
                                                        </label>
                                                        <el-switch v-model="form.pos_drag_category" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Categorías Arrastrables Caja', form.pos_drag_category, 'pos_drag_category', 'listAltIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-clipboard fa-lg"></i> Reporte Caja - para llevar
                                                        </label>
                                                        <el-switch v-model="form.carry_cash_report" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Reporte Caja - para llevar', form.carry_cash_report, 'carry_cash_report', 'clipboardIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-coins fa-lg"></i> Billetes/Monedas a recibir Caja
                                                        </label>
                                                        <el-switch v-model="form.show_coins_to_receive" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Billetes/Monedas a recibir Caja', form.show_coins_to_receive, 'show_coins_to_receive', 'coinsIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-file-alt fa-lg"></i> PDF de precuenta
                                                        </label>
                                                        <el-switch v-model="form.pdf_preorder" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('PDF de precuenta', form.pdf_preorder, 'pdf_preorder', 'fileAltIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-table fa-lg"></i> Mostrar "Mesa Caja"
                                                        </label>
                                                        <el-switch v-model="form.show_caja_table" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar Mesa Caja', form.show_caja_table, 'show_caja_table', 'tableIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-file-alt fa-lg"></i> Texto en precuenta
                                                            <el-tooltip class="item" effect="dark" content="Permite agregar un texto en la precuenta de consumo" placement="top-start">
                                                                <i class="fa fa-info-circle fa-lg"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.text_comanda" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Texto en precuenta', form.text_comanda, 'text_comanda', 'fileAltIcon')"></el-switch>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mt-4">
                                                    <label for="text_1">
                                                        <i class="fa fa-file-alt fa-lg"></i> Primer texto
                                                    </label>
                                                    <el-input :disabled="!form.text_comanda" class="w-100" v-model="form.text_one" placeholder="Texto 1" size="normal" @input="saveSubmitDebounce"></el-input>
                                                </div>

                                                <div class="col-md-2 mt-4">
                                                    <label for="text-2">
                                                        <i class="fa fa-file-alt fa-lg"></i> Segundo texto
                                                    </label>
                                                    <el-input :disabled="!form.text_comanda" class="w-100" v-model="form.text_two" placeholder="Texto 2" size="normal" @input="saveSubmitDebounce"></el-input>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-lock fa-lg"></i> No Cierra Caja con Mesa Ocupada
                                                            <el-tooltip content="Alerta sobre las mesas pendientes al cerrar caja, es posible emitir una nota de venta por todo">
                                                                <i class="fa fa-info-circle fa-lg"></i>
                                                            </el-tooltip>
                                                        </label>
                                                        <el-switch v-model="form.ordens_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Evitar Cerrar Caja con Ordenes Pendientes', form.ordens_cash, 'ordens_cash', 'lockIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <!-- Emitir documento con variación -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-file-alt tab-icon"></i> Emitir documento con variación
                                                        </label>
                                                        <el-switch v-model="form.variation_hotel" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Emitir documento con variación', form.variation_hotel, 'variation_hotel', 'fileAltIcon')"></el-switch>
                                                    </div>
                                                    
                                                    
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

                                                <!-- Producto - Variación -->
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-boxes tab-icon"></i> Producto - Variación
                                                        </label>
                                                        <div class="el-input el-input-group el-input-group--append">
                                                            <el-select :disabled="!form.variation_hotel" ref="producto" v-model="form.item_variation_id" @change="changeItem" filterable remote placeholder="Buscar..." popper-class="el-select-items" @visible-change="focusTotalItem" :remote-method="searchRemoteItems" :loading="loading_search">
                                                                <el-option v-for="option in items" :key="option.id" :value="option.id" :label="option.full_description || option.description"></el-option>
                                                            </el-select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Restaurant-Mozo -->
                                        <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                            <i class="fas fa-concierge-bell" style="margin-right: 10px;"></i>
                                            <span>Mozo</span>
                                        </div>
                                        <div>
                                            Contenido del Mozo.
                                            <div class="row">
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-key fa-lg"></i> Ingresar pin mozo (ordenes)
                                                        </label>
                                                        <el-switch v-model="form.pin_switch" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Ingresar pin mozo (ordenes)', form.pin_switch, 'pin_switch', 'keyIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-user fa-lg"></i> Caja-Mozo
                                                        </label>
                                                        <el-switch v-model="form.box_orden" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Caja-Mozo', form.box_orden, 'box_orden', 'userIcon')"></el-switch>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group" :class="{'has-danger': errors.affectation_igv_type_id}">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-search fa-lg"></i> (Módulo de Mozo) Búsqueda de Producto por
                                                        </label>
                                                        <el-select v-model="form.search_type" @change="submit('Búsqueda de Producto', form.search_type, 'search_type', 'searchIcon')" filterable>
                                                            <el-option label="Buscar por Descripción" value="0"></el-option>
                                                            <el-option label="Buscar por Código interno" value="1"></el-option>
                                                        </el-select>
                                                        <small class="text-danger" v-if="errors.affectation_igv_type_id" v-text="errors.affectation_igv_type_id[0]"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fa fa-user fa-lg"></i> Acciones de inhabilitar mesa mozo
                                                        </label>
                                                        <el-switch v-model="form.cambiar_mesa_mozo" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Acciones mozo', form.cambiar_mesa_mozo, 'Acciones mozo', 'userIcon')"></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Restaurant-Zona de Preparación -->
                                        <div slot="header" style="background-color: #073f68; color: white; padding: 10px; display: flex; align-items: center;">
                                            <i class="fas fa-utensils fa-lg" style="margin-right: 10px;"></i>
                                            <span>Zona de Preparación</span>
                                        </div>
                                        <div>
                                            Contenido de la Zona de Preparación.
                                            <div class="row">
                                                <div class="col-md-2 mt-4">
                                                    <div class="form-group">
                                                        <label class="control-label w-100">
                                                            <i class="fas fa-print fa-lg" style="margin-right: 10px;"></i> Imprimir en Zona Preparación
                                                        </label>
                                                        <el-switch v-model="form.print_kitchen" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Imprimir en Zona Preparación', form.print_kitchen, 'print_kitchen', 'printIcon')"></el-switch>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="row" v-if="form.hotels">
                                            <!-- Tiempo de alarma de alquileres por vencer -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-bell tab-icon"></i> Tiempo de alarma de alquileres por vencer
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.alarm_to_end" @change="submit('Tiempo de alarma de alquileres por vencer', form.alarm_to_end, 'alarm_to_end', 'bellIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Tiempo de mantenimiento -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-tools tab-icon"></i> Tiempo de mantenimiento
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.time_manteniment" @change="submit('Tiempo de mantenimiento', form.time_manteniment, 'time_manteniment', 'toolsIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Límite de la garantía - frigobar -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-shield-alt tab-icon"></i> Límite de la garantía - frigobar
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.credit_line_hotel_limit" @change="submit('Límite de la garantía - frigobar', form.credit_line_hotel_limit, 'credit_line_hotel_limit', 'shieldAltIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Descuento aplicado por día a cambio del servicio x habitación -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-percent tab-icon"></i> Descuento aplicado por Día

                                                        <el-tooltip class="item" effect="dark" content="Descuento aplicado por día a cambio del servicio x habitación" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.discount_amount_instead_service" @change="submit('Descuento aplicado por día a cambio del servicio x habitación', form.discount_amount_instead_service, 'discount_amount_instead_service', 'percentIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Tiempo para aviso de salida de habitación -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-sign-out-alt tab-icon"></i> Tiempo para aviso de salida de habitación
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.minute_close_to_leave" @change="submit('Tiempo para aviso de salida de habitación', form.minute_close_to_leave, 'minute_close_to_leave', 'signOutAltIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Tiempo para limpiar la habitación -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-broom tab-icon"></i> Tiempo para limpiar la habitación
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.time_to_clean" @change="submit('Tiempo para limpiar la habitación', form.time_to_clean, 'time_to_clean', 'broomIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Tiempo para el cálculo del inicio del día -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-clock tab-icon"></i> Tiempo para el cálculo del inicio del día
                                                    </label>
                                                    <el-time-picker style="width: 100%;" value-format="HH:mm:ss" format="hh:mm A" timezone="America/Lima" v-model="form.time_to_enter" @change="submit('Tiempo para el cálculo del inicio del día', form.time_to_enter, 'time_to_enter', 'clockIcon')"></el-time-picker>
                                                </div>
                                            </div>

                                            <!-- Tiempo para el cálculo del final del día -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-clock tab-icon"></i> Tiempo para el cálculo del final del día
                                                    </label>
                                                    <el-time-picker style="width: 100%;" value-format="HH:mm:ss" format="hh:mm A" timezone="America/Lima" v-model="form.time_to_leave" @change="submit('Tiempo para el cálculo del final del día', form.time_to_leave, 'time_to_leave', 'clockIcon')"></el-time-picker>
                                                </div>
                                            </div>

                                            <!-- Autorización de descuento -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-check-circle tab-icon"></i> Autorización de descuento
                                                    </label>
                                                    <el-switch v-model="form.auth_discount" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Autorización de descuento', form.auth_discount, 'auth_discount', 'checkCircleIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Control de mantenimiento -->
                                            <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-wrench tab-icon"></i> Control de mantenimiento
                                                    </label>
                                                    <el-switch v-model="form.maintenance_workers" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Control de mantenimiento', form.maintenance_workers, 'maintenance_workers', 'wrenchIcon')"></el-switch>
                                                </div>
                                            </div>

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
                                            <!-- Dar a crédito nota de venta (sin cuotas) -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-hand-holding-usd tab-icon"></i> Otorgar Créditos NV (s/cuotas)
                                                    </label>
                                                    <el-tooltip content="Otorgar Créditos en Notas de Venta, SIN CUOTAS">
                                                        <i class="fa fa-info-circle"></i>
                                                    </el-tooltip>
                                                    <el-switch v-model="form.sale_note_credit_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Otorgar Créditos NV (s/cuotas)', form.sale_note_credit_cash, 'sale_note_credit_cash', 'handHoldingUsdIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Penalidades -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-balance-scale tab-icon"></i> Penalidades
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_penalty" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Penalidades', form.sale_note_credit_penalty, 'sale_note_credit_penalty', 'balanceScaleIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Confirmación de aprobación -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-check-circle tab-icon"></i> Confirmación de aprobación
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_confirm" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Confirmación de aprobación', form.sale_note_credit_confirm, 'sale_note_credit_confirm', 'checkCircleIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Aceptar montos menores en las cuotas -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-money-bill-wave tab-icon"></i> Aceptar montos menores en las cuotas
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_low_pay" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Aceptar montos menores en las cuotas', form.sale_note_credit_low_pay, 'sale_note_credit_low_pay', 'moneyBillWaveIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Editar Créditos -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-edit tab-icon"></i> Editar Créditos
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_edit" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Editar Créditos', form.sale_note_credit_edit, 'sale_note_credit_edit', 'editIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Enviar whatsapp a clientes -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fab fa-whatsapp tab-icon"></i> Enviar whatsapp a clientes
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_send_whatsapp" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Enviar whatsapp a clientes', form.sale_note_credit_send_whatsapp, 'sale_note_credit_send_whatsapp', 'whatsappIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- Mostrar formatos adicionales -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-file-alt tab-icon"></i> Mostrar formatos adicionales
                                                    </label>
                                                    <el-switch v-model="form.sale_note_credit_formats" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Mostrar formatos adicionales', form.sale_note_credit_formats, 'sale_note_credit_formats', 'fileAltIcon')"></el-switch>
                                                </div>
                                            </div>

                                            <!-- % de crédito -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-percent tab-icon"></i> % de crédito
                                                    </label>
                                                    <el-input-number class="w-100" v-model="form.rates" :precision="2" :step="0.5" :max="100" @change="submit('Porcentaje de crédito', form.rates, 'rates', 'percentIcon')"></el-input-number>
                                                </div>
                                            </div>

                                            <!-- Whatsapp personalizado -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-user-edit tab-icon"></i> Whatsapp personalizado
                                                        <el-tooltip class="item" effect="dark" content="Usa su propia app de whatsapp" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="form.whatsapp_client" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Whatsapp personalizado', form.whatsapp_client, 'whatsapp_client', 'userEditIcon')"></el-switch>
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
                                            <!-- Turno inicio -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-clock tab-icon"></i> Turno inicio
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="form.turn_principal" @change="submit('Turno inicio', form.turn_principal, 'turn_principal', 'clockIcon')" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="turn.label" :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <!-- Turno final -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-hourglass-end tab-icon"></i> Turno final
                                                        <el-tooltip class="item" effect="dark" content="Turno elegido para agrupar las cajas" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-select v-model="form.turn_end" @change="submit('Turno final', form.turn_end, 'turn_end', 'hourglassEndIcon')" clearable>
                                                        <el-option v-for="turn in turns" :key="turn.id" :label="turn.label" :value="turn.id"></el-option>
                                                    </el-select>
                                                </div>
                                            </div>

                                            <!-- Caja principal automática -->
                                            <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                    <label class="control-label w-100">
                                                        <i class="fas fa-cogs tab-icon"></i> Caja principal automática
                                                        <el-tooltip class="item" effect="dark" content="Caja principal se cierra y abre en base al turno inicial - final" placement="top-start">
                                                            <i class="fa fa-info-circle"></i>
                                                        </el-tooltip>
                                                    </label>
                                                    <el-switch v-model="form.automatic_principal_cash" active-text="Si" inactive-text="No" :active-color="'#28a745'" :inactive-color="'#6c757d'" @change="submit('Caja principal automática', form.automatic_principal_cash, 'automatic_principal_cash', 'cogsIcon')"></el-switch>
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
.el-notification__closeBtn {
    color: white;
}

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

@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateX(100%);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fade-out {
    to {
        opacity: 0;
        transform: translateY(-20%);
    }
}

.swal2-no-border {
    border-radius: 12px;
    /* Bordes redondeados */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    /* Sombra suave */
    font-family: 'Arial', sans-serif;
    /* Tipografía moderna */
    padding: 20px;
}

.swal2-no-border .swal2-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.swal2-no-border .swal2-html-container {
    font-size: 1.1rem;
    font-weight: normal;
    color: #343a40;
    /* Color del texto gris oscuro */
}

.icon-activated {
    animation: pulse 1s infinite;
}

.icon-deactivated {
    animation: shake 0.82s cubic-bezier(.36, .07, .19, .97) both;
}

.animate-icon {
    animation: icon-bounce 1s ease-in-out;
}

@keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }

    40% {
        transform: translateY(-15px);
    }

    60% {
        transform: translateY(-10px);
    }
}

@keyframes icon-bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }

    40% {
        transform: translateY(-15px);
    }

    60% {
        transform: translateY(-10px);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}

@keyframes shake {

    10%,
    90% {
        transform: translate3d(-1px, 0, 0);
    }

    20%,
    80% {
        transform: translate3d(2px, 0, 0);
    }

    30%,
    50%,
    70% {
        transform: translate3d(-4px, 0, 0);
    }

    40%,
    60% {
        transform: translate3d(4px, 0, 0);
    }
}

.form-group {
    margin-left: 20px;
    /* Añadir margen izquierdo para evitar que las opciones se superpongan */

}

.payment-logo {
    width: 90px;
    /* Ajusta el tamaño del logo */
    height: auto;
    /* Mantiene la proporción del logo */
    margin-right: 10px;
    /* Añade un margen a la derecha */
    vertical-align: middle;
    /* Alinea verticalmente con el texto */
}
</style>

<script>
import Swal from 'sweetalert2';
export default {
    props: ["typeUser", "isArca"],
    data() {
        return {
            activeSubTab: 'tab-1', // Esta es la subpestaña que se activará por defecto
            searchQueryModes: '', // Input de búsqueda
            form: {
                // Form Modos
                credits: false,
                college: false,
                restaurant: false,
                hotels: false,
                internet: false,
                toll: false,
                health_network: false,
                // Form Modelos de negocio
                promotions_sell: false,
                promotions_cant_purchase: 0,
                accounting_mode: false,
                series_enabled: false,
                lots_enabled: false,
                color_size_enabled: false,
                dispatch: false,
                quotation: false,
                consignment: false,
                item_consignment_id: null,
                transform_item: false,
                commercial_treatment_items: false,
                // Form Contabilidad
                affectation_optional: false,
                decimal_quantity: 2,
                amount_plastic_bag_taxes: 0.1,
                affectation_igv_type_id: null,
                send_auto: false,
                cron: false,
                change_date_emit: false,
                restrict_receipt_date: false,
                days_before_emit: 1,
                include_igv: false,
            },
            items: [
                // Items de Modos

            ],

            loading_submit: false,
            errors: {},

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
        console.log(this.isArca);
        this.getUsersExcluded();
        await this.$http.get(`/${this.resource}/record`).then(response => {
            if (response.data !== "") {
                this.form = response.data.data;
            }
        });
        console.log(this.form.hotels);
        if(this.isArca){
            this.activeTab = "hotel"
        }
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

    computed: {
        filteredAndSortedItems() {
            const query = this.searchQueryModes.trim().toLowerCase();

            if (query.length < 3) {
                return [];
            }

            return this.items
                .filter(item => item.label.toLowerCase().includes(query))
                .sort((a, b) => {
                    const aStartsWithQuery = a.label.toLowerCase().startsWith(query);
                    const bStartsWithQuery = b.label.toLowerCase().startsWith(query);

                    if (aStartsWithQuery && !bStartsWithQuery) return -1;
                    if (!aStartsWithQuery && bStartsWithQuery) return 1;
                    return a.label.toLowerCase().localeCompare(b.label.toLowerCase());
                });
        }
    },

    methods: {
        highlight(text, query) {
            if (!query) return text;
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark>$1</mark>');
        },

        async submit(optionName, isActive, iconOrImgSrc, iconRef, isImage = false) {
            const action = isActive ? 'ACTIVADO' : 'DESACTIVADO';
            const backgroundColor = '#f8f9fa'; // Fondo blanco o gris claro
            const actionColor = isActive ? '#28a745' : '#dc3545'; // Verde para activado, rojo para desactivado

            let iconHtml = '';

            if (isImage && iconOrImgSrc) {
                // Si se trata de una imagen y se ha proporcionado un src válido, se muestra sin el borde redondeado
                iconHtml = `<img src="${iconOrImgSrc}" alt="${optionName} Logo" class="payment-logo" style="width: 80px; height: auto; vertical-align: middle; margin-right: 10px; border-radius: 0;" />`;
            }

            console.log('Enviando datos a la API:', this.form, `/${this.resource}`);

            this.loading_submit = true;
            try {
                const response = await this.$http.post(`/${this.resource}`, this.form);

                if (response.data.success) {
                    // Mostrar un SweetAlert centrado cuando la operación es exitosa
                    Swal.fire({
                        position: "center", // Centrado en la pantalla
                        icon: isActive ? "success" : "error", // Icono de éxito o error dependiendo del estado
                        title: optionName.toUpperCase(),
                        html: `<strong style="color: ${actionColor};">${action}</strong>${iconHtml ? `<br>${iconHtml}` : ''}`,
                        background: backgroundColor,
                        showConfirmButton: false,
                        timer: 2000 // Duración de 2 segundos
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR",
                        text: `Hubo un problema al actualizar la opción "${optionName}". Inténtalo de nuevo.`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR EN EL FORMULARIO",
                        text: "Hay errores en el formulario. Revísalos e intenta nuevamente.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (!navigator.onLine) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "SIN CONEXIÓN A INTERNET",
                        html: `<i class="fas fa-wifi-slash" style="color: #dc3545; font-size: 2rem;"></i><br>Parece que no tienes conexión a Internet. Verifica tu conexión y vuelve a intentarlo.`,
                        background: backgroundColor,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    console.log('Error de conexión:', error);
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "ERROR DE CONEXIÓN",
                        text: "Error de conexión. Verifica tu red y vuelve a intentarlo.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            } finally {
                this.loading_submit = false;
            }

            this.animateIcon(iconRef); // Animar el ícono correspondiente
        },

        showSweetAlert(title, text, iconHtml, backgroundColor = null) {
            Swal.fire({
                title: `<div style="text-align: center;">${title}</div>`, // Título en mayúsculas y centrado
                html: `
                <div style="display: flex; align-items: center; justify-content: center;">
                    ${iconHtml}
                </div>
                <p style="font-weight: bold; font-size: 1.2rem;">${text}</p>
            `, // Texto normal
                timer: 2000, // Duración de 2 segundos
                showConfirmButton: false,
                background: backgroundColor ? backgroundColor : undefined,
                customClass: {
                    popup: 'swal2-no-border', // Clase personalizada
                },
                position: 'center'
            });
        },

        animateIcon(iconRef) {
            const icon = this.$refs[iconRef];
            if (icon) {
                icon.classList.add('animate-icon');
                setTimeout(() => {
                    icon.classList.remove('animate-icon');
                }, 1000);
            }
        },

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
            });
        },

        // async removeNumberWhatsapp(idx) {
        //     let {
        //         number
        //     } = this.numbers[idx];
        //     const response = await this.$http.post("/whatsapp/remove", {
        //         number
        //     });
        //     if (response.status == 200) {
        //         this.$toast.success("Número eliminado correctamente");

        //         this.showAddNumberwhatsapp = false;
        //         this.numberWhatsapp = null;
        //         this.getNumbers();
        //     } else {
        //         this.$toast.error("Ocurrió un error al eliminar el número");

        //     }
        // },
        async removeNumberWhatsapp(idx) {
            let {
                number
            } = this.numbers[idx];
            const response = await this.$http.post("/whatsapp/remove", {
                number
            });

            if (response.status == 200) {
                // Usando SweetAlert con la configuración personalizada
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Número eliminado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });

                this.showAddNumberwhatsapp = false;
                this.numberWhatsapp = null;
                this.getNumbers();
            } else {
                // Usando SweetAlert para mostrar un mensaje de error
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Ocurrió un error al eliminar el número",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },

        async sendNumberWhatsapp() {
            try {
                const response = await this.$http.post("/whatsapp/save", {
                    number: this.numberWhatsapp
                });
                if (response.status == 200) {
                    // Usando SweetAlert para mostrar un mensaje de éxito
                    Swal.fire({
                        position: "center", // Centrado en la pantalla
                        icon: "success", // Icono de éxito
                        title: "Éxito",
                        text: "Número de Whatsapp agregado correctamente",
                        showConfirmButton: false,
                        timer: 2000, // Duración de 2 segundos
                    });

                    this.showAddNumberwhatsapp = false;
                    this.numberWhatsapp = null;
                    this.getNumbers();
                } else {
                    // Usando SweetAlert para mostrar un mensaje de error
                    Swal.fire({
                        position: "center", // Centrado en la pantalla
                        icon: "error", // Icono de error
                        title: "Error",
                        text: "Ocurrió un error al agregar el número",
                        showConfirmButton: false,
                        timer: 2000, // Duración de 2 segundos
                    });
                }
            } catch (e) {
                let {
                    message
                } = e.response.data;
                // Usando SweetAlert para mostrar un mensaje de error en caso de excepción
                Swal.fire({
                    position: "center", // Centrado en la pantalla
                    icon: "error", // Icono de error
                    title: "Error",
                    text: message || "Ocurrió un error al agregar el número",
                    showConfirmButton: false,
                    timer: 2000, // Duración de 2 segundos
                });
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
                this.$toast.error("El numero de whatsapp debe tener 9 dígitos");
                return;
            }
            if (!/^\d+$/.test(v_number_activity)) {
                this.$toast.error(
                    "El numero de whatsapp debe ser un número válido"
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

    }
};
</script>
