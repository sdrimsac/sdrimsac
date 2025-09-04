<template>
    <el-dialog
        :title="titleDialog"
        :visible.sync="showDialog"
        width="50%"
        :close-on-click-modal="false"
        :before-close="handleClose"
    >
        <div>
            <div class="row">
                <div class="col-12" v-for="comp in components" :key="comp.id">
                    <h5>{{ comp.name }}</h5>

                    <!-- SERIES -->
                    <div v-if="comp.series && comp.series.length">
                        <label>Serie:</label>
                        <el-select v-model="comp.selectedSeries" placeholder="Seleccione serie">
                            <el-option
                                v-for="s in comp.series"
                                :key="s.id"
                                :label="s.number"
                                :value="s.id"
                            />
                        </el-select>
                    </div>

                    <!-- TALLA / COLOR -->
                    <div v-if="comp.hasColorSize">
                        <label>Color:</label>
                        <el-select v-model="comp.selectedColor" placeholder="Seleccione color">
                            <el-option
                                v-for="c in comp.colors"
                                :key="c"
                                :label="c"
                                :value="c"
                            />
                        </el-select>

                        <label>Talla:</label>
                        <el-select v-model="comp.selectedSize" placeholder="Seleccione talla">
                            <el-option
                                v-for="t in comp.sizes"
                                :key="t"
                                :label="t"
                                :value="t"
                            />
                        </el-select>
                    </div>

                    <hr>
                </div>
            </div>
        </div>

        <span slot="footer" class="dialog-footer">
            <el-button @click="handleClose">Cancelar</el-button>
            <el-button type="primary" @click="confirmSelection">Confirmar</el-button>
        </span>
    </el-dialog>
</template>

<script>
export default {
    props: {
        showDialog: {
            type: Boolean,
            required: true
        },
        titleDialog: {
            type: String,
            default: "Item Compuesto"
        },
        components: {
            type: Array,
            default: () => []
            /**
             * Estructura ejemplo de components:
             * [
             *   { id: 1, name: 'Celular Samsung', series: [{id:1, number:'ABC123'}], selectedSeries:null },
             *   { id: 2, name: 'Reloj Deportivo', hasColorSize: true, colors: ['Negro','Azul'], sizes:['M','L'], selectedColor:null, selectedSize:null }
             * ]
             */
        }
    },
    methods: {
        handleClose(done) {
            this.$emit("update:showDialog", false);
            if (done) done();
        },
        confirmSelection() {
            // Emitir selección de todos los componentes al padre
            this.$emit("confirm", this.components);
            this.handleClose();
        }
    }
};
</script>

