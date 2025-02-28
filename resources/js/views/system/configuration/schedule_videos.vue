<template>
    <div class="card">
      <div class="card-header bg-secondary">
        <h3 class="my-0">Días para enviar los videos</h3>
      </div>
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-body">
              <div v-for="(message, index) in messages" :key="index" class="row mb-4">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">
                          {{ index === 2 ? 'Mensaje de corte' : `Antes del vencimiento ${index + 1}` }}
                        </label>
                        <el-input-number 
                          v-model="message.send_day_at"
                          :min="1"
                          :max="31"
                          class="w-100"
                        />
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mt-4">
                      <label class="control-label">Activo</label>
                      <el-switch v-model="message.active" />
                    </div>
                  </div>
              </div>
          </div>
          <div class="form-actions text-right pt-2">
            <el-button type="primary" native-type="submit" :loading="loading_submit" class="bg-secondary">Guardar</el-button>
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
</style>

