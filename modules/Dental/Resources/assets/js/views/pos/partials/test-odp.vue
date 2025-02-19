<template>
  <div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="detailOrtodoncia" class="form-label"
          ><el-checkbox v-model="hasOrtodoncia">
            ¿Ha tenido alguna vez tratamiento de ortodoncia?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hasOrtodoncia"
          id="detailOrtodoncia"
          v-model="detailOrtodoncia"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasMedicament" class="form-label"
          ><el-checkbox v-model="hasMedicament">
            ¿Esta tomando algun medicamento?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hasMedicament"
          id="hasMedicament"
          v-model="medicamentDetail"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasAlergic" class="form-label"
          ><el-checkbox v-model="hasAlergic">
            ¿Es alérgico a algun medicamento o anestésico?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hasAlergic"
          id="hasAlergic"
          v-model="alergicDetail"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasHospitalOrCirugia" class="form-label"
          ><el-checkbox v-model="hasHospitalOrCirugia">
            ¿Has estado hospitalizado o tenido una cirugia?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hasHospitalOrCirugia"
          id="hasHospitalOrCirugia"
          v-model="detailHospitalOrCirugia"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasTranstorno" class="form-label"
          ><el-checkbox v-model="hasTranstorno">
            ¿Ha tenido algun transtorno nervioso o emocional?
          </el-checkbox>
        </label>
        <el-input
          :disabled="!hasTranstorno"
          id="hasTranstorno"
          v-model="detailTranstorno"
        ></el-input>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col md-12">
        <label for="hasEnfermedad" class="form-label"
          ><el-checkbox v-model="hasEnfermedad">
            ¿Padece o a padecido alguna de las siguientes enfermedades?
          </el-checkbox>
        </label>
        <br />
        <el-select
          id="hasEnfermedad"
          v-model="enfermedad"
          :disabled="!hasEnfermedad"
          placeholder="Seleccionar"
        >
          <el-option
            v-for="item in enfermedades"
            :key="item"
            :label="item"
            :value="item"
          >
          </el-option>
        </el-select>
      </div>
    </div>
    <div class="row mt-1">
      <div class="card-footer col-md-12 text-right">
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      enfermedad: "",
      hasEnfermedad: false,
      enfermedades: [
        "Asma",
        "Hepatitis",
        "Epilepsia",
        "Enf. renal",
        "Sarampion",
        "Varicela",
        "Tuberculosis",
        "Diabetes",
        "Otras",
      ],
      detailEnfermedad: "",
      hasOrtodoncia: false,
      detailOrtodoncia: "",
      hasMedicament: false,
      medicamentDetail: "",
      hasAlergic: false,
      alergicDetail: "",
      hasHospitalOrCirugia: false,
      detailHospitalOrCirugia: "",
      hasTranstorno: false,
      detailTranstorno: "",
    };
  },
};
</script>