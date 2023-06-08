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
                <el-input v-model="itemValue"> </el-input>
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
    props: ["showDialog", "record", "path", "name"],
    data() {
        return {
            title: `Crear nuevo`,
            loading: false,
            resource: "item",
            itemValue: null
        };
    },
    methods: {
        async submit() {
            try {
                this.loading = true;
                const response = await this.$http.post(`levels/${this.path}`, {
                    description: this.itemValue,
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
            this.itemValue = null;

            if (this.record) {
                this.title = `Editar ${this.name}`;
                this.itemValue = this.record.description;
            } else {
                this.title = `Crear nuevo ${this.name}`;
            }
        }
    }
};
</script>
