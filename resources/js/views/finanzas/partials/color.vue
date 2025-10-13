<template>
<el-dialog :title="titleDialog" width="30%" 
    :visible="showDialog" @open="create" 
    :close-on-click-modal="false" 
    :close-on-press-escape="false" 
    append-to-body :show-close="false">
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
                        <tr v-for="(row, index) in color_size_" :key="index" width="100%">
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
                                <el-input type="text" placeholder="ingrese cantidad" v-model.number="row.selectedQuantity" maxlength="8" show-word-limit>
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

        color_size(val) {
            this.color_size_ = val
        }
    },
    methods: {
        create() {},
        async submit() {
            let hasValidQuantity = this.color_size_.some(row => row.selectedQuantity > 0);
            if (!hasValidQuantity) {
                return this.$toast.error('Debe ingresar al menos una cantidad mayor a 0.');
            }
            this.$toast.success('Producto agregado exitosamente a la lista de venta.');

            this.close();
        },
        close() {

            this.$emit("addRowSelectColor_size", this.color_size_);

            this.$emit("update:showDialog", false);
        },
    }
};
</script>
