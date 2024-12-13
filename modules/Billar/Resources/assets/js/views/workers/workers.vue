<!-- Lista de Usuarios -->
<template>
  <div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h6>
              <span>Lista de Usuarios</span>
            </h6>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/dashboard">Dashboard</a>
              </li>
              <li class="breadcrumb-item active">
                <span class="text-muted">Usuarios</span>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid p-l-0 p-r-0">
      <div class="card">
        <div class="card-header bg-primary">
          <h4 class="my-0 text-white">
            <i class="far fa-address-book mr-2"></i> Módulo de Usuarios
          </h4>
        </div>
        <div class="data-table-visible-columns">
          <el-button type="primary" class href="javascript:void(0)" @click.prevent="clickCreate()">
            <i class="fa fa-user-plus"></i>
            Nuevo Usuario wwwww
          </el-button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Filtro Por Estado</label>
                <el-select v-model="form.qty_type" clearable filterable>
                  <el-option
                    v-for="option in qty_types"
                    :key="option.id"
                    :value="option.value"
                    :label="option.name"
                  ></el-option>
                </el-select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Buscar por Nombre de Usuario</label>
                <el-input
                  v-model="form.name"
                  placeholder="Ingrese el nombre de usuario"
                  clearable
                  @change="getData"
                ></el-input>
              </div>
            </div>
            <div class="col-lg-3 col-md-4 col-md-4 col-sm-12 d-flex align-items-center">
              <el-button
                class="submit"
                type="primary"
                @click.prevent="getRecordsByFilter"
                :loading="loading_submit"
                icon="el-icon-search"
              >Buscar</el-button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr slot="heading" class="bg-primary">
                  <th class="text-white text-center">#</th>
                  <th class="text-white text-center text-end">Estado</th>
                  <th class="text-white text-center">Nombre</th>
                  <th class="text-white text-center">Tipo de Usuario</th>
                  <th class="text-white text-center">Área</th>
                  <th class="text-white text-center">PIN</th>
                  <th class="text-white text-center">Actividad</th>
                  <th class="text-white text-center">Establecimiento</th>
                  <th class="text-white text-center">Serie</th>
                  <th class="text-white text-center text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in records" :key="index">
                  <td class="text-center">{{ index + 1 }}</td>
                  <td class="text-center">
                    <button
                      class="btn"
                      :style="{
                                color: 'white', 
                                backgroundColor: row.active ? 'green' : 'red', 
                                fontWeight: 'bold',
                                width: '110px' 
                            }"
                    >{{ row.active ? 'Activo' : 'Suspendido' }}</button>
                  </td>
                  <td class="text-center">{{ row.name }}</td>

                  <td class="text-center">{{ row.type }}</td>
                  <td class="text-center">{{ row.area }}</td>
                  <td class="text-center">
                    {{ row.visible ? row.pin : "****" }}
                    <button
                      class="btn ml-1 btn-sm btn-success"
                      @click="visiblePin(index)"
                      title="Mostrar Pin"
                    >
                      <i class="fas fa-eye"></i>
                    </button>

                    <button
                      class="btn ml-1 btn-sm btn-primary"
                      @click="editPin(row)"
                      title="Editar Pin"
                    >
                      <i class="fas fa-edit"></i>
                    </button>
                  </td>
                  <td class="tex-center">
                    <template v-if=" row.last_register && row.last_register.user" class="text-center">
                      <span class="text-center fw-bold">{{ row.last_register.user }}</span> :
                      <span class="text-primary">
                        {{ row.last_register.description }}
                      </span>
                      <br />
                      <span
                        :class=" `${ row.last_register.date_time .is24Hours ? 'text-danger' : ''}`">
                        {{
                        formatDateTime( row.last_register.date_time)
                        }}
                      </span>
                    </template>
                  </td>

                  <td class="text-center">{{ row.establishment_description }}</td>
                  <td class="text-center">{{ row.series }}</td>
                  <td class="text-center">
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
                      <a type="button" class="dropdown-item" @click.prevent="clickCreate(row.id)">
                        <i class="fas fa-edit"></i> Editar
                      </a>
                      <a type="button" class="dropdown-item" @click.prevent="clickDelete(row.id)">
                        <i
                          class="fas"
                          :class="{'fa-toggle-on': row.active, 'fa-toggle-off': !row.active}"
                        ></i>
                        {{row.active ? "Desactivar" : "Activar"}}
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <create-form
        :configuration="configuration"
        :showDialog.sync="showDialog"
        :areas="areas"
        :recordId="recordId"
        :workersType="workersType"
        :series="series"
        :establishments="establishments"
        :allEstablishments="allEstablishments"
        :allWarehouses="allWarehouses"
        :commercial_treatment="commercial_treatment"
      ></create-form>
    </div>
    <el-dialog
      :visible.sync="showEditPin"
      title="Editar PIN"
      v-if="currentUser"
      width="350px"
      v-loading="loading"
    >
      <div class="row m-2">
        <div class="col-12">
          <label for>PIN</label>
          <input type="text" class="form-control" v-model="newPin" />
        </div>
      </div>
      <div class="d-flex justify-content-end m-2">
        <button class="btn btn-primary" @click="updatePin">Guardar</button>
        <button class="btn" @click="showEditPin = false">Cerrar</button>
      </div>
      <div class="row m-2"></div>
    </el-dialog>
  </div>
</template>

<script>
/* import DataTableUser from "../../../../../../../resources/js/components/DataTableUser.vue"; */
import CreateForm from "./form.vue";
import { deletable } from "../../../../../../../resources/js/mixins/deletable";
import queryString from "query-string";
export default {
  props: ["establishments", "typeUser", "configuration"],
  mixins: [deletable],
  components: {
    CreateForm
  },
  data() {
    return {
      qty_types: [
        {
          id: 1,
          name: "Activo",
          value: "1"
        },
        {
          id: 2,
          name: "Suspendido",
          value: "0"
        }
      ],
      active: false,
      showEditPin: false,
      showDialog: false,
      resource: "workers",
      recordId: null,
      areas: [],
      workersType: [],
      series: [],
      records: [],
      currentUser: null,
      newPin: null,
      loading: false,
      allWarehouses: [],
      allEstablishments: [],
      form: {},
      loading_submit: false,
      commercial_treatment: []
    };
  },
  created() {
    this.initForm();
    console.log(this.configuration);
    this.$eventHub.$on("reloadData", () => {
      this.getData();
    });
    console.log(this.typeUser);
    this.getTables();

    this.getData();
  },
  methods: {
    formatDateTime(date) {
      let days = date.days;
      let hours = date.hours;
      let minutes = date.minutes;
      let text = "Hace: ";
      if (days > 0) {
        text += `${days} días`;
      } else if (hours > 0) {
        text += `${hours} horas`;
      }
      if (days == 0 && hours == 0) {
        if (minutes == 0) {
          text += `Recientemente`;
        } else {
          text += `${minutes} minutos`;
        }
      }

      return text;
    },
    async updatePin() {
      try {
        this.loading = true;
        const response = await this.$http.post("/users/update_pin", {
          id: this.currentUser.id,
          pin: this.newPin
        });
        if (response.status == 200) {
          this.$toast.success(response.data.message);
          this.getData();
          this.newPin = null;
          this.showEditPin = false;
        }
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    editPin(user) {
      this.showEditPin = true;
      this.currentUser = user;
    },
    visiblePin(idx) {
      this.records[idx].visible = !this.records[idx].visible;
    },
    async getTables() {
      let response = await this.$http.get(`areas/actives`);
      this.areas = response.data.data;
      response = await this.$http.get(`workers-type/actives`);
      this.workersType = response.data.workers_type;
      this.series = response.data.series;
      console.log(this.series);
      this.allWarehouses = response.data.warehouses;
      this.allEstablishments = response.data.establishments;
      this.commercial_treatment = response.data.commercial_treatment;
      console.log(
        "🚀 ~ getTables ~ this.commercial_treatment:",
        this.commercial_treatment
      );
      /* console.log(series); */
    },
    initForm() {
      this.form = {
        qty_type: null,
        name: null
      };
    },

    async getRecordsByFilter() {
      this.loading_submit = await true;
      await this.getData();
      this.loading_submit = await false;
    },

    /* async getData() {
      const response = await this.$http
        .get(`${this.resource}/records?${this.getQueryParameters()}`)
        .then(response => {
          this.records = response.data.data.map(d => {
            d.visible = false;
            return d;
          });
        });
      this.loading_submit = false;
    }, */
    getData() {
      if (this.time) {
        clearTimeout(this.time);
      }
      this.time = setTimeout(async () => {
        const response = await this.$http
          .get(`${this.resource}/records?${this.getQueryParameters()}`)
          .then(response => {
            this.records = response.data.data.map(d => {
              d.visible = false;
              return d;
            });
          });
        this.loading_submit = false;
      }, 350);
    },
    getQueryParameters() {
      return queryString.stringify(this.form);
    },
    clickCreate(recordId = null) {
      this.recordId = recordId;
      this.showDialog = true;
    },
    async clickDelete(id) {
      const response = await this.$http.get(`${this.resource}/${id}`);
      if (response.status == 200) {
        const { message } = response.data;
        this.$toast.success(message);
        this.getData();
      }
    }
  }
};
</script>
