<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @open="create"
        @close="close"
    >
        <form
            autocomplete="off"
            @submit.prevent="clickAddItem"
            @keydown.enter.prevent
        >
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.item_id }"
                        >
                            <label class="control-label">
                                Producto/Servicio
                                <a
                                    href="#"
                                    @click.prevent="showDialogNewItem = true"
                                    >[+ Nuevo]</a
                                >
                            </label>
                            <div
                                class="el-input el-input-group el-input-group--append"
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
                                >
                                    <el-option
                                        v-for="option in items"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.full_description"
                                    ></el-option>
                                </el-select>
                                <el-tooltip
                                    slot="append"
                                    class="item"
                                    effect="dark"
                                    content="Ver Stock del Producto"
                                    placement="bottom"
                                    :disabled="!form.item_id"
                                >
                                    <div class="el-input-group__append">
                                        <el-button
                                         :disabled="!form.item_id"
                                            @click.prevent="
                                                clickWarehouseDetail()
                                            "
                                            ><i class="fa fa-search"></i
                                        ></el-button>
                                    </div>
                                </el-tooltip>
                            </div>
                            <el-input
                                ref="input_barcode"
                                v-if="barcode_lector"
                                v-model="input_barcode"
                                placeholder="Buscar"
                                @input="searchItemsDebounce"
                            >
                            </el-input>
                            <el-checkbox v-model="barcode_lector"
                                >Lector de código de barras</el-checkbox
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.affectation_igv_type_id
                            }"
                        >
                            <label class="control-label">Afectación Igv</label>
                            <el-select
                                v-model="form.affectation_igv_type_id"
                                :disabled="!change_affectation_igv_type_id"
                                filterable
                            >
                                <el-option
                                    v-for="option in affectation_igv_types"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <el-checkbox
                                v-model="change_affectation_igv_type_id"
                                >Editar</el-checkbox
                            >
                            <small
                                class="form-control-feedback"
                                v-if="errors.affectation_igv_type_id"
                                v-text="errors.affectation_igv_type_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.quantity }"
                        >
                            <label class="control-label">Cantidad</label>
                            <el-input-number
                                style="width:100%"
                                v-model="form.quantity"
                                :min="0.01"
                                name="quantity"
                                @input.native="onInput"
                                @change="updateRealQuantity"
                            ></el-input-number>
                            <small
                                class="form-control-feedback"
                                v-if="errors.quantity"
                                v-text="errors.quantity[0]"
                            ></small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.unit_price }"
                        >
                            <label class="control-label">Costo Unitario</label>
                            <el-input
                                v-model="form.unit_price"
                                @input="updatePriceTotal"
                            >
                                <template
                                    slot="prepend"
                                    v-if="form.item.currency_type_symbol"
                                    >{{
                                        form.item.currency_type_symbol
                                    }}</template
                                >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.unit_price"
                                v-text="errors.unit_price[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.unit_price }"
                        >
                            <label class="control-label">Costo total</label>
                            <el-input
                                :disabled="!insertTotalPrice"
                                @input="updateUnitPrice"
                                v-model="form.total_price"
                            >
                                <template
                                    slot="prepend"
                                    v-if="form.item.currency_type_symbol"
                                    >{{
                                        form.item.currency_type_symbol
                                    }}</template
                                >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small>
                                <el-checkbox v-model="insertTotalPrice"
                                    >Precio total</el-checkbox
                                >
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.warehouse_id }"
                        >
                            <label class="control-label"
                                >Almacén de destino</label
                            >
                            <el-select v-model="form.warehouse_id" filterable>
                                <el-option
                                    v-for="option in warehouses"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.warehouse_id"
                                v-text="errors.warehouse_id[0]"
                            ></small>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 d-flex align-items-end">
                        <el-checkbox v-model="noIsUnid"
                            >No son unidades</el-checkbox
                        >
                    </div> -->

                    <div class="col-md-3">
                        <label class="control-label"
                            >Cantidad por embalaje</label
                        >
                        <el-input-number
                            style="width:100%;"
                            @change="updateRealQuantity"
                            @input.native="onInput"
                            name="multi"
                            :disabled="!noIsUnid"
                            v-model="unids"
                        >
                        </el-input-number>
                        <small>
                            <el-checkbox v-model="noIsUnid"
                                >No son unidades</el-checkbox
                            >
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Precio de venta</label>
                        <el-input
                            style="width:100%;"
                            v-model="form.sale_unit_price"
                        >
                        </el-input>
                    </div>
                    <div class="col-md-3 " v-if="noIsUnid">
                        <label class="control-label">Cantidad total</label>
                        <el-input readonly v-model="form.real_quantity">
                        </el-input>
                    </div>
                    <div
                        class="col-md-6 mt-2"
                        v-if="form.item && form.item.lots_enabled"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.lot_code }"
                            v-if="form.item.lots_enabled"
                        >
                            <label class="control-label">
                                Código lote
                            </label>
                            <el-input v-model="lot_code">
                                <!--<el-button slot="append" icon="el-icon-edit-outline"  @click.prevent="clickLotcode"></el-button> -->
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.lot_code"
                                v-text="errors.lot_code[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        style="padding-top: 1%;"
                        class="col-md-3"
                        v-if="form.item && form.item.lots_enabled"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.date_of_due }"
                            v-if="form.item.lots_enabled"
                        >
                            <label class="control-label"
                                >Fec. Vencimiento</label
                            >
                            <el-date-picker
                                v-model="form.date_of_due"
                                type="date"
                                value-format="yyyy-MM-dd"
                                :clearable="true"
                            ></el-date-picker>
                            <small
                                class="form-control-feedback"
                                v-if="errors.date_of_due"
                                v-text="errors.date_of_due[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-3" v-show="form.item_id">
                        <br />
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.has_color_size }"
                            v-if="form.item.has_color_size"
                        >
                            <div class="d-flex">
                                <div class="col-md-6">
                                    <label class="control-label w-100">
                                        <!-- <el-checkbox v-model="enabled_lots"  @change="changeEnabledPercentageOfProfit">Código lote</el-checkbox> -->
                                        Ingrese color & talla
                                    </label>

                                    <el-button
                                        style="margin-top:2%;"
                                        type="primary"
                                        icon="el-icon-edit-outline"
                                        @click.prevent="clickColorSize"
                                    ></el-button>

                                    <small
                                        class="form-control-feedback"
                                        v-if="errors.has_color_size"
                                        v-text="errors.has_color_size[0]"
                                    ></small>
                                </div>
                                <div>
                                    <label class="control-label w-100">
                                        Subir excel

                                        <a
                                            href="/formats/color_talla_compras.xlsx"
                                            >Descargar formato</a
                                        >
                                    </label>

                                    <el-button
                                        style="margin-top:2%;"
                                        type="primary"
                                        icon="el-icon-tickets"
                                        @click.prevent="$refs.file.click()"
                                    ></el-button>
                                    <input
                                        type="file"
                                        @change="uploadExcelColorSize"
                                        style="visibility:hidden;"
                                        ref="file"
                                        accept=".xlsx,.xls"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" v-show="form.item_id">
                        <br />
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.lot_code }"
                            v-if="form.item.series_enabled"
                        >
                            <div class="d-flex">
                                <div class="col-md-6">
                                    <label class="control-label w-100">
                                        <!-- <el-checkbox v-model="enabled_lots"  @change="changeEnabledPercentageOfProfit">Código lote</el-checkbox> -->
                                        Ingrese series
                                    </label>

                                    <el-button
                                        style="margin-top:2%;"
                                        type="primary"
                                        icon="el-icon-edit-outline"
                                        @click.prevent="clickLotcode"
                                    ></el-button>

                                    <small
                                        class="form-control-feedback"
                                        v-if="errors.lot_code"
                                        v-text="errors.lot_code[0]"
                                    ></small>
                                </div>
                                <div>
                                    <label class="control-label w-100">
                                        Subir excel

                                        <a href="/formats/series_compras.xlsx"
                                            >Descargar formato</a
                                        >
                                    </label>

                                    <el-button
                                        style="margin-top:2%;"
                                        type="primary"
                                        icon="el-icon-tickets"
                                        @click.prevent="$refs.file.click()"
                                    ></el-button>
                                    <input
                                        type="file"
                                        @change="uploadExcel"
                                        style="visibility:hidden;"
                                        ref="file"
                                        accept=".xlsx,.xls"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="col-md-12"
                        v-if="
                            form.item_unit_types &&
                                form.item_unit_types.length > 0
                        "
                    >
                        <div style="margin:3px" class="table-responsive">
                            <h6 class="separator-title">
                                Listado de Precios
                                <el-tooltip
                                    class="item"
                                    effect="dark"
                                    content="Aplica para realizar compra/venta en presentacion de diferentes precios y/o cantidades"
                                    placement="top"
                                >
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
                                    <tr
                                        v-for="(row,
                                        index) in form.item_unit_types"
                                        :key="index"
                                    >
                                        <td class="text-center">
                                            {{ row.unit_type_id }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.description }}
                                        </td>
                                        <td class="text-center">
                                            {{ row.quantity_unit }}
                                        </td>

                                        <td
                                            class="series-table-actions text-end"
                                        >
                                            <button
                                                type="button"
                                                :class="
                                                    `btn waves-effect waves-light btn-sm ${
                                                        row.selected
                                                            ? 'btn-primary'
                                                            : 'btn-success'
                                                    } `
                                                "
                                                @click.prevent="
                                                    selectedPrice(row)
                                                "
                                            >
                                                <i class="el-icon-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cerrar</el-button>
                <el-button type="primary" native-type="submit"
                    >Agregar</el-button
                >
            </div>
        </form>
        <item-form
            :showDialog.sync="showDialogNewItem"
            :external="true"
            @add="addRowItems"
        ></item-form>

        <lots-form
            :showDialog.sync="showDialogLots"
            :stock="form.quantity"
            :lots="lots"
            @addRowLot="addRowLot"
        >
        </lots-form>
        <color-size-form
            :showDialog.sync="showColorSize"
            :stock="form.quantity"
            :colorSizes="color_size"
            @addRowColorSize="addRowColorSize"
            :recordId="form.item_id"
        >
        </color-size-form>
        <warehouses-detail
            :showDialog.sync="showWarehousesDetail"
            :warehouses="warehousesDetail"
        >
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
import { calculateRowItem } from "../../../helpers/functions";
import LotsForm from "../../items/partials/lots.vue";
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
    components: { itemForm, LotsForm, ColorSizeForm, WarehousesDetail },
    data() {
        return {
            colorSizes: [],
            changing_name: false,
            input_barcode: null,
            barcode_lector: false,
            timer: null,
            insertTotalPrice: false,
            unids: 0,
            noIsUnid: false,
            titleDialog: "Agregar Producto o Servicios",
            showDialogLots: false,
            resource: "purchases",
            showDialogNewItem: false,
            errors: {},
            form: {},
            items: [],
            warehouses: [],
            lots: [],
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
            warehousesDetail: []
        };
    },
    created() {
        this.inititem();

        this.$eventHub.$on("reloadDataItems", item_id => {
            this.reloadDataItems(item_id);
        });
    },
    methods: {
        clickWarehouseDetail() {
            if (!this.form.item_id) {
                return this.$toast.error("Seleccione un item");
            }
            let item = _.find(this.items, { id: this.form.item_id });
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

                    return {
                        color,
                        size,
                        stock
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
                this.discount_types,
                { id: discount_type_id }
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
            let { target } = env;
            let { name, value } = target;

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
            this.form.item = _.find(this.items, { id: this.form.item_id });
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
        },
        async clickAddItem() {
            this.insertTotalPrice = false;
            if (this.form.item.lots_enabled) {
                if (!this.lot_code)
                    return this.$toast.error("Código de lote es requerido");

                if (!this.form.date_of_due)
                    return this.$toast.error(
                        "Fecha de vencimiento es requerido si lotes esta habilitado."
                    );
            }

            if (this.form.item.series_enabled) {
                if (this.lots.length > this.form.quantity)
                    return this.$toast.error(
                        "La cantidad de series registradas es superior al stock"
                    );

                if (this.lots.length != this.form.quantity)
                    return this.$toast.error(
                        "La cantidad de series registradas son diferentes al stock"
                    );
            }

            let date_of_due = this.form.date_of_due;
            this.form.item.unit_price = this.form.unit_price;
            this.form.item.presentation = this.item_unit_type;
            this.form.affectation_igv_type = _.find(
                this.affectation_igv_types,
                { id: this.form.affectation_igv_type_id }
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
            this.row.lots = await this.lots;
            this.row.color_size = this.color_size;

            this.row = this.changeWarehouse(this.row);

            this.row.date_of_due = date_of_due;

            this.initForm();
            this.unids = 0;
            this.noIsUnid = false;
            this.input_barcode = null;
            if (this.barcode_lector) {
                this.$refs.input_barcode.focus();
            }
            // this.initializeFields()
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
