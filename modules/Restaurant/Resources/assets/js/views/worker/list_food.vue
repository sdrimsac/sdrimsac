<!-- Listfood Mozo -->
<template>
    <div>
        <div v-if="screenWidth > 678" class="row p-2">
            <h2 class="small-title">Productos</h2>
            <template v-if="Array.isArray(listFoods) && listFoods.length == 0">
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
                            class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-light"
                            :style="`${configuration.trunc_txt ? 'min-height:190px;' : 'height:210px;'}`"
                        >
                            <div @click="addFood(index)">
                                <!-- Barra superior: código + precio -->
                                <div class="d-flex justify-content-between align-items-center"
                                    style="width:100%;padding:0;margin-top:1px;margin-bottom:0;">
                                    <div>
                                        <span style="font-size:1.1em;">{{ data.code }}</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-end" style="flex:1;">
                                        <div class="block mb-2">
                                            <span class="time font-weight-light">
                                                <span class="lead-font-weight-500"
                                                    style="font-weight:bold;font-family:'Arial Black', Arial, sans-serif;">
                                                    {{ data.currency }}
                                                    <span style="font-size:1.5em;">{{ data.price }}</span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="overflow-hidden coupon rounded d-flex flex-column justify-content-between p-1 bg-primary text-white">
                                    <el-tooltip class="item" effect="dark" :content="data.description.toUpperCase()"
                                        placement="top-start">
                                        <span :class="`lead-font-weight-700 ${configuration.trunc_txt
                                                ? 'd-inline-block text-truncate'
                                                : ''
                                            }`">
                                            {{ data.description.toUpperCase() }}
                                        </span>
                                    </el-tooltip>
                                </div>

                                <div class="row">
                                    <!-- Imagen -->
                                    <div class="col-4">
                                        <div
                                            style="height:120px;width:120px;display:flex;align-items:center;justify-content:center;">
                                            <template v-if="data.image == 'imagen-no-disponible.jpg'">
                                                <img src="/images/imagen-no-disponible.jpg"
                                                    style="width:100%;height:100%;object-fit:contain;display:block;" />
                                            </template>
                                            <template v-else>
                                                <img :src="formatUrlImage(data.image)"
                                                    style="width:100%;height:120%;object-fit:contain;display:block;" />
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Detalles derecha -->
                                    <div class="col-8">
                                        <!-- Categoría -->
                                        <div class="d-flex justify-content-end align-items-center"
                                            style="text-align:right;margin-right:4px;">
                                            <span class="text-uppercase font-weight-light h5">
                                                {{ data.category.name }}
                                            </span>
                                        </div>

                                        <!-- Dropdown de precios -->
                                        <div v-if="data.types && data.types.length > 0"
                                            style="width:100%;display:flex;justify-content:flex-end;">
                                            <el-dropdown @command="clickCommand">
                                                <span class="el-dropdown-link"
                                                    style="color:green;font-weight:bold;">
                                                    Precios
                                                    <i class="el-icon-arrow-down el-icon--right"></i>
                                                </span>
                                                <el-dropdown-menu slot="dropdown" class="custom-dropdown-menu"
                                                    style="min-width:200px;">
                                                    <el-dropdown-item v-for="(type, idx) in data.types" :key="idx"
                                                        :command="type" class="custom-dropdown-item">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <div>
                                                                <span class="font-weight-bold"
                                                                    style="color:#073f68;">
                                                                    {{ type.description.toUpperCase() }}
                                                                </span>
                                                                <span class="small text-muted ml-2">
                                                                    ( {{ Number(type.quantity_unit) }} )
                                                                </span>
                                                            </div>
                                                            <span class="badge ml-3"
                                                                style="font-size:1em;min-width:30px;text-align:right;color:#000;">
                                                                S/ {{ Number(getDefaultPrice(type)).toFixed(2) }}
                                                            </span>
                                                        </div>
                                                    </el-dropdown-item>
                                                </el-dropdown-menu>
                                            </el-dropdown>
                                        </div>

                                        <!-- Fecha de vencimiento -->
                                        <div v-if="data.item.lots_enabled == 1 && data.item.date_of_due">
                                            <el-tag
                                                :type="`${
                                                    isExpired(data.item.date_of_due)
                                                        ? 'danger'
                                                        : 'success'
                                                }`"
                                            >
                                                Fecha de vencimiento:
                                                {{ data.item.date_of_due }}
                                            </el-tag>
                                        </div>

                                        <!-- Stock -->
                                        <div v-if="data.item.is_set == 0 && data.item.unit_type_id != 'ZZ' && configuration.show_stock_cash == true"
                                            class="cold-12 d-flex justify-content-end"
                                            style="margin:0 2px 2px 2px;text-align:right;">
                                            <template v-if="data.item.stock > 0">
                                                <span class="badge rounded-pill bg-primary m-l-0">
                                                    Stock {{ parseFloat(data.item.stock) }}
                                                </span>
                                            </template>
                                            <template v-else>
                                                <span class="badge rounded-pill bg-danger m-l-0">
                                                    Agotado
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
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
        "configuration",
        "divided_items"  // Add this prop to receive divided_items setting
    ],
    components: {
        ViewImage
    },
    data() {
        return {
            input_item: "",
            category: null,
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
            listFoods: [], // Ensure listFoods is initialized as an array
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
        this.listFoods = Array.isArray(this.foods)
            ? this.foods.map(f => ({
                  ...f,
                  price: f.price ? Number(f.price) : 0,
                  select: false
              }))
            : [];
        this.title = `Mesa N°${this.table.number}`;
        this.$root.$on("productoRecibido", this.agregarProducto);
    },
    watch: {
        foods(newFoods, _) {
            this.listFoods = Array.isArray(newFoods) 
                ? newFoods.map(f => ({
                    ...f,
                    price: f.price ? Number(f.price) : 0
                })) 
                : [];
        },
        listFoods(newVal) {
            if (newVal === null) {
                console.error("listFoods has become null");
            }
        }
    },
    mounted() {
        this.screenWidth = window.innerWidth;
        window.addEventListener("resize", this.handleResize);
    },
    methods: {
        isExpired(date) {
            let today = new Date();
            let dateOfDue = new Date(date);
            if (today > dateOfDue) {
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
                price = Number(type.total);
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
            // this.$refs.ordenRef.calculateTotal();
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
                this.listFoods = _.filter(this.foods, {
                    category_food_id: id
                });
            }
        },
        addFood(index = 0, type = null) {
            if (!Array.isArray(this.listFoods)) {
                console.error("listFoods is not an array");
                return;
            }

            this.selectedFood = JSON.parse(
                JSON.stringify(this.listFoods[index])
            );
            console.log("Producto seleccionado en addFood:", this.selectedFood);

            if (
                !this.selectedFood ||
                !this.selectedFood.description ||
                !this.selectedFood.item
            ) {
                console.error(
                    "Producto inválido seleccionado:",
                    this.selectedFood
                );
                return;
            }

            let unidadMedida = this.selectedFood.item.unit_type_id;
            let internalId = this.selectedFood.item.internal_id;
            let isPackOrRecipe =
                internalId?.startsWith("PACK000") ||
                internalId?.startsWith("PLAT000");
            let isService = unidadMedida === "ZZ";

            // Skip stock validation if divided_items is true or it's a special product type
            if (!this.divided_items && !isService && !isPackOrRecipe) {
                let foodFound = this.localOrden.filter(
                    f => f.id == this.selectedFood.id
                );
                let qty = foodFound.length 
                    ? foodFound.reduce((a, b) => a + Number(b.quantity), 0) + 1 
                    : 1;

                // Validate stock only for regular products
                if (this.configuration.sales_stock === true) {
                    let stock = Number(this.selectedFood.item.stock);
                    if (qty > stock) {
                        this.$toast.warning("Límite de stock alcanzado");
                        return;
                    }
                }
            }

            let selectedPrice = Number(this.selectedFood.price);
            // Convertir a entero si no tiene decimales
            selectedPrice = selectedPrice % 1 === 0 ? parseInt(selectedPrice) : selectedPrice;

            this.currentFood = {
                id: this.selectedFood.id,
                food: this.selectedFood,
                observation: null,
                price: selectedPrice,
                quantity: 1,
                will_be_divided: this.divided_items
            };
            
            this.orden.push(this.currentFood);
            this.$emit(
                "insertOrden",
                this.currentFood,
                this.selectedFood.id,
                type
            );
            
            this.$notify({
                title: this.selectedFood.description.toLowerCase(),
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
            this.listFoods = this.listFoods.map(f => {
                f.select = false;
                return f;
            });
            this.allFalse = true;
        },
        selectFood(index) {
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
            this.listFoods = this.foods.map(f => ({
                ...f,
                select: false
            }));
            this.title = `Mesa N°${this.table.number}`;
        },
        close() {
            this.ordenId = null;
            this.$emit("update:showMenu", false);
            this.$emit("update:currentTable", null);
        },
        agregarProducto(producto) {
            if (!producto || !producto.food) {
                console.error("Producto inválido recibido:", producto);
                return;
            }
            const cleanProducto = {
                ...producto.food,
                price: producto.food.price ? Number(producto.food.price) : 0
            };
            if (!Array.isArray(this.listFoods)) {
                console.error(
                    "🚨 Error: listFoods es undefined o no es un array. Reinicializando..."
                );
                this.listFoods = [];
            }
            let productoIndex = this.listFoods.findIndex(
                f => f.id === cleanProducto.id
            );

            if (productoIndex === -1) {
                this.$set(this.listFoods, this.listFoods.length, cleanProducto);
                productoIndex = this.listFoods.length - 1;
            }

            this.$nextTick(() => {
                this.addFood(productoIndex);
            });
        }
    }
};
</script>
