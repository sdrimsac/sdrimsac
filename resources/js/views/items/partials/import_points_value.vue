<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="dialog-import"
        :close-on-click-modal="false"
        width="70%"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="/items/import/points-value" target="_new"
                            >Descargar Formato con productos</a
                        >
                        <i
                            class="fa fa-file-excel"
                            style="color: green; font-size: 1.5em;"
                        ></i>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div
                            class="form-group text-center"
                            :class="{ 'has-danger': errors.file }"
                        >
                            <el-upload
                                ref="upload"
                                :headers="headers"
                                action="/items/import/points-value"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :limit="1"
                                :on-success="successUpload"
                            >
                                <el-button class="btnsdr-download btnsdr-download:hover"
                                    style="height: 50px;"
                                    >
                                    <i
                                        class="fas fa-upload fa-lg"
                                        style="color: white; margin-right: 5px;"
                                    ></i>
                                    Seleccione un archivo (xlsx)</el-button
                                >
                            </el-upload>
                            <small
                                class="form-control-feedback"
                                v-if="errors.file"
                                v-text="errors.file[0]"
                            ></small>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <el-button 
                        class="btn-cancel btn-cancel:hover" 
                        icon="fas fa-times fa-lg" 
                        @click.prevent="close()"> 
                        Cancelar
                </el-button>
                <el-button
                    class="btnsdr-procesar btnsdr-procesar:hover"
                    id="buttonProcesar"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >
                    <i
                        class="fas fa-hourglass-half fa-lg"
                        :class="{ 'fa-spin': loading_submit }"
                    ></i>
                    &nbsp;
                    Procesar</el-button
                >
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
