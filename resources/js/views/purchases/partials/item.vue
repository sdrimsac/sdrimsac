<!-- Modal de Agregar Productos Compras -->
<template>
<!-- Modal de Agregar Productos Compras -->
<el-dialog :title="titleDialog" :visible="showDialog" @open="create" @close="close" :close-on-click-modal="false" width="70%">
    <form autocomplete="off" @submit.prevent="clickAddItem" @keydown.enter.prevent>
        <div class="form-body">
            <!-- Fila 1 -->
            <div class="row">
                <!-- <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.item_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-box"></i> Producto/Servicios
                                <a href="#" @click.prevent="showDialogNewItem = true">[+ Nuevo]</a> -
                            </label>
                            <div class="row">
                                <div class="col-md-11">
                                    <div
                                        class="el-input el-input-group el-input-group--append"
                                        style="display: flex;"
                                    >
                                        <el-select
                                            v-if="!barcode_lector"
                                            v-model="form.item_id"
                                            :loading="loading_search"
                                            :remote-method="searchRemoteItems"
                                            filterable
                                            placeholder="Buscar"
                                            remote
                                            @change="changeItem"
                                            style="flex: 1;"
                                        >
                                            <el-option
                                                v-for="option in items"
                                                :key="option.id"
                                                :value="option.id"
                                                :label="option.full_description"
                                            ></el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <el-tooltip
                                        class="item"
                                        effect="dark"
                                        content="Agregar Nuevo Producto o Servicio"
                                        placement="top"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            @click.prevent="
                                                showDialogNewItem = true
                                            "
                                            style="margin-left: 5px; height: 100%;"
                                        >
                                            <i class="fas fa-plus fa-xs"></i>
                                        </button>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>
                        <el-input
                            ref="input_barcode"
                            v-if="barcode_lector"
                            v-model="input_barcode"
                            placeholder="Buscar"
                            @input="searchItemsDebounce"
                        >
                        </el-input>
                        <el-checkbox v-model="barcode_lector">
                            Lector de código de barras
                        </el-checkbox>
                    </div> -->

                <div class="col-md-8">
                    <div class="form-group" :class="{ 'has-danger': errors.item_id }">
                        <label class="control-label">
                            <i class="fas fa-box"></i> Producto/Servicios
                        </label>
                        <div class="row">
                            <!-- Input principal -->
                            <div class="col-md-11">
                                <div class="el-input el-input-group el-input-group--append" style="display: flex;">
                                    <el-select v-if="!barcode_lector" v-model="form.item_id" :loading="loading_search" :remote-method="searchRemoteItems" filterable placeholder="Buscar" remote @change="changeItem" style="flex: 1;">
                                        <el-option v-for="option in items" :key="option.id" :value="option.id" :label="option.full_description"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <!-- Botón de "Agregar nuevo producto" -->
                            <div class="col-md-1">
                                <el-tooltip class="item" effect="dark" content="Agregar Nuevo Producto o Servicio" placement="top">
                                    <button type="button" class="btn btn-primary btn-sm" @click.prevent="
                                                showDialogNewItem = true
                                            " style="height: 100%;">
                                        <i class="fas fa-plus fa-xs"></i>
                                    </button>
                                </el-tooltip>
                            </div>
                        </div>
                    </div>
                    <!-- Input del lector de código de barras -->
                    <div class="row" v-if="barcode_lector" style="margin-top: 10px;">
                        <div class="col-md-11">
                            <el-input ref="input_barcode" v-model="input_barcode" placeholder="Buscar" @input="searchItemsDebounce" style="flex: 1;">
                            </el-input>
                        </div>
                        <div class="col-md-1">
                            <!-- <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Agregar Nuevo Producto o Servicio"
                                    placement="top"
                                >
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        @click.prevent="
                                            showDialogNewItem = true
                                        "
                                        style="height: 100%;"
                                    >
                                        <i class="fas fa-plus fa-xs"></i>
                                    </button>
                                </el-tooltip> -->
                        </div>
                    </div>
                    <!-- Checkbox del lector -->
                    <el-checkbox v-model="barcode_lector" style="margin-top: 10px;">
                        Lector de código de barras
                    </el-checkbox>
                </div>
                <div class="col-md-2 text-center">
                    <el-tooltip slot="append" class="item" effect="dark" content="Ver Stock del Producto" placement="bottom" :disabled="!form.item_id">
                        <div class="">
                            <label class="control-label"><i class="fas fa-warehouse"></i>
                                Stock</label>
                            <span>{{
                                    parseFloat(selectedProductStock).toFixed(2)
                                }}</span>
                        </div>
                    </el-tooltip>
                </div>
                <div class="col-md-2">
                    <label class="control-label"><i class="fas fa-dollar-sign"></i> P. de
                        venta</label>
                    <el-input style="width:100%;" v-model="form.sale_unit_price">
                    </el-input>
                </div>
            </div>
            <!-- Fila 2 -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-danger': errors.warehouse_id }">
                        <label class="control-label"><i class="fas fa-warehouse"></i> Almacén de
                            destino</label>
                        <el-select v-model="form.warehouse_id" filterable>
                            <el-option v-for="option in warehouses" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.warehouse_id" v-text="errors.warehouse_id[0]"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{
                                'has-danger': errors.affectation_igv_type_id
                            }">
                        <label class="control-label"><i class="fas fa-percentage"></i> Afectación
                            IGV</label>
                        <el-select v-model="form.affectation_igv_type_id" :disabled="!change_affectation_igv_type_id" filterable>
                            <el-option v-for="option in affectation_igv_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                        </el-select>
                        <el-checkbox v-model="change_affectation_igv_type_id">Editar</el-checkbox>
                        <small class="form-control-feedback" v-if="errors.affectation_igv_type_id" v-text="errors.affectation_igv_type_id[0]"></small>
                    </div>
                </div>
            </div>

            <!-- Fila 3 -->
            <div class="row" style="padding: 20px; justify-content: space-between;">
                <!-- Columna: Datos de Compra -->
                <div class="col-md-6" style="background-color: rgb(106, 158, 209); border-radius: 10px; padding: 20px;">
                    <h5 class="text-center font-weight-bold">
                        Datos de Compra
                    </h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" :class="{ 'has-danger': errors.quantity }">
                                <label class="control-label"><i class="fas fa-sort-numeric-up"></i>
                                    Cantidad</label>
                                <el-input style="width: 100%;" v-model="form.quantity" name="quantity" @input.native="onInput" @change="updateRealQuantity"></el-input>
                                <small class="form-control-feedback" v-if="errors.quantity" v-text="errors.quantity[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{ 'has-danger': errors.unit_price }">
                                <label class="control-label"><i class="fas fa-dollar-sign"></i>
                                    P.Unitario</label>
                                <el-input style="width: 100%;" v-model="form.unit_price" @input="updatePriceTotal"></el-input>
                                <small class="form-control-feedback" v-if="errors.unit_price" v-text="errors.unit_price[0]"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" :class="{
                                        'has-danger': errors.total_price
                                    }">
                                <label class="control-label"><i class="fas fa-dollar-sign"></i>
                                    Total</label>
                                <el-input style="width: 100%;" :disabled="!insertTotalPrice" @input="updateUnitPrice" v-model="form.total_price"></el-input>
                                <small>
                                    <el-checkbox v-model="insertTotalPrice">Manual</el-checkbox>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna: Embalaje -->
                <div class="col-md-6" style="background-color: rgb(160, 245, 175); border-radius: 10px; padding: 20px;">
                    <h5 class="text-center font-weight-bold">Embalaje</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label"><i class="fas fa-box"></i> Cantidad</label>
                            <el-input controls="false" style="width: 100%;" @change="updateRealQuantity" @input.native="onInput" name="multi" :disabled="!noIsUnid" v-model="unids"></el-input>
                            <small>
                                <el-checkbox v-model="noIsUnid">No son unidades</el-checkbox>
                            </small>
                        </div>
                        <div class="col-md-4" v-if="noIsUnid">
                            <label class="control-label"> Contenedor</label>
                            <el-input style="width: 100%;" v-model="form.max_quantity_description"></el-input>
                        </div>
                        <div class="col-md-4" v-if="noIsUnid">
                            <label class="control-label text-center font-weight-bold text-dark"><i class="fas fa-calculator"></i>Total
                                Global</label>
                            <el-input style="width: 100%;" readonly v-model="form.real_quantity"></el-input>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fila 4 -->
            <div class="row" style="margin: 5px; 
                    display: flex; 
                    justify-content: 
                    space-between;">
                <!-- Tratamiento de Productos -->
                <div class="col-md-6" v-if="
                            form.item &&
                                (form.item.lots_enabled ||
                                    form.item.series_enabled ||
                                    form.item.has_color_size)
                        " style="background-color: #f0f8ff; border-radius: 10px; padding: 2px;">
                    <div class="row text-center">
                        <div class="col-md-4 font-weight-bold text-dark">
                            <h4>Ingresar</h4>
                        </div>
                        <div class="col-md-4 font-weight-bold text-dark">
                            <h4>Descargar</h4>
                        </div>
                        <div class="col-md-4 font-weight-bold text-dark">
                            <h4>Importar</h4>
                        </div>
                    </div>
                    <!-- Lotes -->
                    <div class="row justify-content-center">
                        <!-- Botón Lotes -->
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.lots_enabled">
                            <div class="form-group" :class="{
                                        'has-danger': errors.lots_enabled
                                    }">
                                <el-button class="btn btnsdr-lotes d-flex align-items-center justify-content-center gap-2" style="background-color: #e6e6fa; margin-top:2%;" type="primary" icon="fas fa-sign-in-alt icon" @click.prevent="clickLotGroupCode">
                                    Lotes
                                </el-button>
                            </div>
                        </div>
                        <!-- Icono de Excel con Tooltip -->
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.lots_enabled">
                            <div class="form-group" :class="{
                                        'has-danger': errors.lots_enabled
                                    }">
                                <div class="d-flex align-items-center justify-content-center">
                                    <el-tooltip class="item" effect="dark" content="Descargar Formato de Excel" placement="top">
                                        <a href="/formats/lots_group_compras.xlsx" class="text-success d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-file-excel fa-2x"></i>
                                        </a>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>

                        <!-- Botón Subir Archivo -->
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.lots_enabled">
                            <div class="form-group" :class="{
                                        'has-danger': errors.lots_enabled
                                    }">
                                <div class="d-flex justify-content-center">
                                    <el-button class="btn btn-subir w-50 d-flex align-items-center justify-content-center gap-2 bg-light" icon="fas fa-upload icon" @click.prevent="$refs.file.click()"></el-button>
                                    <input type="file" @change="uploadExcelGroup" style="visibility:hidden;" ref="file" accept=".xlsx,.xls" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tallas y Colores -->
                    <div class="row justify-content-center">
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.has_color_size">
                            <div class="form-group" :class="{
                                        'has-danger': errors.has_color_size
                                    }">
                                <div>
                                    <button class="btn btnsdr-tallas-colores" style="margin-top:2%;" type="primary" @click.prevent="clickColorSize">
                                        <i class="fas fa-tshirt"></i>
                                        Color & talla
                                    </button>
                                    <small class="form-control-feedback" v-if="errors.has_color_size" v-text="errors.has_color_size[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.has_color_size">
                            <div class="form-group" :class="{
                                        'has-danger': errors.has_color_size
                                    }">
                                <div>
                                    <el-tooltip class="item" effect="dark" content="Descargar Formato de Excel" placement="top">
                                        <a href="/formats/color_talla_compras.xlsx" class="text-success d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-file-excel fa-2x"></i>
                                        </a>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.has_color_size">
                            <div class="form-group" :class="{
                                        'has-danger': errors.has_color_size
                                    }">
                                <div class="d-flex justify-content-center">
                                    <el-button class="btn btn-subir w-50 d-flex align-items-center justify-content-center gap-2" icon="fas fa-upload icon" @click.prevent="$refs.file.click()"></el-button>
                                    <input type="file" @change="uploadExcelColorSize" style="visibility:hidden;" ref="file" accept=".xlsx,.xls" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- series -->
                    <div class="row justify-content-center">
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.series_enabled">
                            <div class="form-group" :class="{ 'has-danger': errors.lot_code }">
                                <div>
                                    <el-button class="btn btnsdr-series-colores" icon="fas fa-sign-in-alt icon" style="margin-top:2%;" type="primary" @click.prevent="clickLotcode">
                                        Series
                                    </el-button>
                                    <small class="form-control-feedback" v-if="errors.has_color_size" v-text="errors.has_color_size[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.series_enabled">
                            <div class="form-group" :class="{ 'has-danger': errors.lot_code }">
                                <div>
                                    <el-tooltip class="item" effect="dark" content="Descargar Formato de Excel" placement="top">
                                        <a href="/formats/series_compras.xlsx" class="text-success d-inline-flex align-items-center gap-1">
                                            <i class="fas fa-file-excel fa-2x"></i>
                                        </a>
                                    </el-tooltip>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center" v-if="form.item.series_enabled">
                            <div class="form-group" :class="{ 'has-danger': errors.lot_code }">
                                <div class="d-flex justify-content-center">
                                    <el-button class="btn btn-subir w-50 d-flex align-items-center justify-content-center gap-2" icon="fas fa-upload icon" @click.prevent="$refs.file.click()"></el-button>
                                    <input type="file" @change="uploadExcel" style="visibility:hidden;" ref="file" accept=".xlsx,.xls" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Boton Cerrar y Agregar -->
                <div class="col-md-6">
                    <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                        <!-- Botón Cerrar -->
                        <el-button class="btn-cancel btn-cancel:hover" icon="fas fa-times fa-lg" @click.prevent="close()">
                            <span>Cerrar</span>
                        </el-button>
                        <!-- Botón Guardar -->
                        <el-button class="btn-agregar btn-agregar:hover" icon="fas fa-plus fa-lg" type="primary" native-type="submit" :loading="loading_submit">
                            <span>Agregar</span>
                        </el-button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" v-if="
                        form.item_unit_types && form.item_unit_types.length > 0
                    ">
                <div style="margin:3px" class="table-responsive">
                    <h6 class="separator-title">
                        Listado de Precios
                        <el-tooltip class="item" effect="dark" content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades" placement="top">
                            <i class="fa fa-info-circle"></i>
                        </el-tooltip>
                    </h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Unidad</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Factor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in form.item_unit_types" :key="index">
                                <td class="text-center">
                                    {{ row.unit_type_id }}
                                </td>
                                <td class="text-center">
                                    {{ row.description }}
                                </td>
                                <td class="text-center">
                                    {{ row.quantity_unit }}
                                </td>
                                <td class="series-table-actions text-end">
                                    <button type="button" :class="
                                                `btn waves-effect waves-light btn-sm ${
                                                    row.selected
                                                        ? 'btn-primary'
                                                        : 'btn-success'
                                                } `
                                            " @click.prevent="selectedPrice(row)">
                                        <i class="el-icon-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <item-form :showDialog.sync="showDialogNewItem" :external="true" @add="addRowItems"></item-form>
    <lots-form :showDialog.sync="showDialogLots" :stock="form.quantity" :lots="lots" @addRowLot="addRowLot">
    </lots-form>
    <lots-group-form :showDialog.sync="showDialogLotsGroup" :stock="form.quantity" :lotsGroup.sync="lotsGroup" @addRowLot="addRowLotGroup"></lots-group-form>
    <color-size-form :showDialog.sync="showColorSize" :stock="form.quantity" :colorSizes="color_size" @addRowColorSize="addRowColorSize" :recordId="form.item_id">
    </color-size-form>
    <warehouses-detail :showDialog.sync="showWarehousesDetail" :warehouses="warehousesDetail">
    </warehouses-detail>
</el-dialog>
</template>

<style>
.el-select-dropdown {
    max-width: 80% !important;
    margin-right: 5% !important;
}
</style>

<script>
import itemForm from "../../items/form.vue";
import {
    calculateRowItem
} from "../../../helpers/functions";
import LotsForm from "../../items/partials/lots.vue";
import LotsGroupForm from "../../items/partials/lots_group.vue";
import ColorSizeForm from "../../items/partials/color_size.vue";
import readXlsxFile from "read-excel-file";
import WarehousesDetail from "./select_warehouse.vue";
import moment from "moment";

export default {
    props: [
        "showDialog",
        "currencyTypeIdActive",
        "exchangeRateSale",
        "includes",
        "percentage_igv"
    ],
    components: {
        itemForm,
        LotsForm,
        ColorSizeForm,
        WarehousesDetail,
        LotsGroupForm
    },
    data() {
        return {
            input_barcode: "",
            loading_submit: false,
            showDialogLotsGroup: false,

            colorSizes: [],
            changing_name: false,
            input_barcode: null,
            barcode_lector: false,
            timer: null,
            insertTotalPrice: false,
            unids: 0,
            noIsUnid: false,
            titleDialog: "Agregar Productos o Servicios",
            showDialogLots: false,
            resource: "purchases",
            showDialogNewItem: false,
            errors: {},
            form: {},
            items: [],
            warehouses: [],
            lots: [],
            lots_group: [],
            affectation_igv_types: [],
            system_isc_types: [],
            discount_types: [],
            charge_types: [],
            attribute_types: [],
            use_price: 1,
            lot_code: null,
            change_affectation_igv_type_id: false,
            activeName: "first",
            loading_search: false,
            showColorSize: false,
            color_size: [],
            showWarehousesDetail: false,
            warehousesDetail: [],
            selectedProductStock: 0,
            lotsGroup: []
        };
    },
    watch: {
        barcode_lector(newVal) {
            if (newVal) {
                this.$nextTick(() => {
                    this.$refs.input_barcode.focus();
                });
            }
        }
    },
    created() {
        this.inititem();

        this.$eventHub.$on("reloadDataItems", item_id => {
            this.reloadDataItems(item_id);
        });
    },
    methods: {
        addRowLotGroup(lotsgroup) {
            console.log("ver los lotes recibidos", lotsgroup);
            this.lotsGroup = lotsgroup;

            const totalQuantity = this.lotsGroup.reduce((sum, lot) => {
                return sum + parseFloat(lot.quantity);
            }, 0);
            this.form.quantity = totalQuantity;

            console.log("Cantidad total de lotes:", totalQuantity);
        },
        clickLotGroupCode() {
            this.showDialogLotsGroup = true;
        },
        clickWarehouseDetail() {
            if (!this.form.item_id) {
                // return this.$toast.error("Seleccione un item");
                return this.$showSAlert("hola", "Seleccione un item", "error");
            }
            let item = _.find(this.items, {
                id: this.form.item_id
            });
            this.warehousesDetail = item.warehouses;
            this.showWarehousesDetail = true;
        },
        addRowColorSize(color_size) {
            this.color_size = color_size;
        },
        clickColorSize() {
            this.showColorSize = true;
        },
        inititem() {
            this.initForm();
            this.$http.get(`/${this.resource}/item/tables`).then(response => {
                this.items = response.data.items;
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.system_isc_types = response.data.system_isc_types;
                this.discount_types = response.data.discount_types;
                this.charge_types = response.data.charge_types;
                this.attribute_types = response.data.attribute_types;
                this.warehouses = response.data.warehouses;
                // this.filterItems()
            });
        },
        uploadExcelGroup(event) {
            let file = event.target.files[0];
            readXlsxFile(file).then(rows => {
                // Saltar el encabezado
                rows.shift();
                this.lotsGroup = rows.map(row => {
                    let date = moment(row[1])
                        .add(5, "hours")
                        .format("YYYY-MM-DD");
                    return {
                        code: row[0],
                        quantity: row[1], // Asegúrate de que esta columna contenga la cantidad
                        date_of_due: date,
                        state: "Activo"
                    };
                });

                // Sumar todas las cantidades
                const totalQuantity = this.lotsGroup.reduce((sum, lot) => {
                    return sum + parseFloat(lot.quantity); // Asegúrate de convertir a número
                }, 0);

                // Asignar la suma total al formulario
                this.form.quantity = totalQuantity;

                console.log("lotes ver acción", this.lotsGroup);
                console.log("Cantidad total importada:", totalQuantity);
                event.target.value = "";
            });
        },
        uploadExcelColorSize(event) {
            let file = event.target.files[0];
            readXlsxFile(file).then(rows => {
                //skip header
                rows.shift();
                // `rows` is an array of rows
                // each row being an array of cells.

                this.color_size = rows.map(row => {
                    let color = row[0];
                    let size = row[1];
                    let stock = row[2];
                    let price = row[3];

                    return {
                        color,
                        size,
                        stock,
                        price
                    };
                });
                this.form.quantity = this.color_size.reduce(
                    (a, b) => a + Number(b.stock),
                    0
                );
                // this.form.quantity = this.lots.length;
                event.target.value = "";
            });
        },
        uploadExcel(event) {
            let file = event.target.files[0];
            readXlsxFile(file).then(rows => {
                //skip header
                rows.shift();
                // `rows` is an array of rows
                // each row being an array of cells.

                this.lots = rows.map(row => {
                    let date = moment(row[1])
                        .add(5, "hours")
                        .format("YYYY-MM-DD");

                    return {
                        series: row[0],
                        date: date,
                        state: "Activo"
                    };
                });
                this.form.quantity = this.lots.length;
                event.target.value = "";
            });
        },
        searchItemsDebounce() {
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.searchItems();
            }, 500);
        },
        async searchItems() {
            if (this.changing_name) return (this.changing_name = false);
            let input = this.input_barcode;

            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                await this.$http
                    .get(`/documents/search-items/?${parameters}`)
                    .then(response => {
                        this.items_select = response.data[0];
                        this.items = response.data;

                        this.loading_search = false;

                        // this.enabledSearchItemsBarcode();

                        if (this.items.length == 0) {
                            this.filterItems();
                        } else {
                            this.form.item_id = this.items[0].id;
                            this.changeItem(true);
                        }
                    });
            }
        },

        initFilterItems() {
            this.activeName = "first";
            this.items = this.all_items;
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                let parameters = `input=${input}`;

                if (this.timer) {
                    clearTimeout(this.timer);
                }
                this.timer = setTimeout(async () => {
                    await this.$http
                        .get(`/documents/search-items/?${parameters}`)
                        .then(response => {
                            this.items_select = response.data[0];
                            this.items = response.data;

                            this.loading_search = false;

                            // this.enabledSearchItemsBarcode();

                            if (this.items.length == 0) {
                                this.filterItems();
                            }
                        });
                }, 500);
            } else {
                await this.filterItems();
            }
        },

        addRowLot(lots) {
            this.lots = lots;
        },
        clickLotcode() {
            // if(this.form.stock <= 0)
            //     return this.$toast.error('El stock debe ser mayor a 0')

            this.showDialogLots = true;
        },
        filterItems() {
            this.items = this.items.filter(
                item => item.warehouses && item.warehouses.length > 0
            );
        },
        addRowItems(row) {
            this.form.item_id = row.id;
            this.$http.get(`/${this.resource}/item`).then(response => {
                this.items = response.data.items;
                this.form.item = row;
                this.form.unit_price = this.form.item.purchase_unit_price;
                this.form.affectation_igv_type_id = this.form.item.purchase_affectation_igv_type_id;
                this.form.item_unit_types = _.find(this.items, {
                    id: this.form.item_id
                }).item_unit_types;
            });
            //this.changeItem();
            //})
        },
        updatePriceTotal() {
            this.form.total_price = this.form.unit_price * this.form.quantity;
        },
        updateUnitPrice() {
            this.form.unit_price = this.form.total_price / this.form.quantity;
        },

        initForm() {
            this.errors = {};
            this.form = {
                sale_unit_price: 0,
                total_price: 0,
                item_id: null,
                real_quantity: 0,
                warehouse_id: 1,
                warehouse_description: null,
                item: {},
                affectation_igv_type_id: null,
                affectation_igv_type: {},
                has_isc: false,
                system_isc_type_id: null,
                percentage_isc: 0,
                suggested_price: 0,
                quantity: 1,
                unit_price: 0,
                charges: [],
                discounts: [],
                attributes: [],
                item_unit_types: [],
                lot_code: null,
                date_of_due: null,
                impuest_igv: 0.0,
                importe: 0.0
            };

            this.item_unit_type = {};
            this.lots = [];
            this.color_size = [];
            this.lotsGroup = [];
            this.lot_code = null;
        },
        // initializeFields() {
        //     this.form.affectation_igv_type_id = this.affectation_igv_types[0].id
        // },
        create() {
            this.inititem();
            this.input_barcode = null;
            this.barcode_lector = false;
            //     this.initializeFields()
        },
        clickAddDiscount() {
            this.form.discounts.push({
                discount_type_id: null,
                discount_type: null,
                description: null,
                percentage: 0,
                factor: 0,
                amount: 0,
                base: 0
            });
        },
        clickRemoveDiscount(index) {
            this.form.discounts.splice(index, 1);
        },
        changeDiscountType(index) {
            let discount_type_id = this.form.discounts[index].discount_type_id;
            this.form.discounts[index].discount_type = _.find(
                this.discount_types, {
                    id: discount_type_id
                }
            );
        },
        clickAddCharge() {
            this.form.charges.push({
                charge_type_id: null,
                charge_type: null,
                description: null,
                percentage: 0,
                factor: 0,
                amount: 0,
                base: 0
            });
        },
        clickRemoveCharge(index) {
            this.form.charges.splice(index, 1);
        },
        changeChargeType(index) {
            let charge_type_id = this.form.charges[index].charge_type_id;
            this.form.charges[index].charge_type = _.find(this.charge_types, {
                id: charge_type_id
            });
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
        clickRemoveAttribute(index) {
            this.form.attributes.splice(index, 1);
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
        close() {
            this.initForm();
            this.unids = 0;
            this.noIsUnid = false;
            this.$emit("update:showDialog", false);
        },
        selectedPrice(row) {
            this.form.item_unit_types = this.form.item_unit_types.map(i => ({
                ...i,
                selected: i.id == row.id
            }));

            this.form.item_unit_type_id = row.id;
            this.item_unit_type = row;

            // this.form.unit_price = valor
            this.form.item.unit_type_id = row.unit_type_id;
        },
        onInput(env) {
            let {
                target
            } = env;
            let {
                name,
                value
            } = target;

            if (name == "multi") {
                this.form.real_quantity =
                    Number(value) * Number(this.form.quantity);
            } else {
                this.form.real_quantity = Number(this.unids) * Number(value);
            }
        },
        async updateRealQuantity() {
            this.form.real_quantity =
                Number(this.unids) * Number(this.form.quantity);
            this.form.total_price = this.form.unit_price * this.form.quantity;
        },
        changeItem(changing_name = false) {
            this.color_size = [];
            this.form.item = _.find(this.items, {
                id: this.form.item_id
            });
            if (changing_name) {
                this.changing_name = true;
                this.input_barcode = this.form.item.full_description;
                this.changing_name = false;
            }

            this.form.unit_price = this.form.item.purchase_unit_price;
            this.form.sale_unit_price = this.form.item.sale_unit_price;
            this.form.affectation_igv_type_id = this.form.item.purchase_affectation_igv_type_id;
            this.form.item_unit_types = _.find(this.items, {
                id: this.form.item_id
            }).item_unit_types;
            // agregado para mostrar stock de producto en la vista iten
            if (
                this.form.item.warehouses &&
                this.form.item.warehouses.length > 0
            ) {
                this.selectedProductStock = this.form.item.warehouses.reduce(
                    (acc, warehouse) => acc + warehouse.stock,
                    0
                );
            } else {
                this.selectedProductStock = "Stock no disponible";
            }
        },
        async clickAddItem() {
            this.insertTotalPrice = false;

            // Validation for color and size
            if (this.form.item.has_color_size && this.color_size.length === 0) {
                // return this.$toast.error(
                //     "Debe agregar al menos un color y talla para poder realizar la compra."
                // );
                return this.$showSAlert(
                    "Alerta",
                    "Debe agregar al menos un color y talla para poder realizar la Compra",
                    "error"
                );
            }

            // Validation for lots
            /* if (this.form.item.lots_enabled && this.lots.length === 0) {
                    return this.$toast.error("Debe agregar al menos un lote para poder realizar la compra.");
                } */

            // Validation for series
            if (this.form.item.series_enabled) {
                if (this.lots.length > this.form.quantity) {
                    // return this.$toast.error("La cantidad de series registradas es superior al stock");
                    return this.$showSAlert(
                        "Alerta",
                        "La cantidad de series registradas es superior al stock",
                        "error"
                    );
                }

                if (this.lots.length != this.form.quantity) {
                    // return this.$toast.error(
                    //     "La cantidad de series registradas son diferentes al stock"
                    // );
                    return this.$showSAlert(
                        "Alerta",
                        "La cantidad de series registradas son diferentes al stock",
                        "error"
                    );
                }
            }

            let date_of_due = this.form.date_of_due;
            this.form.item.unit_price = this.form.unit_price;
            this.form.item.presentation = this.item_unit_type;
            this.form.affectation_igv_type = _.find(
                this.affectation_igv_types, {
                    id: this.form.affectation_igv_type_id
                }
            );
            this.row = await calculateRowItem(
                this.form,
                this.currencyTypeIdActive,
                this.exchangeRateSale,
                this.includes,
                "documents",
                false,
                this.percentage_igv
            );
            if (this.noIsUnid) {
                this.row.real_quantity = this.form.real_quantity;
            }
            this.row.sale_unit_price = this.form.sale_unit_price;
            this.row.lot_code = await this.lot_code;
            this.row.lots_group = await this.lotsGroup;
            this.row.item.lots_group = await this.lotsGroup;
            this.row.lots = await this.lots;
            this.row.item.lots = await this.lots;
            this.row.color_size = this.color_size;
            this.row.item.color_size = this.color_size;

            this.row = this.changeWarehouse(this.row);

            this.row.date_of_due = date_of_due;

            this.initForm();
            this.unids = 0;
            this.noIsUnid = false;
            this.input_barcode = null;
            if (this.barcode_lector) {
                this.$refs.input_barcode.focus();
            }
            this.$emit("add", this.row);
        },
        changeWarehouse(row) {
            let warehouse = _.find(this.warehouses, {
                id: this.form.warehouse_id
            });
            row.warehouse_id = warehouse.id;
            row.warehouse_description = warehouse.description;
            return row;
        },
        reloadDataItems(item_id) {
            this.$http.get(`/${this.resource}/table/items`).then(response => {
                this.items = response.data;
                this.form.item_id = item_id;
                this.changeItem();
                // this.filterItems()
            });
        }
    }
};
</script>
