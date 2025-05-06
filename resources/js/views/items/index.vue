<!-- Modulo Listado de productos Principal-->
<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0" v-loading="loading">
            <div class="card mb-0">
                <div
                    class="card-header bg-primary d-flex align-items-center"
                    style="padding: 15px;"
                >
                    <h4
                        class="my-0 text-white d-flex align-items-center"
                        style="font-size: 1.5rem; font-weight: bold;"
                    >
                        <i
                            class="far fa-address-book"
                            style="font-size: 2rem; margin-right: 0.5rem;"
                        ></i>
                        Módulo de Productos
                    </h4>
                </div>

                <div class="data-table-visible-columns d-flex align-items-center">
                    <el-button
                        type="primary"
                        class="btn_buscar"
                        style="margin-right: 5px;"
                        href="javascript:void(0)"
                        @click.prevent="clickSaleOffert()"
                        v-if="config.sale_offert"
                    >
                        <i class="fas fa-tag"></i>
                        Ofertas de ventas
                    </el-button>
                    <el-button
                        type="primary"
                        class="btn_buscar"
                        style="margin-right: 5px;"
                        href="javascript:void(0)"
                        @click.prevent="clickBonus()"
                        v-if="config.consolidated_quotations"
                    >
                        <i class="fas fa-gift"></i>
                        Bonificaciones
                    </el-button>
                    <el-button
                        type="primary"
                        class="btn_buscar"
                        style="margin-right: 5px;"
                        href="javascript:void(0)"
                        @click.prevent="clickCreate()"
                    >
                        <i class="fa fa-plus"></i>
                        Nuevo
                    </el-button>
                    <div class="dropdown">
                        <button
                            class="btn_buscar"
                            style="margin-right: 5px;"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                        >
                            <i data-cs-icon="more-horizontal"></i>
                        </button>
                        <div
                            class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                            v-if="typeUser === 'admin' || typeUser === 'superadmin'"
                        >
                            <a
                                class="dropdown-item text-success"
                                href="javascript:void(0)"
                                @click.prevent="clickImport()"
                            >
                                <i class="fa fa-upload me-2"></i> Importar Productos
                            </a>
                            <a
                                v-if="config.quantity_prices"
                                class="dropdown-item text-warning"
                                href="javascript:void(0)"
                                @click.prevent="clickImportListPriceRange()"
                            >
                                <i class="fa fa-upload me-2"></i> Importar Precios
                                por rango de cantidad
                            </a>
                            <a
                                class="dropdown-item text-primary"
                                href="javascript:void(0)"
                                @click.prevent="clickImportListPrice()"
                            >
                                <i class="fa fa-upload me-2"></i> Importar Política
                                de Precios
                            </a>
                            <a
                                v-if="config.quantity_prices"
                                class="dropdown-item text-dark"
                                href="javascript:void(0)"
                                @click.prevent="clickImportListPriceUnitType()"
                            >
                                <i class="fa fa-upload me-2"></i> Importar Precios
                                por rango de cantidad en política de precio
                            </a>
                            <a
                                class="dropdown-item text-danger"
                                href="javascript:void(0)"
                                @click.prevent="clickImportStockProducto()"
                            >
                                <i class="fa fa-upload me-2"></i> Importar Stock de
                                Producto
                            </a>
                            <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click.prevent="clickImportPointsValue()"
                                style="color:orange"
                            >
                                <i class="fa fa-upload"></i> Valor de puntos
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <data-table
                        :typeUser="typeUser"
                        :resource="resource"
                        :config="config"
                        @clickReport="clickReport"
                        @clickReportForImport="clickReportForImport"
                        class="table-striped"
                        ref="dataTable"
                    >
                        <tr slot="heading" width="100%" class="bg-primary">
                            <th class="text-white">#</th>
                            <th class="text-white">Acciones</th>
                            <th class="text-white">Registro Actividad</th>
                            <th class="text-white ">Cód. Interno</th>
                            <th class="text-white text-center">Unidad</th>
                            <th class="text-white text-center">Nombre</th>
                            <!-- <th class="text-white">Descripción</th> -->
                            <th class="text-white">Ubicacion</th>
                            <th class="text-left text-white">Stock</th>
                            <th class="text-white">
                                P.Venta
                            </th>
                            <!-- <th class="text-end text-white">P.Unitario (Venta) establecimiento</th> -->
                            <th
                                v-if="typeUser != 'seller'"
                                class="text-end text-white"
                            >
                                P.Compra
                            </th>
                            <!-- <th class="text-center text-white">Tiene Igv</th> -->
                            <th class="text-white text-center">Estado</th>
                        </tr>

                        <tr
                            slot-scope="{ index, row }"
                            :class="{ disable_color: !row.active }"
                        >
                            <td>{{ index + 1 }}</td>
                            <td class="text-start">
                                <template>
                                    <button
                                        class="btn btnsdr-acciones btnsdr-acciones:hover"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        style="height: 50px; font-size: 1.2rem;"
                                    >
                                        <span
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-delay="0"
                                            title
                                            data-bs-original-title="Item Count"
                                            aria-label="Item Count"
                                        >
                                            Acciones
                                        </span>
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                    >
                                        <!-- Editar -->
                                        <a
                                            type="button"
                                            class="dropdown-item text-secondary"
                                            @click.prevent="clickCreate(row.id)"
                                        >
                                            <i
                                                class="fa fa-edit fa-lg me-2"
                                            ></i>
                                            <!-- Espaciado entre icono y texto -->
                                            Editar
                                        </a>

                                        <!-- Eliminar -->
                                        <a
                                            type="button"
                                            class="dropdown-item text-danger"
                                            @click.prevent="clickDelete(row.id)"
                                        >
                                            <i
                                                class="fa fa-trash fa-lg me-2"
                                            ></i>
                                            Eliminar
                                        </a>

                                        <div class="dropdown-divider"></div>
                                        <!-- Divisor entre acciones -->

                                        <!-- Inhabilitar -->
                                        <a
                                            type="button"
                                            class="dropdown-item"
                                            @click.prevent="
                                                clickDisableItem(row.id)
                                            "
                                            v-if="
                                                row.warehouses.some(
                                                    warehouse =>
                                                        warehouse.active
                                                )
                                            "
                                        >
                                            <i
                                                class="fas fa-toggle-off text-warning fa-lg me-2"
                                            ></i>
                                            Inhabilitar
                                        </a>

                                        <!-- Habilitar -->
                                        <a
                                            type="button"
                                            class="dropdown-item"
                                            @click.prevent="
                                                clickEnableItem(row.id)
                                            "
                                            v-else
                                        >
                                            <i
                                                class="fas fa-toggle-on text-success fa-lg me-2"
                                            ></i>
                                            Habilitar
                                        </a>
                                        <a
                                            type="button"
                                            class="dropdown-item text-succcess"
                                            @click.prevent="
                                                clickDisguise(row.id)
                                            "
                                        >
                                            <i
                                                class="fas fa-toggle-on fa-lg me-2"
                                            ></i>
                                            Desactivar
                                        </a>
                                        <a
                                            type="button"
                                            class="dropdown-item text-succcess"
                                            @click.prevent="
                                                clickPolitica(row.id)
                                            "
                                        >
                                            <!-- <i
                                                class="fas fa-toggle-on fa-lg me-2"
                                            ></i> -->
                                            Politica en Todo Almacenes
                                        </a>
                                    </div>
                                </template>
                            </td>
                            <td>
                                <template
                                    v-if="
                                        row.last_register &&
                                            row.last_register.user
                                    "
                                    class="text-center"
                                >
                                    <span
                                        class="text-center fw-bold"
                                        style="font-family: Arial, sans-serif;"
                                        >{{ row.last_register.user }}</span
                                    >
                                    :
                                    <br />
                                    <span
                                        class="text-primary"
                                        style="font-family: Arial, sans-serif;"
                                        >{{
                                            row.last_register.description
                                        }}</span
                                    >
                                    <br />
                                    <span
                                        :class="
                                            `${
                                                row.last_register.date_time
                                                    .is24Hours
                                                    ? 'text-danger'
                                                    : ''
                                            }`
                                        "
                                        style="font-family: Arial, sans-serif;"
                                    >
                                        <!-- {{
                                            formatDateTime(
                                                row.last_register.date_time
                                            )
                                        }} -->
                                        {{ row.last_register.created_at }}
                                    </span>
                                </template>
                            </td>

                            <td class="text-center">{{ row.internal_id }}</td>
                            <td class="text-center">{{ row.unit_type_id }}</td>
                            <td class="text-center">
                                {{ row.description }}
                                <br />
                                {{ row.second_name }}
                            </td>
                            <!-- <td>{{ row.second_name }}</td> -->
                            <td>{{ row.location }}</td>
                            <td>
                                <div
                                    v-if="config.product_only_location == true"
                                >
                                    {{ row.stock }}
                                </div>
                                <div v-else>
                                    <template
                                        v-if="
                                            typeUser == 'seller' &&
                                                row.unit_type_id != 'ZZ'
                                        "
                                        >{{ row.stock }}</template
                                    >
                                    <template
                                        v-else-if="
                                            typeUser != 'seller' &&
                                                row.unit_type_id != 'ZZ'
                                        "
                                    >
                                        <button
                                            type="button"
                                            class="btn waves-effect waves-light btn-sm btn-info"
                                            @click.prevent="
                                                clickWarehouseDetail(
                                                    row.id,
                                                    row.has_series,
                                                    row.warehouses,
                                                    row.unit_type,
                                                    row
                                                )
                                            "
                                        >
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </template>
                                </div>
                            </td>
                            
                            <td v-if="row.warehouse_prices.length > 0">
                                <table>
                                    <tbody>
                                        <tr
                                            v-for="price in row.warehouse_prices"
                                            :key="price.id"
                                        >
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
                                <button
                                    class="btn"
                                    :style="{
                                        color: 'white',
                                        backgroundColor:
                                            Array.isArray(row.warehouses) &&
                                            row.warehouses.some(
                                                warehouse => warehouse.active
                                            )
                                                ? 'green'
                                                : 'red',
                                        fontWeight: 'bold',
                                        width: '110px'
                                    }"
                                >
                                    {{
                                        Array.isArray(row.warehouses) &&
                                        row.warehouses.some(
                                            warehouse => warehouse.active
                                        )
                                            ? "Habilitado"
                                            : "Inhabilitado"
                                    }}
                                </button>

                                <el-button
                                    v-if="
                                        typeUser == 'superadmin' &&
                                            !row.is_in_all_warehouses
                                    "
                                    type="primary"
                                    @click.prevent="
                                        clickAddProductToWarehouses(row.id)
                                    "
                                    >Agregar a todos los almacenes</el-button
                                >
                            </td>
                        </tr>
                    </data-table>
                </div>

                <items-form
                    :showDialog.sync="showDialog"
                    :recordId.sync="recordId"
                    :typeUser.sync="typeUser"
                ></items-form>
                <sale-offert
                    :showDialog.sync="showSaleOffertDialog"
                    :recordId.sync="recordId"
                ></sale-offert>
                <items-import
                    :showDialog.sync="showImportDialog"
                ></items-import>
                <items-import-points-value
                    :showDialog.sync="showImportPointsValueDialog"
                ></items-import-points-value>
                <warehouses-detail
                    :showDialog.sync="showWarehousesDetail"
                    :unit_type.sync="unit_type"
                    :warehouses="warehousesDetail"
                    :hasSerie="hasSerie"
                    :itemId="itemId"
                    :item="currentItem"
                    :config="config"
                    :user="user"
                    :allWarehouses="warehouses"
                ></warehouses-detail>
                <items-import-list-price-range-unit-type
                    :showDialog.sync="showImportListPriceUnitTypeDialog"
                ></items-import-list-price-range-unit-type>
                <items-import-list-price-range
                    :showDialog.sync="showImportListPriceRangeDialog"
                ></items-import-list-price-range>
                <items-import-list-price
                    :showDialog.sync="showImportListPriceDialog"
                ></items-import-list-price>
                <items-import-stock-producto
                    :showDialog.sync="showImportStockProductoDialog"
                ></items-import-stock-producto>
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
                .catch(error => {});
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
        clickImport() {
            this.showImportDialog = true;
        },
        clickImportListPrice() {
            this.showImportListPriceDialog = true;
        },
        clickImportStockProducto() {
            this.showImportStockProductoDialog = true;
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
        clickDisableItem(id) {
            this.getWarehouses().then(warehouses => {
                swal.fire({
                    title: "Inhabilitar Producto", // Título más claro
                    icon: "warning", // Agregar icono de advertencia
                    text: "¿En qué almacén desea inhabilitar el producto?",
                    input: "select",
                    inputOptions: warehouses,
                    inputPlaceholder: "Seleccionar almacén",
                    inputValue: "1",
                    confirmButtonText: "Si, Inhabilitar",
                    confirmButtonColor: "#d33", // Color rojo para inhabilitar
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
                            const response = await this.disableItemInWarehouse(
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
                            title: "¡Inhabilitado!",
                            text: result.value.message,
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
