<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        :title="`Lista de productos ${form.total.toFixed(2)}`"
        close-on-click-modal
    >
        <div class="row">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td>
                            {{ item.description }}
                        </td>
                        <td>
                            {{ item.sale_unit_price }}
                        </td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.total.toFixed(2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <span slot="footer" class="dialog-footer">
            <el-button @click="close">Cerrar</el-button>
        </span>

    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "form"],
    data() {
        return {
            items: []
        };
    },
    methods: {
        open() {
            this.items = this.form.items;
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
