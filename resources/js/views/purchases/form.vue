<!-- Modulo de Nueva Compra -->
<template>
<div class="card mb-0 pt-2 pt-md-0">
    <div class="card-header bg-primary d-flex align-items-center" style="padding: 15px;">
        <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1.5rem; font-weight: bold;">
            <i class="fas fa-coins" style="font-size: 2rem; margin-right: 0.5rem;"></i>
            Nueva Compra
        </h4>
    </div>
    <div class="tab-content p-3">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group" :class="{'has-danger': errors.document_type_id}">
                            <label class="form-label font-weight-bold text-primary d-flex align-items-center">
                                <i class="fas fa-file-invoice mr-2"></i> Tipo de Comprobante
                                <el-tooltip content="Campo Obligatorio: debe seleccionar un tipo de comprobante" placement="top-end">
                                    <span class="text-danger ml-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </span>
                                </el-tooltip>
                            </label>
                            <!-- Select con estilos personalizados -->
                            <el-select v-model="form.document_type_id" @change="changeDocumentType" placeholder="Seleccione tipo de comprobante" class="custom-select">
                                <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <!-- Mensaje de error -->
                            <small class="text-danger" v-if="errors.document_type_id" v-text="errors.document_type_id[0]"></small>
                        </div>
                    </div>
                    <template v-if="form.document_type_id != 'GU75'">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{ 'has-danger': errors.series }">
                                <label class="control-label font-weight-bold">
                                    <i class="fas fa-layer-group"></i>
                                    Serie
                                    <el-tooltip content="Campo Obligatorio">
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span>
                                    </el-tooltip>
                                </label>
                                <el-input v-model="form.series" :readonly="
                                            this.form.document_type_id == 'NE76'
                                        ">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>

                                <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{ 'has-danger': errors.number }">
                                <label class="control-label font-weight-bold">
                                    <i class="fas fa-list-ol"></i>
                                    Número
                                    <el-tooltip content="Campo Obligatorio">
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span>
                                    </el-tooltip>
                                </label>
                                <el-input v-model="form.number" :readonly="
                                            this.form.document_type_id == 'NE76'
                                        ">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>

                                <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
                            </div>
                        </div>
                    </template>

                    <template v-if="form.document_type_id == 'GU75'">
                        <div class="col-lg-2">
                            <div class="form-group" :class="{
                                        'has-danger': errors.series_guia
                                    }">
                                <label class="control-label font-weight-bold">
                                    <i class="fas fa-layer-group"></i>
                                    Serie Guía
                                    <el-tooltip content="Campo Obligatorio">
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span>
                                    </el-tooltip>
                                </label>
                                <el-input v-model="form.series_guia">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>

                                <small class="form-control-feedback" v-if="errors.series_guia" v-text="errors.series_guia[0]"></small>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group" :class="{
                                        'has-danger': errors.number_guia
                                    }">
                                <label class="control-label font-weight-bold">
                                    <i class="fas fa-list-ol"></i>
                                    Número Guía
                                    <el-tooltip content="Campo Obligatorio">
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span>
                                    </el-tooltip>
                                </label>
                                <el-input v-model="form.number_guia">
                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                </el-input>

                                <small class="form-control-feedback" v-if="errors.number_guia" v-text="errors.number_guia[0]"></small>
                            </div>
                        </div>
                    </template>

                    <div class="col-lg-2">
                        <div class="form-group" :class="{ 'has-danger': errors.date_of_issue }">
                            <label class="control-label">
                                <i class="fas fa-calendar-check red-icon"></i>
                                F. Emisión
                            </label>
                            <el-date-picker v-model="form.date_of_issue" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                            <small class="form-control-feedback" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group" :class="{ 'has-danger': errors.date_of_due }">
                            <label class="control-label">
                                <i class="fas fa-calendar-check red-icon"></i>
                                F. Vencimiento
                            </label>
                            <el-date-picker v-model="form.date_of_due" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                            <small class="form-control-feedback" v-if="errors.date_of_due" v-text="errors.date_of_due[0]"></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{ 'has-danger': errors.supplier_id }">
                            <label class="control-label">
                                <i class="fas fa-user-cog red-icon"></i>
                                <i class="fas fa-network-wired red-icon"></i>
                                Proveedor
                                <a href="#" @click.prevent="
                                            showDialogNewPerson = true
                                        ">[+ Nuevo]</a>
                            </label>
                            <el-select v-model="form.supplier_id" filterable @change="changeSupplier" ref="select_person" @keyup.native="keyupSupplier" @keyup.enter.native="keyupEnterSupplier">
                                <el-option v-for="option in suppliers" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.supplier_id" v-text="errors.supplier_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" :class="{
                                    'has-danger': errors.currency_type_id
                                }">
                            <label class="control-label">
                                <i class="fas fa-coins red-icon"></i>
                                Moneda
                            </label>
                            <el-select v-model="form.currency_type_id" @change="changeCurrencyType">
                                <el-option v-for="option in currency_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.currency_type_id" v-text="errors.currency_type_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" :class="{
                                    'has-danger': errors.exchange_rate_sale
                                }">
                            <label class="control-label">
                                <i class="fas fa-exchange-alt red-icon"></i>
                                Tipo de cambio
                                <el-tooltip class="item" effect="dark" content="Tipo de cambio del día, extraído de SUNAT" placement="top-end">
                                    <i class="fa fa-info-circle"></i>
                                </el-tooltip>
                            </label>
                            <el-input v-model="form.exchange_rate_sale">
                                <i slot="prefix" class="el-icon-edit-outline"></i>
                            </el-input>
                            <small class="form-control-feedback" v-if="errors.exchange_rate_sale" v-text="errors.exchange_rate_sale[0]"></small>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group" :class="{
                                    'has-danger': errors.exchange_rate_sale
                                }">
                            <label class="control-label">Incluye IGV</label>
                            <br />
                            <el-switch active-text="Si" v-model="form.includes" inactive-text="No" @change="incluye_igv()"></el-switch>
                            <small class="form-control-feedback" v-if="errors.includes" v-text="errors.includes[0]"></small>
                        </div>
                    </div>

                    <!-- <div class="col-md-8 mt-4">
                        <div class="form-group">
                            <el-checkbox v-model="form.has_client" @change="changeHasClient">¿Desea agregar el cliente para esta
                                compra?</el-checkbox>
                        </div>
            </div>-->
                    <div class="row align-items-center mb-4">
                        <!-- Checkbox para agregar pagos -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <el-checkbox v-model="form.has_payment" @change="changeHasPayment">
                                    ¿Desea agregar pagos a esta compra?
                                </el-checkbox>
                            </div>
                        </div>

                        <!-- Selector de Clientes -->
                        <div class="col-md-4" v-if="form.has_client">
                            <div class="form-group">
                                <label class="control-label font-weight-bold">Clientes</label>
                                <el-select v-model="form.customer_id" filterable remote popper-class="el-select-customers" clearable placeholder="Nombre o número de documento" :remote-method="searchRemotePersons" :loading="loading_search" class="custom-input">
                                    <el-option v-for="option in customers" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
                            </div>
                        </div>

                        <!-- Tabla de pagos -->
                        <div class="col-md-12" v-if="form.has_payment">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th>Forma de pago</th>
                                        <th>Destino</th>
                                        <th>Referencia</th>
                                        <th>Monto</th>
                                        <th>
                                            <a href="#" @click.prevent="clickAddPayment" class="text-white font-weight-bold">[+ Agregar]</a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in form.payments" :key="index">
                                        <!-- Forma de pago -->
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-select v-model="row.payment_method_type_id" @change="changePaymentMethodType(true, index)" class="custom-input">
                                                    <el-option v-for="option in payment_method_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                                </el-select>
                                            </div>
                                        </td>
                                        <!-- Destino -->
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-select v-model="row.payment_destination_id" filterable class="custom-input">
                                                    <el-option v-for="option in payment_destinations" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                                </el-select>
                                            </div>
                                        </td>
                                        <!-- Referencia -->
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-input v-model="row.reference" class="custom-input">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                                </el-input>
                                            </div>
                                        </td>
                                        <!-- Monto -->
                                        <td>
                                            <div class="form-group mb-0">
                                                <el-input v-model="row.payment" class="custom-input">
                                                    <i slot="prefix" class="el-icon-edit-outline"></i>
                                                </el-input>
                                            </div>
                                        </td>
                                        <!-- Acción: Eliminar -->
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm" @click.prevent="clickCancel(index)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botón Agregar Producto -->
                    <div class="col-lg-6 col-md-6 d-flex justify-content-start mt-4">
                        <div class="form-group">
                            <button type="button" class="btn btn-add-product" @click.prevent="showDialogAddItem = true" data-toggle="tooltip" title="Agrega un nuevo producto a la lista.">
                                <i class="fas fa-plus"></i> Agregar Producto
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex justify-content-end mt-4">
                        <div class="form-group">
                            <!-- Botón Restaurar -->
                            <button type="button" 
                                    v-if="form.items.length > 0"
                            class="btn btn-restore" @click="restoreApart" data-toggle="tooltip" title="Restaura la compra previamente aparcada.">
                                <i class="fas fa-recycle"></i>
                                Restaurar
                            </button>

                            <!-- Botón Aparcar -->
                            <button type="button" 
                                    v-if="form.items.length > 0"
                            class="btn btn-aparcar" @click.prevent="PurchaseApart" data-toggle="tooltip" title="Aparca temporalmente esta compra.">
                                <i class="fas fa-pause"></i>
                                Aparcar
                            </button>
                        </div>
                    </div>

                    <br />
                </div>
                <div class="row" v-if="form.items.length > 0">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr slot="heading" class="bg-primary">
                                        <th class="text-white">#</th>
                                        <th class="text-white">
                                            Descripción
                                        </th>
                                        <th class="text-white">Almacén</th>
                                        <th class="text-white text-center">
                                            Unidad
                                        </th>
                                        <th class="text-white text-end">
                                            Cantidad
                                        </th>
                                        <th class="text-white text-end">
                                            Costo Unitario
                                        </th>
                                        <th class="text-end text-white" v-if="form.includes == false">
                                            IGV
                                        </th>
                                        <th class="text-white text-end">
                                            Descuento
                                        </th>
                                        <th class="text-white text-end">
                                            Cargo
                                        </th>
                                        <th class="text-white text-end">
                                            Total
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in form.items" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            {{ row.item.internal_id }}-{{
                                                    row.item.description
                                                }}
                                            <br />
                                            <small>
                                                {{
                                                        row.affectation_igv_type
                                                            .description
                                                    }}
                                            </small>

                                            <template v-if="
                                                        row.lots &&
                                                            row.lots.length > 0
                                                    ">
                                                <br />
                                                <small class="text-primary" v-for="(lot,
                                                        index) in row.lots" :key="index">
                                                    <b>Serie:</b>
                                                    {{ lot.series }}
                                                </small>
                                            </template>

                                            <template v-if="
                                                        row.lots_group &&
                                                            row.lots_group
                                                                .length > 0
                                                    ">
                                                <br />
                                                <small class="text-primary" v-for="(lot,
                                                        index) in row.lots_group" :key="index">
                                                    <b>Lote:</b>
                                                    {{ lot.code }}
                                                </small>
                                            </template>

                                            <template v-if="
                                                        row.color_size &&
                                                            row.color_size
                                                                .length > 0
                                                    ">
                                                <br />
                                                <small class="text-primary" v-for="(color,
                                                        index) in row.color_size" :key="index">
                                                    <b>Color:</b>
                                                    {{ color.color }}
                                                    <b>Talla:</b>
                                                    {{ color.size }}
                                                </small>
                                            </template>
                                        </td>
                                        <td class="text-left">
                                            {{ row.warehouse_description }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.item.unit_type_id }}
                                        </td>
                                        <td class="text-end">
                                            {{ row.quantity }}
                                            <template v-if="row.real_quantity">({{
                                                        row.real_quantity
                                                    }})</template>
                                        </td>
                                        <td class="text-end">
                                            {{ currency_type.symbol }}
                                            {{
                                                    getFormatUnitPriceRow(
                                                        row.unit_price
                                                    )
                                                }}
                                        </td>
                                        <td class="text-end" v-if="form.includes == false">
                                            {{ row.unit_price_igv }}
                                        </td>
                                        <td class="text-end">
                                            {{ currency_type.symbol }}
                                            {{ row.total_discount }}
                                        </td>
                                        <td class="text-end">
                                            {{ currency_type.symbol }}
                                            {{ row.total_charge }}
                                        </td>

                                        <td class="text-end">
                                            {{ currency_type.symbol }}
                                            {{ row.total }}
                                            <!-- <el-input-number
                                                    v-model="row.total"
                                                    @input="inputTotal(index,true)"
                                                >
                        </el-input-number>-->
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="
                                                        clickRemoveItem(index)
                                                    ">
                                                x
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="text-end" v-if="form.total_exportation > 0">
                            OP.EXPORTACIÓN: {{ currency_type.symbol }}
                            {{ form.total_exportation }}
                        </p>
                        <p class="text-end" v-if="form.total_free > 0">
                            OP.GRATUITAS: {{ currency_type.symbol }}
                            {{ form.total_free }}
                        </p>
                        <p class="text-end" v-if="form.total_unaffected > 0">
                            OP.INAFECTAS: {{ currency_type.symbol }}
                            {{ form.total_unaffected }}
                        </p>
                        <p class="text-end" v-if="form.total_exonerated > 0">
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
                        <h6 class="text-end" v-if="form.total > 0">
                            <b>TOTAL COMPRAS:</b>
                            {{ currency_type.symbol }} {{ form.total }}
                        </h6>

                        <template v-if="is_perception_agent">
                            <hr />
                            <div class="row mt-1">
                                <div class="col-lg-10 float-right">
                                    <label class="float-right control-label">NÚMERO PERCEPCIÓN:</label>
                                </div>
                                <div class="col-lg-2 float-right">
                                    <div class="form-group" :class="{
                                                'has-danger':
                                                    errors.perception_number
                                            }">
                                        <el-input v-model="form.perception_number">
                                            <i slot="prefix" class="el-icon-edit-outline"></i>
                                        </el-input>

                                        <small class="form-control-feedback" v-if="errors.perception_number" v-text="
                                                    errors.perception_number[0]
                                                "></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-10 float-right">
                                    <label class="float-right control-label">FEC EMISIÓN PERCEPCIÓN:</label>
                                </div>
                                <div class="col-lg-2 float-right">
                                    <div class="form-group" :class="{
                                                'has-danger':
                                                    errors.perception_date
                                            }">
                                        <el-date-picker v-model="form.perception_date" type="date" value-format="yyyy-MM-dd" :clearable="false" @change="changeDateOfIssue"></el-date-picker>
                                        <small class="form-control-feedback" v-if="errors.perception_date" v-text="
                                                    errors.perception_date[0]
                                                "></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-lg-10 float-right">
                                    <label class="float-right control-label">IMPORTE PERCEPCIÓN:</label>
                                </div>
                                <div class="col-lg-2 float-right">
                                    <div class="form-group" :class="{
                                                'has-danger':
                                                    errors.total_perception
                                            }">
                                        <el-input v-model="form.total_perception" @input="inputTotalPerception" :readonly="true">
                                            <i slot="prefix" class="el-icon-edit-outline"></i>
                                        </el-input>

                                        <small class="form-control-feedback" v-if="errors.total_perception" v-text="
                                                    errors.total_perception[0]
                                                "></small>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-end" v-if="form.total > 0 && !hide_button">
                                <b>MONTO TOTAL :</b>
                                {{ currency_type.symbol }}
                                {{ total_amount }}
                            </h6>
                        </template>
                    </div>
                </div>
            </div>
            <!-- Botones de Cancelar y Generar -->
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <el-button class="btn-cancel btn-cancel:hover" icon="fas fa-times fa-lg" @click.prevent="close()">
                    <span> Cancelar</span>
                </el-button>
                <el-button class="btn-save btn-save:hover" icon="fas fa-cogs fa-lg" type="primary" native-type="submit" :loading="loading_submit" v-if="form.items.length > 0 && !hide_button">
                    <span> Generar</span>
                </el-button>
            </div>
        </form>
    </div>

    <purchase-form-item :showDialog.sync="showDialogAddItem" :includes.sync="includes" :currency-type-id-active="form.currency_type_id" :exchange-rate-sale="form.exchange_rate_sale" :percentage_igv="percentage_igv" @add="addRow"></purchase-form-item>

    <person-form :showDialog.sync="showDialogNewPerson" type="suppliers" :input_person="input_person" :external="true"></person-form>

    <purchase-options :showDialog.sync="showDialogOptions" :recordId="purchaseNewId" :showClose="false"></purchase-options>

    <pull-apart @restoreToLocalOrdens="restoreToLocalOrdens" :showPullApart.sync="listApart" :ordenInBox.sync="ordenInBox"></pull-apart>

    <!-- <aparcado :showDialog.sync="showAparcado"></aparcado> -->

    <el-dialog :visible="apartPurchases" :close-on-click-modal="false" :close-on-press-escape="false" title="Aparcar orden De Compras" @close="apartPurchases = false" width="30%">
        <br />
        <div class="p-2">
            <div class="col-md-12">
                <label class="control-label fw-bold">Datos Referenciales</label>
                <el-input v-model="numberCustomerApart" placeholder="Dni o Nombre"></el-input>
            </div>
            <br />
            <div class="d-flex justify-content-end">
                <button class="btn btn-light m-1" @click="apartPurchases = false">
                    Cancelar
                </button>
                <button class="btn btn-primary m-1" @click="pullApartOrden">

                    Aparcar
                </button>
            </div>
        </div>
        <br />
    </el-dialog>
</div>
</template>

<style>
/* Botón Agregar Producto */
.btn-add-product {
    background-color: #084587;
    /* Azul vibrante */
    box-shadow: 0 4px 6px rgba(0, 123, 255, 0.3);
    /* Sombra ligera */
    color: #fff;
    /* Letras blancas */
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    display: inline-flex;
    align-items: center;
}

.btn-add-product i {
    margin-right: 8px;
    /* Espacio entre el icono y el texto */
}

.btn-add-product:hover {
    background-color: #0056b3;
    /* Azul más oscuro */
    transform: scale(1.05);
    /* Aumenta ligeramente el tamaño */
    box-shadow: 0 6px 8px rgba(0, 86, 179, 0.4);
    /* Sombra más intensa */
}

.btn-add-product:active {
    transform: scale(0.95);
    /* Efecto de pulsación */
}

/* Estilo base para los botones */
.btn {
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    color: #fff;
    transition: all 0.3s ease-in-out;
    margin-left: 10px;
    position: relative;
    overflow: hidden;
    border: none;
    outline: none;
    cursor: pointer;
}

/* Botón Restaurar - Verde */
.btn-restore {
    background-color: #28a745;
    /* Verde */
    box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3);
}

.btn-restore:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.btn-restore:active {
    transform: scale(0.95);
}

/* Botón Aparcar - Naranja */
.btn-aparcar {
    background-color: #fd7e14;
    /* Naranja */
    box-shadow: 0 4px 6px rgba(253, 126, 20, 0.3);
}

.btn-aparcar:hover {
    background-color: #e36c0a;
    transform: scale(1.05);
}

.btn-aparcar:active {
    transform: scale(0.95);
}

/* Tooltip personalizado */
[data-toggle="tooltip"] {
    position: relative;
}

[data-toggle="tooltip"]::after {
    content: attr(title);
    position: absolute;
    bottom: 150%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 4px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease-in-out;
}

[data-toggle="tooltip"]:hover::after {
    opacity: 1;
    visibility: visible;
}

/* Estilos generales */
.form-group {
    margin-bottom: 0.5rem;
}

.custom-input {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border 0.3s ease-in-out;
}

.custom-input:focus,
.custom-input:hover {
    border-color: #007bff;
    outline: none;
}

/* Estilo para la tabla */
.table {
    width: 100%;
    margin: 0;
}

.table thead th {
    background-color: #195580;
    /* Azul */
    color: #fff;
    /* Letras blancas */
    text-align: center;
    font-weight: bold;
    padding: 0.75rem;
}

.table tbody td {
    vertical-align: middle;
    padding: 0.5rem;
}

/* Botón de agregar en el encabezado */
a.text-white {
    text-decoration: none;
}

/* Botón eliminar */
.btn-danger {
    border-radius: 5px;
}
</style>

<script>
import PurchaseFormItem from "./partials/item.vue";
import CardPerdido from "./partials/pedido_btn.vue";
import _ from "lodash";
import PersonForm from "../persons/form.vue";
import PurchaseOptions from "./partials/options.vue";
import PullApart from "./parked.vue";
import {
    functions,
    exchangeRate
} from "../../mixins/functions";
import {
    calculateRowItem
} from "../../helpers/functions";

export default {
    props: ["purchase_order_id", "is_arca"],
    components: {
        PurchaseFormItem,
        PersonForm,
        PurchaseOptions,
        CardPerdido,
        PullApart
    },
    mixins: [functions, exchangeRate],
    data() {
        return {
            listApart: false,
            ordenInBox: [],
            apartPurchases: false,
            numberCustomerApart: null,
            apartPurchases: false,
            showAparcado: false,
            input_person: {},
            resource: "purchases",
            showDialogAddItem: false,
            showDialogNewPerson: false,
            showDialogOptions: false,
            loading_submit: false,
            hide_button: false,
            is_perception_agent: false,
            errors: {},
            aux_supplier_id: null,
            total_amount: 0,
            document_types: [],
            currency_types: [],
            discount_types: [],
            charges_types: [],
            payment_method_types: [],
            all_suppliers: [],
            suppliers: [],
            all_customers: [],
            customers: [],
            company: null,
            operation_types: [],
            establishment: {},
            all_series: [],
            series: [],
            payment_destinations: [],
            currency_type: {},
            loading_search: false,
            purchaseNewId: null,
            includes: false,
            number: null,
            category_name: null,
            restaurant_name: null,
            time: null,
            status: false,
            array_estados: [],
            array_pedidos: [],
            timestamp: 0,
            listar_pedidos: [],
            data: [],
            form: {
                series_guia: "",
                number_guia: ""
            },
            percentage_igv: null
        };
    },
    mounted() {},
    async created() {
        //     setInterval(this.getNow, 1000);
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.document_types = response.data.document_types_invoice;
            this.currency_types = response.data.currency_types;
            this.establishment = response.data.establishment;
            this.all_suppliers = response.data.suppliers;
            this.discount_types = response.data.discount_types;
            this.payment_method_types = response.data.payment_method_types;
            this.payment_destinations = response.data.payment_destinations;
            this.payment_destinations = this.payment_destinations.filter(
                item => item != null
            );
            if (this.payment_destinations.length == 0) {}
            console.log(
                "🚀 ~ awaitthis.$http.get ~ this.payment_destinations:",
                this.payment_destinations
            );

            this.all_customers = response.data.customers;
            this.charges_types = response.data.charges_types;
            this.form.currency_type_id =
                this.currency_types.length > 0 ?
                this.currency_types[0].id :
                null;
            this.form.establishment_id = this.establishment.id ?
                this.establishment.id :
                null;
            this.form.document_type_id =
                this.document_types.length > 0 ?
                this.document_types[0].id :
                null;
            this.array_pedidos = response.data.pedidos;
            this.array_estados = response.data.estados;

            this.changeDateOfIssue();
            this.changeDocumentType();
            this.changeCurrencyType();
        });
        this.form.has_payment = true;
        this.clickAddPayment();
        this.$eventHub.$on("reloadDataPersons", supplier_id => {
            this.reloadDataSuppliers(supplier_id);
        });

        this.$eventHub.$on("initInputPerson", () => {
            this.initInputPerson();
        });

        await this.filterCustomers();
        await this.isGeneratePurchaseOrder();
        await this.changeHasPayment();
        await this.changeHasClient();
        let form_data = {
            establishment_id: this.form.establishment_id,
            date: moment().format("YYYY-MM-DD")
        };
        const response = await this.$http.post("/get_igv", form_data);
        this.percentage_igv = response.data;
    },
    methods: {
        /* restoreToLocalOrdens(products) {
          this.$emit("update:localOrden", products);
        }, */
        restoreToLocalOrdens(restoredProducts) {
            // Agrega los productos restaurados a la lista principal
            this.form.items = [...this.form.items, ...restoredProducts];
            this.calculateTotal(); // Recalcula el total si aplica
            this.$toast.success("Productos restaurados correctamente");
        },
        restoreApart() {
            let data = JSON.parse(localStorage.getItem("purchaseOrdens")) || [];
            this.ordenInBox = data.map(aparted => ({
                ...aparted,
                products: aparted.products || []
            }));

            if (this.ordenInBox.length > 0) {
                this.listApart = true;
            } else {
                this.$showSAlert(
                    "ALERTA",
                    "No hay compras aparcadas",
                    "warning"
                );
            }
        },
        /* para realizar el aparcado de compras */
        pullApartOrden() {
            if (
                !this.numberCustomerApart ||
                this.numberCustomerApart.length <= 1
            ) {
                this.$showSAlert(
                    "ALERTA",
                    "Debe ingresar un nombre o referencia válida",
                    "error"
                );
                return;
            }

            if (this.form.items.length == 0) {
                this.$showSAlert(
                    "ALERTA",
                    "No hay productos para aparcar",
                    "error"
                );
                return;
            }

            if (this.ordenInBox.length >= 15) {
                this.$showSAlert(
                    "ALERTA",
                    "Límite de aparcamientos excedido.",
                    "error"
                );
                return;
            }

            if (
                this.ordenInBox.some(
                    f =>
                    f.ref.toLowerCase() ===
                    this.numberCustomerApart.toLowerCase()
                )
            ) {
                this.$showSAlert("ALERTA", "La referencia ya existe", "error");
                return;
            }

            this.ordenInBox.push({
                ref: this.numberCustomerApart,
                products: this.form.items
            });

            try {
                localStorage.setItem(
                    "purchaseOrdens",
                    JSON.stringify(this.ordenInBox)
                );
                this.$showSAlert(
                    "APARCADO",
                    "Productos aparcados correctamente",
                    "success"
                );
            } catch (error) {
                console.error("Error guardando en localStorage:", error);
                this.$showSAlert(
                    "ALERTA",
                    "Error al guardar en el almacenamiento local.",
                    "error"
                );
            }

            this.numberCustomerApart = "";
            this.form.items = [];
            this.apartPurchases = false;
            this.$emit("cancelOrden");
        },
        /* para validar el yu verificar antes si hay productos a aparcar */
        PurchaseApart() {
            if (
                !this.form ||
                !Array.isArray(this.form.items) ||
                this.form.items.length === 0
            ) {
                this.$showSAlert(
                    "ALERTA",
                    "No tienes órdenes en la lista para aparcar",
                    "error"
                );
            } else {
                this.apartPurchases = true;
            }
        },
        ifIsArca() {
            if (this.is_arca) {}
        },

        // inputTotal(idx,updateTotal = false) {

        //     let item = this.form.items[idx];
        //     let unit_value = item.unit_price;
        //     item.unit_price = item.total / item.quantity;
        //     item.total_base_igv = item.total;

        //     let total_value_partial = unit_value * item.quantity;
        //     if (item.affectation_igv_type_id == "10") {
        //         unit_value = item.unit_price / (1 + this.percentage_igv / 100);
        //         item.unit_price = _.round(unit_value, 2);
        //         total_value_partial = unit_value * item.quantity;
        //         item.unit_price_igv =
        //             item.unit_price * (this.percentage_igv / 100);
        //         item.unit_price_igv = parseFloat(item.unit_price_igv).toFixed(
        //             2
        //         );
        //         item.total_base_igv =
        //             item.total / (1 + this.percentage_igv / 100);
        //         item.total_igv =
        //             (total_value_partial * this.percentage_igv) / 100;
        //     } else {
        //         item.unit_price_igv = 0;
        //         item.total_igv = 0;
        //     }
        //     let total = total_value_partial + item.total_igv;
        //     item.total_value = _.round(total_value_partial, 2);
        //     item.total_base_igv = _.round(total_value_partial, 2);
        //     item.total_igv = _.round(item.total_igv, 2);
        //     item.total_taxes = _.round(item.total_igv, 2);
        //     if(updateTotal){

        //         item.total = _.round(total, 2);
        //     }
        //     this.form.items[idx] = item;

        //     this.calculateTotal();
        // },
        updateQuantity() {
            let {
                items
            } = this.form;

            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                if (item.real_quantity > 0) {
                    item.quantity = item.real_quantity;
                }
            }
            this.form.items = items;
        },
        changeHasPayment() {
            if (!this.form.has_payment) {
                this.form.payments = [];
            }
        },
        incluye_igv() {
            this.includes = this.form.includes;
            this.calculateTotal();
        },

        changeHasClient() {
            if (!this.form.has_client) {
                this.form.customer_id = null;
            }
        },
        searchRemotePersons(input) {
            if (input.length > 1) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                this.$http
                    .get(`/reports/data-table/persons/customers?${parameters}`)
                    .then(response => {
                        this.customers = response.data.persons;
                        this.loading_search = false;

                        if (this.customers.length == 0) {
                            this.filterCustomers();
                        }
                    });
            } else {
                this.filterCustomers();
            }
        },
        filterCustomers() {
            this.customers = this.all_customers;
        },
        getFormatUnitPriceRow(unit_price) {
            return _.round(unit_price, 6);
            // return unit_price.toFixed(6)
        },
        async isGeneratePurchaseOrder() {
            // console.log(this.purchase_order_id)
            if (this.purchase_order_id) {
                await this.$http
                    .get(`/purchase-orders/record/${this.purchase_order_id}`)
                    .then(response => {
                        // console.log(response)

                        let purchase_order = response.data.data.purchase_order;
                        let warehouse = response.data.data.warehouse;
                        let supp = purchase_order.supplier;

                        if (supp.identity_document_type_id == 6) {
                            this.form.document_type_id = "01";
                        } else if (supp.identity_document_type_id == 1) {
                            this.form.document_type_id = "03";
                        }

                        // console.log(purchase_order.supplier_id)

                        this.form.items =
                            response.data.data.purchase_order.items;
                        this.form.supplier_id = purchase_order.supplier_id;
                        this.form.currency_type_id =
                            purchase_order.currency_type_id;
                        this.form.purchase_order_id = purchase_order.id;
                        this.form.payments[0].payment_method_type_id =
                            purchase_order.payment_method_type_id;
                        this.form.payments[0].payment = purchase_order.total;
                        this.form.total = purchase_order.total;
                        this.currency_type = _.find(this.currency_types, {
                            id: this.form.currency_type_id
                        });

                        this.form.items.forEach(it => {
                            it.warehouse_id = warehouse.id;
                            it.charges = it.charges ?
                                Object.values(it.charges) : [];
                            it.attributes = it.attributes ?
                                Object.values(it.attributes) : [];
                            it.discounts = it.discounts ?
                                Object.values(it.discounts) : [];
                        });
                        // this.changeDocumentType()
                    });
            }
        },
        async validate_payments() {
            let error_by_item = 0;
            let acum_total = 0;
            let q_affectation_free = 0;

            await this.form.payments.forEach(item => {
                acum_total += parseFloat(item.payment);
                if (item.payment <= 0 || item.payment == null) error_by_item++;
            });

            //determinate affectation igv
            await this.form.items.forEach(item => {
                if (item.affectation_igv_type.free) {
                    q_affectation_free++;
                }
            });

            let all_free =
                q_affectation_free == this.form.items.length ? true : false;

            if (
                !all_free &&
                (acum_total > parseFloat(this.form.total) || error_by_item > 0)
            ) {
                return {
                    success: false,
                    message: "Los montos ingresados superan al monto a pagar o son incorrectos"
                };
            }

            if (this.form.has_client && !this.form.customer_id) {
                return {
                    success: false,
                    message: "Debe seleccionar un cliente"
                };
            }

            if (this.form.has_payment && this.form.payments.length == 0) {
                return {
                    success: false,
                    message: "Debe registrar al menos un pago"
                };
            }

            return {
                success: true,
                message: null
            };
        },
        clickCancel(index) {
            this.form.payments.splice(index, 1);
        },
        clickAddPayment() {
            this.form.payments.push({
                id: null,
                purchase_id: null,
                date_of_payment: moment().format("YYYY-MM-DD"),
                payment_method_type_id: "01",
                reference: null,
                payment_destination_id: this.payment_destinations.length == 0 ? null : "cash",
                payment: 0
            });
        },
        initInputPerson() {
            this.input_person = {
                number: "",
                identity_document_type_id: ""
            };
        },
        keyupEnterSupplier() {
            if (this.input_person.number) {
                if (!isNaN(parseInt(this.input_person.number))) {
                    switch (this.input_person.number.length) {
                        case 8:
                            this.input_person.identity_document_type_id = "1";
                            this.showDialogNewPerson = true;
                            break;

                        case 11:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                        default:
                            this.input_person.identity_document_type_id = "6";
                            this.showDialogNewPerson = true;
                            break;
                    }
                }
            }
        },
        keyupSupplier(e) {
            if (e.key !== "Enter") {
                this.input_person.number = this.$refs.select_person.$el.getElementsByTagName(
                    "input"
                )[0].value;
                let exist_persons = this.suppliers.filter(supplier => {
                    let pos = supplier.description.search(
                        this.input_person.number
                    );
                    return pos > -1;
                });

                this.input_person.number =
                    exist_persons.length == 0 ? this.input_person.number : null;
            }
        },
        inputSeries() {
            const pattern = new RegExp("^[A-Z0-9]+$", "i");
            if (!pattern.test(this.form.series)) {
                this.form.series = this.form.series.substring(
                    0,
                    this.form.series.length - 1
                );
            } else {
                this.form.series = this.form.series;
            }
        },
        changePaymentMethodType(flag_submit = true, index = null) {
            let payment_method_type = _.find(this.payment_method_types, {
                id: this.form.payments[index].payment_method_type_id
            });
            if (payment_method_type.number_days) {
                this.form.date_of_issue = moment()
                    .add(payment_method_type.number_days, "days")
                    .format("YYYY-MM-DD");
                this.changeDateOfIssue();
            } else {
                if (flag_submit) {
                    this.form.date_of_issue = moment().format("YYYY-MM-DD");
                    this.changeDateOfIssue();
                }
            }
        },
        inputTotalPerception() {
            this.total_amount =
                parseFloat(this.form.total) +
                parseFloat(this.form.total_perception);
            if (isNaN(this.total_amount)) {
                this.hide_button = true;
            } else {
                this.hide_button = false;
            }
        },
        changeSupplier() {
            this.calculatePerception();
        },
        filterSuppliers() {
            if (this.form.document_type_id === "01") {
                this.suppliers = _.filter(this.all_suppliers, {
                    identity_document_type_id: "6"
                });
                this.selectSupplier();
            } else {
                this.suppliers = this.all_suppliers; //_.filter(this.all_suppliers, (c) => { return c.identity_document_type_id !== '6' })
                this.selectSupplier();
            }
        },
        selectSupplier() {
            let supplier = _.find(this.suppliers, {
                id: this.aux_supplier_id
            });
            this.form.supplier_id = supplier ? supplier.id : null;
            this.aux_supplier_id = null;
        },
        initForm() {
            this.errors = {};
            this.form = {
                establishment_id: null,
                document_type_id: null,
                series: null,
                number: null,
                series_guia: null,
                number_guia: null,
                date_of_issue: moment().format("YYYY-MM-DD"),
                time_of_issue: moment().format("HH:mm:ss"),
                supplier_id: null,
                payment_method_type_id: "01",
                currency_type_id: null,
                purchase_order: null,
                exchange_rate_sale: 0,
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
                perception_date: null,
                perception_number: null,
                total_perception: 0,
                date_of_due: moment().format("YYYY-MM-DD"),
                items: [],
                charges: [],
                discounts: [],
                attributes: [],
                guides: [],
                payments: [],
                customer_id: null,
                has_client: false,
                has_payment: false,
                includes: false
            };
            // this.clickAddPayment();

            this.initInputPerson();
        },
        resetForm() {
            this.initForm();
            this.form.currency_type_id =
                this.currency_types.length > 0 ?
                this.currency_types[0].id :
                null;
            this.form.establishment_id = this.establishment.id;
            this.form.document_type_id =
                this.document_types.length > 0 ?
                this.document_types[0].id :
                null;

            this.changeDateOfIssue();
            this.changeDocumentType();
            this.changeCurrencyType();
            this.ifIsArca();
        },
        changeDateOfIssue() {
            this.form.date_of_due = this.form.date_of_issue;
            this.searchExchangeRateByDate(this.form.date_of_issue).then(
                response => {
                    this.form.exchange_rate_sale = response;
                }
            );
        },
        async changeDocumentType() {
            if (
                this.form.document_type_id == "GU75" ||
                this.form.document_type_id == "NE76"
            ) {
                this.form.series = "";
                this.form.number = "0";
                if (this.form.document_type_id == "NE76") {
                    await this.getCorrelative();
                }
            } else {
                this.form.series = null;
                this.form.number = null;
            }
            this.filterSuppliers();
        },
        async getCorrelative() {
            try {
                const response = await this.$http.get(`ne76/correlative`);
                if (response.status === 200) {
                    this.form.series = response.data.series;
                    this.form.number = response.data.number;
                }
            } catch (e) {
                console.log(e);
            }
        },
        addRow(row) {
            console.log("🚀 ~ addRow ~ row:", row);
            this.form.items.push(row);
            this.calculateTotal();
        },
        clickRemoveItem(index) {
            this.form.items.splice(index, 1);
            this.calculateTotal();
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
            let unit_price_igv = 0;
            if (this.form.includes == true) {
                unit_price_igv = 0;
            }
            //

            this.form.items.forEach(row => {
                total_discount += parseFloat(row.total_discount);
                total_charge += parseFloat(row.total_charge);

                if (row.affectation_igv_type_id == "10") {
                    if (
                        this.form.includes == 0 ||
                        this.form.includes == false
                    ) {
                        console.log(row.unit_price_igv, "mk unit_price_igv");
                        if (
                            row.unit_price_igv === 0 ||
                            row.unit_price_igv === undefined
                        ) {
                            let igv_item = row.unit_price * row.quantity;
                            console.log(igv_item, " igv_item");
                            row.unit_price_igv =
                                igv_item * (this.percentage_igv / 100);
                            console.log(row.unit_price_igv, " unit_price_igv");
                        } else {
                            unit_price_igv = 0;
                        }
                    }

                    if (this.form.includes == false) {
                        total_taxed += parseFloat(row.total);
                    } else {
                        total_taxed += parseFloat(row.total_value);
                    }
                }
                if (row.affectation_igv_type_id === "20") {
                    total_exonerated += parseFloat(row.total_value);
                    row.unit_price_igv = 0;
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

                total_value += parseFloat(row.total_value);

                if (row.affectation_igv_type_id === "10") {
                    if (this.form.includes == false) {
                        total_igv += parseFloat(
                            row.total * (this.percentage_igv / 100)
                        );
                    } else {
                        total_igv += parseFloat(row.total_igv);
                    }
                }

                if (row.affectation_igv_type_id === "10") {
                    if (this.form.includes == false) {
                        total +=
                            parseFloat(row.total) +
                            parseFloat(row.unit_price_igv);
                    } else {
                        total += parseFloat(row.total);
                    }
                } else {
                    total += parseFloat(row.total);
                }
            });

            this.form.total_exportation = _.round(total_exportation, 2);
            this.form.total_taxed = _.round(total_taxed, 2);
            this.form.total_exonerated = _.round(total_exonerated, 2);
            this.form.total_unaffected = _.round(total_unaffected, 2);
            this.form.total_free = _.round(total_free, 2);
            this.form.total_igv = _.round(total_igv, 2);
            console.log("total igv", _.round(total_igv, 2));
            this.form.total_value = _.round(total_value, 2);
            this.form.total_taxes = _.round(total_igv, 2);

            // if(this.form.includes==false){
            //     this.form.total = _.round(total+this.form.total_igv, 2)
            //  }else{
            this.form.total = _.round(total, 2);
            //  }

            this.calculatePerception();

            // this.form.payments[0].payment = this.form.total
            this.setTotalDefaultPayment();
        },
        setTotalDefaultPayment() {
            if (this.form.payments.length > 0) {
                this.form.payments[0].payment = this.form.total;
            }
        },
        calculatePerception() {
            let supplier = _.find(this.all_suppliers, {
                id: this.form.supplier_id
            });

            if (supplier) {
                if (supplier.perception_agent) {
                    let total_perception = 0;
                    let quantity_item_perception = 0;
                    let total_amount = 0;
                    this.form.total_perception = 0;

                    this.form.perception_date = moment().format("YYYY-MM-DD");

                    this.form.items.forEach(row => {
                        quantity_item_perception += row.item.has_perception ?
                            1 :
                            0;
                        total_perception += row.item.has_perception ?
                            parseFloat(row.unit_price) *
                            parseFloat(row.quantity) *
                            (parseFloat(row.item.percentage_perception) / 100) :
                            0;
                    });

                    this.is_perception_agent =
                        quantity_item_perception > 0 ? true : false;
                    this.form.total_perception = _.round(total_perception, 2);
                    total_amount =
                        this.form.total +
                        parseFloat(this.form.total_perception);
                    this.total_amount = _.round(total_amount, 2);
                } else {
                    this.is_perception_agent = false;
                    this.form.perception_date = null;
                    this.form.perception_number = null;
                    this.form.total_perception = null;
                }
            }
        },
        async submit() {
            if (this.form.total == null || isNaN(this.form.total)) {
                this.form.total = 0;
            }
            if (this.form.items.length == 0) {
                this.$toast.error("Debe agregar al menos un item");
                return;
            }

            let validate = await this.validate_payments();
            if (!validate.success) {
                return this.$toast.error(validate.message);
            }
            /* if (!this.form.series || !this.form.number) {
                      return this.$toast.error(
                          "Serie/Número del documento es obligatorio."
                      );
                  }
                  if (!this.form.series_guia || !this.form.number_guia) {
                      return this.$toast.error(
                          "Serie/Número de la Guía es obligatorio."
                      );
                  } */

            if (this.form.document_type_id !== "GU75") {
                if (!this.form.series || !this.form.number) {
                    return this.$toast.error(
                        "Serie/Número del documento es obligatorio."
                    );
                }
            } else if (this.form.document_type_id === "GU75") {
                if (!this.form.series_guia || !this.form.number_guia) {
                    return this.$toast.error(
                        "Serie/Número de la Guía es obligatorio."
                    );
                }
            }
            this.loading_submit = true;

            // await this.changePaymentMethodType(false)
            this.updateQuantity();
            await this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        if (this.purchase_order_id) {
                            this.$message({
                                showClose: true,
                                message: `Compra registrada : ${response.data.data.number_full}`,
                                duration: 2 * 3000,
                                type: "success"
                            });

                            this.close();
                        } else {
                            this.resetForm();
                            this.purchaseNewId = response.data.data.id;
                            this.showDialogOptions = true;
                        }
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
        },
        close() {
            location.href = "/purchases";
        },
        reloadDataSuppliers(supplier_id) {
            this.$http
                .get(`/${this.resource}/table/suppliers`)
                .then(response => {
                    this.aux_supplier_id = supplier_id;
                    this.all_suppliers = response.data;
                    this.filterSuppliers();
                });
        }
    }
};
</script>
