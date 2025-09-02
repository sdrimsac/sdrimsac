<!-- Modal de Importar Productos Admin -->
<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import"
        :close-on-click-modal="false" v-loading="loading">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-6 form-group" :class="{ 'has-danger': errors.warehouse_id }">
                        <label for="warehouse">
                            <i class="fas fa-warehouse fa-lg"></i> Almacén
                        </label>
                        <el-select class="mb-1" v-model="form.warehouse_id">
                            <el-option v-for="w in warehouses" :key="w.id" :label="w.description"
                                :value="w.id"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.warehouse_id"
                            v-text="errors.warehouse_id[0]"></small>

                        <div class="col-12 mb-2" v-if="form.warehouse_id" style="display: flex; justify-content: center;">
                            <a :href="`/items/import_stock_format?warehouse_id=${form.warehouse_id}`"
                                target="_new">
                                <span class="mr-2">
                                    Descarga AQUÍ el formato
                                </span>
                                <i class="fa fa-download"></i>
                            </a>
                        </div>

                        <div style="display: flex; justify-content: center;">
                            <el-upload ref="upload" :headers="headers" action="/items/import_stock" :show-file-list="true"
                                :auto-upload="false" :multiple="false" :on-error="errorUpload"
                                :before-upload="onBeforeUpload" :limit="1" :data="form" :on-success="successUpload">
                                <el-button class="btn_buscarsmall" type="primary">
                                    <i class="fa fa-file-excel" style="color: green; font-size: 1rem;"></i>
                                    Cargar Archivo
                                </el-button>
                            </el-upload>
                        </div>
                        <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>

                    </div>
                    <div class="col-6">
                        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                            <el-button class="btn_cancelarsmall" type="primary" @click.prevent="close()">
                                <i class="fas fa-times fa-lg"></i> &nbsp;
                                Cancelar
                            </el-button>
                            <el-button class="btn_guardarsmall" id=buttonProcesar type="primary" native-type="submit"
                                :disabled="loading_submit" :loading="loading_submit">
                                <i class="fas fa-hourglass-half fa-lg" :class="{ 'fa-spin': loading_submit }"></i>
                                &nbsp;
                                Procesar</el-button>
                        </div>
                    </div>

                    <!-- <div class="col-6 form-group d-flex justify-content-end" :class="{ 'has-danger': errors.file }">

                    </div> -->

                </div>
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
        onBeforeUpload(file) { },
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
            this.titleDialog = 'Importar Stock de Productos Masivamente'
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
            if (this.loading_submit) return;

            const buttonProcesar = document.querySelector('#buttonProcesar')
            buttonProcesar.classList.add('disabled');
            this.loading = true
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
            this.loading = false
        },
        errorUpload(error) {
            console.log(error)
        }
    }
}
</script>
