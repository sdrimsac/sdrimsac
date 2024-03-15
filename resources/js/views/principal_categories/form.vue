<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row p-2">
            <div class="col-md-6">
                <label for="description">Nombre</label>
                <el-input v-model="form.name"> </el-input>
            </div>
                <div class="col-md-6">
                <label for="description">Identificador</label>
                <el-input v-model="form.identifier"> </el-input>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <el-checkbox v-model="form.is_expanded">
                    <span>¿Mostrar detalle en reporte?</span>
                </el-checkbox>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["recordId", "showDialog"],
    data() {
        return {
            title: null,
            form: {},
            loading: false,
            resource: "principal_categories"
        };
    },
    created() {},
    methods: {
        initForm() {
            this.form = {
                id: null,
                name: null,
                identifier: null,
                is_expanded: true
            };
        },
        async submit() {
            let { name } = this.form;
            if (!name) {
                this.$message.error("Debe ingresar el nombre");
                return;
            }
            try {
                this.loading = true;
                await this.$http.post(this.resource, this.form);
                this.$eventHub.$emit("reloadData");
                this.close();
            } catch (e) {
                this.$message.error("Ocurrió un error al guardar el registro");
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.initForm();
            if (this.recordId) {
                this.title = "Editar categoria principal";

                this.getRecord();
            } else {
                this.title = "Crear categoria principal";
            }
            
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        getRecord(){
            this.$http.get(`${this.resource}/record/${this.recordId}`).then(({data}) => {
                this.form = data.data;
            });
        }
    }
};
</script>
