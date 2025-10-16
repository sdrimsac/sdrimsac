<!-- Agragar Tallas y Colores en compras -->
<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @open="open" @close="close" width="70%" append-to-body>

        <div class="row m-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light text-center">
                        <tr>
                            <th class="text-center" style="padding: 4px; width: 18%;">Código Familia</th>
                            <th class="text-center" style="padding: 4px; width: 18%;">Color</th>
                            <th class="text-center" style="padding: 4px; width: 18%;">Talla</th>
                            <th class="text-center" style="padding: 4px; width: 14%;">Stock</th>
                            <th class="text-center" style="padding: 4px; width: 18%;">P. Venta</th>
                            <th class="text-center" style="padding: 4px; width: 14%;">
                                <el-button class="btn_guardarsmall" type="primary" icon="el-icon-plus" size="mini"
                                    @click="clickAddColorSize">
                                    Agregar
                                </el-button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in colorSizes" :key="index" class="text-center">
                            <td>
                                <el-input v-model="row.code" placeholder="Código"></el-input>
                            </td>
                            <td>
                                <el-input v-model="row.color" placeholder="Color"></el-input>
                            </td>

                            <td>
                                <el-input v-model="row.size" placeholder="Talla"></el-input>
                            </td>
                            <td>
                                <el-input type="number" v-model="row.stock" step="1" placeholder="Stock" :min="1" @change="onInputNumber(row, 'stock')"></el-input>
                            </td>
                            <td>
                                <el-input type="number" v-model="row.price" step="1" placeholder="Precio" :min="1" @change="onInputNumber(row, 'price')"></el-input>
                            </td>
                            <td class="text-center">
                                <el-tooltip content="Eliminar Producto" placement="top">
                                    <el-button
                                        type="danger"
                                        icon="el-icon-delete"
                                        size="mini"
                                        circle
                                        @click="colorSizes.splice(index, 1)">
                                    </el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                    <div class="form-actions d-flex justify-content-end gap-3 pt-3">
            <el-button type="primary" class="btn_cancelarsmall" icon="fas fa-times" @click="close">
                Cancelar
            </el-button>
            <el-button type="primary" class="btn_guardarsmall" icon="fas fa-save" @click="addColorSize">
                Aceptar
            </el-button>
        </div>

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
            let codes = new Set();
            let hasDuplicateCode = false;
            this.colorSizes.forEach(item => {
                if (item.color == "" || item.size == "" || item.stock == 0) {
                    complete = false;
                }
                if (codes.has(item.code)) {
                    hasDuplicateCode = true;
                } else {
                    codes.add(item.code);
                }
            });
            if (hasDuplicateCode) {
                this.$showSAlert("ALERTA", "No se permite repetir el mismo código en dos filas", "warning");
                return false;
            }
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
                return;
            }
            const lastCode = !this.colorSizes.length ? this.lastColorSize + 1 : this.colorSizes.length + 1;
            let code = `${this.internalId}-${lastCode}`;
            this.colorSizes.push({
                color: "",
                size: "",
                stock: 1,
                price: 1,
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
        },
        onInputNumber(row, field) {
            // Solo corregir si el valor es menor a 1 o no es número
            if (row[field] === '' || isNaN(row[field]) || Number(row[field]) < 1) {
                row[field] = 1;
            } else {
                // Permitir cualquier número entero >= 1
                row[field] = Math.floor(Number(row[field]));
            }
        },
    }
};
</script>
