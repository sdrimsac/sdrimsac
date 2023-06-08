<template>
    <div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="page-header">
              <div class="row">
                <div class="col-sm-12">
                  <h6>Inventario Inicial</h6>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active"><span class="text-muted">Inventario Inicial</span></li>
                  </ol>
                </div>
              </div>
            </div>
        </div>
        <div class="container-fluid p-l-0 p-r-0">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mb-0">
                            <div class="card-header bg-primary">
                                <h6 class="my-0 text-white">Actualizar Inventario Inicial</h6>
                            </div>
                            <div class="card-body">
                                <form autocomplete="off" @submit.prevent="submit">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group" :class="{'has-danger': errors.date_of_issue}">
                                                <label class="control-label">Nombre<span class="text-danger">*</span></label>
                                                <el-date-picker v-model="form.date_of_issue" type="date" format="dd-MM-yyyy" value-format="yyyy-MM-dd" :clearable="true"></el-date-picker>
                                                <small class="text-danger" v-if="errors.date_of_issue" v-text="errors.date_of_issue[0]"></small>
                                            </div>
                                        </div>
                                        <div class="form-actions text-end m-t-10">
                                            <el-button class="submit" type="primary" native-type="submit" :loading="loading_submit">Actualizar
                                            </el-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
        props: ['typeUser'],
         data() {
            return {
                form:{},
                errors: {},
                loading_submit:false,
                resource:"inventory/storeupdate"
            }
        },
        async created() {
            await this.initForm()
        },
        methods: {
            initForm(){
                this.form={
                    date_of_issue:moment().format('YYYY-MM-DD')
                }
            },
            async submit() {
                this.$confirm('¿ Desea Actualizar el stock Inicial de los productos ?', 'Aviso de Advertencia', {
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cerrar',
                    type: 'warning'
                    }).then(() => {

                    this.loading_submit = true
                    this.$http.post(`/${this.resource}`, this.form).then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message);
                        } else {
                            this.$toast.error(response.data.message);
                        }
                   }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data;
                        } else {
                            this.$toast.error(error.response.data.message);
                        }
                    }).then(() => {
                        this.loading_submit = false;
                    });

                    });

            }
        }
  }
</script>
