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
                <table class="table">
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
                                
                                @input="verifyStock"
                                v-model="row.stock"></el-input>
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
            <el-button type="primary" @click="close">Aceptar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "colorSizes", "stock", "recordId"],
    data() {
        return {
            titleDialog: "Color - Talla",
            loading: false
        };
    },
    methods: {
        verifyStock(){
            let total = 0;
            this.colorSizes.forEach((item) => {
                total += parseInt(item.stock);
            });
            if (total > this.stock) {
                this.$message({
                    message: "El stock no puede ser mayor al total",
                    type: "warning"
                });
            }
        },
        clickAddColorSize() {
            this.colorSizes.push([
                {
                    color: "",
                    size: "",
                    stock: 0
                }
            ]);
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
                } else {
                    let quantity = this.stock - this.colorSizes.length;
                    if (quantity > 0) {
                        this.addMoreColorSizes(quantity);
                    } else {
                        this.deleteMoreColorSizes(quantity);
                    }
                }
            }
            if (this.colorSizes.length > 0) {
                this.sortItems();
            }
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
        }
    }
};
</script>
