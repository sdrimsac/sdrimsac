<!-- Visualizar los productos de la venta en un modal -->
<template>
    <!-- <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        :title="`Lista de productos ${form.total.toFixed(2)}`"
        :close-on-click-modal="false"
    > -->
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :show-close="false"
        :visible="showDialog"
        :title="null"
        width="70%"
        close-on-click-modal
    >
        <!-- Personalización del título con slot -->
        <template #title>
            <div
                style="display: grid; grid-template-columns: 1fr auto; gap: 300px; align-items: center;"
            >
                <!-- Título de la izquierda -->
                <span style="font-weight: bold; font-size: 16px;"
                    >Listado de Productos</span
                >

                <!-- Título de la derecha con el valor de form.total, añadiendo el simbolo 'S/' -->
                <span style="font-size: px; color: #333; text-align: right;">
                    S/ {{ form.total }}
                </span>
            </div>
        </template>
        <div class="row">
    <table class="table table-responsive" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #073f68; color: #f1f1f1; text-align: left; font-weight: bold; border-bottom: 2px solid #f1f1f1;">
                <th class="text-white" style="padding: 12px 15px;">Descripción</th>
                <th class="text-white" style="padding: 12px 15px;">Ubicación</th>
                <th class="text-white" style="padding: 12px 15px;">Precio</th>
                <th class="text-white" style="padding: 12px 15px;">Cantidad</th>
                <th class="text-white" style="padding: 12px 15px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in items" :key="index" :style="{
                backgroundColor: index % 2 === 0 ? '#f9f9f9' : '#fff',
                transition: 'background-color 0.3s ease'
            }">
                <td style="padding: 12px 15px; border-bottom: 1px solid #ddd;">
                    {{ item.description }}
                    <div v-if="item.affectation_igv_type_id == 15 || item.affectation_igv_type_id == 21">
                        <span class="badge badge-success" style="background-color: #1E88E5; color: white; padding: 4px 8px; font-size: 0.9rem; border-radius: 12px;">
                            Producto Gratuito
                        </span>
                    </div>
                </td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #ddd;">{{ item.location }}</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #ddd;">{{ item.sale_unit_price }}</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #ddd;">{{ item.quantity }}</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #ddd;">{{ formatNumber(item.total) }}</td>
            </tr>
        </tbody>
    </table>
</div>


        

        <span slot="footer" class="dialog-footer">
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
            <el-button
                class="btn-cancel btn-cancel:hover"
                icon="fas fa-times fa-lg"
                @click.prevent="close()"
            >
                <span>Cancelar</span>
            </el-button>
        </div>
        </span>
    </el-dialog>
</template>

<style>
table tbody tr:hover {
    background-color: #e8e8e8; /* Color gris claro en hover */
}
</style>
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
            // Guard against form or form.items being undefined
            this.items = (this.form && Array.isArray(this.form.items)) ? this.form.items : [];
        },
        // Safe formatter that handles undefined/null/non-number values
        formatNumber(value) {
            const n = Number(value);
            if (Number.isFinite(n)) {
                return n.toFixed(2);
            }
            return '0.00';
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
