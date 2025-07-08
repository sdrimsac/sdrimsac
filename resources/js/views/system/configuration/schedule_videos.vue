<template>
  <div class="card shadow-lg border-0">
    <div class="card-header text-white d-flex align-items-center justify-content-between"
      style="background-color: #073f68;">
      <h3 class="my-0 font-weight-bold">
        <i class="el-icon-video-camera-solid mr-2"></i>
        Días para enviar los videos
      </h3>
      <!-- <span class="badge badge-pill badge-info px-3 py-2">Configuración avanzada</span> -->
    </div>
    <div class="card-body bg-light">
      <form autocomplete="off" @submit.prevent="submit">
        <div class="form-body">
          <div class="row mb-4">
            <div class="col-md-6">
              <div v-for="(message, index) in messages" :key="index"
                class="row mb-4 p-3 rounded bg-white shadow-sm align-items-center border border-secondary position-relative">
                <div class="position-absolute" style="top: -18px; left: 20px;">
                  <span class="badge badge-secondary px-3 py-2">
                    <i class="el-icon-message"></i>
                    {{ index === 2 ? 'Mensaje de corte' : `Antes del vencimiento ${index + 1}` }}
                  </span>
                </div>
                <div class="col-md-6 mt-3">
                  <div class="form-group mb-0">
                    <label class="control-label font-weight-bold">
                      <i class="el-icon-date mr-1"></i> Día de envío
                    </label>
                    <el-input-number v-model="message.send_day_at" :min="1" :max="31"
                      class="w-100 border border-primary rounded" />
                  </div>
                </div>
                <div class="col-md-6 mt-3">
                  <div class="form-group mb-0 d-flex align-items-center">
                    <label class="control-label font-weight-bold mr-3 mb-0">
                      <i class="el-icon-check mr-1"></i> Activo
                    </label>
                    <el-switch v-model="message.active" active-color="#13ce66" inactive-color="#ff4949" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
              <el-button type="primary" native-type="submit" :loading="loading_submit" class="bg-secondary pro-btn">
              Guardar
              </el-button>
            </div>
          </div>

        </div>

      </form>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      loading_submit: false,
      resource: "clients",
      errors: {},

      messages: []
    };
  },
  async created() {
    await this.initForm();

    await this.$http.get(`/${this.resource}/schedule-videos`).then(response => {
      if (response.data.success) {
        this.messages = response.data.messages;
      }
    });
  },
  methods: {
    initForm() {
      this.errors = {};
      this.messages = [];
    },

    validateDays() {
      for (let i = 0; i < this.messages.length; i++) {
        const days = this.messages[i].send_day_at;
        if (!days || days < 1 || days > 31) {
          this.$message.error('Todos los días deben estar entre 1 y 31');
          return false;
        }
      }
      return true;
    },

    submit() {
      if (!this.validateDays()) {
        return;
      }

      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}/schedule-videos`, {
          messages: this.messages
        })
        .then(response => {
          if (response.data.success) {
            this.$message.success(response.data.message);
          } else {
            this.$message.error(response.data.message);
          }
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data;
          } else {
            console.log(error);
          }
        })
        .finally(() => {
          this.loading_submit = false;
        });
    },
  }
};
</script>

<style scoped>
.upload-demo {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  padding: 20px;
}

.upload-demo:hover {
  border-color: #409EFF;
}

.bg-gradient-primary {
  background: linear-gradient(90deg, #4e73df 0%, #224abe 100%) !important;
  color: #fff !important;
}

.card-header {
  border-bottom: none;
}

.badge-info {
  background: #36b9cc;
  color: #fff;
  font-size: 1rem;
}

.shadow-lg {
  box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
}

.shadow-sm {
  box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
}
</style>
