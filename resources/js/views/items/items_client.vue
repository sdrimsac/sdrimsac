<template>
  <div>

    <div class="container-fluid ">
      <div class="card">
        <div class="card-header bg-primary" style="padding:10px;">
          <h5 class="my-0 text-white">
            <i class="fa fa-cubes text-white mr-2" aria-hidden="true"></i>
            <i class="fa fa-user text-white mr-2" aria-hidden="true"></i>
            Reporte de Productos X Cliente
          </h5>
        </div>
        <div class="card-body">
          <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="row ">
              <div class="col-md-4">
                <div class="form-group">
                  <!-- <label class="control-label">
                    Producto
                  </label> -->
                  <el-select class="w-100" v-model="form.item_id" filterable remote popper-class="el-select-customers"
                    clearable placeholder="Producto/Código Interno" :remote-method="searchRemoteItems"
                    :loading="loading_search_item">
                    <el-option v-for="option in items" :key="option.id" :value="option.id"
                      :label="option.description"></el-option>
                  </el-select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <!-- <label class="control-label">
                    Cliente
                  </label> -->
                  <el-select class="w-100" v-model="form.customer_id" filterable remote
                    popper-class="el-select-customers" clearable placeholder="Cliente/DNI/RUC"
                    :remote-method="searchRemoteCustomers" :loading="loading_search_item">
                    <el-option v-for="option in customers" :key="option.id" :value="option.id"
                      :label="option.name"></el-option>
                  </el-select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <!-- <label class="control-label">Fecha Inicio</label> -->
                  <el-date-picker style="width:100%;" v-model="form.date_start" value-format="yyyy-MM-dd"
                    placeholder="F.Incio" @change="checkDate"></el-date-picker>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <!-- <label class="control-label">Fecha Final</label> -->
                  <el-date-picker style="width:100%;" v-model="form.date_end" value-format="yyyy-MM-dd"
                    placeholder="F.Final" @change="checkDate"></el-date-picker>
                </div>
              </div>

            </div>

            <div class="row mt-2">
              <div class="col-md-2">
                <div class="form-group">
                  <!-- <label class="control-label">Almacén</label> -->
                  <el-select v-model="form.establishment_id" clearable filterable placeholder="Almacén">
                    <el-option v-for="option in warehouses" :key="option.id" :value="option.id"
                      :label="option.description"></el-option>
                  </el-select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <!-- <label class="control-label">Categoría</label> -->
                  <el-select v-model="form.categoria_id" clearable filterable placeholder="Categoría">
                    <el-option v-for="option in categories" :key="option.id" :value="option.id"
                      :label="option.name"></el-option>
                  </el-select>
                </div>
              </div>
              <div class="col-6 d-flex align-items-center justify-content-end">
                <el-button class="btn_guardarsmall ml-2" type="primary" @click.prevent="getRecordsByFilter"
                  :loading="loading_submit" icon="el-icon-search">
                  Buscar
                </el-button>
                <template v-if="records.length > 0">
                  <!-- <el-button class="btn_pdfsmall ml-2" type="danger" @click.prevent="clickDownload('pdf')"><i
                      class="fa fa-file-pdf"></i>
                    PDF</el-button> -->
                  <el-button class="btn_excelsmall ml-2" type="success" @click.prevent="clickDownload('excel')">
                    <i class="fa fa-file-excel"></i>
                    Excel
                  </el-button>
                  <el-button class="btn_whatsappsmall ml-2" type="success" @click.prevent="openWhastappForm()">
                    <i class="icofont-brand-whatsapp"></i>
                    WhatsApp
                  </el-button>
                </template>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table tabble-striped">
                <thead>
                  <tr slot="heading" style="background:#073f68;color:#fff;">
                    <th class="text-white" style="width:6%; min-width:36px; white-space:nowrap;">#</th>
                    <th class="text-white" style="width:65%;">Cliente</th>
                    <th class="text-white" style="width:10%;">Ver Productos</th>
                    <th class="text-white text-center" style="width:10%;">Unidades</th>
                    <th class="text-white text-right" style="width:10%;">Total</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in records" :key="index">
                    <td>
                      <span
                        style="display:inline-block; font-size:1.25rem; font-weight:700; background:#073f68; color:#fff; padding:6px 10px; border-radius:6px; min-width:36px; text-align:center;">
                        {{ index + 1 }}
                      </span>
                    </td>
                    <td>
                      <span
                        style="display:inline-block; font-size:1.2rem; padding:6px 10px; background:#e8f4ff; border-radius:6px; font-weight:600; color:#073f68;">
                        {{ row.customer_name }}
                      </span>
                      <!-- <template v-if="row.items">
                        <div class="col-12">
                          <table class="table">
                            <thead>
                              <tr slot="heading" style="background:#1e5a85;color:#fff;">
                                <th class="text-white" style="width:12%; min-width:80px; white-space:nowrap;">CPE</th>
                                <th class="text-white text-center" style="width:8%; min-width:60px;">Cant</th>
                                <th class="text-white" style="width:20%; min-width:100px;">Producto</th>
                                <th class="text-white text-center" style="width:15%; min-width:110px;">Fecha</th>
                                <th class="text-white text-right" style="width:15%; min-width:90px;">Monto</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(item, idx) in row.items" :key="idx"
                                :style="{ backgroundColor: idx % 2 === 0 ? '#ffffff' : '#f7f7f7' }">
                                <td class="align-middle" style="white-space:nowrap; padding: .35rem .75rem;">
                                  <small>
                                    <span style="font-size:1rem; font-weight:700; color:#073f68;">
                                      {{ item.document }}
                                    </span>
                                  </small>
                                </td>

                                <td class="align-middle text-center" style="width:80px; padding: .35rem .75rem;">
                                  <small>{{ isNaN(Number(item.quantity)) ? '0.00' : Number(item.quantity).toFixed(2)
                                    }}</small>
                                </td>

                                <td class="align-middle" style="width:40%; padding: .35rem .75rem;">
                                  <small class="d-block text-truncate" style="max-width:100%;">
                                    {{ item.description }}
                                    <span v-if="item.selectedAncho && item.selectedGrosor && item.selectedLargo">
                                      - {{ item.selectedAncho }}x{{ item.selectedGrosor }}x{{ item.selectedLargo }}
                                    </span>
                                  </small>
                                </td>

                                <td class="align-middle text-center" style="width:120px; padding: .35rem .75rem;">
                                  <small>{{ item.date_of_issue }}</small>
                                </td>

                                <td class="align-middle text-right" style="width:100px; padding: .35rem .75rem;">
                                  <small>{{ isNaN(Number(item.total)) ? '0.00' : Number(item.total).toFixed(2)
                                    }}</small>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </template> -->
                    </td>
                    <td>
                      <el-tooltip content="Ver productos del cliente" placement="top">
                        <el-badge :value="row.items ? row.items.length : 0" class="mr-2">
                          <el-button
                            type="primary"
                            size="small"
                            @click.prevent="FormProducts(row.customer_id)"
                            aria-label="Ver productos"
                            style="display:flex; align-items:center; gap:8px; font-weight:600; border-radius:8px;"
                          >
                            <i class="el-icon-view"></i>
                            Productos
                          </el-button>
                        </el-badge>
                      </el-tooltip>
                    </td>
                    <td>
                      <span style="display:inline-block; font-size:1.25rem; font-weight:700;">
                        {{ isNaN(Number(row.quantity)) ? '0.00' : Number(row.quantity).toFixed(2) }}
                      </span>
                    </td>
                    <td>
                      <span style="display:inline-block; font-size:1.25rem; font-weight:700;">
                        {{
                          row.total.toLocaleString("es-PE", {
                            style: "currency",
                            currency: "PEN"
                          })
                        }}
                      </span>
                    </td>
                    
                  </tr>
                </tbody>
              </table>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <whatsapp-form-report :message.sync="messageReport" :resource="resourceReport"
      :showWhatsappForm.sync="showWhatsappForm"></whatsapp-form-report>

  <form-client :showDialog.sync="showDialogFomClient" :customerId="recordId" :items="modalClientItems" @fetch-items="onFetchItemsForClient"></form-client>
  </div>
</template>


<script>
import { deletable } from "../../mixins/deletable";

import queryString from "query-string";
import moment from "moment";
import WhatsappFormReport from "../../components/WhatsappModalReports.vue";
import FormClient from "../items/form_client.vue";
export default {
  mixins: [deletable],
  components: { WhatsappFormReport, FormClient },
  props: ["typeUser", "user", "fromAdmin", "cajaopen"],
  data() {
    return {
      showDialogFomClient: false,
      customers: [],
      loading_search_item: false,
      totalGeneral: null,
      totalGain: 0,
      warehouses: [],
      loading_submit: false,
      showDialog: false,
      showDialogClose: false,
      messageReport: null,
      resourceReport: null,
      open_cash: true,
      resource: "report_cash",
      recordId: null,
      data_closed: moment().format("YYYY-MM-DD"),
      date_start: moment().format("YYYY-MM-DD"),
      month_start: moment().format("YYYY-MM"),
      cash: null,
      otroNombre: false,
      form: {},
      records: [],
      categories: [],
      pagination: {},
      showWhatsappForm: false,
      loading_search: false,
      timer: null,

      items: []
      ,
      modalClientItems: []
    };
  },
  async created() {
    await this.$http.get(`/reports/inventory/tables`).then(response => {
      this.warehouses = response.data.warehouses;
      this.categories = response.data.categories;
      console.log(response);
    });
  },
  methods: {
    FormProducts(customerId) {
      // find the record for this customer and set modal items
      this.recordId = customerId;
      const rec = this.records.find(r => r.customer_id == customerId);
      this.modalClientItems = rec && rec.items ? rec.items : [];
      this.showDialogFomClient = true;
    },

    // handle fetch-items event from modal (in case modal requests parent to provide items)
    onFetchItemsForClient(customerId) {
      const rec = this.records.find(r => r.customer_id == customerId);
      this.modalClientItems = rec && rec.items ? rec.items : [];
    },
    searchRemoteCustomers(input) {
      if (input.length > 0) {
        this.loading_search = true;
        let parameters = `input=${input}`;

        this.$http
          .get(`/documents/search/customers?${parameters}`)
          .then(response => {
            this.customers = response.data.customers;
            this.loading_search = false;
          });
      }
    },
    async searchRemoteItems(input) {
      if (input.length > 2) {
        if (this.timer) {
          clearTimeout(this.timer);
        }
        this.timer = setTimeout(async () => {
          try {
            let parameters = `input=${input}`;
            this.loading_search = true;
            const response = await this.$http.get(
              `/documents/data-table/items?${parameters}`
            );

            this.items = response.data;
          } catch (e) {
            console.log(e);
          } finally {
            this.loading_search = false;
          }
        }, 250);
      }
    },
    openWhastappForm() {
      this.messageReport = `Reporte de productos por cliente ${this.form
        .date_start || ""} ${this.form.date_end ? this.form.date_end : ""
        }.xlsx`;
      console.log(this.messageReport);
      this.resourceReport = `/report_product_client/report/excel?${this.getQueryParameters()}`;
      console.log(this.resourceReport);
      this.showWhatsappForm = true;
    },
    formatUnit(row) {
      let { max_quantity_item, unit_type, unit_item, count } = row;
      let full = Math.trunc(count / max_quantity_item);
      let rest = count % max_quantity_item;

      return `${full} ${unit_item} ${rest} ${unit_type}`;
    },
    checkDate() {
      if (this.form.date_end) {
        let fail = moment(this.form.date_start) > moment(this.form.date_end);

        if (fail) {
          this.form.date_end = null;
          this.$toast.error(
            "La fecha final no puede ser menor a la fecha de inicio"
          );
        }
      }
    },
    initForm() {
      this.form = {
        warehouse_id: null,
        category_id: null,
        typeresult: "Detallado"
      };
    },
    getQueryParameters() {
      return queryString.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        ...this.form
      });
    },

    async getRecords() {
      this.totalGain = 0;
      const response = await this.$http.get(
        `/report_product_client/records?${this.getQueryParameters()}`
      );

      if (response.status == 200) {
        let records = response.data;
        let customer_ids = new Set(records.map(r => r.customer_id));
        //agrupar por cliente
        let customers = [];
        customer_ids.forEach(id => {
          let customer = {
            ...records.find(r => r.customer_id == id)
          };
          let items = records.filter(r => r.customer_id == id);
          delete customer.item_description;
          delete customer.date_of_issue;
          delete customer.series;
          delete customer.number;
          delete customer.total_quantity;
          delete customer.total;
          let quantity = 0;
          let total = 0;
          customer.items = items.map(i => {
            quantity += Number(i.total_quantity);
            total += Number(i.total);
            return {
              description: i.item_description,
              selectedAncho: i.selectedAncho,
              selectedLargo: i.selectedLargo,
              selectedGrosor: i.selectedGrosor,
              date_of_issue: i.date_of_issue,
              document: i.series + "-" + i.number,
              quantity: i.total_quantity,
              total: i.total
            };
          });
          customer.items.sort((a, b) => {
            return moment(a.date_of_issue) < moment(b.date_of_issue) ? 1 : -1;
          });
          customer.quantity = quantity;
          customer.total = total;
          customers.push(customer);
        });
        this.records = customers;
      }

      this.loading_submit = false;
      // this.initTotals()
    },
    async getRecordsByFilter() {
      if (this.form.date_end) {
        let fail = moment(this.form.date_start) > moment(this.form.date_end);

        if (fail) {
          this.$toast.error(
            "La fecha final no puede ser menor a la fecha de inicio"
          );
          return;
        }
      }
      this.loading_submit = true;
      await this.getRecords();
      this.loading_submit = false;
    },
    customIndex(index) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
    ocultarBoton() {
      this.otroNombre = !this.otroNombre;
    },

    async clickDownload(id) {
      window.open(
        `/report_product_client/report/excel?${this.getQueryParameters()}`,
        "_blank"
      );
    },
    clickDownloadIncomeSummary(id) {
      window.open(`/${this.resource}/report/income-summary/${id}`, "_blank");
    },
    clickCreate(recordId = null) {
      this.recordId = recordId;
      this.showDialog = true;
    },
    clickCloseCash(recordId) {
      this.recordId = recordId;
      this.showDialogClose = true;
    },
    printreport(row) {
      window.open(
        `/caja/report-boxes/reports_resumen_type?date_end=${row.date_closed}&date_start=${row.date_closed}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf&cash_id=${row.id}`,
        "_blank"
      );
    },
    createRegister(instance, done) {
      instance.confirmButtonLoading = true;
      instance.confirmButtonText = "Cerrando caja...";
      //this.$http.get(`/${this.resource}/close/${this.recordId}`)
      window.open(
        `/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`,
        "_blank"
      );
      this.showDialogClose = false;
      // .then(response => {
      //     if(response.data.success){
      this.$eventHub.$emit("reloadData");
      //         this.open_cash = true
      //         this.$toast.success(response.data.message)
      //          window.open(`/caja/report-boxes/reports_resumen_type?date_end=${this.date_start}&date_start=${this.date_start}&month_end=${this.month_start}&month_start=${this.month_start}&period=between_dates&type=pdf`, '_blank')
      //         //window.open(`/${this.resource}/${type}/?${query}`, '_blank')
      //     }else{
      //         console.log(response)
      //     }
      // })
      // .catch(error => {
      //     console.log(error)
      // })
      // .then(() => {
      instance.confirmButtonLoading = false;
      //       instance.confirmButtonText = 'Iniciar prueba'
      //     done()
      // })
    },
    clickOpenPos() {
      window.open("/pos");
    },
    clickDelete(id) {
      this.destroy(`/${this.resource}/${id}`).then(() =>
        this.$eventHub.$emit("reloadData")
      );
    },
    clickDownloadGeneral() {
      window.open(`/${this.resource}/report`, "_blank");
    },
    clickDownloadProducts(id) {
      window.open(`/${this.resource}/report/products/${id}`, "_blank");
    }
  }
};
</script>
<style>
input[disabled],
input[readonly],
input[type="date"][disabled],
input[type="date"][readonly],
.el-input.is-disabled .el-input__inner,
.el-input__inner[disabled],
.el-input__inner[readonly],
.el-date-editor.is-disabled .el-date-editor__input,
.el-date-editor .el-input__inner[disabled],
.el-date-editor .el-input__inner[readonly],
.el-date-editor__input[disabled],
.el-date-editor__input[readonly],
.el-input-number.is-disabled .el-input-number__decrease,
.el-input-number.is-disabled .el-input-number__increase,
.el-input-number.is-disabled .el-input-number__inner,
input[disabled]::placeholder,
input[readonly]::placeholder,
input[type="date"][disabled]::placeholder,
input[type="date"][readonly]::placeholder,
.el-input__inner[disabled]::placeholder,
.el-input__inner[readonly]::placeholder,
.el-date-editor__input[disabled]::placeholder,
.el-date-editor__input[readonly]::placeholder {
  color: #073f68 !important;
  opacity: 1 !important;
  -webkit-text-fill-color: #073f68 !important;
}
</style>
