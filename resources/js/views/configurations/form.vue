<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Configuraciones</h6>
            </div>
            <div class="card-body pt-0 pb-5">
                <form autocomplete="off">
                    <div class="form-body">
                        <el-tabs type="border-card">
                            <el-tab-pane label="Servicios">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label"
                                            >Envío de comprobantes
                                            automático</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.send_auto
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.send_auto"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.send_auto"
                                                v-text="errors.send_auto[0]"
                                            ></small>
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-4"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        <label class="control-label"
                                            >Crontab
                                            <small
                                                >Tareas Programadas</small
                                            ></label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.cron
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
                                                v-text="errors.cron[0]"
                                            ></small>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6 mt-4" v-if="typeUser != 'integrator'">
                                    <label class="control-label">Envío de comprobantes a servidor alterno de SUNAT</label>
                                    <div class="form-group" :class="{'has-danger': errors.sunat_alternate_server}">
                                        <el-switch v-model="form.sunat_alternate_server" active-text="Si" inactive-text="No" @change="submit"></el-switch>
                                        <small class="text-danger" v-if="errors.sunat_alternate_server" v-text="errors.sunat_alternate_server[0]"></small>
                                    </div>
                                </div> -->
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Contable">
                                <div class="row">
                                    <div
                                        class="col-md-4"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        <label class="control-label"
                                            >Cantidad decimales POS</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.decimal_quantity
                                            }"
                                        >
                                            <el-input-number
                                                v-model="form.decimal_quantity"
                                                @change="submit"
                                                :min="2"
                                                :max="10"
                                            ></el-input-number>
                                            <small
                                                class="text-danger"
                                                v-if="errors.decimal_quantity"
                                                v-text="
                                                    errors.decimal_quantity[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-4"
                                        v-if="typeUser != 'integrator'"
                                    >
                                        <label class="control-label"
                                            >Impuesto bolsa plástica</label
                                        >
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
                                    <div class="col-md-6 mt-4">
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.affectation_igv_type_id
                                            }"
                                        >
                                            <label class="control-label"
                                                >Tipo de afectación
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
                                                    :value="option.id"
                                                    :label="option.description"
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
                            </el-tab-pane>
                            <el-tab-pane label="Visual">
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label class="control-label"
                                            >Uso de Comanda Fisica (Modulo
                                            caja)</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.commands_fisico
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.commands_fisico"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.commands_fisico"
                                                v-text="
                                                    errors.commands_fisico[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="control-label"
                                            >Recrear Documento</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.recreat_document
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.recreat_document"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.recreat_document"
                                                v-text="
                                                    errors.recreat_document[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="control-label"
                                            >Eliminar Documento</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.delete_document
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.delete_document"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.delete_document"
                                                v-text="
                                                    errors.delete_document[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="control-label"
                                            >Editar Precio Venta en Caja</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.edit_price_sales
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.edit_price_sales"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.edit_price_sales"
                                                v-text="
                                                    errors.edit_price_sales[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Editar Cantidad en Caja</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.quantity_cash
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.quantity_cash"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.quantity_cash"
                                                v-text="errors.quantity_cash[0]"
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Editar nombre de productos</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.edit_name_product
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.edit_name_product"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.edit_name_product"
                                                v-text="
                                                    errors.edit_name_product[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Cambiar fecha de emisión</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.change_date_emit
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.change_date_emit"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.change_date_emit"
                                                v-text="
                                                    errors.change_date_emit[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Restringir fecha de
                                            comprobante</label
                                        >
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
                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Días trasncurridos para emitir
                                            dcto</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.days_before_emit
                                            }"
                                        >
                                            <el-select
                                                v-model="form.days_before_emit"
                                                @change="submit"
                                            >
                                                <el-option
                                                    v-for="day in days"
                                                    :key="`${day.id}-d`"
                                                    :value="day.value"
                                                    :label="
                                                        `${day.value} ${
                                                            day.value > 1
                                                                ? ' dias'
                                                                : ' dia'
                                                        }`
                                                    "
                                                >
                                                </el-option>
                                            </el-select>
                                            <small
                                                class="text-danger"
                                                v-if="errors.days_before_emit"
                                                v-text="
                                                    errors.days_before_emit[0]
                                                "
                                            ></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="control-label"
                                            >Impuesto incluido en registro de
                                            productos</label
                                        >
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger': errors.include_igv
                                            }"
                                        >
                                            <el-switch
                                                v-model="form.include_igv"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                            <small
                                                class="text-danger"
                                                v-if="errors.include_igv"
                                                v-text="errors.include_igv[0]"
                                            ></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Impresión Directa</label
                                            >
                                            <el-switch
                                                v-model="form.print_direct"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Multiples Caja (Usuario
                                                Cajero)</label
                                            >
                                            <el-switch
                                                v-model="form.multiple_boxes"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Venta Rapida (Modulo
                                                Caja)</label
                                            >
                                            <el-switch
                                                v-model="form.sales_quick"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Imprimir Comanda</label
                                            >
                                            <el-switch
                                                v-model="form.print_commands"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Vender con stock</label
                                            >
                                            <el-switch
                                                v-model="form.sales_stock"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="
                                                    submit();
                                                    stock_control();
                                                "
                                            ></el-switch>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Imprimir en Zona
                                                Preparación</label
                                            >
                                            <el-switch
                                                v-model="form.print_kitchen"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Ingresar pin
                                                mozo(ordenes)</label
                                            >
                                            <el-switch
                                                v-model="form.pin_switch"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Caja-Mozo
                                            </label>
                                            <el-switch
                                                v-model="form.box_orden"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Editar subtotal en caja
                                            </label>
                                            <el-switch
                                                v-model="form.edit_subtotal_box"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Enviar XML por whatsapp
                                            </label>
                                            <el-switch
                                                v-model="form.xml_whatsapp"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Mostrar politica precios ticket
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.show_unit_types_ticket
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Emitir dcto variacion
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.show_variation_dcto
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <template id="select-append">
                                            <label class="control-label w-100"
                                                >Producto - Variacion
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
                                                    @change="changeItem"
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
                                                    :loading="loading_search"
                                                >
                                                    <el-option
                                                        v-for="option in items"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.full_description ||
                                                                option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div
                                            class="form-group"
                                            :class="{
                                                'has-danger':
                                                    errors.affectation_igv_type_id
                                            }"
                                        >
                                            <label class="control-label"
                                                >(Modulo de Mozo) Busqueda de
                                                Producto por
                                            </label>
                                            <el-select
                                                v-model="form.search_type"
                                                @change="submit"
                                                filterable
                                            >
                                                <el-option
                                                    label="Buscar por Descripcion"
                                                    value="0"
                                                ></el-option>
                                                <el-option
                                                    label="Buscar por Codigo interno"
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
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >(Mod. Caja) Mostrar stock
                                                almacénes
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.show_stock_establishment_box
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Usar número personal (whatsapp)
                                            </label>
                                            <el-switch
                                                v-model="form.personal_phone"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Recibir mercaderia (caja)
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.receive_merchandise
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Imprimir referencia en ticket
                                            </label>
                                            <el-switch
                                                v-model="form.reference_ticket"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Crédito nota de venta
                                            </label>
                                            <el-switch
                                                v-model="form.credits"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >% de crédito
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
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Mostrar guías en caja
                                            </label>
                                            <el-switch
                                                v-model="form.dispatch"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Mostrar cotización en caja
                                            </label>
                                            <el-switch
                                                v-model="form.quotation"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Cargo por pago con tarjeta
                                            </label>
                                            <el-switch
                                                v-model="form.credit_mode"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Pedir pin en caja al eliminar
                                                orden
                                            </label>
                                            <el-switch
                                                v-model="form.pin_orden_delete"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Enviar whatsapp al eliminar
                                                orden
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.send_whatsapp_activity
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >N° de whatsapp para enviar
                                                actividad
                                            </label>
                                            <el-input
                                                @input="changeNumberActivity"
                                                v-model="form.number_activity"
                                            >
                                            </el-input>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Categorias arrastables caja
                                            </label>
                                            <el-switch
                                                v-model="form.pos_drag_category"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Editar producto en caja
                                            </label>
                                            <el-switch
                                                v-model="form.edit_product_pos"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Imprimir gastos/ingresos
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.print_incomes_expenses
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Ver venta diaria
                                            </label>
                                            <el-switch
                                                v-model="form.view_daily_cash"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Ver venta diaria con pin
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.view_daily_cash_pin
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Enviar whatsapp al ver venta
                                                diaria
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.send_whatsapp_daily_cash
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Bloquear stock inicial
                                                <el-tooltip
                                                    content="Stock inicial 0 en formulario de producto"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch
                                                v-model="form.init_stock"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Observación al hacer ajuste de
                                                stock

                                                <el-tooltip
                                                    content="Obligar a dar razón del traslado"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch
                                                v-model="
                                                    form.observation_translate
                                                "
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Consignación

                                                <el-tooltip
                                                    content="Crear y liquidar consignaciones desde caja"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch
                                                v-model="form.consignment"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <template id="select-append">
                                            <label class="control-label w-100"
                                                >Producto penalidad -
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
                                                    @change="changeItem"
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
                                                    :loading="loading_search"
                                                >
                                                    <el-option
                                                        v-for="option in items"
                                                        :key="option.id"
                                                        :value="option.id"
                                                        :label="
                                                            option.full_description ||
                                                                option.description
                                                        "
                                                    ></el-option>
                                                </el-select>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Cambiar afectación IGV en caja

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
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Traslados directos

                                                <el-tooltip
                                                    content="Sin necesidad de insertar clave y/o código"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch
                                                v-model="form.translate_direct"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Descuentos variante

                                                <el-tooltip
                                                    content="Permite recalcular el precio de venta de un producto con descuento a la base"
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
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Evitar cerrar caja sin ordenes
                                                pendientes

                                                <el-tooltip
                                                    content="Alerta sobre las mesas pendientes al cerrar caja, es posible emitir una nota de venta por todo"
                                                >
                                                    <i
                                                        class="fa fa-info-circle"
                                                    ></i>
                                                </el-tooltip>
                                            </label>
                                            <el-switch
                                                v-model="form.ordens_cash"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Crear productos compuestos en
                                                caja
                                            </label>
                                            <el-switch
                                                v-model="form.item_set_caja"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Ver productos por vencer en
                                                caja
                                            </label>
                                            <el-switch
                                                v-model="form.items_due_caja"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Mostrar toda la descripción del
                                                producto en caja
                                            </label>
                                            <el-switch
                                                v-model="form.trunc_txt"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Ordenar productos por
                                                descripción caja
                                            </label>
                                            <el-switch
                                                v-model="form.ord_dscp"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Visualizar administrador -
                                                usuarios
                                            </label>
                                            <el-switch
                                                v-model="form.users_views"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Impresion">
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label class="control-label w-100">
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
                                            v-model="form.new_old_printer"
                                            active-text="Si"
                                            inactive-text="No"
                                            @change="submit"
                                        ></el-switch>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="control-label w-100">
                                            Orientación A5
                                        
                                        </label>
                                        <el-switch
                                            v-model="form.a5_orientation"
                                            active-text="Horizontal"
                                            inactive-text="Vertical"
                                            @change="submit"
                                        ></el-switch>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Modos">
                                <div class="row">
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Caja - colegio
                                            </label>
                                            <el-switch
                                                v-model="form.college"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Entorno Restaurant</label
                                            >
                                            <el-switch
                                                v-model="form.restaurant"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Entorno Internet</label
                                            >
                                            <el-switch
                                                v-model="form.internet"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <div class="form-group">
                                            <label class="control-label w-100"
                                                >Entorno Peaje</label
                                            >
                                            <el-switch
                                                v-model="form.toll"
                                                active-text="Si"
                                                inactive-text="No"
                                                @change="submit"
                                            ></el-switch>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Promociones">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label w-100">
                                            Modo Promociones
                                            <el-tooltip
                                                class="item"
                                                effect="dark"
                                                content="Visualiza en el modulo de caja y administrativo el modulo que permite que por cada compra se pueda hacer una promocion, llegando a xs items vendidos"
                                                placement="top-start"
                                            >
                                                <i
                                                    class="fa fa-info-circle"
                                                ></i>
                                            </el-tooltip>
                                        </label>
                                        <el-switch
                                            v-model="form.promotions_sell"
                                            active-text="Si"
                                            inactive-text="No"
                                            @change="submit"
                                        ></el-switch>
                                    </div>
                                    <div class="col-md-6">
                                        <el-input
                                            v-model="
                                                form.promotions_cant_purchase
                                            "
                                            placeholder="cantidad de ventas para acceder a la promosion "
                                            size="normal"
                                            @blur="submit"
                                        ></el-input>
                                    </div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
//  import TermsCondition from '@views/quotations/partials/terms_condition.vue'

export default {
    props: ["typeUser"],
    //  components: {TermsCondition},
    //
    data() {
        return {
            loading_search: false,
            showDialogTermsCondition: false,
            loading_submit: false,
            resource: "configurations",
            errors: {},
            form: {},
            affectation_igv_types: [],
            placeholder: "",
            items: [],
            days: [
                { id: 1, value: 1 },
                { id: 2, value: 2 },
                { id: 3, value: 3 },
                { id: 4, value: 4 },
                { id: 5, value: 5 },
                { id: 6, value: 6 },
                { id: 7, value: 7 }
            ]
        };
    },
    async created() {
        await this.loadTables();
        await this.initForm();

        await this.$http.get(`/${this.resource}/record`).then(response => {
            if (response.data !== "") {
                this.form = response.data.data;
            }
            // console.log(this.placeholder)
        });
    },
    methods: {
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
                        this.items = response.data.items;
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
        }
    }
};
</script>
