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
                    <div class="col-12 col-lg-6  col-xl-6 col-xxl-4 p-1" v-for="(data, index) in listFoods"
                        :key="index">
                        <!--  -->
                        <div id="card"
                            class="overflow-hidden coupon rounded  d-flex flex-column  justify-content-between p-1 bg-white">
                            <div @click="addFood(index)">
                                <div>
                                    <span class="lead-font-weight-700 h5">
                                        {{ data.description.toUpperCase() }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="p-1">
                                        <div class="icon-container ">
                                            <div class="icon-container_box">
                                                <template v-if="
                                                    data.image ==
                                                    'imagen-no-disponible.jpg'
                                                ">
                                                    <img src="/images/imagen-no-disponible.jpg" alt="User Img"
                                                        class="thumbail" />
                                                </template>
                                                <template v-else>
                                                    <img :src="formatUrlImage(
                                                        data.image
                                                    )
                                                        " class=" thumbail" />
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        {{ data.code }}
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="text-uppercase font-weight-light h5">
                                            {{ data.category.name }}
                                        </div>
                                        <div class="block mb-2">
                                            <span class="time font-weight-light">
                                                <span class="text-muted lead-font-weight-700">
                                                    {{ data.currency }}
                                                    {{ data.price }}</span>
                                            </span>
                                        </div>
                                        <div v-if="
                                            data.item.lots_enabled == 1 &&
                                            data.item.date_of_due
                                        ">
                                            <el-tag :type="`${isExpired(
                                                data.item
                                                    .date_of_due
                                            )
                                                ? 'danger'
                                                : 'success'
                                                }`
                                                ">
                                                Fecha de vencimiento:
                                                {{ data.item.date_of_due }}
                                            </el-tag>
                                        </div>
                                        <div>
                                            <template v-if="
                                                data.item.is_set == 0 && data.item.promotions_items == 0 &&
                                                data.item
                                                    .unit_type_id !=
                                                'ZZ' && configuration.show_stock_cash == true
                                            ">
                                                <template v-if="data.item.stock > 0">
                                                    <span class="badge rounded-pill bg-primary m-l-0">Stock
                                                        {{
                                                            parseFloat(
                                                                data.item.stock
                                                            )
                                                        }}
                                                    </span>
                                                </template>
                                                <template v-else>
                                                    <span class="badge rounded-pill bg-danger m-l-0">
                                                        Agotado
                                                    </span>
                                                </template>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="data.types && data.types.length > 0" class="d-flex justify-content-end"
                                style="padding-right:5px;margin-top:5px;">
                                <el-dropdown @command="clickCommand">
                                    <span class="el-dropdown-link">
                                        Precios<i class="el-icon-arrow-down el-icon--right"></i>
                                    </span>
                                    <el-dropdown-menu slot="dropdown">
                                        <el-dropdown-item v-for="(type, idx) in data.types" :key="idx" :command="type">
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
        <item-promotion :showDialog.sync="showDialogItemPromotion" 
        :selectedFood="selectedFood && selectedFood.item" :selectedItemId="selectedFood && selectedFood.item && selectedFood.item.id"
        @addPromotionItems="onAddPromotionItems"
        ></item-promotion>

        <view-image :image="currentImage" :showDialog.sync="showImage"></view-image>
        <el-pagination @current-change="getRecords" layout="total, prev, pager, next" :total="pagination.total"
            :current-page.sync="pagination.current_page" :page-size="Number(pagination.per_page)">
        </el-pagination>
    </div>
</template>

<script>
import ViewImage from "./image.vue";
import ItemPromotion from "./item_promotion.vue";
export default {
    props: [
        "table",
        "pagination",
        "localOrden",
        "showMenu",
        "categories",
        "foods",
        "configuration",
        "divided_items" 
    ],
    components: {
        ViewImage,
        ItemPromotion
    },
    data() {
        return {
            showDialogItemPromotion: false,
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

        async onAddPromotionItems(items) {
            this.showDialogItemPromotion = false;

            if (!Array.isArray(items) || items.length === 0) return;

            const groups = items.reduce((acc, it) => {
                const pid = it.promotion_id;
                if (!acc[pid]) acc[pid] = [];
                acc[pid].push(it);
                return acc;
            }, {});

            for (const promotionId of Object.keys(groups)) {
                const group = groups[promotionId];

                // Construir array detallado de items de la promoción
                const promoItemsDetailed = [];

                for (const promo of group) {
                    const promoItemId = promo.promotion_item_id;
                    const qty = Number(promo.quantity) || 1;
                    const description = promo.description || promo.descripcion || null;

                    // Buscar el item en listFoods (vista actual) o en foods (fallback)
                    let found = this.listFoods.find(
                        f => (f.item && f.item.id == promoItemId) || f.id == promoItemId
                    );
                    if (!found) {
                        found = this.foods.find(
                            f => (f.item && f.item.id == promoItemId) || f.id == promoItemId
                        );
                    }

                    if (!found) {
                        try {
                            const resp = await this.$http.get(`/items/record/${promoItemId}`);
                            // Algunos endpoints devuelven resource en resp.data.data o directamente en resp.data
                            const responseItem = (resp && resp.data && (resp.data.data || resp.data)) || null;
                            if (responseItem) {
                                // Normalizar a la estructura que usa la vista: asegurar .item y propiedades básicas
                                found = {
                                    id: responseItem.id || promoItemId,
                                    description: responseItem.description || responseItem.name || "",
                                    price: Number(responseItem.sale_unit_price || responseItem.price || 0).toFixed(2),
                                    item: responseItem,
                                    series: responseItem.series || []
                                };
                            }
                        } catch (err) {
                            console.warn(`onAddPromotionItems: no se pudo obtener item ${promoItemId} del servidor`, err);
                        }
                    }

                    if (!found) {
                        console.warn(`onAddPromotionItems: item promocional no encontrado id=${promoItemId}`);
                        continue;
                    }

                    // Realizar verificaciones similares a addFood si el item es set/promocion
                    try {
                        let foodFound = this.localOrden.filter(f => f.id == (found.item ? found.item.id : found.id));
                        let existingQty = 0;
                        if (foodFound.length != 0) {
                            existingQty = foodFound.reduce((a, b) => a + Number(b.quantity), 0);
                        }

                        // Validaciones por unidad (si aplica)
                        let pass = true;
                        const quotation_stock = (localStorage.getItem("quotation_stock") || 0) == 1;

                        if ((found.item && found.item.is_set == 1) || (found.item && found.item.promotions_items == 1)) {
                            if (this.configuration.sales_stock == true && !quotation_stock && found.item.unit_type_id != "ZZ") {
                                if (this.configuration.restaurant) {
                                    pass = await this.setItemCheckStock(found.item.id, existingQty + qty);
                                } else {
                                    pass = await this.setItemPolicy(found.item.id, existingQty + qty);
                                }
                            }
                            if (pass === false) {
                                console.info(`Promoción: el check para el item ${found.item.id} falló, no se agregará.`);
                                continue;
                            }
                        }

                        // Añadir al detalle de la promoción (clonando para evitar mutaciones)
                        const cloned = JSON.parse(JSON.stringify(found));
                        cloned._promo_quantity = qty; // cantidad dentro de la promoción
                        cloned._promo_description = description;
                        cloned.promotion = { promotion_id: promotionId, promotion_item_id: promoItemId };
                        // Asegurar que la estructura que espera el padre esté presente
                        if (!cloned.item) cloned.item = {};
                        promoItemsDetailed.push(cloned);
                    } catch (err) {
                        console.error("Error procesando item de promoción:", err);
                        continue;
                    }
                }

                if (promoItemsDetailed.length === 0) {
                    console.warn(`onAddPromotionItems: ningun item valido para la promoción ${promotionId}`);
                    continue;
                }

                // Intentar encontrar el item de promoción real (el padre) en foods/listFoods
                let promotionItem = this.listFoods.find(
                    f => (f.item && f.item.id == promotionId) || f.id == promotionId
                );
                if (!promotionItem) {
                    promotionItem = this.foods.find(
                        f => (f.item && f.item.id == promotionId) || f.id == promotionId
                    );
                }

                let promotionFood;
                if (promotionItem) {
                    // Clonar el item real y anexar los promotion_items
                    promotionFood = JSON.parse(JSON.stringify(promotionItem));
                    promotionFood.promotion_items = promoItemsDetailed;
                    // Aseguramos la marca de que es una promoción
                    promotionFood.item = promotionFood.item || {};
                    promotionFood.item.promotions_items = 1;
                } else {
                    // Si no existe el item de promoción como tal, crear un objeto genérico
                    promotionFood = {
                        id: `PROMO-${promotionId}`,
                        description: `Promoción ${promotionId}`,
                        price: 0,
                        promotion_id: promotionId,
                        promotion_items: promoItemsDetailed,
                        item: {
                            lots_group: [],
                            currency_type_id: null,
                            lots_enabled: 0,
                            promotions_items: 1,
                            unit_type_id: "ZZ",
                            stock: 0,
                            is_set: 0,
                            has_color_size: false,
                            has_series: false,
                            item_unit_types: [],
                            warehouses: [],
                            lot_code: null,
                            date_of_due: null,
                            subject_to_detraction: 0
                        },
                        series: []
                    };
                }

                const currentFood = {
                    id: promotionFood.id,
                    food: promotionFood,
                    observation: null,
                    price: promotionFood.price || 0,
                    quantity: 1
                };

                // Emitir la promoción con sus componentes. El padre debe interpretar 'food.promotion_items'
                this.$emit("insertOrden", currentFood, currentFood.id, null, false, null, []);

                this.$notify({
                    title: promotionFood.description || `Promoción ${promotionId}`,
                    duration: 1000,
                    iconClass: "el-icon-star-on",
                    message: "Promoción agregada con sus items",
                    position: "bottom-left"
                });
            }
        },

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

        async setItemCheckStock(id, quantity) {
            let pass = true;
            const response = await this.$http.get(
                `/receta/check/${id}/${quantity}`
            );
            if (response.status == 200) {
                const { success, message } = response.data;
                if (!success) {
                    this.$toast.error(message);
                    pass = false;
                }
            }
            return pass;
        },

        async setItemPolicy(id, quantity) {
            let pass = true;
            const response = await this.$http.get(
                `/item-sets/check/${id}/${quantity}`
            );

            if (response.status === 200) {
                const { success, message, components } = response.data;

                // ✅ Validar si components tiene algo
                if (components && components.length > 0) {
                    this.showDialogItemSet = true;
                    this.itemSetComponents = components;
                } else {
                    this.showDialogItemSet = false;
                }

                if (!success) {
                    this.$toast.error(message);
                    pass = false;
                }
            }

            return pass;
        },

        async addFood(index = 0, type = null) {
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
            let pass = true;

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
                    if (this.selectedFood.item.promotions_items == 1) {
                        if (this.configuration.sales_stock == true &&
                            this.selectedFood.item.unit_type_id != "ZZ") {
                            if (this.configuration.restobar_home) {
                                this.$nextTick(() => {
                                    this.showDialogItemPromotion = true;
                                });
                                return;
                            }
                        }
                    } else if (this.selectedFood.item.is_set == 1) {
                        if (this.configuration.sales_stock == true &&
                            this.selectedFood.item.unit_type_id != "ZZ") {
                            if (this.configuration.restobar_home) {
                                pass = await this.setItemCheckStock(
                                    this.selectedFood.item.id,
                                    qty
                                );
                            } else {
                                pass = await this.setItemPolicy(
                                    this.selectedFood.item.id,
                                    qty
                                );
                            }
                            return;
                        }
                        return;
                    } else {
                        let stock = Number(this.selectedFood.item.stock);
                        if (qty > stock) {
                            this.$toast.warning("Límite de stock alcanzado");
                            return;
                        }
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
