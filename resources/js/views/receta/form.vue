<template>
    <el-dialog width="65%" :title="titleDialog" :visible="showDialog" :close-on-click-modal="false" @close="close"
        @open="create" append-to-body top="7vh" class="rounded-dialog">
        <form autocomplete="off" @submit.prevent="submit">
            <el-tabs v-model="activeTab">
                <el-tab-pane label="General" name="general">
                    <div class="form-body">
                        <br />
                        <div class="row">
                            <div class="short-div col-md-2">
                                <div class="form-group" :class="{
                                    'has-danger': errors.internal_id
                                }">
                                    <label class="control-label">
                                        Código Interno
                                        <el-tooltip class="item" effect="dark"
                                            content="Código interno de la empresa para el control de sus productos"
                                            placement="top-start">
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>

                                    <el-input v-model="form.internal_id" dusk="internal_id"></el-input>
                                    <small class="form-control-feedback" v-if="errors.internal_id"
                                        v-text="errors.internal_id[0]"></small>
                                </div>
                            </div>
                            <!-- Nombre del Producto compuesto -->
                            <div class="col-md-5">
                                <div class="form-group" :class="{
                                    'has-danger': errors.description
                                }">
                                    <label class="control-label">
                                        Nombre
                                        <span class="text-danger">*</span>
                                    </label>

                                    <el-input v-model="form.description" dusk="description"></el-input>
                                    <small class="form-control-feedback" v-if="errors.description"
                                        v-text="errors.description[0]"></small>
                                </div>
                            </div>

                            <!-- Descripcion del Producto Compuesto -->
                            <div class="col-md-5">
                                <div class="form-group" :class="{ 'has-danger': errors.name }">
                                    <label class="control-label">Descripción</label>
                                    <el-input v-model="form.name" dusk="name"></el-input>
                                    <small class="form-control-feedback" v-if="errors.name"
                                        v-text="errors.name[0]"></small>
                                </div>
                            </div>
                            <!-- categoria -->
                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger': errors.category_id
                                }">
                                    <label class="control-label">
                                        Categoría
                                    </label>

                                    <a href="#" v-if="form_category.add == false"
                                        class="control-label font-weight-bold text-info"
                                        @click="form_category.add = true">
                                        <i class="fas fa-plus-circle"></i>
                                        Nuevo
                                    </a>

                                    <a href="#" v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-info" @click="saveCategory()">
                                        <i class="fas fa-save fa-lg"></i>
                                    </a>

                                    <a href="#" v-if="form_category.add == true"
                                        class="control-label font-weight-bold text-danger"
                                        @click="form_category.add = false">
                                        <i class="fas fa-times fa-lg"></i>
                                    </a>

                                    <el-input v-if="form_category.add == true" v-model="form_category.name"
                                        dusk="item_code" style="margin-bottom:1.5%;">
                                        <i slot="prefix" class="el-icon-edit-outline"></i></el-input>

                                    <el-select v-if="form_category.add == false" v-model="form.category_id" filterable
                                        clearable>
                                        <el-option v-for="option in categories" :key="option.id" :value="option.id"
                                            :label="option.name"></el-option>
                                    </el-select>
                                    <small class="text-danger" v-if="errors.category_id"
                                        v-text="errors.category_id[0]"></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger':
                                        errors.sale_affectation_igv_type_id
                                }">
                                    <label class="control-label">Lugar de Preparación</label>
                                    <el-select v-model="form.area_id">
                                        <el-option v-for="option in areas" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="
                                        errors.sale_affectation_igv_type_id
                                    " v-text="errors
                                                .sale_affectation_igv_type_id[0]
                                            "></small>
                                </div>
                            </div>
                            <!-- Almacen  -->
                            <div class="col-md-3" v-show="recordId == null">
                                <div class="form-group" :class="{
                                    'has-danger': errors.warehouse_id
                                }">
                                    <label class="control-label">
                                        Almacén
                                        <el-tooltip class="item" effect="dark"
                                            content="Si no selecciona almacén, se asignará por defecto el relacionado al establecimiento"
                                            placement="top">
                                            <i class="fa fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-select :disabled="allEstablishment" v-model="form.warehouse_id" filterable>
                                        <el-option v-for="option in warehouses" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.warehouse_id"
                                        v-text="errors.warehouse_id[0]"></small>
                                </div>
                                <small v-if="!recordId">
                                    <el-checkbox v-model="allEstablishment">
                                        Todos los almacenes</el-checkbox>
                                </small>
                            </div>
                            <!-- Unidad de Medida -->
                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger': errors.unit_type_id
                                }">
                                    <label class="control-label">Unidad de Medida</label>
                                    <el-select v-model="form.unit_type_id" dusk="unit_type_id">
                                        <el-option v-for="option in unit_types" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.unit_type_id"
                                        v-text="errors.unit_type_id[0]"></small>
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.individual_items}">
                            <label class="control-label">Elegir productos</label>
                            <el-select v-model="form.individual_items" filterable multiple collapse-tags @change="changeIndividualItems" >
                                <el-option v-for="option in individual_items" :key="option.id" :value="option.id" :label="option.full_description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.individual_items" v-text="errors.individual_items[0]"></small>
                        </div>
                    </div> -->
                            <!-- moneda -->
                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger': errors.currency_type_id
                                }">
                                    <label class="control-label">Moneda</label>
                                    <el-select v-model="form.currency_type_id" dusk="currency_type_id">
                                        <el-option v-for="option in currency_types" :key="option.id" :value="option.id"
                                            :label="option.description"></el-option>
                                    </el-select>
                                    <small class="form-control-feedback" v-if="errors.currency_type_id"
                                        v-text="errors.currency_type_id[0]"></small>
                                </div>
                            </div>
                            <!-- Afectacion  -->
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="short-div col-md-12">
                                        <div class="form-group" :class="{
                                            'has-danger':
                                                errors.purchase_affectation_igv_type_id
                                        }">
                                            <label class="control-label">
                                                Tipo de afectación (Venta)
                                            </label>

                                            <el-select v-model="form.sale_affectation_igv_type_id
                                                " @change="
                                                    changeAffectationIgvType
                                                ">
                                                <el-option v-for="option in affectation_igv_types" :key="option.id"
                                                    :value="option.id" :label="option.description"></el-option>
                                            </el-select>
                                            <small class="form-control-feedback" v-if="
                                                errors.sale_affectation_igv_type_id
                                            " v-text="errors
                                                        .sale_affectation_igv_type_id[0]
                                                    "></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Precio Unitario -->
                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger': errors.sale_unit_price
                                }">
                                    <label class="control-label">Precio Unitario (Venta)
                                        <span class="text-danger">*</span></label>
                                    <el-input v-model="form.sale_unit_price" dusk="sale_unit_price" @input="
                                        calculatePercentageOfProfitBySale
                                    "></el-input>
                                    <small class="form-control-feedback" v-if="errors.sale_unit_price"
                                        v-text="errors.sale_unit_price[0]"></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" :class="{
                                    'has-danger': errors.commission
                                }">
                                    <label class="control-label">Comision para el receta
                                        <span class="text-danger">*</span></label>
                                    <el-input v-model="form.commission" dusk="commission"></el-input>
                                    <small class="form-control-feedback" v-if="errors.commission"
                                        v-text="errors.commission[0]"></small>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-6 px-2">
                                <div class="form-group">
                                    <label class="control-label d-flex align-items-center">
                                        <i class="fa fa-motorcycle fa-lg me-1"></i>
                                        Add. Delivery
                                        <el-tooltip class="ms-2" effect="dark"
                                            content="Valor agregado en SOLES al enviar el producto por delivery"
                                            placement="top">
                                            <i class="fas fa-info-circle"></i>
                                        </el-tooltip>
                                    </label>
                                    <el-input v-model="form.delivery_cost"></el-input>
                                </div>
                            </div>


                            <div class="col-md-3 mt-4 d-flex align-items-start justify-content-end">
                                <el-button type="primary" icon="plus" @click.prevent="showDialogAddItem = true">
                                    <i class="fas fa-plus-circle fa-lg"></i>
                                    Agregar productos
                                </el-button>
                            </div>

                            <div class="col-md-12 mt-2" v-if="form.individual_items.length > 0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr slot="heading" class="bg-primary">
                                                <th class="text-white">#</th>
                                                <th class="font-weight-bold text-white">
                                                    Descripción
                                                </th>
                                                <th class="text-white text-center font-weight-bold">
                                                    Precio Unitario
                                                </th>
                                                <th class="text-white text-right font-weight-bold">
                                                    Cantidad
                                                </th>
                                                <th class="text-white text-end">
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row,
                                                index) in form.individual_items" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>
                                                    {{ row.full_description }}
                                                </td>
                                                <td class="text-center">
                                                    {{
                                                        row.unit_type_description
                                                    }}
                                                </td>

                                                <td class="text-right">
                                                    <!-- {{ row.quantity }} -->
                                                    {{
                                                        parseFloat(
                                                            row.quantity
                                                        ).toFixed(3)
                                                    }}
                                                    {{
                                                        row.unit_type_description
                                                    }}
                                                </td>

                                                <td class="text-right">
                                                    <button type="button"
                                                        class="btn waves-effect waves-light btn-xs btn-danger"
                                                        @click.prevent="
                                                            clickRemoveItem(
                                                                index
                                                            )
                                                            ">
                                                        x
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div
                        class="col-md-3"
                        v-show="recordId == null && form.unit_type_id != 'ZZ'"
                    >
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.stock }"
                        >
                            <label class="control-label">Stock Inicial</label>
                            <el-input v-model="form.stock"></el-input>
                            <small
                                class="form-control-feedback"
                                v-if="errors.stock"
                                v-text="errors.stock[0]"
                            ></small>
                        </div>
                    </div> -->

                            <div class="row col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Imágen
                                            <span class="text-danger"></span></label>
                                        <el-upload class="avatar-uploader" :data="{ type: 'items' }" :headers="headers"
                                            :action="`/${resource}/upload`" :show-file-list="false"
                                            :on-success="onSuccess">
                                            <img v-if="form.image_url" :src="form.image_url" class="avatar" />
                                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                        </el-upload>
                                    </div>
                                </div>
                            </div>

                            <item-set-form-item :warehouse_id.sync="form.warehouse_id"
                                :showDialog.sync="showDialogAddItem" @add="addRow"></item-set-form-item>
                        </div>
                    </div>

                    <br />
                </el-tab-pane>
                <el-tab-pane label="Almacenes" name="almacenes">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <el-table :data="warehousePrices" style="width: 100%">
                                    <el-table-column prop="warehouse" label="Almacén" width="300"></el-table-column>
                                    <el-table-column label="Precio">
                                        <template #default="scope">
                                            <el-input v-model="scope.row.price" placeholder="Precio"
                                                @input=""></el-input>
                                        </template>
                                    </el-table-column>
                                </el-table>
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <div class="form-actions text-right pt-2">
                <el-button icon="fas fa-times fa-lg" @click.prevent="close()">
                    Cancelar
                </el-button>

                <el-button icon="fas fa-save fa-lg" type="primary" native-type="submit" :loading="loading_submit">
                    Guardar
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<style>
.el-dialog {
    border-radius: 10px;
    overflow: hidden;
}
</style>

<script>
import ItemSetFormItem from "./partials/item.vue";

export default {
    props: ["showDialog", "recordId", "external", "establishment_id"],
    components: {
        ItemSetFormItem
    },

    data() {
        return {
            allEstablishment: false,
            warehousePrices: [],
            activeTab: "general",
            showDialogAddItem: false,
            warehouses: [],
            loading_submit: false,
            showPercentagePerception: false,
            has_percentage_perception: false,
            percentage_perception: null,
            enabled_percentage_of_profit: false,
            titleDialog: null,
            resource: "receta",
            errors: {},
            headers: headers_token,
            form_category: {
                add: false,
                name: null,
                id: null
            },
            form: {},
            areas: [],
            categories: [],
            unit_types: [],
            currency_types: [],
            individual_items: [],
            system_isc_types: [],
            affectation_igv_types: [],
            internal_id: null,
            affectation_igv_type_id: null,
            accounts: [],
            show_has_igv: true,
            have_account: false,
            web_platforms: [],
            item_unit_type: {
                id: null,
                unit_type_id: null,
                quantity_unit: 0,
                price1: 0,
                price2: 0,
                price3: 0,
                price_default: 2
            }
        };
    },
    created() {
        this.initForm();

        this.$eventHub.$on("submitPercentagePerception", data => {
            this.form.percentage_perception = data;
            if (!this.form.percentage_perception)
                this.has_percentage_perception = false;
        });
    },
    methods: {
        clickRemoveItem(index) {
            this.form.individual_items.splice(index, 1);
            this.changeIndividualItems();
        },
        addRow(row) {
            let exist = this.form.individual_items.find(
                item => item.individual_item_id == row.individual_item_id
            );

            if (exist) {
                exist.quantity += row.quantity;
            } else {
                this.form.individual_items.push(row);
            }
            // console.log(row)
            this.changeIndividualItems();
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
                .catch(error => { });
        },
        changeIndividualItems() {
            // let acum_sale_unit_price = 0
            // this.form.individual_items.forEach(row => {
            //     // let individual_item = _.find(this.individual_items,{'id':id})
            //     acum_sale_unit_price += parseFloat(row.sale_unit_price) * parseFloat(row.quantity)
            // });
            // this.form.sale_unit_price = acum_sale_unit_price
            // this.form.sale_unit_price_set = acum_sale_unit_price
        },
        initForm() {
            (this.loading_submit = false), (this.errors = {});
            this.form = {
                warehouse_id: null,
                id: null,
                item_type_id: "01",
                internal_id: null,
                item_code: null,
                item_code_gs1: null,
                description: null,
                name: null,
                second_name: null,
                unit_type_id: "NIU",
                currency_type_id: "PEN",
                sale_unit_price: 0,
                commission: 0,
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
                account_id: null,
                is_set: true,
                sale_unit_price_set: 0,
                date_of_due: null,
                web_platform_id: null,
                category_id: null,
                area_id: null,
                individual_items: [],
                attributes: []
            };
            this.warehousePrices = [];
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
            let is_exonerated = false;
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
            this.warehousePrices = [];
        },
        async create() {
            const response = await this.$http.get(`/${this.resource}/tables`);

            this.unit_types = response.data.unit_types;
            this.accounts = response.data.accounts;
            this.currency_types = response.data.currency_types;
            this.system_isc_types = response.data.system_isc_types;
            this.affectation_igv_types = response.data.affectation_igv_types;
            this.affectation_igv_type_id =
                response.data.affectation_igv_type_id;
            this.internal_id = response.data.internal_id;
            this.areas = response.data.areas;
            this.categories = response.data.categories;
            // this.individual_items = response.data.individual_items
            this.warehouses = response.data.warehouses;
            if (this.warehouses.length > 0) {
                this.form.warehouse_id = this.warehouses[0].id;
            }
            if (this.establishment_id) {
                this.form.warehouse_id = this.establishment_id;
            }

            this.web_platforms = response.data.web_platforms;

            this.form.sale_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.form.purchase_affectation_igv_type_id =
                this.affectation_igv_types.length > 0
                    ? this.affectation_igv_types[0].id
                    : null;
            this.titleDialog = this.recordId
                ? "Editar Plato Con receta"
                : "Nuevo Plato Con Receta";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.warehousePrices = response.data.data.warehouse_prices.map(
                            price => ({
                                id: price.id,
                                warehouse_id: price.warehouse_id,
                                warehouse: price.warehouse,
                                price: price.price
                            })
                        );
                        this.changeAffectationIgvType();
                    });
            } else {
            }
            if (!this.form.category_id && this.categories.length > 0) {
                let categoria_packs = this.categories.find(
                    area => area.name == "PACKS"
                );
                if (categoria_packs) {
                    this.form.category_id = categoria_packs.id;
                }
            }
            if (!this.form.warehouse_id && this.warehouses.length > 0) {
                this.form.warehouse_id = this.warehouses[0].id;
            }
            if (!this.form.area_id && this.areas.length > 0) {
                let area_caja = this.areas.find(
                    area => area.description == "CAJA"
                );
                if (area_caja) {
                    this.form.area_id = area_caja.id;
                }
            }
            if (this.affectation_igv_type_id && !this.recordId) {
                console.log("xd");
                this.form.sale_affectation_igv_type_id = this.affectation_igv_type_id;
            }
            if (!this.form.internal_id && this.internal_id) {
                this.form.internal_id = this.internal_id;
            }
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
                price_default: 2
            });
        },
        clickCancel(index) {
            this.form.item_unit_types.splice(index, 1);
            // this.initDocumentTypes()
            // this.showAddButton = true
        },
        calculatePercentageOfProfitBySale() {
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
        submit() {
            if (this.form.category_id === null)
                return this.$toast.error("Debe seleccionar una categoría");
            if (this.form.individual_items.length < 1)
                return this.$toast.error("Al menos debe elegir 2 productos");

            this.form.all_establishment = this.allEstablishment;

            this.form.warehouse_prices = this.warehousePrices;

            this.form.sale_unit_price_set = this.form.sale_unit_price;
            this.form.attributes = this.form.attributes
                ? this.form.attributes
                : [];
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        if (this.external) {
                            this.$eventHub.$emit(
                                "reloadDataItems",
                                response.data.id
                            );
                        } else {
                            this.$eventHub.$emit("reloadData");
                        }
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
            this.resetForm();
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
        }
    }
};
</script>
