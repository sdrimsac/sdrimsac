<template>
  <el-dialog
    width="60%"
    :visible="showDialog"
    @open="open"
    @close="close"
    append-to-body
    :title="title"
    class="rounded-dialog"
    :close-on-click-modal="false"
  >


      <div class="">
        <div class="row">
          <div class="col-md-3">
            <!-- <label class="w-100">Por Dia</label> -->
            <el-date-picker
              v-model="date_of_issue"
              type="date"
              style="width: 100%;"
              placeholder="Buscar por dia"
              value-format="yyyy-MM-dd"
              @change="changeClearInput('date_of_issue')"
            ></el-date-picker>
          </div>
          <div class="col-md-3">
            <!-- <label class="w-100">Por Mes</label> -->
            <el-date-picker
              v-model="month_start"
              type="month"
              style="width: 100%;"
              placeholder="Buscar por mes"
              value-format="yyyy-MM"
              @change="changeClearInput('month_start')"
            ></el-date-picker>
          </div>
          <div class="col-lg-2 col-md-2 pb-2">
            <div class="form-group">
              <el-button
                class="btn_excelsmall"
                type="primary"
                icon="el-icon-tickets"
                @click.prevent="clickDownload('excel')"
              >Exportar Excel</el-button>
            </div>
          </div>
          <div class="col-md-4">
            <h3 class="fw-bold">Total Acumulado S/ {{ totalAcumulado }}</h3>
          </div>
        </div>
      </div>
  
   
    <div class="card">
      <div class="card-body mb-2" style="padding: 12px;">
        <div class="row">
          <table class="table table-striped">
            <thead style="background-color: #073f68; color: #fff;">
              <tr>
                <th style="color: #fff;">#</th>
                <th style="color: #fff;">Nombre Producto</th>
                <th style="color: #fff;">Cantidad</th>
                <th style="color: #fff;">Precio</th>
                <th style="color: #fff;">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="paginatedItems.length === 0">
                <td colspan="5">No hay productos vendidos para mostrar</td>
              </tr>
              <tr v-for="(item, index) in paginatedItems" :key="index">
                <td>{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}</td>
                <td>{{ item.item }}</td>
                <td>{{ Number(item.quantity) }}</td>
                <td>{{ Number(item.unit_price).toFixed(2) }}</td>
                <td>{{ Number(item.total_price).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div>
          <el-pagination
            layout="total, prev, pager, next"
            :total="combinedItems.length"
            :current-page.sync="pagination.current_page"
            :page-size="pagination.per_page"
            @current-change="handlePageChange"
          ></el-pagination>
        </div>
      </div>
    </div>
    
  </el-dialog>
</template>

<style>
.el-dialog {
  border-radius: 10px;
  overflow: hidden;
}
</style>

<script>
export default {
  props: ["showDialog", "sellerId", "sellers"],
  data() {
    return {
      /* title: null, */
      errors: {},
      form: {},
      loading_submit: false,
      loading_submitI: false,
      timer: null,
      groupedItems: [],
      resource: "sellers",
      date_of_issue: null,
      month_start: null,
      /* pagination: {}, */
      pagination: {
        current_page: 1,
        per_page: 10
      },
      sold_items: [],
      salesItems: [],
      combinedItems: []
    };
  },
  computed: {
    title() {
      console.log(this.sellers);
      const seller = this.sellers.find(seller => seller.id === this.sellerId);
      const sellerName = seller ? seller.name : "Vendedor Desconocido";
      return `${sellerName} -  Lista de Productos Vendidos`;
    },
    paginatedItems() {
      if (!this.combinedItems || this.combinedItems.length === 0) {
        return [];
      }
      const start =
        (this.pagination.current_page - 1) * this.pagination.per_page;
      const end = start + this.pagination.per_page;
      return this.combinedItems.slice(start, end);
    },
    totalAcumulado() {
      if (!this.combinedItems || this.combinedItems.length === 0) {
        return 0;
      }
      return this.combinedItems
        .reduce((sum, item) => {
          return sum + Number(item.total_price || 0);
        }, 0)
        .toFixed(2);
    }
  },
  methods: {
    /* combineItems() {
      this.sold_items = [...this.sold_items, ...this.salesItems];
    }, */
    combineItems() {
      this.combinedItems = [...this.sold_items, ...this.salesItems];
    },
    Params() {
      return {
        sellerId: this.sellerId,
        date_of_issue: this.date_of_issue,
        month_start: this.month_start
      };
    },
    clickDownload() {
      let params = this.Params();
      let queryString = new URLSearchParams(params).toString();
      window.open(`/${this.resource}/list-product?${queryString}`, "_blank");
    },
    productSeller() {
      const params = {
        sellerId: this.sellerId,
        date_of_issue: this.date_of_issue,
        month_start: this.month_start
      };

      // Make the API call with filters
      this.$http
        .get(`/${this.resource}/product_seller`, { params })
        .then(response => {
          this.sold_items = response.data.data[0].sold_items || [];
          this.salesItems = response.data.data[0].salesItems || [];
          this.combineItems();
          /* this.sold_items = response.data.data[0].sold_items || []; */
          this.pagination = response.data.meta || {};
        })
        .catch(error => {
          console.error(error);
        });
    },
    changeClearInput(inputType) {
      if (inputType === "date_of_issue") {
        this.month_start = null;
      } else if (inputType === "month_start") {
        this.date_of_issue = null;
      }
      this.productSeller();
    },
    handlePageChange(page) {
      this.pagination.current_page = page;
    },
    open() {
      this.productSeller();
      console.log("ver passar el id del vendedor", this.sellerId);
      console.log("ver los item vendidos", this.sold_items);
    },
    close() {
      this.ListSoldItems = [];
      this.$emit("update:showDialog", false);
    }
  }
};
</script>
