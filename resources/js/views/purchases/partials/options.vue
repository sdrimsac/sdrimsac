<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @open="create"
        width="40%"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        :show-close="false"
    >
        <div class="d-flex justify-content-center gap-5 mt-3">
            <div class="text-center font-weight-bold">
                <button
                    type="button"
                    class="btn btn-lg btn-info waves-effect waves-light"
                    @click="clickPrint('a4')"
                    style="font-size: 2em;"
                >
                    <i class="fa fa-file-alt"></i>
                </button>
                <p style="font-size: 2em;">Imprimir A4</p>
            </div>
            <div class="text-center font-weight-bold">
                <button
                    type="button"
                    class="btn btn-lg btn-info waves-effect waves-light"
                    @click="clickPrinter(recordId)"
                    style="font-size: 2em;"
                >
                    <i class="fa fa-file-alt"></i>
                </button>
                <p style="font-size: 2em;">Imprimir A4 generado</p>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-center gap-5 mt-3">
            <div
                class="text-center font-weight-bold"
                v-for="document in documents"
                :key="document.filename"
            >
                <button
                    type="button"
                    class="btn btn-lg btn-info waves-effect waves-light"
                    @click="clickPrintDocument(document.filename)"
                    style="font-size: 2em;"
                >
                    <i class="fa fa-file-alt"></i>
                </button>
                <p style="font-size: 2em;">{{ document.type }}</p>
            </div>
        </div> -->

        <span slot="footer" class="dialog-footer">
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <template v-if="showClose">
                    <el-button
                        class="btn-cancel btn-cancel:hover"
                        icon="fas fa-times fa-lg"
                        @click="clickClose"
                    >
                        <span> Cerrar</span>
                    </el-button>
                </template>
                <div
                    class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
                >
                    <!-- Botón Listado de Compras -->
                    <el-button
                        class="btnsdr-listado btnsdr-listado:hover"
                        icon="fas fa-list fa-lg"
                        @click="clickFinalize"
                        style="font-size: 1.2em;"
                    >
                        <span> Listado de Compras</span>
                    </el-button>

                    <!-- Botón Nueva Compra -->
                    <el-button
                        class="btn-save btn-save:hover"
                        icon="fas fa-plus fa-lg"
                        type="success"
                        native-type="submit"
                        @click="clickNewDocument"
                    >
                        <span> Nueva compra</span>
                    </el-button>
                </div>
            </div>

            <!-- <template v-if="showClose">
                <el-button @click="clickClose">Cerrar</el-button>
            </template>
            <template v-else>
                <el-button @click="clickFinalize">Ir al listado</el-button>
                <el-button type="primary" @click="clickNewDocument"
                    >Nueva compra</el-button
                >
            </template> -->
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId", "showClose", "type"],
    data() {
        return {
            titleDialog: null,
            loading: false,
            resource: "purchases",
            errors: {},
            form: {},
            documents: [] // Add this line
        };
    },
    created() {
        this.initForm();
    },
    methods: {
        clickPrint(format) {
            window.open(
                `/${this.resource}/print/${this.form.external_id}/${format}`,
                "_blank"
            );
        },
        clickPrinter(recordId) {
            window.open(
            `/${this.resource}/printer/${recordId}`,
            "_blank"
            );
        },
        /* clickPrintDocument(filename) {
            window.open(
                `/${this.resource}/print/${this.form.external_id}/${filename}`,
                "_blank"
            );
        }, */
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                external_id: null,
                number: null,
                customer_email: null,
                download_pdf: null
            };
        },
        create() {
            this.$http
                .get(`/${this.resource}/record/${this.recordId}`)
                .then(response => {
                    this.form = response.data.data;
                    let typei = this.type == "edit" ? "editada" : "registrada";
                    this.titleDialog = `Compra ${typei}: ` + this.form.number;
                    this.loadDocuments(); // Add this line
                });
        },
        loadDocuments() {
            this.$http
                .get(`/${this.resource}/documents/${this.recordId}`)
                .then(response => {
                    this.documents = response.data.documents;
                });
        },
        clickFinalize() {
            location.href = `/${this.resource}`;
        },
        clickNewDocument() {
            this.clickClose();
        },
        clickClose() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
