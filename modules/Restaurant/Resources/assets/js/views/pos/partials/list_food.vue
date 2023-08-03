<template>
    <div>
        <div class="row p-2">
            <h2 class="small-title">Productos</h2>
            <template v-if="listFoods.length == 0">
                <div class="col-12 text-center font-weight-bold">
                    <label>No Hay Productos</label>
                </div>
            </template>

            <template v-else>
                <div class="d-flex flex-wrap">
                    <div
                        class="col-12 col-lg-6 col-xl-4 col-xxl-4 p-1"
                        v-for="(data, index) in foods"
                        :key="index"
                    >
                        <el-tooltip
                            effect="dark"
                            :disabled="
                                data.item.warehouses.length == 1 ||
                                    !configuration.show_stock_establishment_box
                            "
                        >
                            <div slot="content">
                                Stock Almacenes <br />
                                <span
                                    v-for="(info, idx) in data.item.warehouses"
                                    :key="idx"
                                >
                                    <label
                                        v-if="
                                            info.warehouse.id != establishmentId
                                        "
                                    >
                                        <template v-if="data.item.max_quantity">
                                            <!-- {{
                                                `${
                                                    info.warehouse.description
                                                }: ${Number(info.stock) /
                                                    data.item.max_quantity}`
                                            }} -->
                                            {{
                                                formatedStockPresentation(
                                                    data.item,
                                                    info.stock
                                                )
                                            }}
                                        </template>
                                        <template v-else>
                                            {{
                                                `${
                                                    info.warehouse.description
                                                }: ${Number(info.stock).toFixed(
                                                    2
                                                )}`
                                            }}
                                        </template> </label
                                    ><br />
                                </span>
                            </div>
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
                                style="height: 190px;"
                            >
                                <div @click="addFood(index)">
                                    <div>
                                        <span
                                            class="lead-font-weight-700 d-inline-block text-truncate"
                                        >
                                            {{ data.description.toUpperCase() }}
                                        </span>
                                        <el-tooltip
                                            class="item"
                                            effect="dark"
                                            :content="
                                                data.description.toUpperCase()
                                            "
                                            placement="top-start"
                                        >
                                            <i class="fas fa-ellipsis-h"></i>
                                        </el-tooltip>
                                    </div>
                                    <div
                                        class="d-flex align-items-end justify-content-between"
                                    >
                                        <div class="p-1">
                                            <div
                                                class="icon-container"
                                                style="  height: 64px;  width: 64px;"
                                            >
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
                                                            class="thumbail"
                                                            style="  max-height: 69px;  max-width: 69px;"
                                                        />
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            {{ data.code }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between"
                                    style="padding-right: 10px; margin-top: 2px"
                                >
                                    <div
                                        class="d-flex flex-column align-items-end"
                                    >
                                        <!-- <div class="text-uppercase font-weight-light h5">
                                                {{ data.category.name }}
                                            </div> -->
                                        <div class="block mb-2">
                                            <span
                                                class="time font-weight-light"
                                            >
                                                <span
                                                    class="text-muted lead-font-weight-700"
                                                >
                                                    S/
                                                    {{ data.price }}</span
                                                >
                                            </span>
                                        </div>
                                        <div></div>
                                    </div>
                                    <div v-if="data.types.length > 0">
                                        <el-dropdown @command="clickCommand">
                                            <span class="el-dropdown-link">
                                                Precios<i
                                                    class="el-icon-arrow-down el-icon--right"
                                                ></i>
                                            </span>
                                            <el-dropdown-menu slot="dropdown">
                                                <el-dropdown-item
                                                    v-for="(type,
                                                    idx) in data.types"
                                                    :key="idx"
                                                    :command="type"
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
                                    <div class="d-flex justify-content-center m-1"
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
                                                            : 'primary'
                                                    }`
                                                "
                                            >
                                                Fecha de vencimiento:
                                                {{ data.item.date_of_due }}
                                            </el-tag>
                                        </div>
                                <div
                                    v-if="data.item.is_set == 0"
                                    class="row justify-content-end "
                                    style="margin-left: 2px; margin-right: 2px; margin-bottom: 2px;"
                                >
                                    <template v-if="data.item.stock > 0">
                                        <span
                                            class="badge rounded-pill bg-primary m-l-0"
                                            style="text-align: center !important"
                                            >Stock
                                            <template
                                                v-if="data.item.max_quantity"
                                            >
                                                {{
                                                    formatedStockPresentation(
                                                        data.item,
                                                        data.item.stock
                                                    )
                                                }}
                                                <!-- {{
                                                    parseFloat(
                                                        data.item
                                                            .stock /
                                                            data
                                                                .item
                                                                .max_quantity
                                                    )
                                                }} -->
                                            </template>
                                            <template v-else>
                                                {{
                                                    parseFloat(data.item.stock)
                                                }}
                                            </template>
                                        </span>
                                    </template>
                                    <template v-else>
                                        <span
                                            class="badge rounded-pill bg-danger m-l-0"
                                            style="text-align: center !important"
                                        >
                                            Agotado
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </el-tooltip>
                    </div>
                    <!-- hasta aqui -->
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "foods",
        "configuration",
        "worker",
        "pagination",
        "blockAdd",
        "localOrden",

        "barcode"
    ],
    data() {
        return {
            selectCategory: 0,
            activeName: "menu",
            loading: true,
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
            establishmentId: this.worker.establishment_id,
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
            },
            screenWidth: 0
        };
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);

        if (this.foods.length > 0) {
            this.loading = false;
        }
    },
    watch: {
        foods(__, _) {
            this.updateListFoods();
        }
    },
    created() {
        this.ordenItems = [];
        this.orden = [];
        this.updateListFoods();
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
        handleResize() {
            this.screenWidth = window.innerWidth;
        },
        nthing() {},
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

        clickCommand(type) {
            let idxFood = this.listFoods.findIndex(
                food => food.item.id == type.item_id
            );
            if (idxFood >= 0) {
                this.addFood(idxFood, type);
            }
        },
        updateListFoods() {
            this.listFoods = this.foods.map(f => {
                f.price = Number(f.price).toFixed(2);
                return { ...f, select: false };
            });
            if (this.barcode && this.listFoods.length == 1) {
                this.addFood(0);
            }
        },
        formatedStockPresentation(
            {
                max_quantity,
                item_unit_types,
                max_quantity_description,
                unit_type
            },
            stock
        ) {
            // let item_unit = item_unit_types.find(
            //     i => Number(i.quantity_unit) == Number(max_quantity)
            // );
            // let general = 0;
            // if (item_unit) {
            //     general = Math.trunc(stock / max_quantity);
            // } else {
            //     general = stock / max_quantity;
            // }
            // let part = ((stock / max_quantity) % 1).toFixed(2);
            // let part_general = general.toString().split(".");

            // if (part_general.length > 1 && part_general[1].length > 2) {
            //     general = general.toFixed(2);
            // }
            // let text = `${general} ${unit_type.id}`;
            // if (part != 0) {
            //     if (item_unit) {
            //         text += ` ${part * max_quantity} ${item_unit.unit_type.id}`;
            //     } else {
            //         text = `${general} ${max_quantity_description ||
            //             unit_type.id}`;
            //     }
            // } else {
            //     text = `${general} ${max_quantity_description || unit_type.id}`;
            // }

            // return text;
            let general = Math.trunc(stock / max_quantity);
            let part = ((stock / max_quantity) % 1).toFixed(2);

            let text = `${general} ${unit_type.id}`;
            if (part != 0) {
                let item_unit = item_unit_types.find(
                    i => Number(i.quantity_unit) == Number(max_quantity)
                );
                let part = (stock / max_quantity) % 1;
                if (item_unit) {
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${item_unit.unit_type.id}`;
                }
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                    let new_part = part * max_quantity;
                    new_part = new_part.toFixed(2);
                    text += ` ${new_part} ${unit_type.id}`;
                }
            } else {
                if (max_quantity && max_quantity_description) {
                    text = `${general} ${max_quantity_description}`;
                }
            }

            return text;
        },
        getRecords() {
            let currentPage = this.pagination.current_page;
            this.$emit("changePage", currentPage);
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
        async setItemCheckStock(id,quantity) {
            //item-sets/check/{id}
            let pass = true;
            const response = await this.$http.get(`/item-sets/check/${id}/${quantity}`);
            if(response.status == 200){
                const {success,message} = response.data;
                if(!success){
                    this.$toast.error(message);
                    pass = false;
                }
            }
            console.log(response);
            return pass;
        },
       async addFood(index = 0, type = null) {
      
            if (this.blockAdd && !this.configuration.box_orden) {
                this.$toast.error("No puede agregar productos a esta orden.");
                return;
            }
            this.selectedFood = JSON.parse(
                JSON.stringify(this.listFoods[index])
            );

            if (!this.selectedFood) return;
            
            let foodFound = this.localOrden.filter(
                f => f.id == this.selectedFood.id
            );

            if (this.selectedFood.item.is_set == 1) {
                if (this.configuration.sales_stock == true) {
                    let qty = 1;
                    if(foodFound.length != 0){
                        qty = foodFound.reduce((a, b) => a + Number(b.quantity), 0);
                        qty += 1;
                    }
                    let pass = await this.setItemCheckStock(this.selectedFood.item.id,qty);
                    if(!pass){
                        return;
                    }
                }
            } else {
                if (
                    Number(this.selectedFood.item.stock) <= 0 &&
                    this.configuration.sales_stock == true
                ) {
                    this.$toast.warning("Stock insuficiente");
                    return;
                }
            }

            // let foodFound = this.localOrden.filter(
            //     f => f.id == this.selectedFood.id
            // );

            if (foodFound.length != 0) {
                let { item } = this.selectedFood;
                if (item.lots_enabled) {
                    if (item.item_unit_types.length == 0) {
                        let message = "Producto con lote, ya  agregado";
                        this.$toast.warning(message);
                        return;
                    }
                }

                if (item.series_enabled) {
                    if (item.item_unit_types.length == 0) {
                        let message = "Producto con serie, ya  agregado";
                        this.$toast.warning(message);
                        return;
                    } else {
                        if (type) {
                            if (foodFound.some(i => i.type_id == type.id)) {
                                let message =
                                    "Producto con serie, ya  agregado";
                                this.$toast.warning(message);
                                return;
                            }
                        }
                    }
                }
                let qty = foodFound.reduce((a, b) => a + Number(b.quantity), 0);

                if (type) {
                    // qty += Number(type.quantity_unit);

                    qty += 1;
                } else {
                    qty += 1;
                }
                if (this.configuration.sales_stock == true && this.selectedFood.item.is_set == 0) {
                    if (qty > Number(this.selectedFood.item.stock)) {
                        this.$toast.warning("Limite de stock alcanzado");
                        return;
                    }
                }
            } else {
                if (type) {
                    let qty = type.quantity_unit;
                    if (this.configuration.sales_stock == true && this.selectedFood.item.is_set == 0) {
                        let stock = Number(this.selectedFood.item.stock);
                        if ( qty > stock) {
                            this.$toast.warning("Limite de stock alcanzado");
                            return;
                        }
                    }
                }
            }

            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: this.selectedFood.price,
                quantity: !!this.selectedFood.item.series_enabled ? 0 : 1
            };
            this.$emit(
                "insertOrden",
                this.currentFood,
                this.selectedFood.id,
                type
            );
            this.$notify({
                title: this.currentFood.food.description.toLowerCase(),
                duration: 800,
                iconClass: "el-icon-food",
                message: "Agregado con èxito",
                position: "bottom-left"
            });

            this.currentFood = {
                food: null,
                observation: null,
                quantity: 0,
                price: 0
            };
            this.selectedFood = null;
            this.item = null;
            //this.setFalse();
            this.$emit("buscarnuevo");
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
        searchFoodCategories(value) {
            if (value == 0) {
                this.listFoods = this.foods;
            } else {
                this.listFoods = _.filter(this.foods, {
                    category_food_id: value
                });
            }
        },
        searchFood(value = null, optionsSelected = "Descripcion") {
            !this.allFalse && this.setFalse();
            if (value) {
                if (optionsSelected == "Descripcion") {
                    this.listFoods = this.foods.filter(f =>
                        f.description.toLowerCase().includes(value)
                    );
                } else {
                    //this.listFoods=_.filter(this.foods,{'code':value})
                    this.listFoods = this.foods.filter(ff =>
                        ff.code.toLowerCase().includes(value)
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
                if (!this.categories.some(c => c.id == 0)) {
                    this.categories.unshift({
                        id: 0,
                        description: "todos"
                    });
                }
                this.listFoods = this.foods.map(f => ({ ...f, select: false }));
                this.title = `Mesa N°${this.table.number}`;
            }
        }
    }
};
</script>
