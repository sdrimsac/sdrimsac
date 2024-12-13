<!-- Modal de Importar Clientes/Proveedores -->
<template>
    <el-dialog 
        :title="titleDialog" 
        :visible="showDialog"
        @close="close"  
        @open="create" 
        class="dialog-import" 
        width="45%">
        <template #title>
            {{ titleDialog }}
        </template>
                
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <div class="form-group text-stat" :class="{'has-danger': errors.file}">
                            <el-upload
                                    ref="upload"
                                    :headers="headers"
                                    :data="{'type': type}"
                                    action="/persons/import"
                                    :show-file-list="true"
                                    :auto-upload="false"
                                    :multiple="false"
                                    :on-error="errorUpload"
                                    :limit="1"
                                    :on-success="successUpload">
                                <el-button slot="trigger" type="primary">Seleccione un archivo (xlsx)</el-button>
                            </el-upload>
                            <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="/formats/persons.xlsx" target="_new">Descargar formato (Excel)</a>
                        <i class="fas fa-file-excel fa-2x" style="color: green;"></i>
                    </div>
                </div>
            </div>
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <el-button class="btn-cancel btn-cancel:hover" icon="fas fa-times fa-lg" @click.prevent="close()">
                    <span>Cancelar</span>
                </el-button>

                <el-button class="btn-save btn-save:hover" icon="fas fa-cogs" type="primary" native-type="submit" :loading="loading_submit">
                    <span>Procesar</span>
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>
    export default {
        props: ['showDialog', 'type'],
        data() {
            return {
                loading_submit: false,
                headers: headers_token,
                titleDialog: null,
                resource: 'persons',
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
                    file: null,
                }
            },
            create() {
                if(this.type === 'customers') {
                    this.titleDialog = 'Importar Clientes'
                }
                if(this.type === 'suppliers') {
                    this.titleDialog = 'Importar Proveedores'
                }
            },
            async submit() {
                this.loading_submit = true
                await this.$refs.upload.submit()
                this.loading_submit = false
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
            successUpload(response, file, fileList) {
                if (response.success) {
                    this.$toast.success(response.message)
                    this.$eventHub.$emit('reloadData')
                    this.$refs.upload.clearFiles()
                    this.close()
                } else {
                    this.$toast.error(response.message);
                }
            },
            errorUpload(response) {
                console.log(response)
            }
        }
    }
</script>