<template>
    <div>
        <div class="row" v-if="ordens.length > 0">
            <div class="col-12 p-1">
                <h2 class="small-title">Ordenes Realizados</h2>
                <hooper :settings="hooperSettings">
                    <slide v-for="(o, index) in ordens" :key="index">
                        <div class="col-md-12 p-2">
                            <div class="card_profile" :class="ordenSelectedId == o.id ? 'bg-active' : ''
                                " @click="
        selectOrden(o.id);
    show_orders();
    ">
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
            <div v-if="screenWidth > 678" class="col-md-5 col-xl-8 col-lg-6 p-1">
                <list-food ref="list_foods" @insertOrden="insertOrden" :configuration="configuration"
                    :pagination="pagination" :table="table" :categories="categories" :showMenu.sync="showMenu"
                    :localOrden.sync="localOrden" :foods.sync="foods" @changePage="changePage"></list-food>
            </div>
            <!--  inicio sidebar -->
            <div v-else><!-- Modo Celular/ Movil -->
                <div class="d-flex flex-wrap ">
                    <button type="button" class="btn settings-button btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#settings" id="settingsButton">
                        <i class="fas fa-shopping-basket"></i>
                    </button>
                    <div class="modal fade modal-right scroll-out-negative" id="settings" data-bs-backdrop="true"
                        tabindex="-1" role="dialog" aria-labelledby="settings" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable full" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" style="color: var(--light-text) !important;"> Visualizacion de
                                        Productos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding-right: 2px;">
                                    <div class="scroll-track-visible" style="overflow-y: auto;">
                                        <div class="row ">
                                            <div class="col-12">
                                                <template>
                                                    <h2 class="text-muted text-small">
                                                        Categorias
                                                    </h2>
                                                    <el-select v-model="category" filterable clearable
                                                        placeholder="Selecionar aqui...." @change="searchOrden(category)">
                                                        <el-option v-for="item in categories" :key="item.id"
                                                            :label="item.name" :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </template>
                                            </div>
                                            <div class="col-12 ">
                                                <h2 class="text-muted text-small">
                                                    Buscar
                                                </h2>
                                                <el-input ref="input_item" size="small" v-model="input_item"
                                                    @input="searchOrden()" @focus="clear_input()" autofocus
                                                    placeholder="Ingrese aca Un Producto">
                                                    <el-button slot="append" icon="el-icon-search"
                                                        @click="searchOrden()"></el-button>
                                                </el-input>
                                            </div>
                                            <div class="row d-flex flex-wrap">
                                                <div class="col-12  p-1" v-for="(data, index) in foods" :key="index">


                                                    <div id="card" class="
                                                                    overflow-hidden
                                                                    coupon
                                                                    rounded
                                                                    d-flex
                                                                    flex-column
                                                                    justify-content-between
                                                                    p-1
                                                                    "
                                                        style="height: 112px; width: 297px ; margin-left: 9px; ">
                                                        <div @click="addFood(index)">
                                                            <div>
                                                                <span class="lead-font-weight-700 h5">
                                                                    {{ data.description.toUpperCase() }}
                                                                </span>
                                                            </div>
                                                            <div class="d-flex align-items-end justify-content-between">
                                                                <div class="p-1">
                                                                    <div class="icon-container">
                                                                        <div class="icon-container_box">
                                                                            <template
                                                                                v-if="data.image == 'imagen-no-disponible.jpg'">
                                                                                <img hidden
                                                                                    src="/images/imagen-no-disponible.jpg"
                                                                                    alt="User Img" class="thumbail" />
                                                                            </template>
                                                                            <template v-else>
                                                                                <img :src="formatUrlImage(data.image)"
                                                                                    class="thumbail" />
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    {{ data.code }}
                                                                </div>
                                                                <div class="d-flex flex-column align-items-end">

                                                                    <div class="block mb-2">
                                                                        <span class="time font-weight-light">
                                                                            <span class="text-muted lead-font-weight-700">
                                                                                S/
                                                                                {{ data.price }}</span>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <template v-if="data.item.stock > 0">
                                                                            <span
                                                                                class="badge rounded-pill bg-primary m-l-0">Stock
                                                                                <template v-if="data.item.max_quantity">
                                                                                    {{
                                                                                        formatedStockPresentation(
                                                                                            data.item,
                                                                                            data.item.stock
                                                                                        )
                                                                                    }}  
                                                                                </template>
                                                                                <template v-else>
                                                                                    {{ parseFloat(data.item.stock) }}
                                                                                </template>
                                                                            </span>
                                                                        </template>
                                                                        <template v-else>
                                                                            <span
                                                                                class="badge rounded-pill bg-danger m-l-0">
                                                                                Agotado
                                                                            </span>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div @click="nthing" v-if="data.types.length > 0"
                                                            class="d-flex justify-content-end"
                                                            style="padding-right: 10px; margin-top: 5px">
                                                            <el-dropdown @command="clickCommand">
                                                                <span class="el-dropdown-link">
                                                                    Precios<i class="el-icon-arrow-down el-icon--right"></i>
                                                                </span>
                                                                <el-dropdown-menu slot="dropdown">
                                                                    <el-dropdown-item v-for="(type, idx) in data.types"
                                                                        :key="idx" :command="type">
                                                                        {{ formatDescriptionType(type) }}
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


            </div><!-- sidebarmodal fin  -->

            <!-- fin de sidebar -->
            <div class="col-md-7 col-xl-4 col-lg-6 p-1">
                <current-orden ref="ordenRef" :referencia.sync="currentRef" :tableId="table.id"
                    :configuration.sync="configuration" :localOrden.sync="localOrden" :ordens.sync="ordensItems"
                    :ordenSelectedId.sync="ordenSelectedId" @updateOrdens="updateOrdens" @deleteFood="deleteFood"
                    @ordenDeleted="createOrden" @listtables="clearTables">
                </current-orden>
            </div>
        </div>
    </div>
</template>
<script></script>
<style>
    ::-webkit-scrollbar {
        width: 5px;
        height: 5px;
        
    }
    ::-webkit-scrollbar-thumb {
        background-color: var(--primary);
        border-radius: 5px;
        cursor:move;
    }
</style>
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
            allFalse: true,
            currentFood: {},
            input_item: '',
            category: null ,
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
    mounted(){
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    }, 
    methods: {

        addFood(index = 0, type = null) {

            
            
            this.selectedFood = JSON.parse(
                JSON.stringify(this.foods[index])
            );
            
            
            if (!this.selectedFood) return;
            let foodFound = this.localOrden.filter(
                f => f.id == this.selectedFood.id
            );
            
            if (foodFound.length != 0) {
                let qty = foodFound.reduce((a, b) => a + Number(b.quantity), 0);
                if (type) {
                    // qty += Number(type.quantity_unit);
                    qty += 1;
                } else {
                    qty += 1;
                }
                if (this.configuration.sales_stock == true) {
                    if (qty > Number(this.selectedFood.item.stock)) {
                        this.$toast.warning("Limite de stock alcanzado");
                        return;
                    }
                }
            } else {
                if (type) {
                    let qty = type.quantity_unit;
                    if (this.configuration.sales_stock == true) {
                        let stock = Number(this.selectedFood.item.stock);
                        if (qty == stock || qty > stock) {
                            this.$toast.warning("Limite de stock alcanzado");
                            return;
                        }
                    }
                }
            }
            (this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                quantity: 1
            }),
                this.insertOrden(
                    
                    this.currentFood,
                    this.selectedFood.id,
                    type
                );
            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                iconClass: "el-icon-food",
                position: "top-right",
                message: "Agregado con èxito",
                position: "bottom-left"
            });
            //this.orden.push(this.currentFood);
            this.currentFood = {
                food: null,
                observation: null,
                quantity: 0
            };
            this.selectedFood = null;
            this.item = null;
            this.setFalse();

            //this.$forceUpdate();
        },
        setFalse() {
            this.foods = this.foods.map(f => {
                f.select = false;
                return f;
            });
            this.allFalse = true;
        },
        

        searchOrden(item){
            console.log(this.input_item)
            this.$emit("update:category",this.category)
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
