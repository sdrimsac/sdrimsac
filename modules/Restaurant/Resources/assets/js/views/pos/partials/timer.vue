<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="modal del timer regresivo"
    close-on-click-modal
    width="25%"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Ingrese Referencia</label>
              <el-input type="text" v-model="imput" clearable></el-input>
            </div>
          </div>
          <div>
            <el-card>
              <el-card>
                <div class="card-body text-center">{{ formattedTime}}</div>
              </el-card>
              <el-card>
                <div class="text-center">
                  <label>Ingrese Hora</label>
                  <el-input-number v-model="inputHours" :min="0" label="Horas" placeholder></el-input-number>
                </div>
              </el-card>
              <el-card>
                <div class="text-center">
                  <label>Ingrese Minutos</label>
                  <el-input-number
                    v-model="inputMinutes"
                    :min="0"
                    :max="59"
                    label="Minutos"
                    placeholder
                  ></el-input-number>
                </div>
              </el-card>
              <el-card>
                <div class="text-center">
                  <el-button type="primary" @click="startTimer" :disabled="isRunning">Iniciar</el-button>
                  <el-button type="danger" @click="stopTimer" :disabled="!isRunning">Detener</el-button>
                  <el-button type="warning" @click="resetTimer">Reiniciar</el-button>
                </div>
              </el-card>
            </el-card>
          </div>
        </div>
      </div>
      <div class="form-actions text-end pt-2 pb-2">
        <el-button icon="fas fa-times" @click.prevent="close()">Cancelar</el-button>
        <el-button type="primary" @click="startTimer" native-type="submit">Iniciar tiempo</el-button>
      </div>
    </form>
  </el-dialog>
</template>

<script>
export default {
  props: ["showDialog", "form", "table"],
  data() {
    return {
      imput: "",
      totalTime: 0,
      interval: null,
      isRunning: false,
      inputHours: 0,
      inputMinutes: 0
    };
  },
  computed: {
    formattedTime() {
      let hours = Math.floor(this.totalTime / 3600);
      let minutes = Math.floor((this.totalTime % 3600) / 60);
      let seconds = this.totalTime % 60;
      return `${hours < 10 ? "0" : ""}${hours}:${
        minutes < 10 ? "0" : ""
      }${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    }
  },
  methods: {
    startTimer() {
      if (!this.isRunning && (this.inputHours > 0 || this.inputMinutes > 0)) {
        this.isRunning = true;
        this.totalTime = this.inputHours * 3600 + this.inputMinutes * 60;
        this.interval = setInterval(() => {
          if (this.totalTime > 0) {
            this.totalTime--;
          } else {
            this.stopTimer();
            this.$message({
              message: "¡El tiempo ha terminado!",
              type: "warning"
            });
          }
        }, 1000);
      }
    },
    stopTimer() {
      clearInterval(this.interval);
      this.isRunning = false;
    },
    resetTimer() {
      this.stopTimer();
      this.totalTime = 0;
      this.inputHours = 0;
      this.inputMinutes = 0;
    },
    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        reference: null
      };
    },
    open() {
      console.log("Datos recibidos en table:", this.table);
      console.log("datos recibidos de", this.form);
    },
    /* async submit() {
      try {
        const response = await this.$http.get("/caja/tableBillar/store2");
        this.timerInicial = response.data.data;
      } catch (error) {
        console.error("Error en la solicitud:", error);
      }
    }, */
    async submit() {
      try {
        const now = new Date();
        const data = {
          reference: this.imput,
          time_start: this.inputHours,
          minutes: this.inputMinutes
        };

        const response = await this.$http.post(`/caja/billar/${this.resource}`, data);

        this.$message({
          message: "Datos enviados correctamente",
          type: "success"
        });

        this.close();
      } catch (error) {
        console.error("Error en la solicitud:", error);
        this.$message({
          message: "Hubo un error al enviar los datos",
          type: "error"
        });
      }
    },
    close() {
      this.$emit("update:showDialog", false);
    }
  }
};
</script>
