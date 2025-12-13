<template>
    <el-dialog
        :visible="showDialog"
        @open="open"
        @close="close"
        append-to-body
        center
    >
        <span slot="title" class="w-100 d-flex justify-content-between align-items-center">
            <strong>{{ titleDialog }}</strong>
            <el-button
            class="btn_guardarsmall"
            type="primary"
            icon="el-icon-plus"
            size="mini"
            @click="clickAddColorSize"
            >Agregar</el-button>

             <strong>  </strong>
           
        </span>
        <div class="row m-2">
            <!-- <div class="col-12 d-flex justify-content-end">
                <el-button
                    class="btn_guardarsmall"
                    type="primary"
                    icon="el-icon-plus"
                    size="mini"
                    @click="clickAddColorSize"
                > Agregar</el-button>
            </div> -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead style="background-color:#073f68;">
                        <tr>
                            <th style="color:#ffffff;">
                                Código Familia 
                            </th>
                            <th style="color:#ffffff;">
                                Color
                            </th>
                            <th style="color:#ffffff;">
                                Talla
                            </th>
                            <th style="color:#ffffff;">
                                Stock
                            </th>
                            <th style="color:#ffffff;">
                                Precio
                            </th>
                            <th style="color:#ffffff;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in colorSizes" :key="index":style="{ backgroundColor: index % 2 === 0 ? '#ffffff' : '#f0f0f0' }" >
                            <td>
                                 <el-input
                                    type="text"
                                    v-model="row.code"
                                ></el-input>

                                
                            </td>
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
            <div class="d-flex justify-content-end" style="width: 100%;">
                <el-button class="btn_cancelarsmall" type="danger" @click="close" size="large">Cancelar</el-button>
                <el-button class="btn_guardarsmall ml-2" type="primary" @click="addColorSize" size="large">Aceptar</el-button>
            </div>
        </span>
        <!-- </span> -->
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
