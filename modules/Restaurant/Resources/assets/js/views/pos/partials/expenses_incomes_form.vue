<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @close="close"
        @open="create"
        append-to-body
        width="50%"
        v-loading="loading"
    >
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.method }"
                        >
                            <label class="control-label">Metodo de Pgo </label>
                            <el-select disabled v-model="form.method" clearable>
                                <el-option
                                    v-for="option in payment_methods"
                                    :key="option.id"
                                    :value="option.description"
                                    :label="option.description"
                                ></el-option>
                            </el-select>
                            <small
                                class="text-danger"
                                v-if="errors.method"
                                v-text="errors.method[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.amount }"
                        >
                            <label class="control-label">Efectivo</label>
                            <el-input-number
                                :disabled="hasDetails"
                                v-model.number="form.amount"
                                :precision="2"
                                :controls="false"
                                class="w-100"
                            ></el-input-number>
                            <small
                                class="text-danger"
                                v-if="errors.amount"
                                v-text="errors.amount[0]"
                            ></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.date }"
                        >
                            <label class="control-label">Fecha</label>
                            <el-date-picker
                                :disabled="true"
                                style="width:100%;"
                                v-model="form.date"
                                format="dd-MM-yyyy"
                                value-format="yyyy-MM-dd"
                                type="date"
                            >
                            </el-date-picker>
                            <small
                                class="text-danger"
                                v-if="errors.date"
                                v-text="errors.date[0]"
                            ></small>
                        </div>
                    </div>
                    <template v-if="activeName == 'expenses'">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="item">
                                    Gasto
                                    <a
                                        href="#"
                                        class="control-label font-weight-bold text-info"
                                        @click="openCreateItem"
                                    >
                                        [ + Nuevo]</a
                                    >
                                </label>
                                <el-select
                                    v-if="form.item_add == false"
                                    v-model="detail.item_detail_id"
                                    filterable
                                    remote
                                    popper-class="el-select-customers"
                                    clearable
                                    placeholder="Buscar producto"
                                    :remote-method="searchRemoteItems"
                                    @change="loadDataUtilities"
                                    class="w-100"
                                >
                                    <el-option
                                        v-for="option in items_detail"
                                        :key="option.id"
                                        :value="option.id"
                                        :label="
                                            `${option.detail} ${option.unit_id}`
                                        "
                                    ></el-option>
                                </el-select>
                                <el-input
                                    placeholder="Buscar producto"
                                    class="w-100"
                                    v-model="detail.item_detail_id"
                                    v-else
                                >
                                </el-input>
                            </div>
                            <div class="col-md-2">
                                <label for="qty">
                                    Cantidad
                                </label>

                                <el-input-number
                                    controls-position="right"
                                    :controls="false"
                                    :precision="2"
                                    class="w-100"
                                    v-model.number="detail.quantity"
                                ></el-input-number>
                            </div>
                            <div class="col-md-2">
                                <label for="price">
                                    Precio
                                </label>
                                <el-input-number
                                    controls-position="right"
                                    :precision="2"
                                    :controls="false"
                                    class="w-100"
                                    v-model.number="detail.price"
                                ></el-input-number>
                            </div>
                            <div class="col-md-2">
                                <label for="price">
                                    Precio adicional
                                </label>
                                <el-input-number
                                    :min="0"
                                    :precision="2"
                                    class="w-100"
                                    :controls="false"
                                    id="extra_price"
                                    v-model.number="detail.extra_price"
                                ></el-input-number>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <el-button type="primary" @click="addDetail">
                                    <i
                                        class="fa fa-plus"
                                        aria-hidden="true"
                                    ></i>
                                    Agregar
                                </el-button>
                            </div>
                        </div>
                        <div
                            class="row"
                            style="margin-top:25px;"
                            v-if="details != 0"
                        >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>DESCP.</th>
                                        <th>CANT.</th>
                                        <th>PRECIO UNIT</th>
                                        <th>PRECIO ADICIONAL</th>
                                        <th>PRECIO TOTAL</th>
                                        <th>ELIMINAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(dt, idx) in details" :key="idx">
                                        <td>{{ dt.item.detail }}</td>
                                        <td>
                                            {{ dt.quantity }}
                                            {{ dt.item.unit_id }}
                                        </td>
                                        <td>{{ dt.price }}</td>
                                        <td>{{ dt.extra_price }}</td>
                                        <td>
                                            {{
                                                dt.price * dt.quantity +
                                                    dt.extra_price
                                            }}
                                        </td>
                                        <td>
                                            <el-button
                                                type="danger"
                                                size="mini"
                                                @click="
                                                    deleteDetail(
                                                        dt.item_detail_id
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fa fa-trash"
                                                    aria-hidden="true"
                                                ></i>
                                            </el-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <div class="col-md-12 p-2">
                        <div
                            class="form-group"
                            :class="{ 'has-danger': errors.description }"
                        >
                            <label class="control-label"
                                >Detalle - Concepto</label
                            >
                            <el-input
                                type="textarea"
                                v-model="form.description"
                            >
                                <i
                                    slot="prefix"
                                    class="el-icon-edit-outline"
                                ></i
                            ></el-input>
                            <small
                                class="text-danger"
                                v-if="errors.description"
                                v-text="errors.description[0]"
                            ></small>
                        </div>
                    </div>
                </div>
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
        <el-dialog
            v-loading="loading"
            width="50%"
            append-to-body
            :visible.sync="showCreateItem"
            title="Crear detalle de concepto"
        >
            <div class="row p-2">
                <div class="col-md-8">
                    <label for="product">
                        Descripción
                    </label>
                    <el-input v-model="newItem.item"></el-input>
                </div>
                <div class="col-md-4">
                    <label for="type">
                        Unidad de medida
                    </label>
                    <el-select v-model="newItem.unitTypeId">
                        <el-option
                            v-for="(type, idx) in unitTypes"
                            :key="idx"
                            :value="type.id"
                            :label="type.description"
                        ></el-option>
                    </el-select>
                </div>
                <div class="col-12 text-right " style="margin-top:15px;">
                    <el-button type="primary" @click="saveUnitType"
                        >Guardar</el-button
                    >
                </div>
            </div>
        </el-dialog>
    </el-dialog>
</template>

<script>
//import { EventBus } from "../../../helpers/bus";

export default {
    props: ["cashid", "showDialog", "activeName", "items_detail", "unitTypes","recordId"],
    data() {
        return {
            hasDetails: false,
            newItem: {},
            loading_submit: false,
            titleDialog: null,
            loading: false,
            resource: "restaurant/worker/expenses",
            errors: {},
            errors_group: {},
            errors_category: {},
            errors_subcategory: {},
            form: {},
            array_subcategorias: [],
            array_categorias: [],
            details: [],
            detail: {
                extra_price: 0
            },
            array_group: [],
            register_group: false,
            register_category: false,
            register_subcategory: false,
            form_group: [],
            form_category: [],
            form_subcategory: [],
            array_company: [],
            payment_methods: [],
            showCreateItem: false
        };
    },
    watch: {},
    created() {
        console.log(this.recordId);
        this.initForm();
        this.$http.get(`/${this.resource}/tables`).then(response => {
            this.array_group = response.data.gruop;
            this.array_categorias = response.data.category;
            this.array_subcategorias = response.data.subcategory;
            this.array_company = response.data.company;
            this.payment_methods = response.data.methods;
            this.form.method = this.payment_methods[0].description;
            this.form.soap_type_id = this.array_company.soap_type_id;
        });
    },
    methods: {
        async saveUnitType() {
            if (!this.newItem.item || !this.newItem.unitTypeId) {
                return this.$toast.error("Verifique los datos");
            }
            try {
                this.loading = true;
                const response = await this.$http.post("../save_item", {
                    description: this.newItem.item,
                    unitTypeId: this.newItem.unitTypeId
                });
                const {
                    data: { item, success, message }
                } = response;
                success
                    ? this.$toast.success(message)
                    : this.$toast.error(message);
                if (success) {
                    this.$emit("update:items_detail", [item]);
                    this.detail.item_detail_id = item.id;
                    this.showCreateItem = false;
                    this.newItem = {};
                }
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
        openCreateItem() {
            this.showCreateItem = true;
        },
        deleteDetail(id) {
            this.details = this.details.filter(f => f.item_detail_id != id);
            let total = this.details.reduce(
                (a, b) => a + (b.price * b.quantity + b.extra_price),
                0
            );
            this.form.amount = total;
            this.hasDetails = this.details.length != 0;
        },
        addDetail() {
            let { price, quantity, item_detail_id } = this.detail;

            if (!price || !quantity || !item_detail_id) {
                this.$toast.error("Verifique los datos");
                return;
            }
            let item = this.items_detail.find(
                i => i.id == this.detail.item_detail_id
            );

            let detailExist = this.details.find(
                d => d.item_detail_id == item_detail_id
            );

            if (detailExist) {
                detailExist.quantity += quantity;
                detailExist.price = price;

                this.details = [
                    ...this.details.filter(
                        d => d.item_detail_id != item_detail_id
                    ),
                    detailExist
                ];
            } else {
                this.details = [
                    ...this.details,
                    {
                        ...this.detail,
                        item
                    }
                ];
            }

            this.hasDetails = this.details.length != 0;

            this.detail = {};
            this.detail.extra_price = 0;
            let total = this.details.reduce(
                (a, b) => a + (b.price * b.quantity + b.extra_price),
                0
            );

            this.form.amount = total;
            console.log(this.details);
        },
        searchRemoteItems(input) {
            if (input.length > 1 && this.form.item_add == false) {
                this.$emit("getItemsDetail", input);
            }
        },
        loadDataUtilities() {},
        initGroup() {
            this.form_group = {
                id: null,
                group: null,
                type: 2
            };
        },
        initCategory() {
            this.form_category = {
                id: null,
                category: null,
                type: 2
            };
        },
        initSubcategory() {
            this.form_subcategory = {
                id: null,
                subcategory: null,
                type: 2
            };
        },
        initForm() {
            this.details = [];
            this.errors = {};
            this.detail = {};
            this.form = {
                id: null,
                user_id: this.userid,
                seller_id: null,
                method: null,
                group_id: 1,
                category_id: 1,
                subcategory_id: 1,
                item_add: false,
                amount: 0.0,
                date: moment().format("YYYY-MM-DD"),
                description: null,
                extra_price: 0.0,
                close: null,
                type: this.activeName == "expenses" ? 2 : 1,
                state: 1,
                soap_type_id: "01",
                incomes: this.activeName == "incomes",
                expenses: this.activeName == "expenses"
            };

            this.initGroup();
            this.initCategory();
            this.initSubcategory();
        },
        submit_group() {
            this.$http
                .post(`/groups`, this.form_group)
                .then(response => {
                    if (response.data.success) {
                        this.register_group = false;
                        this.array_group.push({
                            id: response.data.data.id,
                            group: response.data.data.group,
                            type: 2
                        });
                        this.form.group_id = response.data.data.id;
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors_group = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        submit_Category() {
            this.$http
                .post(`/restaurant/worker/category`, this.form_category)
                .then(response => {
                    if (response.data.success) {
                        this.register_category = false;
                        this.array_categorias.push({
                            id: response.data.data.id,
                            category: response.data.data.category,
                            type: 2
                        });
                        this.form.category_id = response.data.data.id;
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors_category = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        submit_Subcategory() {
            this.$http
                .post(`/restaurant/worker/subcategories`, this.form_subcategory)
                .then(response => {
                    if (response.data.success) {
                        this.register_subcategory = false;
                        this.array_subcategorias.push({
                            id: response.data.data.id,
                            subcategory: response.data.data.subcategory,
                            type: 2
                        });
                        this.form.subcategory_id = response.data.data.id;
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors_subcategory = error.response.data;
                    } else {
                        console.log(error);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        create() {
            this.initForm();
            this.titleDialog =
                this.activeName == "expenses"
                    ? "Nuevo Egreso Caja"
                    : "Nuevo Ingreso Caja";
            if (this.recordId) {
                this.$http
                    .get(`/${this.resource}/record/${this.recordId}`)
                    .then(response => {
                        this.form = response.data.data;
                        this.form.item_add = false;
                        if(this.activeName == 'expenses'){
                            this.details = this.form.items.map(i=>{

                                return {
                                    ...i,
                                    price:Number(i.price||0),
                                    quantity:Number(i.quantity||1),
                                    extra_price:Number(i.extra_price||0.0)
                                }
                            });
                        }
                        });
                    this.form.method = this.payment_methods[0].description;
            } else {
                this.form.method = this.payment_methods[0].description;
            }
            this.detail.extra_price = 0.0;
            this.hasDetails = this.details.length != 0;
        },
        submit() {
            let total = this.details.reduce(
                (a, b) => a + (b.price * b.quantity + b.extra_price),
                0
            );
            if (total > this.form.amount) {
                return this.$toast.error(
                    "La suma de los items no puede ser mayor al gasto general"
                );
            }
            this.form.cashid = this.cashid;
            this.form.items = this.details;
            this.loading_submit = true;
            this.$http
                .post(`/${this.resource}`, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$toast.success(response.data.message);
                        this.$emit("getRecords");
                        this.details = [];
                        this.detail = {};
                        this.close();
                    } else {
                        this.$toast.error(response.data.message);
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.$toast.error(error.response.data.message);
                    }
                })
                .then(() => {
                    this.loading_submit = false;
                });
        },
        close() {
            this.$emit("update:showDialog", false);
            this.initForm();
        }
    }
};
</script>
