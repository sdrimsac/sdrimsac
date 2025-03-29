<template>
    <div>
        <div class="row" v-if="ordens.length > 0">
            <div class="col-12 p-1">
                <h2 class="small-title fw-bold">Ordenes Realizadas</h2>
                <hooper :settings="hooperSettings">
                    <slide v-for="(o, index) in ordens" :key="index">
                        <div class="col-md-12 p-2">
                            <div
                                class="card_profile"
                                :data-id="o.id"
                                :class="
                                    ordenSelectedId == o.id ? 'bg-active' : ''
                                "
                                @click="
                                    selectOrden(o.id);
                                    show_orders();
                                "
                            >
                                <div class="card__avatar">
                                    <div class="badge"></div>
                                </div>
                                <div>
                                    <h3>
                                        <strong> Orden Nº{{ o.id }} </strong>
                                        <br />{{ o.ref }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </slide>
                    <hooper-navigation slot="hooper-addons"></hooper-navigation>
                </hooper>
            </div>
        </div>

        <div class="row">
            <div
                v-if="screenWidth > 698"
                class="col-sm-6 col-md-5 col-lg-6 col-xl-8 p-1"
            >
                <list-food
                    ref="list_foods"
                    @insertOrden="insertOrden"
                    :configuration="configuration"
                    :pagination="pagination"
                    :table="table"
                    :categories="categories"
                    :showMenu.sync="showMenu"
                    :localOrden.sync="localOrden"
                    :foods.sync="foods"
                    :divided_items="divided_items"
                    @changePage="changePage"
                ></list-food>
            </div>
            <!--  inicio sidebar -->
            <div v-else>
                <!-- Modo Celular/ Movil -->
                <div class="d-flex flex-wrap ">
                    <button
                        type="button"
                        class="btn settings-button btn-gradient-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#settings"
                        id="settingsButton"
                    >
                        <i class="fas fa-shopping-basket"></i>
                    </button>
                    <div
                        class="modal fade modal-right scroll-out-negative"
                        id="settings"
                        data-bs-backdrop="true"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="settings"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-scrollable full"
                            role="document"
                        >
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5
                                        class="modal-title"
                                        style="color: var(--light-text) !important;"
                                    >
                                        Visualizacion de Productos
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div
                                    class="modal-body"
                                    style="padding-right: 2px;"
                                >
                                    <div
                                        class="scroll-track-visible"
                                        style="overflow-y: auto;"
                                    >
                                        <div class="row ">
                                            <div class="col-12">
                                                <template>
                                                    <h2
                                                        class="font-weight-bold custom-text-size"
                                                    >
                                                        Categorias
                                                    </h2>
                                                    <el-select
                                                        v-model="category"
                                                        filterable
                                                        clearable
                                                        placeholder="Selecionar aqui...."
                                                        @change="
                                                            searchOrden(
                                                                category
                                                            )
                                                        "
                                                    >
                                                        <el-option
                                                            v-for="item in categories"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </template>
                                            </div>
                                            <div class="col-12 ">
                                                <h2
                                                    class="font-weight-bold custom-text-size"
                                                >
                                                    Buscar
                                                </h2>
                                                <el-input
                                                    ref="input_item"
                                                    size="small"
                                                    v-model="input_item"
                                                    @input="searchOrden()"
                                                    @focus="clear_input()"
                                                    autofocus
                                                    placeholder="Ingrese Nombre de Producto"
                                                >
                                                    <el-button
                                                        slot="append"
                                                        icon="el-icon-search"
                                                        @click="searchOrden()"
                                                    ></el-button>
                                                </el-input>
                                            </div>
                                            <div class="row d-flex flex-wrap">
                                                <div
                                                    class="col-12  p-1"
                                                    v-for="(data,
                                                    index) in foods"
                                                    :key="index"
                                                >
                                                    <div
                                                        id="card"
                                                        class="
                                                                    overflow-hidden
                                                                    coupon
                                                                    rounded
                                                                    d-flex
                                                                    flex-column
                                                                    justify-content-between
                                                                    p-1
                                                                    "
                                                        style="height: 112px; width: 297px ; margin-left: 9px; "
                                                    >
                                                        <div
                                                            @click="
                                                                addFood(index)
                                                            "
                                                        >
                                                            <div>
                                                                <span
                                                                    class="lead-font-weight-700 h5"
                                                                >
                                                                    {{
                                                                        data.description.toUpperCase()
                                                                    }}
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-end justify-content-between"
                                                            >
                                                                <div
                                                                    class="p-1"
                                                                >
                                                                    <div
                                                                        class="icon-container"
                                                                    >
                                                                        <div
                                                                            class="icon-container_box"
                                                                        >
                                                                            <template
                                                                                v-if="
                                                                                    data.image ==
                                                                                        'imagen-no-disponible.jpg'
                                                                                "
                                                                            >
                                                                                <img
                                                                                    hidden
                                                                                    src="/images/imagen-no-disponible.jpg"
                                                                                    alt="User Img"
                                                                                    class="thumbail"
                                                                                />
                                                                            </template>
                                                                            <template
                                                                                v-else
                                                                            >
                                                                                <img
                                                                                    :src="
                                                                                        formatUrlImage(
                                                                                            data.image
                                                                                        )
                                                                                    "
                                                                                    class="thumbail"
                                                                                />
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    {{
                                                                        data.code
                                                                    }}
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column align-items-end"
                                                                >
                                                                    <div
                                                                        class="block mb-2"
                                                                    >
                                                                        <span
                                                                            class="time font-weight-light"
                                                                        >
                                                                            <span
                                                                                class="text-muted lead-font-weight-700"
                                                                            >
                                                                                S/
                                                                                {{
                                                                                    data.price
                                                                                }}</span
                                                                            >
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <template
                                                                            v-if="
                                                                                data
                                                                                    .item
                                                                                    .is_set ==
                                                                                    0 &&
                                                                                    data
                                                                                        .item
                                                                                        .unit_type_id !=
                                                                                        'ZZ'
                                                                            "
                                                                        >
                                                                            <template
                                                                                v-if="
                                                                                    data
                                                                                        .item
                                                                                        .stock >
                                                                                        0
                                                                                "
                                                                            >
                                                                                <span
                                                                                    class="badge rounded-pill bg-primary m-l-0"
                                                                                    >Stock
                                                                                    <template
                                                                                        v-if="
                                                                                            data
                                                                                                .item
                                                                                                .max_quantity
                                                                                        "
                                                                                    >
                                                                                        {{
                                                                                            formatedStockPresentation(
                                                                                                data.item,
                                                                                                data
                                                                                                    .item
                                                                                                    .stock
                                                                                            )
                                                                                        }}
                                                                                    </template>
                                                                                    <template
                                                                                        v-else
                                                                                    >
                                                                                        {{
                                                                                            parseFloat(
                                                                                                data
                                                                                                    .item
                                                                                                    .stock
                                                                                            )
                                                                                        }}
                                                                                    </template>
                                                                                </span>
                                                                            </template>
                                                                            <template
                                                                                v-else
                                                                            >
                                                                                <span
                                                                                    class="badge rounded-pill bg-danger m-l-0"
                                                                                >
                                                                                    Agotado
                                                                                </span>
                                                                            </template>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            @click="nthing"
                                                            v-if="
                                                                data.types
                                                                    .length > 0
                                                            "
                                                            class="d-flex justify-content-end"
                                                            style="padding-right: 10px; margin-top: 5px"
                                                        >
                                                            <el-dropdown
                                                                @command="
                                                                    clickCommand
                                                                "
                                                            >
                                                                <span
                                                                    class="el-dropdown-link"
                                                                >
                                                                    Precios<i
                                                                        class="el-icon-arrow-down el-icon--right"
                                                                    ></i>
                                                                </span>
                                                                <el-dropdown-menu
                                                                    slot="dropdown"
                                                                >
                                                                    <el-dropdown-item
                                                                        v-for="(type,
                                                                        idx) in data.types"
                                                                        :key="
                                                                            idx
                                                                        "
                                                                        :command="
                                                                            type
                                                                        "
                                                                    >
                                                                        {{
                                                                            formatDescriptionType(
                                                                                type
                                                                            )
                                                                        }}
                                                                    </el-dropdown-item>
                                                                </el-dropdown-menu>
                                                            </el-dropdown>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sidebarmodal fin  -->

            <!-- fin de sidebar -->
            <div class="col-sm-6 col-md-7 col-lg-6 col-xl-4 p-1">
                <current-orden
                    :divided_items.sync="divided_items"
                    :table="table"
                    ref="ordenRef"
                    :referencia.sync="currentRef"
                    :tableId="table.id"
                    :configuration.sync="configuration"
                    :localOrden.sync="localOrden"
                    :ordens.sync="ordensItems"
                    :ordenSelectedId.sync="ordenSelectedId"
                    :mozos.sync="mozos"
                    @updateOrdens="updateOrdens"
                    @deleteFood="deleteFood"
                    @ordenDeleted="createOrden"
                    @listtables="clearTables"
                    @selectNewOrden="handleSelectOrden"
                >
                </current-orden>
            </div>
        </div>
    </div>
</template>
<script>
import ListFood from "./list_food.vue";
import CurrentOrden from "./current_orden.vue";
import { Hooper, Slide, Navigation as HooperNavigation } from "hooper";
import "hooper/dist/hooper.css";
export default {
    components: { ListFood, CurrentOrden, Hooper, Slide, HooperNavigation },
    props: [
        "pagination",
        "table",
        "showMenu",
        "categories",
        "foods",
        "configuration",
        "tables_row_select",
        "changingOrden"
    ],
    async created() {
        this.ordens = this.table.orden;

        try {
            this.loading = true;
            const response = await this.$http.get(`dashboard/data_table`);
            if (response.status === 200) {
                this.mozos = response.data.mozos;
                console.log("ver si esta llegando los mozos", this.mozos);
            } else {
                throw new Error("Error al obtener datos");
            }
        } catch (error) {
            console.error("Error:", error);
            this.$toast.error("Error al cargar los mozos");
        } finally {
            this.loading = false;
        }
    },
    watch: {
        table(newTable, _) {
            this.ordens = newTable.orden;
        }
    },
    data() {
        return {
            mozos: [], // Add this line
            divided_items: false,
            allFalse: true,
            currentFood: {},
            input_item: "",
            category: null,
            screenWidth: 0,
            ordenTitle: "Nueva Orden",
            activeName: "menu",
            localOrden: [],
            currentRef: undefined,
            ordens: [],
            ordenSelectedId: null,
            ordensItems: [],
            item: null,
            hooperSettings: {
                centerMode: false,
                trimWhiteSpace: true,
                playSpeed: 3500,
                itemsToShow: 6,
                breakpoints: {
                    2400: {
                        itemsToShow: 6
                    },
                    1800: {
                        itemsToShow: 6
                    },
                    1500: {
                        itemsToShow: 5
                    },
                    1100: {
                        itemsToShow: 2
                    },
                    0: {
                        itemsToShow: 2
                    }
                }
            }
        };
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    },
    methods: {
        handleSelectOrden(id) {
            this.ordenNew(id);
        },

        async ordenNew(id) {
            try {
                console.log(`Fetching order with ID: ${id}`);
                const response = await this.$http.get(`orden-new/${id}`);

                const orden = response.data.orden;

                console.log("Orden recibida:", orden);

                let exists = this.ordens.some(o => o.id == orden.id);
                console.log("¿La orden ya existe?", exists);

                if (!exists) {
                    this.ordens = [...this.ordens, orden];
                    console.log("Orden agregada:", orden);
                } else {
                    // Update the existing order with new items
                    const existingOrder = this.ordens.find(
                        o => o.id == orden.id
                    );
                    existingOrder.orden_items = orden.orden_items;
                }

                this.ordenSelectedId = orden.id;
                this.ordensItems = [...orden.orden_items]; // Ensure reactivity
                this.currentRef = orden.ref;
                console.log("Orden seleccionada:", orden.id);

                if (typeof this.selectOrden === "function") {
                    this.selectOrden(orden.id);
                    console.log("selectOrden ejecutado correctamente.");
                } else {
                    console.error("selectOrden no está definido.");
                }
            } catch (error) {
                console.error("Error fetching order:", error);
                this.$toast.error("Error al obtener la orden");
            }
        },

        formatedStockPresentation(
            {
                max_quantity,
                item_unit_types,

                unit_type
            },
            stock
        ) {
            let general = Math.trunc(stock / max_quantity);
            let part = ((stock / max_quantity) % 1).toFixed(2);

            let text = `${general} ${unit_type.id}`;
            if (part != 0) {
                let item_unit = item_unit_types.find(
                    i => Number(i.quantity_unit) == Number(max_quantity)
                );
                if (item_unit) {
                    text += ` ${part * max_quantity} ${item_unit.unit_type.id}`;
                }
            }

            return text;
        },
        clickCommand(type) {
            console.log("clickCommand called with type:", type);
            console.log("Current listFoods:", this.listFoods);
            let idxFood = this.listFoods.findIndex(
                food => food.item.id == type.item_id
            );
            console.log("Index found:", idxFood);
            if (idxFood >= 0) {
                this.addFood(idxFood, type);
            }
        },
        nthing() {},
        formatDescriptionType(type) {
            let price = this.getDefaultPrice(type);
            return `${type.description} (${Number(
                type.quantity_unit
            )}) - S/ ${price}`;
        },
        addFood(index = 0, type = null) {
            if (!Array.isArray(this.foods)) {
                console.error("foods is not an array");
                return;
            }

            this.selectedFood = JSON.parse(JSON.stringify(this.foods[index]));

            if (!this.selectedFood) return;

            let unidadMedida = this.selectedFood.item.unit_type_id;
            let internalId = this.selectedFood.item.internal_id;
            let foodFound = this.localOrden.filter(
                f => f.id == this.selectedFood.id
            );

            // Always create a new item if divided_items is true, regardless of stock validation
            if (!this.divided_items) {
                let qty = foodFound.reduce((a, b) => a + Number(b.quantity), 0) + 1;

                // Skip stock validation for ZZ, PACK000, or PLAT000
                if (
                    unidadMedida === "ZZ" ||
                    internalId.startsWith("PACK000") ||
                    internalId.startsWith("PLAT000")
                ) {
                    // Allow unlimited quantity
                } else if (this.configuration.sales_stock === true) {
                    // Validate stock for other items
                    let stock = Number(this.selectedFood.item.stock);
                    if (qty > stock) {
                        this.$toast.warning("Limite de stock alcanzado");
                        return;
                    }
                }
            }

            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                quantity: 1
            };

            this.insertOrden(this.currentFood, this.selectedFood.id, type);
            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                iconClass: "el-icon-food",
                position: "top-right",
                message: "Agregado con éxito",
                position: "bottom-left"
            });

            this.currentFood = {
                food: null,
                observation: null,
                quantity: 0
            };
            this.selectedFood = null;
            this.item = null;
            this.setFalse();
        },

        setFalse() {
            let f = this.foods.map(f => {
                f.select = false;
                return f;
            });
            this.$emit("update:foods", f);
            this.allFalse = true;
        },

        searchOrden(item) {
            console.log(this.input_item);
            this.$emit("update:category", this.category);
            this.$emit("searchOrden", this.input_item);
        },
        clear_input() {
            this.input_item = "";
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },

        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        changePage(currentPage) {
            this.$emit("changePage", currentPage);
        },
        calculateOrden(tab) {
            if (tab.name == "orden") {
                this.$refs.ordenRef.calculateTotal();
            }
        },
        deleteFood(idx) {
            this.localOrden.splice(idx, 1);
        },

        updateOrdens() {
            this.createOrden();
        },
        createOrden() {
            this.ordenTitle = "Nueva Orden";
            this.ordenSelectedId = null;
            this.ordensItems = [];
            this.$refs.ordenRef.open_orders();
        },
        seleccionar_mesa() {
            this.$emit("add", null);
        },
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (type.total == null) {
                this.$toast.error(
                    "Politica de precio sin total: Tomando precio unitario.."
                );
            } else {
                price = Number(type.total);
            }
            return price;
        },
        insertOrden(orden, food_id, type) {
            let ordenAdded = this.localOrden.filter(ord => ord.id == food_id);
            if (ordenAdded.length == 0 || this.divided_items) {
                orden.to_carry = false;
                orden.change_subtotal = false;
                orden.series = [];
                orden.lotes = [];
                orden.type_id = type ? type.id : null;
                orden.type_description = type ? type.description : null;
                orden.type_quantity = type ? Number(type.quantity_unit) : 0;
                
                if (type) {
                    orden.quantity = 1;
                    orden.price = this.getDefaultPrice(type);
                } else {
                    orden.price = orden.food.price;
                }
                if (this.configuration.divided_items) {
                    if (this.divided_items) {
                        orden.will_be_divided = true;
                    }
                }
                this.localOrden.push(orden);
            } else {
                if (type != null) {
                    let indexFind = this.localOrden.findIndex(
                        orden => orden.type_id == type.id
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) +
                            Number(type.quantity_unit);
                    } else {
                        orden.quantity = Number(type.quantity_unit);
                        orden.price = this.getDefaultPrice(type);
                        orden.type_id = type.id;
                        orden.type_description = type.description;
                        orden.to_carry = false;
                        orden.change_subtotal = false;
                        orden.series = [];
                        orden.lotes = [];
                        orden.type_quantity = type
                            ? Number(type.quantity_unit)
                            : 0;
                        if (this.configuration.divided_items) {
                            if (this.divided_items) {
                                orden.will_be_divided = true;
                            }
                        }
                        this.localOrden.push(orden);
                    }
                } else {
                    let indexFind = this.localOrden.findIndex(
                        p => p.id == food_id && p.type_id == null
                    );
                    if (indexFind != -1) {
                        this.localOrden[indexFind].quantity =
                            Number(this.localOrden[indexFind].quantity) + 1;
                    } else {
                        this.localOrden.push(orden);
                    }
                }
                this.localOrden = [...this.localOrden];
            }
            this.$refs.ordenRef.calculateTotal();
        },
        show_orders() {
            this.$refs.ordenRef.view_orders();
        },
        clearTables() {
            this.$emit("add", null);
        },
        filterCategory(id) {
            this.$refs.list_foods.setCategory(id);
        },
        filter_food(value, optionsSelected) {
            this.$refs.list_foods.searchFood(value, optionsSelected);
        },
        selectOrden(id) {
            console.log("selectOrden called with id:", id);
            if (this.changingOrden) {
                this.$emit("changeOrdenEvent", id);
                return;
            }
            this.ordenTitle = `Orden #${id}`;
            this.ordenSelectedId = id;
            this.$emit("addenfoque", null);
            let orden = this.ordens.find(o => o.id == id);
            if (orden.orden_items) {
                this.ordensItems = orden.orden_items;
            } else {
                this.ordensItems = [];
            }
            this.currentRef = orden.ref;
            this.$refs.ordenRef.calculateTotal();
        }
    }
};
</script>
<style>
::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
::-webkit-scrollbar-thumb {
    background-color: var(--primary);
    border-radius: 5px;
    cursor: move;
}
.custom-text-size {
    font-size: 0.8em;
}
</style>
