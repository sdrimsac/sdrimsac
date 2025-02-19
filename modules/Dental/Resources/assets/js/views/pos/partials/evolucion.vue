<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h4 class="text-white">EVOLUCION</h4>
            <h4 class="text-white text-right">
              Nombre del paciente | N° Historia 454136
            </h4>
          </div>
          <div class="card-body p-1">
            <div class="row">
              <div v-if="!adding" class="col text-right">
                <button class="btn btn-primary" @click="adding = !adding">
                  Agregar
                </button>
              </div>
            </div>
            <div v-if="!adding" class="row p-1">
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
                      Descripción
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Medico
                    </th>
                    <th class="text-center bg-primary text-white" scope="col">
                      Especialidad
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
                    <td class="text-center">{{ data.observation }}</td>
                    <td class="text-center">
                      {{ all_doctores.find((d) => d.id == data.medic_id).name }}
                    </td>
                    <td class="text-center">
                      {{
                        especialidades.find((d) => d.id == data.speciality_id)
                          .name
                      }}
                    </td>
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
                  v-model="dataInfo.speciality_id"
                  placeholder="Seleccionar"
                  @change="updateDoctorList"
                >
                  <el-option
                    v-for="item in especialidades"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
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
                  v-model="dataInfo.medic_id"
                  placeholder="Seleccionar"
                >
                  <el-option
                    v-for="item in doctores"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
              </div>
              <div class="col-md-4">
                <label for="date" class="form-label">Fecha</label><br />
                <el-date-picker
                  style="width: 100%"
                  id="date"
                  v-model="dataInfo.date"
                  type="datetime"
                  format="dd/MM/yyyy"
                >
                </el-date-picker>
              </div>
              <div class="col mt-1">
                <label for="observation" class="form-label">Detalles</label>
                <el-input
                  type="textarea"
                  :rows="2"
                  v-model="dataInfo.observation"
                ></el-input>
              </div>
              <div class="col-md-12 text-right mt-1">
                <button class="btn btn-light" @click="adding = false">
                  Cerrar
                </button>
                <button class="btn btn-primary" @click="save">Agregar</button>
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
      dataInfo: {
        date: new Date(),
      },
      especialidades: [],
      dataCollection: [],
      all_doctores: [],
      doctores: [],
      errors: {},
      adding: false,
    };
  },
  async created() {
    this.getTables();
    this.init();
  },
  watch: {
    id: function (newer, older) {
      newer != older && this.init();
    },
  },
  methods: {
    async init() {
      //si hay algun paciente
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(
          `/evolution/patient/${this.id}`,{
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
    async save() {
      this.errors = {};
      //si el paciente esta seleccionado
      if (this.id) {
        //aca deberia verificar si hay algun registro guardado
        try {
          this.dataInfo.patient_id = this.id;
          let token = localStorage.getItem("token");
          const response = await this.$http.post("/evolution",this.dataInfo,{
                    headers: {
                        Authorization: "Bearer " + token,
                    }}
          );

          const {
            data: { success, message },
          } = response;
          console.log(response);
          if (success) {
            this.dataInfo = {};
            this.$message.success(message);
            this.init();
            this.adding = false;
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

    updateDoctorList() {
      this.doctores = this.all_doctores.filter(
        (doctor) => doctor.specialty_id == this.dataInfo.speciality_id
      );
    },
    async getTables() {

       let token = localStorage.getItem("token");
      const response = await this.$http.get("quotes/tables",{
        headers: {
        Authorization: "Bearer " + token,
        }});
      if (response.status == 200) {
        const { data } = response;
        this.all_doctores = data.persons;
        this.especialidades = data.specialities;
      }
    },
  },
};
</script>