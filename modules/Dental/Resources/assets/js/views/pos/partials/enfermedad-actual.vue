<template>
  <div>
    <div class="row mt-1">
      <div class="col-md-12">
        <label for="tiempoEnfermedad" class="form-label"
          >Tipo de enfermedad
        </label>
        <el-input
          id="tiempoEnfermedad"
          v-model="dataInfo.disease_type"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-md-6">
        <label for="motivoConsulta" class="form-label"
          >Motivo de consulta
        </label>
        <el-input
          type="textarea"
          :rows="2"
          id="motivoConsulta"
          v-model="dataInfo.consultation_reason"
        >
        </el-input>
      </div>
      <div class="col-md-6">
        <label for="sintomas" class="form-label"
          >Signos y sintomas principales
        </label>
        <el-input type="textarea" :rows="2" v-model="dataInfo.signs_symptoms">
        </el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-md-6">
        <label for="antecedentesPersonales" class="form-label"
          >Antecedentes Personales
        </label>
        <el-input
          type="textarea"
          :rows="2"
          id="antecedentesPersonales"
          v-model="dataInfo.personal_background"
        >
        </el-input>
      </div>
      <div class="col-md-6">
        <label for="antecedentesFamiliares" class="form-label"
          >Antecedentes Familiares
        </label>
        <el-input
          type="textarea"
          :rows="2"
          v-model="dataInfo.family_background"
        >
        </el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-md-4">
        <label for="isMedicamento" class="form-label"
          >¿Está tomando algún medicamento?
        </label>
        <el-radio-group v-model="dataInfo.medicine">
          <el-radio-button :label="true">Sí</el-radio-button>
          <el-radio-button :label="false">No</el-radio-button>
        </el-radio-group>
      </div>
      <div class="col-md-8">
        <label for="medicamento" class="form-label"
          >Nombre del medicamento
        </label>
        <el-input
          :disabled="!dataInfo.medicine"
          id="medicamento"
          v-model="dataInfo.medicine_name"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-md-6">
        <label for="motivoMedicamento" class="form-label">Motivo de uso </label>
        <el-input
          :disabled="!dataInfo.medicine"
          v-model="dataInfo.medicine_reason"
        >
        </el-input>
      </div>
      <div class="col-md-6">
        <label for="antecedentdosisMedicamentoesFamiliares" class="form-label"
          >Dosis
        </label>
        <el-input
          :disabled="!dataInfo.medicine"
          v-model="dataInfo.medicine_dose"
        >
        </el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="card-footer col-md-12 text-right">
        <button type="button" @click="save" class="btn btn-primary">
          Guardar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      dataInfo: {},
    };
  },
  created() {
    this.init();
  },
  methods: {
    async init() {
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(
          `/disease/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { data },
          data: { success },
        } = response;

        if (success) {
          this.dataInfo = data;
          this.dataInfo.medicine = !!data.medicine;
        }
      }
    },
    async save() {
      //physical_exploration

      if (this.id) {
        this.dataInfo.patient_id = this.id;
          let token = localStorage.getItem("token");
        const response = await this.$http.post("/disease", this.dataInfo,{
        headers: {
        Authorization: "Bearer " + token,
        }});
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