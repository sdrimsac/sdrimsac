<template>
    <div class="card">
      <div class="card-header bg-secondary">
        <h3 class="my-0">URL|Token para la emisión de documentos desde el distribuidor</h3>
      </div>
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-body">
                <div class="col-md-12">
                <div class="form-group" :class="{'has-danger': errors.document_emit_url}">
                  <label class="control-label">
                  URL
                  </label>
                  <el-input v-model="form.document_emit_url" placeholder="Ejemplo: https://portalsdr.sdrimsac.pro/"></el-input>
                  <small class="form-text text-muted">
                  Ejemplo: https://portalsdr.sdrimsac.pro/
                  </small>
                  <small
                  class="form-control-feedback"
                  v-if="errors.document_emit_url"
                  v-text="errors.document_emit_url[0]"
                  ></small>
                </div>
                </div>
                <div class="col-md-12">
                <div class="form-group" :class="{'has-danger': errors.document_emit_url_token}">
                  <label class="control-label">
                    Token del usuario administrador
                  </label>
                  <el-input v-model="form.document_emit_url_token" placeholder="Ejemplo: 123456789abcdef"></el-input>
                  <small class="form-text text-muted">
                    Ejemplo: 123456789abcdef
                  </small>
                  <small
                  class="form-control-feedback"
                  v-if="errors.document_emit_url_token"
                  v-text="errors.document_emit_url_token[0]"
                  ></small>
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
      resource: "configurations",
      errors: {},
      form: {},
    };
  },
  async created() {
    await this.initForm();

    await this.$http.get(`/${this.resource}/emit-document-url`).then(response => {
        this.form.document_emit_url = response.data.document_emit_url;
        this.form.document_emit_url_token = response.data.document_emit_url_token;
    });
  },
  methods: {
    initForm() {
      this.errors = {};
      this.form = {
        document_emit_url: null,
        document_emit_url_token: null
      };
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}`, this.form)
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

