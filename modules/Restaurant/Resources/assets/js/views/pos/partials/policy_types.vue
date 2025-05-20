<template>
    <el-dialog
        :visible="showDialog"
        width="60%"
        :title="`PRODUCTO ${localItem.description}`"
        @open="open"
        @close="close"
        append-to-body
        :close-on-click-modal="false"
    >
        <div>
            <div>
                <br />
                <div class="row">
                    <div class="col-md-9 col-12">
                        <label class="fw-bold">Lista de Politicas</label>
                    </div>
                </div>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Unidad Medida</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Precio1</th>
                                <th>Precio2</th>
                                <th>Precio3</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td>234234</td>
                              <td>234534</td>
                              <td>534534</td>
                              <td>5345</td>
                              <td>53534</td>
                              <td>5345</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-actions text-end pt-2 pb-2">
            <el-button
                @click="close"
                class="bg-white text-light"
                :disabled="price == 0"
            >
                <i class="fas fa-times fa-lg"></i>
                Cancelar
            </el-button>
            <el-button
                @click="selectUnit"
                class="bg-primary text-white"
                :disabled="price == 0"
            >
                <!-- <i class="fas fa-ti fa-lg"></i> -->
                Agregar
            </el-button>
        </div>
    </el-dialog>
</template>
<style scoped>
.swal2-popup-z-index {
    z-index: 9999 !important;
}
</style>

<script>
export default {
    props: [
        "foods",
        "showDialog",
        "item_unit_types",
        "item",
        "currentIndex"
    ],
    data() {
        return {
            localItem: {},
            modal_item: [],
            categoria_foods: [],
            index: null,
            search: "",
            table_madera: [],
            unit_type_selected: null,
            unit_types: [],
            has_unit_types: [],
            filteredUnits: [],
            categoria_madera_select: [],
            modal_item_id: null,
            categoria_madera_item: [],
            EditTotalPrice: false,
            //total_price: 0,
            unit: {
                unitPrice: 0,
                fot: 0,
                price: 0,
                total_price: 0,
                total_price_unit: 0,
                key: null,
                quantity: 1
            }
        };
    },
    created() {},
    computed: {
        price() {
            if (this.unit_types
  
            ) {
                let grosor = Number(this.unit.selectedGrosor);
                let ancho = Number(this.unit.selectedAncho);
                let largo = Number(this.unit.selectedLargo);
                let result = (grosor * ancho * largo) / 12;
                this.unit.fot = result;
                let price = Number(this.unit.unitPrice);
                result = result * price;
                result = Number(result.toFixed(1));
                this.unit.price = Number(result);
                this.unit.key = `${grosor}.${ancho}.${largo}.${this.unit.selectedCategoria}.${price}`;
                return result;
            }
            return 0;
        },
        totalPie() {
            if (
                this.unit.selectedGrosor &&
                this.unit.selectedAncho &&
                this.unit.selectedLargo &&
                this.unit.selectedCategoria
            ) {
                let grosor = Number(this.unit.selectedGrosor);
                let ancho = Number(this.unit.selectedAncho);
                let largo = Number(this.unit.selectedLargo);
                let piePorUnidad = (grosor * ancho * largo) / 12;
                let pieTotal = piePorUnidad * this.unit.quantity;
                this.unit.fot = pieTotal;

                return pieTotal;
            }
            return 0;
        },
        totalPrice() {
            if (this.unit.price > 0 && this.unit.quantity > 0) {
                return this.unit.price * this.unit.quantity;
            }
            return 0;
            // if (
            //   this.totalPie > 0 &&
            //   this.unit.unitPrice > 0 &&
            //   this.unit.quantity > 0
            // ) {
            //   let priceTotal = this.totalPie * this.unit.unitPrice;
            //   this.unit.price = priceTotal.toFixed(2);
            //   return priceTotal;
            // }
            // return 0;
        },
        unitPricePerMeasure() {
            if (this.totalPrice > 0 && this.unit.quantity > 0) {
                let unitPrice = this.totalPrice / this.unit.quantity;

                this.unit.price = unitPrice.toFixed(2);

                return unitPrice;
            }
            return 0;
        }
    },
    methods: {
        ItemChange(newItemId) {
            this.modal_item_id = newItemId;
            this.resetForm();
        },

        updateTotalPrice() {
            if (this.totalPie > 0 && this.unit.unitPrice > 0) {
                let newTotalPrice = this.totalPie * this.unit.unitPrice;
                this.unit.total_price = newTotalPrice.toFixed(2);
            }
        },
        resetTotalPriceFlag() {
            this.EditTotalPrice = false;
        },
        MaderaItem() {
            this.table_madera = this.foods.filter(
                item =>
                    item.category.name !== "MADERERA" &&
                    item.categoria_madera_item &&
                    item.categoria_madera_item.length > 0
            );
        },
        madereraItems() {
            this.categoria_foods = this.foods.filter(
                item => item.category.name === "MADERERA"
            );
        },
        filter() {
            if (this.search) {
                this.filteredUnits = this.unit_types.filter(unit =>
                    unit.description
                        .toUpperCase()
                        .includes(this.search.toUpperCase())
                );
            } else {
                this.filteredUnits = this.unit_types;
            }
        },
        filterRelatedData() {
            this.resetTotalPriceFlag();
            let unit = this.unit;
            let categoria = this.categoria_madera_item.find(
                c => c.categoria_madera_id == unit.selectedCategoria
            );
            if (categoria) {
                this.unit.unitPrice = categoria.precio;
            }
            let cat_madera = this.categoria_madera.find(
                cm => cm.id == unit.selectedCategoria
            );
            if (cat_madera) {
                this.unit.sumTotals = cat_madera.sum_totals || false;
            }
            if (unit.selectedCategoria) {
                this.medida_alto_select = this.medida_alto.filter(
                    alto => alto.categoria_madera_id === unit.selectedCategoria
                );
                if (this.medida_alto_select.length > 0) {
                    if (cat_madera && cat_madera.largo_default) {
                        this.unit.selectedLargo = cat_madera.largo_default;
                    } else {
                        this.unit.selectedLargo = this.medida_alto_select[0].alto;
                    }
                }
                this.medida_ancho_select = this.medida_ancho.filter(
                    ancho =>
                        ancho.categoria_madera_id === unit.selectedCategoria
                );
                if (this.medida_ancho_select.length > 0) {
                    if (cat_madera && cat_madera.ancho_default) {
                        this.unit.selectedAncho = cat_madera.ancho_default;
                    } else {
                        this.unit.selectedAncho = this.medida_ancho_select[0].ancho;
                    }
                }
                this.medida_grosor_select = this.medida_grosor.filter(
                    grosor =>
                        grosor.categoria_madera_id === unit.selectedCategoria
                );

                if (this.medida_grosor_select.length > 0) {
                    if (cat_madera && cat_madera.grosor_default) {
                        this.unit.selectedGrosor = cat_madera.grosor_default;
                    } else {
                        this.unit.selectedGrosor = this.medida_grosor_select[0].grosor;
                    }
                }
            }
        },

        selectUnit() {
            let toAdd = { ...this.unit };
            toAdd.table_madera = this.unit.table_madera;
            toAdd.selectedAncho = Number(toAdd.selectedAncho);
            toAdd.selectedGrosor = Number(toAdd.selectedGrosor);
            toAdd.selectedLargo = Number(toAdd.selectedLargo);
            toAdd.quantity = this.unit.quantity;
            toAdd.sumTotals = this.unit.sumTotals;
            toAdd.fot = this.totalPie;
            toAdd.price = this.totalPrice / this.unit.quantity;
            //item this.modal_item_id
            //todos los item: this.foods;

            let idx = this.foods.findIndex(f => f.id == this.modal_item_id);
            this.$emit("addCategoriaMadera", toAdd, idx);

            if (this.unit.categoriafoods) {
                let idx_service = this.foods.findIndex(
                    f => f.id == this.unit.categoriafoods
                );
                this.$emit(
                    "addCategoriaMadera",
                    {
                        quantity: this.totalPie,
                        key: `${this.unit.key}_${idx_service}`
                    },
                    idx_service
                );
            }
            this.resetForm();
            //;
        },
        resetForm() {
            // this.open();
            this.unit = {
                selectedCategoria: null,
                selectedLargo: null,
                sumTotals: false,
                selectedAncho: null,
                selectedGrosor: null,
                selected: null,
                unitPrice: 0,
                fot: 0,
                price: 0,
                total_price: 0,
                key: null,
                quantity: 1
            };
            this.changeMadera();
        },
        open() {
            this.modal_item_id = this.item.id;
            this.madereraItems();
            this.MaderaItem();
            this.resetForm();
            /* if (this.item && this.item.id) {
        this.modal_item_id = this.item.id;
        this.syncLocalItem();
      } else {
        console.warn("El objeto `item` es nulo o indefinido:", this.item);
      } */
            /* const selectedItem = this.table_madera.find(
        item => item.id === this.modal_item_id
      ); */

            // if (this.item) {
            //   this.index = this.currentIndex;
            //   let { categoria_madera_item } = this.item;
            //   this.categoria_madera_item = categoria_madera_item;
            // }
        },
        changeMadera() {
            let selectedItem = this.foods.find(f => f.id == this.modal_item_id);
            if (selectedItem) {
                this.localItem = { ...selectedItem };
                this.unit.selectedCategoria =
                    selectedItem.categoria_madera_item?.[0]
                        ?.categoria_madera_id || null;
                this.filterRelatedData();
                let { categoria_madera_item } = selectedItem;
                this.categoria_madera_item = categoria_madera_item;

                this.categoria_madera_select = this.categoria_madera.filter(
                    cm => {
                        return this.categoria_madera_item.some(
                            cmm => cmm.categoria_madera_id == cm.id
                        );
                    }
                );
                if (this.categoria_madera_select.length > 0) {
                    this.unit.selectedCategoria = this.categoria_madera_select[0].id;
                    this.filterRelatedData();
                }
                this.unit.quantity = 1;
            }
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
