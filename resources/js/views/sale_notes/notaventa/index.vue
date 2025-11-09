<!-- Modulo de Notas de Venta -->
<template>
  <div>
    <div class="container-fluid ">
      <div class="card ">
        <div class="card-header bg-primary">
          <h4 class="my-0 text-white">
            <i class="fas fa-file-alt"></i>
            Productos Vendidos Nota De Venta
          </h4>
        </div>
        <div class="card-body">
          <data-table :resource="resource">
            <tr slot="heading" class="bg-primary">
              <th class="text-white" style="width:5%;">#</th>
              <th class="text-white text-center" style="width:10%;">Comprobante</th>
              <th class="text-center text-white" style="width:10%;">Tienda</th>
              <th class="text-left text-white" style="width:30%;">Cliente</th>
              <th class="text-left text-white" style="width:30%;">Producto</th>
              <th class="text-center text-white" style="width:7%;">Cantidad</th>
              <th class="text-center text-white" style="width:8%;">Precio</th>
              <th class="text-white text-end" style="width:10%;">Total</th>
            </tr>

            <tr></tr>
            <template slot-scope="{ index_, row }">
              <tr v-for="(item, index) in row.items" :key="'item-' + (row.id || index_) + '-' + index" :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                <td>{{  index == 0 ? index_ : '' }}</td>
                <td  class="text-center">
                  {{ row.series }}-{{ row.alone_number }}
                  <br>
                  {{ row.date_of_issue }}
                  <template>
                  <br />
                  <small>{{ row.time_of_issue }}</small>
                </template>
                </td>
                <td class="text-center">{{ row.establishment_description }}</td>
                <td class="text-left">
                          {{ row.client_number }}
                  <br>
                          <span style="font-weight: bold; font-size: 1.15em;">{{ row.client_name }}</span>
                </td>
                <td class="text-left">
                  <span style="font-weight: bold; font-size: 1.1em;">{{ item.item.internal_id }}</span>
                  <br>
                  <span style="font-weight: bold; font-size: 1.15em;">{{ item.item.description }}</span>
                </td>
                
                <td class="text-center">{{ parseFloat(item.quantity).toFixed(2) }}</td>
                <td class="text-end">{{ parseFloat(item.unit_value).toFixed(2) }}</td>
                <td class="text-end">{{ parseFloat(item.total).toFixed(2) }}</td>
              </tr>
            </template>
          </data-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DataTable from "../../../components/DataTableSaleNoteVenta.vue";
export default {
  props: [
    "just_sale_notes",
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

      resource: "nota_venta",
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
    clickDownload(external_id) {
      window.open(`/sale-notes/downloadExternal/${external_id}`, "_blank");
    },
    clickSchedule(recordId) {
      window.open(`/sale-notes/schedule/${recordId}`, "_blank");
    },
    clickContract(recordId) {
      window.open(`/sale-notes/contract/${recordId}`, "_blank");
    },
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
