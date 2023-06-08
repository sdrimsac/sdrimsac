<template>
    <el-dialog :title="titleDialog" :visible="showDialogPrinter" @close="close" @open="create" class="dialog-import">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                     <div class="col-md-12">
                          <label class="control-label">Asesor - Vendedor<span class="text-danger">*</span></label>
                         <el-select v-model="form.seller_id"
                            placeholder="Seleccione el Asesor">
                                        <el-option
                                        v-for="item in array_user"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                        </el-option>
                        </el-select>
                    </div>

                    <div class="col-md-12">
                          <label class="control-label">Distrito<span class="text-danger">*</span></label>
                         <el-select v-model="form.value"
                            placeholder="Seleccione el Distrito">
                                        <el-option
                                        v-for="item in array_district"
                                        :key="item.id"
                                        :label="item.description"
                                        :value="item.id">
                                        </el-option>
                        </el-select>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Aceptar</el-button>
            </div>
        </form>
    </el-dialog>
</template>
<style>
.el-dialog__body {
    padding: 1px 20px 20px 20px !important;
    color: #606266  !important;
    font-size: 14px  !important;
}
</style>
<script>

    export default {
        props: ['showDialogPrinter', 'type'],
        data() {
            return {
                loading_submit: false,
                titleDialog: "Listado de Clientes",
                resource: 'persons',
                errors: {},
                form: {},
                array_district:[],
                array_user:[]
            }
        },
        created() {
            this.initForm()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    value: null,
                    seller_id:null
                }
            },
            create() {
                // this.$http.get(`/filtrar_distritos/records`)
                // .then(response => {
                //     this.array_district = response.data.district
                //     this.array_user=response.data.asesores
                // })
            },
            async submit() {
              //  this.loading_submit = true
              //  await this.$refs.upload.submit()
              //  this.loading_submit = false
            //   if(this.form.seller_id==null){
            //       this.$message({message:"Seleccione un Asesor - Vendedor", type: 'error'})
            //       return false
            //   }
            // if(this.form.value==null){
            //       this.$message({message:"Seleccione un Distrito", type: 'error'})
            //       return false
            //   }
             if(this.form.value==null && this.form.seller_id!=null){
                  window.open( `/${this.resource}/customers/printer?seller_id=`+this.form.seller_id,"_blank");
            }else if(this.form.seller_id==null && this.form.value!=null){
                  window.open( `/${this.resource}/customers/printer?district_id=`+this.form.value,"_blank");
            }else if(this.form.seller_id==null && this.form.value==null){
                window.open( `/${this.resource}/customers/printer?district_id&seller_id`,"_blank");
            }else{
                  window.open( `/${this.resource}/customers/printer?district_id=`+this.form.value+`&seller_id=`+this.form.seller_id,"_blank");
            }


            },
            close() {
                this.$emit('update:showDialogPrinter', false)
                this.initForm()
            },

        }
    }
</script>
