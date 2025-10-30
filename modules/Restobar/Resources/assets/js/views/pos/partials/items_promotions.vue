<!-- Productos de la promoción Nuevo restobar - CAJA -->
<template>
    <el-dialog :visible="showDialog" width="50%" :close-on-click-modal="false" :show-close="false"
        :title="'Productos de la Promoción ' + (selectedFood ? ' - ' + selectedFood.description : '')"
        custom-class="items-promotions-dialog" @update:visible="$emit('update:showDialog', $event)"
        @close="closeDialog">

        <div style="display: flex; justify-content: space-between; align-items:center; gap: 8px;">
            <div v-if="promoMaxQuantity" style="font-size:1.25em;color:#444;display:flex;align-items:center;gap:8px;">
                <strong style="font-size:1.15em;">Capacidad restante:</strong> {{ remainingCapacity }} / {{ promoMaxQuantity }}
            </div>
            <div style="display:flex; gap:8px; align-items:center; margin-left:auto;">
                <el-button class="btn_cancelarsmall" type="danger" @click="closeDialog">Cerrar</el-button>
                <el-button class="btn_guardarsmall" type="primary" @click="handleSave">Agregar</el-button>
            </div>
        </div>

        <!-- Buscador / filtro interactivo -->
        <div class="mt-2" style="display:flex; gap:8px; align-items:center;">
            <el-input v-model="searchTerm" placeholder="Buscar producto" clearable
                style="width:60%;">
                <template #prefix>
                    <i class="el-icon-search"></i>
                </template>
            </el-input>
            <div style="flex:1"></div>
        </div>

        <!-- Lista de productos seleccionados (resumen) -->
        <div v-if="selectedItems.length" class="mt-2"
            style="border:1px solid #eaeaea;padding:8px;border-radius:4px;background:#fafafa;">
            <strong>Productos seleccionados</strong>
            <table class="table table-sm" style="margin-top:8px;">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th style="text-align:right;">Cantidad</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(it, idx) in selectedItems" :key="'sel-' + idx">
                        <td>
                            <small style="color:#666">{{ it.internal_id }}</small><br />
                            <strong>{{ it.description }}</strong>
                        </td>
                        <td style="text-align:right; width:160px;">
                            <el-input-number v-model="it.quantity_to_add" :min="0" :max="getMaxForRow(it)" :step="1"
                                controls-position="right"></el-input-number>
                        </td>
                        <td style="text-align:center; width:110px;">
                            <el-button type="danger" size="mini" @click="removeSelected(it)">
                                <i class="el-icon-delete"></i>
                            </el-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class=" mt-2">
            <div>
                <table class="table table-striped">
                    <thead>
                        <tr style="background-color: #073f68; color: #fff;">
                            <th></th>
                            <th style="text-align: left; color: #fff !important;">Producto</th>
                            <!-- <th style="text-align: right; color: #fff !important;">Stock</th>
                            <th style="text-align: right; color: #fff !important;">Falta</th> -->
                            <th style="text-align: center; color: #fff !important;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="promotionItems.length === 0">
                            <td colspan="7" class="text-center">No hay productos en la promoción</td>
                        </tr>
                        <tr v-for="(row, index) in filteredItems" :key="index"
                            :style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }">
                            <td style="text-align: center;">
                                <el-tag v-if="row.has_stock" effect="dark"
                                    style="background-color:#1b5e20;color:#fff;border-color:#1b5e20;padding:4px 8px;">
                                    <i class="el-icon-check" style="color:#fff;font-size:14px;"></i>
                                </el-tag>
                                <el-tag v-else effect="dark"
                                    style="background-color:#c62828;color:#fff;border-color:#c62828;padding:4px 8px;">
                                    <i class="el-icon-close" style="color:#fff;font-size:14px;"></i>
                                </el-tag>
                            </td>
                            <td style="text-align: left;">
                                <small style="color: #666;">{{ row.internal_id }}</small><br />
                                <strong style="font-size:1.1em;">{{ row.description }}</strong>
                            </td>
                            <td>
                                <!-- <el-input v-model="row.quantity_to_add" placeholder="Cantidad a agregar"></el-input> -->
                                <el-input-number v-model="row.quantity_to_add" controls-position="right" :min="0"
                                    :max="getMaxForRow(row)" :step="1"></el-input-number>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            // texto para filtrar en tiempo real
            searchTerm: '',
        };
    },
    methods: {
        closeDialog() {
            this.$emit("update:showDialog", false);
        },
        removeSelected(item) {
            // Quitar la selección: dejar la cantidad en 0 para que no se incluya
            // Mejor hacer el $set sobre el objeto almacenado en promotionItems (índice)
            // y agregar un log breve para facilitar depuración en consola.
            console.log('removeSelected called with item:', item);
            if (!item) return;

            const idx = (this.promotionItems || []).indexOf(item);
            if (idx !== -1) {
                // Eliminar completamente del array de promotionItems para que desaparezca del resumen
                // Esto evita problemas de reactividad y hace la UX más clara.
                this.promotionItems.splice(idx, 1);
            } else {
                // Fallback: si por alguna razón la referencia no coincide, set sobre el objeto recibido
                this.$set(item, 'quantity_to_add', 0);
            }
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
                    // normalize quantity_to_add so sums don't break
                    (this.promotionItems || []).forEach(it => {
                        if (typeof it.quantity_to_add === 'undefined' || it.quantity_to_add === null) {
                            this.$set(it, 'quantity_to_add', 0);
                        }
                    });
                }
            } catch (e) {
                this.$toast.error('Error al obtener los productos de la promoción');
                this.promotionItems = [];
                pass = false;
            }

            return pass;
        },
        getMaxForRow(row) {
            // Determine per-row declared max (try multiple property names, include common misspelling)
            const perRow = row && (row.promo_max_quantity || row.promo_max_quantiy || row.max_quantity || row.maxQuantity);
            // Promotion-level max (normalized via computed)
            const promoLevel = this.promoMaxQuantity;
            const fallback = 999;
            const declaredMax = perRow || promoLevel || fallback;

            // If there's a promotion-level cap, compute remaining capacity excluding this row
            if (promoLevel) {
                const totalOther = (this.promotionItems || []).reduce((s, it) => s + (it === row ? 0 : (Number(it.quantity_to_add) || 0)), 0);
                const remaining = Number(promoLevel) - totalOther;
                const current = Number(row.quantity_to_add) || 0;

                if (remaining <= 0) {
                    // No capacity left. Allow current value (so user doesn't lose what's already set) or 0.
                    return Math.max(0, current);
                }

                // Allow at most the smaller of declared max and remaining capacity, but at least current
                const upper = Math.min(Number(declaredMax), remaining);
                return Math.max(0, Math.max(current, Number(upper)));
            }

            // No promotion-level cap; return declared max (allow 0 minimum)
            return Math.max(0, Number(declaredMax));
        },

        handleSave() {
            // Emit selected promotion items with promotion id, promotion item id and quantities to add
            const itemsToAdd = this.promotionItems
                .filter(item => item.quantity_to_add && item.quantity_to_add > 0)
                .map(item => ({
                    promotion_id: item.promotion_id || item.promotionId || null,
                    promotion_item_id: item.promotion_item_id || item.promotionItemId || item.id || null,
                    quantity: Number(item.quantity_to_add),
                    description: item.description || (this.selectedFood && this.selectedFood.description) || null,
                }));

            // Normalize promotion-level max (accept different property names and misspelling)
            const promoMax = this.promoMaxQuantity;
            const firstRowMax = (this.promotionItems && this.promotionItems.length && (this.promotionItems[0].promo_max_quantity || this.promotionItems[0].promo_max_quantiy || this.promotionItems[0].max_quantity || this.promotionItems[0].maxQuantity)) || null;
            const maxQuantity = promoMax || firstRowMax || null;

            const totalRequested = itemsToAdd.reduce((sum, it) => sum + (Number(it.quantity) || 0), 0);

            // No items selected -> show message
            if (totalRequested === 0) {
                this.$toast.error('Seleccione al menos un producto para agregar a la promoción.');
                return;
            }

            // If a maxQuantity exists, enforce exact completion: totalRequested must equal maxQuantity
            if (maxQuantity) {
                if (totalRequested > Number(maxQuantity)) {
                    this.$toast.error(`La promoción permite un máximo de ${maxQuantity} artículo(s). Seleccionaste ${totalRequested}.`);
                    return;
                }

                if (totalRequested < Number(maxQuantity)) {
                    const remaining = Number(maxQuantity) - totalRequested;
                    this.$toast.error(`Debe completar la promoción seleccionando ${remaining} artículo(s) más.`);
                    return;
                }
            }

            // If there's a single promotion id for the whole dialog (e.g. from selectedFood), prefer that
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
    computed: {
        // Promotion-level maximum quantity (normalized): prefer promo_max_quantity (or misspelled) then other common names
        promoMaxQuantity() {
            return (this.selectedFood && (this.selectedFood.promo_max_quantity || this.selectedFood.promo_max_quantiy || this.selectedFood.promoMaxQuantity || this.selectedFood.max_quantity || this.selectedFood.maxQuantity)) || null;
        },
        // total currently selected in the dialog (sum of quantity_to_add)
        totalSelected() {
            return (this.promotionItems || []).reduce((s, it) => s + (Number(it.quantity_to_add) || 0), 0);
        },
        // remaining capacity for the promotion (non-negative)
        remainingCapacity() {
            if (!this.promoMaxQuantity) return null;
            return Math.max(0, Number(this.promoMaxQuantity) - this.totalSelected);
        },
        // items filtrados por searchTerm (nombre o internal_id)
        filteredItems() {
            const term = (this.searchTerm || '').toString().trim().toLowerCase();
            if (!term) return this.promotionItems;
            return this.promotionItems.filter(it => {
                const desc = (it.description || '').toString().toLowerCase();
                const code = (it.internal_id || '').toString().toLowerCase();
                return desc.includes(term) || code.includes(term);
            });
        },
        // lista de items con cantidad > 0 para el resumen
        selectedItems() {
            return (this.promotionItems || []).filter(it => Number(it.quantity_to_add) > 0);
        }
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