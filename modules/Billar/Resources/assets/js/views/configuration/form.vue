<!-- Nueva mesa -->
 <!-- Nueva Habacion -->
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
          <div
            v-if=" type !== 'billar'"
            class="col-md-12"
          >
            <div class="form-group" :class="{ 'has-danger': errors.description }">
              <label class="control-label">
                <i class="fas fa-info-circle mr-2"></i> Descripción
              </label>
              <el-input v-model="form.description"></el-input>
              <small class="text-danger" v-if="errors.description" v-text="errors.description[0]"></small>
            </div>
          </div>
          <div v-if="type == 'caja/areas' && configurations.multiple_boxes === 1" class="col-md-6">
            <div class="form-group" :class="{ 'has-danger': errors.printer }">
              <label class="control-label">
                <i class="fas fa-print mr-2"></i> Impresora
              </label>
              <el-input v-model="form.printer"></el-input>
              <small class="text-danger" v-if="errors.printer" v-text="errors.printer[0]"></small>
            </div>
          </div>
          <div v-if="type == 'caja/areas' && configurations.multiple_boxes === 1" class="col-md-6">
            <div class="form-group" :class="{ 'has-danger': errors.printer }">
              <label class="control-label">
                <i class="fas fa-copy mr-2"></i> Nº COPIAS
              </label>
              <el-input v-model="form.copies"></el-input>
              <small class="text-danger" v-if="errors.copies" v-text="errors.copies[0]"></small>
            </div>
          </div>
          <template v-if="type == 'billar'">
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
                <el-select :disabled="recordId != null" v-model="form.status_table_id">
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
          </template>
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

<style>
.el-dialog {
  border-radius: 10px;
  overflow: hidden;
}
</style>

<script>

export default {
  props: [
    "showDialog",
    "recordId",
    "types",
    "type",
    "areas",
    "statusTable",
    "configurations",
    "establishments"
  ],
  components: {
  },
  data() {
    return {
      newTag: null,
      loading_submit: false,
      titleDialog: null,
      resource: this.type,
      errors: {},
      tags: [],
      form: {},
      options: [],
      all_services: [],
      detailsArray: [],
      detail: null,
      details: [],
    };
  },
  created() {
    this.initForm();
  },
  methods: {
    async getDetails() {
      const response = await this.$http.get("/billar/detail_table");
      if (response.status == 200) {
        this.details = response.data.data;
        this.tags = this.details.slice(0, 10);
      } else {
        this.$toast.warning("Ocurrió un error");
      }
    },
    search(input) {
      this.tags = this.details
        .filter(o => o.description.includes(input.toUpperCase()))
        .slice(0, 10);
    },
    async handleInputConfirm() {
      if (this.newTag) {
        if (this.newTag.trim().length > 1) {
          let toAdd = this.newTag.toUpperCase();

          try {
            this.loading = true;
            const response = await this.$http.post("/billar/detail_table", {
              description: toAdd,
              active: 1
            });
            if (response.status == 200) {
              this.tags.push({
                description: toAdd,
                selected: true,
                active: 1
              });
              this.addWord(toAdd);
              this.formatObs();

              // this.$emit("update:details", [
              //     ...this.details,
              //     ...this.tags
              // ]);
              // this.tags = this.details.slice(0, 10);
            } else {
              if (response.status == 422) {
                this.$toast.error("La obse ya existe.");
              } else {
                this.$toast.error("No se guardó la obs.");
              }
            }
          } catch (e) {
            console.log(e);
            const { response } = e;
            if (response.status == 422) {
              this.$toast.error("La observación ya existe.");
            } else {
              this.$toast.error("No se guardó la obs.");
            }
          } finally {
            this.loading = false;
          }
        }
      }

      this.newTag = null;
    },
    removeWord(word) {
      this.detailsArray = this.detailsArray.filter(o => o != word);
    },
    addWord(word) {
      this.detailsArray.push(word);
    },
    formatObs() {
      this.detail = this.detailsArray.join(" / ");
    },
    initForm() {
      this.detailsArray = [];

      this.detail = null;
      this.errors = {};
      this.form = {
        description: null,
        id: null,
        description: null,
        printer: null,
        copies: null,
        active: 1,
        price: 0,
        month_price: 0,
      };
    },
    async getTables() {
      const response = await this.$http("/billar/tables");
      if (response.status == 200) {
        const { towers, floors, services } = response.data;
        this.all_services = services;
        this.all_services = this.all_services.map(s => ({
          ...s,
          selected: false
        }));
        /* this.all_floors = floors;
        this.all_towers = towers;
        this.towers = towers;
        let [tower] = towers;
        this.form.tower_id = tower.id;

        this.filterFloorsByTower(tower.id); */
      } else {
        this.$toast.warning("Ocurrió un error");
      }
    },
    /* filterFloorsByTower(tower_id) {
      this.form.floor_id = null;
      this.form.tower_id = tower_id;
      this.floors = this.all_floors.filter(f => {
        return f.tower_id == tower_id;
      });
    }, */
    selectService(idx) {
      this.all_services[idx].selected = !this.all_services[idx].selected;
    },
    select(idx) {
      this.tags[idx].selected = !this.tags[idx].selected;
      if (this.tags[idx].selected) {
        this.addWord(this.tags[idx].description);
      } else {
        this.removeWord(this.tags[idx].description);
      }
      this.formatObs();
    },

    restoreDetail() {
      this.tags = this.details.slice(0, 10).map(o => ({ 
        ...o,
        description: o.description.toUpperCase(),
        selected: false
      }));
      this.detailsArray = [];
      this.newTag = null;

      if (this.detail && this.detail.length > 0) {
        this.restore();
      }
    },
    restore() {
      let obs = this.detail.split(" / ");
      this.detailsArray = obs;
      let tgs = this.tags.map(t => t.description);
      let idxs = [];
      for (let i = 0; i < tgs.length; i++) {
        let wd = tgs[i];

        if (obs.some(t => t == wd)) {
          idxs.push(i);
        }
      }
      if (idxs.length != 0) {
        idxs.forEach(i => {
          this.tags[i].selected = true;
        });
      }
    },
    async create() {
      if (this.type == "billar ") {
        await this.getTables();
      }
      this.getDetails();
      this.titleDialog = this.recordId
        ? "Modificar Registro"
        : "Nuevo Registro";
      this.initForm();
      if (this.recordId) {
        const response = await this.$http.get(
          `/${this.resource}/record/${this.recordId}`
        );

        this.form = response.data.data;
        /* if (this.type === "billar") {
        let { floor, description } = this.form;
        this.detail = description;
        this.restoreDetail();
        this.form.tower_id = floor.tower_id;
        this.filterFloorsByTower(floor.tower_id);
        this.form.floor_id = floor.id;
        this.all_services = this.all_services.map(s => {
          if (this.form.services.some(srv => srv.room_service_id == s.id)) {
            return {
              ...s,
              selected: true
            };
          }
          return s;
        });
      } */
      }

      /* if (this.type == "caja/rooms") {
        let area = this.areas.find(
          area => area.description.toUpperCase() == "HOTEL"
        );
        if (area) {
          this.form.area_id = area.id;
        }

        if (!this.recordId) {
          let status = this.statusTable.find(
            status => status.description.toUpperCase() == "LIBRE"
          );
          if (status) {
            this.form.status_table_id = status.id;
          }
        }
        if (this.types.length > 0) {
          this.form.table_type_id = this.types[0].id;
        }
      } */
    },
    /* validRoom() {
      if (this.type == "caja/rooms") {
        this.form.description = this.detail;
        let pass = true;
        let {
          number,
          floor_id,
          table_type_id,
          price,
          status_table_id,
          establishment_id
        } = this.form;
        if (!number) {
          this.$toast.error("El número de habitación es requerido");
          pass = false;
        }
        if (!floor_id) {
          this.$toast.error("El piso es requerido");
          pass = false;
        }
        if (!table_type_id) {
          this.$toast.error("El tipo de habitación es requerido");
          pass = false;
        }
        if (!price) {
          this.$toast.error("El precio es requerido");
          pass = false;
        }
        if (!status_table_id) {
          this.$toast.error("El estado es requerido");
          pass = false;
        }
        if (!establishment_id) {
          this.$toast.error("El establecimiento es requerido");
          pass = false;
        }
        return pass;
      }
      return true;
    }, */
    submit() {
      this.loading_submit = true;
      this.form.services = this.all_services
        .filter(s => s.selected)
        .map(s => s.id);
      this.$http
        .post(`/billar/${this.resource}`, this.form)
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
            this.$toast.error("Ocurrió un error / Verifique los datos");
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
