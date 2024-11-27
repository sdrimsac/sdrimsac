<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    :close-on-click-modal="false"
    width="50%"
  >
    <br />
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-6">
            <label class="control-label">
              <i class="fas fa-align-left"></i> Tipo Servicio
            </label>
            <el-select v-model="form.service_id" id="services">
              <el-option v-for="service in services" 
                :key="service.id" 
                :value="service.id"
                :label="service.description">
              </el-option>
            </el-select>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.name}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Servicio
              </label>
              <el-input v-model="form.name">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.description}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Description o Observacion
              </label>
              <el-input v-model="form.description">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.name" v-text="errors.description[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.price_unit}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Precio 
              </label>
              <el-input v-model="form.price_unit" type="number">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.price_unit" v-text="errors.price_unit[0]"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button icon="fas fa-times" @click.prevent="close()">Cancelar</el-button>
        <el-button
          icon="fas fa-save"
          type="primary"
          native-type="submit"
          :loading="loading_submit"
        >Guardar</el-button>
      </div>
    </form>
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
  props: ["showDialog", "recordId"],
  data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: "workshop",
      errors: {},
      form: {
        service_id: null,
        name: null
      },
      services: []
    };
  },
  created() {
    /* this.initForm(); */
  },
  watch: {
    recordId: {
      immediate: true,
      handler() {
        if (this.recordId) {
          /* this.fetchRecord(); */
        } else {
          this.resetForm();
        }
      }
    }
  },
  methods: {
    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        service_id: null,
        service_description: null,
        name: null,
        description: null,
        price_unit: null,
      };
    },
    resetForm() {
      this.initForm();
    },
    create() {
      this.titleDialog = this.recordId ? "Editar servicos" : "Nuevo servico";
      this.getServices();
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/servicesdetails/record/${this.recordId}`)
          .then(response => {
            this.form = response.data.data;
          });
      } else {
        this.resetForm();
      }
    },
    getServices() {
      this.$http.get(`/${this.resource}/services/records`).then(response => {
        this.services= response.data.data;
      });
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}/servicesdetails`, this.form)
        .then(response => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
            this.close();
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
        });
    },
    close() {
      this.$emit("update:showDialog", false);
      this.initForm();
    }
  }
};
</script>
