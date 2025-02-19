<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h4 class="text-white">INFORMACION</h4>
            <h4 class="text-white text-right">
              {{ patient ? `${patient.value} | N° Historia 454136` : "" }}
            </h4>
          </div>
          <div class="card-body p-1">
            <div class="row">
              <div class="col-md-6">
                <label for="name" class="form-label">Nombre del paciente</label>
                <el-input id="name" v-model="currentPatient.name"></el-input>
              </div>
              <div class="col-md-6">
                <label for="document" class="form-label"
                  >Documento de identidad</label
                >
                <el-input
                  id="document"
                  v-model="currentPatient.document"
                ></el-input>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <el-input id="email" v-model="currentPatient.email"></el-input>
              </div>
              <div class="col-md-2">
                <label for="birthDate" class="form-label"
                  >Fecha de nacimiento</label
                >
                <el-input
                  id="birthDate"
                  v-model="currentPatient.birthDate"
                ></el-input>
              </div>
              <div class="col-md-2">
                <label for="age" class="form-label">Edad</label>
                <el-input id="age" v-model="currentPatient.age"></el-input>
              </div>
              <div class="col-md-2">
                <label for="sex" class="form-label">Genero</label>
                <el-input id="sex" v-model="currentPatient.sex"></el-input>
              </div>
            </div>
            <div class="row mt-1">
              <div class="col-md-12">
                <el-input
                  type="textarea"
                  :rows="2"
                  placeholder="Observaciones"
                  v-model="currentPatient.observation"
                >
                </el-input>
              </div>
            </div>
            <div class="row mt-1">
              <div class="card-footer col-md-12 text-right">
                <button type="button" class="btn btn-primary">Guardar</button>
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
  props: ["patient"],
  data() {
    return {
      currentPatient: {},
    };
  },
  methods: {
    initPatient() {
      if (this.patient) {
        this.currentPatient = {
          name: this.patient.value || "",
          email: this.patient.email || "",
          document: this.patient.number || "",
          birthDate: this.patient.birthDate || "",
          sex: this.patient.sex || "",
          age: this.patient.age || "",
          address: this.patient.address || "",
          email: this.patient.email || "",
          observation: this.patient.observation || "",
        };
      }
    },
  },
  watch: {
    patient: function (p, _) {
      console.log(p);
      this.initPatient();
    },
  },
  created() {
    this.initPatient();
  },
};
</script>
