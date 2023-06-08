<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        :visible="showDialog"
        v-loading="loading"
    >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <el-input v-model="form.description"> </el-input>
                    </div>
                    <div class="col-md-6 col-12">
                        <el-input-number v-model="form.default_count">
                        </el-input-number>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer" class="dialog-footer">
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "record"],
    data() {
        return {
            title: `Crear nuevo`,
            loading: false,
            resource: "item",
            form: {}
        };
    },
    methods: {
        async submit() {
            try {
                this.loading = true;
                const response = await this.$http.post(`periods`, {
                    ...this.form,
                    id: this.record ? this.record.id : null
                });
                const { message, success } = response.data;
                if (success) {
                    this.$toast.success(message);
                    this.$emit("getRecords");
                } else {
                    this.$toast.error(message);
                }
                console.log(response);
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un problema");
            } finally {
                this.loading = false;
                this.close();
            }
        },
        close() {
            this.$emit("update:showDialog");
        },
        open() {
            this.form = {
                default_count: 1
            };

            if (this.record) {
                this.form = { ...this.record };
                this.title = `Editar periodo`;
            } else {
                this.title = `Crear nuevo periodo`;
            }
        }
    }
};
</script>
