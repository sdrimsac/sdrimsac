<template>
    <el-dialog
        :visible="showDialog"
        width="60%"
        :title="dialogTitle"
        @open="open"
        @close="close"
        append-to-body
        :close-on-click-modal="false"
    >
        <div>
            <div class>
                <br />
                <div class="row">
                    <div class="col-md-4 col-12">
                        <label class="fw-bold">Categoría</label>
                        <el-select
                            v-model="unit.selectedCategoria"
                            @change="filterRelatedData"
                        >
                            <el-option
                                v-for="(madera,
                                index) in categoria_madera_select"
                                :key="index"
                                filterable
                                :label="madera.description"
                                :value="madera.id"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div>
                            <label class="fw-bold">P. Unit.</label>
                            <br />
                            <el-input
                                v-model="unit.unitPrice"
                                type="tel"
                                :min="1"
                                :max="999"
                                autocomplete="off"
                                autocorrect="off"
                                autocapitalize="off"
                                spellcheck="false"
                            ></el-input>
                        </div>
                        <!-- <input placeholder="" type="text"> -->
                    </div>
                    <div class="col-md-2 col-12">
                        <label class="fw-bold">PIE (S)</label>
                        <br />
                        <span>{{ totalPie.toFixed(2) }}</span>
                    </div>
                    <div class="col-md-2 col-12">
                        <label class="fw-bold">S/.</label>
                        <br />
                        <span>{{ totalPrice.toFixed(2) }}</span>
                    </div>

                    <div class="col-md-3 col-12">
                        <label class="w-100">Cantidad</label>
                        <el-input-number
                            class="w-100"
                            v-model="unit.quantity"
                            :min="1"
                            :precision="0"
                        >
                        </el-input-number>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="fw-bold">Grosor</label>
                        <el-select
                            v-model="unit.selectedGrosor"
                            clearable
                            filterable
                            :disabled="!unit.selectedCategoria"
                        >
                            <el-option
                                v-for="(grosor, index) in medida_grosor_select"
                                :key="index"
                                :label="grosor.grosor"
                                :value="grosor.grosor"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="fw-bold">Ancho</label>
                        <el-select
                            v-model="unit.selectedAncho"
                            clearable
                            filterable
                            :disabled="!unit.selectedCategoria"
                        >
                            <el-option
                                v-for="(ancho, index) in medida_ancho_select"
                                :key="index"
                                :label="ancho.ancho"
                                :value="ancho.ancho"
                            ></el-option>
                        </el-select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label class="fw-bold">Largo</label>
                        <el-select
                            filterable
                            clearable
                            v-model="unit.selectedLargo"
                            :disabled="!unit.selectedCategoria"
                        >
                            <el-option
                                v-for="(alto, index) in medida_alto_select"
                                :key="index"
                                :label="alto.alto"
                                :value="alto.alto"
                            ></el-option>
                        </el-select>
                    </div>
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
import Swal from "sweetalert2";
export default {
    props: [
        "showDialog",
        "item",
        "medida_alto",
        "medida_ancho",
        "medida_grosor",
        "categoria_madera",
        "currentIndex"
    ],
    data() {
        return {
            index: null,
            search: "",
            medida_alto_select: [],
            medida_ancho_select: [],
            medida_grosor_select: [],
            unit_type_selected: null,
            unit_types: [],
            has_unit_types: [],
            filteredUnits: [],
            categoria_madera_select: [],
            categoria_madera_item: [],
            unit: {
                selectedCategoria: null,
                selectedLargo: null,
                selectedAncho: null,
                selectedGrosor: null,
                selected: null,
                unitPrice: 0,
                fot: 0,
                price: 0,
                total_price:0,
                key: null,
                quantity: 1
            }
        };
    },
    created() {},
    computed: {
        dialogTitle() {
            return this.item && this.item.description
                ? ` Madera: ${this.item.description}`
                : " Madera";
        },
        price() {
            if (
                this.unit.selectedGrosor &&
                this.unit.selectedAncho &&
                this.unit.selectedLargo &&
                this.unit.selectedCategoria
            ) {
                let grosor = Number(this.unit.selectedGrosor);
                let ancho = Number(this.unit.selectedAncho);
                let largo = Number(this.unit.selectedLargo);
                // let { categoria_madera_item } = this.item;
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
            if (this.totalPie > 0 && this.unit.unitPrice > 0) {
                let priceTotal = this.totalPie * this.unit.unitPrice;
                this.unit.price = priceTotal.toFixed(2);
                return priceTotal;
            }
            return 0;
        }
    },
    methods: {
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
            let unit = this.unit;
            let categoria = this.categoria_madera_item.find(
                c => c.categoria_madera_id == unit.selectedCategoria
            );
            if (categoria) {
                this.unit.unitPrice = categoria.precio;
            }
            if (unit.selectedCategoria) {
                this.medida_alto_select = this.medida_alto.filter(
                    alto => alto.categoria_madera_id === unit.selectedCategoria
                );
                if (this.medida_alto_select.length > 0) {
                    this.unit.selectedLargo = this.medida_alto_select[0].alto;
                }
                this.medida_ancho_select = this.medida_ancho.filter(
                    ancho =>
                        ancho.categoria_madera_id === unit.selectedCategoria
                );
                if (this.medida_ancho_select.length > 0) {
                    this.unit.selectedAncho = this.medida_ancho_select[0].ancho;
                }
                this.medida_grosor_select = this.medida_grosor.filter(
                    grosor =>
                        grosor.categoria_madera_id === unit.selectedCategoria
                );

                if (this.medida_grosor_select.length > 0) {
                    this.unit.selectedGrosor = this.medida_grosor_select[0].grosor;
                }
            }
        },

        selectUnit() {
            console.log(
                "Antes de agregar: Cantidad actual:",
                this.unit.quantity
            );
            let toAdd = { ...this.unit };
            toAdd.selectedAncho = Number(toAdd.selectedAncho);
            toAdd.selectedGrosor = Number(toAdd.selectedGrosor);
            toAdd.selectedLargo = Number(toAdd.selectedLargo);
            toAdd.quantity = this.unit.quantity;
            toAdd.fot = this.totalPie; // Asignar el total de PIE
            toAdd.price = this.totalPrice/this.unit.quantity;
            console.log("Datos a enviar (con cantidad):", toAdd);
            this.$emit("addCategoriaMadera", toAdd, this.index);
            this.resetForm();
            console.log(
                "Después de agregar: Cantidad actual:",
                this.unit.quantity
            );
        },
        resetForm() {
            this.open();
        },
        open() {
              this.unit = {
                selectedCategoria: null,
                selectedLargo: null,
                selectedAncho: null,
                selectedGrosor: null,
                selected: null,
                unitPrice: 0,
                fot: 0,
                price: 0,
                total_price:0,
                key: null,
                quantity: 1
            };
            if (this.item) {
                this.index = this.currentIndex;
                let { categoria_madera_item } = this.item;
                this.categoria_madera_item = categoria_madera_item;
            }
            this.categoria_madera_select = this.categoria_madera.filter(cm => {
                return this.categoria_madera_item.some(
                    cmm => cmm.categoria_madera_id == cm.id
                );
            });

            if (this.categoria_madera_select.length > 0) {
                this.unit.selectedCategoria = this.categoria_madera_select[0].id;
                this.filterRelatedData();
            }
            this.unit.quantity = 1;
        },
        close() {
            this.$emit("update:showDialog", false);
        }
    }
};
</script>
