<!-- Agregar producto a la lista de productos de un despacho -->
<template>
    <el-dialog
        :title="titleDialog"
        :visible="dialogVisible"
        @open="create"
        append-to-body
        @close="close"
        top="8vh"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.items }"
                    >
                        <label class="control-label">
                            Producto
                            <!-- <a
                                href="#"
                                @click.prevent="showDialogNewItem = true"
                                >[+ Nuevo]</a
                            > -->
                        </label>
                        <el-select
                            v-model="form.item"
                            filterable
                            @change="onChangeItem"
                            remote
                            :remote-method="searchRemoteItems"
                            :loading="loading_search"
                        >
                            <el-option
                                v-for="option in items"
                                :key="option.id"
                                :value="option.id"
                                :label="option.full_description"
                            ></el-option>
                        </el-select>
                        <div v-if="unit_types && unit_types.length > 0">
                            <el-dropdown @command="clickCommand">
                                <span class="el-dropdown-link">
                                    Presentación
                                    <i
                                        class="el-icon-arrow-down el-icon--right"
                                    ></i>
                                </span>
                                <el-dropdown-menu slot="dropdown">
                                    <el-dropdown-item
                                        v-for="(type, idx) in unit_types"
                                        :key="idx"
                                        :command="type"
                                    >
                                        {{ type.description }}
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div
                        class="form-group"
                        :class="{ 'has-danger': errors.quantity }"
                    >
                        <label class="control-label w-100"
                            >Cantidad
                            <span class="text-primary">
                                [{{ unit_type_description }}]
                            </span>
                        </label>
                        <el-input-number
                            class="w-100"
                            v-model="form.quantity"
                            :precision="4"
                            :step="1"
                            :min="1"
                            :max="99999999"
                            :value="form.quantity === undefined ? 1 : form.quantity"
                            @change="val => form.quantity = val"
                        ></el-input-number>
                        <small
                            class="form-control-feedback"
                            v-if="errors.quantity"
                            v-text="errors.quantity[0]"
                        ></small>
                    </div>
                </div>

                <!-- Agregar Lote de producto -->
                <template v-if="item">
                    <div class="col-12 mt-2">
                        <el-button
                            class="bg-primary text-white"
                            v-if="
                                item.lots_enabled && item.lots_group.length > 0
                            "
                            @click.prevent="clickLotGroup"
                            >Seleccionar lote</el-button
                        >
                        <el-button
                            v-if="
                                item.series_enabled && item.lots.length > 0
                            "
                            class="bg-primary text-white"
                            @click.prevent="addRowLots"
                            >Seleccionar Series</el-button
                        >
                        <el-button
                            v-if="
                                item.has_color_size && item.color_size.length > 0
                            "
                            class="bg-primary text-white"
                            @click.prevent="addRowColorSize"
                            >Seleccionar Talla Color</el-button
                        >
                    </div>
                </template>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <!-- Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close"
                >
                    <span>Cancelar</span>
                </el-button>

                <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-plus-circle fa-lg"
                    type="primary"
                    native-type="submit"
                    @click="clickAddItem"
                >
                    <span>Guardar</span>
                </el-button>
            </div>
        </span>

        <item-form
            :showDialog.sync="showDialogNewItem"
            :external="true"
        ></item-form>
        <color-size
            v-if="item"
            :key="item ? 'color-size-' + item.id : 'color-size-none'"
            :showDialog.sync="showDialogColorSize"
            :stock="item.stock"
            :color_size="item.color_size"
            :recordId="item.id"
            @addRowSelectColor_size="addRowSelectColor_size"
        >
        </color-size>

        <series
            v-if="item"
            :showDialog.sync="showDialogSeries"
            :stock="item.stock"
            :recordId="item.id"
            :lots="item.lots"
            :itemWarehouseId="item.warehouse_id"
            @addRowSelectLot="addRowSelectLot"
        >
        </series>
        <lots-group
            v-if="item"
            :quantity="form.quantity"
            :showDialog.sync="showDialogLots"
            :lots_group="item.lots_group"
            @addRowLotGroup="addRowLotGroup"
        >
        </lots-group>
    </el-dialog>
</template>

<script>
import itemForm from "../items/form.vue";
import LotsGroup from "../documents/partials/lots_group.vue";
import Series from "../documents/partials/lots.vue";
import ColorSize from "../documents/partials/color.vue";

export default {
    components: { itemForm, LotsGroup, Series, ColorSize },
    props: ["dialogVisible"],
    data() {
        return {
            titleDialog: "Agregar Producto",
            showDialogNewItem: false,
            all_items: [],
            resource: "dispatches",
            errors: {},
            items: [],
            form: {},
            showDialogLots: false,
            showDialogColorSize: false,
            showDialogSeries: false,
            item: null,
            loading_search: false,
            unit_types: [],
            all_unit_types: [],
            unit_type_selected: null,
            unit_type_description: ""
        };
    },
    created() {
        this.getUnitTypes();
    },
    computed: {
        // getUnitType() {
        //     if (!this.item) return "";
        //     let { unit_type_id } = this.item;
        //     let unit_type = this.all_unit_types.find(
        //         ut => ut.id == unit_type_id
        //     );
        //     return unit_type ? unit_type.description : "";
        // }
    },
    methods: {
        // Series seleccionadas (cada serie equivale a 1 unidad en la cantidad)
        addRowSelectLot(series) {
            // 'series' ya llega filtrado desde el modal (solo las con has_sale)
            const seleccionadas = Array.isArray(series) ? series : [];

            // Ajustar cantidad a cantidad de series elegidas (mínimo 1)
            this.form.quantity = seleccionadas.length || 1;
            // Canonical: guardar en lots
            this.form.lots = seleccionadas.map(s => ({ ...s }));
            // Alias compatibilidad
            this.form.selected_series = this.form.lots;

            // Sincronizar el estado local del item (para que al clonar incluya flags de lots)
            if (this.item && Array.isArray(this.item.lots)) {
                // Marcar en lots cuáles fueron seleccionadas
                this.item.lots = this.item.lots.map(l => {
                    const found = seleccionadas.find(
                        s =>
                            (s.id && s.id === l.id) ||
                            (s.series === l.series && s.lot_code === l.lot_code)
                    );
                    return { ...l, has_sale: !!found };
                });
            }
        },

        getUnitTypes() {
            this.$http("/unit_types/records").then(response => {
                this.all_unit_types = response.data.data;
            });
        },
        clickCommand(type) {
            this.unit_type_selected = type;
            this.unit_type_description =
                this.all_unit_types.find(ut => ut.id == type.unit_type_id)
                    ?.description || "";
            // this.form.price_type = command;
        },
        clickLotGroup() {
            this.showDialogLots = true;
        },
        onChangeItem() {
            this.form.IdLoteSelected = null;
            this.form.IdColorSizeSelected = null;
            this.form.IdSeriesSelected = null;
            this.item = this.items.find(it => it.id == this.form.item);
            this.unit_types = this.item.item_unit_types || [];
            this.unit_type_description =
                this.all_unit_types.find(ut => ut.id == this.item.unit_type_id)
                    ?.description || "";
            // console.log("🚀 ~ onChangeItem ~ this.item:", this.item)
            // Limpiar selecciones anteriores para que no se mezclen entre items distintos
            this.form.lots = [];
            this.form.selected_series = [];
            this.form.selected_color_size = [];
        },
        addRowLotGroup(id) {
            console.log("que datos llega aqui", id);
            this.form.IdLoteSelected = id;
        },
        addRowLots() {
            this.showDialogSeries = true;
        },
        addRowColorSize() {

            this.showDialogColorSize = true;
        },
        addRowSelectColor_size(color_size){
            // Establecer cantidad como la suma total de todas las tallas/colores seleccionados
            console.log("ver que datos esta pasando:", color_size);
            if (Array.isArray(color_size)) {
                const seleccionados = color_size.filter(r => Number(r.selectedQuantity) > 0);
                if (seleccionados.length) {
                    const total = seleccionados.reduce((acc, r) => acc + Number(r.selectedQuantity || 0), 0);
                    this.form.quantity = total;
                    // Normalizar: convertir selectedQuantity -> quantity (lo que espera el backend)
                    const normalizados = seleccionados.map(({ selectedQuantity, ...rest }) => ({
                        ...rest,
                        quantity: Number(selectedQuantity)
                    }));
                    this.form.selected_color_size = normalizados; // detalle listo para enviar
                } else {
                    this.form.selected_color_size = [];
                }
            }
        },
        create() {
            this.$http.post(`/${this.resource}/tables`).then(response => {
                this.items = response.data.items;
                this.all_items = this.items;
            });
            // Mantener forma reactiva del objeto evitando reemplazar referencia completa
            this.form.item = null;
            this.form.quantity = 1;
            this.form.IdLoteSelected = null;
            this.form.selected_color_size = [];
            this.form.lots = [];
            this.form.selected_series = [];
        },
        close() {
            this.$emit("update:dialogVisible", false);
        },
        clickAddItem() {
            this.errors = {};

            if (this.item && this.item.lots_enabled) {
                if (!this.form.IdLoteSelected) {
                    return this.$message.error("Debe seleccionar un lote.");
                }
            }

            if (this.form.item != null && this.form.quantity != null) {
                // Normalizar cantidad
                this.form.quantity = Math.abs(this.form.quantity);
                if (isNaN(this.form.quantity)) this.form.quantity = 0;

                // Usar el estado actual del item (ya incluye flags de lots luego de seleccionar series)
                if (!this.item) return;
                const item = JSON.parse(JSON.stringify(this.item));

                // Aplicar selección de presentación si existe
                if (this.unit_type_selected) {
                    item.unit_type_id = this.unit_type_selected.unit_type_id;
                    item.presentation = this.unit_type_selected.description;
                }

                // Asociar lote seleccionado y selecciones adicionales
                item.IdLoteSelected = this.form.IdLoteSelected || null;

                // Series seleccionadas (si fueron cargadas desde modal series)
                if (item.series_enabled && Array.isArray(this.form.lots) && this.form.lots.length) {
                    const selectedLots = this.form.lots.map(s => ({ ...s }));
                    item.lots = selectedLots; // backend
                    item.selected_series = selectedLots; // compatibilidad
                    console.log("Series seleccionadas (lots) ->", item.lots);
                }

                if (Array.isArray(this.form.selected_color_size) && this.form.selected_color_size.length) {
                    // Ya vienen normalizados con 'quantity'. Clonar para no mutar referencia.
                    item.color_size = this.form.selected_color_size.map(cs => ({ ...cs }));
                }

                const quantity = this.form.quantity;
                console.log("🚀 ~ clickAddItem ~ item (cloned):", item);
                this.$emit("addItem", { item, quantity });

                // Cerrar diálogos antes de limpiar item para evitar parches conflictivos
                this.showDialogColorSize = false;
                this.showDialogSeries = false;
                this.showDialogLots = false;

                // Reset diferido para permitir que el patch anterior termine
                /* this.$nextTick(() => {
                    this.form.item = null;
                    this.form.quantity = 1;
                    this.form.IdLoteSelected = null;
                    this.form.selected_color_size = [];
                    this.form.selected_series = [];
                    this.item = null;
                    this.unit_type_selected = null;
                    this.unit_types = [];
                    this.unit_type_description = "";
                }); */
                return;
            }

            if (this.form.item == null)
                this.$set(this.errors, "items", ["Seleccione el producto"]);

            if (this.form.quantity == null)
                this.$set(this.errors, "quantity", ["Digite la cantidad"]);

            this.form.IdLoteSelected = null;
        },
        filterItems() {
            this.items = this.all_items;
        },
        async searchRemoteItems(input) {
            if (input.length > 2) {
                this.loading_search = true;
                const params = {
                    input: input,
                    search_by_barcode: this.search_item_by_barcode ? 1 : 0
                };
                await this.$http
                    .get(`/documents/search-items`, { params })
                    .then(response => {
                        this.items = response.data;
                        this.loading_search = false;
                        // this.enabledSearchItemsBarcode()
                        if (this.items.length == 0) {
                            this.filterItems();
                        }
                    });
            } else {
                await this.filterItems();
            }
        }
    }
};
</script>
