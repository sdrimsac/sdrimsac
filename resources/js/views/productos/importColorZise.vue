<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        class="dialog-import rounded-dialog"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6 mt-4">
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
                    <div class="col-md-6 mt-4">
                        <div
                            class="form-group text-center"
                            :class="{ 'has-danger': errors.file }"
                        >
                            <el-upload
                                ref="upload"
                                :headers="headers"
                                action="inventory/transaction/importColorZise"
                                :show-file-list="true"
                                :auto-upload="false"
                                :multiple="false"
                                :on-error="errorUpload"
                                :limit="1"
                                :data="form"
                                :on-success="successUpload"
                            >
                                <el-button 
                                    slot="trigger" 
                                    type="primary"
                                    class="text-lg px-6 py-3 rounded-lg"
                                >
                                    Seleccione un archivo (xlsx) a Importar
                                </el-button>
                            </el-upload>
                            <small
                                class="form-control-feedback"
                                v-if="errors.file"
                                v-text="errors.file[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <el-button 
                            class="bg-primary text-white rounded-lg text-lg px-6 py-3 text-center"
                            @click="downloadFormat"
                            type="primary"
                        >
                            Descargar formato de importación
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button 
                    icon="fas fa-times fa-lg" 
                    @click.prevent="close()"
                    class="text-lg px-6 py-3 rounded-lg"
                    type="danger"
                >
                    Cancelar
                </el-button>
                <el-button
                    icon="fas fa-random fa-lg"
                    type="success"
                    native-type="submit"
                    :loading="loading_submit"
                    class="text-lg px-6 py-3 rounded-lg"
                >
                    Procesar
                </el-button>
            </div>
            <br />
        </form>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

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
            this.titleDialog = "Importar Colores y Tallas";
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
        },
        downloadFormat() {
            window.open('/formats/item_color_size.xlsx', '_blank');
        }
    }
};
</script>
