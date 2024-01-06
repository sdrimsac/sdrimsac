<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6><span>Productos</span></h6>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <span class="text-muted"
                                    >Lista de Productos</span
                                >
                            </li>
                        </ol>
                    </div>
                    <div
                        class="col-12 col-md-6 d-flex align-items-start justify-content-end"
                    >
                        <!-- Contact Button Start -->
                        <button
                            type="button"
                            class="btn btn-outline-primary btn-icon btn-icon-start btn-sm"
                            @click.prevent="clickCreate()"
                        >
                            <i data-cs-icon="plus"></i>
                            <span>Nuevo</span>
                        </button>
                        <button
                            class="btn btn-sm btn-icon btn-icon-only btn-outline-primary align-top float-end"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            aria-haspopup="true"
                        >
                            <i data-cs-icon="more-horizontal"></i>
                        </button>
                        <div
                            class="dropdown-menu dropdown-menu-sm dropdown-menu-end"
                        >
                            <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click.prevent="clickImport()"
                            >
                                <i class="fa fa-upload"></i> Importar</a
                            >
                            <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click.prevent="clickImportListPrice()"
                            >
                                <i class="fa fa-upload"></i> Importar lista de
                                precios</a
                            >
                        </div>
                        <!-- <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click.prevent="clickCreate()">
                        <i class="icofont-plus-circle"></i>
                        <span>Nuevo</span>
                    </button>

                    <div class="btn-group flex-wrap">
                    <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-upload"></i> Importar <span class="caret"></span></button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                        <a class="dropdown-item" href="#" @click.prevent="clickImport()">Importar Productos</a>
                    </div>
                 </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="card mb-0">
                <div class="card-header bg-primary">
                    <h6 class="my-0 text-white">Listado de productos</h6>
                </div>
                <div class="card-body">
                    <data-table
                        :typeUser="typeUser"
                        :resource="resource"
                        :config="config"
                        @clickReport="clickReport"
                        @clickReportForImport="clickReportForImport"
                    >
                        <tr slot="heading" width="100%">
                            <th>#</th>
                            <th>Cód. Interno</th>
                            <th>Unidad</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Cód. SUNAT</th>
                            <th class="text-left">Stock</th>
                            <th class="text-end">P.Unitario (Venta)</th>
                            <th v-if="typeUser != 'seller'" class="text-end">
                                P.Unitario (Compra)
                            </th>
                            <th class="text-center">Tiene Igv</th>
                            <th class="text-end">Acciones</th>
                        </tr>

                        <tr></tr>
                        <tr
                            slot-scope="{ index, row }"
                            :class="{ disable_color: !row.active }"
                        >
                            <td>{{ index }}</td>
                            <td>{{ row.internal_id }}</td>
                            <td>{{ row.unit_type_id }}</td>
                            <td>{{ row.description }}</td>
                            <td>{{ row.second_name }}</td>
                            <td>{{ row.item_code }}</td>
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
                                <!-- <template v-for="item in row.warehouses">
                                <template>{{item.stock}} - {{item.warehouse_description}}</template><br>
                            </template> -->

                                <!-- <br/>Mín:{{ row.stock_min }} -->
                            </td>
                            <td class="text-end">{{ row.sale_unit_price }}</td>
                            <td v-if="typeUser != 'seller'" class="text-end">
                                {{ row.purchase_unit_price }}
                            </td>
                            <td class="text-center">
                                {{ row.has_igv_description }}
                            </td>
                            <td class="text-end">
                                <template
                                    v-if="
                                        typeUser === 'admin' ||
                                            typeUser == 'superadmin'
                                    "
                                >
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-info"
                                        @click.prevent="clickCreate(row.id)"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDelete(row.id)"
                                    >
                                        Eliminar
                                    </button>

                                    <!-- <button type="button" class="btn waves-effect waves-light btn-sm btn-warning" @click.prevent="duplicate(row.id)">Duplicar</button> -->
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickDisable(row.id)"
                                        v-if="row.active"
                                    >
                                        Inhabilitar
                                    </button>
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-primary"
                                        @click.prevent="clickEnable(row.id)"
                                        v-else
                                    >
                                        Habilitar
                                    </button>
                                    <!--

                                <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" @click.prevent="clickBarcode(row)">Cod. Barras</button>
                                <button
                                type="button"
                                class="btn waves-effect waves-light btn-sm btn-primary"
                                @click.prevent="clickPrintBarcode(row)"
                                >
                                Etiquetas
                                </button> -->
                                </template>
                            </td>
                        </tr>
                    </data-table>
                </div>

                <items-form
                    :showDialog.sync="showDialog"
                    :recordId.sync="recordId"
                ></items-form>

                <items-import
                    :showDialog.sync="showImportDialog"
                ></items-import>

                <warehouses-detail
                    :showDialog.sync="showWarehousesDetail"
                    :unit_type.sync="unit_type"
                    :warehouses="warehousesDetail"
                    :hasSerie="hasSerie"
                    :itemId="itemId"
                    :item="currentItem"
                    :config="config"
                    :user="user"
                >
                </warehouses-detail>

                <items-import-list-price
                    :showDialog.sync="showImportListPriceDialog"
                ></items-import-list-price>
            </div>
        </div>
    </div>
</template>
<script>
import ItemsForm from "./form.vue";
import WarehousesDetail from "./partials/warehouses.vue";
import ItemsImport from "./import.vue";
import ItemsImportListPrice from "./partials/import_list_price.vue";
import DataTable from "../../components/DataTable.vue";
import { deletable } from "../../mixins/deletable";
//const  ItemsForm = () =>  import(/* webpackChunkName:"js/form.vue"*/"./form.vue");
//const  WarehousesDetail = () =>  import(/* webpackChunkName:"js//partials/warehouses.vue"*/"./partials/warehouses.vue");
//const  ItemsImport = () =>  import(/* webpackChunkName:"js/import.vue"*/"./import.vue");
//const  ItemsImportListPrice = () =>  import(/* webpackChunkName:"js/partials/import_list_price.vue"*/"./partials/import_list_price.vue");
//const  DataTable = () =>  import(/* webpackChunkName:"js/components/DataTable.vue"*/"../../components/DataTable.vue");

export default {
    props: ["typeUser", "user"],
    mixins: [deletable],
    components: {
        ItemsForm,
        ItemsImport,
        DataTable,
        WarehousesDetail,
        ItemsImportListPrice
    },
    data() {
        return {
            currentItem: null,
            showDialog: false,
            showImportDialog: false,
            showImportListPriceDialog: false,
            showWarehousesDetail: false,
            resource: "items",
            recordId: null,
            warehousesDetail: [],
            unit_type: [],
            hasSerie: false,
            itemId: null,
            config: {}
        };
    },
    created() {

        this.$http.get(`/configurations/record`).then(response => {
            this.config = response.data.data;
        });
    },
    methods: {
        clickReportForImport(query = null) {
   let { column, value, warehouse_id, area_id } = query;
            window.open(
                `/items/excel-for-import?column=${column || ""}&value=${value ||
                    ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id ||
                    ""}`,
                "_blank"
            );
        },
        clickReport(query = null) {
            let { column, value, warehouse_id, area_id } = query;
            window.open(
                `/items/excel?column=${column || ""}&value=${value ||
                    ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id ||
                    ""}`,
                "_blank"
            );
        },
        duplicate(id) {
            this.$http
                .post(`${this.resource}/duplicate`, { id })
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
        clickWarehouseDetail(id, hasSerie, warehouses, unit_type, item) {
            this.currentItem = item;
            this.itemId = id;
            this.hasSerie = hasSerie;

            this.warehousesDetail = warehouses;
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
        }
    }
};
</script>
