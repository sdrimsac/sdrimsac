<template>
<el-dialog :title="titleDialog" width="30%" :visible="showDialog" @open="create" :close-on-click-modal="false" :close-on-press-escape="false" append-to-body :show-close="false">
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
                            <th>Ingrese Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in color_size_" :key="row.id ? 'cs-'+row.id : 'cs-'+row.color+'-'+row.size" width="100%">
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
                            <td class="text-center">
                                <el-input-number
                                    type="text"
                                    placeholder="cantidad"
                                    v-model.number="row.selectedQuantity"
                                    maxlength="8"
                                    show-word-limit
                                    controls-position="right"
                                    :min="0"
                                >
                                </el-input-number>
                            </td>
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
    props: ['showDialog', 'color_size', 'stock', 'recordId'],
    data() {
        return {
            titleDialog: "Talla Color",
            loading: false,
            errors: {},
            form: {},
            color_size_: [],
        };
    },
    async created() {},
    watch: {
        color_size: {
            handler(val) {
                // Clonar para evitar mutaciones reactivas inesperadas y forzar actualización
                this.color_size_ = Array.isArray(val)
                    ? val.map(r => ({ ...r }))
                    : [];
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        create() {
            // Asegurar que al abrir el modal se tenga una copia fresca
            if (!this.color_size_ || this.color_size_.length === 0) {
                this.color_size_ = Array.isArray(this.color_size)
                    ? this.color_size.map(r => ({ ...r }))
                    : [];
            }
        },
        async submit() {
            // Filtrar solo filas con cantidad válida (>0) y definida
            const selectedRows = this.color_size_.filter(row => row.selectedQuantity != null && row.selectedQuantity !== '' && Number(row.selectedQuantity) > 0);

            if (selectedRows.length === 0) {
                return this.$toast.error('Debe ingresar al menos una cantidad mayor a 0.');
            }

            // Emitir únicamente las filas con cantidades válidas
            this.$emit("addRowSelectColor_size", selectedRows);
            this.$toast.success('Producto agregado exitosamente a la lista de venta.');

            this.close(false); // evitar emitir de nuevo lista completa
        },
        close(emitSelection = true) {
            // Al cerrar desde el botón (no desde submit) opcionalmente emitir solo las filas con cantidad válida
            if (emitSelection) {
                const selectedRows = this.color_size_.filter(row => row.selectedQuantity != null && row.selectedQuantity !== '' && Number(row.selectedQuantity) > 0);
                this.$emit("addRowSelectColor_size", selectedRows);
            }
            this.$emit("update:showDialog", false);
        },
        async clickCancelSubmit() {}
    }
};
</script>
