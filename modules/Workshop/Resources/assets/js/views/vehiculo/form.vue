<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    :close-on-click-modal="false"
    width="60%"
  >
    <br />
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.placa}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Placa
              </label>
              <el-input v-model="form.placa">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.placa"
                v-text="errors.placa[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.customer_id}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Cliente
              </label>
              <el-input v-model="form.customer_id">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.customer_id"
                v-text="errors.customer_id[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
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
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.modelo}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Modelo
              </label>
              <el-input v-model="form.modelo">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.modelo"
                v-text="errors.modelo[0]"
              ></small>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.marca}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Marca
              </label>
              <el-input v-model="form.marca">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.marca"
                v-text="errors.marca[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.serie}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Serie
              </label>
              <el-input v-model="form.serie">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.serie"
                v-text="errors.serie[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.color}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Color
              </label>
              <el-input v-model="form.color">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.color"
                v-text="errors.color[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.motor}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Motor
              </label>
              <el-input v-model="form.motor">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.motor"
                v-text="errors.motor[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.anio_fabricacion}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Año Fabricacion
              </label>
              <el-input v-model="form.anio_fabricacion">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.anio_fabricacion"
                v-text="errors.anio_fabricacion[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{'has-danger': errors.Kilometraje}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Kilometraje
              </label>
              <el-input v-model="form.Kilometraje">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.Kilometraje"
                v-text="errors.Kilometraje[0]"
              ></small>
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
      resource: "workshop/vehiculo",
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
        id: null,
        number: null,
        name: null,
        telephone: null
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
