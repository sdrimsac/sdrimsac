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
            <el-button @click="close">Cancelar</el-button>
            <el-button type="primary" @click="addColorSize">Aceptar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "colorSizes", "stock", "recordId"],
    data() {
        return {
            titleDialog: `Color - Talla`,
            loading: false
        };
    },
    methods: {
        addColorSize() {
            if (this.verifyStock()) {
                if (this.verifyCompleteData()) {
                    this.sortItems();
                    this.$emit("addRowColorSize", this.colorSizes);
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
            let total = 0;
            this.colorSizes.forEach(item => {
                total += parseInt(item.stock);
            });
            if (total != this.stock) {
                this.$toast.warning(
                    "El stock total debe ser igual al stock del producto"
                );
                return false;
            }
            return true;
        },
        clickAddColorSize() {
            this.colorSizes.push({
                color: "",
                size: "",
                stock: 0
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
                    item.size = item.size.toUpperCase();
                }
            });
        }
    }
};
</script>
