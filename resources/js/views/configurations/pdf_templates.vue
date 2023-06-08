<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-6">
                  <h6><span>Comprobantes</span></h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Configuración</span></li>
                  </ol>
                </div>
              <div class="col-12 col-md-6 d-flex align-items-start justify-content-end">
                <!-- Contact Button Start -->
                  <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto" @click="addSeeder">
                   <i class="icofont-refresh"></i>
                    <span>Actualizar</span>
                    </button>
                <!-- Contact Button End -->
              </div>
              </div>
            </div>
          </div>        
          <!-- Container-fluid starts-->
        <div class="container-fluid p-l-0 p-r-0">
        <div class="card">
            <div class="card-header bg-primary">
                <h6 class="my-0 text-white">Selección de plantilla de impresión para comprobantes</h6>
            </div>
            <div class="card-body p-t-2 p-b-5">
                <h6>Plantilla actual: <a :href="'#'+form.formats" class="text-secondary">{{form.formats}}</a></h6>
                <div class="row">
                  <div v-for="(o, index) in formatos" class="col-md-3 my-2" :key="index">
                    <el-card :body-style="{ padding: '0px' }" :id="o.formats">
                      <a @click="viewImage(o.formats)"><img :src="path.origin+'/templates/pdf/'+o.formats+'/image.png'" class="image" style="width: 100%"></a>
                      <div style="padding: 14px;">
                        <span class="text-center">{{o.formats}}</span>
                        <div class="bottom clearfix text-end">
                            <!-- <el-button type="submit" class="button" @change="changeFormat(o.formats)">Activo</el-button> -->
                            <el-radio v-model="form.formats" :label="o.formats" @change="changeFormat(o.formats)">
                                <span v-if="form.formats == o.formats">Activo</span>
                                <span v-else>Activar</span>
                            </el-radio>
                        </div>
                      </div>
                    </el-card>
                  </div>
                </div>
            </div>
        </div>
        </div>
        <el-dialog
           :visible.sync="modalImage"
           width="60">
            <span>
                <img :src="path.origin+'/templates/pdf/'+template+'/image.png'" class="image" style="width: 100%">
            </span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="modalImage = false">Cerrar</el-button>
                <el-button @click="changeFormat(template)" type="primary">Activar</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>

    export default {
        props:['path_image'],

        data() {
            return {
                loading_submit: false,
                resource: 'configurations',
                errors: {},
                form: {},
                formatos: [],
                path: location,
                modalImage: false,
                template: '',
            }
        },
        async created() {

            await this.$http.get(`/${this.resource}/record`) .then(response => {
                if (response.data !== ''){
                this.form = response.data.data;
                }
                // console.log(this.placeholder)
            });

            await this.$http.get(`/${this.resource}/getFormats`) .then(response => {
                if (response.data !== '') this.formatos = response.data
                // console.log(this.formatos)
            });

        },
        methods: {
            changeFormat(value){
                this.modalImage = false
                this.formatos = {
                    formats: value,
                }

                this.$http.post(`/${this.resource}/changeFormat`, this.formatos).then(response =>{
                    this.$toast.success(response.data.message);
                    location.reload()
                })

            },
            addSeeder(){
                var ruta = location.host
                this.$http.get(`/${this.resource}/addSeeder`).then(response =>{
                    this.$toast.success(response.data.message);
                    location.reload()
                })
            },
            viewImage($value){
                this.template = $value

                this.modalImage = true
            }
        }
    }
</script>
