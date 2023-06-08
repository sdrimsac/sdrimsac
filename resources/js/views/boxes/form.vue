<template>
  <el-dialog
    :title="titleDialog"
    :visible="showDialog"
    @close="close"
    @open="create"
    width="70%"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-6">
            <div
              class="form-group"
              :class="{ 'has-danger': errors.group_id }"
              v-if="register_group == false"
            >
              <label class="control-label"
                >Grupo
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="register_group = true"
                  >[Nuevo]</span
                ></label
              >
              <el-select v-model="form.group_id">
                <el-option
                  v-for="option in array_group"
                  :key="option.id"
                  :value="option.id"
                  :label="option.group"
                ></el-option>
              </el-select>
              <small
                class="form-control-feedback"
                v-if="errors.group_id"
                v-text="errors.group_id[0]"
              ></small>
            </div>
            <div
              class="form-group"
              :class="{ 'has-danger': errors_group.group }"
              v-if="register_group == true"
            >
              <label class="control-label">
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="submit_group()"
                  >[+ Guardar]</span
                >
                <span
                  class="text-danger"
                  style="cursor: pointer"
                  @click="
                    register_group = false;
                    initGroup;
                  "
                  >[Cancelar]</span
                ></label
              >
              <el-input v-model="form_group.group">
                <i slot="prefix" class="el-icon-edit-outline"></i
              ></el-input>
              <small
                class="form-control-feedback"
                v-if="errors_group.group"
                v-text="errors_group.group[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-6">
            <div
              class="form-group"
              :class="{ 'has-danger': errors.category_id }"
              v-if="register_category == false"
            >
              <label class="control-label"
                >Categoria
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="register_category = true"
                  >[Nuevo]</span
                ></label
              >
              <el-select v-model="form.category_id">
                <el-option
                  v-for="option in array_categorias"
                  :key="option.id"
                  :value="option.id"
                  :label="option.category"
                ></el-option>
              </el-select>
              <small
                class="form-control-feedback"
                v-if="errors.category_id"
                v-text="errors.category_id[0]"
              ></small>
            </div>
            <div
              class="form-group"
              :class="{ 'has-danger': errors_category.category }"
              v-if="register_category == true"
            >
              <label class="control-label">
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="submit_Category()"
                  >[+ Guardar]</span
                >
                <span
                  class="text-danger"
                  style="cursor: pointer"
                  @click="
                    register_category = false;
                    initCategory();
                  "
                  >[Cancelar]</span
                ></label
              >
              <el-input v-model="form_category.category">
                <i slot="prefix" class="el-icon-edit-outline"></i
              ></el-input>
              <small
                class="form-control-feedback"
                v-if="errors_category.category"
                v-text="errors_category.category[0]"
              ></small>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div
              class="form-group"
              :class="{ 'has-danger': errors.subcategory_id }"
              v-if="register_subcategory == false"
            >
              <label class="control-label"
                >Subcategoria
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="register_subcategory = true"
                  >[Nuevo]</span
                ></label
              >
              <el-select v-model="form.subcategory_id">
                <el-option
                  v-for="option in array_subcategorias"
                  :key="option.id"
                  :value="option.id"
                  :label="option.subcategory"
                ></el-option>
              </el-select>
              <small
                class="form-control-feedback"
                v-if="errors.subcategory_id"
                v-text="errors.subcategory_id[0]"
              ></small>
            </div>
            <div
              class="form-group"
              :class="{ 'has-danger': errors_category.subcategory }"
              v-if="register_subcategory == true"
            >
              <label class="control-label">
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="submit_Subcategory()"
                  >[+ Guardar]</span
                >
                <span
                  class="text-danger"
                  style="cursor: pointer"
                  @click="
                    register_subcategory = false;
                    initSubcategory();
                  "
                  >[Cancelar]</span
                ></label
              >
              <el-input v-model="form_subcategory.subcategory">
                <i slot="prefix" class="el-icon-edit-outline"></i
              ></el-input>
              <small
                class="form-control-feedback"
                v-if="errors_category.subcategory"
                v-text="errors_category.subcategory[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" :class="{ 'has-danger': errors.method }">
              <label class="control-label">Metodo </label>
              <el-select v-model="form.method">
                <el-option
                  v-for="option in payment_methods"
                  :key="option.id"
                  :value="option.description"
                  :label="option.description"
                ></el-option>
              </el-select>
              <small
                class="form-control-feedback"
                v-if="errors.method"
                v-text="errors.method[0]"
              ></small>
            </div>
            <div
              class="form-group"
              :class="{ 'has-danger': errors_category.subcategory }"
              v-if="register_subcategory == true"
            >
              <label class="control-label">
                <span
                  class="text-primary"
                  style="cursor: pointer"
                  @click="submit_Subcategory()"
                  >[+ Guardar]</span
                >
                <span
                  class="text-danger"
                  style="cursor: pointer"
                  @click="
                    register_subcategory = false;
                    initSubcategory();
                  "
                  >[Cancelar]</span
                ></label
              >
              <el-input v-model="form_subcategory.subcategory">
                <i slot="prefix" class="el-icon-edit-outline"></i
              ></el-input>
              <small
                class="form-control-feedback"
                v-if="errors_category.subcategory"
                v-text="errors_category.subcategory[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" :class="{ 'has-danger': errors.amount }">
              <label class="control-label">Efectivo</label>
              <el-input-number
                v-model="form.amount"
                :precision="2"
                :controls="false"
                class="w-100"
              ></el-input-number>
              <small
                class="form-control-feedback"
                v-if="errors.amount"
                v-text="errors.amount[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" :class="{ 'has-danger': errors.date }">
              <label class="control-label">Fecha</label>
              <el-date-picker
                v-model="form.date"
                format="dd-MM-yyyy"
                value-format="yyyy-MM-dd"
                type="date"
              >
              </el-date-picker>
              <small
                class="form-control-feedback"
                v-if="errors.date"
                v-text="errors.date[0]"
              ></small>
            </div>
          </div>
          <div class="col-md-12">
            <div
              class="form-group"
              :class="{ 'has-danger': errors.description }"
            >
              <label class="control-label">Detalle</label>
              <el-input type="textarea" v-model="form.description">
                <i slot="prefix" class="el-icon-edit-outline"></i
              ></el-input>
              <small
                class="form-control-feedback"
                v-if="errors.description"
                v-text="errors.description[0]"
              ></small>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" native-type="submit" :loading="loading_submit"
          >GGGGGGuardar</el-button
        >
      </div>
    </form>
  </el-dialog>
</template>

<script>
import { EventBus } from "../../helpers/bus";

export default {
  props: ["showDialog", "recordId"],
  data() {
    return {
      loading_submit: false,
      titleDialog: null,
      resource: "expensesbox",
      errors: {},
      errors_group: {},
      errors_category: {},
      errors_subcategory: {},
      form: {},
      array_subcategorias: [],
      array_categorias: [],
      array_group: [],
      register_group: false,
      register_category: false,
      register_subcategory: false,
      form_group: [],
      form_category: [],
      form_subcategory: [],
      array_company: [],
      payment_methods: [],
    };
  },
  created() {
    this.initForm();

    this.$http.get(`/${this.resource}/tables`).then((response) => {
      this.array_group = response.data.gruop;
      this.array_categorias = response.data.category;
      this.array_subcategorias = response.data.subcategory;
      this.array_company = response.data.company;
      this.payment_methods = response.data.methods;
      this.form.soap_type_id = this.array_company.soap_type_id;
    });

    //            await this.$http.get(`/${this.resource}/record`)
    //                .then(response => {
    //                    if (response.data !== '') {
    //                        this.form = response.data.data
    //                    }
    //                })
  },
  methods: {
    initGroup() {
      this.form_group = {
        id: null,
        group: null,
        type: 2,
      };
    },
    initCategory() {
      this.form_category = {
        id: null,
        category: null,
        type: 2,
      };
    },
    initSubcategory() {
      this.form_subcategory = {
        id: null,
        subcategory: null,
        type: 2,
      };
    },
    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        user_id: null,
        seller_id: null,
        group_id: null,
        category_id: null,
        subcategory_id: null,
        amount: null,
        date: null,
        description: null,
        close: null,
        type: 2,
        state: 1,
        soap_type_id: null,
      };
      this.initGroup();
      this.initCategory();
      this.initSubcategory();
    },
    submit_group() {
      this.$http
        .post(`/groups`, this.form_group)
        .then((response) => {
          if (response.data.success) {
            this.register_group = false;
            this.array_group.push({
              id: response.data.data.id,
              group: response.data.data.group,
              type: 2,
            });
            this.form.group_id = response.data.data.id;
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors_group = error.response.data;
          } else {
            console.log(error);
          }
        })
        .then(() => {
          this.loading_submit = false;
        });
    },
    submit_Category() {
      this.$http
        .post(`/category`, this.form_category)
        .then((response) => {
          if (response.data.success) {
            this.register_category = false;
            this.array_categorias.push({
              id: response.data.data.id,
              category: response.data.data.category,
              type: 2,
            });
            this.form.category_id = response.data.data.id;
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors_category = error.response.data;
          } else {
            console.log(error);
          }
        })
        .then(() => {
          this.loading_submit = false;
        });
    },
    submit_Subcategory() {
      this.$http
        .post(`/subcategories`, this.form_subcategory)
        .then((response) => {
          if (response.data.success) {
            this.register_subcategory = false;
            this.array_subcategorias.push({
              id: response.data.data.id,
              subcategory: response.data.data.subcategory,
              type: 2,
            });
            this.form.subcategory_id = response.data.data.id;
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors_subcategory = error.response.data;
          } else {
            console.log(error);
          }
        })
        .then(() => {
          this.loading_submit = false;
        });
    },
    create() {
      this.titleDialog = this.recordId
        ? "Editar Egresos Caja"
        : "Nueva Egresos Caja";
      if (this.recordId) {
        this.$http
          .get(`/${this.resource}/record/${this.recordId}`)
          .then((response) => {
            this.form = response.data.data;
          });
      }
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}`, this.form)
        .then((response) => {
          if (response.data.success) {
            this.$toast.success(response.data.message);
            this.$eventHub.$emit("reloadData");
            this.close();
          } else {
            this.$toast.error(response.data.message);
          }
        })
        .catch((error) => {
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
    },
  },
};
</script>
