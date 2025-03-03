<template>
    <el-dialog :visible.sync="showDialogMedicDetails" title="Configurar Horario Médico">
      <el-form @submit.prevent="saveSchedule">
        <el-form-item label="Día de la Semana">
          <el-select v-model="schedule.day_of_week">
            <el-option v-for="day in days" :key="day" :label="day" :value="day"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="Hora Inicio">
          <el-time-picker v-model="schedule.start_time" format="HH:mm"></el-time-picker>
        </el-form-item>
        <el-form-item label="Hora Fin">
          <el-time-picker v-model="schedule.end_time" format="HH:mm"></el-time-picker>
        </el-form-item>
        <el-form-item>
          <el-checkbox v-model="schedule.is_active">Activo</el-checkbox>
        </el-form-item>
        <el-button type="primary" @click="saveSchedule">Guardar</el-button>
      </el-form>
    </el-dialog>
</template>
  
<script>
export default {
    props: {
        showDialogMedicDetails: {
            type: Boolean,
            default: false
        },
        recordId: {
            type: [String, Number],
            default: null
        }
    },
    data() {
      return {
        schedule: {
          day_of_week: '',
          start_time: '',
          end_time: '',
          is_active: true
        },
        days: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo']
      };
    },
    methods: {
      saveSchedule() {
        // Aquí envías los datos al backend con axios o fetch
        console.log(this.schedule);
        this.$emit('update:showDialogMedicDetails', false);
      }
    }
};
</script>
