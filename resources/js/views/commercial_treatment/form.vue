<template>
    <el-dialog
        :title="title"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row p-2">
            <div class="col-md-8">
                <label for="description">Descripción</label>
                <el-input v-model="form.description"> </el-input>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <el-checkbox v-model="form.is_amount">
                    <span>¿Es por monto?</span>
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
            resource: "commercial_treatment"
        };
    },
    created() {},
    methods: {
        initForm() {
            this.form = {
                id: null,
                description: null,
                is_amount: true
            };
        },
        async submit() {
            let { description } = this.form;
            if (!description) {
                this.$message.error("Debe ingresar una descripción");
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
                this.title = "Editar tratamiento comercial";

                this.getRecord();
            } else {
                this.title = "Crear tratamiento comercial";
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
