<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import" v-loading="loading">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-12 form-group" :class="{'has-danger': errors.warehouse_id}">
                        <label for="warehouse">Almacén</label>
                        <el-select v-model="form.warehouse_id">
                            <el-option v-for="w in warehouses" :key="w.id" :label="w.description" :value="w.id"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.warehouse_id" v-text="errors.warehouse_id[0]"></small>
                    </div>
                    <div class="col-12 form-group" :class="{'has-danger': errors.file}">
                        <el-upload
                                ref="upload"
                                :headers="headers"
                                action="/items/import"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :before-upload="onBeforeUpload"
                                :limit="1"
                                :data="form"
                                :on-success="successUpload">
                            <el-button slot="trigger" type="primary">Seleccione un archivo (xlsx)</el-button>
                        </el-upload>
                        <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                    </div>
                    <div class="col-12 mt-4 mb-2">
                        <a class=" mr-auto" href="/formats/items.xlsx" target="_new">
                            <span class="mr-2">Descargar formato de ejemplo para importar</span>
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button id=buttonProcesar type="primary" native-type="submit" :disabled="loading_submit" :loading="loading_submit">Procesar</el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>

    export default {
        props: ['showDialog'],
        data() {
            return {
                loading_submit: false,
                headers: headers_token,
                titleDialog: null,
                resource: 'items',
                errors: {},
                form: {},
                warehouses: [],
                loading: false
            }
        },
        async created() {
            this.initForm();
            await this.onFetchTables();
            
        },
        methods: {
            onBeforeUpload(file) {},
            async onFetchTables() {
                this.loading_submit = true;
                
                await this.$http.get('/items/import/tables').then(response => {
                    this.warehouses = response.data.warehouses;
                    
                }).finally(() => this.loading_submit = false);
            },
            initForm() {
                this.errors = {}
                this.form = {
                    warehouse_id: null
                }
            },
            create() {
                this.titleDialog = 'Importar Productos'
            },
            async submit() {
                if (! this.form.warehouse_id) {
                    this.$toast.warning('Seleccione un almacén para poder continuar');
                    return;
                }
                if(this.loading_submit) return;

                const buttonProcesar = document.querySelector('#buttonProcesar')
                buttonProcesar.classList.add('disabled');
                this.loading= true 
                this.loading_submit = true
                
                await this.$refs.upload.submit()
                
                this.loading_submit = false
                console.log('llego al final ');
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
            successUpload(response, file, fileList) {
                if (response.success) {
                    this.$toast.success(response.message)
                    
                    this.$eventHub.$emit('reloadData')
                    this.$eventHub.$emit('reloadTables')
                    this.$refs.upload.clearFiles()
                    this.close()
                } else {
                    this.$toast.error(response.message);
                }
                this.loading= false
            },
            errorUpload(error) {
                console.log(error)
            }
        }
    }
</script>
