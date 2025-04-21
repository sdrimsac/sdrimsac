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
                            :min="0.01"
                            :max="99999999"
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
                    <div
                        class="col-12 mt-2"
                        v-if="item.lots_enabled && item.lots_group.length > 0"
                    >
                        <a
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickLotGroup"
                            >[&#10004; Seleccionar lote]</a
                        >
                    </div>
                </template>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <div class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2">
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
                    :loading="loading_submit"
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

        <lots-group
            v-if="item"
            :quantity="form.quantity"
            :showDialog.sync="showDialogLots"
            :lotsGroup="item.lots_group"
            @addRowLotGroup="addRowLotGroup"
        >
        </lots-group>
    </el-dialog>
</template>

<script>
import itemForm from "../items/form.vue";
import LotsGroup from "../documents/partials/lots_group.vue";

export default {
    components: { itemForm, LotsGroup },
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
            item: null,
            loading_search: false,
            unit_types: [],
            all_unit_types: [],
            unit_type_selected: null,
            unit_type_description:"",
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
        getUnitTypes() {
            this.$http("/unit_types/records").then(response => {
                this.all_unit_types = response.data.data;
            });
        },
        clickCommand(type) {
            this.unit_type_selected = type;
            this.unit_type_description = this.all_unit_types.find(ut => ut.id == type.unit_type_id)?.description || "";
            // this.form.price_type = command;
        },
        clickLotGroup() {
            this.showDialogLots = true;
        },
        onChangeItem() {
            this.form.IdLoteSelected = null;
            this.item = this.items.find(it => it.id == this.form.item);
            this.unit_types = this.item.item_unit_types || [];
            this.unit_type_description = this.all_unit_types.find(ut => ut.id == this.item.unit_type_id)?.description || "";
            // console.log("🚀 ~ onChangeItem ~ this.item:", this.item)
        },
        addRowLotGroup(id) {
            this.form.IdLoteSelected = id;
        },
        create() {
            this.$http.post(`/${this.resource}/tables`).then(response => {
                this.items = response.data.items;
                this.all_items = this.items;
            });

            this.form = {};
        },
        close() {
            this.$emit("update:dialogVisible", false);
        },
        clickAddItem() {
            this.errors = {};

            if (this.item.lots_enabled) {
                if (!this.form.IdLoteSelected)
                    return this.$message.error("Debe seleccionar un lote.");
            }

            if (this.form.item != null && this.form.quantity != null) {
                this.form.quantity = Math.abs(this.form.quantity);
                if (isNaN(this.form.quantity)) this.form.quantity = 0;
                const item = this.items.find(item => item.id == this.form.item);
                let quantity = this.form.quantity;
                if (this.unit_type_selected) {
                    item.unit_type_id = this.unit_type_selected.unit_type_id;
                    item.presentation = this.unit_type_selected.description;
                }
                console.log("🚀 ~ clickAddItem ~ item:", item);
                item.IdLoteSelected = this.form.IdLoteSelected;
                this.$emit("addItem", {
                    item,
                    quantity,
                });

                this.form = {};
                this.item = null;
                this.unit_type_selected = null;
                this.unit_types = [];
                this.unit_type_description = "";
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
