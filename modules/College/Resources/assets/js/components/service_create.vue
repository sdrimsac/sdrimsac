<template>
    <el-dialog
        width="65%"
        :title="titleDialog"
        :visible="showDialog"
        :close-on-click-modal="false"
        @close="close"
        @open="create"
        append-to-body
        top="7vh"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <el-tabs tab-position="top">
                    <el-tab-pane label="General">
                        <div class="row">
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.internal_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Código Interno
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Código interno de la empresa para el control de sus productos"
                                            placement="top-start"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input
                                        ref="internal_id"
                                        v-model="form.internal_id"
                                        dusk="internal_id"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.internal_id"
                                        v-text="errors.internal_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.description
                                    }"
                                >
                                    <label class="control-label"
                                        >Nombre<span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <el-input
                                        v-model="form.description"
                                        dusk="description"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i>
                                    </el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.description"
                                        v-text="errors.description[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.second_name
                                    }"
                                >
                                    <label class="control-label"
                                        >Nombre secundario
                                    </label>
                                    <el-input
                                        v-model="form.second_name"
                                        dusk="second_name"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.second_name"
                                        v-text="errors.second_name[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.category_id
                                    }"
                                >
                                    <label class="control-label">
                                        Categoría
                                    </label>

                                    <a
                                        href="#"
                                        v-if="form_category.add == false"
                                        class="control-label font-weight-bold text-info"
                                        @click="form_category.add = true"
                                    >
                                        [ + Nuevo]</a
                                    >
                                    <a
                                        href="#"
                                        v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-info"
                                        @click="saveCategory()"
                                    >
                                        [ + Guardar]</a
                                    >
                                    <a
                                        href="#"
                                        v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-danger"
                                        @click="form_category.add = false"
                                    >
                                        [ Cancelar]</a
                                    >
                                    <el-input
                                        v-if="form_category.add == true"
                                        v-model="form_category.name"
                                        dusk="item_code"
                                        style="margin-bottom:1.5%;"
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>

                                    <el-select
                                        v-if="form_category.add == false"
                                        v-model="form.category_id"
                                        filterable
                                        clearable
                                    >
                                        <el-option
                                            v-for="option in categories"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.name"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.category_id"
                                        v-text="errors.category_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger':
                                            errors.sale_affectation_igv_type_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Zona
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            content="Lugar en donde se despacha el producto"
                                            placement="top-start"
                                        >
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-select v-model="form.area_id">
                                        <el-option
                                            v-for="option in areas"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="form-control-feedback"
                                        v-if="
                                            errors.sale_affectation_igv_type_id
                                        "
                                        v-text="
                                            errors
                                                .sale_affectation_igv_type_id[0]
                                        "
                                    >
                                    </small>
                                </div>
                            </div>
                            <div
                                class="col-md-3 center-el-checkbox"
                                v-show="show_has_igv"
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.has_igv }"
                                >
                                    <el-checkbox v-model="form.has_igv"
                                        >Incluye Igv
                                        {{
                                            configuration.include_igv
                                        }}</el-checkbox
                                    ><br />
                                    <small
                                        class="text-danger"
                                        v-if="errors.has_igv"
                                        v-text="errors.has_igv[0]"
                                    ></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.location }"
                                >
                                    <label class="control-label"
                                        >Ubicación del producto
                                    </label>
                                    <el-input
                                        v-model="form.location"
                                        dusk="name"
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.location"
                                        v-text="errors.location[0]"
                                    ></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.unit_type_id
                                    }"
                                >
                                    <label class="control-label">Unidad</label>
                                    <el-select
                                        disabled
                                        v-model="form.unit_type_id"
                                        dusk="unit_type_id"
                                    >
                                        <el-option
                                            v-for="option in unit_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.unit_type_id"
                                        v-text="errors.unit_type_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.currency_type_id
                                    }"
                                >
                                    <label class="control-label">Moneda</label>
                                    <el-select
                                        v-model="form.currency_type_id"
                                        dusk="currency_type_id"
                                    >
                                        <el-option
                                            v-for="option in currency_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="errors.currency_type_id"
                                        v-text="errors.currency_type_id[0]"
                                    ></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger': errors.sale_unit_price
                                    }"
                                >
                                    <label class="control-label"
                                        >Precio Unitario (Venta)
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <el-input
                                        v-model="form.sale_unit_price"
                                        dusk="sale_unit_price"
                                        @input="
                                            calculatePercentageOfProfitBySale
                                        "
                                    >
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.sale_unit_price"
                                        v-text="errors.sale_unit_price[0]"
                                    ></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div
                                    class="form-group"
                                    :class="{
                                        'has-danger':
                                            errors.sale_affectation_igv_type_id
                                    }"
                                >
                                    <label class="control-label"
                                        >Tipo de afectación (Venta)</label
                                    >
                                    <el-select
                                        v-model="
                                            form.sale_affectation_igv_type_id
                                        "
                                        @change="changeAffectationIgvType"
                                    >
                                        <el-option
                                            v-for="option in affectation_igv_types"
                                            :key="option.id"
                                            :value="option.id"
                                            :label="option.description"
                                        ></el-option>
                                    </el-select>
                                    <small
                                        class="text-danger"
                                        v-if="
                                            errors.sale_affectation_igv_type_id
                                        "
                                        v-text="
                                            errors
                                                .sale_affectation_igv_type_id[0]
                                        "
                                    ></small>
                                </div>
                            </div>

                            <div
                                class="col-md-3"
                                v-show="
                                    recordId == null &&
                                        form.unit_type_id != 'ZZ'
                                "
                            >
                                <div
                                    class="form-group"
                                    :class="{ 'has-danger': errors.stock }"
                                >
                                    <label class="control-label"
                                        >Stock Inicial</label
                                    >
                                    <el-input v-model="form.stock">
                                        <i
                                            slot="prefix"
                                            class="el-icon-edit-outline"
                                        ></i
                                    ></el-input>
                                    <small
                                        class="text-danger"
                                        v-if="errors.stock"
                                        v-text="errors.stock[0]"
                                    ></small>
                                </div>
                            </div>
                        </div>
                    </el-tab-pane>
                </el-tabs>
            </div>
            <div class="form-actions text-end pt-2 pb-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button
                    type="primary"
                    native-type="submit"
                    :loading="loading_submit"
                    >Guardar</el-button
                >
            </div>
        </form>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "recordId", "external"],
    components: {},

    data() {
        return {
            showDialogLots: false,
            form_category: { add: false, name: null, id: null },
            form_brand: { add: false, name: null, id: null },
            warehouses: [],
            loading_submit: false,
            showPercentagePerception: false,
            has_percentage_perception: false,
            percentage_perception: null,
            enabled_percentage_of_profit: false,
            titleDialog: null,
            resource: "items",
            errors: {},
            headers: headers_token,
            form: {},
            configuration: {},
            unit_types: [],
            areas: [],
            currency_types: [],
            system_isc_types: [],
            affectation_igv_types: [],
            categories: [],
            brands: [],
            accounts: [],
            show_has_igv: true,
            have_account: false,
            showSeries: false,
            item_unit_type: {
                id: null,
                unit_type_id: null,
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 2
            },
            attribute_types: [],
            area_id: 2
        };
    },
    async created() {
        await this.initForm();
        await this.$http.get(`/${this.resource}/tables`).then(response => {
            this.unit_types = response.data.unit_types;
            this.accounts = response.data.accounts;
            this.currency_types = response.data.currency_types;
            this.system_isc_types = response.data.system_isc_types;
            this.affectation_igv_types = response.data.affectation_igv_types;
            this.warehouses = response.data.warehouses;
            if (this.warehouses.length > 0) {
                this.form.warehouse_id = this.warehouses[0].id;
                this.form.warehouse_prices = this.warehouses.map(w => ({
                    id: null,
                    item_id: null,
                    warehouse_id: w.id,
                    price: null,
                    warehouse: w.description
                }));
            }
            this.categories = response.data.categories;
            this.brands = response.data.brands;
            this.attribute_types = response.data.attribute_types;
            this.configuration = response.data.configuration;
            this.areas = response.data.areas;
            this.form.sale_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.form.purchase_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            //agregar opciones para entorno restaurante
        });

        this.$eventHub.$on("submitPercentagePerception", data => {
            this.form.percentage_perception = data;
            if (!this.form.percentage_perception)
                this.has_percentage_perception = false;
        });

        this.$eventHub.$on("reloadTables", () => {
            this.reloadTables();
        });

        await this.setDefaultConfiguration();
    },

    methods: {
        selectedMax(idx) {
            let selected = this.form.item_unit_types[idx].selected;
            for (let i = 0; i < this.form.item_unit_types.length; i++) {
                let it = this.form.item_unit_types[i];
                it.selected = false;
            }

            this.form.item_unit_types[idx].selected = selected;
            if (selected) {
                let qty = Number(this.form.item_unit_types[idx].quantity_unit);
                !isNaN(qty) && (this.form.max_quantity = qty);
            } else {
                this.form.max_quantity = null;
            }
            this.$forceUpdate();
        },
        undToTotal(idx, amount, qty) {
            let arr = this.form.item_unit_types;
            if (qty > 0) {
                arr[idx].total = Number(amount) * Number(qty);
            } else {
                this.$toast.warning("Ingrese una cantidad válida");
                arr[idx].price2 = 0;
            }
        },
        totalToUnd(idx, amount, qty) {
            let arr = this.form.item_unit_types;
            if (qty > 0) {
                arr[idx].price2 = Number(amount) / Number(qty);
            } else {
                this.$toast.warning("Ingrese una cantidad válida");
                arr[idx].total = 0;
            }
        },
        setDefaultConfiguration() {
            this.form.sale_affectation_igv_type_id = this.configuration
                ? this.configuration.affectation_igv_type_id
                : "10";

            this.$http.get(`/configurations/record`).then(response => {
                this.form.has_igv = response.data.data.include_igv;
            });
            this.changeAffectationIgvType();
        },
        clickAddAttribute() {
            this.form.attributes.push({
                attribute_type_id: null,
                description: null,
                value: null,
                start_date: null,
                end_date: null,
                duration: null
            });
        },
        async reloadTables() {
            await this.$http.get(`/${this.resource}/tables`).then(response => {
                this.unit_types = response.data.unit_types;
                this.accounts = response.data.accounts;
                this.currency_types = response.data.currency_types;
                this.system_isc_types = response.data.system_isc_types;
                this.affectation_igv_types =
                    response.data.affectation_igv_types;
                this.warehouses = response.data.warehouses;
                this.categories = response.data.categories;
                this.brands = response.data.brands;

                this.form.sale_affectation_igv_type_id =
                    this.affectation_igv_types.length > 0
                        ? this.affectation_igv_types[0].id
                        : null;
                this.form.purchase_affectation_igv_type_id =
                    this.affectation_igv_types.length > 0
                        ? this.affectation_igv_types[0].id
                        : null;
            });
        },
        changeLotsEnabled() {
            // if(!this.form.lots_enabled){
            //     this.form.lot_code = null
            //     this.form.lots = []
            // }
        },
        addRowLot(lots) {
            this.form.lots = lots;
        },
        clickLotcode() {
            // if(this.form.stock <= 0)
            //     return this.$toast.error('El stock debe ser mayor a 0')

            this.showDialogLots = true;
        },
        changeHaveAccount() {
            if (!this.have_account) this.form.account_id = null;
        },
        changeEnabledPercentageOfProfit() {
            // if(!this.enabled_percentage_of_profit) this.form.percentage_of_profit = 0
        },
        clickDelete(id) {
            this.$http
                .delete(`/${this.resource}/item-unit-type/${id}`)
                .then(res => {
                    if (res.data.success) {
                        this.loadRecord();
                        this.$toast.success(
                            "Se eliminó correctamente el registro"
                        );
                    }
                })
                .catch(error => {
                    if (error.response.status === 500) {
                        this.$toast.error("Error al intentar eliminar");
                    } else {
                        console.log(error.response.data.message);
                    }
                });
        },
        changeHasPerception() {
            if (!this.form.has_perception) {
                this.form.percentage_perception = null;
            }
        },
        clickAddRow() {
            this.form.item_unit_types.push({
                id: null,
                description: null,
                unit_type_id: "NIU",
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 2,
                warehouse_id: null
            });
        },
        clickCancel(index) {
            this.form.item_unit_types.splice(index, 1);
            // this.initDocumentTypes()
            // this.showAddButton = true
        },
        initForm() {
            (this.loading_submit = false), (this.errors = {});
            this.form = {
                id: null,
                item_type_id: "01",
                location: null,
                internal_id: null,
                item_code: null,
                item_code_gs1: null,
                description: null,
                name: null,
                second_name: null,
                unit_type_id: "ZZ",
                currency_type_id: "PEN",
                sale_unit_price: 0,
                purchase_unit_price: 0,
                has_isc: false,
                system_isc_type_id: null,
                percentage_isc: 0,
                suggested_price: 0,
                sale_affectation_igv_type_id: null,
                purchase_affectation_igv_type_id: null,
                calculate_quantity: false,
                stock: 0,
                stock_min: 1,
                has_igv: true,
                has_perception: false,
                item_unit_types: [],
                percentage_of_profit: 0,
                percentage_perception: 0,
                image: null,
                image_url: null,
                temp_path: null,
                is_set: false,
                account_id: null,
                category_id: null,
                brand_id: null,
                date_of_due: null,
                lot_code: null,
                lots_enabled: false,
                lots: [],
                attributes: [],
                series_enabled: false,
                area_id: 2
            };
            this.show_has_igv = true;
            this.enabled_percentage_of_profit = false;
        },
        onSuccess(response, file, fileList) {
            if (response.success) {
                this.form.image = response.data.filename;
                this.form.image_url = response.data.temp_image;
                this.form.temp_path = response.data.temp_path;
            } else {
                this.$toast.error(response.message);
            }
        },
        changeAffectationIgvType() {
            let affectation_igv_type_exonerated = [
                20,
                21,
                30,
                31,
                32,
                33,
                34,
                35,
                36,
                37
            ];
            let is_exonerated = affectation_igv_type_exonerated.includes(
                parseInt(this.form.sale_affectation_igv_type_id)
            );

            if (is_exonerated) {
                this.show_has_igv = false;
                this.form.has_igv = true;
            } else {
                this.show_has_igv = true;
            }
        },
        resetForm() {
            this.initForm();
            this.form.sale_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.form.purchase_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.setDefaultConfiguration();
        },
        create() {
            this.titleDialog = this.recordId
                ? "Editar Productos"
                : "Nuevo Producto";

            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;

                        if (this.form.warehouse_prices.length == 0) {
                            if (this.warehouses.length > 0) {
                                this.form.warehouse_id = this.warehouses[0].id;
                                this.form.warehouse_prices = this.warehouses.map(
                                    w => ({
                                        id: null,
                                        item_id: null,
                                        warehouse_id: w.id,
                                        price: null,
                                        warehouse: w.description
                                    })
                                );
                            }
                        } else {
                            this.form.warehouse_prices = this.warehouses.map(
                                w => {
                                    let exist = this.form.warehouse_prices.find(
                                        ww => ww.warehouse_id == w.id
                                    );
                                    if (exist) {
                                        return exist;
                                    }
                                    return {
                                        id: null,
                                        item_id: null,
                                        warehouse_id: w.id,
                                        price: null,
                                        warehouse: w.description
                                    };
                                }
                            );
                        }
                        if (this.form.item_unit_types.length != 0) {
                            this.restoreUnitTypes();
                        }
                        this.has_percentage_perception = this.form
                            .percentage_perception
                            ? true
                            : false;
                        this.changeAffectationIgvType();
                        this.showSeries = true;

                        if (this.form.series_enabled == 1) {
                            this.form.series_enabled = true;
                        } else this.form.series_enabled = false;
                    });
            } else {
                this.showSeries = true;
                //this.form.area_id = 2 ;
            }
            // if(!this.record){
            //     this.form.has_igv= true
            // }
        },
        restoreUnitTypes() {
            let hasSelected = false;
            this.form.item_unit_types = this.form.item_unit_types.map(i => {
                let selected = false;
                if (
                    !hasSelected &&
                    Number(this.form.max_quantity) == Number(i.quantity_unit)
                ) {
                    selected = true;
                    hasSelected = true;
                }
                return {
                    ...i,
                    selected,
                    total: (Number(i.price2) * Number(i.quantity_unit)).toFixed(
                        2
                    )
                };
            });
        },
        loadRecord() {
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.changeAffectationIgvType();
                    });
            }
        },
        changeWarehouse() {
            this.$toast.warning(
                "Cambió el destino del producto, verifique los PRECIOS DE ALMACÉN"
            );

            let w = this.form.warehouse_prices.find(
                ww => ww.warehouse_id == this.form.warehouse_id
            );
            if (w) {
                w.price = this.form.sale_unit_price;
            }

            this.$forceUpdate();
        },
        calculatePercentageOfProfitBySale() {
            let w = this.form.warehouse_prices.find(
                ww => ww.warehouse_id == this.form.warehouse_id
            );
            if (w) {
                w.price = this.form.sale_unit_price;
            }
            let difference =
                parseFloat(this.form.sale_unit_price) -
                parseFloat(this.form.purchase_unit_price);

            if (parseFloat(this.form.purchase_unit_price) === 0) {
                this.form.percentage_of_profit = 0;
            } else {
                if (this.enabled_percentage_of_profit)
                    this.form.percentage_of_profit =
                        (difference /
                            parseFloat(this.form.purchase_unit_price)) *
                        100;
            }
        },
        calculatePercentageOfProfitByPurchase() {
            if (this.form.percentage_of_profit === "") {
                this.form.percentage_of_profit = 0;
            }

            if (this.enabled_percentage_of_profit)
                this.form.sale_unit_price =
                    (this.form.purchase_unit_price *
                        (100 + parseFloat(this.form.percentage_of_profit))) /
                    100;
        },
        calculatePercentageOfProfitByPercentage() {
            if (this.form.percentage_of_profit === "") {
                this.form.percentage_of_profit = 0;
            }

            if (this.enabled_percentage_of_profit)
                this.form.sale_unit_price =
                    (this.form.purchase_unit_price *
                        (100 + parseFloat(this.form.percentage_of_profit))) /
                    100;
        },
        async submit() {
            if (this.form.internal_id == null || this.form.internal_id == "") {
                this.$refs.internal_id.$el.querySelector("input").focus();
                return this.$toast.warning(
                    "No puede guardar Un nuevo Producto sin codigo interno "
                );
            }

            if (this.form.has_perception && !this.form.percentage_perception)
                return this.$toast.error("Ingrese un porcentaje");

            if (!this.form.warehouse_id)
                return this.$toast.error("Seleccione un almacen");
            if (!this.recordId && this.form.lots_enabled) {
                // if (!this.form.lot_code)
                //     return this.$toast.error("Código de lote es requerido");
                // if (!this.form.date_of_due)
                //     return this.$toast.error(
                //         "Fecha de vencimiento es requerido si lotes esta habilitado."
                //     );
            }

            if (!this.recordId && this.form.series_enabled) {
                if (this.form.lots.length > this.form.stock)
                    return this.$toast.error(
                        "La cantidad de series registradas es superior al stock"
                    );

                if (this.form.lots.length != this.form.stock)
                    return this.$toast.error(
                        "La cantidad de series registradas son diferentes al stock"
                    );
            }

            this.loading_submit = true;
            await this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$emit("add", response.data.data);
                        console.log(response);
                        //this.$eventHub.$emit('reloadDataItems', response.data.id)

                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
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
            this.showSeries = false;
            this.resetForm();
            this.form.warehouse_prices = this.warehouses.map(w => ({
                id: null,
                item_id: null,
                warehouse_id: w.id,
                price: null,
                warehouse: w.description
            }));
        },
        changeHasIsc() {
            this.form.system_isc_type_id = null;
            this.form.percentage_isc = 0;
            this.form.suggested_price = 0;
        },
        changeSystemIscType() {
            if (this.form.system_isc_type_id !== "03") {
                this.form.suggested_price = 0;
            }
        },
        saveCategory() {
            this.form_category.add = false;

            this.$http
                .post(`/items/categories`, this.form_category)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.categories.push(response.data.data);
                        this.form.category_id = response.data.data.id;
                        this.form_category.name = null;
                    } else {
                        this.$toast.error("No se guardaron los cambios");
                    }
                })
                .catch(error => {});
        },
        saveBrand() {
            this.form_brand.add = false;

            this.$http
                .post(`/brands`, this.form_brand)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.brands.push(response.data.data);
                        this.form_brand.name = null;
                    } else {
                        this.$toast.error("No se guardaron los cambios");
                    }
                })
                .catch(error => {});
        },
        changeAttributeType(index) {
            let attribute_type_id = this.form.attributes[index]
                .attribute_type_id;
            let attribute_type = _.find(this.attribute_types, {
                id: attribute_type_id
            });
            this.form.attributes[index].description =
                attribute_type.description;
        },
        clickRemoveAttribute(index) {
            this.form.attributes.splice(index, 1);
        }
    }
};
</script>
