<template>
  <el-dialog
    @open="open"
    @close="close"
    append-to-body
    :visible="showDialog"
    title="INGRESE REFERECIA PARA INICIAR TENPORIZADOR"
    close-on-click-modal
    width="25%"
  >
    <form autocomplete="off" @submit.prevent="submit">
      <div class="form-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Ingrese Referencia O Nombre del cliente</label>
              <el-input type="text" v-model="input" clearable></el-input>
            </div>
          </div>
          <div>
            <div>
              <el-card>
                <el-card>
                  <div class="text-center">{{ formattedTime }}</div>
                </el-card>
              </el-card>
            </div>
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
  props: ["showDialog", "form", "tableId"],
  data() {
    return {
      input: "",
      secondsElapsed: 0,
      interval: null,
      resource: "billar",
      isRunning: false,
      startTime: null // Add startTime to data
    };
  },
  computed: {
    formattedTime() {
      let minutes = Math.floor(this.secondsElapsed / 60);
      let seconds = this.secondsElapsed % 60;
      return `${minutes < 10 ? "0" : ""}${minutes}:${
        seconds < 10 ? "0" : ""
      }${seconds}`;
    }
  },
  methods: {
    getData() {
       this.$http.get(`/${this.resource}/casino/records`).tehn(response => {
        const casinos = response.data.data;
         console.log("Response received:", casinos);
       }).catch(error => {
         console.error("Error en la solicitud:", error);
       });

    },
    startTimer() {
      this.resetTimer(); // Reset the timer to zero
      if (!this.isRunning) {
        this.isRunning = true;
        this.startTime = new Date(); // Set the start time
        this.interval = setInterval(() => {
          const now = new Date();
          this.secondsElapsed = Math.floor((now - this.startTime) / 1000);
        }, 1000);
      }
    },
    stopTimer() {
      clearInterval(this.interval);
      this.isRunning = false;
    },
    resetTimer() {
      this.stopTimer();
      this.secondsElapsed = 0;
    },

    initForm() {
      this.errors = {};
      this.form = {
        id: null,
        reference: null
      };
    },
    open() {
      this.initForm();
      this.getData();
      console.log("Datos recibidos en table:", this.tableId);
      console.log("datos recibidos de", this.form);
    },
    async submit() {
      if (!this.input) {
        this.$showSAlert("ALERTA", "La referencia no puede estar vacía", "warning");
        return;
      }
      try {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const formattedTime = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        const data = {
          reference: this.input,
          table_id: this.tableId,
          time_start: formattedTime,
          date_start: now.toISOString().slice(0, 19).replace("T", " "),
          /* date_start: 0  */// Set date_start to null
        };
        console.log("Sending data:", data); // Log the data being sent
        const response = await this.$http.post(`/${this.resource}/casino-store`, data);
        console.log("Response received:", response); // Log the response

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
  },
  created() {
    // Remove localStorage logic
  }
};
</script>