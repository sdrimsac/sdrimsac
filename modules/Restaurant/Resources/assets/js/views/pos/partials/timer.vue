<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="INGRESE REFERECIA"
    close-on-click-modal
    width="25%"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Ingrese Referencia</label>
              <el-input type="text" v-model="imput" clearable></el-input>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Ingrese Tiempo
              </label>
              <el-input type="time">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback"></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button icon="fas fa-times" @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit">Iniciar tiempo</el-button>
      </div>
    </form>
  </el-dialog>
</template>

<script>
export default {
  props: ["showDialog", "form"],
  data() {
    return {
      imput: "",
      timerInicial: false
    };
  },
  methods: {
    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        reference: null
      };
    },
    open() {
      this.timerInicial = this.form.timerInicial;
    },
    async submit() {
      try {
        const response = await this.$http.get("/caja/casino/store");
        this.timerInicial = response.data.data;
      } catch (error) {
        console.error("Error en la solicitud:", error);
      }
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>
