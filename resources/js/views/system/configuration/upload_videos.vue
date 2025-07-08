<template>
    <div class="card pro-upload-card">
      <div class="card-header pro-upload-header" style="background: #073f68;">
        <h3 class="my-0"><i class="el-icon-video-camera-solid"></i> Videos para los mensajes</h3>
      </div>
      <div class="card-body pro-upload-body">
        <form autocomplete="off" @submit.prevent="submit">
          <div class="form-body row">
              <div class="col-md-6 mb-4">
                <div class="form-group" :class="{'has-danger': errors.before_video_url}">
                  <label class="control-label pro-label">
                    <i class="el-icon-time"></i> Video antes del vencimiento
                  </label>
                  <el-upload
                    class="upload-demo pro-upload-area"
                    drag
                    action="#"
                    :http-request="uploadBeforeVideo"
                    :before-upload="beforeUpload"
                    accept="video/mp4"
                    :show-file-list="false">
                    <i class="el-icon-upload pro-upload-icon"></i>
                    <div class="el-upload__text pro-upload-text">Suelta el archivo aquí o <em>haz clic para subir</em></div>
                    <div class="el-upload__tip pro-upload-tip" slot="tip">Solo archivos MP4 menores a 10MB</div>
                  </el-upload>
                  <div v-if="beforeVideoPreview" class="pro-video-preview-wrapper">
                    <video 
                         :src="beforeVideoPreview" 
                         controls 
                         class="mt-2 pro-video-preview" 
                         style="max-width: 100%; max-height: 200px;">
                    </video>
                  </div>
                  <small
                    class="form-control-feedback pro-error-msg"
                    v-if="errors.before_video_url"
                    v-text="errors.before_video_url[0]"
                  ></small>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-group" :class="{'has-danger': errors.after_video_url}">
                  <label class="control-label pro-label">
                    <i class="el-icon-timer"></i> Video después del vencimiento
                  </label>
                  <el-upload
                    class="upload-demo pro-upload-area"
                    drag
                    action="#"
                    :http-request="uploadAfterVideo"
                    :before-upload="beforeUpload"
                    accept="video/mp4"
                    :show-file-list="false">
                    <i class="el-icon-upload pro-upload-icon"></i>
                    <div class="el-upload__text pro-upload-text">Suelta el archivo aquí o <em>haz clic para subir</em></div>
                    <div class="el-upload__tip pro-upload-tip" slot="tip">Solo archivos MP4 menores a 10MB</div>
                  </el-upload>
                  <div v-if="afterVideoPreview" class="pro-video-preview-wrapper">
                    <video 
                         :src="afterVideoPreview" 
                         controls 
                         class="mt-2 pro-video-preview"
                         style="max-width: 100%; max-height: 200px;">
                    </video>
                  </div>
                  <small
                    class="form-control-feedback pro-error-msg"
                    v-if="errors.after_video_url"
                    v-text="errors.after_video_url[0]"
                  ></small>
                </div>
              </div>
          </div>
          <div class="form-actions text-right pt-2">
            <el-button type="primary" native-type="submit" :loading="loading_submit" class="bg-secondary pro-btn">Guardar</el-button>
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

/* --- PRO STYLES --- */
.pro-upload-card {
  background: #f8fafc;
  border-radius: 18px;
  box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);
  border: none;
}
.pro-upload-header {
  border-radius: 18px 18px 0 0;
  background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
  color: #fff;
  box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04);
}
.pro-upload-body {
  padding: 2rem 2.5rem 2rem 2.5rem;
}
.pro-label {
  font-weight: 600;
  color: #374151;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  gap: 0.5em;
}
.pro-upload-area {
  background: #f0f4f8;
  border: 2px dashed #a0aec0;
  border-radius: 12px;
  transition: border-color 0.2s, box-shadow 0.2s;
  min-height: 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.pro-upload-area:hover {
  border-color: #6a82fb;
  box-shadow: 0 2px 8px 0 rgba(106,130,251,0.08);
}
.pro-upload-icon {
  font-size: 2.5rem;
  color: #6a82fb;
  margin-bottom: 0.5rem;
}
.pro-upload-text {
  font-size: 1.05rem;
  color: #374151;
}
.pro-upload-tip {
  color: #6a82fb;
  font-size: 0.95rem;
  margin-top: 0.5rem;
}
.pro-video-preview-wrapper {
  margin-top: 1rem;
  display: flex;
  justify-content: center;
}
.pro-video-preview {
  border-radius: 10px;
  box-shadow: 0 2px 12px 0 rgba(60,60,60,0.10);
  border: 2px solid #e0e7ef;
  background: #fff;
}
.pro-error-msg {
  color: #e53e3e;
  font-size: 0.95rem;
  margin-top: 0.5rem;
  display: block;
}
.pro-btn {
  border-radius: 8px;
  font-weight: 600;
  font-size: 1.1rem;
  padding: 0.6em 2.2em;
  box-shadow: 0 2px 8px 0 rgba(106,130,251,0.08);
}
</style>

