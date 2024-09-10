<!-- Modulo Listado de productos -->
<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h6>
              <span>Productos</span>
            </h6>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                <span class="text-muted">Lista de Productos</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="card mb-0">
        <div class="card-header bg-primary">
          <h4 class="my-0 text-white">
            <i class="fas fa-box"></i>
            Listado de productos
          </h4>
        </div>

        <div class="data-table-visible-columns">
          <el-button
            type="primary"
            class
            style="margin-right: 5px;"
            href="javascript:void(0)"
            @click.prevent="clickCreate()"
          >
            <i class="fas fa-box fa-lg"></i>
            <i class="fa fa-plus"></i>
            Nuevo Producto
          </el-button>

          <button
            class="btn btn-sm btn-icon btn-icon-only btn-outline-light align-top float-end"
            style="margin-right: 5px;"
            type="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            aria-haspopup="true"
          >
            <i data-cs-icon="more-horizontal"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
            <a
              class="dropdown-item"
              href="javascript:void(0)"
              @click.prevent="clickImport()"
              style="color:green"
            >
              <i class="fa fa-upload"></i> Importar Productos
            </a>
            <a
              class="dropdown-item"
              href="javascript:void(0)"
              @click.prevent="clickImportListPrice()"
              style="color:blue"
            >
              <i class="fa fa-upload"></i> Importar Politica de Precios
            </a>
            <a
              class="dropdown-item"
              href="javascript:void(0)"
              @click.prevent="clickImportStockProducto()"
              style="color:red"
            >
              <i class="fa fa-upload"></i> Importar stock de producto
            </a>
          </div>
        </div>
        <div class="data-table-visible-columns"></div>
        <div class="card-body">
          <data-table
            :typeUser="typeUser"
            :resource="resource"
            :config="config"
            @clickReport="clickReport"
            @clickReportForImport="clickReportForImport"
            class="table-striped"
          >
            <tr slot="heading" width="100%" class="bg-primary">
              <th class="text-white text-center">Acciones</th>
              <th class="text-white">#</th>
              <th class="text-white">Cód. Interno</th>
              <th class="text-white text-center">Unidad</th>
              <th class="text-white text-center">Nombre</th>
              <th class="text-white">Descripción</th>
              <!-- <th class="text-white">Cód. SUNAT</th> -->
              <th class="text-left text-white">Stock</th>
              <th class="text-end text-white">P.Unitario (Venta)</th>
              <th v-if="typeUser != 'seller'" class="text-end text-white">P.Unitario (Compra)</th>
              <th class="text-center text-white">Tiene Igv</th>
              <th class="text-white text-center">Estado</th>
            </tr>

            <tr></tr>
            <tr slot-scope="{ index, row }" :class="{ disable_color: !row.active }">
              <td class="text-start">
                <template
                  v-if="
                                        typeUser === 'admin' ||
                                            typeUser == 'superadmin'
                                    "
                >
                  <button
                    class="btn p-0"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span
                      class="btn btn-primary dropdown-toggle"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      data-bs-delay="0"
                      title
                      data-bs-original-title="Item Count"
                      aria-label="Item Count"
                    >Acciones</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" style>
                    <a
                      type="button"
                      class="dropdown-item text-secondary"
                      @click.prevent=" clickCreate(row.id)"
                    >
                      <i class="fa fa-edit fa-lg"></i> Editar
                    </a>
                    <a
                      type="button"
                      class="dropdown-item text-danger"
                      @click.prevent="
                                    clickDelete(row.id)"
                    >
                      <i class="fa fa-trash fa-lg"></i> Eliminar
                    </a>
                    <a
                      type="button"
                      class="dropdown-item"
                      @click.prevent="clickDisable(row.id)"
                      v-if="row.active"
                    >
                      <i class="fas fa-toggle-off text-warning fa-lg"></i> Inhabilitar
                    </a>
                    <a
                      type="button"
                      class="dropdown-item"
                      @click.prevent="clickEnable(row.id)"
                      v-else
                    >
                      <i class="fas fa-toggle-on text-success fa-lg"></i> Habilitar
                    </a>
                    <!-- <a type="button" class="dropdown-item" @click.prevent="toggleActive(row.id)">
                                        <i :class="{'fas fa-check-circle text-success': row.active, 'fas fa-times-circle text-danger': !row.active}"></i>
                                        {{ row.active ? "Deshabilitar" : "Habilitar" }}
                    </a>-->
                  </div>
                </template>
              </td>
              <td>{{ index }}</td>
              <td>{{ row.internal_id }}</td>
              <td>{{ row.unit_type_id }}</td>
              <td>{{ row.description }}</td>
              <td>{{ row.second_name }}</td>
              <!-- <td>{{ row.item_code }}</td> -->
              <td>
                <div v-if="config.product_only_location == true">{{ row.stock }}</div>
                <div v-else>
                  <template
                    v-if="
                                            typeUser == 'seller' &&
                                                row.unit_type_id != 'ZZ'
                                        "
                  >{{ row.stock }}</template>
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
                </template>-->

                <!-- <br/>Mín:{{ row.stock_min }} -->
              </td>
              <td class="text-end">{{ row.sale_unit_price }}</td>
              <td v-if="typeUser != 'seller'" class="text-end">{{ row.purchase_unit_price }}</td>
              <td class="text-center">{{ row.has_igv_description }}</td>
              <td class="text-center">
                <button
                  class="btn"
                  :style="{
                                color: 'white', 
                                backgroundColor: row.active ? 'green' : 'red', 
                                fontWeight: 'bold',
                                width: '110px' 
                            }"
                >{{ row.active ? 'Habilitado' : 'Inhabilitado' }}</button>
              </td>
            </tr>
          </data-table>
        </div>

        <items-form :showDialog.sync="showDialog" :recordId.sync="recordId"></items-form>

        <items-import :showDialog.sync="showImportDialog"></items-import>

        <warehouses-detail
          :showDialog.sync="showWarehousesDetail"
          :unit_type.sync="unit_type"
          :warehouses="warehousesDetail"
          :hasSerie="hasSerie"
          :itemId="itemId"
          :item="currentItem"
          :config="config"
          :user="user"
        ></warehouses-detail>

        <items-import-list-price :showDialog.sync="showImportListPriceDialog"></items-import-list-price>
        <items-import-stock-producto :showDialog.sync="showImportStockProductoDialog"></items-import-stock-producto>
      </div>
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
import ItemsImportListPrice from "./partials/import_list_price.vue";
import DataTable from "../../components/DataTable.vue";
import ItemsImportStockProducto from "./partials/stock_producto.vue";
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
    ItemsImportListPrice,
    ItemsImportStockProducto
  },
  data() {
    return {
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
      hasSerie: false,
      itemId: null,
      config: {},
      records: []
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
          ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id || ""}`,
        "_blank"
      );
    },
    clickReport(query = null) {
      let { column, value, warehouse_id, area_id } = query;
      window.open(
        `/items/excel?column=${column || ""}&value=${value ||
          ""}&warehouse_id=${warehouse_id || ""}&area_id=${area_id || ""}`,
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
            this.$toast.success("Se guardaron los cambios correctamente.");
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
    }
  }
};
</script>
