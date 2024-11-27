<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    :close-on-click-modal="false"
    width="60%"
    append-to-body
  >
    <br />
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.number}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Numero Identificacion
              </label>
              <el-input v-model="form.number" maxlength="8" show-word-limit>
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.name}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Nombre
              </label>
              <el-input v-model="form.name">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.telephone}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Telefono
              </label>
              <el-input v-model="form.telephone" maxlength="9" show-word-limit>
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small
                class="form-control-feedback"
                v-if="errors.telephone"
                v-text="errors.telephone[0]"
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
/* .el-dialog__wrapper {
    z-index: 2005 !important;
} */
</style>

<script>
export default {
  props: ["showDialog", "recordId", "external"],
  data() {
    return {
      titleDialog: null,
      loading_submit: false,
      titleDialog: null,
      resource: "workshop",
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
      this.titleDialog = this.recordId
        ? "Editar Personal Mecanico"
        : "Nuevo Personal Mecanico";
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/mecanico/record/${this.recordId}`)
          .then(response => {
            this.form = response.data.data;
          });
      }
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}/mecanico`, this.form)
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
    /* close() {
            this.showDialogInternal = false;
            if (!this.external) this.$emit('update:showDialog', false);
            this.initForm();
        }, */
  }
};
</script>
