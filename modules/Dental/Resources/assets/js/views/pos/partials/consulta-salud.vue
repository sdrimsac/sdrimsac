<template>
  <div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="detailOrtodoncia" class="form-label"
          ><el-checkbox v-model="orthodontics">
            ¿Ha tenido alguna vez tratamiento de ortodoncia?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!orthodontics"
          id="detailOrtodoncia"
          v-model="dataInfo.orthodontics"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasMedicament" class="form-label"
          ><el-checkbox v-model="medicine">
            ¿Esta tomando algun medicamento?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!medicine"
          id="hasMedicament"
          v-model="dataInfo.medicine"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasAlergic" class="form-label"
          ><el-checkbox v-model="allergy">
            ¿Es alérgico a algun medicamento o anestésico?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!allergy"
          id="hasAlergic"
          v-model="dataInfo.allergy"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasHospitalOrCirugia" class="form-label"
          ><el-checkbox v-model="hospital_surgery">
            ¿Has estado hospitalizado o tenido una cirugia?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hospital_surgery"
          id="hasHospitalOrCirugia"
          v-model="dataInfo.hospital_surgery"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasTranstorno" class="form-label"
          ><el-checkbox v-model="disorder">
            ¿Ha tenido algun transtorno nervioso o emocional?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!disorder"
          id="hasTranstorno"
          v-model="dataInfo.disorder"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasEnfermedad" class="form-label"
          ><el-checkbox v-model="disease_type_id">
            ¿Padece o a padecido alguna de las siguientes enfermedades?
          </el-checkbox>
        </label>
        <br />
        <el-select
          id="hasEnfermedad"
          v-model="dataInfo.disease_type_id"
          :disabled="!disease_type_id"
          placeholder="Seleccionar"
        >
          <el-option
            v-for="item in diseases"
            :key="item.id"
            :label="item.description"
            :value="item.id"
          >
          </el-option>
        </el-select>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasTranstorno" class="form-label"
          ><el-checkbox v-model="brush_teeth">
            ¿Cepilla los dientes diariamente?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!brush_teeth"
          id="hasTranstorno"
          v-model="dataInfo.brush_teeth"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasTranstorno" class="form-label"
          ><el-checkbox v-model="high_pressure">
            ¿Sufre de presión arterial alta?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!high_pressure"
          id="hasTranstorno"
          v-model="dataInfo.high_pressure"
        ></el-input>
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
      diseases: [],
      orthodontics: false,
      medicine: false,
      allergy: false,
      hospital_surgery: false,
      disorder: false,
      disease_type_id: false,
      brush_teeth: false,
      high_pressure: false,
    };
  },
  methods: {
    setBool(v) {
      if (v) {
        return true;
      }
      return false;
    },
    changeState(v) {
      console.log(v);
      if (v) {
        v = null;
      }
      v = "";
    },
    async init() {
      //si hay algun paciente
      if (this.id) {
          let token = localStorage.getItem("token");
        const response = await this.$http.get(
          `/consultations/patient/${this.id}`,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { data },
          data: { success },
        } = response;

        if (success) {
          this.dataInfo = data;
          console.log(this.dataInfo);
          this.initState();
        }
      }
    },
    async save() {
      //si el paciente esta seleccionado
      if (this.id) {
        //aca deberia verificar si hay algun registro guardado
        this.dataInfo.patient_id = this.id;
          let token = localStorage.getItem("token");
        this.checkToSave();
        const response = await this.$http.post(
          "/consultations",
          this.dataInfo,{
        headers: {
        Authorization: "Bearer " + token,
        }});
        const {
          data: { success, message },
        } = response;
        if (success) {
          this.$message.success(message);
        }
        console.log(response);
      }
    },
    initState() {
      this.dataInfo.orthodontics && (this.orthodontics = true);
      this.dataInfo.medicine && (this.medicine = true);
      this.dataInfo.allergy && (this.allergy = true);
      this.dataInfo.hospital_surgery && (this.hospital_surgery = true);
      this.dataInfo.disorder && (this.disorder = true);
      this.dataInfo.disease_type_id && (this.disease_type_id = true);
      this.dataInfo.brush_teeth && (this.brush_teeth = true);
      this.dataInfo.high_pressure && (this.high_pressure = true);
    },
    checkToSave() {
      this.orthodontics == false && (this.dataInfo.orthodontics = null);
      this.medicine == false && (this.dataInfo.medicine = null);
      this.allergy == false && (this.dataInfo.allergy = null);
      this.hospital_surgery == false && (this.dataInfo.hospital_surgery = null);
      this.disorder == false && (this.dataInfo.disorder = null);
      this.disease_type_id == false && (this.dataInfo.disease_type_id = null);
      this.brush_teeth == false && (this.dataInfo.brush_teeth = null);
      this.high_pressure == false && (this.dataInfo.high_pressure = null);
    },
  },
  watch: {
    id: function (newer, older) {
      newer != older && this.init();
    },
  },
  async created() {
     let token = localStorage.getItem("token");
    const response = await this.$http.get("diseases/records",{
        headers: {
        Authorization: "Bearer " + token,
        }});
    if (response.status == 200) {
      const {
        data: { data },
      } = response;
      this.diseases = data;
    }

    this.init();
  },
};
</script>