<template>
    <el-dialog
        :title="titleDialog"
        width="70%"
        :visible="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="false"
    >

    <div class="row m-3">
            <!-- Botón Agregar -->
            <div class="col-12 text-end mb-3">
                <el-button
                    class="btn-agregar"
                    icon="el-icon-plus"
                    size="mini"
                    @click.prevent="clickAddLot"
                >
                    Agregar
                </el-button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>Lote</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr v-for="(row, index) in lotsGroup_splice" :key="index" class="text-center">
                                <td>
                                    <el-input
                                        v-model="row.code"
                                        placeholder="Lote"
                                        @blur="duplicateSerie(row.code, index)"
                                    >
                                        <template #prefix>
                                            <i class="el-icon-edit-outline"></i>
                                        </template>
                                    </el-input>
                                </td>
                                <td>
                                    <el-input
                                        v-model="row.quantity"
                                        type="number"
                                        placeholder="Cantidad"
                                    ></el-input>
                                </td>
                                <td>
                                    <el-date-picker
                                        v-model="row.date_of_due"
                                        type="date"
                                        value-format="yyyy-MM-dd"
                                        :clearable="false"
                                        placeholder="Fecha"
                                    ></el-date-picker>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        @click.prevent="clickCancel(index)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                </table>
    </div>
        
            <!-- <el-pagination
                @current-change="handleCurrentChange"
                :current-page="currentPage"
                :page-size="10"
                :total="lotsGroup.length"
                layout="total, prev, pager, next"
            >
            </el-pagination> -->
        </div>

        <!-- Acciones del formulario -->
        <div class="form-actions d-flex justify-content-end gap-3 pt-3">
            <!-- Botón Cancelar -->
            <el-button
                class="btn-cancel"
                icon="fas fa-times fa-lg"
                @click.prevent="clickCancelSubmit"
            >
                Cancelar
            </el-button>
            <!-- Botón Guardar -->
            <el-button
                class="btn-save"
                icon="fas fa-save fa-lg"
                type="primary"
                @click="submit"
            >
                Guardar
            </el-button>
        </div>
    </el-dialog>
</template>


<script>
export default {
    props: ["showDialog", "stock", "recordId", "lotsGroup"],
    data() {
        return {
            currentPage: 1,
            localLotsGroup: [...this.lotsGroup],
            /* lotsGroup: [], */
            lotsGroup_splice: [],
            titleDialog: "Lotes",
            loading: false,
            errors: {},
            form: {},
            states: ["Activo", "Inactivo", "Desactivado", "Voz", "M2m"]
        };
    },
    async created() {},
    computed: {
        // Sumar las cantidades de todos los lotes
        totalQuantity() {
            return this.lotsGroup.reduce((total, lot) => total + (parseFloat(lot.quantity) || 0), 0);
        }
    },
    watch: {
        lotsGroup: {
            handler(newVal) {
                this.lotsGroup_splice = newVal.slice(0, 20);
            },
            immediate: true
        }
    },
    methods: {
        updateTotalQuantity() {
            // Actualizar la cantidad total basada en las cantidades de los lotes
            this.form.quantity = this.totalQuantity;
        },
        handleCurrentChange(val) {
            this.currentPage = val;
            this.lotsGroup_splice = this.lotsGroup.slice(
                (val - 1) * 20,
                val * 20
            );
        },
        async duplicateSerie(data, index) {
            let duplicates = await _.filter(this.lotsGroup, { Lotes: data });
            if (duplicates.length > 1) {
                this.lotsGroup[index].Lotes = null;
            }
        },
        create() {
            console.log("ver los lotes", this.lotsGroup);
            if (
                !this.recordId &&
                this.lotsGroup.filter(lg => lg.code != null).length == 0
            ) {
                this.localLotsGroup = [
                    {
                        id: null,
                        item_id: null,
                        code: null,
                        quantity: 0,
                        date_of_due: moment().format("YYYY-MM-DD"),
                        state: "Activo"
                    }
                ];
                this.lotsGroup_splice = this.lotsGroup.slice(0, 20);
            }
            // if (!this.recordId) {
            //     if (this.lotsGroup.length == 0) {
            //         this.addMorelotsGroup(this.stock);
            //     } else {
            //         let quantity = this.stock - this.lotsGroup.length;
            //         if (quantity > 0) {
            //             this.addMorelotsGroup(quantity);
            //         }
            //         // else{
            //         //     this.deleteMorelotsGroup(quantity)
            //         // }
            //     }
            //           this.lotsGroup_splice = this.lotsGroup.slice(0, 20);
            // }
        },
        addMorelotsGroup(number) {
            for (let i = 0; i < number; i++) {
                this.clickAddLot();
            }
        },
        deleteMorelotsGroup(number) {
            for (let i = 0; i < number; i++) {
                this.lotsGroup.pop();
                this.$emit("addRowLot", this.lotsGroup);
            }
        },
        async validatelotsGroup() {
            let error = 0;

            await this.lotsGroup.forEach(element => {
                if (element.code == null) {
                    error++;
                }
            });

            if (error > 0)
                return {
                    success: false,
                    message: "El campo serie es obligatorio"
                };

            return { success: true };
        },
        async submit() {
            let val_lotsGroup = await this.validatelotsGroup();
            if (!val_lotsGroup.success)
                return this.$toast.error(val_lotsGroup.message);
             console.log("ver retormar los lotes con datos", this.lotsGroup);   
            await this.$emit("addRowLot", this.lotsGroup);
            console.log("ver retormar los lotes con datos", this.lotsGroup);
            await this.$emit("update:showDialog", false);
        },
        clickAddLot() {
            // if (!this.recordId) {
            //     if (this.lotsGroup.length >= this.stock)
            //         return this.$toast.error(
            //             "La cantidad de registros es superior al stock o cantidad"
            //         );
            // }

            this.lotsGroup.push({
                id: null,
                item_id: null,
                Lotes: null,
                date_of_due: moment().format("YYYY-MM-DD"),
                state: "Activo"
            });
            this.lotsGroup_splice = this.lotsGroup.slice(0, 20);
            // this.$emit("addRowLot", this.lotsGroup);
        },

        close() {
            this.$emit("update:showDialog", false);
            this.$emit("addRowLot", this.lotsGroup);
            this.lotsGroup_splice = [];
        },
        clickCancel(index) {
            this.lotsGroup.splice(index, 1);
            // item.deleted = true
            this.$emit("addRowLot", this.lotsGroup);
        },

        async clickCancelSubmit() {
            this.$emit("addRowLot", []);
            await this.$emit("update:showDialog", false);
        }
    }
};
</script>
