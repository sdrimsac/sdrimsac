<template>
    <el-dialog @open="open" @close="close" append-to-body :visible="showDialog" :title="titulo"
        :close-on-click-modal="true" width="70%">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div v-for="promotion in listPromotionItems" :key="promotion.id" class="col-md-3"
                            style="margin-bottom: 20px;">
                            <div class="card" style="width: 100%; height: 100%; padding: 10px; position: relative;">
                                <div class="text-center">
                                    <template v-if="
                                        promotion.item.image ==
                                        'imagen-no-disponible.jpg'
                                    ">
                                        <img src="/images/imagen-no-disponible.jpg" alt="User Img" class="thumbail"
                                            style="width: 100%; height: auto;" />
                                    </template>
                                    <template v-else>
                                        <img :src="formatUrlImage(
                                            promotion.item.image
                                        )
                                            " class="thumbail" style="width: 100%; height: auto;" />
                                    </template>
                                    <img v-if="promotion.stock <= 0" src="/status_images/agotado.png" alt="Agotado"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.5; pointer-events: none;" />
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        {{ promotion.item.description.toUpperCase() }}
                                    </h5>
                                    <div>
                                        <p class="card-text text-center">
                                            Código Interno:
                                            {{ promotion.item.internal_id }}
                                        </p>
                                        <p class="card-text text-center"
                                            :class="{ 'text-danger bold': Number(promotion.points_value) > remainingPoints }">
                                            Puntos:
                                            {{ promotion.points_value }}
                                        </p>
                                        <p class="card-text text-center" v-if="promotion.stock > 0">
                                            Stock:
                                            {{
                                                Number(
                                                    promotion.stock
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <label for="num">Ingrese Cantidad:</label>
                                        <br />
                                        <el-input v-model="promotion.quantity"
                                            :min="0"
                                            :max="promotion.stock > 0 ? Math.floor(remainingPoints / promotion.points_value) : 0"
                                            @input="updatePoints(promotion)"
                                            :disabled="promotion.stock <= 0"
                                            type="number"
                                            class="qquantity-promotion"
                                        ></el-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
            <div style="margin-top: 10px; text-align: right;">
                <el-button class="btn_cancelarsmall"  @click="close">
                    <i class="fas fa-times me-1"></i>
                    Cerrar
                </el-button>
                <el-button class="btn_cajearsmall"  @click="submit" style="margin-left: 10px;">
                    <i class="fas fa-gift me-1"></i>
                    Canjear
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>
<style>
.qquantity-promotion .el-input__inner {
    text-align: center;
}
</style>
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
            return `Promociones - Puntos Acumulados: ${this.hasPromotionText} - Puntos Restantes: ${this.remainingPoints}`;
        },
        remainingPoints() {
            return this.hasPromotionText - this.totalPointsUsed;
        },
            totalPointsUsed() {
                return this.listPromotionItems.reduce((total, promotion) => {
                    const qty = Number(promotion.quantity) || 0;
                    const points = Number(promotion.points_value) || 0;
                    return total + qty * points;
                }, 0);
            }
    },
    watch: {
        totalPointsUsed() {
            this.$forceUpdate();
        }
    },
    methods: {
        submit() {
            console.log(
                "[SUBMIT] Lista de promociones con cantidades seleccionadas:",
                JSON.parse(JSON.stringify(this.listPromotionItems))
            );
            this.$emit("submit", JSON.parse(JSON.stringify(this.listPromotionItems)));
            this.$emit("update:showDialog", false);
            // Resetear promociones después de emitir
            this.resetPromotions();
        },
        formatUrlImage(url) {
            if (!url) return;
            let formated = "storage/uploads/items/" + url;
            return `/${formated}`;
        },
        open() {
            // Solo inicializar cantidad si está indefinida o el stock es cero
            this.listPromotionItems.forEach(promotion => {
                if (promotion.quantity === undefined) {
                    this.$set(promotion, "quantity", 0);
                }
                if (promotion.stock <= 0) {
                    promotion.quantity = 0;
                }
            });

            // Solo distribuir puntos si todas las cantidades están en cero (no hay selección previa)
            const allZero = this.listPromotionItems.every(p => !p.quantity || p.quantity === 0);
            if (allZero) {
                this.distributePoints(parseInt(this.hasPromotionText));
            }

            console.log(
                "ver pasar los item relacionados con la promocion seleccionada",
                this.listPromotionItems
            );
            console.log("ver si tiene promocion", this.hasPromotionText);
        },
        distributePoints(totalPoints) {
            let remainingPoints = totalPoints;
            console.log("puntos iniciales", remainingPoints);

            // Distribución equitativa inicial
            remainingPoints = this.distributeEqualPoints(remainingPoints);
            console.log("puntos restantes después de distribución igual", remainingPoints);

            // Distribuir puntos restantes
            if (remainingPoints > 0) {
                remainingPoints = this.distributeRemainingPoints(remainingPoints);
            }

            console.log("puntos restantes finales", remainingPoints);
        },
        distributeEqualPoints(points) {
            // Solo distribuir puntos a promociones con stock > 0
            const availablePromotions = this.listPromotionItems.filter(p => p.stock > 0);
            const numPromotions = availablePromotions.length;
            if (numPromotions === 0) return points;
            const pointsPerPromotion = Math.floor(points / numPromotions);

            availablePromotions.forEach(promotion => {
                let pointsValue = parseInt(promotion.points_value);
                promotion.quantity = Math.floor(pointsPerPromotion / pointsValue);
                points -= promotion.quantity * pointsValue;
            });

            return points;
        },
        distributeRemainingPoints(points) {
            // Solo distribuir puntos a promociones con stock > 0
            const sortedPromotions = [...this.listPromotionItems]
                .filter(p => p.stock > 0)
                .sort((a, b) => parseInt(a.points_value) - parseInt(b.points_value));

            for (let promotion of sortedPromotions) {
                let pointsValue = parseInt(promotion.points_value);
                if (points >= pointsValue) {
                    let additionalQuantity = Math.floor(points / pointsValue);
                    promotion.quantity += additionalQuantity;
                    points -= additionalQuantity * pointsValue;
                }
            }

            return points;
        },
        close() {
            console.log("[CLOSE] Antes de resetPromotions", JSON.parse(JSON.stringify(this.listPromotionItems)));
            this.resetPromotions();
            console.log("[CLOSE] Después de resetPromotions", JSON.parse(JSON.stringify(this.listPromotionItems)));
            this.$emit("update:showDialog", false);
        },
        resetPromotions() {
            console.log("[RESET] Antes de limpiar cantidades", JSON.parse(JSON.stringify(this.listPromotionItems)));
            this.listPromotionItems.forEach(promotion => {
                promotion.quantity = 0;
                // Reset other properties of the promotion card if needed
            });
            console.log("[RESET] Después de limpiar cantidades", JSON.parse(JSON.stringify(this.listPromotionItems)));
        },
        updatePoints(promotion) {
            // Si no hay stock, la cantidad debe ser 0 y no se puede modificar
            if (promotion.stock <= 0) {
                promotion.quantity = 0;
                return;
            }
            const otherPointsUsed = this.listPromotionItems.reduce(
                (total, item) => {
                    if (item.id !== promotion.id) {
                        return total + (item.quantity || 0) * item.points_value;
                    }
                    return total;
                },
                0
            );

            const maxAllowedQuantity = Math.floor(
                (this.hasPromotionText - otherPointsUsed) /
                promotion.points_value
            );

            if (promotion.quantity > maxAllowedQuantity) {
                promotion.quantity = maxAllowedQuantity;
                this.$showSAlert(
                    "ALERTA",
                    "No tienes suficientes puntos para agregar más de este ítem.",
                    "warning"
                );
            }
        }
    }
};
</script>
