<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @open="open"
        @close="close"
        width="70%"
        append-to-body
    >
        <!-- Contenedor principal -->
        <div class="row m-3">
            <!-- Botón Agregar -->
            <div class="col-12 text-end mb-3">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="clickAddColorSize"
                >
                    Agregar
                </el-button>
            </div>
            <!-- Tabla de contenido -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>Color</th>
                            <th>Código</th>
                            <th>Talla</th>
                            <th>Stock</th>
                            <th>P. Venta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(row, index) in colorSizes"
                            :key="index"
                            class="text-center"
                        >
                            <td>
                                <el-input
                                    v-model="row.color"
                                    placeholder="Color"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    v-model="row.code"
                                    placeholder="Código"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    v-model="row.size"
                                    placeholder="Talla"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    type="number"
                                    v-model="row.stock"
                                    placeholder="Stock"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    type="number"
                                    v-model="row.price"
                                    step="0.01"
                                    placeholder="Precio"
                                ></el-input>
                            </td>
                            <td>
                                <el-tooltip
                                    content="Eliminar Producto"
                                    placement="top"
                                >
                                    <el-button
                                        type="danger"
                                        icon="el-icon-delete"
                                        size="mini"
                                        @click="colorSizes.splice(index, 1)"
                                    >
                                    </el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer de acciones -->
        <div class="form-actions d-flex justify-content-end gap-3 pt-3">
            <!-- Botón Cancelar -->
            <el-button class="btn-cancel" icon="fas fa-times" @click="close">
                Cancelar
            </el-button>
            <!-- Botón Aceptar -->
            <el-button
                class="btn-save"
                icon="fas fa-save"
                type="primary"
                @click="addColorSize"
            >
                Aceptar
            </el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "colorSizes", "stock", "recordId", "internalId"],
    data() {
        return {
            titleDialog: `Color - Talla`,
            loading: false,
            lastColorSize: 0,
        };
    },
    computed: {
        totalStock() {
            let total = 0;
            this.colorSizes.forEach(item => {
                total += parseInt(item.stock);
            });
            return total;
        }
    },
    methods: {
        getLastColorSize() {
            this.$http.get(`/item-color-size/last-record/${this.recordId}`).then(response => {
                console.log(response);
                this.lastColorSize = response.data;
            });
        },
        addColorSize() {
            if (this.verifyStock()) {
                if (this.verifyCompleteData()) {
                    this.sortItems();
                    this.$emit("addRowColorSize", this.colorSizes);
                    console.log(this.colorSizes);
                    this.close();
                } else {
                    this.$toast.warning("Debe llenar todos los campos");
                }
            }
        },
        verifyCompleteData() {
            //verificar si todos los campos estan llenos
            let complete = true;
            this.colorSizes.forEach(item => {
                if (item.color == "" || item.size == "" || item.stock == 0) {
                    complete = false;
                }
            });
            return complete;
        },
        verifyStock() {
            if (this.stock == 0) {
                return true;
            }
            let total = 0;
            this.colorSizes.forEach(item => {
                total += parseInt(item.stock);
            });
            if (total != this.stock) {
                this.$showSAlert(
                    "warning",
                    "El stock total debe ser igual al stock del producto",
                    "warning"
                );
                /* this.$toast.warning(
                    "El stock total debe ser igual al stock del producto"
                ); */
                return false;
            }
            return true;
        },
        clickAddColorSize() {
            if (this.totalStock >= this.stock) {
                this.$showSAlert(
                    "warning",
                    "El stock total no puede ser mayor al stock del producto",
                    "warning"
                );
                /* this.$toast.warning("El stock total no puede ser mayor al stock del producto"); */
                return;
            }
            const lastCode = !this.colorSizes.length ? this.lastColorSize + 1 : this.colorSizes.length + 1;
            let code = `${this.internalId}-${lastCode}`;
            this.colorSizes.push({
                color: "",
                size: "",
                stock: 0,
                price: 0,
                code
            });
        },
        addMoreColorSizes() {
            this.clickAddColorSize();
        },
        deleteMoreColorSizes(number) {
            for (let i = 0; i < number; i++) {
                this.colorSizes.pop();
            }
        },
        open() {
            this.getLastColorSize();
            if (!this.recordId) {
                if (this.colorSizes.length == 0) {
                    this.addMoreColorSizes();
                }
            }
            if (this.colorSizes.length > 0) {
                this.sortItems();
            }

            this.titleDialog = `Color - Talla - Stock: ${this.stock} | Cantidad: ${this.totalStock}`;
        },
        close() {
            this.$emit("update:showDialog", false);
        },
        sortItems() {
            this.colorSizes.sort((a, b) => {
                if (a.color > b.color) {
                    return 1;
                }
                if (a.color < b.color) {
                    return -1;
                }
                return 0;
            });

            this.colorSizes.sort((a, b) => {
                if (a.size > b.size) {
                    return 1;
                }
                if (a.size < b.size) {
                    return -1;
                }
                return 0;
            });

            this.colorSizes.forEach(item => {
                if (item.size && item.color) {
                    item.color = item.color.toUpperCase();

                    if (isNaN(item.size)) {
                        item.size = item.size.toUpperCase();
                    }
                }
            });
        }
    }
};
</script>
