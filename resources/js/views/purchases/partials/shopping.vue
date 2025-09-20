<!-- Ver Compra (solo lectura, con filtros) -->

<template>
    <el-dialog :visible="localShowDialog" width="70%" top="6vh" custom-class="pro-products-dialog"
        :close-on-click-modal="false" :close-on-press-escape="true"
        @close="closeDialog">
        <template #title>
            <div class="d-flex align-items-center">
                <i class="fas fa-shopping-cart"></i>
                <span style="margin-left: 10px; font-size: 1.5rem; font-weight: bold;">Ver Compra</span>
            </div>
        </template>
        <div class="tab-content p-3">
            <!-- Filtros de búsqueda -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <el-input v-model="search" placeholder="Buscar por descripción o código interno..." clearable />
                </div>
            </div>
            <!-- Tabla de productos -->
            <div class="row" v-if="filteredItems.length > 0">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white">#</th>
                                    <th class="text-white">Código Interno</th>
                                    <th class="text-white">Producto</th>
                                    <th class="text-white">Almacén</th>
                                    <th class="text-white text-center">Cantidad</th>
                                    <th class="text-white text-center" v-if="configuration.series_enabled && hasLots.length > 0">Series</th>
                                    <th class="text-white text-center" v-if="configuration.color_size_enabled && hasColorSize.length > 0">Talla color</th>
                                    <th class="text-white text-center" v-if="configuration.lots_enabled && hasLotsGroup.length > 0">Lote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in paginatedItems" :key="index">
                                    <td>{{ (currentPage - 1) * pageSize + index + 1 }}</td>
                                    <td>{{ row.internal_id || '-' }}</td>
                                    <td>
                                        <span v-if="row.name_product_pdf" v-html="row.name_product_pdf"></span>
                                        <span v-else>{{ row.description }}</span>
                                    </td>
                                    <td>{{ row.warehouse || '-' }}</td>
                                    <td class="text-center">
                                        <span style="background:#e3f2fd; border-radius:4px; padding:2px 8px; font-weight:500;">
                                            {{ calculate(row) }}
                                        </span>
                                    </td>
                                    <!-- Series -->
                                    <td class="text-center" v-if="configuration.series_enabled && row.lots && row.lots.length > 0">
                                        <span v-if="row.lots && row.lots.length">
                                            <table class="table table-bordered table-sm mb-0" style="background: transparent;">
                                                <thead>
                                                    <tr><th>Serie</th></tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(lot, idx) in row.lots" :key="idx">
                                                        <td>{{ lot.series }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <!-- Talla color -->
                                    <td class="text-center" v-if="configuration.color_size_enabled && row.color_size && row.color_size.length > 0">
                                        <span v-if="row.color_size && row.color_size.length">
                                            <table class="table table-bordered table-sm mb-0" style="background: transparent;">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Talla</th>
                                                        <th>Color</th>
                                                        <th>Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(color, idx) in row.color_size" :key="idx">
                                                        <td>{{ color.code }}</td>
                                                        <td>{{ color.size }}</td>
                                                        <td>{{ color.color }}</td>
                                                        <td>{{ color.stock }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <!-- Lote -->
                                    <td class="text-center" v-if="configuration.lots_enabled && row.lots_group && row.lots_group.length > 0"> 
                                        <span v-if="row.lots_group && row.lots_group.length">
                                            <table class="table table-bordered table-sm mb-0" style="background: transparent;">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Fecha de Vencimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(lot, idx) in row.lots_group" :key="idx">
                                                        <td>{{ lot.code }}</td>
                                                        <td>{{ lot.date_of_due }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div style="margin: 16px 0; text-align: right;">
                        <el-pagination background layout="prev, pager, next" :page-size="pageSize"
                            :total="filteredItems.length" :current-page.sync="currentPage"
                            @current-change="handlePageChange" small>
                        </el-pagination>
                    </div>
                </div>
            </div>
            <div v-else class="text-center text-muted">No hay productos para mostrar.</div>
            <div style="text-align: right; margin-top: 18px;">
                <el-button class="btn_guardarsmall" @click="closeDialog" type="primary"
                    size="medium">Cerrar</el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: {
        configuration: {
            type: Object,
            default: () => ({})
        },
        items: {
            type: Array,
            default: () => []
        },
        showDialog: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            search: '',
            currentPage: 1,
            pageSize: 10,
            localShowDialog: this.showDialog
        };
    },
    watch: {
        showDialog(val) {
            this.localShowDialog = val;
        },
        localShowDialog(val) {
            if (!val) {
                this.$emit('update:showDialog', false);
            }
        }
    },
    computed: {

        hasLots() {
            return this.filteredItems.some(item => item.lots && item.lots.length > 0);
        },
        hasColorSize() {
            return this.filteredItems.some(item => item.color_size && item.color_size.length > 0);
        },
        hasLotsGroup() {
            return this.filteredItems.some(item => item.lots_group && item.lots_group.length > 0);
        },

        filteredItems() {
            if (!this.search) return this.items;
            const s = this.search.toLowerCase();
            return this.items.filter(item => {
                return (
                    (item.description && item.description.toLowerCase().includes(s)) ||
                    (item.internal_id && item.internal_id.toLowerCase().includes(s)) || 
                    (item.warehouse && item.warehouse.toLowerCase().includes(s))
                );
            });
        },
        paginatedItems() {
            const start = (this.currentPage - 1) * this.pageSize;
            return this.filteredItems.slice(start, start + this.pageSize);
        }
    },
    methods: {
        handlePageChange(page) {
            this.currentPage = page;
        },
        closeDialog() {
            this.localShowDialog = false;
        },
        calculate(item) {
            let { quantity, unit_type_id, max_quantity, max_quantity_description } = item;
            if (!max_quantity && !max_quantity_description) {
                return quantity;
            }
            let general = Math.trunc(quantity / max_quantity);
            let part = ((quantity / max_quantity) % 1).toFixed(2);
            let text = `${general} ${unit_type_id}`;
            if (part != 0) {
                let part = (quantity / max_quantity) % 1;
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${unit_type_id}`;
                }
            } else {
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                }
            }
            return text;
        }
    }
};
</script>

<style scoped>
.table-striped tr:nth-child(even) {
    background-color: #f2f2f2;
}

.bg-primary {
    background-color: #073f68 !important;
}

.text-white {
    color: #fff !important;
}
</style>
