<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{'has-danger': errors.group}">
                            <label class="control-label">Nombre</label>
                            <el-input v-model="form.group"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.group" v-text="errors.group[0]"></small>
                        </div>
                    </div> 
                </div> 
            </div>
           <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>
</template>
 
<script>
 

    export default {
        props: ['showDialog', 'recordId','type'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'groups', 
                errors: {}, 
                form: {}, 
            }
        },
        created() {
            this.initForm() 
        },
        methods: {
            initForm() { 
                this.errors = {} 

                this.form = {
                    id: null,
                    group: null, 
                  type:this.type,
                }
            },
            create() {
               // console.log(`/${this.resource}/record/${this.recordId}`)
                this.titleDialog = (this.recordId)? 'Editar Grupo':'Nueva Grupo'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`).then(response => {
                            this.form = response.data.data
                        })
                }
            },
            submit() {   
 

                this.loading_submit = true  
                this.$http.post(`${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$toast.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$toast.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data 
                        } else {
                            console.log(error.response)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
                    
            },  
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            }
        }
    }
</script>