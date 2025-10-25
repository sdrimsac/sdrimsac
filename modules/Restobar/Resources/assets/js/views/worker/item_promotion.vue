<template>
    <el-dialog :visible="showDialog" 
    :close-on-click-modal="false" :show-close="false" 
    :title="'Productos de la Promoción' + (selectedFood ? ' - ' + selectedFood.description : '')"
        custom-class="items-promotions-dialog" @update:visible="$emit('update:showDialog', $event)"
        @close="closeDialog">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                           <!--  <th style="text-align: left;">Código</th> -->
                            <th style="text-align: left;">Descripción</th>
                            <th style="text-align: right;">Req.</th>
                            <!-- <th style="text-align: right;">Precio</th> -->
                            <th style="text-align: right;">Stock</th>
                            <th style="text-align: right;">Falta</th>
                            <th style="text-align: center;">Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="promotionItems.length === 0">
                            <td colspan="7" class="text-center">No hay productos en la promoción</td>
                        </tr>
                        <tr v-for="(row, index) in promotionItems" :key="index">
                            <!-- <td style="text-align: left;">{{ row.internal_id }}</td> -->
                            <td style="text-align: left;">{{ row.description }}</td>
                            <td style="text-align: right;">{{ row.quantity_required }}</td>
                            <!-- <td style="text-align: right;">{{ row.sale_unit_price }}</td> -->
                            <td style="text-align: right;">{{ row.stock_available }}</td>
                            <td style="text-align: right;">{{ row.difference }}</td>
                            <td style="text-align: center;">
                                <el-tag type="success" v-if="row.has_stock">Sí</el-tag>
                                <el-tag type="danger" v-else>No</el-tag>
                            </td>
                            <td>
                                <!-- <el-input v-model="row.quantity_to_add" placeholder="Cantidad a agregar"></el-input> -->
                                <el-input-number v-model="row.quantity_to_add" controls-position="right" :min="0"
                                    :max="getMaxForRow(row)" :step="1" @change="onQuantityChange(row, index)"></el-input-number>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="text-align: right; margin-top: 12px;">
                <div style="display:inline-block; margin-right:12px; vertical-align: middle; font-weight:700;">Restan: {{ remaining }}</div>
                <el-button type="primary" @click="closeDialog">Cerrar</el-button>
                <el-button type="success" @click="handleSave" style="margin-left: 8px;">Agregar</el-button>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    name: "ItemsPromotions",
    props: ["showDialog", "selectedFood", "selectedItemId"],
    data() {
        return {
            promotionItems: [],
        };
    },
    computed: {
        totalSelected() {
            return this.promotionItems.reduce((sum, it) => sum + (Number(it.quantity_to_add) || 0), 0);
        },
        remaining() {
            const promoMax = this.selectedFood && (this.selectedFood.max_quantity || this.selectedFood.maxQuantity);
            const firstRowMax = (this.promotionItems && this.promotionItems.length && (this.promotionItems[0].max_quantity || this.promotionItems[0].maxQuantity)) || null;
            const maxQuantity = promoMax || firstRowMax || null;
            if (!maxQuantity) return 'Sin límite';
            return Math.max(0, Number(maxQuantity) - this.totalSelected);
        }
    },
    methods: {
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        async setItemCheckPromotions(id) {
            let pass = true;
            if (!id) {
                return false;
            }

            try {
                const response = await this.$http.get(`/promotions/item-promotion/${id}`);
                if (response.status == 200) {
                    const data = response.data;
                    if (Array.isArray(data)) {
                        this.promotionItems = data;
                    } else if (data && data.data && Array.isArray(data.data)) {
                        this.promotionItems = data.data;
                    } else if (data && data.success === false) {
                        this.promotionItems = [];
                        this.$toast.error(data.message || 'No se pudo recuperar la promoción');
                        pass = false;
                    } else {
                        // fallback: try to use data as array
                        this.promotionItems = Array.isArray(data) ? data : [];
                    }
                    // initialize quantity_to_add to 0 for each item to ensure inputs start at 0
                    if (Array.isArray(this.promotionItems)) {
                        this.promotionItems = this.promotionItems.map(it => Object.assign({}, it, { quantity_to_add: Number(it.quantity_to_add) || 0 }));
                    }
                }
            } catch (e) {
                this.$toast.error('Error al obtener los productos de la promoción');
                this.promotionItems = [];
                pass = false;
            }

            return pass;
        },
        getMaxForRow(row) {
            const perRow = row && (row.max_quantity || row.maxQuantity);
            const promoLevel = this.selectedFood && (this.selectedFood.max_quantity || this.selectedFood.maxQuantity);
            const fallback = 999;
            const val = perRow || promoLevel || fallback;
            return Math.max(0, Number(val));
        },

        onQuantityChange(row, index) {
            const promoMax = this.selectedFood && (this.selectedFood.max_quantity || this.selectedFood.maxQuantity);
            const firstRowMax = (this.promotionItems && this.promotionItems.length && (this.promotionItems[0].max_quantity || this.promotionItems[0].maxQuantity)) || null;
            const maxQuantity = promoMax || firstRowMax || null;
            if (!maxQuantity) return;

            const totalOther = this.promotionItems.reduce((sum, it, idx) => {
                if (idx === index) return sum;
                return sum + (Number(it.quantity_to_add) || 0);
            }, 0);

            const allowedForThis = Math.max(0, Number(maxQuantity) - totalOther);
            const current = Number(row.quantity_to_add) || 0;
            if (current > allowedForThis) {
                this.$toast.error(`Solo quedan ${allowedForThis} artículo(s) disponibles en la promoción.`);
                this.$set(this.promotionItems, index, Object.assign({}, this.promotionItems[index], { quantity_to_add: allowedForThis }));
            }
        },

        handleSave() {
            const itemsToAdd = this.promotionItems
                .filter(item => item.quantity_to_add && item.quantity_to_add > 0)
                .map(item => ({
                    promotion_id: item.promotion_id || item.promotionId || null,
                    promotion_item_id: item.promotion_item_id || item.promotionItemId || item.id || null,
                    quantity: Number(item.quantity_to_add),
                    description: item.description || (this.selectedFood && this.selectedFood.description) || null,
                }));

            // validate against global max_quantity
            const promoMax = this.selectedFood && (this.selectedFood.max_quantity || this.selectedFood.maxQuantity);
            const firstRowMax = (this.promotionItems && this.promotionItems.length && (this.promotionItems[0].max_quantity || this.promotionItems[0].maxQuantity)) || null;
            const maxQuantity = promoMax || firstRowMax || null;
            if (maxQuantity) {
                const totalRequested = itemsToAdd.reduce((s, it) => s + (Number(it.quantity) || 0), 0);
                if (totalRequested > Number(maxQuantity)) {
                    this.$toast.error(`La promoción permite un máximo de ${maxQuantity} artículo(s). Seleccionaste ${totalRequested}.`);
                    return;
                }
            }

            const promotionIdFromParent = this.selectedFood && (this.selectedFood.promotion_id || this.selectedFood.promotionId || null);
            if (promotionIdFromParent) {
                itemsToAdd.forEach(it => {
                    if (!it.promotion_id) it.promotion_id = promotionIdFromParent;
                });
            }

            this.$emit('addPromotionItems', itemsToAdd);
            this.closeDialog();
        },
    },
    watch: {
        async showDialog(newVal) {
            if (newVal) {
                try {
                    console.log('ItemsPromotions selectedFood (watch showDialog):', this.selectedFood);

                    let id = this.selectedItemId || (this.selectedFood && this.selectedFood.id);
                    if (!id) {
                        await new Promise(resolve => setTimeout(resolve, 100));
                        console.log('Retrying selectedItemId/selectedFood after short delay:', { selectedItemId: this.selectedItemId, selectedFood: this.selectedFood });
                        id = this.selectedItemId || (this.selectedFood && this.selectedFood.id);
                    }

                    if (!id) {
                        console.warn('ItemsPromotions: no item id available to check promotions');
                        return;
                    }

                    await this.setItemCheckPromotions(id);
                } catch (e) {
                    console.error('Error checking item promotions', e);
                }
            }
        }
    },
    mounted() {
        console.log('ItemsPromotions mounted, selectedFood:', this.selectedFood);
    },
};
</script>
<style scoped>
.items-promotions-dialog {
    /* allow dialog to shrink on small screens */
    max-width: 95vw !important;
    width: auto !important;
}

.items-promotions-dialog .el-dialog__body {
    padding: 12px !important;
}

.items-promotions-dialog .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.items-promotions-dialog table {
    width: 100%;
    table-layout: auto; /* allow columns to size to content so they don't become extremely narrow */
    border-collapse: collapse;
}

.items-promotions-dialog th,
.items-promotions-dialog td {
    /* allow wrapping at spaces, avoid breaking single words into characters */
    white-space: normal !important;
    word-break: normal !important;
    /* ensure text flows horizontally (override any global writing-mode/text-orientation) */
    writing-mode: horizontal-tb !important;
    text-orientation: mixed !important;
    overflow-wrap: break-word !important;
    padding: 6px 8px !important;
    vertical-align: middle !important;
}

.items-promotions-dialog tbody tr td:last-child {
    /* make input column at least wide enough on small screens */
    min-width: 80px;
}

/* Reduce font-size slightly on narrow screens for improved fit */
@media (max-width: 480px) {
    .items-promotions-dialog table,
    .items-promotions-dialog th,
    .items-promotions-dialog td {
        font-size: 13px;
    }
    .items-promotions-dialog .el-dialog__body {
        padding: 8px !important;
    }
}

/* Ensure inputs/tags aren't squashed */
.items-promotions-dialog .el-tag,
.items-promotions-dialog .el-input-number {
    display: inline-block;
    max-width: 100%;
}
</style>