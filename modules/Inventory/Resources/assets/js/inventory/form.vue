<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        :close-on-click-modal="false"
        class="rounded-dialog"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <el-checkbox v-model="barcodeMode"
                                >¿Usar lector de código de barras?</el-checkbox
                            >
                        </div>
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.item_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-box"></i> Producto
                            </label>
                            <template v-if="!barcodeMode">
                                <el-select
                                    v-model="form.item_id"
                                    ref="itemSelect"
                                    class="w-100"
                                    filterable
                                    clearable
                                    remote
                                    :remote-method="searchRemoteItems"
                                    :loading="loading_search_item"
                                    @change="changeItem"
                                    placeholder=" busque por nombre/código"
                                >
                                    <el-option
                                        v-for="option in items"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="option.description"
                                    ></el-option>
                                </el-select>
                            </template>
                            <template v-else>
                                <el-input
                                    v-model="barcodeInput"
                                    placeholder="Escanee el código de barras aquí"
                                    @keydown.native="handleBarcodeInput"
                                    clearable
                                ></el-input>
                            </template>
                            <small
                                class="form-control-feedback"
                                v-if="errors.item_id"
                                v-text="errors.item_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.quantity }"
                        >
                            <label class="control-label">
                                <i class="fas fa-sort-numeric-up"></i> Cantidad
                            </label>
                            <el-input v-model="form.quantity">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.quantity"
                                v-text="errors.quantity[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.warehouse_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-warehouse"></i> Almacén
                            </label>
                            <el-select
                                v-model="form.warehouse_id"
                                filterable
                                @change="changeItem"
                            >
                                <el-option
                                    v-for="option in warehouses"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.warehouse_id"
                                v-text="errors.warehouse_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div
                        class="col-md-4"
                        v-if="type == 'input' && form.lots_enabled"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.lot_code }"
                        >
                            <label class="control-label">
                                <i class="fas fa-barcode"></i> Código lote
                            </label>
                            <el-input v-model="form.lot_code">
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i>
                            </el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.lot_code"
                                v-text="errors.lot_code[0]"
                            ></small>
                        </div>
                    </div>

                    <div class="col-md-3" v-show="form.lots_enabled">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.date_of_due }"
                        >
                            <label class="control-label">
                                <i class="fas fa-calendar-alt"></i> Fec.
                                Vencimiento
                            </label>
                            <el-date-picker
                                v-model="form.date_of_due"
                                type="date"
                                value-format="yyyy-MM-dd"
                                :clearable="true"
                            ></el-date-picker>
                            <small
                                class="form-control-feedback"
                                v-if="errors.date_of_due"
                                v-text="errors.date_of_due[0]"
                            ></small>
                        </div>
                    </div>

                    <div
                        style="padding-top: 3%"
                        class="col-md-4"
                        v-if="form.warehouse_id && form.series_enabled"
                    >
                        <a
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickLotcode"
                        >
                            <i class="fas fa-list-ol"></i> [&#10004; Ingresar
                            series]
                        </a>
                    </div>
                    <div
                        style="padding-top: 3%"
                        class="col-md-4"
                        v-if="form.warehouse_id && form.has_color_size"
                    >
                        <a
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickColorSize"
                        >
                            <i class="fas fa-palette"></i> [&#10004; Ingresar
                            Color & Talla]
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.inventory_transaction_id
                            }"
                        >
                            <label class="control-label">
                                <i class="fas fa-exchange-alt"></i> Motivo
                                traslado
                            </label>
                            <el-select
                                v-model="form.inventory_transaction_id"
                                filterable
                            >
                                <el-option
                                    v-for="option in inventory_transactions"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.name"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.inventory_transaction_id"
                                v-text="errors.inventory_transaction_id[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-boxes"></i> Stock en almacenes
                            </label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Almacén</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="warehouse in selectedWarehouses"
                                        :key="warehouse.id"
                                    >
                                        <td>
                                            {{
                                                warehouse.warehouse_description
                                            }}
                                        </td>
                                        <td>{{ warehouse.stock }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="form-actions d-flex justify-content-end gap-3 pt-2 pb-2"
            >
                <!-- Botón Cancelar -->
                <el-button
                    class="btn-cancel btn-cancel:hover"
                    icon="fas fa-times fa-lg"
                    @click.prevent="close()"
                >
                    <span>Cancelar</span>
                </el-button>
                <!-- Botón Guardar -->
                <el-button
                    class="btn-save btn-save:hover"
                    icon="fas fa-save fa-lg"
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                >
                    <span>Aceptar</span>
                </el-button>
            </div>
        </form>

        <input-lots-form
            :showDialog.sync="showDialogLots"
            :stock="form.quantity"
            :lots="form.lots"
            @addRowLot="addRowLot"
        >
        </input-lots-form>

        <output-lots-form
            :showDialog.sync="showDialogLotsOutput"
            :lots="form.lots"
            @addRowOutputLot="addRowOutputLot"
        >
        </output-lots-form>
        <color-size
            :showDialog.sync="showDialogColorSizeInput"
            :stock="form.quantity"
            :recordId="form.item_id"
            @addRowColorSize="updateColorSize"
        ></color-size>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
import InputLotsForm from "../../../../../../resources/js/views/items/partials/lots.vue";
import OutputLotsForm from "./partials/lots.vue";
import ColorSize from "./partials/color_size.vue";
export default {
    components: { OutputLotsForm, InputLotsForm, ColorSize },
    props: ["showDialog", "recordId", "type"],
    data() {
        return {
            loading_submit: false,
            showDialogLots: false,
            showDialogLotsOutput: false,
            showDialogColorSizeInput: false,
            titleDialog: null,
            resource: "inventory",
            errors: {},
            form: {},
            items: [],
            item: null,
            warehouses: [],
            inventory_transactions: [],
            loading_search_item: false,
            product: null,
            barcodeBuffer: "",
            lastKeyTime: 0,
            barcodeMode: false,
            barcodeInput: ""
        };
    },
    created() {
        this.initForm();
    },
    computed: {
        selectedWarehouses() {
            return this.item && this.item.warehouse ? this.item.warehouse : [];
        }
    },

    methods: {
        clickColorSize() {
            this.showDialogColorSizeInput = true;
        },
        updateColorSize(color_size) {
            console.log(
                "🚀 ~ file: form.vue:256 ~ updateColorSize ~ color_size:",
                color_size
            );
            this.form.color_size = color_size;
        },
        handleBarcode(event) {
            const currentTime = new Date().getTime();
            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;
            this.barcodeBuffer += event.key;
            if (event.key === "Enter" && this.barcodeBuffer.length > 0) {
                event.preventDefault();
                // Solo buscar el producto, no limpiar el modelo ni el input visual aquí
                this.searchRemoteItems(this.barcodeBuffer);
                this.barcodeBuffer = "";
            }
        },
        handleBarcodeInput(event) {
            if (!this.barcodeMode) return;
            const currentTime = new Date().getTime();
            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;
            // Solo agregar caracteres imprimibles
            if (
                event.key.length === 1 &&
                !event.ctrlKey &&
                !event.altKey &&
                !event.metaKey
            ) {
                this.barcodeBuffer += event.key;
            }
            if (event.key === "Enter" && this.barcodeBuffer.length > 0) {
                event.preventDefault();
                this.loading_search_item = true;
                this.$http
                    .get(`/${this.resource}/items?value=${this.barcodeBuffer}`)
                    .then(response => {
                        this.items = response.data;
                        if (this.items.length > 0) {
                            // Si se encuentra producto, agregarlo como válido y mostrar la descripción en el input
                            this.setProduct([this.items[0]]);
                            this.barcodeInput =
                                this.items[0].descripcion ||
                                this.items[0].description ||
                                "";
                            this.form.quantity = this.items[0].stock || 0; // Actualizar el stock
                        } else {
                            // Si no hay resultados, limpia la selección y el input
                            this.form.item_id = null;
                            this.item = null;
                            this.barcodeInput = "";
                        }
                        this.loading_search_item = false;
                    })
                    .finally(() => {
                        this.barcodeBuffer = "";
                    });
            }
        },
        searchRemoteItems(input) {
            if (!input || input.length < 3) {
                this.items = [];
                this.loading_search_item = false;
                return;
            }
            clearTimeout(this.timer);
            this.loading_search_item = true;
            this.timer = setTimeout(() => {
                this.$http
                    .get(`/${this.resource}/items?value=${input}`)
                    .then(response => {
                        this.items = response.data;
                        this.loading_search_item = false;
                    })
                    .catch(() => {
                        this.items = [];
                        this.loading_search_item = false;
                    });
            }, 300);
        },
        async changeItem() {
            if (this.type == "output") {
                this.form.lots = [];
                let item = await _.find(this.items, { id: this.form.item_id });
                console.log(
                    "🚀 ~ file: form.vue:277 ~ changeItem ~ item:",
                    item
                );
                this.item = item;
                this.form.lots_enabled = item.lots_enabled;
                let lots = await _.filter(item.lots, {
                    warehouse_id: this.form.warehouse_id
                });
                // console.log(item)
                this.form.lots = lots;
                this.form.lots_enabled = item.lots_enabled;
                this.form.series_enabled = item.series_enabled;
                this.form.has_color_size = item.has_color_size;
            } else {
                let item = await _.find(this.items, { id: this.form.item_id });
                console.log(
                    "🚀 ~ file: form.vue:277 ~ changeItem ~ item:",
                    item
                );
                this.item = item;
                this.form.lots_enabled = item.lots_enabled;
                this.form.series_enabled = item.series_enabled;
                this.form.has_color_size = item.has_color_size;
            }
        },
        addRowOutputLot(lots) {
            this.form.lots = lots;
        },
        addRowLot(lots) {
            this.form.lots = lots;
        },
        clickLotcode() {
            this.showDialogLots = true;
        },
        clickLotcodeOutput() {
            this.showDialogLotsOutput = true;
        },
        initForm() {
            this.errors = {};
            this.form = {
                id: null,
                item_id: null,
                warehouse_id: 1,
                inventory_transaction_id: "02",
                quantity: 0,
                type: this.type,
                lot_code: null,
                lots_enabled: false,
                series_enabled: false,
                lots: [],
                date_of_due: null
            };
        },
        async create() {
            console.log("🚀 ~ create ~ this.type:", this.type);
            this.titleDialog =
                this.type == "input"
                    ? "Ingreso de producto al almacén"
                    : "Salida de producto del almacén";

            await this.$http
                .get(`/${this.resource}/tables/transaction/${this.type}`)
                .then(response => {
                    this.items = response.data.items;
                    this.warehouses = response.data.warehouses;
                    this.inventory_transactions =
                        response.data.inventory_transactions;
                });
        },
        async submit() {
            // if(this.form.quantity<0)
            //     return this.$toast.error('No puede ingresar cantidad negativa')
            if (this.type == "input") {
                if (this.form.lots_enabled) {
                    if (!this.form.lot_code)
                        return this.$toast.error("Código de lote es requerido");

                    if (!this.form.date_of_due)
                        return this.$toast.error(
                            "Fecha de vencimiento es requerido si lotes esta habilitado."
                        );
                }

                if (this.form.series_enabled) {
                    if (this.form.lots.length > this.form.quantity)
                        return this.$toast.error(
                            "La cantidad de series registradas es superior al stock"
                        );

                    if (this.form.lots.length != this.form.quantity)
                        return this.$toast.error(
                            "La cantidad de series registradas son diferentes al stock"
                        );
                }

                /*if(this.form.lots_enabled){

                        if(!this.form.lot_code)
                            return this.$toast.error('Código de lote es requerido');

                        if(this.form.lots.length != this.form.quantity)
                            return this.$toast.error('La cantidad de series registradas son diferentes a la cantidad a ingresar');

                    }*/
            } else {
                if (this.form.lots.length > 0 && this.form.lots_enabled) {
                    let select_lots = await _.filter(this.form.lots, {
                        has_sale: true
                    });

                    if (select_lots.length != this.form.quantity) {
                        return this.$toast.error(
                            "La cantidad ingresada es diferente a las series seleccionadas"
                        );
                    }
                }

                //
                // return
            }

            this.loading_submit = true;
            this.form.type = this.type;
            //
            await this.$http
                .post(`/${this.resource}/transaction`, this.form)
                .then(response => {
                    console.log("qwwwewe", response);
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$emit("stock", this.form.quantity);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
            this.barcodeInput = "";
        },
        setProduct(items) {
            if (items && items.length > 0) {
                const item = items[0];

                if (item.warehouses && !item.warehouse) {
                    item.warehouse = item.warehouses;
                }

                // Agregar el item al array de items si no existe
                if (!this.items.some(i => i.id === item.id)) {
                    this.items.push({
                        id: item.id,
                        description: item.descripcion,
                        stock: item.stock || 0,
                        lots_enabled: item.lots_enabled || false,
                        series_enabled: item.series_enabled || false,
                        has_color_size: item.has_color_size || false,
                        warehouse: item.warehouse || item.warehouses || [] // Asegura almacenes
                    });
                }

                this.form.item_id = item.id;
                this.form.description = item.descripcion;
                this.form.quantity = item.stock || 0;
                this.item = item; // Asegura que selectedWarehouses se actualice

                this.$nextTick(() => {
                    if (this.$refs.itemSelect) {
                        this.$refs.itemSelect.blur();
                        this.$refs.itemSelect.$el.querySelector("input").value =
                            "";
                    }
                });
                this.barcodeBuffer = "";
            }
        }
    }
};
</script>
