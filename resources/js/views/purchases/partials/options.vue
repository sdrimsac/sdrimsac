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
        <div
            class="col-lg-12 col-md-12 col-sm-12 text-center font-weight-bold mt-3"
        >
            <button
                type="button"
                class="btn btn-lg btn-info waves-effect waves-light"
                @click="clickPrint('a4')"
            >
                <i class="fa fa-file-alt"></i>
            </button>
            <p>Imprimir A4</p>
        </div>
        

        <span slot="footer" class="dialog-footer">
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
                <template v-if="showClose">
                    <el-button  class="btn-cancel btn-cancel:hover" 
                                icon="fas fa-times fa-lg" 
                                @click="clickClose">
                        <span> Cerrar</span>
                    </el-button>
                </template>
            <!-- Botón Listado de Compras -->
            <el-button  class="btn-cancel btn-cancel:hover" 
                        icon="fas fa-times fa-lg" 
                        @click="clickFinalize">
                <span> Listado de Compras</span>
            </el-button>

            <!-- Botón Guardar -->
            <el-button  class="btn-save btn-save:hover" 
                        icon="fas fa-save fa-lg" 
                        type="primary" 
                        native-type="submit" 
                        @click="clickNewDocument">
                <span> Nueva compra</span>
            </el-button>
        </div>
        
            <template v-if="showClose">
                <el-button @click="clickClose">Cerrar</el-button>
            </template>
            <template v-else>
                <el-button @click="clickFinalize">Ir al listado</el-button>
                <el-button type="primary" @click="clickNewDocument"
                    >Nueva compra</el-button
                >
            </template>
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
            form: {}
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
