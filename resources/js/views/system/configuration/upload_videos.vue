<template>
    <div class="card">
      <div class="card-header bg-secondary">
        <h3 class="my-0">Videos para los mensajes</h3>
      </div>
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-body">
              <div class="col-md-12 mb-4">
                <div class="form-group" :class="{'has-danger': errors.before_video_url}">
                  <label class="control-label">
                    Video antes del vencimiento
                  </label>
                  
                  <el-upload
                    class="upload-demo"
                    drag
                    action="#"
                    :http-request="uploadBeforeVideo"
                    :before-upload="beforeUpload"
                    accept="video/mp4"
                    :show-file-list="false">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">Suelta el archivo aquí o <em>haz clic para subir</em></div>
                    <div class="el-upload__tip" slot="tip">Solo archivos MP4 menores a 10MB</div>
                  </el-upload>

                  <video v-if="beforeVideoPreview" 
                         :src="beforeVideoPreview" 
                         controls 
                         class="mt-2" 
                         style="max-width: 100%; max-height: 200px;">
                  </video>

                  <small
                    class="form-control-feedback"
                    v-if="errors.before_video_url"
                    v-text="errors.before_video_url[0]"
                  ></small>
                </div>
              </div>
              <div class="col-md-12 mb-4">
                <div class="form-group" :class="{'has-danger': errors.after_video_url}">
                  <label class="control-label">
                    Video despues del vencimiento
                  </label>
                  
                  <el-upload
                    class="upload-demo"
                    drag
                    action="#"
                    :http-request="uploadAfterVideo"
                    :before-upload="beforeUpload"
                    accept="video/mp4"
                    :show-file-list="false">
                    <i class="el-icon-upload"></i>
                    <div class="el-upload__text">Suelta el archivo aquí o <em>haz clic para subir</em></div>
                    <div class="el-upload__tip" slot="tip">Solo archivos MP4 menores a 10MB</div>
                  </el-upload>

                  <video v-if="afterVideoPreview" 
                         :src="afterVideoPreview" 
                         controls 
                         class="mt-2"
                         style="max-width: 100%; max-height: 200px;">
                  </video>

                  <small
                    class="form-control-feedback"
                    v-if="errors.after_video_url"
                    v-text="errors.after_video_url[0]"
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
      resource: "clients",
      errors: {},
      form: {
        before_video_url: null,
        after_video_url: null,
        before_temp_path: null,
        after_temp_path: null
      },
      beforeVideoPreview: null,
      afterVideoPreview: null
    };
  },
  async created() {
    await this.initForm();

    await this.$http.get(`/${this.resource}/videos`).then(response => {
        this.form.before_video_url = response.data.before_video_url;
        this.form.after_video_url = response.data.after_video_url;
        
        if(this.form.before_video_url) {
            this.beforeVideoPreview = this.form.before_video_url;
        }
        if(this.form.after_video_url) {
            this.afterVideoPreview = this.form.after_video_url;
        }
    });
  },
  methods: {
    initForm() {
      this.errors = {};
      this.form = {
        before_video_url: null,
        after_video_url: null,
        before_temp_path: null,
        after_temp_path: null
      };
      this.beforeVideoPreview = null;
      this.afterVideoPreview = null;
    },
    beforeUpload(file) {
      const isMP4 = file.type === 'video/mp4';
      const isLt10M = file.size / 1024 / 1024 < 10;

      if (!isMP4) {
        this.$message.error('Solo se permiten archivos MP4!');
        return false;
      }
      if (!isLt10M) {
        this.$message.error('El video debe ser menor a 10MB!');
        return false;
      }
      return true;
    },
    async uploadBeforeVideo({ file }) {
      const formData = new FormData();
      formData.append('file', file);
      
      try {
        const response = await this.$http.post('/clients/upload', formData);
        if (response.data.success) {
          this.form.before_temp_path = response.data.data.temp_path;
          this.beforeVideoPreview = response.data.data.preview_url;
          this.$message.success('Video subido correctamente');
        }
      } catch (error) {
        console.error(error);
        this.$message.error('Error al subir el video');
      }
    },
    async uploadAfterVideo({ file }) {
      const formData = new FormData();
      formData.append('file', file);
      
      try {
        const response = await this.$http.post('/clients/upload', formData);
        if (response.data.success) {
          this.form.after_temp_path = response.data.data.temp_path;
          this.afterVideoPreview = response.data.data.preview_url;
          this.$message.success('Video subido correctamente');
        }
      } catch (error) {
        console.error(error);
        this.$message.error('Error al subir el video');
      }
    },
    submit() {
      this.loading_submit = true;
      this.$http
        .post(`/${this.resource}/videos`, {
          ...this.form,
          before_temp_path: this.form.before_temp_path,
          after_temp_path: this.form.after_temp_path
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

