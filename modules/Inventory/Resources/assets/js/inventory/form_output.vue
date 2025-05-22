<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        :close-on-click-modal="false"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <br />
                <div class="row">
                    <!-- <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.item_id }"
                        >
                            <label class="control-label">
                                <i class="fas fa-boxes fa-lg"></i>
                                Producto
                            </label>
                            <el-select
                                v-model="form.item_id"
                                class="w-100"
                                filterable
                                remote
                                popper-class="el-select-customers"
                                clearable
                                @change="changeItem"
                                @keydown.native="handleBarcode"
                                placeholder="Nombre o código interno"
                                :remote-method="searchRemoteItems"
                                :loading="loading_search_item"
                            >
                                <el-option
                                    v-for="option in items"
                                    :key="option.id"
                                    :value="option.id"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="form-control-feedback"
                                v-if="errors.item_id"
                                v-text="errors.item_id[0]"
                            ></small>
                        </div>
                    </div> -->
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
                                    @change="changeItem"
                                    placeholder=" busque por nombre/código"
                                    :remote-method="searchRemoteItems"
                                    :loading="loading_search_item"
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
                            <label class="control-label">Cantidad</label>
                            <el-input
                                v-model="form.quantity"
                                :disabled="form.has_color_size"
                            >
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
                                <i class="fas fa-warehouse red-icon fa-lg"></i>
                                Almacén
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
                        style="padding-top: 3%;"
                        class="col-md-2 col-sm-2"
                        v-if="
                            form.item_id &&
                                form.lots_enabled &&
                                form.lots_group.length > 0
                        "
                    >
                        <el-button
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickLotGroup"
                            >[&#10004; Seleccionar lote]
                        </el-button>
                    </div>
                    <div
                        style="padding-top: 3%;"
                        class="col-md-3 col-sm-3"
                        v-if="form.item_id && form.series_enabled"
                    >
                        <!-- <el-button type="primary" native-type="submit" icon="el-icon-check">Elegir serie</el-button> -->
                        <el-button
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickSelectLots"
                            >[&#10004; Seleccionar series]</el-button
                        >
                    </div>
                    <div
                        style="padding-top: 3%;"
                        class="col-md-3 col-sm-3"
                        v-if="
                            form.item_id &&
                                form.has_color_size &&
                                form.warehouse_id
                        "
                    >
                        <!-- <el-button type="primary" native-type="submit" icon="el-icon-check">Elegir serie</el-button> -->
                        <el-button
                            href="#"
                            class="text-center font-weight-bold text-info"
                            @click.prevent="clickSelectColorSize"
                            >[&#10004; Seleccionar color & talla]</el-button
                        >
                    </div>
                    <div class="col-md-8">
                        <div
                            class="form-group"
                            :class="{
                                'has-danger': errors.inventory_transaction_id
                            }"
                        >
                            <label class="control-label">
                                <i class="fas fa-exchange-alt fa-lg"></i>
                                Motivo traslado
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
                            <label>Stock en almacenes</label>
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
                                        <td
                                            :class="{
                                                'text-danger':
                                                    warehouse.stock < 0,
                                                'text-success':
                                                    warehouse.stock > 0
                                            }"
                                        >
                                            {{
                                                Number(warehouse.stock).toFixed(
                                                    2
                                                )
                                            }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
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

                <!-- <el-button
                    type="primary"
                    icon="fas fa-save fa-lg"
                    native-type="submit"
                    :loading="loading_submit"
                    >Aceptar</el-button
                > -->
            </div>
        </form>

        <lots-group
            :quantity="form.quantity"
            :showDialog.sync="showDialogLots"
            :lots_group="form.lots_group"
            @addRowLotGroup="addRowLotGroup"
        ></lots-group>

        <select-lots-form
            :showDialog.sync="showDialogSelectLots"
            :lots="form.lots"
            @addRowSelectLot="addRowSelectLot"
        ></select-lots-form>
        <color-size-output
            :showDialog.sync="showDialogColorSizeOutput"
            :item_id="form.item_id"
            :item.sync="item"
            @updateColorSize="colorSizeSelected"
            :warehouse_id="form.warehouse_id"
            :quantity="form.quantity"
        ></color-size-output>
    </el-dialog>
</template>

<script>
//  import InputLotsForm from '../../../../../../resources/js/views/tenant/items/partials/lots.vue'
// import OutputLotsForm from './partials/lots.vue'
import LotsGroup from "./lots_group.vue";
import SelectLotsForm from "./lots.vue";
import ColorSizeOutput from "./partials/color_size_output.vue";

export default {
    components: { LotsGroup, SelectLotsForm, ColorSizeOutput },
    props: ["showDialog", "recordId"],
    data() {
        return {
            loading_search_item: false,
            type: "output",
            // lots: [],
            loading_submit: false,
            showDialogLots: false,
            showDialogSelectLots: false,
            titleDialog: null,
            resource: "inventory",
            errors: {},
            form: {},
            items: [],
            warehouses: [],
            inventory_transactions: [],
            timer: null,
            item: null,
            showDialogColorSizeOutput: false,
            barcodeBuffer: "",
            barcodeTimeoutHandle: null,
            barcodeMode: false,
            barcodeInput: ""
        };
    },
    /* mounted() {
        document.addEventListener("keypress", this.handleBarcodeInput);
    },
    beforeDestroy() {
        document.removeEventListener("keypress", this.handleBarcodeInput);
    }, */
    created() {
        this.initForm();
    },
    computed: {
        selectedWarehouses() {
            return this.item && this.item.warehouse ? this.item.warehouse : [];
        }
    },
    methods: {
        handleBarcodeInput(event) {
            if (!this.barcodeMode) return;
            const currentTime = new Date().getTime();
            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;
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
                            // Si se encuentra producto, seleccionarlo y actualizar datos
                            this.form.item_id = this.items[0].id;
                            this.changeItem();
                            this.barcodeInput =
                                this.items[0].descripcion ||
                                this.items[0].description ||
                                "";
                            this.form.quantity = this.items[0].stock || 0;
                        } else {
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
        colorSizeSelected(color_size) {
            // Guardar el array
            this.form.color_size = color_size;
            // Si hay color y talla, sumar la cantidad total y reflejar en el input
            if (this.form.has_color_size && Array.isArray(color_size)) {
                const total = color_size.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
                this.form.quantity = total;
            }
        },
        clickSelectColorSize() {
            this.showDialogColorSizeOutput = true;
        },
        /* handleBarcode(event) {
            const currentTime = new Date().getTime();

            if (currentTime - this.lastKeyTime > 100) {
                this.barcodeBuffer = "";
            }
            this.lastKeyTime = currentTime;

            this.barcodeBuffer += event.key;

            if (event.key === "Enter" && this.barcodeBuffer.length > 0) {
                event.preventDefault();
                this.searchRemoteItems(this.barcodeBuffer);
                this.barcodeBuffer = "";
            }
        }, */
        async searchRemoteItems(input) {
            if (input.length >= 3) {
                clearTimeout(this.timer);
                this.loading_search_item = true;
                this.timer = setTimeout(() => {
                    this.$http
                        .get(`/${this.resource}/items?value=${input}`)
                        .then(response => {
                            this.items = response.data;
                            // Si encontramos exactamente un item, lo seleccionamos automáticamente
                            /* if (this.items.length === 1) {
                                this.form.item_id = this.items[0].id;
                                this.changeItem();
                            } */
                            this.loading_search_item = false;
                        });
                }, 300); // Reducido de 600 a 300ms para mayor velocidad en lectura de códigos
            }
        },
        async changeItem() {
            this.form.lots = [];
            let item = await _.find(this.items, { id: this.form.item_id });
            console.log(
                "🚀 ~ file: form_output.vue:232 ~ changeItem ~ item:",
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
            this.form.lots_group = item.lots_group;
            this.form.has_color_size = item.has_color_size;
            this.form.color_size = item.color_size;
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
                inventory_transaction_id: "01",
                quantity: 0,
                type: this.type,
                lot_code: null,
                lots_enabled: false,
                series_enabled: false,
                lots: [],
                date_of_due: null,
                IdLoteSelected: null,
                lots_group: []
            };
        },
        async create() {
            this.titleDialog = "Salida de producto del almacén";

            await this.$http
                .get(`/${this.resource}/tables/transaction/output`)
                .then(response => {
                    this.items = response.data.items;
                    this.warehouses = response.data.warehouses;
                    this.inventory_transactions =
                        response.data.inventory_transactions;
                });
        },
        async submit() {
            if (this.form.lots.length > 0 && this.form.series_enabled) {
                let select_lots = await _.filter(this.form.lots, {
                    has_sale: true
                });

                if (select_lots.length != this.form.quantity) {
                    return this.$toast.error(
                        "La cantidad ingresada es diferente a las series seleccionadas"
                    );
                }
            }

            if (this.form.lots_enabled) {
                if (!this.form.IdLoteSelected)
                    return this.$toast.error("Debe seleccionar un lote.");
            }

            this.loading_submit = true;
            this.form.type = this.type;
            //
            await this.$http
                .post(`/${this.resource}/transaction`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$eventHub.$emit("reloadData");
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data;
                        // console.log(error.response.data)
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
        clickLotGroup() {
            if (this.form.warehouse_id) {
                this.showDialogLots = true;
            } else {
                this.$showSAlert(
                    "ALERTA",
                    "Debe seleccionar un Almacen antes de poder seleccionar un lote",
                    "error"
                );
            }
        },
        addRowLotGroup(id) {
            this.form.IdLoteSelected = id;
        },
        async clickSelectLots() {
            if (this.form.warehouse_id) {
                this.showDialogSelectLots = true;
            } else {
                this.$showSAlert(
                    "ALERTA",
                    "Debe seleccionar un almacén antes para poder seleccionar la serie",
                    "error"
                );
            }
        },
        addRowSelectLot(lots) {
            this.form.lots = lots;
        }
    }
};
</script>
