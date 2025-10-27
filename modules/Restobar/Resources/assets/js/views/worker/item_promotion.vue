<!-- Productos de la promoción Nuevo restobar - CAJA -->
<template>
    <el-dialog :visible="showDialog" width="50%" :close-on-click-modal="false" :show-close="false"
        :title="'Productos de la Promoción ' + (selectedFood ? ' - ' + selectedFood.description : '')"
        custom-class="items-promotions-dialog" @update:visible="$emit('update:showDialog', $event)"
        @close="closeDialog">

        <div style="display: flex; justify-content: space-between; align-items:center; gap: 8px;">
            <div v-if="promoMaxQuantity" style="font-size:1.25em;color:#444;display:flex;align-items:center;gap:8px;">
                <strong style="font-size:1.15em;">Rest:</strong> {{ remainingCapacity }} / {{ promoMaxQuantity }}
            </div>
            <div style="display:flex; gap:8px; align-items:center; margin-left:auto;">
                <el-button class="btn_cancelarsmall" type="danger" @click="closeDialog">Cerrar</el-button>
                <el-button class="btn_guardarsmall" type="primary" @click="handleSave">Agregar</el-button>
            </div>
        </div>

        <!-- Buscador / filtro interactivo -->
        <div class="mt-2 search-wrapper" style="display:flex; gap:8px; align-items:center;">
            <el-input v-model="searchTerm" placeholder="Buscar producto por nombre o código" clearable
                class="responsive-input">
                <template #prefix>
                    <i class="el-icon-search"></i>
                </template>
            </el-input>
            <div style="flex:1"></div>
        </div>

        <!-- Lista de productos seleccionados (resumen) -->
        <div v-if="selectedItems.length" class="mt-2 selected-items-wrapper"
            style="border:1px solid #eaeaea;padding:8px;border-radius:4px;background:#fafafa;">
            <strong>Productos seleccionados</strong>
            <div class="table-responsive" style="margin-top:8px;">
                <table class="table table-sm selected-items-table">
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
                            <td class="quantity-cell" style="text-align:right;">
                                <el-input-number v-model="it.quantity_to_add" :min="0" :max="getMaxForRow(it)" :step="1"
                                    controls-position="right"></el-input-number>
                            </td>
                            <td class="action-cell" style="text-align:center;">
                                <el-button type="danger" size="mini" @click="removeSelected(it)">
                                    <i class="el-icon-delete"></i>
                                </el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class=" mt-2">
            <div>
                <div class="table-responsive">
                    <table class="table table-striped main-items-table">
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
                                <td class="quantity-cell">
                                    <!-- <el-input v-model="row.quantity_to_add" placeholder="Cantidad a agregar"></el-input> -->
                                    <el-input-number v-model="row.quantity_to_add" controls-position="right" :min="0"
                                        :max="getMaxForRow(row)" :step="1"></el-input-number>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            // Quitar la selección: dejar la cantidad en 0/undefined para que no se incluya
            if (!item) return;
            this.$set(item, 'quantity_to_add', 0);
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
            // Expectation: each promotion item object may include a promotion_id and either an id or promotion_item_id
            const itemsToAdd = this.promotionItems
                .filter(item => item.quantity_to_add && item.quantity_to_add > 0)
                .map(item => ({
                    promotion_id: item.promotion_id || item.promotionId || null,
                    promotion_item_id: item.promotion_item_id || item.promotionItemId || item.id || null,
                    quantity: Number(item.quantity_to_add),
                    // include the item description; fall back to selectedFood.description if missing
                    description: item.description || (this.selectedFood && this.selectedFood.description) || null,
                }));

            // Determine global max_quantity (promotion-level). Assumption: the promotion's max_quantity is provided
            // either on the selectedFood prop or on each promotion item. We prefer the promotion-level value.
            // Normalize promotion-level max (accept different property names and misspelling)
            const promoMax = this.promoMaxQuantity;
            const firstRowMax = (this.promotionItems && this.promotionItems.length && (this.promotionItems[0].promo_max_quantity || this.promotionItems[0].promo_max_quantiy || this.promotionItems[0].max_quantity || this.promotionItems[0].maxQuantity)) || null;
            const maxQuantity = promoMax || firstRowMax || null;

            // If a maxQuantity exists, validate the total requested does not exceed it
            if (maxQuantity) {
                const totalRequested = itemsToAdd.reduce((sum, it) => sum + (Number(it.quantity) || 0), 0);
                if (totalRequested > Number(maxQuantity)) {
                    this.$toast.error(`La promoción permite un máximo de ${maxQuantity} artículo(s). Seleccionaste ${totalRequested}.`);
                    return;
                }
            }

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

<style scoped>
/* Responsive adjustments for the promotions dialog */
.items-promotions-dialog .responsive-input {
    width: 40%;
    min-width: 140px;
}

.items-promotions-dialog .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.items-promotions-dialog .selected-items-table th,
.items-promotions-dialog .selected-items-table td,
.items-promotions-dialog .main-items-table th,
.items-promotions-dialog .main-items-table td {
    white-space: nowrap;
}

.items-promotions-dialog .quantity-cell,
.items-promotions-dialog .action-cell {
    min-width: 80px;
}

@media (max-width: 768px) {
    /* Make dialog nearly full width on small screens */
    .items-promotions-dialog {
        width: 95% !important;
        left: 2.5% !important;
        right: 2.5% !important;
        margin: 0 auto !important;
    }

    .items-promotions-dialog .responsive-input {
        width: 100% !important;
    }

    .items-promotions-dialog .search-wrapper {
        flex-direction: column;
        align-items: stretch;
    }

    /* Allow tables to scroll horizontally instead of squeezing content */
    .items-promotions-dialog .table-responsive {
        overflow-x: auto;
    }

    /* Allow table cells to wrap and avoid overflow/distortion */
    .items-promotions-dialog .selected-items-table th,
    .items-promotions-dialog .selected-items-table td,
    .items-promotions-dialog .main-items-table th,
    .items-promotions-dialog .main-items-table td {
        white-space: normal;
        word-break: break-word;
    }

    .items-promotions-dialog .quantity-cell,
    .items-promotions-dialog .action-cell {
        width: auto !important;
    }

    .items-promotions-dialog .el-dialog__body {
        padding: 8px !important;
    }
}

/* Convert tables into stacked cards on small devices for better aesthetics */
@media (max-width: 480px) {
    .items-promotions-dialog .main-items-table,
    .items-promotions-dialog .selected-items-table {
        width: 100%;
        border-collapse: separate;
    }

    /* hide the table headers on very small screens */
    .items-promotions-dialog .main-items-table thead,
    .items-promotions-dialog .selected-items-table thead {
        display: none;
    }

    /* make each row a card - use flex for main table so icon+description sit in one line */
    .items-promotions-dialog .main-items-table tbody tr,
    .items-promotions-dialog .selected-items-table tbody tr {
        display: block;
        background: #fff;
        border: 1px solid #e9e9e9;
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 1px 0 rgba(0,0,0,0.03);
    }

    /* For the main items table, use a flex layout so the green icon and description share the same row */
    .items-promotions-dialog .main-items-table tbody tr {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .items-promotions-dialog .main-items-table tbody tr td {
        display: block;
        padding: 4px 0;
        white-space: normal;
    }

    .items-promotions-dialog .main-items-table tbody tr td:first-child {
        /* icon cell */
        flex: 0 0 auto;
        margin-right: 6px;
    }

    .items-promotions-dialog .main-items-table tbody tr td:nth-child(2) {
        /* description */
        flex: 1 1 auto;
        min-width: 0; /* allow flex shrink */
    }

    .items-promotions-dialog .main-items-table tbody tr .quantity-cell {
        /* put quantity control on its own line to avoid squeezing */
        flex: 0 0 100%;
        margin-top: 8px;
    }

    /* Selected-items keep stacked card appearance (single-column) */
    .items-promotions-dialog .selected-items-table tbody tr td {
        display: block;
        width: 100%;
        text-align: left !important;
        padding: 4px 0;
    }

    /* move the delete/action button to the top-right of the selected item card */
    .items-promotions-dialog .selected-items-table tbody tr {
        position: relative;
        padding-top: 10px; /* space for the absolute action button */
    }

    .items-promotions-dialog .selected-items-table .action-cell {
        position: absolute;
        top: 8px;
        right: 8px;
        width: auto;
        text-align: right !important;
    }

    .items-promotions-dialog .selected-items-table .action-cell .el-button {
        padding: 6px 8px;
    }

    /* ensure the search input stays on top and is clickable (avoid accidental overlays) */
    .items-promotions-dialog .search-wrapper {
        position: relative;
        z-index: 10010;
        pointer-events: auto;
    }

    .items-promotions-dialog .responsive-input,
    .items-promotions-dialog .responsive-input .el-input__inner {
        position: relative;
        z-index: 10020;
        pointer-events: auto;
    }

    /* keep table containers below the search input stacking-wise */
    .items-promotions-dialog .table-responsive {
        position: relative;
        z-index: 1;
    }

    .items-promotions-dialog .main-items-table tbody tr .el-input-number,
    .items-promotions-dialog .selected-items-table tbody tr .el-input-number {
        min-width: 80px;
    }

    /* Reduce header/title sizes to fit mobile */
    .items-promotions-dialog .el-dialog__header {
        padding: 12px 16px;
        font-size: 1rem;
    }

    .items-promotions-dialog strong {
        font-size: 0.95rem;
    }
}
</style>