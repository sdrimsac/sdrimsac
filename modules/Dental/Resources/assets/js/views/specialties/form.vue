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
          <div class="col-md-12">
            <div class="form-group" :class="{'has-danger': errors.placa}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Especialidad
              </label>
              <el-input v-model="form.description">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.placa"
                v-text="errors.placa[0]"
              ></small>
            </div>
          </div>
          <!-- <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.tipo_vehiculo_id}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Tipo Vehiculo
              </label>
              <el-input v-model="form.tipo_vehiculo_id">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.tipo_vehiculo_id"
                v-text="errors.tipo_vehiculo_id[0]"
              ></small>
            </div>
          </div> -->
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
      resource: "dental/specialties",
      errors: {},
      form: {}
    };
  },
  created() {
    this.initForm();
  },
  methods: {
    initForm() {
      this.errors = {};
      this.form = {
        description: null
      };
    },
    create() {
      this.titleDialog = this.recordId ? "Editar Vehiculo" : "Nuevo Vehiculo";
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/record/${this.recordId}`)
          .then(response => {
            this.form = response.data.data;
          });
      }
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}`, this.form)
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
