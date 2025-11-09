<!-- Listado de Comprobante de Pago -->
<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <!-- <div class="col-sm-12"> -->
        <div class="card">
          <div class="card-header bg-primary rounded-top">
            <h5 class="my-0 text-white">
              <i class="icofont-barcode text-white" title="Series"></i>
              Productos Vendidos con CPE
            </h5>
          </div>

          <div class="card-body">
            <data-table :resource="resource" class="table-striped">
              <tr slot="heading" class="bg-primary">
                <th class="text-white" style="width:1%;">#</th>
                <th class="text-white" style="width:15%;">Número</th>
                <!-- <th class="text-white">Fecha Emisión</th> -->
                <th class="text-white" style="width:10%;">Tienda</th>
                <th class="text-white text-left" style="width:21%;">Cliente</th>
                <!-- <th class="text-white text-center">Dni</th> -->
                <!-- <th class="text-white">Código Interno</th>
                <th v-if="configuration.health_network" class="text-white">Categoría Principal</th> -->
                <th class="text-white" style="width:12%;">Producto</th>
                <th class="text-white" style="width:8%;">Cantidad</th>
                <th class="text-white text-end" style="width:15%;">Precio</th>
                <th class="text-white text-end" style="width:15%;">Total</th>
                <!-- <th class="text-white text-end">
                                        Pendiente
                </th>-->
                <!-- <th class="text-white text-end"></th> -->
              </tr>

              <tr></tr>
              <template slot-scope="{ index_, row }">
                <tr
                  v-for="(item, index) in row.items"
                  :key="'item-' + row.id + '-' + index"
                  :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' } "
                  
                  >
                  <td>
                    {{index == 0 ? index_ : ''}}
                  </td>
                  <td>
                    <span style="font-weight:700; font-size:1.1em;">{{ row.number_full }}</span>
                    <br />
                    {{ row.date_of_issue }}
                    <template>
                      <br />
                      <small>{{ row.time_of_issue }}</small>
                    </template>
                  </td>
                  <!-- <td class="text-center">
                    
                  </td> -->
                  <td>{{ row.establishment_description }}</td>

                  <td class="text-left">
                      <span style="font-weight:700; font-size:1.1em;">{{ row.customer.number }}</span>
                     <br>
                      <span style="font-weight:600; font-size:1.05em; font-family: Arial, Helvetica, sans-serif; color:#222;">
                        {{ row.customer.name }}
                      </span>
                     
                    
                  </td>
                  <!-- <td class="text-center"></td> -->
                  <!-- <td></td> -->
                  <td v-if="configuration.health_network">{{ item.item.barcode }}</td>
                  <td class="text-left">
                    {{ item.item.internal_id }}
                    <br />
                    {{ item.item.description }}
                  </td>
                  <td>{{ parseFloat(item.quantity).toFixed(2) }}</td>
                  <td class="text-end">{{ parseFloat(item.unit_value).toFixed(2) }}</td>
                  <td class="text-end">{{ parseFloat(item.total).toFixed(2) }}</td>
                </tr>
              </template>
            </data-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DataTable from "../../../components/DataTableVenta.vue";
import { deletable } from "../../../mixins/deletable";
/* import DetractionPayments from "./detraction_payments.vue"; */
export default {
  mixins: [deletable],
  props: ['configuration'],
  components: {
    DataTable
    /* DetractionPayments */
  },
  data() {
    return {
      showDialogDocumentSalud: false,
      showDialogReportPayment: false,
      showDialogVoided: false,
      showImportDialog: false,
      showDialogCDetraction: false,
      showDialogValidate: false,
      showImportSecondDialog: false,
      resource: "documents_ventas",
      recordId: null,
      showDialogOptions: false,
      showDialogPayments: false,
      closeBox: false,
      showDialogEdit: false,
      loading_data: false,
      editDocument: false,
      documents: [],
      print: false,
      columns: {
        sale_note: {
          title: "Nota de venta",
          visible: true
        },
        dispatch: {
          title: "Guia de remisión",
          visible: true
        },
        igv: {
          title: "T.Igv",
          visible: false
        },
        total_value: {
          title: "T. Gravado",
          visible: false
        },
        boxes: {
          title: "Metodo de pago",
          visible: true
        },
        notes: {
          title: "Notas C/D",
          visible: false
        },
        user_name: {
          title: "Usuario",
          visible: true
        },
        total_exportation: {
          title: "T.Exportación",
          visible: false
        },
        total_free: {
          title: "T.Gratuito",
          visible: false
        },
        total_unaffected: {
          title: "T.Inafecto",
          visible: false
        },
        total_exonerated: {
          title: "T.Exonerado",
          visible: false
        },
        date_of_due: {
          title: "F. Vencimiento",
          visible: false
        }
      }
    };
  },
  created() {
    // this.$http.get(`/${this.resource}/tables`)
    //         .then(response => {
    //           this.closeBox=response.data.closebox
    //         })
  },
  methods: {
    clickDocumentSalud() {
      this.showDialogDocumentSalud = true;
    },
    teclasInit() {
      document.onkeydown = e => {
        const key = e.key;
        if (key == "F3") {
          //Agregar cliente
          location.href = `/${this.resource}/create`;
        }
      };
    },

    clickVoided(recordId = null) {
      this.recordId = recordId;
      this.showDialogVoided = true;
    },
    clickNuevo() {
      location.href = `/${this.resource}/create`;
    },
    clickDownload(download) {
      window.open(download, "_blank");
    },
    clickResend(document_id) {
      this.$http
        .get(`/${this.resource}/send/${document_id}`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
        });
    },
    clickSendOnline(document_id) {
      this.$http
        .get(`/${this.resource}/send_server/${document_id}/1`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success("Se envio satisfactoriamente el comprobante.");
            this.$eventHub.$emit("reloadData");

            this.clickCheckOnline(document_id);
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
        });
    },
    clickCheckOnline(document_id) {
      this.$http
        .get(`/${this.resource}/check_server/${document_id}`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success("Consulta satisfactoria.");
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
        });
    },
    clickCDetraction(recordId) {
      this.recordId = recordId;
      this.showDialogCDetraction = true;
    },
    async checkResume() {
      try {
        this.loading_data = true;
        const response = await this.$http.get(`/documents/check_summarie`);
        if (response.data.success) {
          this.$toast.success(response.data.message);
          this.$eventHub.$emit("reloadData");
        } else {
          this.$toast.error(response.data.message);
        }
      } catch (e) {
        this.$toast.error(e.response.data.message);
      } finally {
        this.loading_data = false;
      }
    },
    async clickResume() {
      try {
        this.loading_data = true;
        const response = await this.$http.get(`/documents/create_summarie`);
        if (response.data.success) {
          this.$toast.success(response.data.message);
          this.$eventHub.$emit("reloadData");
        } else {
          this.$toast.error(response.data.message);
        }
      } catch (e) {
        this.$toast.error(e.response.data.message);
      } finally {
        this.loading_data = false;
      }
    },
    clickValidarCpe(document_id) {
      this.loading_data = false;
      this.$http
        .get(`/${this.resource}/validate/${document_id}`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
          this.loading_data = false;
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
          this.loading_data = false;
        });
      this.loading_data = false;
    },
    clickEdit(recordId = null) {
      location.href = `/${this.resource}/create/${recordId}`;
    },
    clickOptions(recordId = null, printer) {
      this.recordId = recordId;
      this.showDialogOptions = true;
      this.print = printer;
    },
    clickReStore(document_id) {
      this.$http
        .get(`/${this.resource}/re_store/${document_id}`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
        });
    },
    tooltip(row, message = true) {
      if (message) {
        if (row.shipping_status) return row.shipping_status.message;

        if (row.sunat_shipping_status) return row.sunat_shipping_status.message;

        if (row.query_status) return row.query_status.message;
      }

      if (row.shipping_status || row.sunat_shipping_status || row.query_status)
        return true;

      return false;
    },
    clickPayment(recordId) {
      this.recordId = recordId;
      this.showDialogPayments = true;
    },
    clickChangeToRegisteredStatus(document_id) {
      this.$http
        .get(`/${this.resource}/change_to_registered_status/${document_id}`)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          this.$toast.error(error.response.data.message);
        });
    },
    clickImport() {
      this.showImportDialog = true;
    },
    clickValidate() {
      this.showDialogValidate = true;
    },
    clickDownloadReportPagos(type) {
      window.open(`/${this.resource}/payments/${type}`, "_blank");
    },
    clickImportSecond() {
      this.showImportSecondDialog = true;
    },
    clickDeleteDocument(document_id) {
      this.destroy(
        `/${this.resource}/delete_document/${document_id}`
      ).then(() => this.$eventHub.$emit("reloadData"));
    },
    clickReportPayments() {
      this.showDialogReportPayment = true;
    }
  },
  mounted() {
    this.teclasInit();
    //prueba haber
    //nada
  }
};
</script>


