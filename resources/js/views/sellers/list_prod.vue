<template>
  <el-dialog
    width="70%"
    v-if="sellerId"
    :visible="showDialog"
    @open="open"
    @close="close"
    append-to-body
    :title="title"
    class="rounded-dialog"
    :close-on-click-modal="false"
  >
    <br />
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <label class="w-100">Por Dia</label>
            <el-date-picker
              v-model="search.date_of_issue"
              type="date"
              style="width: 100%;"
              placeholder="Buscar por dia"
              value-format="yyyy-MM-dd"
              @change="changeClearInput('date_of_issue')"
            ></el-date-picker>
          </div>
          <div class="col-md-4">
            <label class="w-100">Por Mes</label>
            <el-date-picker
              v-model="search.month_start"
              type="month"
              style="width: 100%;"
              placeholder="Buscar por mes"
              value-format="yyyy-MM"
              @change="changeClearInput('date_of_issue')"
            ></el-date-picker>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in sold_items" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.item }}</td>
                <td>{{ Number(item.quantity) }}</td>
                <td>{{ Number(item.unit_price) }}</td>
                <td>{{ Number(item.total_price) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <span slot="footer" class="dialog-footer">
      <el-button icon="fas fa-times" @click="close">Cancelar</el-button>
    </span>
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
  props: ["showDialog", "sellerId", "sold_items", "sellers"],
  data() {
    return {
      /* title: null, */
      errors: {},
      form: {},
      loading_submit: false,
      loading_submitI: false,
      timer: null,
      groupedItems: [],
      resource: "sellers"
    };
  },
  computed: {
    title() {
      console.log(this.sellers);
      const seller = this.sellers.find(seller => seller.id === this.sellerId);
      const sellerName = seller ? seller.name : "Vendedor Desconocido";
      return `${sellerName} - Productos Vendidos`;
    }
  },
  methods: {
    productSeller() {
      this.$http
        .get(`/${this.resource}/product_seller`, {
          params: { sellerId: this.sellerId }
        })
        .then(response => {
          console.log("Datos recibidos:", response.data.data);
          this.groupedItems = response.data.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    open() {
      this.productSeller();
      /* this.groupItems(); */
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
