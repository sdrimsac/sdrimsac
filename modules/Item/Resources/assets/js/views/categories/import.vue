<template>
    <el-dialog
        :title="title"
        :visible.sync="showDialog"
        width="30%"
        append-to-body
    >
        <div class="row m-2">
            <div class="form-group text-end" :class="{ 'has-danger': errors.file }">
                    <el-upload
                        ref="upload"
                        :headers="headers"
                        action="/items/categories/import"
                        :show-file-list="true"
                        :auto-upload="false"
                        :multiple="false"
                        :on-error="errorUpload"
                        :limit="1"
                        :data="form"
                        :on-success="successUpload"
                    >
                        <el-button slot="trigger" type="primary" icon="el-icon-upload" class="btn-lg">
                            Seleccione un archivo (xlsx)
                            <i class="el-icon-download el-icon--right"></i>
                        </el-button>
                    </el-upload>
                    <small class="form-control-feedback" v-if="errors.file" v-text="errors.file[0]"></small>
                </div>
            
            <div class="col-md-12">
                <a href="/formats/item_categories.xlsx" target="_new"
                    >Descargar formato (Excel)</a
                >
            </div>

            <div class="form-actions text-right m-4">
                <el-button @click.prevent="close()" icon="fas fa-times"> Cancelar</el-button>
                <el-button type="primary" :loading="loading_submit" @click.prevent="submit" icon="el-icon-check"> Procesar</el-button>
            </div>
 
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog"],
    data() {
        return {
            headers: headers_token,
            title: "Importar Categorías",
            form: {
                file: null
            },
            errors: {},
            loading_submit: false
        };
    },
    methods: {
        initForm() {
            this.errors = {};
            this.form = {
                file: null
            };
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
                this.$toast.success("Categorías importadas correctamente");
                this.$eventHub.$emit("reloadData");
                this.$refs.upload.clearFiles();
                this.close();
            } else {
                this.$toast.error("Error al importar categorías");
            }
        },
        errorUpload(response) {
            this.$toast.error("Error al importar categorías");
            console.log(response);
        }
    }
};
</script>
