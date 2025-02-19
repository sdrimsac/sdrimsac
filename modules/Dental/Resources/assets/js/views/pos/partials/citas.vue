<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h4 class="text-white">CITAS</h4>
            <h4 class="text-white text-right">
              Nombre del paciente | N° Historia 454136
            </h4>
          </div>
          <div class="card-body p-1">
            <div class="row p-1">
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
                      Medico
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Especialidad
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Estado Cita
                    </th>

                    <th class="text-center bg-primary text-white" scope="col">
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(data, index) in dataCollection" :key="data.id">
                    <th class="text-center" scope="row">{{ index + 1 }}</th>
                    <td class="text-center">{{ data.date }}</td>

                    <td class="text-center">
                      {{ all_doctors.find((d) => d.id == data.medic_id).name }}
                    </td>
                    <td class="text-center">Ortodoncia</td>
                    <td class="text-center">{{ data.state }}</td>
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
            <div v-if="adding" class="row p-1">
              <div class="col-md-4">
                <label for="especialidad" class="form-label"
                  >Especialidad
                </label>
                <br />
                <el-select
                  style="width: 100%"
                  id="especialidad"
                  v-model="especialidad"
                  placeholder="Seleccionar"
                >
                  <el-option
                    v-for="item in especialidades"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                  </el-option>
                </el-select>
              </div>
              <div class="col-md-4">
                <label for="doctor" class="form-label">Medicos </label>
                <br />
                <el-select
                  style="width: 100%"
                  id="doctor"
                  v-model="doctor"
                  placeholder="Seleccionar"
                >
                  <el-option
                    v-for="item in doctores"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                  </el-option>
                </el-select>
              </div>
              <div class="col-md-4">
                <label for="date" class="form-label">Fecha</label><br />
                <el-date-picker
                  style="width: 100%"
                  id="date"
                  v-model="date"
                  type="datetime"
                >
                </el-date-picker>
              </div>
              <div class="col mt-1">
                <label for="observation" class="form-label">Detalles</label>
                <el-input
                  type="textarea"
                  :rows="2"
                  v-model="observation"
                ></el-input>
              </div>
              <div class="col-md-12 text-right mt-1">
                <button class="btn btn-primary">Agregar</button>
              </div>
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
      especialidades: [],
      especialidad: "",
      doctores: [],
      doctor: "",
      date: "",
      observation: "",
      adding: false,
      diagnosticos: [],
      all_doctors: [],
      specialities: [],
      diagnostico: "",
      date: "",
    };
  },
  created() {
    this.getTables();
    this.init();
  },
  methods: {
    async init() {
      //si hay algun paciente
      if (this.id) {
        let token = localStorage.getItem("token");
        const response = await this.$http.get(`/quotes/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { data },
          data: { success },
        } = response;
        console.log(response);
        if (success) {
          this.dataCollection = data;

          // this.initState();
        }
      }
    },
    async getTables() {
      let token = localStorage.getItem("token");
      const response = await this.$http.get("quotes/tables",{
        headers: {
        Authorization: "Bearer " + token,
        }});
      if (response.status == 200) {
        const { data } = response;
        this.all_doctors = data.persons;
        this.specialities = data.specialities;
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