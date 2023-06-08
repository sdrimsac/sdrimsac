<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        :title="title"
        v-loading="loading"
    >
        <div class="row mt-2">
            <div class="col-md-8">
                <label for="description">Descripción</label>
                <el-input v-model="form.description"> </el-input>
            </div>
            <div class="col-md-4">
                <label for="price">Precio</label>
                <el-input-number
                    class="w-100"
                    :controls="false"
                    v-model="form.price"
                >
                </el-input-number>
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
    props: ["dataVariation", "showDialog"],
    data() {
        return {
            title: null,
            form: {},
            title: "Nuevo",
            loading: false
        };
    },
    methods: {
        async submit() {
            try {
                this.loading = true;
                this.form.type_id = this.dataVariation.typeId;
                const response = await this.$http.post(
                    `/internet/${this.dataVariation.type}/variation`,
                    this.form
                );
                if (response.status == 200) {
                    this.$toast.success("Creado con exito.");
                    this.$emit("addVariation", {
                        ...this.form,
                        type: this.dataVariation.type
                    });
                    this.close();
                } else {
                    this.$toast.warnig("Ocurrió un error.");
                }
            } catch (e) {
                console.log(e);
                this.$toast.error("Ocurrió un error.");
            } finally {
                this.loading = false;
            }
        },
        open() {
            this.form = {};
            let { type } = this.dataVariation;
            if (type) {
                this.title = type == "plan" ? "Nuevo plan" : "Nuevo concepto";
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
