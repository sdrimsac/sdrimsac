<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary">
            <h4 class="text-white">EXPLORACION</h4>
            <h4 class="text-white text-right">
              Nombre del paciente | N° Historia 454136
            </h4>
          </div>
          <div class="card-body p-1">
            <el-tabs>
              <el-tab-pane>
                <span slot="label"
                  ><i class="fas fa-head-side-cough"></i>Enfermedad actual</span
                >
                <enfermedad-actual :id.sync="id"></enfermedad-actual>
              </el-tab-pane>
              <el-tab-pane>
                <span slot="label"
                  ><i class="fas fa-medkit"></i>Consulta de salud</span
                >
                <consulta-salud :id.sync="id"></consulta-salud>
              </el-tab-pane>
              <el-tab-pane>
                <span slot="label"
                  ><i class="fas fa-walking"></i>Exploración fisica</span
                >
                <exploracion :id.sync="id"></exploracion>
              </el-tab-pane>
              <el-tab-pane>
                <span slot="label"
                  ><i class="fas fa-bacteria"></i>Alergias</span
                >
                <alergia :id.sync="id"></alergia>
              </el-tab-pane>
              <el-tab-pane>
                <span slot="label"><i class="fas fa-baby"></i>Test ODP</span>
                <test></test>
              </el-tab-pane>
            </el-tabs>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EnfermedadActual from "./enfermedad-actual.vue";
import ConsultaSalud from "./consulta-salud.vue";
import Exploracion from "./exploracion-fisica.vue";
import Alergia from "./alergias.vue";
import Test from "./test-odp.vue";
export default {
  props: ["id"],
  components: {
    EnfermedadActual,
    Test,
    ConsultaSalud,
    Exploracion,
    Alergia,
  },
};
</script>