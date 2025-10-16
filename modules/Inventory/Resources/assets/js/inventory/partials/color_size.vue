<template>
    <el-dialog
        :title="titleDialog"
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
    >
        <div class="row m-2">
            <div class="col-12 text-end">
                <el-button
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="clickAddColorSize"
                ></el-button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                COLOR
                            </th>
                            <th>
                                TALLA
                            </th>
                            <th>
                                STOCK
                            </th>
                            <th>
                                PRECIO
                            </th>
                            <th>
                                CODIGO FAMILIA 
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in colorSizes" :key="index">
                            <td>
                                <el-input v-model="row.color"></el-input>
                            </td>
                            <td>
                                <el-input v-model="row.size"></el-input>
                            </td>
                            <td>
                                <el-input
                                    type="number"
                                    v-model="row.stock"
                                    :min="1"
                                    @input="e => { if (e === '' || e === null) { row.stock = ''; } else if (Number(e) < 1) { row.stock = 1; } else { row.stock = Number(e); } }"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    type="number"
                                    step="0.01"
                                    v-model="row.price"
                                    :min="1"
                                    @input="e => { if (e === '' || e === null) { row.price = ''; } else if (Number(e) < 1) { row.price = 1; } else { row.price = Number(e); } }"
                                ></el-input>
                            </td>
                            <td>
                                <el-input
                                    type="text"
                                    v-model="row.code"
                                ></el-input>
                            </td>
                            <td>
                                <el-button
                                    type="danger"
                                    icon="el-icon-delete"
                                    size="mini"
                                    @click="colorSizes.splice(index, 1)"
                                ></el-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="close" size="large">Cancelar</el-button>
            <el-button type="primary" @click="addColorSize" size="large">Aceptar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "stock", "recordId"],
    data() {
        return {
            titleDialog: `Color - Talla`,
            loading: false,
            colorSizes: []
        };
    },
    methods: {
        addColorSize() {
            if (this.verifyCompleteData()) {
                this.sortItems();
                // Emit a cloned array to avoid future mutations affecting parent
                const payload = this.colorSizes.map(item => ({ ...item }));
                this.$emit("addRowColorSize", payload);
                // Limpiar el formulario para que al volver a abrir esté vacío
                this.resetForm();
                this.close();
            } else {
                this.$toast.warning("Debe llenar todos los campos y el stock/precio debe ser mínimo 1");
            }
        },
        resetForm() {
            this.colorSizes = [];
            // Agregar fila en blanco para nueva entrada
            this.addMoreColorSizes();
        },
        verifyCompleteData() {
            //verificar si todos los campos estan llenos y stock/precio >= 1
            let complete = true;
            this.colorSizes.forEach(item => {
                if (
                    item.color === "" ||
                    item.size === "" ||
                    item.stock === null ||
                    item.price === null ||
                    Number(item.stock) < 1 ||
                    Number(item.price) < 1
                ) {
                    complete = false;
                }
            });
            return complete;
        },
        clickAddColorSize() {
            this.colorSizes.push({
                color: "",
                size: "",
                stock: 1, // por defecto 1
                price: 1, // por defecto 1
                code: ""
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
            if (!this.recordId) {
                if (this.colorSizes.length == 0) {
                    this.addMoreColorSizes();
                }
            }
            if (this.colorSizes.length > 0) {
                this.sortItems();
            }

            this.titleDialog = `Color - Talla - Stock: ${this.stock}`;
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
