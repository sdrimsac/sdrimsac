<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h4 class="text-white">DIAGNOSTICO</h4>
            <h4 class="text-white text-right">
              Nombre del paciente | N° Historia 454136
            </h4>
          </div>
          <div class="card-body p-1">
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <label for="date" class="form-label">Fecha</label><br />
                <el-date-picker
                  disabled
                  id="date"
                  v-model="dataInfo.date"
                  type="datetime"
                  format="dd/MM/yyyy"
                  placeholder="Select date and time"
                >
                </el-date-picker>
              </div>
              <div class="col-md-6">
                <label for="diagnostico" class="form-label">Diagnostico</label
                ><br />
                <el-select
                  style="width: 100%"
                  id="diagnostico"
                  v-model="dataInfo.diagnosis_types_id"
                  placeholder="Seleccionar"
                >
                  <el-option
                    v-for="item in diagnosis"
                    :key="item.id"
                    :label="item.description"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
              </div>
              <div
                class="
                  col-md-2
                  text-center
                  justify-content-center
                  align-self-end
                "
              >
                <button class="btn btn-primary" @click="save">Agregar</button>
              </div>
            </div>
            <div class="row mt-1 p-1">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center bg-primary text-white" scope="col">
                      #
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Fecha
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      CIE10
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Diagnostico
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in dataCollection" :key="data.key">
                    <td class="text-center celda">{{ index + 1 }}</td>
                    <td class="text-center celda">{{ data.date }}</td>
                    <td class="text-center celda">
                      {{
                        diagnosis.find((d) => d.id == data.diagnosis_types_id)
                          .CIE10
                      }}
                    </td>
                    <td class="text-center celda">
                      {{
                        diagnosis.find((d) => d.id == data.diagnosis_types_id)
                          .description
                      }}
                    </td>
                    <td class="text-center celda">
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      dataCollection: [],
      dataInfo: {
        date: new Date(),
      },
      diagnosis: [],
      errors: {},
    };
  },
  watch: {
    id: function (newer, older) {
      newer != older && this.init();
    },
  },
  async created() {
      let token = localStorage.getItem("token");
     
    const response = await this.$http.get("diagnosis_types/records",{
        headers: {
        Authorization: "Bearer " + token,
        }});
    if (response.status == 200) {
      const {
        data: { data },
      } = response;

      this.diagnosis = data;
    }
    this.init();
  },
  methods: {
    async init() {
      //si hay algun paciente
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(`dental/diagnosis/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { data },
          data: { success },
        } = response;

        if (success) {
          this.dataCollection = data;
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
          const response = await this.$http.post("/dental/diagnosis",this.dataInfo,{
            headers: {
              Authorization: "Bearer " + token,
            }}
          );

          const {
            data: { success, message },
          } = response;

          if (success) {
            this.dataInfo.diagnosis_types_id = null;
            this.$message.success(message);
            this.init();
          }
        } catch (e) {
          const {
            data: { errors },
          } = e.response;

          this.errors = errors;
        }
      }
    },
  },
};
</script>