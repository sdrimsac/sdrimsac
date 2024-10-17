<template>
  <el-dialog
    title="Registro Entrada De Vehiculo"
    :visible="showDialog"
    :close-on-click-modal="false"
    @close="close"
    @open="open"
    width="60%"
    append-to-body
  >
    <form action>
      <br />
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 pb-2">
              <div class="form-group" :class="{ 'has-danger': errors.customer_id }">
                <label>
                  Cliente
                  <a href="#" @click.prevent="showDialogNewPerson = true">[+ Nuevo]</a>
                </label>
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
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">
                  Número de Placa
                  <el-tooltip
                    class="item"
                    effect="dark"
                    content="Este campo es obligatorio...!!!"
                    placement="top"
                  >
                    <i class="fas fa-info-circle text-danger"></i>
                  </el-tooltip>
                </label>
                <div v-if="api_factiliza_token != false">
                  <x-input-carro 
                  v-model="form.number" 
                  @search="handleSearchResult">
                  </x-input-carro>
                </div>
                <div v-else>
                  <el-input
                    ref="number"
                    v-model="form.number"
                    :maxlength="6"
                    dusk="number"
                  >
                    <template v-slot:append>
                      <el-button
                        :loading="loading_search"
                        icon="el-icon-search"
                        @click.prevent="searchPlaca"
                      ></el-button>
                    </template>
                    <template v-slot:prefix>
                      <i class="el-icon-edit-outline"></i>
                    </template>
                  </el-input>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <label for="tipo-vehiculo">Tipo de Vehiculo</label>
              <el-select
                v-model="tipo_vehiculo_id"
                filterable
                placeholder="Seleccione un tipo de vehículo"
              >
                <el-option
                  v-for="option in tipo_vehiculo"
                  :key="option.id"
                  :value="option.id"
                  :label="option.description"
                ></el-option>
              </el-select>
            </div>
            <div class="col-md-4">
              <label for>Serie</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Modelo</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Marca</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Color</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Motor</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Año Fabricacion</label>
              <el-input placeholder></el-input>
            </div>
            <div class="col-md-4">
              <label for>Kilometraje</label>
              <el-input placeholder></el-input>
            </div>
          </div>
        </div>
      </div>
      <person-form
        :showDialog.sync="showDialogNewPerson"
        type="customers"
        :external="true"
        :user_id="form.user_id"
        :document_type_id="form.document_type_id"
      ></person-form>
    </form>
  </el-dialog>
</template>
<script>
import personForm from "../../../../../../../../resources/js/views/persons/form.vue";
export default {
  components: {
    personForm
  },
  props: ["showDialog"],
  data() {
    return {
      showDialogNewPerson: false,
      errors: {},
      form: {},
      loading_search: false,
      customers: [],
      tipo_vehiculo: [],
      tipo_vehiculo_id: null,
      resource: "workshop/tipo",
      value: null,
      number: null,
      api_factiliza_token: false
    };
  },
  async created() {
    this.$eventHub.$on("reloadDataPersons", customer_id => {
      this.reloadDataCustomers(customer_id);
    });
    console.log("Props categoriaMadera recibido :", {
      items: this.items
    });
    await this.initForm();
    /* await this.$http.get(`/${this.resource}/tables`).then(response => {
      this.api_factiliza_token = response.data.api_factiliza_token;
    }); */
  },
  watch: {
    all_customers(newCustomer, _) {
      this.customers = newCustomer.filter(n => n.number != "88888888");
    }
  },
  computed: {
    maxLength: function() {
      if (this.form.number === "6") {
        return 6;
      }
    }
  },
  methods: {
    handleSearchResult(data){
      /* this.customers = data.customers; */
      console.log('Resultado de la Busqueda de la placa', this.form.number);
    },
    initForm() {
      this.errors = {};
      this.form = {
        number: "6"
      };
    },
    async opened() {
      // this.form.seller_id = this.user_id;
      if (this.external && this.input_person) {
        if (this.form.number.length === 6) {
          if (this.api_factiliza_token != false) {
            await this.$eventHub.$emit("enableClickBuscar");
          } else {
            this.searchPlaca();
          }
        }
      }
    },
    searchPlaca (){
      this.$http(`/carros/${this.form.number}`).then(
        response => {
          console.log(response);
        }
      )
      console.log('Busqueda manual de la placa', this.form.number)

    },
    getTipoVehiculo() {
      this.$http
        .get(`/${this.resource}/records`)
        .then(response => {
          this.tipo_vehiculo = response.data;
          console.log("Tipos de vehículo:", this.tipo_vehiculo);
        })
        .catch(error => {
          console.error("Error al obtener los tipos de vehículo:", error);
        });
    },
    reloadDataCustomers(customer_id) {
      this.$http
        .get(`/documents/search/customer/${customer_id}`)
        .then(response => {
          this.customers = response.data.customers;
          this.form.customer_id = customer_id;
        });
    },
    searchRemoteCustomers(input) {
      if (input.length > 0) {
        this.loading_search = true;
        let parameters = `input=${input}`;

        this.$http
          .get(`/${this.resource}/search/customers?${parameters}`)
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
    open() {
      this.form = {
        customer_id: null
      };
      /* this.customers = this.all_customers;
      console.log("🚀 ~ open ~ this.all_customers:", this.all_customers);
      let customer = this.customers.find(c => c.number == "99999999");
      if (customer) {
        this.form.customer_id = customer.id;
      } */
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>