<!-- Modulo Listado de productos Principal-->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="card mb-0">
                <div class="card-header bg-primary d-flex align-items-center" style="padding: 10px;">
                    <h4 class="my-0 text-white d-flex align-items-center" style="font-size: 1rem; font-weight: bold;">
                        <i class="fas fa-box-open" style="font-size: 1rem; margin-right: 0.5rem;"></i>
                        Listado de Productos
                    </h4>
                </div>

                <div class="data-table-visible-columns d-flex align-items-center">
                    <el-button type="primary" class="btn_guardarsmall" style="margin-right: 5px;" href="javascript:void(0)"
                        @click.prevent="clickSaleOffert()" v-if="config.sale_offert">
                        <i class="fas fa-tag"></i>
                        Ofertas de ventas
                    </el-button>
                    <el-button type="primary" class="btn_guardarsmall" style="margin-right: 5px;" href="javascript:void(0)"
                        @click.prevent="clickBonus()" v-if="config.consolidated_quotations">
                        <i class="fas fa-gift"></i>
                        Bonificaciones
                    </el-button>
                    <el-button v-if="config.unique_code_unit_types" type="primary" class="btn_guardarsmall"
                        style="margin-right: 5px;" href="javascript:void(0)" @click.prevent="clickGenerate()">
                        <!-- <i class="fa fa-plus"></i> -->
                        Generar Código de Familia
                    </el-button>
                    <el-button type="primary" class="btn_guardarsmall" style="margin-right: 5px;" href="javascript:void(0)"
                        @click.prevent="clickCreate()">
                        <i class="fa fa-plus"></i>
                        Nuevo
                    </el-button>
                    <div class="dropdown">
                        <button class="btn_guardarsmall" type="Primary" data-bs-toggle="dropdown" aria-expanded="false"
                            aria-haspopup="true" style="margin-right: 5px;">
                            <i class="fa fa-upload me-2"></i>
                            Importar
                        </button>
                        <div class="dropdown-menu p-2 custom-dropdown-bg"
                            v-if="typeUser === 'admin' || typeUser === 'superadmin'">
                            <div class="d-flex flex-column" style="width: 180px;">
                                <el-button type="primary" size="mini" class="btn_buscarsmall mb-2"
                                    style="margin: 0px 0px 8px 10px;" @click.prevent="clickImport()">
                                    <i class="fa fa-box-open me-2"></i> Productos
                                </el-button>
                                <el-button v-if="config.quantity_prices" type="primary" size="mini"
                                    class="btn_buscarsmall mb-2" @click.prevent="clickImportListPriceRange()">
                                    <i class="fa fa-layer-group me-2"></i> Precios por rango
                                </el-button>
                                <el-button type="primary" size="mini" class="btn_buscarsmall mb-2 w-100"
                                    @click.prevent="clickImportListPrice()">
                                    <i class="fa fa-tags me-2"></i> Política de Precios
                                </el-button>
                                <el-button v-if="config.quantity_prices" type="primary" size="mini"
                                    class="btn_buscarsmall mb-2  w-100" @click.prevent="clickImportListPriceUnitType()">
                                    <i class="fa fa-cubes me-2"></i> Precios por rango en política
                                </el-button>
                                <el-button type="primary" size="mini" class="btn_buscarsmall mb-2  w-100"
                                    @click.prevent="clickImportStockProducto()">
                                    <i class="fa fa-dolly me-2"></i> Stock de Producto
                                </el-button>
                                <el-button type="primary" size="mini" class="btn_buscarsmall mb-2  w-100"
                                    @click.prevent="clickImportStockItem()">
                                    <i class="fa fa-plus-square me-2"></i> Stock adicional
                                </el-button>
                                <el-button type="primary" size="mini" class="btn_buscarsmall mb-2  w-100"
                                    @click.prevent="clickImportPointsValue()">
                                    <i class="fa fa-star me-2"></i> Valor de puntos
                                </el-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <data-table :typeUser="typeUser" :resource="resource" :config="config" @clickReport="clickReport"
                        @clickReportForImport="clickReportForImport" class="table-striped" ref="dataTable">
                        <tr slot="heading" width="100%" class="bg-primary">
                            <th class="text-white" style="width: 10px;">#</th>
                            <th class="text-white" style="width: 50px;">Acciones</th>
                            <th class="text-white" style="width: 150px;">Registro Actividad</th>
                            <th class="text-white text-center" style="width: 150px;">Cód. Interno</th>
                            <th class="text-white text-center" style="width: 20px;">Unidad</th>
                            <th class="text-white text-center" style="width: 600px;">Producto o Servicio</th>
                            <!-- <th class="text-white">Descripción</th> -->
                            <th class="text-white" style="width: 40px;">Ubicación</th>
                            <th class="text-center text-white" style="width: 20px;">Stock</th>
                            <th class="text-white" style="width: 100px;">
                                P.Venta
                            </th>
                            <!-- <th class="text-end text-white">P.Unitario (Venta) establecimiento</th> -->
                            <th v-if="typeUser != 'seller'" class="text-end text-white" style="width: 100px;">
                                P.Compra
                            </th>
                            <!-- <th class="text-center text-white">Tiene Igv</th> -->
                            <th class="text-white text-center" style="width: 100px;">Estado</th>
                        </tr>

                        <tr slot-scope="{ index, row }" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }"
 >
                            <td>{{ index + 1 }}</td>
                            <td class="text-start">
                                <template>
                                    <div class="dropdown">
                                        <button class="btn_buscarsmall" type="Primary" data-bs-toggle="dropdown"
                                            aria-expanded="false" aria-haspopup="true" style="margin-right: 5px;">
                                            Acciones
                                        </button>
                                        <div class="dropdown-menu p-2 custom-dropdown-bg">
                                            <div class="d-flex flex-column" style="width: 120px;">
                                                <template v-if="row.active === true">
                                                    <el-button type="primary" size="mini"
                                                        class="btn_buscarsmall d-flex align-items-center"
                                                        style="margin: 0px 0px 8px 10px;"
                                                        @click.prevent="clickCreate(row.id)">
                                                        <i class="fa fa-edit fa-lg me-2"></i> Editar
                                                    </el-button>
                                                    <el-button type="danger" size="mini"
                                                        class="btn_buscarsmall mb-2 d-flex align-items-center"
                                                        @click.prevent="clickDelete(row.id)">
                                                        <i class="fa fa-trash fa-lg me-2"></i> Eliminar
                                                    </el-button>
                                                    <el-button
                                                        v-if="row.warehouses.some(warehouse => warehouse.active)"
                                                        type="warning" size="mini"
                                                        class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                        @click.prevent="clickDisableItem(row)">
                                                        <i class="fas fa-toggle-off fa-lg me-2"></i> Inhabilitar
                                                    </el-button>
                                                    <el-button v-else type="success" size="mini"
                                                        class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                        @click.prevent="clickEnableItem(row.id)">
                                                        <i class="fas fa-toggle-on fa-lg me-2"></i> Habilitar
                                                    </el-button>
                                                    <el-button type="info" size="mini"
                                                        class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                        @click.prevent="clickDisguise(row.id)">
                                                        <i class="fas fa-eye-slash fa-lg me-2"></i> Desactivar
                                                    </el-button>
                                                    <el-tooltip content="Agregar este producto a todos los Almacenes"
                                                        placement="top">
                                                        <!-- typeUser == 'superadmin' &&  -->
                                                        <el-button
                                                            class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                            v-if="!row.is_in_all_warehouses" type="primary"
                                                            @click.prevent="clickAddProductToWarehouses(row.id)">
                                                            <i class="fas fa-warehouse fa-lg me-2"></i>Agregar
                                                        </el-button>
                                                    </el-tooltip>
                                                    <el-tooltip
                                                        content="Agregar Política de Precios de Producto en todos los establecimintos"
                                                        placement="top">
                                                        <el-button type="primary" size="mini"
                                                            class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                            @click.prevent="clickPolitica(row.id)">
                                                            <i class="fas fa-balance-scale fa-lg me-2"></i> PPP
                                                        </el-button>
                                                    </el-tooltip>
                                                </template>
                                                <template v-else>
                                                    <el-button type="success" size="mini"
                                                        class="btn_buscarsmall mb-2 w-100 d-flex align-items-center"
                                                        @click.prevent="clickDisguiseEnable(row.id)">
                                                        <i class="fas fa-toggle-on fa-lg me-2"></i> Activar
                                                    </el-button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </td>
                            <td>
                                <template v-if="
                                    row.last_register &&
                                    row.last_register.user
                                " class="text-center">
                                    <span class="text-center fw-bold" style="font-family: Arial, sans-serif;">{{
                                        row.last_register.user }}</span>
                                    :
                                    <br />
                                    <span class="text-primary" style="font-family: Arial, sans-serif;">{{
                                        row.last_register.description
                                        }}</span>
                                    <br />
                                    <span style="font-family: Arial, sans-serif;">
                                        <span style="color: #007bff;">
                                            {{ row.last_register.created_at.split(' ')[0] }}
                                        </span>
                                        <span style="color: #dc3545; margin-left: 4px;">
                                            {{ row.last_register.created_at.split(' ')[1] }}
                                        </span>
                                    </span>
                                </template>
                            </td>

                            <td class="text-center">{{ row.internal_id }}</td>
                            <td class="text-center">{{ row.unit_type_id }}</td>
                            <td class="text-center">
                                <span style="font-weight: bold; font-size: 1.2em;">{{ row.description }}</span>
                                <br />
                                {{ row.second_name }}
                            </td>
                            <!-- <td>{{ row.second_name }}</td> -->
                            <td>{{ row.location }}</td>
                            <td>
                                <div v-if="config.product_only_location == true">
                                    {{ row.stock }}
                                </div>
                                <div v-else>
                                    <template v-if="
                                        typeUser == 'seller' &&
                                        row.unit_type_id != 'ZZ'
                                    ">{{ row.stock }}</template>
                                    <template v-else-if="
                                        typeUser != 'seller' &&
                                        row.unit_type_id != 'ZZ'
                                    ">
                                        <el-tooltip content="Ver STOCK del producto y Almacenes" placement="top">
                                            <button type="primary" class="btn_guardarsmall"
                                                style="width: 30px; padding: 1px;" @click.prevent="
                                                    clickWarehouseDetail(
                                                        row.id,
                                                        row.has_series,
                                                        row.warehouses,
                                                        row.unit_type,
                                                        row
                                                    )
                                                    ">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </el-tooltip>
                                    </template>
                                </div>
                            </td>

                            <td v-if="row.warehouse_prices.length > 0">
                                <table>
                                    <tbody>
                                        <tr v-for="price in row.warehouse_prices" :key="price.id">
                                            <td v-if="price.warehouse_id">
                                                {{ price.price }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td v-else>
                                {{ row.sale_unit_price }}
                            </td>

                            <td v-if="typeUser != 'seller'" class="text-end">
                                {{ row.purchase_unit_price }}
                            </td>

                            <td class="text-center">
                                <template
                                    v-if="Array.isArray(row.warehouses) && row.warehouses.some(warehouse => warehouse.active)">
                                    <button class="btn_excelsmall d-flex justify-content-center align-items-center"
                                        :style="{
                                            color: 'white',
                                            backgroundColor: 'green',
                                            fontWeight: 'bold',
                                            width: '110px',
                                            textAlign: 'center'
                                        }">
                                        <span style="width: 100%; text-align: center;">Habilitado</span>
                                    </button>
                                </template>
                                <template v-else>
                                    <el-button
                                        class="btn_cancelarsmall d-flex justify-content-center align-items-center"
                                        type="danger" style="width: 110px; text-align: center;">
                                        <span style="width: 100%; text-align: center;">Inhabilitado</span>
                                    </el-button>
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <items-form :showDialog.sync="showDialog" :recordId.sync="recordId"
                    :typeUser.sync="typeUser"></items-form>
                <sale-offert :showDialog.sync="showSaleOffertDialog" :recordId.sync="recordId"></sale-offert>
                <items-import :showDialog.sync="showImportDialog"></items-import>
                <items-import-points-value :showDialog.sync="showImportPointsValueDialog"></items-import-points-value>
                <warehouses-detail :showDialog.sync="showWarehousesDetail" :unit_type.sync="unit_type"
                    :warehouses="warehousesDetail" :hasSerie="hasSerie" :itemId="itemId" :item="currentItem"
                    :config="config" :user="user" :allWarehouses="warehouses"></warehouses-detail>
                <items-import-list-price-range-unit-type
                    :showDialog.sync="showImportListPriceUnitTypeDialog"></items-import-list-price-range-unit-type>
                <items-import-list-price-range
                    :showDialog.sync="showImportListPriceRangeDialog"></items-import-list-price-range>
                <items-import-list-price :showDialog.sync="showImportListPriceDialog"></items-import-list-price>
                <items-import-stock-producto
                    :showDialog.sync="showImportStockProductoDialog"></items-import-stock-producto>
                <items-import-list :showDialog.sync="showImportStockListDialog"></items-import-list>
            </div>
            <bonus-modal :showDialog.sync="showBonusDialog"></bonus-modal>
        </div>
    </div>
</template>

<style>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}
</style>

<script>
import ItemsForm from "./form.vue";
import WarehousesDetail from "./partials/warehouses.vue";
import ItemsImport from "./import.vue";
import ItemsImportPointsValue from "./partials/import_points_value.vue";
import ItemsImportListPrice from "./partials/import_list_price.vue";
import DataTable from "../../components/DataTable.vue";
import ItemsImportStockProducto from "./partials/stock_producto.vue";
import ItemsImportList from "./partials/stock_item_list.vue";
import BonusModal from "./partials/bonus_modal.vue";
import SaleOffert from "./partials/sale_offert.vue";
import ItemsImportListPriceRangeUnitType from "./partials/import_list_price_range_unit_type.vue";
import ItemsImportListPriceRange from "./partials/import_list_price_range.vue";
import { deletable } from "../../mixins/deletable";
import swal from "sweetalert2";

export default {
    props: ["typeUser", "user"],
    mixins: [deletable],
    components: {
        ItemsImportList,
        ItemsImportListPriceRangeUnitType,
        ItemsImportListPriceRange,
        ItemsImportPointsValue,
        ItemsForm,
        ItemsImport,
        DataTable,
        WarehousesDetail,
        ItemsImportListPrice,
        ItemsImportStockProducto,
        BonusModal,
        SaleOffert
    },
    data() {
        return {
            showImportStockListDialog: false,
            loading: false,
            selectedWarehousePrice: null,
            tables: [],
            currentItem: null,
            showDialog: false,
            showImportDialog: false,
            showImportListPriceDialog: false,
            showImportStockProductoDialog: false,
            showWarehousesDetail: false,
            resource: "items",
            recordId: null,
            warehousesDetail: [],
            unit_type: [],
            warehouses: [],
            hasSerie: false,
            itemId: null,
            config: {},
            records: [],
            showBonusDialog: false,
            showImportPointsValueDialog: false,
            showSaleOffertDialog: false,
            showImportListPriceUnitTypeDialog: false,
            showImportListPriceRangeDialog: false
        };
    },
    created() {
        this.$http.get(`/configurations/record`).then(response => {
            this.config = response.data.data;
        });
        this.getWarehouses();
    },
    methods: {
        clickAddProductToWarehouses(id) {
            this.loading = true;
            this.$http
                .get(`/items/warehouses/add-product/${id}`)
                .then(response => {
                    this.$toast.success(response.data.message);
                    this.$eventHub.$emit("reloadData");
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        getWarehouses() {
            this.$http.get(`/warehouses/records`).then(response => {
                this.warehouses = response.data.data;
            });
        },
        selectWarehousePrice(warehousePrice) {
            this.selectedWarehousePrice = warehousePrice;
        },

        // Método para limpiar la selección
        clearSelection() {
            this.selectedWarehousePrice = null;
        },
        // realiza una peticon get a tables
        clickImportListPriceUnitType() {
            this.showImportListPriceUnitTypeDialog = true;
        },
        clickImportListPriceRange() {
            this.showImportListPriceRangeDialog = true;
        },
        clickSaleOffert() {
            this.showSaleOffertDialog = true;
        },
        clickImportPointsValue() {
            this.showImportPointsValueDialog = true;
        },
        formatDateTime(date) {
            let days = date.days;
            let hours = date.hours;
            let minutes = date.minutes;
            let text = "Hace: ";
            if (days > 0) {
                text += `${days} días`;
            } else if (hours > 0) {
                text += `${hours} horas`;
            }
            if (days == 0 && hours == 0) {
                if (minutes == 0) {
                    text += `Recientemente`;
                } else {
                    text += `${minutes} minutos`;
                }
            }

            return text;
        },
        clickBonus() {
            this.showBonusDialog = true;
        },
        clickReportForImport(query = null) {
            let { column, value, warehouse_id, area_id, active } = query;
            window.open(
                `/items/excel-for-import?column=${column || ""}&value=${value ||
                ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id || ""}&active=${active || ""}`,
                "_blank"
            );
        },
        clickReport(query = null) {
            let { column, value, warehouse_id, area_id, active } = query;
            window.open(
                `/items/excel?column=${column || ""}&value=${value ||
                ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id || ""}&active=${active || ""}`,
                "_blank"
            );
        },
        duplicate(id) {
            this.$http
                .post(`${this.resource}/duplicate`, {
                    id
                })
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(
                            "Se guardaron los cambios correctamente."
                        );
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error("No se guardaron los cambios");
                    }
                })
                .catch(error => { });
            this.$eventHub.$emit("reloadData");
        },
        clickWarehouseDetail(id, hasSerie, warehouses, unit_type, item, active) {
            this.currentItem = item;
            this.itemId = id;
            this.hasSerie = hasSerie;
            this.warehousesDetail = warehouses;
            this.active = active;
            this.unit_type = unit_type;
            this.showWarehousesDetail = true;
        },
        clickCreate(recordId = null) {
            this.recordId = recordId;
            this.showDialog = true;
        },

        clickGenerate() {
            this.$http
                .get(`${this.resource}/generate_family`, {
                })
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(
                            "Se generó el código de familia correctamente."
                        );
                        this.$eventHub.$emit("reloadData");
                    } else {
                        this.$toast.error("No se generó el código de familia");
                    }
                })
                .catch(error => { });
        },

        clickImport() {
            this.showImportDialog = true;
        },
        clickImportListPrice() {
            this.showImportListPriceDialog = true;
        },
        clickImportStockProducto() {
            this.showImportStockProductoDialog = true;
        },
        clickImportStockItem() {
            this.showImportStockListDialog = true;
        },
        clickDelete(id) {
            this.destroy(`/${this.resource}/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickDisable(id) {
            this.disable(`/${this.resource}/disable/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickEnable(id) {
            this.enable(`/${this.resource}/enable/${id}`).then(() =>
                this.$eventHub.$emit("reloadData")
            );
        },
        clickBarcode(row) {
            if (!row.internal_id) {
                return this.$toast.error(
                    "Para generar el código de barras debe registrar el código interno."
                );
            }

            window.open(`/${this.resource}/barcode/${row.id}`);
        },
        clickPrintBarcode(row) {
            if (!row.barcode) {
                return this.$toast.error(
                    "Para generar el código de barras debe registrar el código de barras."
                );
            }

            window.open(`/${this.resource}/export/barcode/print?id=${row.id}`);
        },
        clickDisableItem(row) {
            // Pregunta por el almacén y si existe stock, ofrece quitarlo antes de inhabilitar
            const id = row && row.id ? row.id : null;
            this.getWarehouses().then(warehouses => {
                swal.fire({
                    title: "Inhabilitar Producto",
                    icon: "warning",
                    text: "¿En qué almacén desea inhabilitar el producto?",
                    input: "select",
                    inputOptions: warehouses,
                    inputPlaceholder: "Seleccionar almacén",
                    inputValue: "1",
                    confirmButtonText: "Si, Inhabilitar",
                    confirmButtonColor: "#d33",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: async selectedWarehouseId => {
                        if (!selectedWarehouseId) {
                            swal.showValidationMessage("Debe seleccionar un almacén");
                            return false;
                        }

                        try {
                            // Intentamos inhabilitar primero
                            const response = await this.disableItemInWarehouse(id, selectedWarehouseId);
                            if (response && response.success) {
                                return response;
                            }

                            // Si no se pudo, y el mensaje indica que aún hay stock en ese almacén,
                            // preguntamos si desea quitar el stock y luego reintentamos la inhabilitación
                            const message = response && response.message ? String(response.message) : "";
                            const hasStockMsg = /tiene stock|todav/i.test(message);

                            if (hasStockMsg) {
                                // extraer cantidad si viene entre paréntesis (ej: (9.0000))
                                let qty = null;
                                const m = message.match(/\(([\d\.,]+)\)/);
                                if (m && m[1]) {
                                    qty = parseFloat(m[1].replace(/,/g, "."));
                                }

                                const confirmRemove = await swal.fire({
                                    title: "El producto tiene stock",
                                    html: `${message}<br/><br/>¿Desea eliminar ese stock en este almacén y continuar con la inhabilitación?`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Si, quitar stock",
                                    cancelButtonText: "Cancelar",
                                    focusConfirm: false,
                                    showLoaderOnConfirm: true,
                                    preConfirm: async () => {
                                        // Realizar la transacción para quitar stock
                                        try {
                                            const payload = {
                                                IdLoteSelected: null,
                                                color_size: [],
                                                date_of_due: null,
                                                has_color_size: row.has_color_size,
                                                id: null,
                                                inventory_transaction_id: "01",
                                                item_id: row.id,
                                                lot_code: null,
                                                lots: [],
                                                lots_enabled: row.lots_enabled,
                                                lots_group: [],
                                                quantity: String(qty !== null ? Number(qty).toFixed(2) : "0"),
                                                series_enabled: row.series_enabled,
                                                type: "output",
                                                warehouse_id: selectedWarehouseId
                                            };

                                            // usar this.$http si está disponible, sino fetch
                                            let tranRes;
                                            if (this.$http && typeof this.$http.post === "function") {
                                                tranRes = await this.$http.post(`/inventory/transaction`, payload);
                                                // algunos wrappers ponen la data en tranRes.data
                                                tranRes = tranRes && tranRes.data ? tranRes.data : tranRes;
                                            } else {
                                                const r = await fetch(`/inventory/transaction`, {
                                                    method: "POST",
                                                    headers: { "Content-Type": "application/json" },
                                                    body: JSON.stringify(payload)
                                                });
                                                tranRes = await r.json();
                                            }

                                            if (tranRes && (tranRes.success === false || tranRes.success === undefined && tranRes.error)) {
                                                throw new Error(tranRes.message || "No se pudo quitar el stock");
                                            }

                                            // una vez quitado el stock, reintentar inhabilitar
                                            const retry = await this.disableItemInWarehouse(id, selectedWarehouseId);
                                            if (retry && retry.success) {
                                                return retry;
                                            }

                                            throw new Error(retry && retry.message ? retry.message : "No se pudo inhabilitar luego de quitar stock");
                                        } catch (err) {
                                            throw new Error(err.message || err);
                                        }
                                    }
                                });

                                if (confirmRemove && confirmRemove.isConfirmed) {
                                    // el preConfirm del segundo modal ya devolvió el resultado final (o lanzó),
                                    // Swal.fire espera el valor devuelto; como ya usamos swal internamente,
                                    // devolver un objeto de éxito para que el flujo principal lo considere confirmado.
                                    // Si el segundo modal devolvió valor en confirmRemove.value lo regresamos.
                                    return confirmRemove.value || { success: true, message: "Inhabilitado luego de quitar stock" };
                                }

                                // si el usuario canceló quitar stock, mostramos mensaje de validación
                                swal.showValidationMessage("Operación cancelada: el producto sigue teniendo stock en ese almacén");
                                return false;
                            }

                            // Caso general: mostrar el mensaje de error como validación
                            swal.showValidationMessage(message || "No se pudo inhabilitar el producto");
                            return false;
                        } catch (error) {
                            swal.showValidationMessage(`Error: ${error}`);
                        }
                    },
                    allowOutsideClick: () => !swal.isLoading()
                }).then(result => {
                    if (result.isConfirmed) {
                        swal.fire({
                            title: "¡Inhabilitado!",
                            text: result.value && result.value.message ? result.value.message : "Operación realizada",
                            icon: "success"
                        });
                        this.$eventHub.$emit("reloadData");
                    }
                });
            });
        },
        clickEnableItem(id) {
            this.getWarehouses().then(warehouses => {
                swal.fire({
                    title: "Habilitar Producto", // Título diferente
                    icon: "info", // Icono diferente
                    text: "¿En qué almacén desea habilitar el producto?",
                    input: "select",
                    inputOptions: warehouses,
                    inputPlaceholder: "Seleccionar almacén",
                    inputValue: "1",
                    confirmButtonText: "Si, Habilitar",
                    confirmButtonColor: "#3085d6", // Color azul para habilitar
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    showLoaderOnConfirm: true,
                    preConfirm: async selectedWarehouseId => {
                        if (!selectedWarehouseId) {
                            Swal.showValidationMessage(
                                "Debe seleccionar un almacén"
                            );
                            return false;
                        }

                        try {
                            const response = await this.enableItemInWarehouse(
                                id,
                                selectedWarehouseId
                            );
                            if (response.success) {
                                return response;
                            } else {
                                Swal.showValidationMessage(response.message);
                                return false;
                            }
                        } catch (error) {
                            Swal.showValidationMessage(`Error: ${error}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then(result => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "¡Habilitado!",
                            text: result.value.message,
                            icon: "success"
                        });
                        this.$eventHub.$emit("reloadData");
                    }
                });
            });
        },
        clickDisguise(id) {
            swal.fire({
                title: "DESACTIVAR PRODUCTO?",
                text:
                    "Recuerda si se desactiva el producto ya no se podrá recuperar ni visualizar en ningún almacén",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Desactivar"
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .get(`/items/disguise/${id}`)
                        .then(response => {
                            if (response.data.success) {
                                swal.fire({
                                    title: "Desactivado",
                                    text: response.data.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                this.$eventHub.$emit("reloadData");
                            } else {
                                swal.fire({
                                    title: "Error",
                                    text: response.data.message,
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            swal.fire({
                                title: "Error",
                                text:
                                    "Hubo un problema al intentar realizar la acción",
                                icon: "error"
                            });
                        });
                }
            });
        },

        clickDisguiseEnable(id) {
            swal.fire({
                title: "HABILITAR PRODUCTO?",
                text:
                    "Recuerda si se habilita el producto ya se podrá recuperar y visualizar en todos los almacenes",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Habilitar"
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .get(`/items/enable/${id}`)
                        .then(response => {
                            if (response.data.success) {
                                swal.fire({
                                    title: "Desactivado",
                                    text: response.data.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                this.$eventHub.$emit("reloadData");
                            } else {
                                swal.fire({
                                    title: "Error",
                                    text: response.data.message,
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            swal.fire({
                                title: "Error",
                                text:
                                    "Hubo un problema al intentar realizar la acción",
                                icon: "error"
                            });
                        });
                }
            });
        },

        clickPolitica(id) {
            swal.fire({
                title: "¿ESTAS SEGURO?",
                text:
                    "recuerda al realizar este proceso se aplicara la politica de precios en todos los almacenes",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si"
            }).then(result => {
                if (result.isConfirmed) {
                    axios
                        .get(`/items/politica/${id}`)
                        .then(response => {
                            if (response.data.success) {
                                swal.fire({
                                    title: "EXITO",
                                    text: response.data.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                this.$eventHub.$emit("reloadData");
                            } else {
                                swal.fire({
                                    title: "Error",
                                    text: response.data.message,
                                    icon: "error"
                                });
                            }
                        })
                        .catch(error => {
                            swal.fire({
                                title: "Error",
                                text:
                                    "Hubo un problema al intentar realizar la acción",
                                icon: "error"
                            });
                        });
                }
            });
        },

        getWarehouses() {
            return fetch("/items/import/tables")
                .then(response => response.json())
                .then(data => {
                    if (!data || !Array.isArray(data.warehouses)) {
                        throw new Error("Formato de datos incorrecto");
                    }

                    const warehouses = {};
                    data.warehouses.forEach(warehouse => {
                        warehouses[warehouse.id] = warehouse.description;
                    });
                    return warehouses;
                })
                .catch(error => {
                    console.error("Error al obtener almacenes:", error);
                    throw new Error("No se pudo cargar la lista de almacenes.");
                });
        },
        disableItemInWarehouse(id, warehouseId) {
            return fetch(`/items/disableItem/${id}/${warehouseId}`, {})
                .then(response => response.json())
                .catch(error => {
                    return { success: false, message: `Error: ${error}` };
                });
        },
        enableItemInWarehouse(id, warehouseId) {
            return fetch(`/items/enableItem/${id}/${warehouseId}`, {})
                .then(response => response.json())
                .catch(error => {
                    return { success: false, message: `Error: ${error}` };
                });
        }
    }
};
</script>
