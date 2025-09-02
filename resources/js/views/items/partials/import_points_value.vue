<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import"
        :close-on-click-modal="false" width="50%">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group text-center" :class="{ 'has-danger': errors.file }">
                            <el-upload ref="upload" :headers="headers" action="/items/import/points-value"
                                :show-file-list="true" :auto-upload="false" :multiple="false" :on-error="errorUpload"
                                :limit="1" :on-success="successUpload">
                                <el-button class="btn_buscarsmall" type="primary">
                                    <i class="fa fa-file-excel" style="color: green; font-size: 1rem;"></i>
                                    Cargar Archivo</el-button>
                            </el-upload>
                            <a href="/items/import/points-value" target="_new">Descarga AQUÍ el Formato </a>
                            <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                        </div>

                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                            <el-button class="btn_cancelarsmall" icon="fas fa-times fa-lg" @click.prevent="close()">
                                Cancelar
                            </el-button>
                            <el-button class="btn_guardarsmall" id="buttonProcesar" type="primary" native-type="submit"
                                :loading="loading_submit">
                                <i class="fas fa-hourglass-half fa-lg" :class="{ 'fa-spin': loading_submit }"></i>
                                &nbsp;
                                Procesar</el-button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            loading_submit: false,
            headers: headers_token,
            titleDialog: null,
            resource: "items",
            errors: {},
            form: {}
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                file: null
            };
        },
        create() {
            this.titleDialog = "Importar valor de puntos por productos";
        },
        async submit() {
            this.loading_submit = true;
            await this.$refs.upload.submit();
            this.loading_submit = false;
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$showSAlert(
                    "IMPORTANTE",
                    response.message,
                    "success"
                );
                this.$eventHub.$emit("reloadData");
                this.$eventHub.$emit("reloadTables");
                this.$refs.upload.clearFiles();
                this.close();
            } else {
                this.$showSAlert(
                    "IMPORTANTE",
                    response.message,
                    "error"
                );
            }
        },
        errorUpload(response) {
            console.log(response);
        }
    }
};
</script>
