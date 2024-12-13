<!-- Crear o Editar Marcas -->
<template>
    <el-dialog :title="titleDialog" 
                :visible="showDialog" 
                @close="close" 
                 @open="create"
                 class="rounded-dialog" 
                :close-on-click-modal="false"
                width="30%"
    >
         <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">
                                <i class="fas fa-tag"></i> Marca
                            </label>
                            <el-input v-model="uppercaseName"> <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <!-- Botón Cancelar -->
            <el-button class="btn-cancel btn-cancel:hover" icon="fas fa-times fa-lg" @click.prevent="close()">
                <span>Cancelar</span>
            </el-button>
            <!-- Botón Guardar -->
            <el-button class="btn-save btn-save:hover" icon="fas fa-save fa-lg" type="primary" native-type="submit" :loading="loading_submit">
                <span>Guardar</span>
            </el-button>
        </div>
        </form>
    </el-dialog>
</template>



<script>
 

    export default {
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'brands', 
                errors: {}, 
                form: {
                    id: null,
                    name: null, 
                }, 
            }
        },
        computed: {
            uppercaseName: {
                get() {
                    return this.form.name ? this.form.name.toUpperCase() : '';
                },
                set(value) {
                    this.form.name = value.toUpperCase();
                }
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
                    name: null, 
                }
            },
            create() {

                this.titleDialog = (this.recordId)? 'Editar marca':'Nueva marca'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`).then(response => {
                            this.form = response.data
                        })
                }
            },
            submit() {   
 

                this.loading_submit = true  
                this.form.name = this.form.name.toUpperCase();
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