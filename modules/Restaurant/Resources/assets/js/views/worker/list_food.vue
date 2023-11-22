<template>
    <div>
        <div v-if="screenWidth > 678" class="row p-2">
            <h2 class="small-title">Productos</h2>
            <template v-if="listFoods.length == 0">
                <div class="col-12 text-center font-weight-bold">
                    <label>No Hay Productos</label>
                </div>
            </template>
            <template v-else>
                <div class="d-flex flex-wrap">
                    <!-- copiar desde aqui -->
                    <div
                        class="col-12 col-lg-6  col-xl-6 col-xxl-4 p-1"
                        v-for="(data, index) in listFoods"
                        :key="index"
                    >
                        <!--  -->
                        <div
                            id="card"
                            class="overflow-hidden coupon rounded  d-flex flex-column  justify-content-between p-1"
                        >
                            <div @click="addFood(index)">
                                <div>
                                    <span class="lead-font-weight-700 h5">
                                        {{ data.description.toUpperCase() }}
                                    </span>
                                </div>
                                <div
                                    class="d-flex align-items-end justify-content-between"
                                >
                                    <div class="p-1">
                                        <div class="icon-container ">
                                            <div class="icon-container_box">
                                                <template
                                                    v-if="
                                                        data.image ==
                                                            'imagen-no-disponible.jpg'
                                                    "
                                                >
                                                    <img
                                                        src="/images/imagen-no-disponible.jpg"
                                                        alt="User Img"
                                                        class="thumbail"
                                                    />
                                                </template>
                                                <template v-else>
                                                    <img
                                                        :src="
                                                            formatUrlImage(
                                                                data.image
                                                            )
                                                        "
                                                        class=" thumbail"
                                                    />
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        {{ data.code }}
                                    </div>
                                    <div
                                        class="d-flex flex-column align-items-end"
                                    >
                                        <div
                                            class="text-uppercase font-weight-light h5"
                                        >
                                            {{ data.category.name }}
                                        </div>
                                        <div class="block mb-2">
                                            <span
                                                class="time font-weight-light"
                                            >
                                                <span
                                                    class="text-muted lead-font-weight-700"
                                                >
                                                    S/ {{ data.price }}</span
                                                >
                                            </span>
                                        </div>
                                        <div
                                            v-if="
                                                data.item.lots_enabled == 1 &&
                                                    data.item.date_of_due
                                            "
                                        >
                                            <el-tag
                                                :type="
                                                    `${
                                                        isExpired(
                                                            data.item
                                                                .date_of_due
                                                        )
                                                            ? 'danger'
                                                            : 'success'
                                                    }`
                                                "
                                            >
                                                Fecha de vencimiento:
                                                {{ data.item.date_of_due }}
                                            </el-tag>
                                        </div>
                                        <div>
                                           <template v-if="data.item.is_set == 0 && data.item.unit_type_id != 'ZZ'">
                                             <template
                                                v-if="data.item.stock > 0"
                                            >
                                                <span
                                                    class="badge rounded-pill bg-primary m-l-0"
                                                    >Stock
                                                    {{
                                                        parseFloat(
                                                            data.item.stock
                                                        )
                                                    }}
                                                </span>
                                            </template>
                                            <template v-else>
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
                                v-if="data.types.length > 0"
                                class="d-flex justify-content-end"
                                style="padding-right:5px;margin-top:5px;"
                            >
                                <el-dropdown @command="clickCommand">
                                    <span class="el-dropdown-link">
                                        Precios<i
                                            class="el-icon-arrow-down el-icon--right"
                                        ></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item
                                            v-for="(type, idx) in data.types"
                                            :key="idx"
                                            :command="type"
                                        >
                                            {{ formatDescriptionType(type) }}
                                        </el-dropdown-item>
                                    </el-dropdown-menu>
                                </el-dropdown>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                    <!-- hasta aqui -->
                </div>
            </template>
        </div>

        <view-image
            :image="currentImage"
            :showDialog.sync="showImage"
        ></view-image>
        <el-pagination
            @current-change="getRecords"
            layout="total, prev, pager, next"
            :total="pagination.total"
            :current-page.sync="pagination.current_page"
            :page-size="Number(pagination.per_page)"
        >
        </el-pagination>
    </div>
</template>

<script>
import ViewImage from "./image.vue";
export default {
    props: [
        "table",
        "pagination",
        "localOrden",
        "showMenu",
        "categories",
        "foods",
        "configuration"
    ],
    components: { ViewImage },
    data() {
        return {
             input_item: '',
            category: null ,
            screenWidth: 0,
            selectCategory: 0,
            activeName: "menu",
            ordenItems: [],
            orden: [],
            currentFood: {},
            item: null,
            search: "Buscar por Codigo",
            currentImage: null,
            showImage: false,
            listFoods: [],
            selectedFood: null,
            allFalse: true,
            title: null,
            total: null,
            ordenId: null,
            optionsSelected: 0,
            generalOrdens: 1,
            settings: {
                dots: false,
                dotsClass: "slick-dots custom-dot-class",
                edgeFriction: 0.35,
                infinite: false,
                speed: 500,
                centerMode: true,
                centerPadding: "10px",
                focusOnSelect: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                swipeToSlide: true,
                speed: 500,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            initialSlide: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            },
            settings_tables: {
                dots: true,
                dotsClass: "slick-dots custom-dot-class",
                infinite: false,
                speed: 500,
                centerMode: true,
                centerPadding: "10px",
                focusOnSelect: true,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                swipeToSlide: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            initialSlide: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            }
        };
    },
    created() {
        this.ordenItems = [];
        this.orden = [];
        if (this.table.length != 0) {
            this.ordenItems = this.table.orden.orden_items;
            this.ordenId = this.table.orden.id;
            setTimeout(() => this.calculateOrden(), 50);
        }
        // if (!this.categories.some((c) => c.id == 0)) {
        //   this.categories.unshift({
        //     id: 0,
        //     name: "todos",

        //   });
        // }
        this.listFoods = this.foods.map(f => ({ ...f, select: false }));
        this.title = `Mesa N°${this.table.number}`;
    },
    watch: {
        foods(newFoods, _) {
            this.listFoods = newFoods;
        }
    },
    mounted(){
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    },
    methods: {
        isExpired(date){
            let today = new Date();
            let dateOfDue = new Date(date);
            if(today > dateOfDue){
                return true;
            }
            return false;
    
        },
        getDefaultPrice(type) {
            let listPricesDescription = ["price1", "price2", "price3"];
            let currentPriceIndx =
                listPricesDescription[type.price_default - 1];
            let price = type[currentPriceIndx];
            if (type.total == null) {
                // this.$toast.error(
                //     "Politica de precio sin total: Tomando precio unitario.."
                // );
            } else {
                price = Number(type.total);
            }
            return price;
        },
        formatDescriptionType(type) {
            let price = this.getDefaultPrice(type);
            return `${type.description} (${Number(
                type.quantity_unit
            )}) - S/ ${price}`;
        },
        getRecords() {
            let currentPage = this.pagination.current_page;
            this.$emit("changePage", currentPage);
        },
        clickCommand(type) {
            let idxFood = this.listFoods.findIndex(
                food => food.item.id == type.item_id
            );
            if (idxFood >= 0) {
                this.addFood(idxFood, type);
            }
        },
        deleteOrden(id) {
            this.ordenItems = this.ordenItems.filter(o => o.id != id);
        },
        calculateOrden() {
            // this.$refs.ordenRef.calculateTotal();
        },
        selectSearch(value) {
            this.optionsSelected = value;
        },

        deleteFood(idx) {
            this.orden.splice(idx, 1);
        },
        setCategory(id) {
            this.selectCategory = id;
            !this.allFalse && this.setFalse();
            if (id == 0) {
                this.listFoods = this.foods;
            } else {
                this.listFoods = [];
                this.listFoods = _.filter(this.foods, { category_food_id: id });
            }
        },
        addFood(index = 0, type = null) {
            this.selectedFood = JSON.parse(
                JSON.stringify(this.listFoods[index])
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
                    let qty = Number( type.quantity_unit);
                    if (this.configuration.sales_stock == true) {
                        let stock = Number(this.selectedFood.item.stock);
                        console.log(qty," as ",stock," sa" );
                        if ( qty > stock) {
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
                this.$emit(
                    "insertOrden",
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
            this.listFoods = this.listFoods.map(f => {
                f.select = false;
                return f;
            });
            this.allFalse = true;
        },
        selectFood(index) {
            //  this.$refs.description.$el.getElementsByTagName("input")[0].focus();
            if (this.listFoods[index].select) {
                this.listFoods[index].select = false;
                this.allFalse = true;
                this.selectedFood = null;
                return;
            }

            !this.allFalse && this.setFalse();
            this.listFoods[index].select = true;
            this.selectedFood = this.listFoods[index];
            this.allFalse = false;
        },
        searchFood(value = null, optionsSelected = 0) {
            !this.allFalse && this.setFalse();
            if (value) {
                if (optionsSelected == 0) {
                    this.listFoods = this.foods.filter(f =>
                        f.description.toLowerCase().includes(value)
                    );
                } else {
                    this.listFoods = this.foods.filter(f =>
                        f.code.toLowerCase().includes(value)
                    );
                }
            } else {
                this.listFoods = this.foods;
            }
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        viewImage(url) {
            this.currentImage = null;
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            this.currentImage = `/${formated}`;

            this.showImage = true;
        },
        open() {
            this.ordenItems = [];
            this.orden = [];
            if (this.table.orden.length != 0) {
                this.ordenItems = this.table.orden.orden_items;

                // this.activeName = "orden";
                this.ordenId = this.table.orden.id;
                setTimeout(() => this.calculateOrden(), 50);
            }
            if (!this.categories.some(c => c.id == 0)) {
                this.categories.unshift({
                    id: 0,
                    description: "todos"
                });
            }
            this.listFoods = this.foods.map(f => ({ ...f, select: false }));
            this.title = `Mesa N°${this.table.number}`;
        },
        close() {
            this.ordenId = null;
            this.$emit("update:showMenu", false);
            this.$emit("update:currentTable", null);
        }
    }
};
</script>
