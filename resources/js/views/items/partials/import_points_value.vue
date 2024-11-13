<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="dialog-import"
        :close-on-click-modal="false" 
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <a href="/items/import/points-value" target="_new"
                            >Descargar Formato con productos</a
                        >
                    </div>
                    <div class="col-md-12 mt-4">
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
                                <el-button slot="trigger" type="primary"
                                    >
                                    <i class="fas fa-file-excel fa-lg" style="color: green; margin-right: 5px;"></i>
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
            <div class="form-actions text-end pt-2 pb-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()"> Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    icon="fas fa-hourglass-half fa-lg"
                    :loading="loading_submit"
                    > Procesar</el-button
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
                this.$toast.success(response.message);
                this.$eventHub.$emit("reloadData");
                this.$eventHub.$emit("reloadTables");
                this.$refs.upload.clearFiles();
                this.close();
            } else {
                this.$toast.error(response.message);
            }
        },
        errorUpload(response) {
            console.log(response);
        }
    }
};
</script>
