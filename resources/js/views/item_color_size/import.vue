<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="dialog-import"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <label class="form-control-label" for="warehouse_id"
                            >Almacén</label
                        >
                        <el-select
                            v-model="form.warehouse_id"
                            placeholder="Seleccione un almacén"
                            :disabled="loading_submit"
                            :class="{ 'is-invalid': errors.warehouse_id }"
                        >
                            <el-option
                                v-for="warehouse in warehouses"
                                :key="warehouse.id"
                                :label="warehouse.description"
                                :value="warehouse.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div
                            class="form-group text-center"
                            :class="{ 'has-danger': errors.file }"
                        >
                            <el-upload
                                ref="upload"
                                :headers="headers"
                                action="/item-color-size/import"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :limit="1"
                                :data="form"
                                :on-success="successUpload"
                            >
                                <el-button slot="trigger" type="primary"
                                    >Seleccione un archivo (xlsx)</el-button
                                >
                            </el-upload>
                            <small
                                class="form-control-feedback"
                                v-if="errors.file"
                                v-text="errors.file[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="/formats/item_sets.xlsx" target="_new"
                            >Descargar formato</a
                        >
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Procesar</el-button
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
            resource: "item-color-size",
            errors: {},
            form: {},
            warehouses: []
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        getWarehouses() {
            this.$http.get("/items/import/tables").then(response => {
                this.warehouses = response.data.warehouses;
            });
        },
        initForm() {
            this.errors = {};
            this.form = {
                file: null
            };
        },
        create() {
            this.titleDialog = "Importar Productos Compuestos";
            this.getWarehouses();
        },
        async submit() {
            if (!this.form.warehouse_id) {
                this.$toast.warning(
                    "Seleccione un almacén para poder continuar"
                );
                return;
            }
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
