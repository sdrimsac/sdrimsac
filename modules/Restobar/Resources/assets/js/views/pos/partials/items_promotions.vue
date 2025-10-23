<template>
    <el-dialog :visible="showDialog" width="900px" :close-on-click-modal="false" :show-close="false" :title="'Productos de la Promoción' + (selectedFood ? ' - ' + selectedFood.description : '')"
        custom-class="items-promotions-dialog" @update:visible="$emit('update:showDialog', $event)"
        @close="closeDialog">
        <div class="card">
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Código</th>
                            <th style="text-align: left;">Descripción</th>
                            <th style="text-align: right;">Req.</th>
                            <th style="text-align: right;">Precio</th>
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
                            <td style="text-align: left;">{{ row.internal_id }}</td>
                            <td style="text-align: left;">{{ row.description }}</td>
                            <td style="text-align: right;">{{ row.quantity_required }}</td>
                            <td style="text-align: right;">{{ row.sale_unit_price }}</td>
                            <td style="text-align: right;">{{ row.stock_available }}</td>
                            <td style="text-align: right;">{{ row.difference }}</td>
                            <td style="text-align: center;">
                                <el-tag type="success" v-if="row.has_stock">Sí</el-tag>
                                <el-tag type="danger" v-else>No</el-tag>
                            </td>
                            <td>
                                <!-- <el-input v-model="row.quantity_to_add" placeholder="Cantidad a agregar"></el-input> -->
                                <el-input-number v-model="row.quantity_to_add" controls-position="right" :min="1.00"
                                    :max="999"></el-input-number>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="text-align: right; margin-top: 12px;">
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
                    // Controller now returns an array of promotion items
                    const data = response.data;
                    // If backend wraps success/message, try to normalize
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
                }
            } catch (e) {
                this.$toast.error('Error al obtener los productos de la promoción');
                this.promotionItems = [];
                pass = false;
            }

            return pass;
        },
        handleSave() {
            // Emit selected promotion items with promotion id, promotion item id and quantities to add
            // Expectation: each promotion item object may include a promotion_id and either an id or promotion_item_id
            const itemsToAdd = this.promotionItems
                .filter(item => item.quantity_to_add && item.quantity_to_add > 0)
                .map(item => ({
                    promotion_id: item.promotion_id || item.promotionId || null,
                    promotion_item_id: item.promotion_item_id || item.promotionItemId || item.id || null,
                    quantity: item.quantity_to_add,
                    // include the item description; fall back to selectedFood.description if missing
                    description: item.description || (this.selectedFood && this.selectedFood.description) || null,
                }));

            // If there's a single promotion id for the whole dialog (e.g. from selectedFood), prefer that
            // Only accept explicit promotion id fields from the selectedFood object.
            // Do NOT use selectedFood.id — that's the item's id, not the promotion id.
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
        // When the dialog is opened, check promotions for the selected food
        async showDialog(newVal) {
            if (newVal) {
                try {
                    // Debug: log selectedFood so developer can see what arrives
                    console.log('ItemsPromotions selectedFood (watch showDialog):', this.selectedFood);

                    // Prefer explicit primitive id prop (less subject to reactivity race conditions)
                    let id = this.selectedItemId || (this.selectedFood && this.selectedFood.id);
                    if (!id) {
                        // wait a short time to allow the parent to propagate the prop/object
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
                    // optional: report error
                    console.error('Error checking item promotions', e);
                }
            }
        }
    },
    mounted() {
        // Extra debug: log on mount in case prop is already set
        console.log('ItemsPromotions mounted, selectedFood:', this.selectedFood);
    },
};
</script>