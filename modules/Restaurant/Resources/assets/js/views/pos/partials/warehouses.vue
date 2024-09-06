<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="open"
    append-to-body
    top="7vh"
    v-loading="loading"
    :close-on-click-modal="false"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <el-tabs tab-position="top" type="card" v-model="activeName" @tab-click="getRecords">
          <el-tab-pane label="Ultimas Ventas" name="sales_">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class>#</th>
                      <th class>Fecha</th>
                      <th class="text-center">Documento</th>
                      <th class="text-center">Cliente</th>
                      <th class="text-center">Cantidad</th>
                      <th class="text-end">Precio</th>
                      <th class="text-end">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(sale, index) in sales " :key="index">
                      <td>{{ customIndex(index)}}</td>
                      <td>{{ sale.date_of_issue }}</td>
                      <td class="text-center">{{ sale.series }}-{{ sale.number }}</td>
                      <td class="text-center">
                        {{ sale.customer_name }}
                        <br />
                        {{sale.customer_number}}
                      </td>
                      <td class="text-center">{{ parseFloat(sale.quantity).toFixed(2) }}</td>
                      <td class="text-end">{{ parseFloat(sale.unit_value).toFixed(2) }}</td>
                      <td class="text-end">{{ sale.total }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="Ultimas Compras" name="purchases_">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class>#</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Documento</th>
                      <th class="text-center">Proveedor</th>
                      <th class="text-center">Cantidad</th>
                      <th class="text-end">Precio</th>
                      <th class="text-end">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(purchase, index) in purchases " :key="index">
                      <td>{{ customIndex(index,'purchases_') }}</td>
                      <td>{{ purchase.date_of_issue }}</td>
                      <td class="text-center">{{ purchase.series }}-{{ purchase.number }}</td>
                      <td class="text-center">
                        {{ purchase.supplier_name }}
                        <br />
                        {{ purchase.supplier_number }}
                      </td>
                      <td class="text-center">{{ parseFloat(purchase.quantity).toFixed(2) }}</td>
                      <td class="text-center">{{ parseFloat(purchase.unit_value).toFixed(2) }}</td>
                      <td class="text-end">{{ purchase.total }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </el-tab-pane>
          <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="activeName == 'sales_' ? pagination.sales.total : pagination.purchases.total"
            :current-page="activeName == 'sales_' ? pagination.sales.current_page : pagination.purchases.current_page"
            :page-size="activeName == 'sales_' ? pagination.sales.per_page : pagination.purchases.per_page"
          ></el-pagination>
          <!-- <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
          ></el-pagination>-->
        </el-tabs>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button @click.prevent="close()">
          <i class="fas fa-times fa-lg"></i>
          Cerrar
        </el-button>
      </div>
    </form>

    <inventories-stock
      :user="user"
      :showDialog.sync="showDialogStock"
      :recordId="recordId"
      :config="config"
    ></inventories-stock>
  </el-dialog>
</template>

<script>
import InventoriesStock from "../../../../../../../../resources/js/views/items/partials/stock.vue";
// import queryString
export default {
  components: { InventoriesStock },
  props: [
    "user",
    "showDialog",
    "warehouses",
    "unit_type",
    "itemId",
    "hasSerie",
    "item",
    "config",
    "record"
  ],
  data() {
    return {
      isRequesting: false,
      activeName: "sales_",
      showDialogStock: false,
      showImportDialog: false,
      resource: "items",
      total: 0,
      recordId: null,
      titleDialog: "Historial de venta y Compra",
      series: null,
      loading: false,
      maxDescription: "",
      ventas: "sales",
      sales: [],
      purchases: [],
      pagination: {
        sales: {},
        purchases: {}
      },
      itemlocal: null
    };
  },
  created() {
    this.$eventHub.$on("reloadData", () => {
      this.close();
    });

    //console.log(this.typeUser)
  },
  mounted() {
    this.getsales();
    this.getpurchases();
  },
  methods: {
    customIndex(index, type = "sales_") {
      //2
      //5 * (1 - 1) + 0 + 1 = 5 * (0) + 0 + 1 = 1
      //5 * (2 -1) +2 + 1 = 8
      let per_page =
        type == "sales_"
          ? this.pagination.sales.per_page
          : this.pagination.purchases.per_page;
      let current_page =
        type == "sales_"
          ? this.pagination.sales.current_page
          : this.pagination.purchases.current_page;

      return per_page * (current_page - 1) + index + 1;
    },
    async getRecords(page = 1) {
      this.loading = true;
      console.log("ac: ", this.activeName);
      if (this.activeName == "sales_") {
        this.pagination.sales.current_page = parseInt(page);
        await this.getsales(page);
      } else {
        this.pagination.purchases.current_page = parseInt(page);
        await this.getpurchases(page);
      }

      this.loading = false;
    },

    getQueryParameters(form = {}) {
      let page =
        this.activeName == "sales"
          ? this.pagination.sales.current_page
          : this.pagination.purchases.current_page;

      return queryString.stringify({
        page: page,
        isNote: this.activeName == "sales",
        column: this.typeSearch,
        value: this.value,
        id: 3,
        user: 6
      });
      //domionio.com/caja/records?page=1&isNote=true&...&..&..&..&..
    },

    // getdocument() {
    //   if (this.ventas === "sales") {
    //     this.getsales();
    //   } else if (this.ventas === "purchases") {
    //     this.getpurchases();
    //   }
    // },
    async getsales(page = 1) {
      if (!this.itemId) {
        /* this.itemlocal = this.itemId; */
        console.log("Item ID vacio");
        return;
      }
      try {
        const response = await this.$http.get(
          `/items/ultima-venta/${this.itemId}?page=${page}`
        );
        this.sales = response.data.data;
        this.pagination.sales = response.data.meta;
        this.pagination.sale.per_page = parseInt(response.data.meta.per_page);
        this.$emit("getRecords", this.pagination.sales.current_page);
      } catch (e) {
        console.log(e);
      } finally {
        this.isRequesting = false;
      }
    },
    async getpurchases(page = 1) {
      if (!this.itemId) {
        /* this.itemlocal = this.itemId; */
        console.log("Item ID vacio en compra");
        return;
      }
      try {
        const response = await this.$http.get(
          `/items/ultima-compra/${this.itemId}?page=${page}&date_of_issue=2024-05-09`
        );
        this.purchases = response.data.data;
        this.pagination.purchases = response.data.meta;
        this.pagination.purchases.per_page = parseInt(
          response.data.meta.per_page
        );
        this.$emit("getRecords", this.pagination.purchases.current_page);
      } catch (e) {
        console.log(e);
      } finally {
        this.isRequesting = false;
      }
    },
    clickStock(record) {
      this.recordId = record.id;
      this.showDialogStock = true;
    },
    async open() {
      /* this.total = this.warehouses.reduce((a, b) => a + Number(b.stock), 0); */
      this.activeName = "sales_";
      await this.getRecords();
      if (this.hasSerie) {
        this.getSeries();
      }
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>
