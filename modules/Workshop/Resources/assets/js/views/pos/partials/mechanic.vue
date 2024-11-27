<template>
  <el-dialog
    :title="title"
    :visible="showDialog"
    :close-on-click-modal="false"
    @close="close"
    @open="open"
    width="90%"
    append-to-body
  >
    <form autocomplete="off" action>
      <br />
      <div class>
        <div class>
          <div class="row">
            <div class="col-md-3">
              <label>cliente</label>
              <el-select
                v-model="form.customer_id"
                filterable
                remote
                class="border-left rounded-left border-info"
                popper-class="el-select-customers"
                dusk="customer_id"
                placeholder="Escriba el nombre o número de documento del cliente"
                :remote-method="searchRemoteCustomers"
                :loading="loading_search"
              >
                <el-option
                  v-for="option in customers"
                  :key="option.id"
                  :value="option.id"
                  :label="option.description"
                ></el-option>
              </el-select>
            </div>
            <div class="col-md-3">
              <label>Placa Vehiculo</label>
              <el-input v-model="form.placa" placeholder="ingrese placa" @input="lisVehicle()"></el-input>
            </div>
            <div class="col-md-6 text-end">
              <el-button type="primary" @click="clickCreate()">Nuevo Registro</el-button>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="card-body">
        <div class>
          <table class="table table-striped table-responsive col-md-12">
            <thead>
              <tr class="bg-primary">
                <th class="text-white">Acciones</th>
                <th class="text-white">#</th>
                <th class="text-white">Cliente</th>
                <th class="text-white">Vehiculo</th>
                <th class="text-white">Placa</th>
                <th class="text-white">Marca</th>
                <th class="text-white">Color</th>
                <th class="text-white">Serie</th>
                <th class="text-white">Motor</th>
                <th class="text-white">Año</th>
                <th class="text-white">Kilometros Corridos</th>
                <th class="text-white">Fecha Registro</th>
                <th class="text-white">Productos</th>
                <th class="text-white">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(vehiculo, index) in vehiculos" :key="index" :index="customIndex(index)">
                <td>
                  <div class="dropdown-as-select d-inline-block" data-childselector="span">
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
                      >
                        <i class="fas fa-list"></i>
                      </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item">
                        <el-button
                          v-if="vehiculo.historial_id"
                          type="success"
                          @click="openpayOrden(vehiculo.id)"
                          class="w-100"
                        >Cobrar</el-button>
                      </a>
                    </div>
                  </div>
                </td>
                <td>{{ customIndex(index) }}</td>
                <td>{{ vehiculo.customer_name }}</td>
                <td>{{ vehiculo.tipo_vehiculo_description }}</td>
                <td>{{ vehiculo.placa }}</td>
                <td>{{ vehiculo.marca }}</td>
                <td>{{ vehiculo.color }}</td>
                <td>{{ vehiculo.serie }}</td>
                <td>{{ vehiculo.motor }}</td>
                <td>{{ vehiculo.anio_fabricacion }}</td>
                <td>{{ vehiculo.kilometraje }}</td>
                <td>{{ vehiculo.created_at }}</td>
                <td>
                  <el-button
                    v-if="vehiculo.historial_id"
                    @click="selectItem(vehiculo.id, vehiculo.placa, vehiculo.historial_id)"
                    type="info"
                  >Productos</el-button>
                </td>
                <td class="text-end">
                  <div class="btn-toolbar mb-2" role="toolbar">
                    <div class="btn-group mb-1">
                      <button
                        class="btn btn-secondary btn-sm dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <i class="fas fa-ellipsis-v"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-sm">
                        <a class="dropdown-item">
                          <el-button class="w-100" @click="HistorialVehiculo(vehiculo.id)">
                            <i class="fas fa-list"></i>
                            Historial
                          </el-button>
                        </a>
                        <a class="dropdown-item">
                          <el-button
                            type="primary"
                            @click="clickCreate(vehiculo.id)"
                            class="w-100"
                          >Editar</el-button>
                        </a>
                        <a class="dropdown-item">
                          <el-button
                            @click.prevent="clickPrintFormat(vehiculo.id)"
                            class="w-100"
                            type="success"
                          >
                            <i class="far fa-file-alt"></i>
                            Format Vehiculo
                          </el-button>
                        </a>
                        <a class="dropdown-item">
                          <el-button
                            @click.prevent="clickPrint(vehiculo.id)"
                            class="w-100"
                            type="danger"
                          >
                            <i class="far fa-file-alt"></i>
                            PDF
                          </el-button>
                        </a>
                        <!-- <a class="dropdown-item">
                          <el-button
                            @click.prevent="format_vehicle(vehiculo.id)"
                            class="w-100"
                            type="info"
                          >
                            <i class="far fa-file-alt"></i>
                            Ver PDF
                          </el-button>
                        </a>-->
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            <el-pagination
              layout="total, prev, pager, next"
              :total="pagination.total"
              :current-page.sync="pagination.current_page"
              :page-size="pagination.per_page"
              @current-change="handlePageChange"
            ></el-pagination>
          </div>
        </div>
      </div>
      <register-history :showDialog.sync="showDialogRegisterHistory" :recordId="recordId"></register-history>
      <historial :showDialog.sync="showDialogHistorial" :vehiculoId="selectedVehiculoId"></historial>
      <modal-item
        :showDialog.sync="showDialogModalItem"
        :vehiculoId="selectedVehiculoId"
        :vehiculoPlaca="selectedVehiculoPlaca"
        :vehiculoHistorial="selectedHistorial"
        :nexItem="mechanicItem"
      ></modal-item>
      <format-pdf :showDialog.sync="showDialogFormatPdf" :vehiculoId="selectedVehiculoId"></format-pdf>
    </form>
  </el-dialog>
</template>
<script>
import registerHistory from "./register_history.vue";
import historial from "./historial.vue";
import modalItem from "./modal_item.vue";
import FormatPdf from "./format_pdf.vue";
import queryString from "query-string";
export default {
  props: ["showDialog", "mechanicItem", "visible"],
  components: {
    registerHistory,
    historial,
    modalItem,
    FormatPdf
  },
  data() {
    return {
      pagination: {},
      showDialogFormatPdf: false,
      recordId: null,
      title: "Registro Ingreso Vehiculo",
      localMechanicItem: this.mechanicItem,
      showDialogRegisterHistory: false,
      showDialogHistorial: false,
      showDialogModalItem: false,
      resource: "workshop",
      vehiculos: [],
      loading_search: false,
      form: {
        customer_id: null,
        placa: ""
      },
      customers: [],
      allFoods: [],
      nexItem: [],
      selectedVehiculoId: null,
      formatVehiculoId: null,
      selectedVehiculoPlaca: "",
      selectedHistorial: null
    };
  },
  mounted() {
    console.log(
      "Datos recibidos en mechanicItem en el modal:",
      this.mechanicItem
    );
  },
  watch: {
    mechanicItem(newValue) {
      console.log("Cambio en mechanicItem:", newValue);
    }
  },
  methods: {
    handlePageChange(page) {
      this.pagination.current_page = page;
      this.lisVehicle();
    },
    format_vehicle(id) {
      this.selectedVehiculoId = id;
      console.log("ver si esta pasando el id", id);
      this.showDialogFormatPdf = true;
    },
    clickPrintFormat(recordId) {
      window.open(
        `/${this.resource}/vehiculo/format_vehicle/${recordId}`,
        "_blank"
      );
    },
    clickPrint(recordId) {
      window.open(`/${this.resource}/vehiculo/print/${recordId}/a4`, "_blank");
    },
    clickCreate(recordId = null) {
      this.recordId = recordId;
      this.showDialogRegisterHistory = true;
    },
    resetForm() {
      this.form = {
        id: null,
        customer_id: null,
        placa: "",
        tipo_vehiculo_id: null,
        serie: "",
        modelo: "",
        marca: "",
        color: "",
        motor: "",
        anio_fabricacion: "",
        kilometraje: "",
        personal_id: null,
        observacion: "",
        motive: "",
        reparacion: false,
        garantia: false,
        mantenimiento: false,
        diagnostico: false
      };
      this.errors = {};
    },
    fillForm(data) {
      this.form.id = data.id;
      this.form.customer_id = data.customer_id;
      this.form.placa = data.placa;
      this.form.tipo_vehiculo_id = data.tipo_vehiculo_id;
      this.form.serie = data.serie;
      this.form.modelo = data.modelo;
      this.form.marca = data.marca;
      this.form.color = data.color;
      this.form.motor = data.motor;
      this.form.anio_fabricacion = data.anio_fabricacion;
      this.form.kilometraje = data.kilometraje;
      this.form.personal_id = data.personal_id;
      this.form.observacion = data.observacion;
      this.form.motive = data.motive;
      this.form.reparacion = data.reparacion;
      this.form.garantia = data.garantia;
      this.form.mantenimiento = data.mantenimiento;
      this.form.diagnostico = data.diagnostico;
    },
    checkIsExistSerie() {
      let hasError = false;
      for (let ord of this.localOrden) {
        let { series_enabled } = ord.food.item;

        if (series_enabled && ord.series.length == 0) {
          hasError = true;
          break;
        }
      }
      return hasError;
    },

    async openpayOrden(id) {
      this.$emit("payment", id);
    },
    selectItem(id, placa, historial_id) {
      if (historial_id == null) {
        return;
      }
      this.selectedHistorial = historial_id;
      this.selectedVehiculoId = id;
      this.selectedVehiculoPlaca = placa;
      console.log(
        "Vehiculo ID:",
        id,
        "Vehiculo Placa:",
        placa,
        "histoprial idd",
        historial_id
      );
      this.localMechanicItem = this.nexItem;
      this.showDialogModalItem = true;
    },
    searchRemoteCustomers(input) {
      if (input.length > 0) {
        this.loading_search = true;
        let parameters = `input=${input}`;

        this.$http
          .get(`/${this.resource}/customers?${parameters}`)
          .then(response => {
            this.customers = response.data.customers;
            this.loading_search = false;
            if (this.customers.length == 0) {
              this.customers = this.all_customers;
            }
          });
      } else {
        this.customers = this.all_customers;
      }
    },
    reloadDataCustomers(customer_id) {
      this.$http.get(`/workshop/customer/${customer_id}`).then(response => {
        this.customers = response.data.customers;
        this.form.customer_id = customer_id;
      });
    },
    lisVehicle() {
      this.$http
        .get(`/${this.resource}/vehiculo/records?${this.getQueryParameters()}`)
        .then(response => {
          this.vehiculos = response.data.data;
          this.pagination = response.data.meta;
          this.pagination.per_page = parseInt(response.data.meta.per_page);
          /* console.log("Tipos de vehículo:", this.vehiculos); */
        })
        .catch(error => {
          console.error("Error al obtener los tipos de vehículo:", error);
        });
    },
    customIndex(index) {
      return (
        this.pagination.per_page * (this.pagination.current_page - 1) +
        index +
        1
      );
    },
    getQueryParameters() {
      this.search = {
        placa: this.form.placa
      };
      return queryString.stringify({
        page: this.pagination.current_page,
        limit: this.limit,
        ...this.search
      });
    },
    clickRegisterHistory() {
      this.showDialogRegisterHistory = true;
    },
    HistorialVehiculo(id) {
      this.selectedVehiculoId = id;
      console.log("Vehiculo ID Para la historia del car:", id);
      this.showDialogHistorial = true;
    },
    open() {
      this.lisVehicle();
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>