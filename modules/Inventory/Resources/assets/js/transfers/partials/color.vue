<template>
    <el-dialog
        :title="titleDialog"
        width="40%"
        :visible="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="false"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 table-responsive">
                    <table width="100%" class="table">
                        <thead>
                            <tr width="100%">
                                <th>Talla</th>
                                <th>Color</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Seleccione Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in color_size"
                                :key="index"
                                width="100%"
                            >
                                <td>
                                    {{ row.size }}
                                </td>
                                <td>
                                    {{ row.color }}
                                </td>
                                <td>
                                    {{ row.stock }}
                                </td>
                                <td>
                                    {{ row.price }}
                                </td>
                                <td>
                                    <el-input
                                        type="text"
                                        placeholder="ingrese cantidad"
                                        v-model.number="row.selectedQuantity"
                                        maxlength="8"
                                        show-word-limit
                                    >
                                    </el-input>
                                </td>
                                <br />
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-actions text-end pt-2 pb-2">
            <el-button @click.prevent="close()">Cerrar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
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
    props: ["showDialog", "color_size"],
    data() {
        return {
            titleDialog: "Talla Color",
            loading: false,
            errors: {},
            form: {}
        };
    },
    async created() {},
    methods: {
        create() {},
        async submit() {
            let quantity = this.color_size.reduce(
                (a, b) => a + Number(b.selectedQuantity ?? "0"),
                0
            );
            this.$emit("sumColor_size", quantity);
            this.close();
        },
        close() {
            this.$emit("addRowOutputColor_size", this.color_size);
            let message = "la cantidad seleccione no puede ser mayor al stock ";
            this.$emit("showMessage", message);
            console.log(this.color_size);
            this.$emit("update:showDialog", false);
        },
        async clickCancelSubmit() {}
    }
};
</script>
