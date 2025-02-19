<template>
  <div>
    <div class="row mt-1">
      <div class="col-md-12">
        <div class="card-header bg-primary">
          <h4 class="text-white">Funciones Vitales</h4>
        </div>

        <div class="row mt-1 p-1">
          <div class="col-md-3">
            <label for="sintomas" class="form-label"
              >Presión Arterial - <small><strong>mn Hg</strong> </small>
            </label>
            <el-input v-model="dataInfo.blood_pressure"> </el-input>
            <small
              class="text-danger"
              v-if="errors.blood_pressure"
              v-text="errors.blood_pressure[0]"
            ></small>
          </div>
          <div class="col-md-3">
            <label for="sintomas" class="form-label"
              >Pulso -
              <small>
                <strong>/min</strong>
              </small>
            </label>
            <el-input v-model="dataInfo.pulse"> </el-input>
            <small
              class="text-danger"
              v-if="errors.pulse"
              v-text="errors.pulse[0]"
            ></small>
          </div>
          <div class="col-md-3">
            <label for="sintomas" class="form-label"
              >Temperatura -
              <small><strong>C°</strong></small>
            </label>
            <el-input v-model="dataInfo.temperature"> </el-input>
            <small
              class="text-danger"
              v-if="errors.temperature"
              v-text="errors.temperature[0]"
            ></small>
          </div>
          <div class="col-md-3">
            <label for="sintomas" class="form-label"
              >Frecuencia Cardiaca -
              <small><strong>x min</strong></small>
            </label>
            <el-input v-model="dataInfo.heart_rate"> </el-input>
            <small
              class="text-danger"
              v-if="errors.heart_rate"
              v-text="errors.heart_rate[0]"
            ></small>
          </div>
          <div class="col-md-3">
            <label for="sintomas" class="form-label"
              >Frecuencia Respiratoria -
              <small><strong>/ min</strong></small></label
            >
            <el-input v-model="dataInfo.respiratory_rate"> </el-input>
            <small
              class="text-danger"
              v-if="errors.respiratory_rate"
              v-text="errors.respiratory_rate[0]"
            ></small>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-1">
      <div class="col-md-12">
        <div class="card-header bg-primary">
          <h4 class="text-white">Peso - Talla</h4>
        </div>

        <div class="row mt-1 p-1">
          <div class="col-md-4">
            <label for="sintomas" class="form-label"
              >Peso -

              <small>
                <strong>kg</strong>
              </small>
            </label>
            <el-input v-model="dataInfo.weight"> </el-input>
            <small
              class="text-danger"
              v-if="errors.weight"
              v-text="errors.weight[0]"
            ></small>
          </div>
          <div class="col-md-4">
            <label for="sintomas" class="form-label"
              >Talla -
              <small><strong>m</strong></small>
            </label>
            <el-input v-model="dataInfo.height"> </el-input>
            <small
              class="text-danger"
              v-if="errors.height"
              v-text="errors.height[0]"
            ></small>
          </div>
          <div class="col-md-4">
            <label for="sintomas" class="form-label"
              >IMC - <small> <strong> kg/m</strong></small></label
            >
            <el-input v-model="dataInfo.imc"> </el-input>
            <small
              class="text-danger"
              v-if="errors.imc"
              v-text="errors.imc[0]"
            ></small>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-1">
      <div class="col">
        <label for="examenClinicoGeneral" class="form-label"
          >Examen Clinico General
        </label>
        <el-input
          type="textarea"
          :rows="2"
          id="examenClinicoGeneral"
          v-model="dataInfo.general_clinical_examination"
        >
        </el-input>
        <small
          class="text-danger"
          v-if="errors.general_clinical_examination"
          v-text="errors.general_clinical_examination[0]"
        ></small>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col">
        <label for="examenComplementario" class="form-label"
          >Examen Complementario
        </label>
        <el-input
          type="textarea"
          :rows="2"
          id="examenComplementario"
          v-model="dataInfo.complementary_examination"
        >
        </el-input>
        <small
          class="text-danger"
          v-if="errors.complementary_examination"
          v-text="errors.complementary_examination[0]"
        ></small>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col">
        <label for="odontoestomatologico" class="form-label"
          >Odontoestomatologico
        </label>
        <el-input
          type="textarea"
          :rows="2"
          id="odontoestomatologico"
          v-model="dataInfo.odontostomatological"
        >
        </el-input>
        <small
          class="text-danger"
          v-if="errors.odontostomatological"
          v-text="errors.odontostomatological[0]"
        ></small>
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
      errors: {},
      // blood_pressure: null,
      // pulse: null,
      // temperature: null,
      // heart_rate: null,
      // respiratory_rate: null,
      // weight: null,
      // height: null,
      // imc: null,
      // general_clinical_examination: null,
      // complementary_examination: null,
      // odontostomatological: null,
      // patient_id: null,
    };
  },
  created() {
    this.init();
  },
  methods: {
    async init() {
      //si hay algun paciente
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(
          `/physical_exploration/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        console.log(response);
        const {
          data: { data },
          data: { success },
        } = response;

        if (success) {
          this.dataInfo = data;
          console.log(this.dataInfo);
          //  this.initState();
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
          const response = await this.$http.post("/physical_exploration",this.dataInfo,{
            headers: {
            Authorization: "Bearer " + token,
            }});

          const {
            data: { success, message },
          } = response;

          if (success) {
            this.$message.success(message);
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
  watch: {
    id: function (newer, older) {
      newer != older && this.init();
    },
  },
};
</script>


<style>
.el-select .el-input {
  width: 110px;
}
.input-with-select .el-input-group__prepend {
  background-color: #fff;
}
</style>