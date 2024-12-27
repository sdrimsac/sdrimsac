<template>
<el-dialog  :title="titleDialog" 
            width="60%" 
            :visible="showDialog" 
            @open="create" 
            :close-on-click-modal="false" 
            :close-on-press-escape="false" append-to-body 
            :show-close="false">

    <div class="row m-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light text-center">
                    <tr>
                        <th v-if="lots.length > 0">Serie</th>
                        <th v-if="lots.length > 0">Estado</th>
                        <th v-if="lots.length > 0">Fecha</th>
                        <th ></th>
                    </tr>
                </thead>
                    <tbody>
                        <tr v-for="(row, index) in lots_splice" :key="index" class="text-center">
                            <td>
                                <div class="form-group mb-2 mr-2">
                                    <el-input @blur="
                                                duplicateSerie(
                                                    row.series,
                                                    index
                                                )
                                            " v-model="row.series">
                                        <i slot="prefix" class="el-icon-edit-outline"></i></el-input>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-2 mr-2">
                                    <el-select v-model="row.state">
                                        <el-option v-for="(option,
                                                index) in states" :key="index" :value="option" :label="option"></el-option>
                                    </el-select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-2 mr-2">
                                    <el-date-picker v-model="row.date" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                                </div>
                            </td>
                            <td class="series-table-actions text-center">
                                <button type="button" class="btn waves-effect waves-light btn-sm btn-danger" @click.prevent="clickCancel(index)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>

                        </tr>
                    </tbody>
            </table>
        </div>
    </div>

   
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
    props: ["showDialog", "lots", "stock", "recordId"],
    data() {
        return {
            currentPage: 1,
            lots_splice: [],
            titleDialog: "Series",
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
            this.lots_splice = this.lots.slice((val - 1) * 20, val * 20);
        },
        async duplicateSerie(data, index) {
            let duplicates = await _.filter(this.lots, {
                series: data
            });
            if (duplicates.length > 1) {
                this.lots[index].series = null;
            }
        },
        create() {

            if (!this.recordId) {
                if (this.lots.length == 0) {
                    this.addMoreLots(this.stock);
                } else {
                    let quantity = this.stock - this.lots.length;
                    if (quantity > 0) {
                        this.addMoreLots(quantity);
                    }
                    // else{
                    //     this.deleteMoreLots(quantity)
                    // }
                }
                this.lots_splice = this.lots.slice(0, 20);
            }
        },
        addMoreLots(number) {
            for (let i = 0; i < number; i++) {
                this.clickAddLot();
            }
        },
        deleteMoreLots(number) {
            for (let i = 0; i < number; i++) {
                this.lots.pop();
                this.$emit("addRowLot", this.lots);
            }
        },
        async validateLots() {
            let error = 0;

            await this.lots.forEach(element => {
                if (element.series == null) {
                    error++;
                }
            });

            if (error > 0)
                return {
                    success: false,
                    message: "El campo serie es obligatorio"
                };

            return {
                success: true
            };
        },
        async submit() {
            let val_lots = await this.validateLots();
            if (!val_lots.success) return this.$toast.error(val_lots.message);

            await this.$emit("addRowLot", this.lots);
            await this.$emit("update:showDialog", false);
        },
        clickAddLot() {
            if (!this.recordId) {
                if (this.lots.length >= this.stock)
                return this.$showSAlert("Advertencia", "La cantidad de registros es superior al stock", "error");
            }

            this.lots.push({
                id: null,
                item_id: null,
                series: null,
                date: moment().format("YYYY-MM-DD"),
                state: "Activo"
            });

            this.$emit("addRowLot", this.lots);
        },

        close() {
            this.$emit("update:showDialog", false);
            this.$emit("addRowLot", this.lots);
            this.lots_splice = [];
        },
        clickCancel(index) {
            this.lots.splice(index, 1);
            // item.deleted = true
            this.$emit("addRowLot", this.lots);
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
