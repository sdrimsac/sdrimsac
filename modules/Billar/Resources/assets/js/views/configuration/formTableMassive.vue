<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    append-to-body
    :close-on-click-modal="false"
    class="rounded-dialog"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <br />
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" :class="{ 'has-danger': errors.number }">
              <label class="control-label">
                <i class="fas fa-hashtag mr-2"></i>
                Número de Mesa Billar
              </label>
              <el-input v-model="form.number"></el-input>
              <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{ 'has-danger': errors.status_table_id }">
              <label class="control-label">
                <i class="fas fa-info-circle mr-2"></i>
                Estado de Mesa Billar
              </label>
              <el-select v-model="form.status_table_id">
                <el-option
                  v-for="(data, index) in statusTable"
                  :key="index"
                  :label="data.description"
                  :value="data.id"
                ></el-option>
              </el-select>
              <small
                class="form-control-feedback"
                v-if="errors.status_table_id"
                v-text="errors.status_table_id[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{ 'has-danger': errors.area_id }">
              <label class="control-label">
                <i class="fas fa-map-marker-alt mr-2"></i>
                Área de Mesa Billar
              </label>
              <el-select v-model="form.area_id">
                <el-option
                  v-for="(data, index) in areas"
                  :key="index"
                  :label="data.description"
                  :value="data.id"
                ></el-option>
              </el-select>
              <small class="text-danger" v-if="errors.area_id" v-text="errors.area_id[0]"></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" :class="{ 'has-danger': errors.establishment_id }">
              <label class="control-label">
                <i class="fas fa-store mr-2"></i> Establecimiento
              </label>
              <el-select v-model="form.establishment_id">
                <el-option
                  v-for="(data, index) in establishments"
                  :key="index"
                  :label="data.description"
                  :value="data.id"
                ></el-option>
              </el-select>
              <small
                class="text-danger"
                v-if="errors.establishment_id"
                v-text="errors.establishment_id[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label w-100">
                <i class="fas fa-list-ol mr-2"></i>
                Número inicial de Mesa Billar
              </label>
              <el-input-number class="w-100" v-model="form.initNumberTable"></el-input-number>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label w-100">
                <i class="fas fa-list-ol mr-2"></i>
                Número final de Mesa Billar
              </label>
              <el-input-number class="w-100" v-model="form.finalNumberTable"></el-input-number>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button icon="fas fa-times fa-lg" @click.prevent="close()">Cancelar</el-button>
        <el-button
          type="primary"
          icon="fas fa-save fa-lg"
          native-type="submit"
          :loading="loading_submit"
        >Guardar</el-button>
      </div>
    </form>
  </el-dialog>
</template>

<script>
export default {
  props: [
    /* "titleDialog", */
    "showDialog",
    "type",
    "configurations",
    /* "form", */
    "recordId",
    /* "errors", */
    "statusTable",
    "areas",
    "establishments",
    /* "loading_submit" */
  ],
  data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: this.type,
      errors: {},
      form: {},
      options: []
    };
  },
  created() {
    this.initForm();
  },
  methods: {
    close() {
      this.$emit("close");
    },
    create() {
      this.$emit("create");
      this.getTables();
      this.titleDialog = "Nuevo Registro Masivo";
      this.initForm();
      let area = this.areas.find(
        area => area.description.toUpperCase() == "HOTEL"
      );
      if (area) {
        this.form.area_id = area.id;
      }

      let status = this.statusTable.find(
        status => status.description.toUpperCase() == "LIBRE"
      );
      if (status) {
        this.form.status_table_id = status.id;
      }

      /* if (this.types.length > 0) {
        this.form.table_type_id = this.types[0].id;
      } */
    },
    submit() {
      if (!this.valid()) {
        return;
      }
      this.loading_submit = true;
      this.form.numbers = this.createNumbers();
      this.$http
        .post(`/${this.resource}/billar_massive`, this.form)
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
    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        price: 0,
        month_price: 0,
        table_type_id: null,
        status_table_id: null,
        area_id: null,
        establishment_id: null,
        description: null,
        active: 1
      };
    },
    async getTables() {
      const response = await this.$http("/billar/tables");
      if (response.status == 200) {
        const { towers, floors } = response.data;
      } else {
        this.$toast.warning("Ocurrió un error");
      }
    },
    valid() {
      let pass = true;
      let {
        initNumberTable,
        finalNumberTable,
        area_id,
        establishment_id
      } = this.form;

      if (initNumberTable > finalNumberTable) {
        this.$toast.error(
          "El número inicial de mesa billar no puede ser mayor al número final de mesa billar"
        );
        pass = false;
      }

      if (area_id == null) {
        this.$toast.error("Debe seleccionar un área");
        pass = false;
      }
      if (establishment_id == null) {
        this.$toast.error("Debe seleccionar un establecimiento");
        pass = false;
      }

      return pass;
    },
    createNumbers() {
      let { initNumberTable, finalNumberTable } = this.form;
      let numbers = [];
      for (let i = initNumberTable; i <= finalNumberTable; i++) {
        numbers.push(i);
      }
      return numbers;
    },
    close(){
      this.$emit("update:showDialog", false);
    }
    
  }
};
</script>

<style scoped>
.rounded-dialog .el-dialog__header {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
</style>

<style>
.el-dialog {
  border-radius: 10px;
  overflow: hidden;
}
</style>
