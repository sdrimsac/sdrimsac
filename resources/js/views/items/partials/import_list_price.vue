<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import"
        :close-on-click-modal="false" v-loading="loading" width="40%">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <br />
                <div class="row">
                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="text-center w-100 mb-2">
                            <a href="/formats/item_price_lists.xlsx" target="_new">Descarga AQUÍ el formato </a>
                        </div>
                        <!-- <i class="fa fa-file-excel" style="color: green; font-size: 1.5em;"></i> -->

                        <div class="form-group text-center w-100" :class="{ 'has-danger': errors.file }">
                            <el-upload ref="upload" :headers="headers" action="/items/import_prices"
                                :show-file-list="true" :auto-upload="false" :multiple="false" :on-error="errorUpload"
                                :limit="1" :on-success="successUpload">
                                <el-button class="btn_guardarsmall" type="primary" style="height: 50px;">
                                    <i class="fa fa-file-excel" style=" font-size: 1rem;"></i>
                                    Cargar Archivo</el-button>
                            </el-upload>
                            <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                            <el-button class="btn_cancelarsmall" type="primary" icon="fas fa-times fa-lg"
                                @click.prevent="close()">
                                Cancelar</el-button>
                            <el-button class="btn_guardarsmall" id="buttonProcesar" type="primary" native-type="submit"
                                :disabled="loading_submit" :loading="loading_submit">
                                <i class="fas fa-hourglass-half fa-lg" :class="{ 'fa-spin': loading_submit }"></i>
                                &nbsp; Procesar</el-button>
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
            loading: false,
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
            this.titleDialog = "Importar Listado de Precios";
        },
        async submit() {
            this.loading = true;
            this.loading_submit = true;
            await this.$refs.upload.submit();
            this.loading_submit = false;
            this.loading = false;
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        successUpload(response, file, fileList) {
            this.loading = false;
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
            this.loading = false;
            console.log(response);
        }
    }
};
</script>
