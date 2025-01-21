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
          <!-- <div class="col-md-6">
            <label class="control-label">
              <i class="fas fa-align-left"></i> Tipo de Concepto
            </label>
            <input type="text" class="form-control" v-model="form.type_concept">
          </div> -->
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.process}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Procedimiento
              </label>
              <el-input v-model="form.process">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.process" v-text="errors.process[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.price}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Precio 
              </label>
              <el-input v-model="form.price">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.price" v-text="errors.price[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.price_unit}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Categoria
              </label>
              <el-select v-model="form.category_id" placeholder="Seleccione una categoria">
                <el-option
                  v-for="category in categories"
                  :key="category.id"
                  :label="category.name"
                  :value="category.id"
                ></el-option>
              </el-select>
              <small class="form-control-feedback" v-if="errors.price_unit" v-text="errors.price_unit[0]"></small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group" :class="{'has-danger': errors.measure}">
              <label class="control-label">
                <i class="fas fa-align-left"></i> Medida 
              </label>
              <el-input v-model="form.measure" type="text">
                <i slot="prefix" class="el-icon-edit-outline"></i>
              </el-input>
              <small class="form-control-feedback" v-if="errors.measure" v-text="errors.measure[0]"></small>
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
      resource: "dental/tariffs",
      errors: {},
      form: {
        category_id: null,  // Add this field
        type_concept: null,
        process: null,
        price: null,
        measure: null,
        discount: 0
      },
      services: [],
      categories: []
    };
  },
  created() {
    this.getTables();
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
        description: null,
        category_id: null,  // Add this field
        type_concept: null,
        process: null,
        price: null,
        measure: null,
        discount: 0
      };
    },
    resetForm() {
      this.initForm();
    },
    create() {
      this.titleDialog = this.recordId ? "Editar Tarifa" : "Nuevo Tarifa";
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/record/${this.recordId}`)
          .then(response => {
            this.form = response.data.data;
          });
      } else {
        this.resetForm();
      }
    },
    getTables() {
      this.$http.get(`/${this.resource}/tables`).then(response => {
        this.categories = response.data.categories;
      });
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
