<!-- Modulo de Notas de Venta -->
<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h6>
              <span>Productos Comprados </span>
            </h6>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/dashboard">Dashbodard</a>
              </li>
              <li class="breadcrumb-item active">
                <span class="text-muted">Productos Comprados</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid p-l-0 p-r-0">
      <div class="card mb-0">
        <div class="card-header bg-primary">
          <h4 class="my-0 text-white">
            <i class="fas fa-file-alt"></i>
            Productos Comprados
          </h4>
        </div>
        <div class="card-body">
          <data-table :resource="resource">
            <tr slot="heading" class="bg-primary">
              <th class="text-white">#</th>
              <th class="text-white text-center">Numero</th>
              <th class="text-white text-center">Fecha Emisión</th>
              <th class="text-center text-white">Establecimiento</th>
              <th class="text-center text-white">Codigo Interno</th>
              <th class="text-center text-white">Producto</th>
              <th class="text-center text-white">Cantidad</th>
              <th class="text-center text-white">Precio</th>
              <th class="text-white text-end">Total</th>
            </tr>

            <tr></tr>
            <template slot-scope="{ index_, row }">
              <tr v-for="(item, index) in row.items" :key="'item-' + (row.id || index_) + '-' + index">
                <td>{{  index == 0 ? index_ : '' }}</td>
                <td  class="text-center">{{ row.number }}-{{ row.alone_number }}</td>

                <td class="text-center">{{ row.date_of_issue }}
                  <template>
                  <br />
                  <small>{{ row.time_of_issue }}</small>
                </template>
                </td>
                <td class="text-center">{{ row.establishment_description }}</td>
                <td class="text-center">{{ item.internal_id }}</td>
                <td class="text-center">{{ item.description }}</td>
                <td class="textcenter">{{ parseFloat(item.quantity).toFixed(2) }}</td>
                <td class="text-center">{{ parseFloat(item.unit_price).toFixed(2) }}</td>
                <td class="text-end">{{ parseFloat(item.total).toFixed(2) }}</td>
              </tr>
            </template>
          </data-table>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
td {
  color: #000;
}
</style>
<script>
import DataTable from "../../../components/DataTableShopping.vue";
export default {
  props: [
    "shopping",
    "soapCompany",
    "company",
    "configuration",
    "user_type"
  ],
  components: {
    DataTable
  },
  data() {
    return {
      cashId: null,

      resource: "shopping",
      saleNotesNewId: null,
      recordId: null,
      currentNumber: null,
      boxes: [],
      editSale: false,
      showDialogOptions: false
    };
  },
  created() {},
  mounted() {
    /* this.$getCashId().then(() => {
      this.cashId = this.$cashId;
    }); */
  },
  methods: {
    /* clickDownload(external_id) {
      window.open(`/sale-notes/downloadExternal/${external_id}`, "_blank");
    }, */
    /* clickSchedule(recordId) {
      window.open(`/sale-notes/schedule/${recordId}`, "_blank");
    }, */
    /* clickContract(recordId) {
      window.open(`/sale-notes/contract/${recordId}`, "_blank");
    }, */
    changeConcurrency(row) {
      // console.log(row)
      this.$http
        .post(`/${this.resource}/enabled-concurrency`, row)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.log(error);
          }
        })
        .then(() => {});
    }
  },
  
};
</script>
