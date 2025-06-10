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
                        <tbody>                            <tr
                                v-for="(color, index) in localColorSize"
                                :key="index"
                                width="100%"
                            >
                                <td>
                                    {{ color.size }}
                                </td>
                                <td>
                                    {{ color.color }}
                                </td>
                                <td>
                                    {{ color.stock }}
                                </td>
                                <td>
                                    {{ color.price }}
                                </td>
                                <td>
                                    <el-input-number
                                        v-model.number="color.quantity"
                                        controls-position="right"
                                        :min="0"
                                        :max="Number(color.stock) || 100"
                                    ></el-input-number>
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
            form: {},
            localColorSize: [] // Copia local reactiva
        };
    },    watch: {
        showDialog(val) {
            if (val) {
                this.updateLocalColorSize();
            }
        },
        // Observa cambios en color_size para actualizar la copia local
        color_size: {
            handler(newVal) {
                this.updateLocalColorSize();
            },
            immediate: true
        }
    },
    async created() {},
    methods: {
        create() {
            this.updateLocalColorSize();
        },        updateLocalColorSize() {
            // Crear una copia profunda para romper la referencia
            this.localColorSize = Array.isArray(this.color_size)
                ? this.color_size.map(row => ({
                    ...row,
                    quantity: typeof row.quantity === 'number' ? row.quantity : 0
                }))
                : [];

            console.log('Copia local actualizada:', this.localColorSize);
            
            // Marca de depuración para seguir el flujo
            console.log('MODAL: Color_size actual:', this.color_size);
            console.log('MODAL: Copia local después de actualización:', this.localColorSize);
        },
        /* async submit() {
            const arr = Array.isArray(this.color_size) ? this.color_size : [];
            let quantity = arr.reduce(
                (a, b) => a + Number(b.selectedQuantity ?? "0"),
                0
            );
            console.log("cantidad total antes de enviar al padre", quantity);
            this.$emit("sumColor_size", quantity);
            this.close();
        }, */
        async submit() {
            // Usar la copia local
            const seleccionados = this.localColorSize.filter(row => Number(row.quantity) > 0);
            let quantity = seleccionados.reduce(
                (a, b) => a + Number(b.quantity ?? 0),
                0
            );

            console.log("cantidad total antes de enviar al padre", quantity, seleccionados);

            if (seleccionados.length === 0) {
                this.$message.error('Debe seleccionar al menos una talla/color con cantidad.');
                return;
            }

            // Envía solo los seleccionados
            this.$emit("addRowOutputColor_size", seleccionados);
            this.$emit("sumColor_size", quantity);
            this.close();
        },
        close() {
            /* this.$emit("addRowOutputColor_size", this.color_size); */
            let message = "la cantidad seleccione no puede ser mayor al stock ";
            this.$emit("showMessage", message);
            console.log("que pasa aqui", this.color_size);
            this.$emit("update:showDialog", false);
        },
        async clickCancelSubmit() {}
    }
};
</script>
