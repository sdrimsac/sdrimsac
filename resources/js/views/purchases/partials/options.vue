<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @open="create" width="30%" :close-on-click-modal="false"
        :close-on-press-escape="false" :show-close="false">

        <div class="row mb-3">
            <div class="col-6">
                <!-- Contenido de la columna izquierda -->
            </div>
            <div class="col-6">
                <!-- Contenido de la columna derecha -->
            </div>
        </div>
        <div class="d-flex justify-content-center gap-5 mt-3">
            <!-- <div class="text-center font-weight-bold">
                <button type="button" class="btn btn-lg btn-info waves-effect waves-light" @click="clickPrint('a4')"
                    style="font-size: 1em;">
                    <i class="fa fa-file-alt"></i>
                </button>
                <p style="font-size: 1em;">Imprimir A4</p>
            </div> -->
            <div class="text-center font-weight-bold">
                <button type="button" class="btn btn-lg btn-info waves-effect waves-light"
                    @click="clickPrinter(recordId)" style="font-size: 1em;">
                    <i class="fa fa-file-alt"></i>
                </button>
                <p style="font-size: 1em;">A4</p>
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


        <div class="form-actions d-flex justify-content-center gap-3 pt-2 pb-2">
            <template v-if="showClose">
            <el-button type="primary" class="btn_cancelarsmall" icon="fas fa-times fa-lg" @click="clickClose">
                <span> Cerrar</span>
            </el-button>
            </template>
            <el-button type="primary" class="btn_excelsmall" icon="fas fa-list fa-lg" @click="clickFinalize"
            style="font-size: 1.2em;">
            <span> Listado</span>
            </el-button>
            <el-button class="btn_guardarsmall" icon="fas fa-plus fa-lg" type="primary" native-type="submit"
            @click="clickNewDocument">
            <span> Nueva compra</span>
            </el-button>
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
