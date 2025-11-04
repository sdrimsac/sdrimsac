<!-- Modal de Importar Productos en la Principal Admin -->
<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create" class="dialog-import"
        :close-on-click-modal="false" v-loading="loading" width="60%">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-6" :class="{ 'has-danger': errors.warehouse_id }">
                        <small class="form-control-feedback" v-if="errors.warehouse_id"
                            v-text="errors.warehouse_id[0]"></small>

                        <div class="mt-2 col-md-12 d-flex justify-content-center"
                            :class="{ 'has-danger': errors.file }">
                            <el-upload ref="upload" :headers="headers" action="/staff/import-person" :show-file-list="true"
                                :auto-upload="false" :multiple="false" :on-error="errorUpload"
                                :before-upload="onBeforeUpload" :limit="1" :data="form" :on-success="successUpload">
                                <el-button class="btn_guardarsmall" type="primary" style="height: 50px;">
                                    <i class="fa fa-file-excel" style=" font-size: 1rem;"></i>
                                    Cargar Archivo
                                </el-button>
                            </el-upload>
                            <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                        </div>
                        <div class="col-12 mb-2 d-flex justify-content-center">
                            <a class="mr-auto" href="/formats/import_workers.xlsx" target="_new">
                                <span class="mr-2"> Descargar AQUÍ el formato</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                            <el-button class="btn_cancelarsmall" type="primary" @click.prevent="close()">
                                <i class="fas fa-times fa-lg"></i> &nbsp;
                                Cancelar</el-button>
                            <el-button class="btn_guardarsmall" type="primary" id="buttonProcesar" native-type="submit"
                                :disabled="loading_submit" :loading="loading_submit">
                                <i class="fas fa-hourglass-half fa-lg" :class="{ 'fa-spin': loading_submit }"></i>
                                &nbsp; Procesar
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <el-dialog v-if="showErrors" title="Errores" :visible="showErrors" @close="showErrors = false" append-to-body
            width="75%">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Se encontraron errores en los siguientes productos:
                        </th>
                    </tr>
                    <tr>
                        <th>ID Interno</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(error, index) in generalErrors.slice(0, 100)" :key="index">
                        <td>{{ error.internal_id }}</td>
                        <td>{{ error.description }}</td>
                    </tr>
                </tbody>
            </table>
        </el-dialog>
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
            resource: "staff",
            errors: {},
            form: {},
            warehouses: [],
            loading: false,
            showErrors: false,
            generalErrors: []
        };
    },
    /* async created() {
        this.initForm();
        await this.onFetchTables();
    }, */
    methods: {
        onBeforeUpload(file) { },
        /* async onFetchTables() {
            this.loading_submit = true;

            await this.$http
                .get("/items/import/tables")
                .then(response => {
                    this.warehouses = response.data.warehouses;
                })
                .finally(() => (this.loading_submit = false));
        }, */
        initForm() {
            this.errors = {};
            this.form = {
                warehouse_id: null
            };
        },
        create() {
            this.titleDialog = "Importar Productos";
        },
        async submit() {
            /* if (!this.form.warehouse_id) {
                this.$showSAlert(
                    "IMPORTANTE",
                    "Seleccione una Almacen para continuar",
                    "success"
                );
                return;
            } */
            if (this.loading_submit) return;

            const buttonProcesar = document.querySelector("#buttonProcesar");
            buttonProcesar.classList.add("disabled");
            this.loading = true;
            this.loading_submit = true;

            await this.$refs.upload.submit();

            this.loading_submit = false;
            console.log("llego al final ");
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        },
        successUpload(response, file, fileList) {
            if (response.success) {
                this.$showSAlert("IMPORTANTE", response.message, "success");
                this.$eventHub.$emit("reloadData");
                this.$eventHub.$emit("reloadTables");
                this.$refs.upload.clearFiles();
                let errors = response.errors;
                if (errors && errors.length > 0) {
                    this.showErrors = true;
                    this.generalErrors = errors;
                } else {
                    this.close();
                }
            } else {
                this.$showSAlert("IMPORTANTE", response.message, "error");
            }
            this.loading = false;
        },
        errorUpload(error) {
            console.log(error);
        }
    }
};
</script>
