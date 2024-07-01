<template>
    <el-dialog
        :title="titleDialog"
        width="40%"
        :visible="showDialog"
        @open="create"
        :close-on-click-modal="false"
        :close-on-press-escape="false"
        append-to-body
        :show-close="false"
    >
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <table width="100%">
                        <thead>
                            <tr width="100%">
                                <th v-if="lotsGroup.length > 0">Lote</th>
                                <th v-if="lotsGroup.length > 0">Cantidad</th>
                                <th v-if="lotsGroup.length > 0">Fecha</th>
                                <th width="15%">
                                    <a
                                        href="#"
                                        @click.prevent="clickAddLot"
                                        class="text-center font-weight-bold text-info"
                                        >[+ Agregar]</a
                                    >
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, index) in lotsGroup_splice"
                                :key="index"
                                width="100%"
                            >
                                <td>
                                    <div class="form-group mb-2 mr-2">
                                        <el-input
                                            @blur="
                                                duplicateSerie(row.code, index)
                                            "
                                            v-model="row.code"
                                        >
                                            <i
                                                slot="prefix"
                                                class="el-icon-edit-outline"
                                            ></i
                                        ></el-input>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-2 mr-2">
                                        <el-input
                                            v-model="row.quantity"
                                            type="number"
                                        ></el-input>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group mb-2 mr-2">
                                        <el-date-picker
                                            v-model="row.date"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            :clearable="false"
                                        ></el-date-picker>
                                    </div>
                                </td>
                                <td class="Lotes-table-actions text-center">
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-sm btn-danger"
                                        @click.prevent="clickCancel(index)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <br />
                            </tr>
                        </tbody>
                    </table>

                    <el-pagination
                        @current-change="handleCurrentChange"
                        :current-page="currentPage"
                        :page-size="20"
                        :total="lotsGroup.length"
                        layout="total, prev, pager, next"
                    >
                    </el-pagination>
                </div>
            </div>
        </div>

        <div class="form-actions text-end pt-2 pb-2">
            <el-button @click.prevent="clickCancelSubmit()">Cancelar</el-button>
            <el-button type="primary" @click="submit">Guardar</el-button>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: ["showDialog", "stock", "recordId"],
    data() {
        return {
            currentPage: 1,
            lotsGroup: [],
            lotsGroup_splice: [],
            titleDialog: "Lotes",
            loading: false,
            errors: {},
            form: {},
            states: ["Activo", "Inactivo", "Desactivado", "Voz", "M2m"]
        };
    },
    async created() {
        // await this.$http.get(`/pos/payment_tables`)
        //     .then(response => {
        //         this.payment_method_types = response.data.payment_method_types
        //         this.cards_brand = response.data.cards_brand
        //         this.clickAddLot()
        //     })
    },
    methods: {
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
            if (
                !this.recordId &&
                this.lotsGroup.filter(lg => lg.code != null).length == 0
            ) {
                this.lotsGroup = [
                    {
                        id: null,
                        item_id: null,
                        code: null,
                        date: moment().format("YYYY-MM-DD"),
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

            await this.$emit("addRowLot", this.lotsGroup);
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
                date: moment().format("YYYY-MM-DD"),
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
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
