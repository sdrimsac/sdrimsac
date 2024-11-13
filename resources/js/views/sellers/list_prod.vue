<template>
  <el-dialog
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in groupedItems" :key="index">
                <td>{{ item.item }}</td>
                <td>{{ Number(item.quantity)}}</td>
                <td>{{ Number(item.unit_price)}}</td>
                <td>{{ Number(item.total_price)}}</td>
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
  /* watch: {
    sold_items: {
      handler() {
        this.groupItems();
      },
      immediate: true
    }
  }, */
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
          console.log("Datos recibidos:", response.data);
          this.records = response.data.data;

        })
        .catch(error => {
          console.error(error);
        });
    },

    /* getData() {
      this.$http.get(`/${this.resource}/records`).then(response => {
        console.log("Datos de vendedores:", response.data.data);
        this.records = response.data.data;
        this.sellers = response.data.data;
      });
    }, */

    /* groupItems() {
      const grouped = {};

      this.sold_items.forEach(item => {
        if (grouped[item.item_id]) {
          grouped[item.item_id].total_quantity += item.quantity;
          grouped[item.item_id].total_price += item.total_price;
        } else {
          
          grouped[item.item_id] = {
            item: item.item,
            item_id: item.item_id,
            quantity: item.quantity,
            total_price: item.total_price,
            unit_price: item.unit_price,
            total_quantity: item.quantity
          };
        }
      });

      this.groupedItems = Object.values(grouped);
    }, */
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
