<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    :data-keyboard="false"
    :closeOnPressEscape="dontClose"
    :closeOnClickModal="dontClose"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Cajero</label>
              <!--<el-input v-model="form.user" readonly> <i slot="prefix" class="el-icon-edit-outline"></i></el-input> -->
              <el-select :disabled="disableUser" v-model="form.user_id">
                <el-option
                  v-for="option in users"
                  :key="option.id"
                  :value="option.id"
                  :label="option.name"
                ></el-option>
              </el-select>
              <small class="form-control-feedback" v-if="errors.user" v-text="errors.user[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{ 'has-danger': errors.beginning_balance }">
              <label class="control-label">Saldo inicial de Apertura</label>
              <el-input v-model="form.beginning_balance">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.beginning_balance"
                v-text="errors.beginning_balance[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{ 'has-danger': errors.reference_number }">
              <label class="control-label">Seleccionar Turno de Apertura</label>
              <el-select v-model="form.turn_id">
                <el-option
                  v-for="option in turnsTable"
                  :key="option.id"
                  :value="option.id"
                  :label="option.turn_desc"
                ></el-option>
              </el-select>

              <small
                class="form-control-feedback"
                v-if="errors.reference_number"
                v-text="errors.reference_number[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-6" v-if="configuration.health_network == 1">
            <div class="form-group" :class="{ 'has-danger': errors.cash_type_id }">
              <label class="control-label">
                Seleccionar Tipo de Turno
                <el-tooltip class="item" effect="dark" placement="top">
                  <div slot="content">
                    <p>
                      <strong>INICIO:</strong> Turno de
                      apertura
                      <br />Normalmente Noche | Mañana, si no se
                      trabajó en la noche
                    </p>
                    <p>
                      <strong>INTERMEDIO:</strong> Turno
                      intermedio
                      <br />Normalmente Mañana | Turno entre el
                      inicio y el fin
                    </p>
                    <p>
                      <strong>FIN:</strong> Turno de
                      cierre
                      <br />Normalmente Tarde | Mañana, si se
                      trabaja doble turno (Mañana - Tarde)
                    </p>
                    <p>
                      <strong>UNICO:</strong> Turno unico
                      <br />Turno unico para el dia: Mañana -
                      Tarde (Si noche no se trabajó)
                    </p>
                  </div>
                  <i class="el-icon-info"></i>
                </el-tooltip>
              </label>
              <el-select v-model="form.cash_type_id">
                <el-option
                  v-for="option in turnsHealthNetwork"
                  :key="option.id"
                  :value="option.value"
                  :label="option.description"
                ></el-option>
              </el-select>

              <small
                class="form-control-feedback"
                v-if="errors.cash_type_id"
                v-text="errors.cash_type_id[0]"
              ></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
      </div>
    </form>
  </el-dialog>
</template>

<script>
export default {
  props: ["showDialog", "recordId", "typeUser", "fromBox", "principal", "fromPos"],
  data() {
    return {
      newCash: false,
      turnsHealthNetwork: [
        {
          id: 1,
          description: "INICIO",
          value: 3
        },
        {
          id: 2,
          description: "INTERMEDIO",
          value: 1
        },
        {
          id: 3,
          description: "FIN",
          value: 2
        },
        {
          id: 4,
          description: "UNICO",
          value: 4
        }
      ],
      configuration: {},
      loading_submit: false,
      titleDialog: null,
      resource: "caja/worker/cash",
      errors: {},
      form: {},
      user: {},
      all_departments: [],
      all_provinces: [],
      all_districts: [],
      provinces: [],
      districts: [],
      identity_document_types: [],
      users: [],
      turnsTable: [],
      dontClose: false
    };
  },
  async created() {
    await this.$http.get(`/${this.resource}/tables`).then(response => {
      this.users = response.data.users;
      this.user = response.data.user;
      this.turnsTable = response.data.turnsTable;
      this.configuration = response.data.configuration;
    });

    this.initForm();
    if (this.fromPos) {
      this.create();
    }
  },
  computed: {
    disableUser() {
      if (this.typeUser == "admin" || this.typeUser === "superadmin") {
        return false;
      }
      return true;
    }
  },
  methods: {
    ocultarBoton() {
      this.$emit("ocultarBoton");
    },

    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        user_id: this.user.id,
        // user: null,
        date_opening: null,
        time_opening: null,
        date_closed: null,
        time_closed: null,
        beginning_balance: 0,
        final_balance: 0,
        income: 0,
        state: true,
        reference_number: null
      };
    },
    create() {
      this.titleDialog = this.recordId ? "Editar Caja" : "Aperturar Caja";
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/record/${this.recordId}`)
          .then(response => {
            this.form = response.data.data;
          });
      } else {
        this.form.user_id = this.user.id; //sesion
        //this.form.user = this.user.name
      }
    },
    async openingCashCkeck() {
      let response = await this.$http.get(
        `/${this.resource}/opening_cash_check/${this.form.user_id}`
      );

      let cash = response.data.cash;
      return cash ? true : false;
    },
    async submit() {
        if (this.newCash == true ){
            return;
        }
      if (
        this.configuration.health_network == 1 &&
        this.form.cash_type_id == undefined
      ) {
        /* this.$toast.warning(
          `'Tipo de Turno' no puede ser un campo vacio, por favor seleccione una opcion`
        ); */
        this.$showSAlert("Tipo de Turno' no puede ser un campo vacio, por favor seleccione una opcion", "warning");
        this.newCash = false;
        return false;
      }
      if (this.form.turn_id == undefined) {
        /* this.$toast.warning(
          `La opcion 'Seleccionar turno de apertura' no puede ser un campo vacio, por favor seleccione una opcion`
        ); */
        this.$showSAlert("warning","La opcion 'Seleccionar turno de apertura' no puede ser un campo vacio, por favor seleccione una opcion", "warning");

        return false;
      }
      if (!this.recordId) {
        if (await this.openingCashCkeck()) {
          /* this.$toast.warning(
            "No puede crear caja, porfavor cierre caja para el usuario definido"
          ); */
          this.$showSAlert("warning", "No puede crear caja, porfavor cierre caja para el usuario definido", "warning");
        this.newCash = false;
          return false;
        }
      }

      if (this.configuration.health_network == 1) {
        this.confirmAndSubmit();
      } else {
        this.submitForm();
      }
      // if(this.configuration.health_network == 1){
      //     let cash_type = this.turnsHealthNetwork.find(
      //         item => item.value == this.form.cash_type_id
      //     );
      //     await this.$confirm(
      //         "¿Está seguro de que desea aperturar la caja con el turno " +
      //             cash_type.description +
      //             "?",
      //         "Apertura de Caja",
      //         {
      //             confirmButtonText: "Sí",
      //             cancelButtonText: "No",
      //             type: "warning"
      //         }
      //     ).then(() => {
      //             this.$http
      //     .post(`/${this.resource}`, this.form)
      //     .then(response => {
      //         console.log(response);
      //         if (response.data.success) {
      //             this.$toast.success(response.data.message);
      //             if (this.form.user_id === this.user.id)
      //                 this.$eventHub.$emit("openCash");
      //             this.$eventHub.$emit("reloadData");
      //             if (this.fromBox) {
      //                 this.$emit("updateCashId", response.data.cash_id);
      //             }
      //             // window.open('/pos/init')
      //             this.close();
      //             this.ocultarBoton();
      //         } else {
      //             this.$toast.error(response.data.message);
      //         }
      //     })
      //     .catch(error => {
      //         if (error.response.status === 422) {
      //             this.errors = error.response.data;
      //         } else {
      //             console.log(error);
      //         }
      //     })
      //     .then(() => {
      //         this.loading_submit = false;
      //     });
      //     });
      // }else{
      //         this.$http
      //     .post(`/${this.resource}`, this.form)
      //     .then(response => {
      //         console.log(response);
      //         if (response.data.success) {
      //             this.$toast.success(response.data.message);
      //             if (this.form.user_id === this.user.id)
      //                 this.$eventHub.$emit("openCash");
      //             this.$eventHub.$emit("reloadData");
      //             if (this.fromBox) {
      //                 this.$emit("updateCashId", response.data.cash_id);
      //             }
      //             // window.open('/pos/init')
      //             this.close();
      //             this.ocultarBoton();
      //         } else {
      //             this.$toast.error(response.data.message);
      //         }
      //     })
      //     .catch(error => {
      //         if (error.response.status === 422) {
      //             this.errors = error.response.data;
      //         } else {
      //             console.log(error);
      //         }
      //     })
      //     .then(() => {
      //         this.loading_submit = false;
      //     });
      // }
    },
    async submitForm() {
      if (this.loading_submit == true) {
        return;
      }
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}`, this.form)
        .then(response => {
          console.log(response);
          if (response.data.success) {
            this.$toast.success(response.data.message);
            if (this.form.user_id === this.user.id)
              this.$eventHub.$emit("openCash");
            this.$eventHub.$emit("reloadData");
            if (this.fromBox) {
              this.$emit("updateCashId", response.data.cash_id);
            }
            this.close();
            this.ocultarBoton();
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data;
          } else {
            console.log(error);
          }
        })
        .then(() => {
          this.loading_submit = false;
          this.newCash = false;
        });
    },
    async confirmAndSubmit() {
      let cash_type = this.turnsHealthNetwork.find(
        item => item.value == this.form.cash_type_id
      );
      this.$confirm(
        "¿Está seguro de que desea aperturar la caja con el turno " +
          cash_type.description +
          "?",
        "Apertura de Caja",
        {
          confirmButtonText: "Sí",
          cancelButtonText: "No",
          type: "warning"
        }
      )
        .then(() => this.submitForm())
        .catch(() => {
          this.loading_submit = false;

        }).finally(() => { this.newCash = false})

    }, 
    close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
};
</script>
