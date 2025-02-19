<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <el-select
          id="allergy"
          v-model="dataInfo.allergies_types_id"
          placeholder="Seleccionar"
          style="width: 100%"
        >
          <el-option
            v-for="item in allergies"
            :key="item.id"
            :label="item.description"
            :value="item.id"
          >
          </el-option>
        </el-select>
        <small
          class="text-danger"
          v-if="errors.allergies_types_id"
          v-text="errors.allergies_types_id[0]"
        ></small>
      </div>
      <div class="col-md-6">
        <el-input
          id="observation"
          placeholder="Observación"
          v-model="dataInfo.observation"
        >
        </el-input>
        <small
          class="text-danger"
          v-if="errors.observation"
          v-text="errors.observation[0]"
        ></small>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary" @click="save">Agregar</button>
      </div>
    </div>
    <div class="row mt-1">
      <table class="table">
        <thead>
          <tr>
            <th class="text-center bg-primary text-white" scope="col">#</th>
            <th class="text-center bg-primary text-white" scope="col">
              Nombre
            </th>
            <th class="text-center bg-primary text-white" scope="col">
              Observaciones
            </th>
            <th class="text-center bg-primary text-white" scope="col">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(data, index) in dataCollection" :key="data.id">
            <th class="text-center" scope="row">{{ index + 1 }}</th>
            <td class="text-center">
              {{
                data.allergies_types_id &&
                allergies.find((a) => a.id == data.allergies_types_id)
                  .description
              }}
            </td>
            <td class="text-center">{{ data.observation }}</td>
            <td class="text-center">
              <button class="btn btn-primary btn-sm">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      errors: {},
      dataInfo: {},
      dataCollection: [],
      observation: "",
      allergies: [],
    };
  },
  async created() {
      let token = localStorage.getItem("token");
    const response = await this.$http.get("allery_type/records",{
      headers: {
        Authorization: "Bearer " + token,
      }});
    if (response.status == 200) {
      const {
        data: { data },
      } = response;
      this.allergies = data;
    }
    this.init();
  },
  methods: {
    async init() {
      //si hay algun paciente
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(
          `/allergies/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { data },
          data: { success },
        } = response;

        if (success) {
          this.dataCollection = data;
          console.log(this.dataCollection);
          // this.initState();
        }
      }
    },
    async save() {
      this.errors = {};
      //si el paciente esta seleccionado
      if (this.id) {
        //aca deberia verificar si hay algun registro guardado
        try {
          this.dataInfo.patient_id = this.id;
          // this.checkToSave();
            let token = localStorage.getItem("token");
          const response = await this.$http.post("/allergies",this.dataInfo,{
            headers: {
            Authorization: "Bearer " + token,
            }});

          const {
            data: { success, message },
          } = response;

          if (success) {
            this.dataInfo = {};
            this.$message.success(message);
          }
        } catch (e) {
          const {
            data: { errors },
          } = e.response;
          console.log(e.response);
          this.errors = errors;
        }
      }
    },
  },
  watch: {
    id: function (newer, older) {
      newer != older && this.init();
    },
  },
};
</script>