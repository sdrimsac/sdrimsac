<!-- Modal de Importar Productos Admin -->
<template>
    <el-dialog  :title="titleDialog" 
    :visible="showDialog" 
    @close="close" 
    @open="create" 
    class="dialog-import" 
    :close-on-click-modal="false"
    v-loading="loading">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-6 form-group" :class="{'has-danger': errors.warehouse_id}">
                        <label for="warehouse">
                            <i class="fas fa-warehouse fa-lg"></i> Almacén
                        </label>
                        <el-select v-model="form.warehouse_id">
                            <el-option v-for="w in warehouses" :key="w.id" :label="w.description" :value="w.id"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.warehouse_id" v-text="errors.warehouse_id[0]"></small>
                    </div>
                    <div class="col-6 form-group d-flex justify-content-end" :class="{'has-danger': errors.file}">
                        <el-upload
                                ref="upload"
                                :headers="headers"
                                action="/items/import_stock"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :before-upload="onBeforeUpload"
                                :limit="1"
                                :data="form"
                                :on-success="successUpload">
                            <el-button class="btnsdr-download btnsdr-download:hover"
                            style="height: 50px;">
                                <i class="fas fa-upload fa-lg" style="color: green; margin-right: 5px;"></i>
                                Seleccione un archivo (xlsx)
                            </el-button>
                        </el-upload>
                        <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                    </div>
                    <div class="col-12 mt-4 mb-2" v-if="form.warehouse_id">
                        <a class=" mr-auto" :href="`/items/import_stock_format?warehouse_id=${form.warehouse_id}`" target="_new">
                            <span class="mr-2">
                                
                                Descargar AQUI el formato</span>
                            <i class="fa fa-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <el-button  class="btn-cancel btn-cancel:hover"
                            @click.prevent="close()"
                > 
                            <i class="fas fa-times fa-lg"></i> &nbsp;
                            Cancelar
                </el-button>
                <el-button class="btnsdr-procesar btnsdr-procesar:hover"
                           id=buttonProcesar 
                           type="primary" 
                           native-type="submit" 
                           :disabled="loading_submit" 
                           :loading="loading_submit">
                    <i
                        class="fas fa-hourglass-half fa-lg"
                        :class="{ 'fa-spin': loading_submit }"
                    ></i>
                    &nbsp; 
                    Procesar</el-button>
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
                    console.log("fsdfdsfsdf", this.warehouses);
                    
                }).finally(() => this.loading_submit = false);
            },
            initForm() {
                this.errors = {}
                this.form = {
                    warehouse_id: null
                }
            },
            create() {
                this.titleDialog = 'Importar Stock de Productos Masivamentedsdsdsdsd'
            },
            async submit() {
                if (!this.form.warehouse_id) {
                   
                    this.$showSAlert(
                    "IMPORTANTE",
                    "Seleccione una ALMACE para continuar",
                    "success"
                );
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
                    this.$showSAlert(
                    "IMPORTANTE",
                    response.message,
                    "success"
                )
                    
                    this.$eventHub.$emit('reloadData')
                    this.$eventHub.$emit('reloadTables')
                    this.$refs.upload.clearFiles()
                    this.close()
                } else {
                    this.$showSAlert(
                    "IMPORTANTE",
                    response.message,
                    "error"
                );
                }
                this.loading= false
            },
            errorUpload(error) {
                console.log(error)
            }
        }
    }
</script>
