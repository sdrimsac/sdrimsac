<!-- Apertura de Caja en Módulo de Ventas -->
<template>
  <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" :data-keyboard="false"
    :closeOnPressEscape="dontClose" :closeOnClickModal="dontClose" width="45%">
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Cajero</label>
              <!--<el-input v-model="form.user" readonly> <i slot="prefix" class="el-icon-edit-outline"></i></el-input> -->
              <el-select :disabled="disableUser" v-model="form.user_id">
                <el-option v-for="option in users" :key="option.id" :value="option.id" :label="option.name"></el-option>
              </el-select>
              <small class="form-control-feedback" v-if="errors.user" v-text="errors.user[0]"></small>
            </div>
          </div>

          <div class="col-md-6 mb-2">
            <div class="form-group" :class="{ 'has-danger': errors.reference_number }">
              <label class="control-label">Turno de Apertura Detectado</label>
              <el-input v-model="turnName" readonly placeholder="Turno detectado automáticamente"></el-input>
              <el-select v-model="form.turn_id" style="display:none">
                <el-option v-for="option in turnsTable" :key="option.id" :value="option.id" :label="option.turn_desc"></el-option>
              </el-select>
              <small class="form-control-feedback" v-if="errors.reference_number"
                v-text="errors.reference_number[0]"></small>
            </div>
          </div>

          <div class="col-md-6 mb-2">
            <div class="form-group" :class="{ 'has-danger': errors.beginning_balance }">
              <label class="control-label">Saldo inicial</label>
              <el-input v-model="form.beginning_balance">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.beginning_balance"
                v-text="errors.beginning_balance[0]"></small>
            </div>
          </div>
          <div class="col-md-6 mb-2" v-if="configuration.health_network == 1">
            <div class="form-group" :class="{ 'has-danger': errors.cash_type_id }">
              <label class="control-label">
                Tipo de Turno
              </label>
              <el-select v-model="form.cash_type_id">
                <el-option v-for="option in turnsHealthNetwork" :key="option.id" :value="option.value"
                  :label="option.description"></el-option>
              </el-select>
              <small class="form-control-feedback" v-if="errors.cash_type_id" v-text="errors.cash_type_id[0]"></small>
            </div>
          </div>
          <!-- <div class="col-md-6">
            <div class="form-group" :class="{ 'has-danger': errors.reference_number }">
              <label class="control-label">Turno de Apertura</label>
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
          </div> -->
          <div class="row" v-if="configuration.health_network == 1">
            <div class="card mb-2" style="padding: 10px; margin: 8px 8px;">
              <div class="card-body">
                <h5 class="card-title" style="text-align: center; color: red;">Importante</h5>
                <ul class="mb-0" style="list-style: none; padding-left: 0; margin: 0;">
                  <li class="mb-3" style="margin-bottom: 12px; padding: 0;">
                    <strong style="color: #1976d2;">INICIO:</strong> Turno de apertura<br>
                    <small class="text-muted"
                      style="display:block; text-align:justify; word-break:break-word; line-height:1;">
                      Normalmente Noche | Mañana, si no se trabajó en la noche.
                    </small>
                  </li>
                  <li class="mb-3" style="margin-bottom: 12px; padding: 0;">
                    <strong style="color: #388e3c;">INTERMEDIO:</strong> Turno intermedio<br>
                    <small class="text-muted"
                      style="display:block; text-align:justify; word-break:break-word; line-height:1;">
                      Normalmente Mañana | Turno entre el inicio y el fin.
                    </small>
                  </li>
                  <li class="mb-3" style="margin-bottom: 12px; padding: 0;">
                    <strong style="color: #fbc02d;">FIN:</strong> Turno de cierre<br>
                    <small class="text-muted"
                      style="display:block; text-align:justify; word-break:break-word; line-height:1;">
                      Normalmente Tarde | Mañana, si se trabaja doble turno (Mañana - Tarde).
                    </small>
                  </li>
                  <li style="padding: 0;">
                    <strong style="color: #7b1fa2;">ÚNICO:</strong> Turno único<br>
                    <small class="text-muted"
                      style="display:block; text-align:justify; word-break:break-word; line-height:1;">
                      Turno único para el día: Mañana - Tarde (Si noche no se trabajó).
                    </small>
                  </li>
                </ul>
              </div>
            </div>
          </div>


          
        </div>
      </div>
      <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
        <!-- Cancelar -->
        <el-button class="btn_cancelarsmall" icon="fas fa-times fa-lg" @click.prevent="close()">
          <span>Cancelar</span>
        </el-button>

        <el-button class="btn_guardarsmall" icon="fas fa-save fa-lg" type="primary" native-type="submit"
          :loading="loading_submit">
          <span>Guardar</span>
        </el-button>
      </div>
      <!-- <div class="form-actions text-end pt-2 pb-2">
        <el-button @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
      </div> -->
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
          value: 3,
          info: "Turno de apertura. Normalmente Noche | Mañana, si no se trabajó en la noche."
        },
        {
          id: 2,
          description: "INTERMEDIO",
          value: 1,
          info: "Turno intermedio. Normalmente Mañana | Turno entre el inicio y el fin."
        },
        {
          id: 3,
          description: "FIN",
          value: 2,
          info: "Turno de cierre. Normalmente Tarde | Mañana, si se trabaja doble turno (Mañana - Tarde)."
        },
        {
          id: 4,
          description: "ÚNICO",
          value: 4,
          info: "Turno único para el día: Mañana - Tarde (Si noche no se trabajó)."
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
    },
    turnName() {
      // Detecta el turno automáticamente según la hora actual y lo asigna a form.turn_id
      const now = new Date();
      const hour = now.getHours();
      const minute = now.getMinutes();
      let label = '';
      let id = null;
      if (hour >= 6 && (hour < 12 || (hour === 11 && minute <= 59))) {
        label = "Mañana (06:00am - 11:59am)";
        const turno = this.turnsTable.find(t => t.turn_desc.toLowerCase().includes('mañana'));
        id = turno ? turno.id : null;
      } else if (hour >= 12 && (hour < 18 || (hour === 17 && minute <= 59))) {
        label = "Tarde (12:00pm - 5:59pm)";
        const turno = this.turnsTable.find(t => t.turn_desc.toLowerCase().includes('tarde'));
        id = turno ? turno.id : null;
      } else if (hour >= 18 || hour < 6) {
        label = "Noche (6:00pm - 5:59am)";
        const turno = this.turnsTable.find(t => t.turn_desc.toLowerCase().includes('noche'));
        id = turno ? turno.id : null;
      }
      // Asigna el turno detectado al select oculto
      if (id && this.form.turn_id !== id) {
        this.form.turn_id = id;
      }
      return label;
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
      this.titleDialog = this.recordId ? "Editar Caja" : "Apertura de Caja";
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
      if (this.newCash == true) {
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
        this.$showSAlert("warning", "La opcion 'Seleccionar turno de apertura' no puede ser un campo vacio, por favor seleccione una opcion", "warning");

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

        }).finally(() => { this.newCash = false })

    },
    close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
};
</script>
