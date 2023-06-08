<template>
    <el-dialog :title="titleDialog" :visible="showFacturarDialog" @open="create" width="30%"
               :close-on-click-modal="false"
               :close-on-press-escape="false"
               :show-close="false">
                <form autocomplete="off" @submit.prevent="submit">
                <div class="form-body">
                     <div class="row">
                         <div class="col-lg-12">
                            <div class="form-group" :class="{'has-danger': errors.document_type_id}">
                                <label class="control-label">Comprobante</label>
                                 <el-select v-model="form.document_type_id">
                                    <el-option v-for="option in document_types" :key="option.id" :value="option.id" :label="option.description"></el-option>
                                </el-select>
 
                                <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small>
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors.series}">
                                <label class="control-label">Serie</label>
                                 <el-input v-model="form.series" :maxlength="4"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
 
                                <small class="form-control-feedback" v-if="errors.series" v-text="errors.series[0]"></small>
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group" :class="{'has-danger': errors.number}">
                                <label class="control-label">Numero</label>
                                 <el-input v-model="form.number"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
 
                                <small class="form-control-feedback" v-if="errors.number" v-text="errors.number[0]"></small>
                            </div>
                        </div>
                     </div>
                </div>
                </form>

        <span slot="footer" class="dialog-footer">
            <template>
                 <el-button type="primary" @click="submit()">Guardar compra</el-button>
                <el-button @click="clickClose">Cerrar</el-button>
            </template>
          
        </span>
    </el-dialog>
</template>

<script>

    export default {
        props: ['showFacturarDialog', 'recordId', 'showClose', 'type','data'],
        data() {
            return {
                titleDialog: null,
                loading: false,
                resource: 'purchases',
                errors: {},
               document_types:[],
               form:{}
            }
        },
        created() {
            this.initForm()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    id:null,
                    document_type_id:null,
                    series:null,
                    number:null
                }
            },
         async   create() {
                let document=[]
              
                   //_.filter(document,{}) 
                   let document_type=this.data.document_type_description
                   let documents=[]
                   this.form.id=this.data.id
                   this.document_type_id="01"
                   let typei = 'registrada'
                  this.titleDialog = `Facturar ${document_type}  ${typei}: ` +this.data.number_full
                    await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    documents = response.data.document_types_invoice
                }) 
                if(this.data.document_type_id=="GU75"){
                     this.document_types=_.filter(documents, (c) => {
                        return c.id != "GU75"
                    })
                }else{
                     this.document_types=_.filter(documents, (c) => {
                        return c.id != "NE76"
                    })
                 
                }
                  
            },
          
            clickFinalize() {
                location.href = `/${this.resource}`
            },
          async  submit(){
                  await this.$http.post(`/${this.resource}/facturar`, this.form)
                    .then(response => {
                        if (response.data.success) {
                           this.$toast.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                           this.clickClose()
                        } else {
                            this.$toast.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            this.$toast.error(error.response.data.message)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            clickNewDocument() {
                this.clickClose()
            },
            clickClose() {
                this.$emit('update:showFacturarDialog', false)
                this.initForm()
            },
        }
    }
</script>