<template>
    <el-dialog
        :title="`Seleccionar `"
        :visible.sync="showDialog"
        width="70%"
        :close-on-click-modal="false"
        :before-close="handleClose"
    >
        <div>
            <div class="row">
                <div class="col-6" v-for="comp in components" :key="comp.id">
                    <h5>{{ comp.name }}</h5>

                    <!-- SERIES (Tabla) -->
                    <div v-if="comp.series && comp.series.length">
                        <label class="mt-2 d-block"
                            ><strong>Series</strong></label
                        >
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Serie</th>
                                    <th>Fecha</th>
                                    <th>Almacén</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="series in normalizedSeries(comp)"
                                    :key="series._seriesId"
                                >
                                    <td>{{ series.series }}</td>
                                    <td>{{ formatDate(series.date) }}</td>
                                    <td>{{ series.warehouse_id }}</td>
                                    <td>
                                        <el-checkbox
                                            v-model="series.has_sale"
                                        ></el-checkbox>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- COLOR / TALLA VARIANTES (Tabla) -->
                    <div v-if="comp.color_size && comp.color_size.length">
                        <label class="mt-3 d-block"
                            ><strong>Color / Talla</strong></label
                        >
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Color</th>
                                    <th>Talla</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Código</th>
                                    <th>Ingrese Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="variant in normalizedColorSize(comp)"
                                    :key="variant._variantId"
                                    :class="
                                        variant._variantId ===
                                        comp.selectedVariantId
                                            ? 'table-primary'
                                            : ''
                                    "
                                >
                                    <td>{{ variant.color }}</td>
                                    <td>{{ variant.size }}</td>
                                    <td>
                                        {{ Number(variant.stock).toFixed(2) }}
                                    </td>
                                    <td>
                                        {{ Number(variant.price).toFixed(2) }}
                                    </td>
                                    <td>{{ variant.code }}</td>
                                    <td>
                                        <el-input-number
                                            v-model="variant.selectedQuantity"
                                            controls-position="right"
                                            :min="0.0"
                                            :max="999999"
                                        ></el-input-number>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="comp.lots_group && comp.lots_group.length">
                        <label class="mt-3 d-block"
                            ><strong>Lotes</strong></label
                        >
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Lote</th>
                                    <th>Fecha</th>
                                    <th>Stock</th>
                                    <th>Seleccione Lote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="variant in normalizedLots(comp)"
                                    :key="variant._lotId"
                                    :class="
                                        variant._lotId === comp.selectedLotId
                                            ? 'table-primary'
                                            : ''
                                    "
                                >
                                    <td>{{ variant.code }}</td>
                                    <td>{{ variant.date_of_due }}</td>
                                    <td>
                                        {{
                                            Number(variant.quantity).toFixed(2)
                                        }}
                                    </td>
                                    <td>
                                        <el-checkbox
                                            :disabled="variant.quantity < 1"
                                            v-model="variant.checked"
                                            @change="
                                                changeSelect(
                                                    index,
                                                    variant.id,
                                                    variant.quantity
                                                )
                                            "
                                        ></el-checkbox>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="handleClose">Cancelar</el-button>
            <el-button type="primary" @click="confirmSelection"
                >Agregar</el-button
            >
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "item", "components"],

    methods: {
        changeSelect(index, id, quantity_lot) {
            if (this.quantity > quantity_lot) {
                this.lots_group[index].checked = false;
            } else {
                this.lots_group.forEach(row => {
                    row.checked = false;
                });

                this.lots_group[index].checked = true;

                this.idSelected = id;
            }
        },

        handleClose(done) {
            this.$emit("update:showDialog", false);
            if (done) done();
        },
        confirmSelection() {

            const flattened = [];

            this.components.forEach(comp => {
                const itemId = comp.id || comp.item_id;

                // SERIES
                const selectedSeries = this.normalizedSeries(comp).filter(s => s.has_sale);
                selectedSeries.forEach(s => {
                    flattened.push({
                        item_id: itemId,
                        quantity: 1, // asumido 1 por serie
                        series_id: s._seriesId
                    });
                });

                // COLOR / TALLA
                const selectedVariants = this
                    .normalizedColorSize(comp)
                    .filter(v => Number(v.selectedQuantity) > 0);
                selectedVariants.forEach(v => {
                    flattened.push({
                        item_id: itemId,
                        quantity: Number(v.selectedQuantity),
                        color_size_id: v._variantId
                    });
                });

                // LOTES
                const lots = this.normalizedLots(comp);
                const selectedLot = lots.find(l => l.checked);
                if (selectedLot) {
                    flattened.push({
                        item_id: itemId,
                        quantity: 1, // cambiar si se requiere otra cantidad
                        lot_id: selectedLot._lotId
                    });
                }
            });

            const total_quantity = flattened.reduce((a, c) => a + (Number(c.quantity) || 0), 0);

            const payload = {
                item_id: this.item?.id ?? this.item?.item_id ?? null,
                item: this.item || null,
                components: flattened,
                total_quantity,
                // Se incluye opcionalmente el detalle antiguo para trazabilidad (puedes removerlo si no lo necesitas)
                _debug_previous_structure: undefined
            };

            this.$emit("addconfirm", payload);
            this.handleClose();
        },
        selectSeries(comp, row) {
            comp.selectedSeries = row._seriesId;
        },
        selectColor(comp, color) {
            comp.selectedColor = color;
        },
        selectSize(comp, size) {
            comp.selectedSize = size;
        },
        normalizedColorSize(comp) {
            
            if (!Array.isArray(comp.color_size)) return [];
            if (comp.color_size.length === 0) return [];

            if (typeof comp.color_size[0] === "object") {
                comp.color_size.forEach(v => {
                    if (v._variantId == null) {
                        this.$set(
                            v,
                            "_variantId",
                            v.id || `${v.color || ''}-${v.size || ''}`
                        );
                    }
                    if (v.selectedQuantity == null) {
                        this.$set(v, "selectedQuantity", 0);
                    } else if (typeof v.selectedQuantity !== "number") {
                        const parsed = Number(v.selectedQuantity);
                        this.$set(v, "selectedQuantity", isNaN(parsed) ? 0 : parsed);
                    }
                });
                return comp.color_size;
            }

            if (typeof comp.color_size[0] === "string") {
                comp.color_size = comp.color_size.map((c, idx) => ({
                    _variantId: idx,
                    color: c,
                    size: null,
                    stock: null,
                    price: null,
                    code: null,
                    selectedQuantity: 1
                }));
                return comp.color_size;
            }

            return [];
        },
        selectVariant(comp, row) {
            comp.selectedVariantId = row._variantId;
            comp.selectedColor = row.color;
            comp.selectedSize = row.size;
        },
        normalizedSeries(comp) {
            if (!Array.isArray(comp.series)) return [];
            if (comp.series.length === 0) return [];
            if (typeof comp.series[0] === "object") {
                comp.series.forEach(s => {
                    if (s._seriesId == null) {
                        this.$set(
                            s,
                            "_seriesId",
                            s.id || s.series || s.number || s.serie || s.code || ""
                        );
                    }
                    if (!s.series) {
                        this.$set(
                            s,
                            "series",
                            s.series || s.number || s.serie || s.code || ""
                        );
                    }
                    if (s.has_sale == null) {
                        this.$set(s, "has_sale", false);
                    }
                });
                return comp.series; // mismas referencias
            }
            // Legado: array de strings. Convertir una sola vez reemplazando en comp.series
            if (typeof comp.series[0] === "string") {
                comp.series = comp.series.map((val, idx) => ({
                    _seriesId: idx,
                    series: val,
                    date: null,
                    code_lots: null,
                    warehouse_id: null,
                    has_sale: false
                }));
                return comp.series;
            }
            return [];
        },

        normalizedLots(comp) {
            if (!Array.isArray(comp.lots_group)) return [];
            if (comp.lots_group.length === 0) return [];
            // Objetos: mantener referencias para que el checkbox (has_sale) sea reactivo y no se pierda
            if (typeof comp.lots_group[0] === "object") {
                comp.lots_group.forEach(s => {
                    if (s._lotId == null) s._lotId = s.id || s.lot || s.number;
                    // Normalizar alias de "series"
                    if (!s.lot)
                        s.lot = s.lot || s.number || s.serie || s.code || "";
                    if (s.has_sale == null) s.has_sale = false;
                });
                return comp.lots_group; // mismas referencias
            }
            // Legado: array de strings. Convertir una sola vez reemplazando en comp.lots_group
            if (typeof comp.lots_group[0] === "string") {
                comp.lots_group = comp.lots_group.map((val, idx) => ({
                    _lotId: idx,
                    quantity: null,
                    date_of_due: null,
                    warehouse_id: null,
                    code: null
                }));
                return comp.lots_group;
            }
            return [];
        },

        formatDate(value) {
            if (!value) return "";
            // Si ya viene en formato YYYY-MM-DD mostrarlo tal cual
            if (/^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
            try {
                const d = new Date(value);
                if (isNaN(d.getTime())) return value;
                const mm = String(d.getMonth() + 1).padStart(2, "0");
                const dd = String(d.getDate()).padStart(2, "0");
                return `${d.getFullYear()}-${mm}-${dd}`;
            } catch (e) {
                return value;
            }
        }
    }
};
</script>

<style scoped>
.option-table {
    margin-bottom: 8px;
}
</style>
