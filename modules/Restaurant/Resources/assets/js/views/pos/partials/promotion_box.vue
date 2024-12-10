<template>
    <el-dialog
        @open="open"
        @close="close"
        append-to-body
        :visible="showDialog"
        :title="titulo"
        close-on-click-modal
        width="70%"
    >
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div
                            v-for="promotion in listPromotionItems"
                            :key="promotion.id"
                            class="col-md-3"
                        >
                            <div
                                class="card"
                                style="width: 100%; height: 100%;"
                            >
                                <div class="text-center">
                                    <template
                                        v-if="
                                            promotion.item.image ==
                                                'imagen-no-disponible.jpg'
                                        "
                                    >
                                        <img
                                            src="/images/imagen-no-disponible.jpg"
                                            alt="User Img"
                                            class="thumbail"
                                            style="width: 100%; height: auto;"
                                        />
                                    </template>
                                    <template v-else>
                                        <img
                                            :src="
                                                formatUrlImage(
                                                    promotion.item.image
                                                )
                                            "
                                            class="thumbail"
                                            style="width: 100%; height: auto;"
                                        />
                                    </template>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        {{ promotion.item.description }}
                                    </h5>
                                    <div>
                                        <p class="card-text text-center">
                                            Código Interno:
                                            {{ promotion.item.internal_id }}
                                        </p>
                                        <p class="card-text text-center">
                                            Precio Puntos:
                                            {{ promotion.points_value }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <label for="num">Cantidad:</label>
                                        <br />
                                        <el-input-number
                                            v-model="promotion.quantity"
                                            :min="0"
                                            :max="100"
                                            :value="0"
                                            @input="updatePoints(promotion)"
                                        ></el-input-number>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
            <div style="margin-top: 10px; text-align: right;">
                <el-button type="info" @click="close">
                    Cerrar
                </el-button>
                <el-button
                    type="primary"
                    @click="submit"
                    style="margin-left: 10px;"
                >
                    Canjear
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>
<script>
export default {
    props: ["showDialog", "listPromotionItems", "hasPromotionText"],
    data() {
        return {
            value: 0
            /* showDialog: false, */
        };
    },
    computed: {
        titulo() {
            return `Promociones - Puntos Acumulados: ${this.hasPromotionText}`;
        },
        remainingPoints() {
            return this.hasPromotionText - this.totalPointsUsed;
        },
        totalPointsUsed() {
            return this.listPromotionItems.reduce((total, promotion) => {
                return (
                    total + (promotion.quantity || 0) * promotion.points_value
                );
            }, 0);
        }
    },
    methods: {
        submit() {
            console.log(
                "Lista de promociones con cantidades seleccionadas:",
                this.listPromotionItems
            );
            this.$emit("submit", this.listPromotionItems);
            this.$emit("update:showDialog", false);
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        open() {
            // Initialize promotion quantities to zero when the dialog opens
            this.listPromotionItems.forEach(promotion => {
                if (promotion.quantity === undefined) {
                    this.$set(promotion, "quantity", 0);
                }
            });
            console.log(
                "ver pasar los item relacionados con la promocion seleccionada",
                this.listPromotionItems
            );
            console.log("ver si tiene promocion", this.hasPromotionText);
        },
        close() {
            /* this.resetPromotions(); */
            this.$emit("update:showDialog", false);
        },
        resetPromotions() {
            this.listPromotionItems.forEach(promotion => {
                promotion.quantity = 0;
                // Reset other properties of the promotion card if needed
            });
        },
        updatePoints(promotion) {
            const otherPointsUsed = this.listPromotionItems.reduce(
                (total, item) => {
                    if (item.id !== promotion.id) {
                        return total + (item.quantity || 0) * item.points_value;
                    }
                    return total;
                },
                0
            );

            const newTotalPointsUsed =
                otherPointsUsed + promotion.quantity * promotion.points_value;

            if (newTotalPointsUsed > this.hasPromotionText) {
                this.$showSAlert(
                    "ALERTA",
                    "No tienes suficientes puntos para agregar este item.",
                    "warning"
                );
                promotion.quantity = Math.max(promotion.quantity - 1, 0); // Restaura la cantidad previa
            } else {
                /* console.log("Puntos restantes:", this.remainingPoints); */
            }
            // Ensure the quantity is updated correctly
            this.$forceUpdate();
        }
    }
};
</script>
