<template>
    <div>
        <div class="row" v-if="ordens.length > 0">
            <div class="col-12 p-1">
                <h2 class="small-title">Ordenes Realizados</h2>
                <hooper :settings="hooperSettings">
                    <slide v-for="(o, index) in ordens" :key="index">
                        <div class="col-md-12 p-2">
                            <div
                                class="card_profile"
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
            <div class="col-md-5 col-xl-8 col-lg-6 p-1">
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
                    @changePage="changePage"
                ></list-food>
            </div>

            <div class="col-md-7 col-xl-4 col-lg-6 p-1">
                <current-orden
                    ref="ordenRef"
                    :referencia.sync="currentRef"
                    :tableId="table.id"
                    :configuration.sync="configuration"
                    :localOrden.sync="localOrden"
                    :ordens.sync="ordensItems"
                    :ordenSelectedId.sync="ordenSelectedId"
                    @updateOrdens="updateOrdens"
                    @deleteFood="deleteFood"
                    @ordenDeleted="createOrden"
                    @listtables="clearTables"
                >
                </current-orden>
            </div>
        </div>
    </div>
</template>
<script></script>
<style scoped></style>
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
        "tables_row_select"
    ],
    created() {
        this.ordens = this.table.orden;
    },
    watch: {
        table(newTable, _) {
            this.ordens = newTable.orden;
        }
    },
    data() {
        return {
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
    methods: {
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
        clean() {
            if (this.selectOrden) {
                let exist = this.ordens.find(o => o.id == this.selectOrden);
                if (!exist) {
                    this.createOrden();
                }
            }
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
            if (ordenAdded.length == 0) {
                orden.to_carry = false;
                orden.change_subtotal = false;
                orden.series = [];
                orden.lotes = [];
                orden.type_id = type ? type.id : null;
                orden.type_description = type ? type.description : null;
                orden.type_quantity = type ? Number(type.quantity_unit) : 0;
                //si es el primer registro del prod en la lista
                if (type) {
                    // orden.quantity = Number(type.quantity_unit);
                    orden.quantity = 1;
                    orden.price = this.getDefaultPrice(type);
                } else {
                    orden.price = orden.food.price;
                }

                this.localOrden.push(orden);
            } else {
                if (type != null) {
                    //si es, verificar si ya existe esa presentación en la lista
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
                        this.localOrden.push(orden);
                    }

                    //y si no agregarla como nueva
                } else {
                    //si es original, seguir agregando uno
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
            // let index_find = _.findIndex(this.localOrden, { id: fodd_id });
            // if (index_find == -1) {
            //     this.localOrden.push(orden);
            // } else {
            //     this.localOrden[index_find].quantity =
            //         this.localOrden[index_find].quantity + 1;
            // }
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
